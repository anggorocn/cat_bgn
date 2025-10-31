<?php
$arrTipeUjian =json_decode(json_encode($tipe_ujian), true);
// print_r($arrTipeUjian);exit;
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
                            <h3 class="card-label">Tahapan Tes Essay</h3>
                        </div>
                       <div class="card-toolbar">
                            <a href="{{url('app/ujian/pilihujian/')}}" class="btn btn-primary font-weight-bolder">
                                Ujian Psikotest
                            </a>
                        </div>
                    </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body" style="overflow: scroll;height: 75vh;">
                        <!-- <button type="button" class="btn btn-success font-weight-bold mr-2" style="margin: 10px;" disabled><h3>Contoh Ujian Selesai</h3></button> -->
                        <br>
                        <!-- <button onclick="InfoUjian(12)" type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian cfit a bagian 1</h3></button> -->
                        <?php for( $i=0; $i<count($arrTipeUjian);$i++){
                            if(empty($arrTipeUjian[$i]['link_jawaban'])){
                                ?>    
                                <a href="app/ujian/ujian_online_essay/<?=$arrTipeUjian[$i]['permohonan_file_id']?>"  type="button" class="btn btn-warning font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian <?=$arrTipeUjian[$i]['nama']?></h3></a>
                                <?php
                            }
                            else{?>
                                <a href="app/ujian/ujian_online_essay/<?=$arrTipeUjian[$i]['permohonan_file_id']?>"  type="button" class="btn btn-success font-weight-bold mr-2" style="margin: 10px;"><h3>Ujian <?=$arrTipeUjian[$i]['nama']?>, sudah terisi jawaban</h3></a>

                            <?php }?>
                            <br>
                        <?php
                        } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function InfoUjian(tahapid,id) {
            openAdd('app/ujian/lookup/popup_ujian/'+id+'/'+tahapid);
        }

        function selanjutnya() {
            window.location.href='app/ujian/persiapan';
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