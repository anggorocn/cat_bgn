<?php
	$arrdata= array(
		array("label"=>"Nip", "field"=> "nip_baru", "alias"=> "A.NIP", "display"=>"",  "width"=>"80")
		, array("label"=>"Nama", "field"=> "NAMA", "alias"=> "A.NAMA", "display"=>"",  "width"=>"80")
		, array("label"=>"Jabatan", "field"=> "last_jabatan", "alias"=> "A.JABATAN", "display"=>"",  "width"=>"10")
		, array("label"=>"Eselon", "field"=> "eselon_nama", "alias"=> "eselon_nama", "display"=>"",  "width"=>"10")
		// , array("label"=>"Direktorat", "field"=> "DEPARTEMEN", "alias"=> "A.DEPARTEMEN", "display"=>"",  "width"=>"10")
		// , array("label"=>"Jenis", "field"=> "JENIS_PEGAWAI", "alias"=> "A.JENIS_PEGAWAI", "display"=>"",  "width"=>"10")
		// , array("label"=>"Email", "field"=> "EMAIL", "alias"=> "A.EMAIL", "display"=>"",  "width"=>"10")

		// buat tombol aksi
		, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
		
		// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
		, array("label"=>"sorderdefault", "field"=> "PEGAWAI_ID",  "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
		, array("label"=>"fieldid", "field"=> "PEGAWAI_ID", "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
	);
?>
@extends('app/index_surat') 
@section('content')
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-supermarket text-primary"></i>
						</span>
						<h3 class="card-label"> Master Peserta</h3>
					</div>
					<div class="card-toolbar">
						<a href="{{url('app/pegawai/add')}}" class="btn btn-primary font-weight-bolder">
							Tambah
						</a>
						&nbsp;
						<a onclick='sinkrondata()' class="btn btn-primary font-weight-bolder">
							Sinkron
						</a>
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
	<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>

	<script type="text/javascript">
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
			
		    var jsonurl= "/Pegawai/json";
			ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

			 $("#triggercari").on("click", function () {
		        if(carijenis == "1")
		        {
		            pencarian= $('#'+infotableid+'_filter input').val();
		            var jsonurl= "/Pegawai/json?reqPencarian="+pencarian;
					datanewtable.DataTable().ajax.url(jsonurl).load();
		        }
		    });
		});

		function calltriggercari()
		{
		    $(document).ready( function () {
		      $("#triggercari").click();     
		    });
		}

		function deletedata(id) {
			if(id == "")
			{
				Swal.fire({
					text: "Pilih salah satu data terlebih dahulu.",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
				});
			}
			else
			{
				urlAjax= "/Pegawai/delete/"+id;
				swal.fire({
					title: 'Apakah anda yakin untuk hapus data?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes'
				}).then(function(result) { 
					if (result.value) {
						$.ajax({
							url : urlAjax,
							type : 'DELETE',
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
								swal.fire({
									position: 'center',
									icon: "success",
									type: 'success',
									title: data.message,
									showConfirmButton: false,
									timer: 2000
								}).then(function() {
									document.location.href = "app/pegawai/index";
								});
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
		}


	function sinkrondata(id) {
			urlAjax= "/Pegawai/sinkron";
			swal.fire({
				title: 'Apakah anda yakin untuk Sinkronisasi data dengan simpeg?',
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
							swal.fire({
								position: 'center',
								icon: "success",
								type: 'success',
								title: data.message,
								showConfirmButton: false,
								timer: 2000
							}).then(function() {
								document.location.href = "app/pegawai/index";
							});
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








		
