<?php
$arrtabledatasuratmasuk= array(
	array("label"=>"No", "field"=> "DT_RowIndex", "display"=>"",  "width"=>"10", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"NO. SURAT", "field"=> "NOMOR", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"DARI", "field"=> "INFO_DARI", "display"=>"",  "width"=>"35", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"PERIHAL", "field"=> "PERIHAL", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"TANGGAL", "field"=> "INFO_TANGGAL_DISPOSISI", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")

    // buat tombol aksi
	, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"1",  "width"=>"10")

    , array("label"=>"fieldmode", "field"=> "MODE_KOTAK_MASUK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "TERBACA", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "SIFAT_NASKAH", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "DISPOSISI_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "SURAT_MASUK_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$arrtabledatadisposisi= array(
	array("label"=>"No", "field"=> "DT_RowIndex", "display"=>"",  "width"=>"10", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"NO. SURAT", "field"=> "NOMOR", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"DARI", "field"=> "INFO_DARI", "display"=>"",  "width"=>"35", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"PERIHAL", "field"=> "PERIHAL", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"TANGGAL", "field"=> "TANGGAL_DISPOSISI", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"DISPOSISI DARI", "field"=> "DETIL_INFO_DARI_DIPOSISI", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"DISPOSISI", "field"=> "DISPOSISI", "display"=>"",  "width"=>"25", "colspan"=>"", "rowspan"=>"")

    // buat tombol aksi
	, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"1",  "width"=>"10")

    , array("label"=>"fieldid", "field"=> "TERBACA", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "SIFAT_NASKAH", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "DISPOSISI_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "SURAT_MASUK_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$arrtableperlupersetujuan= array(
	array("label"=>"No", "field"=> "DT_RowIndex", "display"=>"",  "width"=>"10")

	, array("label"=>"TANGGAL", "field"=> "INFO_STATUS_TANGGAL", "display"=>"",  "width"=>"80")
	, array("label"=>"NO. SURAT", "field"=> "INFO_NOMOR_SURAT", "display"=>"",  "width"=>"80")
	, array("label"=>"PERIHAL", "field"=> "PERIHAL", "display"=>"",  "width"=>"80")
	, array("label"=>"STATUS", "field"=> "INFO_STATUS", "display"=>"",  "width"=>"80")
	, array("label"=>"MENUNGGU PERSETUJUAN", "field"=> "PERSETUJUAN_INFO", "display"=>"",  "width"=>"80")
	, array("label"=>"SISA STEP", "field"=> "JUMLAH_STEP", "display"=>"",  "width"=>"80")

	// buat tombol aksi
	, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"1",  "width"=>"10")
	
	// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
	, array("label"=>"sorderdefault", "field"=> "SURAT_MASUK_ID", "display"=>"1", "width"=>"")
	, array("label"=>"fieldid", "field"=> "SURAT_MASUK_ID", "display"=>"1", "width"=>"")
);
$reqStatusSurat= "PERLU_PERSETUJUAN";

$stf= new StringFunc();
$reqTahun= date("Y");
$user=Session::get('user');
?>

@extends('app/index') 
@section('header') 

<style type="text/css">
	.area-konten-dashboard {
		background-color: #FFFFFF;

		-webkit-border-radius: 15px;
		-moz-border-radius: 15px;
		border-radius: 15px;

		overflow: hidden;
	}
	.area-konten-dashboard .judul {
		font-size: 16px;
		text-transform: uppercase;
		font-weight: bold;
		padding: 5px 15px;
		border-bottom: 1px solid #dadada;
	}
	.area-konten-dashboard .inner {
		padding-bottom: 5px;
	}
	.area-konten-dashboard .inner table td {
		padding: 5px 15px;
	}
	.area-konten-dashboard .inner .dataTables_scroll {
		margin-top: 0px !important;
		margin-bottom: 0px !important;
	}
	.area-konten-dashboard .inner .dataTables_info {
		margin-top: 0px;
		margin-bottom: 0px;
		padding-left: 15px;
	}

	/****/
	.area-unit-kerja-dashboard {
		border: 1px solid rgba(0,0,0,0.2);
		margin-top: 15px;
		padding: 10px 30px 10px 15px;
		width: fit-content;

		-moz-border-radius: 15px;
		-webkit-border-radius: 15px;
		border-radius: 15px;
		
		font-size: 12px;
	}

</style>

<div class="container">
	<!--begin::Dashboard-->
	<!--begin::Row-->
	<div class="row">
		<div class="col-lg-6 col-xxl-3">
			<div class="area-profil">
				<?php
				$vurlfoto= "../../assets/media/users/300_21.jpg";
				if(file_exists(public_path()."/uploads/foto_pegawai/".$user->pegawai->pegawai_id.".png"))
				{
					$vurlfoto= "uploads/foto_pegawai/".$user->pegawai->pegawai_id.".png";
				}
				?>
				<div class="foto"><img src="<?=$vurlfoto?>"></div>
				<div class="data">
					<div class="nama">{{$user->nama}}</div>
					<div class="nik">(NIP : {{$user->pegawai->nip}}) </div>
					<div class="jabatan">{{$user->JABATAN}}</div>	
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="area-last-login">
				<div class="title">Last Login : </div>
				9 November 2022 - 09:22

			</div>
			<div class="area-jam">
				<script>function display_ct7() {
				var x = new Date()
				var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
				hours = x.getHours( ) % 12;
				hours = hours ? hours : 12;
				hours=hours.toString().length==1? 0+hours.toString() : hours;

				var minutes=x.getMinutes().toString()
				minutes=minutes.length==1 ? 0+minutes : minutes;

				var seconds=x.getSeconds().toString()
				seconds=seconds.length==1 ? 0+seconds : seconds;

				var month=(x.getMonth() +1).toString();
				month=month.length==1 ? 0+month : month;

				var dt=x.getDate().toString();
				dt=dt.length==1 ? 0+dt : dt;

				const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
				  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
				];

				const d = new Date();

				var x1=dt + " " + monthNames[d.getMonth()] + " " + x.getFullYear(); 
				// x1 = "<div class='jam'>" + hours + ":" +  minutes + ":" +  seconds + " " + ampm + "</div><div class='hari'>" + x1 + "</div>";
				x1 = "<div class='jam'>" + hours + ":" +  minutes + " " + ampm + "</div><div class='hari'>" + x1 + "</div>";
				document.getElementById('ct7').innerHTML = x1;
				display_c7();
				 }
				 function display_c7(){
				var refresh=1000; // Refresh rate in milli seconds
				mytime=setTimeout('display_ct7()',refresh)
				}
				display_c7()
				</script>
				<span id='ct7'></span>

			</div>
			<div class="area-unit-kerja-dashboard">
				<label>Unit Kerja : </label>
				<select>
					<option>Kantor Pusat</option>
					<option>Banda Aceh</option>
					<option>Singkil</option>
					<option>Sibolga</option>
					<option>Padang</option>
					<option>Batam</option>
					<option>Bangka</option>
					<option>Bakauheni</option>
					<option>Merak</option>
					<option>Surabaya</option>
					<option>Ketapang</option>
					<option>Pontianak</option>
					<option>Batulicin</option>
					<option>Balikpapan</option>
					<option>Selayar</option>
					<option>Bau-bau</option>
					<option>Bajoe</option>
					<option>Luwuk</option>
					<option>Bitung</option>
					<option>Lembar</option>
					<option>Kayangan</option>
					<option>Sape</option>
					<option>Kupang</option>
					<option>Ambon</option>
					<option>Ternate</option>
					<option>Biak</option>
					<option>Sorong</option>
					<option>Merauke</option>
				</select>
			</div>
			<!-- <div class="area-info-pengguna">
				<div class="inner">
					<div class="item pengguna">
						<div class="ikon"><span><img src="../../assets/media/images/icon-pengguna.png"></span></div>
						<div class="data">
							<div class="nilai">4824</div>
							<div class="keterangan">Pengguna</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="item online">
						<div class="ikon"><span><img src="../../assets/media/images/icon-online.png"></span></div>
						<div class="data">
							<div class="nilai">1</div>
							<div class="keterangan">Online</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>

			</div> -->
		</div>
		<div class="col-lg-6 col-xxl-6">
			Selamat datang {{$user->nama}},
			<div class="nama-aplikasi">di <strong>Aplikasi E-Office</strong></div>
			<div class="area-main-menu">
				<div class="inner">
					<!-- <div class="item" onclick="location.href='app/nota_dinas/add';" >
						<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
						<div class="ikon"><img src="../../assets/media/images/icon-buat-surat.png"></div>
						<div class="nama">Buat Surat</div>
						<div class="clearfix"></div>
					</div> -->
					<div class="item" onclick="location.href='app/kotak_masuk/index';">
						<div class="gambar"><img src="../../assets/media/images/img-kotak-masuk.jpg"></div>
						<div class="ikon"><img src="../../assets/media/images/icon-kotak-masuk.png"></div>
						<div class="nama">Kotak Masuk</div>
						<div class="clearfix"></div>
					</div>
					<div class="item" onclick="location.href='app/kotak_keluar/index';">
						<div class="gambar"><img src="../../assets/media/images/img-kotak-keluar.jpg"></div>
						<div class="ikon"><img src="../../assets/media/images/icon-kotak-keluar.png"></div>
						<div class="nama">Kotak Keluar</div>
						<div class="clearfix"></div>
					</div>
					<!-- <div class="item" onclick="location.href='app/perlu_persetujuan/index';">
						<div class="gambar"><img src="../../assets/media/images/img-kotak-proses.jpg"></div>
						<div class="ikon"><img src="../../assets/media/images/icon-kotak-proses.png"></div>
						<div class="nama">Kotak Proses</div>
						<div class="clearfix"></div>
					</div> -->
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="area-data-angka" style="margin-bottom: 15px;">
				<div class="area-konten-dashboard">
					<div class="judul">Total Surat</div>
					<div class="inner">
						<table id="example" class="display" style="width:100%">
					        <thead>
					            <tr>
					                <th>Nama Kantor / Cabang</th>
					                <th>Jumlah Surat</th>
					            </tr>
					        </thead>
					        <tbody>
					            <tr>
					                <td>Kantor Pusat</td>
					                <td>1000</td>
					            </tr>
					            <tr>
					                <td>Banda Aceh</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Singkil</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Sibolga</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Padang</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Batam</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Bangka</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Bakauheni</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Merak</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Surabaya</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Ketapang</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Pontianak</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Batulicin</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Balikpapan</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Selayar</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Bau-bau</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Bajoe</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Luwuk</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Bitung</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Lembar</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Kayangan</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Sape</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Kupang</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Ambon</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Ternate</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Biak</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Sorong</td>
					                <td>100</td>
					            </tr>
					            <tr>
					            	<td>Merauke</td>
					                <td>100</td>
					            </tr>
					        </tbody>
					    </table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-xxl-3">
			<div class="area-kalendar">
				<div id="container" class="calendar-container"></div>
			</div>
			<!-- <div class="area-jam">
				<script>function display_ct7() {
				var x = new Date()
				var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
				hours = x.getHours( ) % 12;
				hours = hours ? hours : 12;
				hours=hours.toString().length==1? 0+hours.toString() : hours;

				var minutes=x.getMinutes().toString()
				minutes=minutes.length==1 ? 0+minutes : minutes;

				var seconds=x.getSeconds().toString()
				seconds=seconds.length==1 ? 0+seconds : seconds;

				var month=(x.getMonth() +1).toString();
				month=month.length==1 ? 0+month : month;

				var dt=x.getDate().toString();
				dt=dt.length==1 ? 0+dt : dt;

				const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
				  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
				];

				const d = new Date();

				var x1=dt + " " + monthNames[d.getMonth()] + " " + x.getFullYear(); 
				// x1 = "<div class='jam'>" + hours + ":" +  minutes + ":" +  seconds + " " + ampm + "</div><div class='hari'>" + x1 + "</div>";
				x1 = "<div class='jam'>" + hours + ":" +  minutes + " " + ampm + "</div><div class='hari'>" + x1 + "</div>";
				document.getElementById('ct7').innerHTML = x1;
				display_c7();
				 }
				 function display_c7(){
				var refresh=1000; // Refresh rate in milli seconds
				mytime=setTimeout('display_ct7()',refresh)
				}
				display_c7()
				</script>
				<span id='ct7'></span>

			</div> -->
			<!-- <div class="area-info-pengguna">
				<div class="inner">
					<div class="item pengguna">
						<div class="ikon"><span><img src="../../assets/media/images/icon-pengguna.png"></span></div>
						<div class="data">
							<div class="nilai">4824</div>
							<div class="keterangan">Pengguna</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="item online">
						<div class="ikon"><span><img src="../../assets/media/images/icon-online.png"></span></div>
						<div class="data">
							<div class="nilai">1</div>
							<div class="keterangan">Online</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>

			</div> -->
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="area-konten-dashboard">
				<div class="judul">Total User</div>
				<div class="inner">
					<table id="example2" class="display" style="width:100%">
				        <thead>
				            <tr>
				                <th>Nama Kantor / Cabang</th>
				                <th>Jumlah User</th>
				            </tr>
				        </thead>
				        <tbody>
				            <tr>
				                <td>Kantor Pusat</td>
				                <td>1024</td>
				            </tr>
				            <tr>
				                <td>Banda Aceh</td>
				                <td>120</td>
				            </tr>
				            <tr>
				            	<td>Singkil</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Sibolga</td>
				                <td>88</td>
				            </tr>
				            <tr>
				            	<td>Padang</td>
				                <td>75</td>
				            </tr>
				            <tr>
				            	<td>Batam</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Bangka</td>
				                <td>37</td>
				            </tr>
				            <tr>
				            	<td>Bakauheni</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Merak</td>
				                <td>34</td>
				            </tr>
				            <tr>
				            	<td>Surabaya</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Ketapang</td>
				                <td>99</td>
				            </tr>
				            <tr>
				            	<td>Pontianak</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Batulicin</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Balikpapan</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Selayar</td>
				                <td>87</td>
				            </tr>
				            <tr>
				            	<td>Bau-bau</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Bajoe</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Luwuk</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Bitung</td>
				                <td>45</td>
				            </tr>
				            <tr>
				            	<td>Lembar</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Kayangan</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Sape</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Kupang</td>
				                <td>66</td>
				            </tr>
				            <tr>
				            	<td>Ambon</td>
				                <td>96</td>
				            </tr>
				            <tr>
				            	<td>Ternate</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Biak</td>
				                <td>76</td>
				            </tr>
				            <tr>
				            	<td>Sorong</td>
				                <td>100</td>
				            </tr>
				            <tr>
				            	<td>Merauke</td>
				                <td>35</td>
				            </tr>
				        </tbody>
				    </table>	
				</div>
			</div>
			
		</div>
		<div class="col-md-6">
			<div class="area-konten-dashboard">
				<div class="judul">Statistik Jenis Surat</div>
				<div class="inner">
					<div id="container-jenis-surat" style="height: calc(20vh + 63px);"></div>
				</div>
			</div>
		</div>
	</div>

	<?php
	if(in_array("ADMIN", explode(",", $user->USER_GROUP)) == FALSE)
	{
	?>
		<div class="row">
			<div class="col-lg-12 col-xxl-12">
				<div class="area-tab">
					<ul class="nav nav-tabs nav-tabs-line">
					    <li class="nav-item">
					        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
					        	Surat Masuk 
					        	<span class="keterangan">belum terbaca</span> 
					        	<span class="jumlah" onclick="location.href='app/kotak_masuk/index';">{{$jmlsuratmasuk}}</span>
					        </a>
					    </li>
					    <li class="nav-item">
					        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">
					        	Disposisi 
					        	<span class="keterangan">belum terbaca</span>
					        	<span class="jumlah" onclick="location.href='app/kotak_masuk_disposisi/index';">{{$jmlsuratdisposisi}}</span>
					        </a>
					    </li>
					    <li class="nav-item">
					        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">
					        	Perlu Persetujuan
					        	<span class="keterangan"></span>
					        	<span class="jumlah" onclick="location.href='app/perlu_persetujuan/index';">{{$jmlpersetujuan}}</span>
					        </a>

					    </li>
					</ul>
					<div class="tab-content mt-5" id="myTabContent">
					    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2">
					    	<div class="area-tabel-surat">
					    		<table class="table table-bordered table-hover table-checkable" id="kt_datatable_sm" style="margin-top: 13px !important">
					    			<thead>
					    				<tr>
					    					<?php
					    					foreach($arrtabledatasuratmasuk as $valkey => $valitem) 
					    					{
					    						$infotablelabel= $stf->arrparam("label", $valitem);
					    						$infotablecolspan= $stf->arrparam("colspan", $valitem);
					    						$infotablerowspan= $stf->arrparam("rowspan", $valitem);

					    						$infowidth= "";
					    						if(!empty($infotablecolspan))
					    						{
					    						}

					    						if(!empty($infotablelabel))
					    						{
					    							?>
					    							<th style="text-align:center; width: <?=$infowidth?>%" colspan='<?=$infotablecolspan?>' rowspan='<?=$infotablerowspan?>'><?=$infotablelabel?></th>
					    							<?php
					    						}
					    					}
					    					?>
					    				</tr>
					    			</thead>
					    		</table>
					    	</div>
					    </div>
					    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
					    	<div class="area-tabel-surat">
					    		<table class="table table-bordered table-hover table-checkable" id="kt_datatable_disposisi" style="margin-top: 13px !important">
					    			<thead>
					    				<tr>
					    					<?php
						                    foreach($arrtabledatadisposisi as $valkey => $valitem) 
						                    {
						                    	$infotablelabel= $stf->arrparam("label", $valitem);
						                    	$infotablecolspan= $stf->arrparam("colspan", $valitem);
						                    	$infotablerowspan= $stf->arrparam("rowspan", $valitem);

						                    	$infowidth= "";
						                    	if(!empty($infotablecolspan))
						                    	{
						                    	}

						                    	if(!empty($infotablelabel))
						                    	{
						                    ?>
						                        <th style="text-align:center; width: <?=$infowidth?>%" colspan='<?=$infotablecolspan?>' rowspan='<?=$infotablerowspan?>'><?=$infotablelabel?></th>
						                    <?php
						                    	}
						                    }
						                    ?>
					    				</tr>
					    			</thead>
					    		</table>
					    	</div>
					    </div>
					    <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
					    	<div class="area-tabel-surat">
					    		<table class="table table-bordered table-hover table-checkable" id="kt_datatable_persetujuan" style="width: 100% !important; margin-top: 13px !important">
					    			<thead>
					    				<tr>
					    					<?php
					    					foreach($arrtableperlupersetujuan as $valkey => $valitem) 
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
	<?php
	}
	?>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="triggercari1" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="triggercari2" style="display:none" title="triggercari">triggercari</a>

