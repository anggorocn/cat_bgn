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
        <li <?php if($pg=='bobot_penilaian'){ echo 'class="activeSide"';} ?>><a href='app/suksesi/bobotpenilaian'>Bobot Penilaian</a></li>
        <li <?php if($pg=='jabatan_target'){ echo 'class="activeSide"';} ?> ><a href='app/suksesi/jabatantarget'>Jabatan Target</a></li>
    </ul>


</div>