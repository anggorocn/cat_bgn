<?php
$querySoal=json_decode(json_encode($querySoal), true);
$queryJawabanPeserta=json_decode(json_encode($queryJawabanPeserta), true);
?>
<style type="text/css">
    

.btn.btn-warning:disabled{
    background-color: #28a745 !important;
  border-color: #28a745 !important;
}
</style>
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
                        <h3 class="card-label">Hasil Ujian</h3>
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body" style="height:60vh; overflow: scroll;">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <h1> Ujian Berakhir</h1>
                                <h3> Berikut adalah rekap soal yang terjawab </h3>
                            </div>
                            <div class="col-lg-12" style="text-align:right;">
                                <div class="row">
                                    <div class="col-lg-4" style="text-align: right;"></div>
                                    <div class="col-lg-2" style="text-align: right;">
                                        <div class="row">
                                            <button type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;width: 25%;" disabled><h3></h3></button> 
                                            <span style="padding:15px">Sudah Terjawab</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <button type="button" class="btn btn-danger font-weight-bold mr-2" style="margin: 10px;width: 25%;" disabled><h3></h3></button>
                                            <span style="padding:15px">Belum Terjawab</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                $totalterjawab=0;
                                for($i=0; $i<count($querySoal);$i++){
                                    $classbtn='btn-danger';
                                    $bank_soal_id=$querySoal[$i]['bank_soal_id'];
                                    if(!empty($queryJawabanPeserta)){
                                        $arrayJawabanPeserta=StringFunc::in_array_column($bank_soal_id, 'bank_soal_id', $queryJawabanPeserta);
                                        if(count($arrayJawabanPeserta)!=0){
                                            $classbtn='btn-warning';
                                            $totalterjawab++;
                                        }
                                    }
                                    ?>
                                    <div class="col-lg-2" style="width:10% !important;max-width: 10%;">
                                        <button type="button" class="btn <?=$classbtn?> font-weight-bold mr-2" style="margin: 10px;width: 100%;" disabled><h3><?=$i+1?></h3></button>
                                    </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align:center;">
                                <a onclick="home()" class="btn btn-warning font-weight-bold mr-2"><h3>Kembali Ke Home</h3></a>
                                <a onclick="selanjutnya()"class="btn btn-warning font-weight-bold mr-2"><h3>Lanjutkan Ujian</h3></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function selanjutnya() {
            window.location.href='app/ujian/pilihujian';
        }

        function home() {
            window.location.href='app/';
        }
    </script>

@endsection