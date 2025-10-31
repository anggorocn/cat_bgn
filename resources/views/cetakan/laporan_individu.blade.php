<?php
// print_r($PenilaianRekomendasi); exit;
$AspekPotensi=json_decode(json_encode($AspekPotensi), true);
$AspekKompetensi=json_decode(json_encode($AspekKompetensi), true);
$PenilaianRekomendasi=json_decode(json_encode($PenilaianRekomendasi), true);
$arr=array('profil_kekuatan'=>'','profil_saran_penempatan'=>'','profil_saran_pengembangan'=>'');
for($j=0; $j<count($PenilaianRekomendasi);$j++){
    $arr[$PenilaianRekomendasi[$j]['tipe']]=$PenilaianRekomendasi[$j]['keterangan'];
}

$reqTanggalTes = explode(' ',$data1->tanggal_tes);
$reqTanggalTes = DateFunc::dateToPage($reqTanggalTes[0]);
$tempBulanAngka = DateFunc::getMonth($reqTanggalTes);
$tempTahun = DateFunc::getYear($reqTanggalTes);
$tempBulanRomawi = StringFunc::romanic_number((int)$tempBulanAngka); 
$statusjenis=$data1->jenis_laporan;
$judulText='SELEKSI';
if($statusjenis==1){
    $judulText='PEMETAAN';
}
?>
<h4>
    <strong>
        HASIL PENILAIAN KOMPETENSI <br>
        <?=$judulText ?> KOMPETENSI JABATAN <?=strtoupper($data1->pegawai_eselon)?><br>
        BADAN PUSAT STATISTIK<br>
        TANGGAL PENYELENGGARAAN 1 DESEMBER 2024<br>
    </strong>
</h4>
<br>
<h4>I. Identitas Pribadi</h4>
<table style="width: 100%;border-collapse: collapse;">
    <tr>
        <td style="border: 1px solid black; width:15%;padding-left: 10px;">Nomor</td>
        <td style="border: 1px solid black; width:5%;padding-left: 10px;">:</td>
        <td style="border: 1px solid black; width:30%;padding-left: 10px;"><?=$data1->id?>/<?=$tempBulanRomawi?>/<?=$tempTahun?></td>
        <td style="border: 1px solid black; width:15%;padding-left: 10px;" rowspan="2">Jabatan</td>
        <td style="border: 1px solid black; width:5%;padding-left: 10px;" rowspan="2">:</td>
        <td style="border: 1px solid black; width:30%;padding-left: 10px;" rowspan="2"><?=$data1->pegawai_jab_struktural?></td>
    </tr>
    <tr>
        <td style="border: 1px solid black; width:15%;padding-left: 10px;">Nama</td>
        <td style="border: 1px solid black; width:5%;padding-left: 10px;">:</td>
        <td style="border: 1px solid black; width:30%;padding-left: 10px;"><?=$data1->pegawai_nama?></td>
    </tr>
    <tr>
        <td style="border: 1px solid black; width:15%;padding-left: 10px;">NIP</td>
        <td style="border: 1px solid black; width:5%;padding-left: 10px;">:</td>
        <td style="border: 1px solid black; width:30%;padding-left: 10px;"><?=$data1->pegawai_nip?></td>
        <td style="border: 1px solid black; width:15%;padding-left: 10px;">Unit Kerja</td>
        <td style="border: 1px solid black; width:5%;padding-left: 10px;">:</td>
        <td style="border: 1px solid black; width:30%;padding-left: 10px;">............................</td>
    </tr>
</table>  