<script type="text/javascript">
	// untuk kotak masuk
	var datanewtable;
	var infotableid= "kt_datatable_sm";
	var carijenis= "";
	var arrdatasm= <?php echo json_encode($arrtabledatasuratmasuk); ?>;
	var indexfieldidsm= arrdatasm.length - 1;
	var valinfoid = '';
	infobold= arrdatasm.length - 4;
	infocolor= arrdatasm.length - 3;
	datachangeorder= "";

	var jsonurlsm= "/SuratMasuk/jsonsuratmasuk?reqMode=home&reqLimit=10&reqTahun=<?=$reqTahun?>";

	jQuery(document).ready(function() {
		ajaxserverselectsingle.init(infotableid, jsonurlsm, arrdatasm);

		$('#'+infotableid+' tbody').on( 'click', 'tr', function () {
	        var dataselected= datanewtable.DataTable().row(this).data();
	        // console.log(dataselected);return false;

	        valinfoid= dataselected[arrdatasm[indexfieldidsm]["field"].toLowerCase()];
	        valmodesurat= dataselected[arrdatasm[infobold-1]["field"].toLowerCase()];
	        if (valinfoid == null)
	        {
	            valinfoid = '';
	        }

	        if(valinfoid)
	        {
	        	window.location = "app/surat_detil/view/"+valmodesurat+"/"+valinfoid;
	        }
	    });
	});

	// untuk disposisi
	var datanewtable1;
	var infotableid1= "kt_datatable_disposisi";
	var carijenis1= "";
	var arrdatadisposisi= <?php echo json_encode($arrtabledatadisposisi); ?>;
	var indexfieldiddisposisi= arrdatadisposisi.length - 1;
	var valinfoid = '';
	infobold1= arrdatadisposisi.length - 4;
	infocolor1= arrdatadisposisi.length - 3;
	datachangeorder1= "";

	jQuery(document).ready(function() {
		var jsonurl= "/SuratMasuk/jsonsuratdisposisi?reqMode=home&reqJenisNaskahId=&reqLimit=10";
		ajaxserverselectsingle1.init(infotableid1, jsonurl, arrdatadisposisi);

		$('#'+infotableid1+' tbody').on( 'click', 'tr', function () {
	        var dataselected= datanewtable1.DataTable().row(this).data();
	        // console.log(dataselected);

	        fieldinfoid= arrdatadisposisi[indexfieldiddisposisi]["field"].toLowerCase();
	        valinfoid= dataselected[fieldinfoid];
	        if (valinfoid == null)
	        {
	            valinfoid = '';
	        }

	        if(valinfoid)
	        {
	        	window.location = "app/surat_detil/viewdisposisi/kotak_masuk_disposisi/"+valinfoid;
	        }
	    });
	});

	// untuk perlu persetujuan
	var datanewtable2;
	var infotableid2= "kt_datatable_persetujuan";
	var carijenis2= "";
	var arrdatapersetujuan= <?php echo json_encode($arrtableperlupersetujuan); ?>;
	var indexfieldidpersetujuan= arrdatapersetujuan.length - 1;
	datachangeorder2= "";

	jQuery(document).ready(function() {
		var jsonurl= "/SuratMasuk/jsonpersetujuan?reqStatusSurat=PERLU_PERSETUJUAN&reqLimit=10";
		ajaxserverselectsingle2.init(infotableid2, jsonurl, arrdatapersetujuan);

		$('#'+infotableid2+' tbody').on( 'click', 'tr', function () {
	        var dataselected= datanewtable2.DataTable().row(this).data();
	        // console.log(dataselected);

	        fieldinfoid= arrdatapersetujuan[indexfieldidpersetujuan]["field"].toLowerCase();
	        valinfoid= dataselected[fieldinfoid];
	        if (valinfoid == null)
	        {
	            valinfoid = '';
	        }

	        if(valinfoid)
	        {
	        	window.location = "app/perlu_persetujuan/viewdetil/"+valinfoid;
	        }
	    });
	});

	jQuery(document).ready(function() {
		$("#triggercari").on("click", function () {
			if(carijenis == "1")
			{
				pencarian= $('#'+infotableid+'_filter input').val();
				datanewtable.DataTable().search( pencarian ).draw();
			}
			else
			{

			}
		});

		$("#triggercari1").on("click", function () {
			if(carijenis1 == "1")
			{
				pencarian= $('#'+infotableid1+'_filter input').val();
				datanewtable1.DataTable().search( pencarian ).draw();
			}
			else
			{

			}
		});

		$("#triggercari2").on("click", function () {
			if(carijenis2 == "1")
			{
				pencarian= $('#'+infotableid2+'_filter input').val();
				datanewtable2.DataTable().search( pencarian ).draw();
			}
			else
			{

			}
		});
	});

	function calltriggercari()
	{
		$(document).ready( function () {
			$("#triggercari").click();      
		});
	}

	function calltriggercari1()
	{
		$(document).ready( function () {
			$("#triggercari1").click();      
		});
	}

	function calltriggercari2()
	{
		$(document).ready( function () {
			$("#triggercari2").click();      
		});
	}

	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		if (e.target.hash == '#kt_tab_pane_2') {
            datanewtable1.DataTable().columns.adjust().draw();
        }

        if (e.target.hash == '#kt_tab_pane_3') {
            datanewtable2.DataTable().columns.adjust().draw();
        }
    })


