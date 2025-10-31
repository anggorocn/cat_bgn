<?php
$reqTanggalTes = explode(' ',$query->tanggal_tes);
?>
@extends('ujian/index_ujian') 
@section('content')
    <div class="d-flex flex-column-fluid" style="margin-top:25px">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Form Persiapan</h3>
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body"  style="color: black;">
                        <div class="form-group row" style="">
                            <ol>
                                <li>Pastikan anda menggunakan browser Firefox(Mozilla) / Chrome, dengan update terbaru.</li>
                                <li>Pastikan anda memiliki koneksi jaringan internet yang bagus, sehingga tidak ada kendala koneksi waktu Tes Online.</li>
                                <li>Jika anda sudah siap, tekan Tombol "SIAP IKUT UJIAN" untuk memulai tes online.</li>
                                <li>Jawablah pertanyaan dengan seksama dengan tenang, dikarenakan waktu yang diberikan tidak dapat dihentikan.</li>
                                <li>Anda dapat mereview kembali pertanyaan anda ketika waktu yang diberikan masih ada.</li>
                                <li>Jangan lupa berdoa agar semua tes berjalan lancar.</li>
                                <li>Jadwal Ujian Anda <b><?=DateFunc::getDayMonthYear($reqTanggalTes[0])?>, 00:00:01 s/d <?=DateFunc::getDayMonthYear($reqTanggalTes[0])?>, 23:59:59.</b></li>
                            </ol>
                            <div class="col-lg-12" style="text-align: center; padding: 20px;">
                                <div class="alert alert-warning" style="text-align: center;">
                                    Peringatan : Apabila anda telah siap melaksanakan ujian klik tombol "Mulai Ujian".
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button> -->
                                <button onclick="selanjutnya()" type="button" class="btn btn-warning font-weight-bold mr-2" style="  float: right;">Siap Ikut Ujian</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function kembali() {
            window.location.href='app/';
        }

        function selanjutnya() {
            window.location.href='app/ujian/pilihujian';
        }
    </script>

@endsection