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
        <li <?php if($pg=='setting_awal_add'){ echo 'class="activeSide"';} ?>><a href='app/setting_awal/add/<?=$reqIdVal?>'>Home</a></li>
        <?php if(!empty($reqId)){?>
            <li <?php if($pg=='setting_awal_hapus_tanggal'){ echo 'class="activeSide"';} ?> ><a href='app/setting_awal/hapustanggal/<?=$reqIdVal?>' >Penghapusan Tanggal</a></li>
            <li <?php if($pg=='setting_awal_undangan'){ echo 'class="activeSide"';} ?> ><a href='app/setting_awal/undangan/<?=$reqIdVal?>'>Undang Peserta</a></li>
            <?php
            foreach ($query as $key => $value) 
            {
                $tanggal_tes=explode(' ', $value->tanggal_tes);
                ?>    
                <li <?php if($pg=='setting_awal_simulasi' && $iddll==$value->jadwal_tes_id){ echo 'class="activeSide"';} ?> ><a href='app/setting_awal/simulasi/<?=$reqIdVal?>/<?=$value->jadwal_tes_id?>'>Undang <?=DateFunc::getDayMonthYear($tanggal_tes[0])?></a></li>
                <?php 
            } 
        }?>
    </ul>


</div>