<?php
	$arrdata= array(
		array("label"=>"Nama", "field"=> "potensi", "alias"=> "A.NIP", "display"=>"",  "width"=>"80")
		, array("label"=>"Tanggal", "field"=> "potensi", "alias"=> "A.NAMA", "display"=>"",  "width"=>"80")
		// , array("label"=>"Direktorat", "field"=> "DEPARTEMEN", "alias"=> "A.DEPARTEMEN", "display"=>"",  "width"=>"10")
		// , array("label"=>"Jenis", "field"=> "JENIS_PEGAWAI", "alias"=> "A.JENIS_PEGAWAI", "display"=>"",  "width"=>"10")
		// , array("label"=>"Email", "field"=> "EMAIL", "alias"=> "A.EMAIL", "display"=>"",  "width"=>"10")

		// buat tombol aksi
		// , array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
		
		// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
		, array("label"=>"sorderdefault", "field"=> "PEGAWAI_ID",  "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
		, array("label"=>"fieldid", "field"=> "PEGAWAI_ID", "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")

	);

?>
@extends('app/index_talenta') 
@section('content')
<div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Manajemen Talenta</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{url('app/manajemen_talenta/tabelninebox/')}}" class="btn btn-primary font-weight-bolder">
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="containerNew">
                    <div class="left" id="left-content"></div>
                    <div class="contentNew" id="contentNew">
                        <div class="container">
                        	<div class="card card-custom">
								<div class="card-header">
									<div class="card-title">
										<span class="card-icon">
											<i class="flaticon2-supermarket text-primary"></i>
										</span>
										<h3 class="card-label"> Riwayat Penghargaan</h3>
									</div>
				<!-- 					<div class="card-toolbar">
										<a href="{{url('app/pegawai/add')}}" class="btn btn-primary font-weight-bolder">
											Tambah
										</a>
									</div> -->
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
			
			$("#reqUnitKerja,#reqJenis").change(function() {
				var cari = ''; 
				var reqUnitKerja= $("#reqUnitKerja").val();
				var reqJenis= $("#reqJenis").val();
			    var jsonurl= "/ManajemenTalenta/jsontabelninebox?reqUnitKerja="+reqUnitKerja;
				datanewtable.DataTable().ajax.url(jsonurl).load();
			});

			var reqUnitKerja= $("#reqUnitKerja").val();

		    var jsonurl= "/ManajemenTalenta/jsontabelninebox?reqUnitKerja="+reqUnitKerja;
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

        fetch('/app/talenta/edit/<?=$reqId?>/<?=$pg?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));

	</script>
@endsection








		
