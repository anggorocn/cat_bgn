
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
$querySoal=json_decode(json_encode($querySoal), true);
$queryJawaban=json_decode(json_encode($queryJawaban), true);
$user=Session::get('user');
$queryJawabanPeserta=json_decode(json_encode($queryJawabanPeserta), true);
// print_r($querySoal);exit;

// Menentukan waktu akhir countdown jika belum ada di localStorage
$duration = $setWaktu->menit_soal*60;

// $duration=100000000;

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
                        <h3 class="card-label">UJIAN <?=$urutan?></h3>
                        <a class="btn btn-warning font-weight-bold mr-2" onclick="InfoUjian(<?=$queryIdentitas->ujian_id?>,<?=$queryIdentitas->tipe_ujian_id?>)"><p style="margin: 0px;">Lihat Instruksi Pengerjaan</p></a>
                    </div>
                    <div class="card-toolbar">
                        <div style="color: black;font-size:20px" id="countdown"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card-body" style="height: 55vh;">
                            <section class="your-class">
                                <?php for($i=0; $i<count($querySoal);$i++){
                                    $pertanyaan=$querySoal[$i]['pertanyaan'];
                                    $pertanyaan_id=$querySoal[$i]['bank_soal_id'];
                                    $keterangan=$querySoal[$i]['keterangan'];
                                    ?>
                                    <div>
                                        <form class="formadd<?=$i?>" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                            <div class="row">
                                                <div style="width:5%"><h4> <?=$i+1?>. </h4></div> 
                                                <div style="width:95%">
                                                    <div class="row">
                                                        <div class="col-lg-12" style="font-size: 15px;">
                                                            <?=$pertanyaan?>
                                                        </div>
                                                        <div class="col-lg-6" style="font-size: 15px;">
                                                            <br>
                                                            <input type="text" class="form-control" id='reqKeterangan<?=$pertanyaan_id?>' value='<?=$keterangan?>'>
                                                        </div>

                                                        <div class="col-lg-2" style="font-size: 15px;">
                                                            <br>
                                                            <a type="button" onclick="terjawab(<?=$pertanyaan_id?>)" class="btn btn-primary"style="width: 92%;padding: 0.3rem 1rem;"><h3>Simpan</h3></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php }?>
                            </section>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a id="prevBtn" class="btn btn-warning font-weight-bold mr-2"><h3>Kembali</h3></a>
                                    <a id="nextBtn" class="btn btn-warning font-weight-bold mr-2" style="float: right;"><h3>Selanjutnya</h3></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                           <a class="btn btn-warning font-weight-bold mr-2" style="width: 90%; margin:10px 5%;display:none" id='selesai' onclick="setFinish()"><h3>Selesai</h3></a>
                            <div class="card-body" style="height: 60vh; overflow: scroll;">
                                <div class="row">
                                    <?php 
                                    $totalterjawab=0;
                                    for($i=0; $i<count($querySoal);$i++){
                                        $classbtn='btn-success';
                                        $bank_soal_id=$querySoal[$i]['bank_soal_id'];
                                        if(!empty($queryJawabanPeserta)){
                                            $arrayJawabanPeserta=StringFunc::in_array_column($bank_soal_id, 'bank_soal_id', $queryJawabanPeserta);
                                            if(count($arrayJawabanPeserta)!=0){
                                                $classbtn='btn-warning';
                                                $totalterjawab++;
                                            }
                                        }
                                        ?>
                                        <div style="width:20%;" >
                                            <button type="button" onClick='tombolsoal(<?=$i?>)' class="btn <?=$classbtn?>" id='nomor-<?=$querySoal[$i]['bank_soal_id']?>'  style="width: 92%;margin: 4%;"><h3><?=$i+1?></h3></button>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<button style="display: none;" id="calculateTotal"></button>
    <script type="text/javascript">

        let total = 0;

        $(document).on('ready', function() {
            <?php  
            if($tipe_ujian->tipe_status==1){?>
                document.location.href = "app/ujian/pilihujian";
            <?php }
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
                slickCarousel.slick('slickPrev');
                checkButtons();  // Cek kondisi tombol setelah navigasi
            });

            $('#nextBtn').click(function(){
                slickCarousel.slick('slickNext');
                checkButtons();  // Cek kondisi tombol setelah navigasi
            });

            // Cek tombol setelah inisialisasi carousel
            checkButtons();

            // Menambahkan event listener saat perubahan slide terjadi
            slickCarousel.on('afterChange', function(event, slick, currentSlide){
                checkButtons();  // Cek kondisi tombol saat slide berubah
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

            $('input[id^="radio"]').change(function(e) {
                var tempId= $(this).attr('id');
                var idPecah = tempId.split('-')
                var idSoal = idPecah[1];
                var idjawaban = idPecah[2];
                document.getElementById('nextBtn').click();

                $("#nomor-"+idSoal).removeClass("btn-success").addClass("btn-warning");

                terjawab(tempId);
                $('#calculateTotal').click();

            });      

             $('#calculateTotal').click();

            <?php if($ujianbaru==1){?>
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
                    var s_url= "Ujian/ujian_online_finish/<?=$reqId?>";
                    $.ajax({'url': s_url,'success': function(msg) {
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
                                    document.location.href = "app/ujian/selesai/<?=$reqId?>";
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
        
        });


        $('#calculateTotal').click(function() {
            
            // Menjumlahkan nilai dari elemen dengan kelas 'price'
            total=0
            $('.btn-warning').each(function() {
                total ++  // Mengambil teks dan mengkonversinya ke float
            });

            // Menampilkan hasil total
            // console.log(total)
            if((total-4)==<?=count($querySoal)?>){
                $('#selesai').show();
            }
        });  

        function setFinish()
        {
            var s_url= "Ujian/ujian_online_finish/<?=$reqId?>";
            Swal.fire({
                text: "Apakah Anda yakin ingin menyelesaikan ujian? jika iya maka jawaban tidak bisa diubah lagi",
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
                // Jika pengguna mengonfirmasi
                if (result.isConfirmed) {
                    // Jalankan operasi Ajax
                    $.ajax({
                        url: s_url,
                        success: function(msg) {
                            if (msg == '') {
                                // Tidak ada tindakan jika pesan kosong
                                // consolelog('xx')
                            } else {
                               Swal.fire({
                                    text: msg,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function() {
                                    // Log URL untuk memastikan URL benar
                                    var redirectUrl = "app/ujian/selesai/<?=$reqId?>";
                                    // console.log("Mengalihkan ke:", redirectUrl);

                                    // Mengalihkan ke URL
                                    window.location.href = redirectUrl;
                                });
                            }
                        }
                    });
                }
            });
           
        }

        function tombolsoal(ke){
            $('.your-class').slick('slickGoTo', ke);
        }

        function terjawab(argument) {
            // Build URL with PHP variables inside
            loadingActive()
            var s_url = "Ujian/jawab/<?=$reqId?>/<?=$user->ujian_id?>/<?=$queryIdentitas->tipe_ujian_id?>/"+argument+"/-1/<?=$user->pegawai_id?>";
            var reqKeterangan = $('#reqKeterangan'+argument).val();
            $.ajax({
                url: s_url,
                method: 'POST', // Make sure to use POST if sending data
                data: {
                    // Send the data as part of the request
                    textarea_data: reqKeterangan
                },
                success: function(msg) {
                    if (msg == '') {
                        // If no message is returned, log to console
                        console.log('No response received');
                    } else {
                        loadingDiactive()
                        document.getElementById('nextBtn').click();
                        $("#nomor-"+argument).removeClass("btn-success").addClass("btn-warning");
                        $('#calculateTotal').click();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    console.log("Error: " + error);
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
    </script>

@endsection
