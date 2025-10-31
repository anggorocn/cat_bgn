<?php
$query=json_decode(json_encode($query), true);
// print_r($query); exit;
?>
<div style="margin: 0px 20px; border: blue 0.5px solid;border-radius: 10px;height: 65vh;">
    <div class="card-header row" style="margin: 10px;">
        <div class="card-title" style="margin-bottom: 0rem;width: 75%;">
            <div class="row">
                <span class="card-icon">
                    <i class="flaticon2-notepad text-primary"></i>
                </span>
                <h3 class="card-label" style="color:black;width: 50%;margin-left: 25px;">List Acara</h3>
            </div>
        </div>  
    </div>
    <div class="card-body" style="height:45vh;overflow: scroll;">
        <div class="form-group row">
            <table id="customers">
                <tr>
                    <th>Penggalian</th>
                    <!--<th>Waktu</th>-->
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                for($i=0; $i<count($query);$i++){
                    $tanggal=explode(' ',$query[$i]['tanggal']) ;
                    $tanggal=$tanggal[0];
                    ?>
                    <tr <?php if($reqDetilId==$query[$i]['jadwal_acara_id']){ echo 'style="background-color: yellow;"';} ?> >
                        <td><?=$query[$i]['kode']?></td>
                        <!-- <td><?=$query[$i]['nama']?> (<?=$query[$i]['kode']?>)</td> -->
                        <!--<td><?=$tanggal?><br><?=$query[$i]['pukul1']?> s/d <?=$query[$i]['pukul2']?></td>-->
                        <td><?=$query[$i]['keterangan_acara']?></td>
                        <td>
                            <?php if($reqDetilId!=$query[$i]['jadwal_acara_id']){?> 
                                <a href='app/setting_jadwal/acara/<?=$reqId?>/<?=$query[$i]["jadwal_acara_id"]?>' class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-edit"></i></a>
                                <a onclick="deletedata(<?=$query[$i]["jadwal_acara_id"]?>)" class="btn btn-danger font-weight-bold mr-2"><i class="fa fa-trash"></i></a>
                            <?php }?>
                            <!-- <a type="submit"  class="btn btn-danger font-weight-bold mr-2"><i class="fa fa-trash"></i></a> -->
                        </td>
                    </tr>
                <?php }?>
            </table>
        </div>
    </div>
</div>