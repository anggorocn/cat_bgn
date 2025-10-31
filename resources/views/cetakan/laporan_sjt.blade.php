<?php
$tanggal_lahir=explode(' ',$queryIdentitas->tgl_lahir);
$tanggal_lahir=$tanggal_lahir[0];

$totalkompetensi=$arrayVal['int']+$arrayVal['kjsm']+$arrayVal['kom']+$arrayVal['oph']+$arrayVal['pp']+$arrayVal['pdol']+$arrayVal['mp']+$arrayVal['pk']+$arrayVal['pb'];

$tanggal=explode(' ',$queryJadwal->tanggal_tes);
// $tanggal=DateFunc::getDayMonthYear($tanggal[0]);
$tanggal=$tanggal[0];
// print_r($arrayVal);exit;

if(empty($queryJadwal->status_jenis)){
    $tipeujian='Seleksi';
}
else{
    $tipeujian='Pemetaan';
}
?>
<div style="width:100%;text-align:center;font-size: 9pt;font-family:arial">
    HASIL PENILAIAN POTENSI DAN<br>KOMPETENSI MANAJERIAL DAN SOSIAL KULTURAL
</div>
<br>

<table style="width:100%;font-size: 9pt;font-family:arial">
    <tr>
        <td style="width: 3%;"><b>1.</b></td>
        <td><b>IDENTITAS DIRI</b></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <table style="width: 100%;border-collapse: collapse; font-size: 9pt;font-family:arial">
                <tr>
                    <td style="border: 1px solid black;width:10%;padding: 0px 5px;">Nama</td>   
                    <td style="border: 1px solid black;width:2% ;padding: 0px 5px;">:</td>   
                    <td style="border: 1px solid black;width:28% ;padding: 0px 5px;"><?=$queryIdentitas->nama?></td>   
                    <td style="border: 1px solid black;width:20%;padding: 0px 5px;">Jabatan</td>   
                    <td style="border: 1px solid black;width:2%;padding: 0px 5px; ">:</td>  
                    <td style="border: 1px solid black;width:38%;padding: 0px 5px;"><?=$queryIdentitas->last_jabatan?></td>   
                </tr>
                <tr>
                    <td style="border: 1px solid black;width:10%;padding: 0px 5px;">NIP</td>   
                    <td style="border: 1px solid black;width:2%;padding: 0px 5px; ">:</td>   
                    <td style="border: 1px solid black;width:28%;padding: 0px 5px;"><?=$queryIdentitas->nip_baru?></td>   
                    <td style="border: 1px solid black;width:20%;padding: 0px 5px;">Kelompok Jabatan</td>   
                    <td style="border: 1px solid black;width:2%;padding: 0px 5px; ">:</td>  
                    <td style="border: 1px solid black;width:38%;padding: 0px 5px;"><?=$queryStandar->note?></td>   
                </tr>
                <tr>
                    <td style="border: 1px solid black;width:10%;padding: 0px 5px;">TTL</td>   
                    <td style="border: 1px solid black;width:2%;padding: 0px 5px;">:</td>   
                    <td style="border: 1px solid black;width:28%;padding: 0px 5px;"><?=$tanggal_lahir?></td>   
                    <td style="border: 1px solid black;width:20%;padding: 0px 5px;">Unit Kerja</td>   
                    <td style="border: 1px solid black;width:2%;padding: 0px 5px; ">:</td>  
                    <td style="border: 1px solid black;width:38%;padding: 0px 5px;"><?=$queryIdentitas->nama_satker?></td>   
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table style="font-size: 9pt;font-family:arial">
    <tr>
        <td style="width: 3%;"><b>2.</b></td>
        <td><b>KOMPETENSI MANAJERIAL DAN SOSIAL KULTURAL</b></td>
    </tr>
<!--     <tr>
        <td></td>
        <td>Level Kompetensi: 3</td>
    </tr> -->
    <tr>
        <td></td>
        <td><br><b>A. Profil Kompetensi</b></td>
    </tr>
</table>

<?php
$jpmkompetensi=($totalkompetensi/$queryStandar->total) *100;

