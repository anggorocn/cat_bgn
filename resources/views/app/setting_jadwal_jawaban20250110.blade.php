<?php
    $query=json_decode(json_encode($query), true);
    $arr['jawaban_benar']=array();
    $arr['jawaban_benar_koreksi']=array();
    $arr['soal_lokasi']=array();
    $arr['soal_id']=array();
    $arr['jawaban_lokasi']=array();
    $arr['jawaban_lokasi_koreksi']=array();
    $arr['tipe_ujian_id']=array();
    $arr['tipe_ujian_nama']=array();
    $cekbanksoalid='';
    for($i=0; $i<count($query);$i++){
        if($cekbanksoalid!=$query[$i]['bank_soal_id']){
            $cekbanksoalid=$query[$i]['bank_soal_id'];

            $tipeujian=$query[$i]['tipe_ujian_id'];
            $tipeujiannama=$query[$i]['tipe'];
            
            array_push($arr['tipe_ujian_id'], $tipeujian);
            array_push($arr['tipe_ujian_nama'], $tipeujiannama);

            if($i!=0){
                array_push($arr['jawaban_lokasi'],$path_jawaban_gabung);
            }
            $jawaban=$query[$i]['nilai'];
            $bank_jawaban_id=$query[$i]['bank_jawaban_id'];
            $path_soal=$query[$i]['path_soal'];
            $path_jawaban=$query[$i]['path_jawaban'];
            $path_gambar=$query[$i]['path_gambar'];
            $path_gambar=str_replace("../main/uploads/","images/soal/",$path_gambar);
            $path_jawaban_gabung='<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 15%;">';
            $gas='';
            if($tipeujian!=9){
                if($jawaban!=0){
                    array_push($arr['jawaban_benar'], '<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 30%;">');
                }
            }
            else{
                if($jawaban!=0){
                    $index9 = array_search($bank_jawaban_id, $arr['jawaban_benar_koreksi']);
                    if(empty($gas)){
                        if ($index9 == false) {
                            $gas='<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 30%;">';
                            array_push($arr['jawaban_benar_koreksi'], $bank_jawaban_id);
                        }
                    }
                }
            }
            array_push($arr['soal_lokasi'], $path_gambar.''.$path_soal);
            array_push($arr['soal_id'], $query[$i]['bank_soal_id']);


        }
        else{
            $bank_jawaban_id=$query[$i]['bank_jawaban_id'];
            $jawaban=$query[$i]['nilai'];
            $tipeujian=$query[$i]['tipe_ujian_id'];
            $path_jawaban=$query[$i]['path_jawaban'];
            $path_gambar=$query[$i]['path_gambar'];
            $path_gambar=str_replace("../main/uploads/","images/soal/",$path_gambar);
            $index = array_search($path_gambar.''.$path_jawaban, $arr['jawaban_lokasi_koreksi']);
            if ($index !== false) {
                // echo "Elemen ditemukan pada indeks: $index"; // Output: Elemen ditemukan pada indeks: 2
            } else {
                
                $path_jawaban_gabung.='<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 15%;">';
                array_push($arr['jawaban_lokasi_koreksi'], $path_gambar.''.$path_jawaban);
            }            

            if($tipeujian!=9){
                if($jawaban!=0){
                    array_push($arr['jawaban_benar'], '<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 30%;">');
                }
            }
            else{
                if($jawaban!=0){
                    $index9 = array_search($bank_jawaban_id, $arr['jawaban_benar_koreksi']);
                    if ($index9 == false) {
                        if(empty($gas)){
                            $gas='<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 30%;">';
                            array_push($arr['jawaban_benar_koreksi'], $bank_jawaban_id);
                        }
                        else{
                            if($gas!='<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 30%;">'){
                                array_push($arr['jawaban_benar'], $gas.'<img src="'.$path_gambar.''.$path_jawaban.'" style="width: 30%;">');
                                array_push($arr['jawaban_benar_koreksi'], $bank_jawaban_id);
                                $gas='';
                            }
                        }
                    }
                }
            }  
        }

    }
    array_push($arr['jawaban_lokasi'],$path_jawaban_gabung);
    // print_r($arr);exit;
?>
@extends('app/index_lookup') 
@section('content')

<link href="assets/jquery-easyui-1.4.2/themes/default/easyui.css" rel="stylesheet" type="text/css" />
<link href="assets/jquery-easyui-1.4.2/themes/icon.css" rel="stylesheet" type="text/css" />
<script src="assets/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/jquery-easyui-1.4.2/themes/default/easyui.css">
<script src="assets/js/jquery-ui.js"></script>


<meta name="csrf_token" content="{{ csrf_token() }}" />
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
                <table id="customers">
                    <?php
                    $cektipe='';
                    $no=1;
                    for($i=0; $i<count($arr['soal_lokasi']);$i++){      
                        if($arr['tipe_ujian_id'][$i]!=$cektipe){?>
                                <tr>
                                    <th width="5%" colspan="4"><b><?= strtoupper($arr['tipe_ujian_nama'][$i])?></b></th>
                                    <!-- <th width="10%">jawaban Peserta</th> -->
                                </tr>
                            <?php
                            if($arr['tipe_ujian_id'][$i]==9){?>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="60%" colspan="2">Soal</th>
                                    <th width="20%">Jawaban Benar</th>
                                    <!-- <th width="10%">jawaban Peserta</th> -->
                                </tr>

                            <?php } else{?>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Soal</th>
                                    <th width="40%">Pilihan Jawaban</th>
                                    <th width="20%">Jawaban Benar</th>
                                    <!-- <th width="10%">jawaban Peserta</th> -->
                                </tr>
                                <?php
                            }
                            $cektipe=$arr['tipe_ujian_id'][$i];
                            $no=1;
                        }
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <?php
                        if($arr['tipe_ujian_id'][$i]==9){?>
                            <td colspan="2"><?=$arr['jawaban_lokasi'][$i]?></td>
                        <?php }
                        else{?>
                            <td><img src="<?=$arr['soal_lokasi'][$i]?>" style='width: 100%;'></td>
                            <td><?=$arr['jawaban_lokasi'][$i]?></td>
                        <?php }?>
                        <td><?=$arr['jawaban_benar'][$i]?></td>
                    </tr>
                    <?php
                        $no++;
                    }?>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
