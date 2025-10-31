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
// print_r($query) ;exit;
if($user->user_group_id==1){
	$jabatan='Administrator';
} else if($user->user_group_id==2){
	$jabatan='Asesor';
} else if($user->user_group_id==6){
	$jabatan='User CAT';
}
$arrdata='';
if($user->user_group_id==2){
  $queryAsesor=json_decode(json_encode($query), true);
// 	print_r($queryAsesor);exit;
}

elseif($user->user_group_id==6){
 	$arrdata= array(
		array("label"=>"Acara", "field"=> "acara", "alias"=> "A.NIP", "display"=>"",  "width"=>"80")
		, array("label"=>"Tanggal Mulai", "field"=> "start", "alias"=> "A.NAMA", "display"=>"",  "width"=>"80")
		, array("label"=>"Tanggal Selesai", "field"=> "end", "alias"=> "A.JABATAN", "display"=>"",  "width"=>"10")
		, array("label"=>"Status", "field"=> "terdaftar",  "display"=>"",  "width"=>"10")
		
		// buat tombol aksi
		, array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
		
		// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
		, array("label"=>"sorderdefault", "field"=> "jadwal_awal_tes_id",  "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
		, array("label"=>"fieldid", "field"=> "jadwal_awal_tes_id", "alias"=> "A.PEGAWAI_ID", "display"=>"1", "width"=>"")
	);

  $query1_jadwal_awal_tes_id='';
  if(!empty($query1)){
  	$query1_jadwal_awal_tes_id=$query1->limit_drh;
  }
  // print_r($query1_jadwal_awal_tes_id);exit;
}

?>

@extends('app/index_kosong') 
@section('header') 

<style type="text/css">
</style>

<div class="container">
	<!--begin::Dashboard-->
	<!--begin::Row-->
	<div class="row" style="margin-top:30px; background-color: rgba(0, 76, 128, 0.5);padding: 20px 0px ; border-radius: 20px;">
		<div class="col-lg-6 col-xxl-3">
			<div class="area-profil">
				<?php
				$vurlfoto= "../../assets/media/users/300_21.jpg";
				?>
				<div class="foto"><img src="<?=$vurlfoto?>"></div>
				<div class="data">
					<div class="nama" style="color:white;">{{$user->nama}}</div>
					<div class="nik"><?=$jabatan?></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-lg-9 col-xxl-6">
			Selamat datang {{$user->nama}},
			<div class="nama-aplikasi" style="font-size:27px">di <strong> Aplikasi Assessment Center Badan Pusat Statistik</strong></div>
		</div>
		<div class="col-lg-9 col-xxl-3">
			<div class="area-jam" style="text-align: right;">
				<script>
					function display_ct7() {
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
						x1 = "<div class='jam'>" + hours + ":" +  minutes + "</div><div class='hari'>" + x1 + "</div>";
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
		</div>
	</div>
	<div>
		<div class="col-lg-12 col-xxl-12">
			<div class="area-main-menu">
				<div class="inner">
					<?php if($user->user_group_id==1){?>
					<div class="col-lg-4 col-xxl-4">
						<div class="item" onclick="location.href='{{url('app/pegawai/index')}}';" style="width:100%">
							<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
							<div class="ikon"><img src="../../assets/media/images/icon-kotak-masuk.png"></div>
							<div class="nama">Pengaturan CAT</div>
							<div class="clearfix"></div>
						</div>
						<div class="item">
						</div>
						<div class="item" onclick="location.href='{{url('app/manajemen_talenta/grafikninebox')}}';" style="width:100%">
							<div class="gambar"><img src="../../assets/media/images/img-kotak-masuk.jpg"></div>
							<div class="ikon"><img src="../../assets/media/images/icon-kotak-masuk.png"></div>
							<div class="nama">Manajemen Talenta</div>
							<div class="clearfix"></div>
						</div>
						<div class="item">
						</div>
						<div class="item" onclick="location.href='{{url('app/suksesi/masterrumpun')}}';" style="width:100%">
							<div class="gambar"><img src="../../assets/media/images/img-kotak-proses.jpg"></div>
							<div class="ikon"><img src="../../assets/media/images/icon-kotak-masuk.png"></div>
							<div class="nama">Rencana Suksesi</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<?php }
					else if($user->user_group_id==2){?>
						<div class="row">
							<div class="col-lg-4">
								<div class="area-kalendar">
									<div class="calendar-container">
                      <div class="calendar-month-arrow-container">
                        <div class="calendar-month-year-container">
                          <select class="calendar-years"></select>
                          <select class="calendar-months">
                          </select>
                        </div>
                        <div class="calendar-month-year">
                        </div>
                        <div class="calendar-arrow-container">
                          <button class="calendar-today-button"></button>
                          <button class="calendar-left-arrow">
                            ← </button>
                          <button class="calendar-right-arrow"> →</button>
                        </div>
                      </div>
                      <ul class="calendar-week">
                      </ul>
                      <ul class="calendar-days">
                      </ul>
                    </div>
								</div>								
							</div>
							<div class="col-lg-8">
								<div  class="area-kalendar" style="padding:20px;">
                <table id="customers">
								  <tr>
								    <th style="width:20%">Ujian</th>
								    <th style="width:20%">Pegawai</th>
								    <th style="width:50%">Tugas Asesor</th>
								    <th style="width:10%"></th>
								  </tr>
								</table>
								<div id="reqTableKegiatan"  style="height: 43vh; overflow: scroll;">
									
								</div>
                </div>
							</div>
						</div>
					<?php
					} 
					else if($user->user_group_id==6)
					{?>
						<div class="row">
							<div class="col-lg-6">
								<div class="d-flex flex-column-fluid">
									<div class="container">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<span class="card-icon">
														<i class="flaticon2-supermarket text-primary"></i>
													</span>
													<h3 class="card-label"> Undangan Ujian</h3>
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
							</div>
							<div class="col-lg-6">
							<?php
								if(empty($query)){
									?>

								<div class="item" style="width:95%">
									<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
									<div class="ikon"><i class='fas fa-pen-square' style='font-size:36px'></i></div>
									<div class="nama">Anda Belum Terdaftar Ujian</div>
									<div class="clearfix"></div>
								</div>
								<?php 
								}
								else{
								    date_default_timezone_set("Asia/Jakarta"); // Atur zona waktu sesuai kebutuhan

                                    $sekarang = date("H:i");
                                    
									if(empty($query->limit_drh)){
    									if($sekarang>$user->waktu_mulai){
    									?>
    										<div class="item" style="width:95%" onclick="location.href='{{url('app/ujian/dashboard')}}';">
    											<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
    											<div class="ikon"><i class='fas fa-pen-square' style='font-size:36px'></i></div>
    											<div class="nama">Mulai Cat</div>
    											<div class="clearfix"></div>
    										</div>
									<?php 
    									}
    									else{?>
    									    <div class="item" style="width:95%">
												<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
												<div class="ikon"><i class='fas fa-pen-square' style='font-size:36px'></i></div>
												<div class="nama" style="display:block;margin-top: 20px;">
													Anda Terdaftar Dalam Ujian Hari Ini, <br>Akses Ujian Belum Dibuka<br>
													<!--<span style="color: red;font-size: 10px;">anda tidak mengisi Pra Ujian dengan batasan waktu</span>-->
												</div>

												<div class="clearfix"></div>
											</div>
    									<?php
    									}
    								}
									else{
										$infolinkfile='uploads/drh/'.$query->jadwal_awal_tes_id.'/'.md5($query->jadwal_awal_tes_id.'-'.$user->pegawai_id).".docx";
										// print_r($infolinkfile);exit;
										if(file_exists($infolinkfile)){?>
											<div class="item" style="width:95%" onclick="location.href='{{url('app/ujian/dashboard')}}';">
												<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
												<div class="ikon"><i class='fas fa-pen-square' style='font-size:36px'></i></div>
												<div class="nama">Mulai Cat</div>
												<div class="clearfix"></div>
											</div>
										<?php  
										}
										else{?>
											<div class="item" style="width:95%">
												<div class="gambar"><img src="../../assets/media/images/img-buat-surat.jpg"></div>
												<div class="ikon"><i class='fas fa-pen-square' style='font-size:36px'></i></div>
												<div class="nama" style="display:block;margin-top: 20px;">
													Anda Tidak Berhak Untuk Mengikuti Ujian<br>
													<span style="color: red;font-size: 10px;">anda tidak mengisi Pra Ujian dengan batasan waktu</span>
												</div>

												<div class="clearfix"></div>
											</div>
										<?php 
										}
									}
									if(!empty($query->link_soal)){?>
									<a href="<?=$query->link_soal?>" target="_blank" style="color: white;"><h1 style=" margin-left: 20px;"> Bergabung dengan zoom</h1></a>
								<?php }?>
								
								<?php
								}
							}

								if(!empty($query1)){?>
										<div class="item" style="width:95%" onclick="location.href='{{ url('app/ujian/uploaddrh/' . $query1->jadwal_awal_tes_id) }}';">
											<div class="gambar"><img src="../../assets/media/images/img-kotak-masuk.jpg"></div>
											<div class="ikon"><i class='fas fa-pen-square' style='font-size:36px'></i></div>
											<div class="nama">File Pra Ujian</div>
											<div class="clearfix"></div>
										</div>
										<div class="item" style="width:95%">
											<span style="color: red; padding: 4px; display: inline-block; border-radius: 5px; background-color: white;">* Isi sebelum tanggal <?=$query1->tanggal_tes?>, jika terlambat anda tidak bisa mengikuti ujian</span>
										</div>
								<?php 
								}?>
							</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

		<div class="col-lg-6 col-xxl-3">
			<div class="area-kalendar">
				<!-- <div id="container" class="calendar-container"></div> -->
			</div>
		</div>
	</div>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="triggercari1" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="triggercari2" style="display:none" title="triggercari">triggercari</a>

<!-- EVENT CALENDAR -->
<link rel="stylesheet" href="assets/animated-event-calendar/dist/simple-calendar.css">
<script src="assets/animated-event-calendar/dist/jquery.simple-calendar.js"></script>
<?php
if($user->user_group_id==2){
?>
<script type="text/javascript">
  // const weekArray = ["Sen", "Sel", "Rbu", "Kms", "Jmt", "Sbt", "Mng"];
  const weekArray = ["Mng","Sen", "Sel", "Rbu", "Kms", "Jmt", "Sbt"];
	const monthArray = [
	  "January",
	  "February",
	  "March",
	  "April",
	  "May",
	  "June",
	  "July",
	  "August",
	  "September",
	  "October",
	  "November",
	  "December"
	];

	const current = new Date();
	const todaysDate = current.getDate();
	const currentYear = current.getFullYear();
	const currentMonth = current.getMonth();

	window.onload = function () {
	  const currentDate = new Date();
	  generateCalendarDays(currentDate);

	  let calendarWeek = document.getElementsByClassName("calendar-week")[0];
	  let calendarTodayButton = document.getElementsByClassName(
	    "calendar-today-button"
	  )[0];
	  calendarTodayButton.textContent = `Today ${todaysDate}`;

	  calendarTodayButton.addEventListener("click", () => {
	    generateCalendarDays(currentDate);
	  });

	  weekArray.forEach((week) => {
	    let li = document.createElement("li");
	    li.textContent = week;
	    li.classList.add("calendar-week-day");
	    calendarWeek.appendChild(li);
	  });

	  const calendarMonths = document.getElementsByClassName("calendar-months")[0];
	  const calendarYears = document.getElementsByClassName("calendar-years")[0];
	  const monthYear = document.getElementsByClassName("calendar-month-year")[0];

	  const selectedMonth = parseInt(monthYear.getAttribute("data-month") || 0);
	  const selectedYear = parseInt(monthYear.getAttribute("data-year") || 0);

	  monthArray.forEach((month, index) => {
	    let option = document.createElement("option");
	    option.textContent = month;
	    option.value = index;
	    option.selected = index === selectedMonth;
	    calendarMonths.appendChild(option);
	  });

	  const currentYear = new Date().getFullYear();
	  const startYear = currentYear - 60;
	  const endYear = currentYear + 60;
	  let newYear = startYear;
	  while (newYear <= endYear) {
	    let option = document.createElement("option");
	    option.textContent = newYear;
	    option.value = newYear;
	    option.selected = newYear === selectedYear;
	    calendarYears.appendChild(option);
	    newYear++;
	  }

	  const leftArrow = document.getElementsByClassName("calendar-left-arrow")[0];

	  leftArrow.addEventListener("click", () => {
	    const monthYear = document.getElementsByClassName("calendar-month-year")[0];
	    const month = parseInt(monthYear.getAttribute("data-month") || 0);
	    const year = parseInt(monthYear.getAttribute("data-year") || 0);

	    let newMonth = month === 0 ? 11 : month - 1;
	    let newYear = month === 0 ? year - 1 : year;
	    let newDate = new Date(newYear, newMonth, 1);
	    generateCalendarDays(newDate);
	  });

	  const rightArrow = document.getElementsByClassName("calendar-right-arrow")[0];

	  rightArrow.addEventListener("click", () => {
	    const monthYear = document.getElementsByClassName("calendar-month-year")[0];
	    const month = parseInt(monthYear.getAttribute("data-month") || 0);
	    const year = parseInt(monthYear.getAttribute("data-year") || 0);
	    let newMonth = month + 1;
	    newMonth = newMonth === 12 ? 0 : newMonth;
	    let newYear = newMonth === 0 ? year + 1 : year;
	    let newDate = new Date(newYear, newMonth, 1);
	    generateCalendarDays(newDate);
	  });

	  calendarMonths.addEventListener("change", function () {
	    let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
	    generateCalendarDays(newDate);
	  });

	  calendarYears.addEventListener("change", function () {
	    let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
	    generateCalendarDays(newDate);
	  });
	};

	function generateCalendarDays(currentDate) {
	  const newDate = new Date(currentDate);
	  const year = newDate.getFullYear();
	  const month = newDate.getMonth();
	  const totalDaysInMonth = getTotalDaysInAMonth(year, month);
	  const firstDayOfWeek = getFirstDayOfWeek(year, month);
	  let calendarDays = document.getElementsByClassName("calendar-days")[0];

	  removeAllChildren(calendarDays);

	  let firstDay = 1;
	  while (firstDay <= firstDayOfWeek) {
	    let li = document.createElement("li");
	    li.classList.add("calendar-day");
	    calendarDays.appendChild(li);
	    firstDay++;
	  }

	  let day = 1;
	  while (day <= totalDaysInMonth) {
	    let li = document.createElement("li");
	    li.setAttribute("id", day+'-'+month+'-'+year);
	    li.textContent = day;
	    li.classList.add("calendar-day");
	    if (todaysDate === day && currentMonth === month && currentYear === year) {
	      li.classList.add("calendar-day-active");
	    }
	        calendarDays.appendChild(li);

	    <?php for($checkbox_index=0;$checkbox_index < count($queryAsesor);$checkbox_index++){?>
	        if ( day === parseInt(<?=$queryAsesor[$checkbox_index]['d']?>) && month === parseInt(<?=$queryAsesor[$checkbox_index]['m']?>)-1 && year === parseInt(<?=$queryAsesor[$checkbox_index]['y']?>)) {
	            li.classList.add("calendar-alert");
	        }
	        calendarDays.appendChild(li);
	        if ( day === parseInt(<?=$queryAsesor[$checkbox_index]['d']?>) && month === parseInt(<?=$queryAsesor[$checkbox_index]['m']?>)-1 && year === parseInt(<?=$queryAsesor[$checkbox_index]['y']?>)) {
	            $( "#<?=(int)$queryAsesor[$checkbox_index]['d']?>-<?=(int)$queryAsesor[$checkbox_index]['m']-1?>-<?=$queryAsesor[$checkbox_index]['y']?>" ).html(day+`<span class="calendar-notif"><?=$queryAsesor[$checkbox_index]['jumlah']?></span>`);
	            $( "#<?=(int)$queryAsesor[$checkbox_index]['d']?>-<?=(int)$queryAsesor[$checkbox_index]['m']-1?>-<?=$queryAsesor[$checkbox_index]['y']?>").attr('onClick', "showdetil('<?=$queryAsesor[$checkbox_index]['d']?>-<?=$queryAsesor[$checkbox_index]['m']?>-<?=$queryAsesor[$checkbox_index]['y']?>')");
	        }
	    <?php }?>
	    day++;
	  }

	  const monthYear = document.getElementsByClassName("calendar-month-year")[0];
	  monthYear.setAttribute("data-month", month);
	  monthYear.setAttribute("data-year", year);
	  const calendarMonths = document.getElementsByClassName("calendar-months")[0];
	  const calendarYears = document.getElementsByClassName("calendar-years")[0];
	  calendarMonths.value = month;
	  calendarYears.value = year;
	}

	function getTotalDaysInAMonth(year, month) {
	  return new Date(year, month + 1, 0).getDate();
	}

	function getFirstDayOfWeek(year, month) {
	  return new Date(year, month, 1).getDay();
	}

	function removeAllChildren(parent) {
	  while (parent.firstChild) {
	    parent.removeChild(parent.firstChild);
	  }
	}

	function showdetil(argument) {
	    var link_url= 'app/asesor/jadwalpenilaian/'+argument;
	    setModal("reqTableKegiatan", link_url);
	}
</script>
<?php }?>

<script type="text/javascript">

	function addLeadingZero(num) {
   	if (num < 10) {
      return "0" + num;
   	} else {
      return "" + num;
   	}
  }

	function setModal(target, link_url)
	{
		var s_url= link_url;
		var request = $.get(s_url);

		request.done(function(msg)
		{
		  if(msg == ''){}
		      else
		      {
		         $('#'+target).html(msg);
		     }
		 });
	}
</script>

<style type="text/css">
@media (min-width: 992px) {
	.header-fixed.subheader-fixed.subheader-enabled .wrapper {
	  padding-top: 65px;
	}
}
</style>

<!-- HIGHCHARTS -->
<script src="assets/highcharts/highcharts.js"></script>
<script src="assets/highcharts/exporting.js"></script>
<script src="assets/highcharts/export-data.js"></script>
<script src="assets/highcharts/accessibility.js"></script>

<!-- DATATABLE -->
<link rel="stylesheet" type="text/css" href="libraries/datatable/jquery.dataTables.css">
<script src="libraries/datatable/jquery.dataTables.js" type="text/javascript"></script>

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
				jsonurl= "/Pegawai/jsonHome";
				datanewtable.DataTable().ajax.url(jsonurl).load();
			});

			var reqUnitKerja= $("#reqUnitKerja").val();

		    var jsonurl= "/Pegawai/jsonHome";
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

	</script>

@endsection 