?>
<table style="font-size: 9pt;font-family:arial;border-collapse: collapse;word-wrap: break-word; width: 100%;margin-left: 20px;">
    <tr>
        <td style="text-align:center;border: 1px solid black;width:5%;padding: 0px 5px;">No</td>
        <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">Kompetensi</td>
        <td style="text-align:center;border: 1px solid black;width:12%;padding: 0px 5px;">Standar<br>Kompetensi</td>
        <td style="text-align:center;border: 1px solid black;width:13%;padding: 0px 5px;">Capaian<br>Kompetensi</td>
        <td style="text-align:center;border: 1px solid black;width:10%;padding: 0px 5px;">Gap</td>
        <td style="text-align:center;border: 1px solid black;width:10%;padding: 0px 5px;">JPM</td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">1</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Integritas</b><br> 
            Konsisten berperilaku selaras dengan nilai, norma, dan/atau etika organisasi, dan jujur dalam hubungan dengan manajemen, rekan kerja, bawahan langsung, dan pemangku kepentingan. Menciptakan budaya etika tinggi, bertanggung jawab atas tindakan atau keputusan beserta risiko yang menyertainya

        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->integritas?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['int']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->integritas-$arrayVal['int']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;" rowspan="9"></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">2</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Kerjasama</b><br>
            Kemampuan menjalin, membina, mempertahankan hubungan kerja yang efektif, memiliki komitmen saling membantu dalam penyelesaian tugas, dan mengoptimalkan segala sumber daya untuk mencapai tujuan strategis organisasi
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->kerjasama?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['kjsm']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->kerjasama-$arrayVal['kjsm']?></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">3</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Komunikasi</b><br> 
            Kemampuan untuk menerangkan pandangan dan gagasan secara jelas, sistematis disertai argumentasi yang logis dengan cara-cara yang sesuai baik secara lisan maupun tertulis; memastikan pemahaman; mendengarkan secara aktif dan efektif; mempersuasi, meyakinkan dan membujuk orang lain dalam rangka mencapai tujuan organisasi
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->komunikasi?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['kom']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->komunikasi-$arrayVal['kom']?></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">4</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Orientasi pada Hasil</b><br>
            Kemampuan mempertahankan komitmen pribadi yang tinggi untuk menyelesaikan tugas, dapat diandalkan, bertanggung jawab, mampu secara sistematis mengidentifikasi risiko dan peluang dengan memperhatikan keterhubungan antara perencanaan dan hasil, untuk keberhasilan organisasi
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->orientasi_hasil?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['oph']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->orientasi_hasil-$arrayVal['oph']?></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">5</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Pelayanan Publik</b><br>
            Kemampuan dalam melaksanakan tugas-tugas pemerintahan, pembangunan dan kegiatan pemenuhan kebutuhan pelayanan publik secara profesional, transparan, mengikuti standar pelayanan yang objektif, netral, tidak memihak, tidak diskriminatif, serta tidak terpengaruh kepentingan pribadi/ kelompok/ golongan/ partai politik
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->pelayanan_publik?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['pp']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->integritas-$arrayVal['int']?></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">6</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Pengembangan Diri dan Orang Lain</b><br>
            Kemampuan untuk meningkatkan pengetahuan dan menyempurnakan keterampilan diri; menginspirasi orang lain untuk mengembangkan dan menyempurnakan pengetahuan dan keterampilan yang relevan dengan pekerjaan dan pengembangan karir jangka panjang, mendorong kemauan belajar sepanjang hidup, memberikan saran/bantuan, umpan 3balik, bimbingan untuk membantu orang lain untuk mengembangkan potensi dirinya
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->mengembangkan_diri?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['pdol']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->mengembangkan_diri-$arrayVal['pdol']?></td>
    </tr>
</table>
<br>
<table style="font-size: 9pt;font-family:arial;border-collapse: collapse;word-wrap: break-word; width: 100%;margin-left: 20px;">
    <tr>
        <td style="text-align:center;border: 1px solid black;width:5%;padding: 0px 5px;">No</td>
        <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">Kompetensi</td>
        <td style="text-align:center;border: 1px solid black;width:12%;padding: 0px 5px;">Standar<br>Kompetensi</td>
        <td style="text-align:center;border: 1px solid black;width:13%;padding: 0px 5px;">Capaian<br>Kompetensi</td>
        <td style="text-align:center;border: 1px solid black;width:10%;padding: 0px 5px;">Gap</td>
        <td style="text-align:center;border: 1px solid black;width:10%;padding: 0px 5px;">JPM</td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">7</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Mengelola Perubahan</b><br> 
            Kemampuan dalam menyesuaikan diri dengan situasi yang baru atau berubah dan tidak bergantung secara berlebihan pada metode dan proses lama, mengambil tindakan untuk mendukung dan melaksanakan insiatif perubahan, memimpin usaha perubahan, mengambil tanggung jawab pribadi untuk memastikan perubahan berhasil diimplementasikan secara efektif
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->mengelolah_perubahan?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['mp']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->mengelolah_perubahan-$arrayVal['mp']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;" rowspan="3"></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">8</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Pengambilan Keputusan</b><br> 
            Kemampuan membuat keputusan yang baik secara tepat waktu dan dengan keyakinan diri setelah mempertimbangkan prinsip kehati-hatian, dirumuskan secara sistematis dan seksama berdasarkan berbagai informasi, alternatif pemecahan masalah dan konsekuensinya, serta bertanggung jawab atas keputusan yang diambil
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->pengambilan_keputusan?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['pk']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->pengambilan_keputusan-$arrayVal['pk']?></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;vertical-align: top;">9</td>
        <td style="padding: 0px 5px;border: 1px solid black; word-wrap: break-word;">
            <b>Perekat Bangsa</b><br> 
            Kemampuan dalam mempromosikan sikap toleransi, keterbukaan, peka terhadap perbedaan individu/kelompok masyarakat; mampu menjadi perpanjangan tangan pemerintah dalam mempersatukan masyarakat dan membangun hubungan sosial psikologis dengan masyarakat di tengah kemajemukan Indonesia sehingga menciptakan kelekatan yang kuat antara ASN dan para pemangku kepentingan serta diantara para pemangku kepentingan itu sendiri; menjaga, mengembangkan, dan mewujudkan rasa persatuan dan kesatuan dalam kehidupan bermasyarakat, berbangsa dan bernegara Indonesia
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->perekat_bangsa?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$arrayVal['pb']?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->perekat_bangsa-$arrayVal['pb']?></td>
    </tr>
    <tr>
        <td style="padding: 0px 5px;border: 1px solid black;"></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align: center;"><b>TOTAL</b>
        </td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->total?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$totalkompetensi?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=$queryStandar->total-$totalkompetensi?></td>
        <td style="padding: 0px 5px;border: 1px solid black;text-align:center;"><?=round($jpmkompetensi,2)?></td>
    </tr>
