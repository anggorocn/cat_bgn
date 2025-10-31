<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
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

#canvas_container{
/*    width:1250px;*/
    height: calc(100vh - 350px);;
    overflow: auto; 
    background:#333;
    text-align:center; 
    border: 3px solid #333
}

#pdf-viewer {
    height: calc(100vh - 350px);
    overflow: auto; 
    background:#333;
    text-align:center; 
    border: 3px solid #333
   }
.button-container {
        height: 55px;
        padding-top:20px;
        justify-content: space-between;
        width: 100%;
        text-align: center;
        background-color: #333;
    }
    .pdf-button {
        cursor: pointer;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }
    .pdf-button:hover {
        background-color: #0056b3;
    }

</style>
<div id="loading-screen">
    <div class="spinner"></div>
    <p>Loading...</p>
</div>
<div id="main-content" style="display: block;">
<!--     <h1>Welcome to the Main Page</h1>
    <p>This is the main content of the page.</p> -->
</div>
</style>
<?php
// print_r($jawabanessay);exit;
$reqJawaban_id=$reqJawaban='';
if(!empty($jawabanessay)){
   $reqJawaban_id= $jawabanessay->essay_jawaban_id;
   $reqJawaban= $jawabanessay->jawaban;
}
$user=Session::get('user');

// Menentukan waktu akhir countdown jika belum ada di localStorage
$duration = 90*60;

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
                    <h3 class="card-label">Ujian Essay</h3>
                </div>
                <div class="card-toolbar">
                    <div style="color: black;" id="countdown"></div>
                </div>
            </div>
            <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body" style="height: 70vh;">                            
                            <div id="my_pdf_viewer">               
                                <div id="pdf-viewer" style="height: 55vh;"></div>
                            </div>

                             <div class="button-container">
                                <a id="zoom-in" class="pdf-button">Zoom In</a>
                                <a id="zoom-out" class="pdf-button">Zoom Out</a>
                                <!-- <a id="rotate" class="pdf-button">Rotate</a>  -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        
                        <a onclick="terjawab(0)" class="btn btn-primary font-weight-bold mr-2">Simpan</a>
                        <a onclick="kembali()" class="btn btn-warning font-weight-bold mr-2">Kembali</a>
                        <button type="button" id="ktloginformsubmitbutton"  class="btn btn-success font-weight-bold mr-2">Kirim Jawaban</button>
                        
                        <input type="hidden" name="reqId" id="reqId" value="{{$reqId}}">
                        <input type="text" name="reqJawaban_id" id="reqJawaban_id" value="<?=$reqJawaban_id?>" style="display:none">
                        <input type="hidden" name="reqSubmit" id="reqSubmit" value="1">
                        <br>
                        <textarea class="form-control" style="width:90%; height: 80%;" name="reqJawaban" id="reqJawaban"><?=$reqJawaban?></textarea>
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
         // clearInterval(x);
         //    localStorage.removeItem('remainingTime');
         //    remainingTime = <?php echo $duration; ?>;
         //    localStorage.setItem('remainingTime', remainingTime);
         //    x = setInterval(updateCountdown, 1000);
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
                // Hapus remainingTime dari localStorage setelah timer selesai
                // return false;
                var s_url = "Ujian/essayJawaban";
                var reqJawaban = $('#reqJawaban').val();
                var reqSubmit = $('#reqSubmit').val();
                var reqId = $('#reqId').val();
                var reqJawaban_id = $('#reqJawaban_id').val();
                $.ajax({
                    url: s_url,
                    method: 'POST', // Make sure to use POST if sending data
                    data: {
                        // Send the data as part of the request
                        reqJawaban: reqJawaban,
                        reqId: reqId,
                        reqSubmit: reqSubmit,
                        reqJawaban_id: reqJawaban_id
                    },
                    success: function(msg) {
                        if (msg == '') {
                            // If no message is returned, log to console
                            console.log('No response received');
                        } else {
                            // Show SweetAlert if message is returned
                            Swal.fire({
                                text: 'Waktu Habis, Silahkan Lanjut ke Ujian Selanjutnya',
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                // Redirect if needed after Swal closes (uncomment the lines below if needed)
                                // var redirectUrl = "app/ujian/selesai/<?=$reqId?>";
                                // console.log("Redirecting to:", redirectUrl);
                                // window.location.href = redirectUrl; // Uncomment to redirect
                                document.location.href = "app/ujian/pilihujian";
                                return;false;
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        console.log("Error: " + error);
                    }
                });

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

    var url = "Ujian/essayJawaban";

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('ktloginform');
    const formSubmitButton = document.getElementById('ktloginformsubmitbutton');
    const formSubmitUrl = url; // Ganti dengan URL sebenarnya
    const _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

    if (!form || !formSubmitButton) return;

    // Jika pakai FormValidation.js dari Metronic
    const fv = FormValidation.formValidation(form, {
        fields: {
            nama: {
                validators: {
                    notEmpty: {
                        message: 'Nama wajib diisi'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap()
        }
    });

    formSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin mengirim data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim!',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        // Show loading
                        formSubmitButton.disabled = true;
                        formSubmitButton.innerHTML = '<span class="' + _buttonSpinnerClasses + '"></span> Mohon tunggu...';

                        const formData = new FormData(form);

                        fetch(formSubmitUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]')?.content || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message?.startsWith('xxx')) {
                                Swal.fire('Error', data.message, 'error');
                            } else {
                                Swal.fire({
                                    text: data.message || 'Data berhasil disimpan!',
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-light-primary font-weight-bold'
                                    },
                                    buttonsStyling: false
                                }).then(() => {
                                    window.location.href = "app/ujian/pilihujian";
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error", "Terjadi kesalahan saat mengirim data.", "error");
                            console.error(error);
                        })
                        .finally(() => {
                            formSubmitButton.disabled = false;
                            formSubmitButton.innerHTML = 'Kirim Jawaban';
                        });
                    }
                });
            } else {
                Swal.fire({
                    text: "Cek kembali isian form kamu.",
                    icon: "error",
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-light-danger font-weight-bold"
                    },
                    buttonsStyling: false
                });
            }
        });
    });
});

