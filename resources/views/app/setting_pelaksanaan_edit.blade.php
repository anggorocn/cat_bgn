<?php
$reqIdVal='';
if (!empty($reqId)){
    $reqIdVal=$reqId;
}

if($queryIdentitas->tipe_formula==1){?>

    
    <div class="side-menu">
        <ul>
            <li <?php if($reqView=='setting_pelaksanaan_add'){ echo 'class="activeSide"';} ?> ><a href='app/setting_pelaksanaan/add/<?=$reqIdVal?>'>Home</a></li>
            <?php if(!empty($reqIdVal)){?>
                <li <?php if($reqView=='setting_pelaksanaan_eselon'){ echo 'class="activeSide"';} ?>><a href="app/setting_pelaksanaan/eselon/<?=$reqIdVal?>">Penilaian Jabatan</a></li>
                <?php foreach ($query as $key => $value) {?>
                    <li <?php if($reqView=='setting_pelaksanaan_attribut' && $iddll==$value->formula_eselon_id){ echo 'class="activeSide"';} ?>><a href="app/setting_pelaksanaan/attribut/<?=$reqIdVal?>/<?=$value->formula_eselon_id?>">Attribut <?=$value->note?> <?=$value->nama?></a></li>
                <?php }?>
                <li <?php if($reqView=='setting_pelaksanaan_soal'){ echo 'class="activeSide"';} ?> ><a href='app/setting_pelaksanaan/soal/<?=$reqIdVal?>'>Simulasi Soal</a></li>
                <li <?php if($reqView=='setting_pelaksanaan_urutansoal'){ echo 'class="activeSide"';} ?> ><a href='app/setting_pelaksanaan/urutansoal/<?=$reqIdVal?>'>Urutan Soal</a></li>
            <?php }?>
        </ul>
    </div>
?
<?php
}
else{
?>
    <div class="side-menu">
        <ul>
            <li <?php if($reqView=='setting_pelaksanaan_add'){ echo 'class="activeSide"';} ?> ><a href='app/setting_pelaksanaan/add/<?=$reqIdVal?>'>Home</a></li>
            <?php if(!empty($reqIdVal)){?>
                <li <?php if($reqView=='setting_pelaksanaan_eselon'){ echo 'class="activeSide"';} ?>><a href="app/setting_pelaksanaan/eselon/<?=$reqIdVal?>">Penilaian Jabatan</a></li>
                <li <?php if($reqView=='setting_pelaksanaan_soal'){ echo 'class="activeSide"';} ?> ><a href='app/setting_pelaksanaan/soal_rapid/<?=$reqIdVal?>'>Simulasi Soal</a></li>
                <?php
                    if($queryIdentitas->tipe_formula==2){?>
                    <li <?php if($reqView=='setting_pelaksanaan_urutansoal'){ echo 'class="activeSide"';} ?> ><a href='app/setting_pelaksanaan/urutansoal/<?=$reqIdVal?>'>Urutan Soal</a></li>
                <?php }
            }?>
        </ul>
    </div>
<?php
}?>