</script>

<!-- EVENT CALENDAR -->
<link rel="stylesheet" href="assets/animated-event-calendar/dist/simple-calendar.css">
<script src="assets/animated-event-calendar/dist/jquery.simple-calendar.js"></script>
<script>
  var $calendar;
  $(document).ready(function () {
    let container = $("#container").simpleCalendar({
      fixedStartDay: 0, // begin weeks by sunday
      disableEmptyDetails: true,
      events: [
        // generate new event after tomorrow for one hour
        {
          startDate: new Date(new Date().setHours(new Date().getHours() + 24)).toDateString(),
          endDate: new Date(new Date().setHours(new Date().getHours() + 25)).toISOString(),
          summary: 'Visit of the Eiffel Tower'
        },
        // generate new event for yesterday at noon
        {
          startDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 12, 0)).toISOString(),
          endDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 11)).getTime(),
          summary: 'Restaurant'
        },
        // generate new event for the last two days
        {
          startDate: new Date(new Date().setHours(new Date().getHours() - 48)).toISOString(),
          endDate: new Date(new Date().setHours(new Date().getHours() - 24)).getTime(),
          summary: 'Visit of the Louvre'
        }
      ],

    });
    $calendar = container.data('plugin_simpleCalendar')
  });
</script>
<!-- END EVENT CALENDAR -->

