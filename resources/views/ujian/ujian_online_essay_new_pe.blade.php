
@extends('ujian/index_ujian') 
@section('content')
<base href="{{ asset('/') }}">
<link rel="stylesheet" type="text/css" href="libraries/slick/slick.css">
<link rel="stylesheet" type="text/css" href="libraries/slick/slick-theme.css">
<style type="text/css">
html, body {
  margin: 0;
  padding: 0;
}

* {
  box-sizing: border-box;
}

.slider {
    width: 50%;
    margin: 100px auto;
}

.slick-slide {
  margin: 0px 20px;
}

.slick-prev:before,
.slick-next:before {
  color: black;
}


.slick-slide {
  transition: all ease-in-out .3s;
  opacity: .2;
}

.slick-active {
  opacity: .5;
}

.slick-current {
  opacity: 1;
}
.jawaban{
    cursor: pointer;
}
.terpilih{
    background-color: red;
  padding: 10px;
  border-radius: 22px;
}

#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 1000; /* Ensure loading screen is above other elements */
/*    display: none;*/
}

.spinner {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#main-content {
    padding: 20px;
}
.btn.btn-light-secondary {
    color: black !important; /* Mengubah warna teks menjadi hitam */
}

.btn.btn-warning{
    background-color: #28a745;
  border-color: #28a745;
}
</style>
<div id="loading-screen">
    <div class="spinner"></div>
    <p>Loading...</p>
</div>
<div id="main-content">
<!--     <h1>Welcome to the Main Page</h1>
    <p>This is the main content of the page.</p> -->
</div>
</style>
<?php
$querySoal=json_decode(json_encode($soalessay), true);
$queryJawaban=json_decode(json_encode($jawabanessay), true);
$user=Session::get('user');
// $queryJawabanPeserta=json_decode(json_encode($queryJawabanPeserta), true);
// print_r($maxJawabanId); exit;
// Menentukan waktu akhir countdown jika belum ada di localStorage
$duration = 90*60;
// $duration = 10;