</script>


<script type="text/javascript">
    var pdfViewer = document.getElementById('pdf-viewer');
    var pdfDoc = null,
        currentPage = 1,
        scale = 1; // Default scale
    var rotation = 0; // Default rotation

    function renderPDF(pdfDoc) {
        if (!pdfDoc) return; // Exit if no PDF document is loaded

        pdfViewer.innerHTML = ''; // Clear previous content
        for (var pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            pdfDoc.getPage(pageNum).then(function(page) {
                var viewport = page.getViewport({ scale: scale, rotation: rotation });
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                pdfViewer.appendChild(canvas);

                page.render({ canvasContext: context, viewport: viewport });
            }).catch(function(error) {
                console.error('Error rendering page:', error);
            });
        }
    }

    function loadPDF(url) {
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            renderPDF(pdfDoc);
        }).catch(function(error) {
            console.error('Error loading PDF:', error);
        });
    }

    document.getElementById('zoom-in').addEventListener('click', function() {
        scale += 0.25;
        renderPDF(pdfDoc);
    });

    document.getElementById('zoom-out').addEventListener('click', function() {
        scale = Math.max(1, scale - 0.25); // Prevent scale from going below 1
        renderPDF(pdfDoc);
    });

    // document.getElementById('rotate').addEventListener('click', function() {
    //     rotation += 90; // Rotate in increments of 90 degrees
    //     if (rotation >= 360) rotation = 0; // Reset rotation after 360 degrees
    //     renderPDF(pdfDoc);
    // });
 
    loadPDF("../../../template_soal/<?=$soalessay->kegiatan_file_file?>");

    function terjawab(loading) {
        // Build URL with PHP variables inside
        var s_url = "Ujian/essayJawaban";
        var reqJawaban = $('#reqJawaban').val();
        var reqId = $('#reqId').val();
        var reqJawaban_id = $('#reqJawaban_id').val();
        $.ajax({
            url: s_url,
            method: 'POST', // Make sure to use POST if sending data
            data: {
                // Send the data as part of the request
                reqJawaban: reqJawaban,
                reqId: reqId,
                reqJawaban_id: reqJawaban_id
            },
            success: function(msg) {
                if (msg == '') {
                    // If no message is returned, log to console
                    console.log('No response received');
                } else {
                    if(loading!=1){
                        // Show SweetAlert if message is returned
                        Swal.fire({
                            text: 'data tersimpan',
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            // Redirect if needed after Swal closes (uncomment the lines below if needed)
                            // var redirectUrl = "app/ujian/selesai/<?=$reqId?>";
                            // console.log("Redirecting to:", redirectUrl);
                            // window.location.href = redirectUrl; // Uncomment to redirect
                        });
                    }
                    else{
                        // console.log('autosave berhasil')
                    }
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error
                console.log("Error: " + error);
            }
        });
    }

    function kembali() {
        // Build URL with PHP variables inside
        var s_url = "Ujian/essayJawaban";
        var reqJawaban = $('#reqJawaban').val();
        var reqId = $('#reqId').val();
        var reqJawaban_id = $('#reqJawaban_id').val();
        $.ajax({
            url: s_url,
            method: 'POST', // Make sure to use POST if sending data
            data: {
                // Send the data as part of the request
                reqJawaban: reqJawaban,
                reqId: reqId,
                reqJawaban_id: reqJawaban_id
            },
            success: function(msg) {
                if (msg == '') {
                    // If no message is returned, log to console
                    console.log('No response received');
                } else {
                    // Show SweetAlert if message is returned
                        // Redirect if needed after Swal closes (uncomment the lines below if needed)
                        // var redirectUrl = "app/ujian/selesai/<?=$reqId?>";
                        // console.log("Redirecting to:", redirectUrl);
                        window.location.href = '/app/ujian/pilihujian'; // Uncomment to redirect
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error
                console.log("Error: " + error);
            }
        });
    }

    $(document).ready(function(){
       $('#reqJawaban').on("cut copy paste",function(e) {
          e.preventDefault();
       });
       setInterval(() => terjawab(1), 10000);
    });
</script>

@endsection