<h4>II. PROFIL POTENSI</h4>
<h4>A.  Aspek Potensi </h4>
<table style="border: 1px solid black; width: 100%;border-collapse: collapse;font-size: 10pt">
    <tr>
        <td rowspan="2" style="border: 1px solid black; width:5%; text-align: center;">No</td>
        <td rowspan="2" style="border: 1px solid black; width:45%; text-align: center;">Aspek Potensi</td>
        <td colspan="5" style="border: 1px solid black; width:50%; text-align: center;">Skala Penilaian</td>
    </tr>
    <tr>
        <td style="border: 1px solid black; width:10%; text-align: center;">KS</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">K</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">C</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">B</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">BS</td>
    </tr>
    <?php
    $no=1;
    for($i=0; $i<count($AspekPotensi);$i++){
        $PotensiNama=$AspekPotensi[$i]['nama'];
        $PotensiNilaiStandar=$AspekPotensi[$i]['nilai_standar'];
        $PotensiNilai=$AspekPotensi[$i]['nilai'];
        $PotensiAtributIdParent=$AspekPotensi[$i]['atribut_id_parent'];
        if($PotensiAtributIdParent==0){?>
            <tr>
                <td style="border: 1px solid black; width:5%; text-align: center;"><?=$no?></td>
                <td style="border: 1px solid black;" colspan="6"><b><?=$PotensiNama?></b></td>
            </tr>
        <?php
            $no++;
        }
        else
        {
        ?>
            <tr>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"><?=$PotensiNama?></td>
                <?php 
                for($j=1; $j<=5;$j++){
                    $bg='';
                    $val='';
                    if($j==$PotensiNilaiStandar){
                        $bg='background-color: lightgray;';
                    }if($j==$PotensiNilai){
                        $val='X';
                    }?>
                    <td style="border: 1px solid black; width:10%; text-align: center;<?=$bg?>"><?=$val?></td>
                <?php }?>
            </tr>
    <?php 
        }
    }?>
    <tr>
        <td style="border: 1px solid black;" colspan="7">
            Keterangan: KS: Kurang Sekali; K: Kurang; C: Cukup; B: Baik; BS: Baik Sekali <br>
            X = Hasil Penilaian
        </td>
    </tr>
</table>
<pagebreak>
<!-- 
<table>
    <tr>
        <td width="5%"><h4>B.  </h4></td>
        <td><h4>Dinamika Psikologis </h4></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td>..................................        </td>
    </tr>
</table> -->

<h4>III.    PROFIL KOMPETENSI</h4>
<h4>A.  Aspek Kompetensi </h4>
<table style="border: 1px solid black; width: 100%;border-collapse: collapse;font-size: 10pt">
    <tr>
        <td rowspan="2" style="border: 1px solid black; width:5%; text-align: center;">No</td>
        <td rowspan="2" style="border: 1px solid black; width:35%; text-align: center;">Aspek Kompetensi</td>
        <td rowspan="2" style="border: 1px solid black; width:10%; text-align: center;">Level</td>
        <td colspan="5" style="border: 1px solid black; width:50%; text-align: center;">Rating Kompetensi</td>
    </tr>
    <tr>
        <td style="border: 1px solid black; width:10%; text-align: center;">1</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">2</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">3</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">4</td>
        <td style="border: 1px solid black; width:10%; text-align: center;">5</td>
    </tr>
    <?php
    $no=1;
    for($i=0; $i<count($AspekKompetensi);$i++){
        $PotensiNama=$AspekKompetensi[$i]['atribut_nama'];
        $PotensiNilaiStandar=$AspekKompetensi[$i]['nilai_standar'];
        $PotensiNilai=$AspekKompetensi[$i]['nilai'];
        $PotensiAtributIdParent=$AspekKompetensi[$i]['atribut_id_parent'];
        $Potensilevel=$AspekKompetensi[$i]['level'];
        if($PotensiAtributIdParent==0){?>
            <tr>
                <td style="border: 1px solid black; width:5%; text-align: center;"><?=$no?></td>
                <td style="border: 1px solid black;" colspan="7"><b><?=$PotensiNama?></b></td>
            </tr>
        <?php
            $no++;
        }
        else
        {
        ?>
            <tr>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"><?=$PotensiNama?></td>
                <td style="border: 1px solid black;text-align: center;"><?=$Potensilevel?></td>
                <?php 
                for($j=1; $j<=5;$j++){
                    $bg='';
                    $val='';
                    if($j==$PotensiNilaiStandar){
                        $bg='background-color: lightgray;';
                    }if($j==$PotensiNilai){
                        $val='X';
                    }?>
                    <td style="border: 1px solid black; width:10%; text-align: center;<?=$bg?>"><?=$val?></td>
                <?php }?>
            </tr>
    <?php 
        }
    }?>
</table>
<table style="width:80%">
    <tr>
        <td>
            X  =  Hasil Penilaian
        </td>
        <td>
        </td>
        <td style="border: 1px solid black;background-color: lightgray;width: 20%;">
        </td>
        <td>
            = Persyaratan Kompetensi  
        </td>
    </tr>
