<?php
$reqId=$reqNip=$reqNama=$reqPhone=$reqJabatan=$reqUnitKerjaNama=$reqIdDirektorat=$reqNamaDirektorat=$reqJenisPegawai=$reqEmail=$reqUnitKerjaId=$selected=$reqView= $readonly='';

if (!empty($query))
{
  $reqId=$query->pegawai_id ;
  $reqNip=$query->nip ;
  $reqNama=$query->nama ;
  $reqJabatan=$query->jabatan;
  $reqUnitKerjaId=$query->satuan_kerja_id;
  $reqUnitKerjaNama=$query->satuan_kerja;
  $reqIdDirektorat=$query->departemen_id;
  $reqNamaDirektorat=$query->departemen;
  $reqJenisPegawai=$query->jenis_pegawai;
  $reqEmail=$query->email;
  $reqPhone=$query->phone;

}

if($reqView=='view')
{
    $reqDisabled='disabled';
}

$readonly= "";
$style= "";

$reqMode='insert';

if(!empty($reqId))
{
    $reqMode='update';
    $readonly= 'readonly';
    $style= 'background-color: #F3F6F9';
}

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
                        <h3 class="card-label">Form Persetujuan</h3>
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body" style="color: black;">
                        <div class="form-group row">
                            <ol>
                                <li>Soal ujian dalam bentuk pilihan ganda dan atau essay.</li>
                                <li>Waktu tes tidak dapat dihentikan</li>
                                <li>Jika waktu tes masih tersisa, Saudara dapat merubah jawaban jika diperlukan.</li>
                                <li>Jika waktu tes telah habis, Saudara tidak dapat melanjutkan pengerjaan soal tes.</li>
                                <li>Pastikan seluruh soal telah dijawab </li>
                                <li>Tes hanya dapat dilakukan satu kali. </li>
                                <li>Kerjakan setiap soal dengan tenang. </li>
                            </ol>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="reqMode" value="{{$reqMode}}">
                                <input type="hidden" name="reqId" value="{{$reqId}}">
                                <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button>
                                <button onclick="selanjutnya()" type="button" class="btn btn-warning font-weight-bold mr-2" style="  float: right;">Selanjutnya</button>
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
            window.location.href='app/ujian/persiapan';
        }
    </script>

@endsection