<style type="text/css">
@media (min-width: 992px) {
	.header-fixed.subheader-fixed.subheader-enabled .wrapper {
	  padding-top: 65px;
	}
}
</style>

<!-- HIGHCHARTS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!-- <script type="text/javascript">
	Highcharts.chart('container-total-surat', {
	  chart: {
	    type: 'column'
	  },
	  title: {
	    text: null,
	    align: 'left'
	  },
	  subtitle: {
	    text: null,
	    align: 'left'
	  },
	  xAxis: {
	    categories: ['USA', 'China', 'Brazil', 'EU', 'India', 'Russia'],
	    crosshair: true,
	    accessibility: {
	      description: 'Countries'
	    }
	  },
	  yAxis: {
	    min: 0,
	    title: {
	      text: null
	    }
	  },
	  tooltip: {
	    valueSuffix: ' (1000 MT)'
	  },
	  plotOptions: {
	    column: {
	      pointPadding: 0.2,
	      borderWidth: 0
	    }
	  },
	  series: [
	    {
	      name: 'Corn',
	      data: [406292, 260000, 107000, 68300, 27500, 14500]
	    },
	    {
	      name: 'Wheat',
	      data: [51086, 136000, 5500, 141000, 107180, 77000]
	    }
	  ]
	});
</script>

