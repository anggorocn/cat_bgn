<?php
	$arrdata= array(
		array("label"=>"Nama", "field"=> "nama", "alias"=> "A.NAMA", "display"=>"",  "width"=>"80")
		// buat tombol aksi
		, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
		
		// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
		, array("label"=>"sorderdefault", "field"=> "kegiatan_file_id",  "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
		, array("label"=>"fieldid", "field"=> "kegiatan_file_id", "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
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
						<h3 class="card-label"> Master Soal <?=$query->nama?></h3>
					</div>
					<div class="card-toolbar">
						<a href="/app/soal/addessay/<?=$reqId?>" class="btn btn-primary font-weight-bolder"style="margin-right:10px">
							Tambah
						</a>
						<a href="{{url('/app/soal/index_essay')}}" class="btn btn-warning font-weight-bolder" >
							Kembali
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
		    var jsonurl= "/Soal/jsondetilessay/<?=$reqId?>";
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
				urlAjax= "/Soal/deleteessay/"+id;
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
									document.location.href = "app/soal/detil_essay/<?=$query->kode?>";
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

	</script>
@endsection








		