</table>
<table>
    <tr>
        <td width="5%"><h4>B.  </h4></td>
        <td><h4>Profil Kompetensi </h4></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td>
            Berdasarkan hasil penilaian kompetensi, menunjukan bahwa nilai total kompetensi Saudara <?=$data1->pegawai_nama?>. adalah <?=$SumPenilaian->individu_rating?>. dari total <?=$SumPenilaian->standar_rating?>. atau setara dengan <?=$JPM->kompeten_jpm?> % Job Person Match  (JPM).
        </td>
    </tr>
</table>

<h4>IV. KEKUATAN DAN AREA PENGEMBANGAN </h4>

<table>
    <tr>
        <td width="5%">1.</td>
        <td>KEKUATAN</td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td>
            Berdasarkan hasil penilaian kompetensi yang dilakukan, maka yang menjadi kekuatan Sdr.<?=$data1->pegawai_nama?> adalah sebagai berikut:
            <br>
            <?=$arr['profil_kekuatan']?>
        </td>
    </tr>
    <tr>
        <td width="5%">2.</td>
        <td>AREA PENGEMBANGAN</td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td>
            Berdasarkan hasil penilaian kompetensi yang dilakukan, maka yang menjadi area pengembangan Sdr. <?=$data1->pegawai_nama?> adalah sebagai berikut:<br>
        </td>
    </tr>
</table>

<h4>V.  REKOMENDASI </h4>
<?php
    if ($JPM->kompeten_jpm >= 80)
        $HasilKonversi1 = 'MS = Memenuhi Syarat.';
    elseif ($JPM->kompeten_jpm >= 65 && $JPM->kompeten_jpm < 80)
        $HasilKonversi1 = 'MMS = Masih Memenuhi Syarat.';
    elseif ($JPM->kompeten_jpm < 68)
        $HasilKonversi1 = 'KMS = Kurang Memenuhi Syarat.';
    else
        $HasilKonversi1 = '-'; 

    if ($JPM->kompeten_jpm >= 90)
        $HasilKonversi2 = 'O = Optimal.';
    elseif ($JPM->kompeten_jpm >= 78 && $JPM->kompeten_jpm < 90)
        $HasilKonversi2 = 'CO = Cukup Optimal.';
    elseif ($JPM->kompeten_jpm < 78)
        $HasilKonversi2 = 'KO = Kurang Optimal.';
    else
        $HasilKonversi2 = '-'; 

if($judulText==1){
    $HasilKonversi1=$HasilKonversi2;
}
?>

Berdasarkan profil dan uraian di atas, maka Saudara <?=$data1->pegawai_nama?>. berada pada kategori <b><?=$HasilKonversi1?></b>.

<h4>VI.  SARAN PENEMPATAN </h4>
    <?=$arr['profil_saran_penempatan']?>

<h4>VII.  SARAN PENGEMBANGAN </h4>
    <?=$arr['profil_saran_pengembangan']?>
 
<table style="width: 100%;">
    <tr>
        <td style="width:50%;text-align: center;">
            <br>
            <br>
            <br>
            Asesor<br>
            <br>
            <br>
            <?php
                $infolinkfile='uploads/tes/'.$reqId.'/asesor_ttd.png';
                if(file_exists($infolinkfile))
                {
                ?>
                <!--<img src="<?=$infolinkfile?>" style="height: 150px;">-->
                <?php
                }
                else{
                ?>
                <br>
                <br>
                <br>
            <?php }?>
            <!--............................................<br>-->
            <?=$ttdCbi->nama?>
        </td>
        <td style="text-align: center;">
            Jakarta <?=DateFunc::getDayMonthYear(DateFunc::dateToPage($reqTanggalTes))?><br>
            <br>
            Pimpinan Penyelenggara Penilaian Kompetensi<br>
            Kepala Biro Sumber Daya Manusia,<br>
            
            <?php
                $infolinkfile='uploads/tes/'.$reqId.'/pimpinan_ttd.png';
                if(file_exists($infolinkfile))
                {
                ?>
                <br>
                <br>
                <img src="<?=$infolinkfile?>" style="height: 150px;">
                <?php
                }
                else{
                ?>
                <br>
                <br>
                <br>
                <br>
                <br>
            <?php }?>
            <!--............................................<br>-->
            <?=$data1->ttd_pimpinan?>
        </td>
    </tr>
</table>
