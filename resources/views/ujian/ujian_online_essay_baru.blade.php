
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
<div id="main-content" style="display: none;">
<!--     <h1>Welcome to the Main Page</h1>
    <p>This is the main content of the page.</p> -->
</div>
</style>
<?php
// print_r($tipe_ujian);exit;
$user=Session::get('user');

// Menentukan waktu akhir countdown jika belum ada di localStorage
$duration = 100000*60;

?>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="libraries/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Ujian <?=$tipe_ujian->nama?></h3>
                </div>
                <div class="card-toolbar">
                    <div style="color: black;" id="countdown"></div>
                </div>
            </div>
            <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="file" name="reqLinkFile" class="form-control" style="width: 90%; margin:10px 5%;" >
                    </div>
                    <div class="col-lg-3">
                        <input type="hidden" name="reqId" value="{{$reqId}}">
                        <input type="hidden" name="reqFileJenisKode" value="<?=$tipe_ujian->kode?>">

                        <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-success font-weight-bold mr-2"  style="margin:10px 5%;">Simpan</button>
                        <a href="<?=$tipe_ujian->link_jawaban?>" target="_blank" class="btn btn-primary font-weight-bold mr-2"  style="margin:10px 0px;">lihat</a>
                        <a href="app/ujian/pilihujianessay" class="btn btn-warning font-weight-bold mr-2"  style="margin:10px 0px;">Kembali</a>
                    </div>
                    <div class="col-lg-12">
                        <div class="card-body" style="height: 70vh;">
                            <embed type="application/pdf" src="<?=$tipe_ujian->link_file?>" width="100%" height="100%"></embed>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    loadingDiactive()

    $(document).on('ready', function() { 
         // reset localStorage
         clearInterval(x);
            localStorage.removeItem('remainingTime');
            remainingTime = <?php echo $duration; ?>;
            localStorage.setItem('remainingTime', remainingTime);
            x = setInterval(updateCountdown, 1000);
         // reset localStorage


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
                return false
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
        // console.log('xxx')
    };

    function loadingDiactive() {
        var loadingScreen = document.getElementById("loading-screen");
        $('#loading-screen').hide();
        // console.log('yyy')
    }

    var url = "Ujian/addUpload";

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
                                document.location.href = "app/ujian/ujian_online_essay/<?=$reqId?>";
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
</script>

@endsection
