<?php
$reqIdVal='';
if (!empty($reqId)){
    $reqIdVal=$reqId;
}
// echo $pg;exit;
// echo $iddll;exit;
?>
<div class="side-menu">
    <ul>
        <li <?php if($pg=='talenta_info_pegawai'){ echo 'class="activeSide"';} ?>><a href='app/manajemen_talenta/talenta_info_pegawai/<?=$reqIdVal?>'>Identitas Peserta</a></li>
        <li <?php if($pg=='skp'){ echo 'class="activeSide"';} ?> ><a href='app/talenta/skp/<?=$reqIdVal?>' >SKP</a></li>
        <li <?php if($pg=='pendidikan'){ echo 'class="activeSide"';} ?> ><a href='app/talenta/pendidikan/<?=$reqIdVal?>' >Riwayat Pendikan</a></li>
        <li <?php if($pg=='huknis'){ echo 'class="activeSide"';} ?> ><a href='app/talenta/huknis/<?=$reqIdVal?>' >Riwayat Huknis</a></li>
        <li <?php if($pg=='assesment'){ echo 'class="activeSide"';} ?> ><a href='app/talenta/assesment/<?=$reqIdVal?>' >Riwayat Assesment</a></li>
        <li <?php if($pg=='penghargaan'){ echo 'class="activeSide"';} ?> ><a href='app/talenta/penghargaan/<?=$reqIdVal?>' >Riwayat Penghargaan</a></li>
    </ul>


</div>