?>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="libraries/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
</script>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">UJIAN PE</h3>

                    </div>
                    <div class="card-toolbar">
                        <div style="color: black;font-size:20px" id="countdown"></div>
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <input type="hidden" id="reqJawaban_id" value="<?=$maxJawabanId?>">
                        <div class="col-lg-9">
                            <div class="card-body" style="height: 55vh;">
                                <span style="color:red">INSTRUKSI</span><span>: Tuliskan/ceritakan pengalaman Anda secara detail dan jelas sesuai dengan perintah pada masing-masing pertanyaan! </span>
                                <br>
                                <br>
                                <section class="your-class">
                                    <?php for($i=0; $i<count($querySoal);$i++){
                                        $arrayJawaban=StringFunc::in_array_column($querySoal[$i]['soal_pe_id'], 'soal_pe_id', $queryJawaban);
                                        if(!empty($arrayJawaban)){
                                            $reqSituasi=$queryJawaban[$arrayJawaban[0]]['situasi'];
                                            $reqKendala=$queryJawaban[$arrayJawaban[0]]['kendala'];
                                            $reqLangkah=$queryJawaban[$arrayJawaban[0]]['langkah'];
                                            $reqHasil=$queryJawaban[$arrayJawaban[0]]['hasil'];
                                        }
                                        else{
                                            $reqSituasi='';
                                            $reqKendala='';
                                            $reqLangkah='';
                                            $reqHasil='';
                                        }
                                        ?>
                                        <div>
                                            <div class="row">
                                                <div style="width:3%"><h4> <?=$i+1?>. </h4></div> 
                                                <div style="width:97%">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <span style="font-size: 15px;"><b><?=$querySoal[$i]['soal']?></b></span>
                                                            <br>
                                                            <!-- <a onclick="terjawab(<?=$querySoal[$i]['soal_pe_id']?>)" class="btn btn-success font-weight-bold mr-2"><span>Simpan</span></a> -->
                                                        </div>
                                                        <div class="col-lg-12" style="overflow: scroll;height: 35vh;overflow-y: show;">
                                                            <br>
                                                            <br>
                                                            <span style="font-size: 15px;">a.Tuliskan situasi dan tugas ketika itu secara detail dan siapa saja yang terlibat</span>
                                                            <br>
                                                            <input type="hidden" name="reqSoalId[]" value="<?=$querySoal[$i]['soal_pe_id']?>">
                                                            <textarea class="form-control" style="height: 100px;" id="reqSituasi-<?=$querySoal[$i]['soal_pe_id']?>" name="reqSituasi[]"><?=$reqSituasi?></textarea>
                                                            <br>
                                                            <br>
                                                            <span style="font-size: 15px;">b.Tuliskan kendala atau kesulitan yang Anda temui</span>
                                                            <br>
                                                            <textarea class="form-control" style="height: 100px;" id="reqKendala-<?=$querySoal[$i]['soal_pe_id']?>" name="reqKendala[]"><?=$reqKendala?></textarea>
                                                            <br>
                                                            <br>
                                                            <span style="font-size: 15px;">c.Tuliskan langkah yang Anda ambil dan mengapa mengambil langkah tersebut</span>
                                                            <br>
                                                            <textarea class="form-control" style="height: 100px;" id="reqLangkah-<?=$querySoal[$i]['soal_pe_id']?>" name="reqLangkah[]"><?=$reqLangkah?></textarea>
                                                            <br>
                                                            <br>
                                                            <span style="font-size: 15px;">d.Tuliskan hasil atau akhir dari kejadian tersebut</span>
                                                            <br>
                                                            <textarea class="form-control" style="height: 100px;" id="reqHasil-<?=$querySoal[$i]['soal_pe_id']?>" name="reqHasil[]"><?=$reqHasil?></textarea>
                                                            <br>
                                                            <br>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                </section>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a onclick="submitForm('simpan')" class="btn btn-success font-weight-bold mr-2" style="float:right;" ><span>Simpan</span></a>
                                        <a onclick="kembali()" class="btn btn-secondary font-weight-bold mr-2" style="float:right;" ><span>Kembali</span></a>
                                        <a id="nextBtn" class="btn btn-warning font-weight-bold mr-2" style="float: right;"><span>Selanjutnya</spanh3></a>
                                        <a id="prevBtn" class="btn btn-warning font-weight-bold mr-2" style="float: right;"><span>Sebelumnya</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="row">
                               <a class="btn btn-warning font-weight-bold mr-2" style="width: 90%; margin:10px 5%;display:none" id='selesai' onclick="setFinish()"><h3>Selesai</h3></a>
                                <div class="card-body" style="height: 60vh; overflow: scroll;">
                                    <div class="row">
                                        <?php 
                                        $totalterjawab=0;
                                        for($i=0; $i<count($querySoal);$i++){
                                            $classbtn='btn-success';
                                            $arrayJawaban=StringFunc::in_array_column($querySoal[$i]['soal_pe_id'], 'soal_pe_id', $queryJawaban);
                                            if(!empty($arrayJawaban)){
                                                $reqSituasi=$queryJawaban[$arrayJawaban[0]]['situasi'];
                                                $reqKendala=$queryJawaban[$arrayJawaban[0]]['kendala'];
                                                $reqLangkah=$queryJawaban[$arrayJawaban[0]]['langkah'];
                                                $reqHasil=$queryJawaban[$arrayJawaban[0]]['hasil'];
                                            }
                                            else{
                                                $reqSituasi='';
                                                $reqKendala='';
                                                $reqLangkah='';
                                                $reqHasil='';
                                            }

                                            if(!empty($reqSituasi) && !empty($reqKendala) && !empty($reqLangkah) && !empty($reqHasil))
                                            {
                                                $classbtn='btn-warning';
                                                $totalterjawab++;
                                            }
                                            ?>
                                            <div style="width:20%;" >
                                                <button type="button" onClick='tombolsoal(<?=$i?>)' class="btn <?=$classbtn?>" id='nomor-<?=$querySoal[$i]['soal_pe_id']?>'  style="width: 92%;margin: 4%;"><h3><?=$i+1?></h3></button>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<button style="display: none;" id="calculateTotal"></button>
    <script type="text/javascript">
        loadingDiactive()

        function kembali() {
            window.location.href='app/ujian/pilihujian';
        }
    
        // Terima pesan dari iframe
        window.addEventListener("message", function(event) {
            if (event.data.action === "callMyFunction") {
                window.location.href='app/ujian/ujian_online/'+event.data.value;
                // alert("Fungsi di halaman utama dipanggil!"+event.data.value);
            }
        }, false);

        let total = 0;

        $(document).on('ready', function() {
            <?php  
            if(!empty($cekjawaban)){
                if(!empty($cekjawaban->submit)){?>
                    document.location.href = "app/ujian/pilihujian";
            <?php }
            }
            ?>

            var slickCarousel = $('.your-class').slick({
                lazyLoad: 'ondemand', // ondemand progressive anticipated
                infinite: false,
                prevArrow: false, // Menonaktifkan tombol prev default
                nextArrow: false, // Menonaktifkan tombol next default
                draggable: false 
            });

            // Menambahkan event listener untuk tombol Next dan Back
            $('#prevBtn').click(function(){
                submitForm('saveaja');
                slickCarousel.slick('slickPrev');
                checkButtons();  // Cek kondisi tombol setelah navigasi
            });

            $('#nextBtn').click(function(){
                submitForm('saveaja');
                slickCarousel.slick('slickNext');
                checkButtons();  // Cek kondisi tombol setelah navigasi

            });

            // Cek tombol setelah inisialisasi carousel
            checkButtons();

            // Menambahkan event listener saat perubahan slide terjadi
            slickCarousel.on('afterChange', function(event, slick, currentSlide){
                checkButtons();  // Cek kondisi tombol saat slide berubah
            });

            const slickElement = document.querySelector('.your-class'); // Ganti dengan selektor Slick-mu

            $('.your-class').on('keydown', function(e) {
                if (e.key === 'Tab') {
                    const $activeSlide = $('.your-class .slick-slide.slick-active');
                    const $focusable = $activeSlide.find('textarea, input, button, select, a, [tabindex]:not([tabindex="-1"])')
                        .filter(':visible:not([disabled])');

                    const first = $focusable[0];
                    const last = $focusable[$focusable.length - 1];

                    if ($focusable.length === 0) return;

                    // Shift + Tab
                    if (e.shiftKey) {
                        if (document.activeElement === first) {
                            e.preventDefault();
                            last.focus();
                        }
                    } 
                    // Tab forward
                    else {
                        if (document.activeElement === last) {
                            e.preventDefault();
                            first.focus();
                        }
                    }
                }
            });


            function checkButtons() {
                var currentSlide = slickCarousel.slick('slickCurrentSlide');
                var totalSlides = slickCarousel.slick('getSlick').slideCount;

                // Menyembunyikan tombol "Back" jika berada di slide pertama
                if (currentSlide === 0) {
                    $('#prevBtn').hide();
                } else {
                    $('#prevBtn').show();
                }

                // Menyembunyikan tombol "Next" jika berada di slide terakhir
                if (currentSlide === totalSlides - 1) {
                    $('#nextBtn').hide();
                } else {
                    $('#nextBtn').show();
                }
            }
             $('#calculateTotal').click();

             <?php if(empty($cekjawaban)){?>
             // reset localStorage
             clearInterval(x);
                localStorage.removeItem('remainingTime');
                remainingTime = <?php echo $duration; ?>;
                localStorage.setItem('remainingTime', remainingTime);
                
            <?php }?>


            // waktu start
            // Periksa apakah ada waktu tersisa di localStorage
            var remainingTime = localStorage.getItem('remainingTime');

            if (!remainingTime) {
                // Jika tidak ada, set waktu tersisa dari PHP
                remainingTime = <?php echo $duration; ?>;
            } else {
                // Pastikan remainingTime dalam bentuk number
                remainingTime = parseInt(remainingTime, 10);
            }
                var x = setInterval(updateCountdown, 1000);

            // Fungsi untuk memperbarui countdown setiap detik
            function updateCountdown() {
                // Hitung waktu untuk jam, menit, dan detik
                var hours = Math.floor((remainingTime % (60 * 60 * 24)) / (60 * 60));
                var minutes = Math.floor((remainingTime % (60 * 60)) / 60);
                var seconds = Math.floor(remainingTime % 60);

                // Tampilkan hasilnya di elemen dengan id "countdown"
                $('#countdown').html(hours + "h " + minutes + "m " + seconds + "s ");

                // Jika countdown selesai, tulis teks
                if (remainingTime <= 0) {
                    clearInterval(x);
                    $('#countdown').html("EXPIRED");
                    // return false
                    // Hapus remainingTime dari localStorage setelah timer selesai
                    // return false;
                    var s_url= "Ujian/essayJawaban";
                    $.ajax({
                        'url': s_url,
                        'method': "POST",
                        'data': {
                            reqJawaban_id: $("#reqJawaban_id").val(),
                            reqSubmit: 1
                        },
                        'success': function(msg) {
                        if(msg == ''){}
                        else
                        {
                            Swal.fire({
                                    text: 'Waktu Habis, Silahkan Lanjut ke Ujian Selanjutnya',
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function() {
                                    document.location.href = "app/ujian/pilihujian";
                                });
                        }
                    }});

                    localStorage.removeItem('remainingTime');
                } else {
                    // Kurangi waktu tersisa
                    remainingTime--;
                    // Simpan waktu tersisa di localStorage
                    localStorage.setItem('remainingTime', remainingTime);
                }
            }

            // Perbarui countdown setiap 1 detik
            // var x = setInterval(updateCountdown, 1000);
            // waktu end
            loadingDiactive()

            setInterval(() => submitForm('saveaja'), 10000);
        })
             
             
        $('#calculateTotal').click(function() {
            
            // Menjumlahkan nilai dari elemen dengan kelas 'price'
             $("[name='reqSituasi[]']").each(function() {
                let val = $(this).val();
                let idblock =  $(this).attr("id");
                idblock = idblock.replace("reqSituasi", "");
            // console.log(idblock)
                if($("#reqSituasi"+idblock).val() && $("#reqKendala"+idblock).val() && $("#reqLangkah"+idblock).val() && $("#reqHasil"+idblock).val() ){
                    $("#nomor"+idblock).removeClass("btn-success").addClass("btn-warning");
                }
            });

            total=0
            $('.btn-warning').each(function() {
                total ++  // Mengambil teks dan mengkonversinya ke float
            });

            // Menampilkan hasil total
            // console.log(total)
            if((total-3)==<?=count($querySoal)?>){
                $('#selesai').show();
            }
        });  

        function setFinish()
        {
            Swal.fire({
                text: "Apakah Anda yakin ingin menyelesaikan ujian? Jika iya maka jawaban tidak bisa diubah lagi.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, lanjutkan",
                cancelButtonText: "Tidak, batalkan",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary",
                    cancelButton: "btn font-weight-bold btn-light-secondary"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan request AJAX
                    $.ajax({
                        url: "Ujian/essayJawaban",
                        method: "POST",
                        data: {
                            reqJawaban_id: $("#reqJawaban_id").val(),
                            reqSubmit: 1
                        },
                        
                        success: function (response) {
                            var data = jQuery.parseJSON(response);
                            // console.log(data); return false;
                            data= data.message;
                            data= data.split("-");
                            rowid= data[0];
                            infodata= data[1];

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
                                    document.location.href = "app/ujian/pilihujian";
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = JSON.parse(xhr.responseText);
                            Swal.fire("Error", err.message, "error");
                        }
                    });
                }
            });
           
        }

        

        function tombolsoal(ke){
            $('.your-class').slick('slickGoTo', ke);
        }

        function terjawab(i) { 
            // console.log(argument); return false;
            loadingActive()
            $.ajax({
                url: "Ujian/jawabPe",
                method: "POST",
                data: {
                    reqSituasi: $("#reqSituasi-"+i).val(),
                    reqKendala: $("#reqKendala-"+i).val(),
                    reqLangkah: $("#reqLangkah-"+i).val(),
                    reqHasil: $("#reqHasil-"+i).val(),
                    reqSoalId: i
                },
                success: function(msg) {
                    if (msg == '') {
                        $.messager.alert('Info', "Data gagal disimpan", 'info');
                        $.messager.progress('close');
                    } else {
                        loadingDiactive();
                        if($("#reqSituasi-"+i).val() && $("#reqKendala-"+i).val() && $("#reqLangkah-"+i).val() && $("#reqHasil-"+i).val()){
                            $("#nomor-"+i).removeClass("btn-success").addClass("btn-warning");
                        }
                        $('#calculateTotal').click();
                    }
                }
            });
           
        }


        // Fungsi untuk memeriksa apakah tombol Back atau Next perlu disembunyikan
    function loadingActive () {
        var loadingScreen = document.getElementById("loading-screen");
        var mainContent = document.getElementById("main-content");

        $('#loading-screen').show();
        mainContent.style.display = "block";  // Show main content

        document.body.style.overflow = "auto"; // Enable scrolling
        // console.log('xxx')
    };

    function loadingDiactive() {
        var loadingScreen = document.getElementById("loading-screen");
        $('#loading-screen').hide();
        // console.log('yyy')
    }


    function InfoUjian(tahapid,id) {
        openAdd('app/ujian/lookup/popup_ujian/'+id+'/'+tahapid+'/close');
    }



    function submitForm(mode) {
        if (mode === "saveaja") {}
        else{
            loadingActive()
        }
        var form = document.getElementById("ktloginform");
        var formData = new FormData(form);
        formData.append("mode", mode); // kirim mode ke server: 'sementara' atau 'selesai'

        $.ajax({
            url: "Ujian/jawabPeSemua", // backend bisa cek berdasarkan 'mode'
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var data = jQuery.parseJSON(response);
                var [rowid, infodata] = data.message.split("-");

                if (rowid === "xxx") {
                    Swal.fire("Error", infodata, "error");
                } else {
                    
                    $('#calculateTotal').click();
                    if (mode === "saveaja") {
                        console.log('autosave berhasil')
                        // loadingDiactive();
                    }
                    else{
                        loadingDiactive();
                        Swal.fire({
                            text: infodata,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(function () {

                        });
                    }

                }
            },
            error: function(xhr) {
                var err = JSON.parse(xhr.responseText);
                Swal.fire("Error", err.message, "error");
            }
        });
    }
    </script>

@endsection
