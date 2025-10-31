<?php
$arrdata= array(
	array("label"=>"Nama", "field"=> "acara", "alias"=> "A.acara", "display"=>"",  "width"=>"80")
	,array("label"=>"Tanggal Tes", "field"=> "start", "alias"=> "A.tanggal_tes", "display"=>"",  "width"=>"80")
	, array("label"=>"Kuota", "field"=> "kuota",  "display"=>"",  "width"=>"10")
	, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
	// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
	, array("label"=>"sorderdefault", "field"=> "jadwal_awal_tes_simulasi_id",  "alias"=> "A.jadwal_tes_id", "display"=>"1", "width"=>"")
	, array("label"=>"fieldid", "field"=> "jadwal_awal_tes_simulasi_id", "alias"=> "A.jadwal_tes_id", "display"=>"1", "width"=>"")
);
?>
@extends('app/index_kosong') 
@section('content')
<form id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-supermarket text-primary"></i>
						</span>
						<h3 class="card-label"> Pegawai Daftar</h3>
					</div>
					<div class="card-toolbar" style="color:black;">
						
					</div>
				</div>
				<div class="card-body">
					<table class="table table-separate table-head-custom table-checkable" id="kt_datatable" style="margin-top: 13px !important;width:100%">
						<thead>
							<tr>
								<?php
								foreach($arrdata as $valkey => $valitem) 
								{
									echo "<th>".$valitem["label"]."</th>";
								}
								?>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">

    var url = "/Pegawai/addDRH/<?=$reqId?>";

    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
    jQuery(document).ready(function() {
        var form = KTUtil.getById('ktloginform');
        var formSubmitUrl = url;
        var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');
        if (!form) {
            return;
        }
        FormValidation
        .formValidation(
            form,
            {
                fields: {
                    // reqNip: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Nip harus diisi'
                    //         }
                    //     }
                    // },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
            )
        .on('core.form.valid', function() {
                // Show loading state on button
                KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
                var formData = new FormData(form);
                
                $.ajax({
                    url: formSubmitUrl,
                    data: formData,
                    contentType: false,
                    processData: false,
                    type: 'POST'
                    // dataType: 'json'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    // , 'Content-Type': 'application/json' 
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        // console.log(data); return false;
                        data= data.message;
                        data= data.split("-");
                        rowid= data[0];
                        infodata= data[1];
                        // console.log(rowid); return false;

                        if(rowid == "xxx")
                        {
                            Swal.fire("Error", infodata, "error");
                        }
                        else
                        {
                            Swal.fire({
                                text: infodata,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                document.location.href = "app/pegawai/daftar/<?=$reqId?>";
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = JSON.parse(xhr.responseText);
                        Swal.fire("Error", err.message, "error");
                    },
                    complete: function () {
                        KTUtil.btnRelease(formSubmitButton);
                    }
                });
            })
        .on('core.form.invalid', function() {
            Swal.fire({
                text: "Check kembali isian pada form",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            }).then(function() {
                KTUtil.scrollTop();
            });
        });
    });

	var datanewtable;
	var infotableid= "kt_datatable";
	var carijenis= "";
	var arrdata= <?php echo json_encode($arrdata); ?>;
	var indexfieldid= arrdata.length - 1;
	var indexvalidasiid= arrdata.length - 3;
	var indexvalidasihapusid= arrdata.length - 4;
	var valinfoid = '';
	var valinfovalidasiid = '';
	var valinfovalidasihapusid = '';

	// var infoscrolly = 50;
	// var datainfoscrollx = 0;

	jQuery(document).ready(function() {
		
		$("#reqUnitKerja,#reqJenis").change(function() {
			var cari = ''; 
			var reqUnitKerja= $("#reqUnitKerja").val();
			var reqJenis= $("#reqJenis").val();
			jsonurl= "/Pegawai/jsonDaftar/<?=$reqId?>";
			datanewtable.DataTable().ajax.url(jsonurl).load();
		});

		var reqUnitKerja= $("#reqUnitKerja").val();

	    var jsonurl= "/Pegawai/jsonDaftar/<?=$reqId?>";
		ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

		 $("#triggercari").on("click", function () {
	        if(carijenis == "1")
	        {
	            pencarian= $('#'+infotableid+'_filter input').val();
	            datanewtable.DataTable().search( pencarian ).draw();
	        }
	    });
	});

	function calltriggercari()
	{
	    $(document).ready( function () {
	      $("#triggercari").click();      
	    });
	}
	function daftar(id) {
		urlAjax= "/Pegawai/addDaftar/<?=$reqId?>/"+id;
		swal.fire({
			title: 'Apakah anda yakin untuk daftar di tanggal ini?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes'
		}).then(function(result) { 
			if (result.value) {
				$.ajax({
					url : urlAjax,
					type : 'POST',
					dataType:'json',
					"headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
					beforeSend: function() {
						swal.fire({
							title: 'Please Wait..!',
							text: 'Is working..',
							onOpen: function() {
								swal.showLoading()
							}
						})
					},
					success : function(data) { 
						data= data.message;
                        data= data.split("-");
                        rowid= data[0];
                        infodata= data[1];
                        // console.log(infodata); return false;

                        if(rowid == "xxx")
                        {
                            Swal.fire("Error", infodata, "error");
                        }
                        else{
							swal.fire({
								position: 'center',
								icon: "success",
								type: 'success',
								title: infodata,
								showConfirmButton: false,
								timer: 2000
							}).then(function() {
								document.location.href = "app/pegawai/daftar/<?=$reqId?>";
							});
						}
					},
					complete: function() {
						swal.hideLoading();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						swal.hideLoading();
						var err = JSON.parse(jqXHR.responseText);
						Swal.fire("Error", err.message, "error");
					}
				});
			}
		});
	}

</script>
@endsection








		