<script type="text/javascript">
	Highcharts.chart('container-total-user', {
	  chart: {
	    type: 'column'
	  },
	  title: {
	    text: null,
	    align: 'left'
	  },
	  subtitle: {
	    text: null,
	    align: 'left'
	  },
	  xAxis: {
	    categories: ['USA', 'China', 'Brazil', 'EU', 'India', 'Russia'],
	    crosshair: true,
	    accessibility: {
	      description: 'Countries'
	    }
	  },
	  yAxis: {
	    min: 0,
	    title: {
	      text: null
	    }
	  },
	  tooltip: {
	    valueSuffix: ' (1000 MT)'
	  },
	  plotOptions: {
	    column: {
	      pointPadding: 0.2,
	      borderWidth: 0
	    }
	  },
	  series: [
	    {
	      name: 'Corn',
	      data: [406292, 260000, 107000, 68300, 27500, 14500]
	    },
	    {
	      name: 'Wheat',
	      data: [51086, 136000, 5500, 141000, 107180, 77000]
	    }
	  ]
	});
</script> -->

<script type="text/javascript">
	Highcharts.chart('container-jenis-surat', {
	  chart: {
	    type: 'column'
	  },
	  exporting: {
	  	enabled: false
	  },
	  title: {
	    text: null,
	    align: 'left'
	  },
	  subtitle: {
	    text: null,
	    align: 'left'
	  },
	  xAxis: {
	    categories: ['Nota Dinas', 'Surat Keluar', 'Surat Edaran', 'Surat Perintah', 'Surat Keputusan Direksi', 'Keputusan Direksi', 'Instruksi Direksi', 'Surat Masuk Manual'],
	    crosshair: true,
	    accessibility: {
	      description: 'Countries'
	    }
	  },
	  yAxis: {
	    min: 0,
	    title: {
	      text: null
	    },
	    stackLabels: {
	          enabled: true,
	          style: {
	            fontSize: '13px',
	            textOutline: 'none',
	            // color: 'white'
	            // fontSize: chartFontSize + 'px'
	          },
	      },
	      // labels: {
	      //   enabled: false
	      // },
	      gridLineColor: 'transparent'
	  },
	  tooltip: {
	    valueSuffix: ' (1000 MT)'
	  },
	  plotOptions: {
	    column: {
	      pointPadding: 0.2,
	      borderWidth: 0
	    }
	  },
	  series: [
	    {
	      name: 'Jumlah',
	      data: [406292, 260000, 107000, 68300, 127500, 104500]
	    },
	    // {
	    //   name: 'Surat Keluar',
	    //   data: [51086, 136000, 5500, 141000, 107180, 77000]
	    // }
	    // ,
	    // {
	    //   name: 'Surat Edaran',
	    //   data: [31086, 106000, 8500, 121000, 57180, 57000]
	    // }
	  ],
	  legend: {
	  	enabled: false
	  }
	});
</script>

<!-- DATATABLE -->
<link rel="stylesheet" type="text/css" href="libraries/datatable/jquery.dataTables.css">

<!-- <script src="libraries/datatable/jquery-3.7.0.js" type="text/javascript"></script> -->
<script src="libraries/datatable/jquery.dataTables.js" type="text/javascript"></script>
<!-- https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css
https://code.jquery.com/jquery-3.7.0.js -->
<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script> -->
<script type="text/javascript">
	// new DataTable('#example');
	new DataTable('#example', {
	    paging: false,
	    scrollCollapse: true,
	    scrollY: 'calc(20vh - 60px)',
	    "searching": false
	});
</script>

<script type="text/javascript">
	// new DataTable('#example');
	new DataTable('#example2', {
	    paging: false,
	    scrollCollapse: true,
	    scrollY: 'calc(20vh - 14px)',
	    "searching": false
	});
</script>

@endsection 
