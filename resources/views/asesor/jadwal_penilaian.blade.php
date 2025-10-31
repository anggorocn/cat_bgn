<?php 
$queryJadwal=json_decode(json_encode($query), true);
for($i=0; $i<count($queryJadwal);$i++){
  $arrlist[$i]['acara']=$queryJadwal[$i]['acara'];
  $arrlist[$i]['pegawai']=$queryJadwal[$i]['nama_pegawai'];
  $arrlist[$i]['nip']=$queryJadwal[$i]['nip_baru'];
  $arrlist[$i]['pegawai_id']=$queryJadwal[$i]['pegawai_id'];
  $arrlist[$i]['jadwal_tes_id']=$queryJadwal[$i]['jadwal_tes_id'];
  $arrlist[$i]['tugas']=$queryJadwal[$i]['kode'];
}

?>

<table id="customers">
  <?php 
  for($i=0; $i<count($arrlist);$i++){?>
  <tr>
    <td style="width:20%"><?=$arrlist[$i]['acara']?></td>
    <td style="width:20%"><?=$arrlist[$i]['pegawai']?><br>(<?=$arrlist[$i]['nip']?>)</td>
    <td style="width:50%"><?=$arrlist[$i]['tugas']?></td>
    <td style="width:10%">
        <a target="_blank" href="app/asesor/identitascat/<?=$arrlist[$i]['pegawai_id']?>/<?=$arrlist[$i]['jadwal_tes_id']?>/<?=$tgl?>" class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
    </td>
  <?php }?>
</table>

</body>
</html>


