<?php
$querySoal=json_decode(json_encode($querySoal), true);
for($index_data=0; $index_data < count($querySoal); $index_data++)
{
    $id=$querySoal[$index_data]["bank_soal_id"];
    $pertanyaan=$querySoal[$index_data]["pertanyaan"];
    $arrData[$id]['pertanyaan']=$pertanyaan ;
    $arrData[$id]['jawaban']= '';
    $arrData[$id]['grade_prosentase']= '';
}

$queryJawabanPegawai=json_decode(json_encode($queryJawabanPegawai), true);
for($index_data=0; $index_data < count($queryJawabanPegawai); $index_data++)
{
    $id=$queryJawabanPegawai[$index_data]["bank_soal_id"];
    $grade_prosentase=$queryJawabanPegawai[$index_data]["grade_prosentase"];
    $jawaban=$queryJawabanPegawai[$index_data]["jawaban"];
    // print_r($grade_prosentase);exit;

    $arrData[$id]['jawaban']= $jawaban;
    $arrData[$id]['grade_prosentase']= $grade_prosentase;
}
// print_r($arrData);exit;

?>
@extends('app/index_lookup') 
@section('content')

<link href="assets/jquery-easyui-1.4.2/themes/default/easyui.css" rel="stylesheet" type="text/css" />
<link href="assets/jquery-easyui-1.4.2/themes/icon.css" rel="stylesheet" type="text/css" />
<script src="assets/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/jquery-easyui-1.4.2/themes/default/easyui.css">
<script src="assets/js/jquery-ui.js"></script>

<div class="d-flex flex-column-fluid" style="margin-top: 20px">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">Jawaban Peserta</h3>
                </div>
            </div>
            <div class="card-body" style="height:80vh; overflow: scroll;">
                <table id='customers'>
                    <tr>
                        <th>No </th>
                        <th>Soal </th>
                        <th>Jawaban</th>
                        <th>Skor</th>
                    </tr>
                    <?php
                    $i=1;
                    foreach ($arrData as $key => $item) {?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$item['pertanyaan']?></td>
                            <td><?=$item['jawaban']?></td>
                            <td><?=$item['grade_prosentase']?></td>
                        </tr>
                    <?php 
                        $i++;
                    }?>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
