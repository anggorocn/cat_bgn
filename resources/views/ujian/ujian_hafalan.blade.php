
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
$duration = 3*60;

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
                    </div>
                    <div class="card-toolbar">
                        <div style="color: black;font-size:20px" id="countdown"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body" style="height: 70vh;">
                            <h2>Di sediakan waktu 3 menit untuk menghapalkan kata-kata di bawah ini</h2>
                            <br>
                            <h4>
                            BUNGA : Soka   Larat   Flamboyan   Yasmin  Dahlia<br><br>
                            PERKAKAS : Wajan  Jarum   Kikir   Cangkul Palu<br><br>
                            BURUNG : Elang  Itik    Walet   Tekukur Nuri<br><br>
                            KESENIAN : Quintet    Arca    Opera   Gamelan Ukiran<br><br>
                            BINATANG : Musang Rusa    Beruang Zebra   Harimau<br><br>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        loadingDiactive()
        let total = 0;

        $(document).on('ready', function() {
            <?php  
            if($tipe_ujian->tipe_status==1){?>
                document.location.href = "app/ujian/selesai/<?=$reqId?>";
            <?php }
            ?>


            var slickCarousel = $('.your-class').slick({
                lazyLoad: 'ondemand', // ondemand progressive anticipated
                infinite: false,
                prevArrow: false, // Menonaktifkan tombol prev default
                nextArrow: false, // Menonaktifkan tombol next default
                draggable: false 
            });

            <?php if($ujianbaru==1){?>
             // reset localStorage
             clearInterval(x);
                localStorage.removeItem('remainingTime');
                remainingTime = <?php echo $duration; ?>;
                localStorage.setItem('remainingTime', remainingTime);
                x = setInterval(updateCountdown, 1000);
             // reset localStorage
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
                    var s_url= "Ujian/ujian_online_selesai_hafal/<?=$reqId?>";
                    $.ajax({'url': s_url,'success': function(msg) {
                        if(msg == ''){}
                        else
                        {
                            Swal.fire({
                                    text: 'Waktu Menghafal Habis, Silahkan Lanjut ke Ujian ',
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function() {
                                    document.location.href = "app/ujian/ujian_online/<?=$reqId?>";
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
            var x = setInterval(updateCountdown, 1000);
            // waktu end

        
        });

        


        // Fungsi untuk memeriksa apakah tombol Back atau Next perlu disembunyikan
        function loadingActive () {
            var loadingScreen = document.getElementById("loading-screen");
            var mainContent = document.getElementById("main-content");

            $('#loading-screen').show();
            mainContent.style.display = "block";  // Show main content

            document.body.style.overflow = "auto"; // Enable scrolling
            console.log('xxx')
        };

        function loadingDiactive() {
            var loadingScreen = document.getElementById("loading-screen");
            $('#loading-screen').hide();
            console.log('yyy')
        }
    </script>

@endsection
