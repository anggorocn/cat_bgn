<?php
$query=json_decode(json_encode($query), true);
// print_r($query);exit;
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
                    <tbody class="example altrowstable" id="alternatecolor"> 
                          <tr>
                              <th style="width: 20%">Nama Ujian</th>
                              <th style="width: 10%">Kode Ujian</th>
                              <th>Jawaban Peserta</th>
                          </tr>
                          <?php
                          for($i=0; $i<count($query);$i++){?>
                            <tr>
                                <td style="width: 20%"><?=$query[$i]['nama_penggalian']?></td>
                                <td style="width: 10%"><?=$query[$i]['kode_penggalian']?></td>
                                <td><?=$query[$i]['jawaban']?></td>
                            </tr>
                          <?php
                            }
                          ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
