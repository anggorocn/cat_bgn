<?php
$queryUjian=json_decode(json_encode($queryUjianHasil), true);
$tanggal=explode(' ', $queryJadwal->tanggal_tes);
$tanggal=$tanggal[0];
// print_r($queryUjian);exit;
?>
@extends('asesor/index') 
@section('content')
<div class="d-flex flex-column-fluid">        
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Identitas Peserta Cat </h3>
                </div>
            </div>
            <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div style="background-color: #CFE3F8;height: 58vh;border-radius: 20px;">
                                <div style="background-color: #eaf1fb;height: 25vh;border-radius: 20px;text-align: center;">
                                    <div class="area-profil">
                                        <div class="foto" style="margin:20px calc(50% - 35px);"><img src="../../assets/media/users/300_21.jpg"></div>
                                    </div>
                                    <?=$query->nama?><br>
                                    <?=$query->nip_baru?>
                                </div>
                                <div style="margin:10px">                                        
                                    <b>Pangkat / Gol.Ruang:</b><br>
                                    <?=$query->eselon_nama?><br>
                                    <hr style="margin:5px 0px">
                                    <b>Jabatan:</b><br>
                                    <?=$query->last_jabatan?><br>
                                    <hr style="margin:5px 0px">
                                    <b>Assesment:</b><br>
                                    <?=$queryJadwal->acara?><br>
                                    <hr style="margin:5px 0px">
                                    <b>Tanggal:</b><br>
                                    <?=$tanggal?>
                                </div>                                    
                            </div>
                        </div>
                        <div class="col-md-8"> 
                            <div style="background-color: #CFE3F8;height: 58vh;border-radius: 20px;padding: 20px; overflow: scroll;"> 
                                <div class="row" style=" line-height: 3.2;">
                                    <div class="col-md-12"><h3><b>Data Peserta</b></h3></div>
<!--                                     <div class="col-md-2">Data Pribadi</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/generate-datadiri/<?=$query->pegawai_id?>" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>                                     -->
                                    <div class="col-md-2">Laporan Individu</div>
                                    <div class="col-md-2">:
                                        <a target="_blank" href="app/asesor/generate-laporanindividu/<?=$query->pegawai_id?>" class="btn btn-warning font-weight-bold mr-2" style="padding: 5px 15px;">
                                            <i class="fa fa-download"  style="padding: 0px;"></i></a>
                                    </div>
                                    <?php
                                    if(!empty($queryCekFile->limit_drh)){?>

                                        <div class="col-md-12" style="margin-top: 20px;"><h3><b>Data Pra Assesment</b></h3></div>
                                        <div class="col-md-2">DRH</div>
                                        <div class="col-md-2">:
                                            <?php
                                            $infolinkfile='uploads/drh/'.$queryJadwal->jadwal_awal_tes_id.'/'.md5($queryJadwal->jadwal_awal_tes_id.'-'.$reqPegawaiId).".docx";
                                            // print_r($reqId.'/'.$reqPegawaiId);
                                            if(file_exists($infolinkfile)){?>
                                                <a  href="uploads/drh/<?=$queryJadwal->jadwal_awal_tes_id?>/<?=md5($queryJadwal->jadwal_awal_tes_id.'-'.$reqPegawaiId)?>.docx" class="btn btn-success font-weight-bolder" style="margin-right:10px;" target="_blank">
                                                    Lihat DRH
                                                </a>
                                                <input type="hidden" id="filecek" value="1">
                                            <?php  
                                            }
                                            else{?>
                                                Belum Uplod DRH
                                            <?php 
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if(!empty($queryCekFile->link_pe)){?>
                                            <div class="col-md-2">PE</div>
                                            <div class="col-md-2">:
                                                <?php
                                                $infolinkfile='uploads/pe/'.$queryJadwal->jadwal_awal_tes_id.'/'.md5($queryJadwal->jadwal_awal_tes_id.'-'.$reqPegawaiId).".docx";
                                                // print_r($reqId.'/'.$reqPegawaiId);
                                                if(file_exists($infolinkfile)){?>
                                                    <a  href="uploads/pe/<?=$queryJadwal->jadwal_awal_tes_id?>/<?=md5($queryJadwal->jadwal_awal_tes_id.'-'.$reqPegawaiId)?>.docx" class="btn btn-success font-weight-bolder" style="margin-right:10px;" target="_blank">
                                                        Lihat PE
                                                    </a>
                                                    <input type="hidden" id="filecek" value="1">
                                                <?php  
                                                }
                                                else{?>
                                                    Belum Uplod DRH
                                                <?php 
                                                }
                                                ?>
                                            </div>
                                        <?php }
                                    }?>
                                    <div class="col-md-12" style="margin-top: 20px;"><h3><b>Hasil Ujian Peserta</b></h3></div>
                                    <?php
                                    for($i=0; $i<count($queryUjian); $i++){?>
                                        <div class="col-md-2"><?=$queryUjian[$i]['nama']?></div>
                                        <div class="col-md-10">:   <?=$queryUjian[$i]['hasil']?></div>
                                    <?php }?>

                                    <!-- <div class="col-md-2">JPM Potensi</div>
                                    <div class="col-md-4">:   62.07</div>
                                    <div class="col-md-2">JPM Kompetensi</div>
                                    <div class="col-md-4">:   102.78</div>
                                    <div class="col-md-2">JPM Final</div>
                                    <div class="col-md-4">:   90.57</div>
                                    <div class="col-md-2">IKK</div>
                                    <div class="col-md-4">:   9.43</div>
                                    <div class="col-md-2">Kuadran</div>
                                    <div class="col-md-4">:   I (Tingkatkan Kompetensi)</div>
                                    <div class="col-md-2">Rekomendasi</div>
                                    <div class="col-md-4">:   Tingkatkan Kompetensi</div>
                                    <div class="col-md-2">Cetak Psikogram</div>
                                    <div class="col-md-10">:  
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i>Sederhana</a>        
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i>Sederhana V2</a>        
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i>Sedang</a>        
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i>Kompleks</a>   
                                    </div>
                                    <div class="col-md-2">Cetak Ringkasan</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">Data Pribadi</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">Critical Incident</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">Q-Inta</div>                                        
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">Q-Kom Eselon</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">In Tray</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>                                        
                                    <div class="col-md-2">Data Pendukung</div>
                                    <div class="col-md-2">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">Detil Pegawai</div>                                        
                                    <div class="col-md-6">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div class="col-md-2">Hasil File Test</div>
                                    <div class="col-md-10">:
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i>Intray / In-basket</a>
                                        <a href="app/asesor/identitascat/1" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-download"></i>Proposal Writing</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function openDirektorat(id)
    {
        openAdd('/app/asesor/hasilujian/<?=$queryJadwal->jadwal_tes_id?>');
    }
</script>
@endsection
