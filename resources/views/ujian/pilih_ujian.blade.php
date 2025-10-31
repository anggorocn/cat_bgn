<?php
$arrTipeUjian =json_decode(json_encode($tipe_ujian), true);
$soalessay =json_decode(json_encode($soalessay), true);
$dikerjakanEssay='';
$sudah=0;
// print_r($soalessay);exit;
for( $i=0; $i<count($soalessay);$i++){
    if($soalessay[$i]['status']=='tersimpan'){
        $dikerjakanEssay='sudah';
    }
    if($soalessay[$i]['status']=='tersubmit'){
        $sudah++;
    }
}

$essaySelesai='';
if($sudah==count($soalessay)){
    $essaySelesai='selesai';
}
// echo $sudah;exit;

$batas=$query->kompetensi_tanggal_selesai;
$tempUjianId=$identitas->ujian_id;
?>
@extends('ujian/index_ujian') 
@section('content')
    <div class="d-flex flex-column-fluid" style="margin-top:25px">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-supermarket text-primary"></i>
                        </span>
                        <h3 class="card-label">Tahapan Tes</h3>
                    </div>
                    <div class="card-toolbar">
<!--                         <a href="{{url('app/ujian/pilihujianessay/')}}" class="btn btn-primary font-weight-bolder">
                            Ujian Essay
                        </a> -->
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body" style="overflow: scroll;height: 60vh;">
                        <!-- <button type="button" class="btn btn-success font-weight-bold mr-2" style="margin: 10px;" disabled><h3>Contoh Ujian Selesai</h3></button> -->
                        <br>

                        <?php 
                        $totalselesai=0;
                        if (!empty($arrTipeUjian)){
                            if($query->tipe_formula==1){?>
                                <h3 class="card-label">Ujian CBT 1</h3>
                            <?php }
                            else{?>
                                <h3 class="card-label"> Ujian Kompetensi Manajerial Sosial Kultural</h3>
                            <?php }?>
                            <!-- <button onclick="InfoUjian(12)" type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian cfit a bagian 1</h3></button> -->
                            <?php 
                            $i=1;
                            $dikerjakan=0;
                            foreach ($arrTipeUjian as $key => $value_hasil) {
                                if($value_hasil['tipe_status']==1){
                                    $totalselesai++;
                                    ?>
                                    <button disabled onclick="InfoUjian(<?=$value_hasil['ujian_tahap_id']?>,<?=$value_hasil['tipe_ujian_id']?>,<?=$i?>)" type="button" class="btn btn-success font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian <?=$i?> , Telah dikerjakan</h3></button><br>
                                    <?php
                                }
                                else if($dikerjakan==1){
                                    ?>
                                    <button onclick="InfoUjian(<?=$value_hasil['ujian_tahap_id']?>,<?=$value_hasil['tipe_ujian_id']?>,<?=$i?>)" type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px; background-color: gray ;border-color: gray;" disabled><h3>Ujian <?=$i?></h3></button>
                                <br>
                                <?php
                                $dikerjakan=1;
                                }
                                else{
                                    ?>
                                    <button onclick="InfoUjian(<?=$value_hasil['ujian_tahap_id']?>,<?=$value_hasil['tipe_ujian_id']?>,<?=$i?>)" type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian <?=$i?></h3></button>
                                <br>
                                <?php
                                $dikerjakan=1;
                                }
                                $i++;
                            } ?>
                            <!-- <button type="button" class="btn btn-success font-weight-bold mr-2" style="margin: 10px;" disabled><h3>Contoh Ujian Selesai</h3></button> -->
                            <br>
                        <?php 
                        }
                        if(!empty($soalessay)){
                        ?>
                            <h3 class="card-label">Ujian CBT 2</h3>
                            <span style="color: red;">batas pengerjaan sampai <?=$batas?> 23:59</span><br><br>
                            <!-- <button onclick="InfoUjian(12)" type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian cfit a bagian 1</h3></button> -->
                            <?php 
                            $no=1;
                            for( $i=0; $i<count($soalessay);$i++){
                                // if(!empty($soalessay[$i]['kegiatan_file_id'])){
                                    if($soalessay[$i]['status']=='tersubmit'){
                                    ?>    
                                        <a class="btn btn-success font-weight-bold mr-2" disabled style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?>, Telah DIkerjakan</h3></a><br>
                                    <?php
                                    }
                                    else if($soalessay[$i]['status']=='tersimpan'){
                                        if($soalessay[$i]['kode']=='PE'){
                                        ?>    
                                            <a href="app/ujian/ujian_online_essay_new_pe/<?=$soalessay[$i]['essay_soal_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?></h3></a><br>
                                    <?php
                                        }
                                        
                                        else if($soalessay[$i]['kode']=='ITR'){
                                        ?>
                                            <a href="app/ujian/ujian_online_essay_new_itr/<?=$soalessay[$i]['essay_soal_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?><?=$soalessay[$i]['kode']?></h3></a><br>
                                        <?php 
                                        }
                                        else{?>
                                            <a href="app/ujian/ujian_online_essay_new/<?=$soalessay[$i]['essay_soal_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?></h3></a><br>
                                        <?php }
                                    }
                                    else if($soalessay[$i]['status']=='kosong'){
                                        if($dikerjakanEssay=='sudah'){
                                        ?>    
                                            <a class="btn btn-warning font-weight-bold mr-2" style="margin: 10px; background-color: gray ;border-color: gray;" disabled><h3>Ujian Essay <?=$soalessay[$i]['nama']?></h3></a><br>
                                        <?php
                                        }
                                        else{
                                            if($soalessay[$i]['kode']=='PE'){
                                            ?>
                                                <a href="app/ujian/ujian_online_essay_new_pe/<?=$soalessay[$i]['essay_soal_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?></h3></a><br>
                                            <?php 
                                            }
                                            else if($soalessay[$i]['kode']=='ITR'){
                                            ?>
                                                <a href="app/ujian/ujian_online_essay_new_itr/<?=$soalessay[$i]['essay_soal_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?></h3></a><br>
                                            <?php 
                                            }
                                            else{?>
                                                <a href="app/ujian/ujian_online_essay_new/<?=$soalessay[$i]['essay_soal_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian Essay <?=$soalessay[$i]['nama']?></h3></a><br>
                                            <?php }
                                        }
                                    }
                                $no++;
                                // }
                            }
                        } ?>
                    </div>
                </form>
                 <?php
                if( $totalselesai==count($arrTipeUjian) && $essaySelesai=='selesai'){
                ?>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align:center;">
                                <!--<h3 style="color:black;">Seluruh Ujian Telah Selesai Dilakukan, Silahkan Kembali Ke Dashboard</h3>-->
                                <h3 style="color:black;">Seluruh Ujian Telah Selesai Dilakukan, Mohon Isi Feedback Berikut</h3>
                                <!-- Link Feedback -->
                                <a href="https://s.bps.go.id/MonevPelaksanaanAsesmen" target="_blank" class="btn btn-info font-weight-bold mr-2" style="margin-bottom:10px;">
                                    <h3>Isi Feedback Ujian</h3>
                                </a>
                                <!--<a onclick="selanjutnya()" class="btn btn-warning font-weight-bold mr-2"><h3>Dashboard</h3></a>-->
                            </div>
                        </div>
                    </div>
                <?php
                }?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function InfoUjian(tahapid,id,urutan) {
            openAdd('app/ujian/lookup/popup_ujian/'+id+'/'+tahapid+'/open/'+urutan);
        }

        function selanjutnya() {
            window.location.href='app/';
        }
    
        // Terima pesan dari iframe
        window.addEventListener("message", function(event) {
            if (event.data.action === "callMyFunction") {
                window.location.href='app/ujian/ujian_online/'+event.data.value;
                // alert("Fungsi di halaman utama dipanggil!"+event.data.value);
            }
        }, false);

    </script>

@endsection