</table>


<table style="font-size: 9pt;font-family:arial">
    <tr>
        <td style="width: 3%;"></td>
        <td><br><b>B.   Job Person Match Untuk <?=$tipeujian?></b></td>
    </tr>
    <tr>
        <td></td>
        <td style="padding-left: 17px;text-align: justify;">Berdasarkan hasil penilaian, total nilai capaian kompetensi adalah <?=$totalkompetensi?> dari total nilai 
        standar <?=$queryStandar->total?> atau setara dengan <?=round($jpmkompetensi,2)?> % Job Person Match.</td>
    </tr>
</table>
<?php
$kompetensiOptomal='';
$kompetensiCukupOptomal='';
$kompetensiKurangOptomal='';
$jpm=round(($totalkompetensi/$queryStandar->total)*100,2);
if($queryJadwal->status_jenis==1){
    
    if( $jpm >=90){
        $kompetensiOptomal='x';
    }
    else if ($jpm >=78 and $jpm <90) {
        $kompetensiCukupOptomal='x';
    }
    else{
        $kompetensiKurangOptomal='x';
    }
    ?>
    <br>
    <table style="font-size: 9pt;font-family:arial;border-collapse: collapse;word-wrap: break-word; width: 100%;margin-left: 40px;">
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Kategori</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">Job Person Match</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Hasil Penilaian</td>    
        </tr>
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Optimal</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">>= 90%</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;"><?=$kompetensiOptomal?></td>
        </tr>
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Cukup Optimal</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">>= 78% s/d < 90%</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;"><?=$kompetensiCukupOptomal?></td>
        </tr>
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Kurang Optimal</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">< 78%</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;"><?=$kompetensiKurangOptomal?></td>
        </tr>
    </table>
    <?php
}
else{
    if( $jpm >=80){
        $kompetensiOptomal='x';
    }
    else if ($jpm >=68 and $jpm<80) {
        $kompetensiCukupOptomal='x';
    }
    else{
        $kompetensiKurangOptomal='x';
    }
    ?>
    <br>
    <table style="font-size: 9pt;font-family:arial;border-collapse: collapse;word-wrap: break-word; width: 100%;margin-left: 40px;">
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Kategori</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">Job Person Match</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">Hasil Penilaian</td>    
        </tr>
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">memenuhi syarat</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">>= 80%</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;"><?=$kompetensiOptomal?></td>
        </tr>
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">masih memenuhi syarat</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">>= 68% s/d < 80%</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;"><?=$kompetensiCukupOptomal?></td>
        </tr>
        <tr>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;">kurang memenuhi syarat</td>
            <td style="text-align:center;border: 1px solid black;padding: 0px 5px;">< 68%</td>
            <td style="text-align:center;border: 1px solid black;width:33%;padding: 0px 5px;"><?=$kompetensiKurangOptomal?></td>
        </tr>
    </table>
    <?php
}
?>
<br>
<br>
<br>
<table style="width:100%">
    <tr>
        <td style="width:50%;text-align:center;font-size: 9pt;font-family:arial"></td>
        <td style="width:50%;text-align:center;font-size: 9pt;font-family:arial">
            Jakarta, <?=$tanggal?><br>
            Kepala Biro Sumber Daya Manusia
            <br>
            <br>
            <br>
            Dr. Eni Lestariningsih, S.Si, M.A.<br>
            NIP. 197003101994012001
        </td>
    </tr>
</table>
