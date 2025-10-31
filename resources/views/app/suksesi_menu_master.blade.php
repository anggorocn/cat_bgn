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
        <li <?php if($pg=='master_rumpun'){ echo 'class="activeSide"';} ?>><a href='app/suksesi/bobotpenilaian'>Rumpun Jabatan</a></li>
        <li <?php if($pg=='master_jabatan'){ echo 'class="activeSide"';} ?> ><a href='app/suksesi/masterjabatan'>Jabatan</a></li>
        <li <?php if($pg=='master_penilaian'){ echo 'class="activeSide"';} ?> ><a href='app/suksesi/masterpenilaian'>Unsur Penilaian</a></li>
    </ul>


</div>