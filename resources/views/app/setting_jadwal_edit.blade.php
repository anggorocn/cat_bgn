<?php
$reqIdVal='';
if (!empty($reqId)){
    $reqIdVal=$reqId;
}
// echo $IdentitasUjian->tipe_formula;exit;
// echo $iddll;exit;
$query=json_decode(json_encode($query), true);
// print_r($query);exit;

if($IdentitasUjian->tipe_formula==1){
?>
<div class="side-menu">
    <ul>
        <li <?php if($pg=='setting_jadwal_add'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/add/<?=$reqIdVal?>'>Home</a></li>
        <li <?php if($pg=='setting_jadwal_kelompok'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/kelompok/<?=$reqIdVal?>'>Setting Kelompok</a></li>
        <!-- <li <?php if($pg=='setting_jadwal_absensi'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/absensi/<?=$reqIdVal?>'>Absensi Pegawai</a></li> -->
        <li <?php if($pg=='setting_jadwal_acara'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/acara/<?=$reqIdVal?>'>Jadwal Acara</a></li>
        <li <?php if($pg=='setting_jadwal_asesor'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/asesor/<?=$reqIdVal?>'>Jadwal Asesor</a></li>
        <li <?php if($pg=='setting_jadwal_pegawai'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/pegawai/<?=$reqIdVal?>'>Jadwal Asesi</a></li>
        <li <?php if($pg=='setting_jadwal_upload'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/upload/<?=$reqIdVal?>'>Ujian Essay</a></li>
        <?php
        if(!empty($cekTabel)){
            for($i=0; $i<count($query); $i++){?>
                <li <?php if($pg=='setting_jadwal_hasil' && $iddll==$query[$i]['tipe_ujian_id']){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/hasil/<?=$reqIdVal?>/<?=$query[$i]['tipe_ujian_id']?>'>Hasil <?=$query[$i]['nama_ujian']?></a></li>
            <?php 
            }
        }?>
        <li <?php if($pg=='setting_jadwal_rekap_upload'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/rekap_upload/<?=$reqIdVal?>'>Rekap Ujian Essay</a></li>


    </ul>


</div>
<?php
}
else{?>

<div class="side-menu">
    <ul>
        <li <?php if($pg=='setting_jadwal_add'){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/add/<?=$reqIdVal?>'>Home</a></li>
        <?php
        if(!empty($cekTabel)){
            for($i=0; $i<count($query); $i++){?>
                <li <?php if($pg=='setting_jadwal_hasil' && $iddll==$query[$i]['tipe_ujian_id']){ echo 'class="activeSide"';} ?>><a href='app/setting_jadwal/hasil/<?=$reqIdVal?>/<?=$query[$i]['tipe_ujian_id']?>'>Hasil <?=$query[$i]['nama_ujian']?></a></li>
            <?php 
            }
        }?>
    </ul>
</div>

<?php
}?>