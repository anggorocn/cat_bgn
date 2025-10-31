<?php
    if($reqTipeUjian == "1" || $reqTipeUjian == "2")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"Hasil subtest 1", "field"=> "jumlah_benar_0101", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Hasil subtest 2", "field"=> "jumlah_benar_0102", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Hasil subtest 3", "field"=> "jumlah_benar_0103", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Hasil subtest 4", "field"=> "jumlah_benar_0104", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Jumlah", "field"=> "jumlah_benar", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nilai", "field"=> "nilai_hasil", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Kesimpulan", "field"=> "Kesimpulan", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "7")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"Total 1", "field"=> "TOTAL_1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Total 2", "field"=> "TOTAL_2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "95")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"Total Integritas", "field"=> "total", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "94")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"Jawaban", "field"=> "keterangan", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "40")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"A", "field"=> "nilai_A", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"B", "field"=> "nilai_b", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"C", "field"=> "nilai_c", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"E", "field"=> "nilai_e", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"F", "field"=> "nilai_f", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"G", "field"=> "nilai_g", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"H", "field"=> "nilai_h", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"I", "field"=> "nilai_i", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"L", "field"=> "nilai_l", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"M", "field"=> "nilai_m", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"N", "field"=> "nilai_n", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"O", "field"=> "nilai_o", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Q1", "field"=> "nilai_Q1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Q2", "field"=> "nilai_Q2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Q3", "field"=> "nilai_Q3", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Q4", "field"=> "nilai_Q4", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "41")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"I", "field"=> "NILAI_I", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"E", "field"=> "NILAI_E", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"S", "field"=> "NILAI_S", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"N", "field"=> "NILAI_N", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"T", "field"=> "NILAI_T", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"F", "field"=> "NILAI_F", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"J", "field"=> "NILAI_J", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"P", "field"=> "NILAI_P", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Tipe Kepribadian", "field"=> "KONVERSI_INFO", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "42")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"D1", "field"=> "D_1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"I1", "field"=> "I_1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"S1", "field"=> "S_1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"C1", "field"=> "C_1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"X1", "field"=> "X_1", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"D2", "field"=> "D_2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"I2", "field"=> "I_2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"S2", "field"=> "S_2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"C2", "field"=> "C_2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"X2", "field"=> "X_2", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"D3", "field"=> "D_3", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"I3", "field"=> "I_3", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"S3", "field"=> "S_3", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"C3", "field"=> "C_3", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($reqTipeUjian == "18")
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            ,array("label"=>"SE", "field"=> "RW_SE", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"WA", "field"=> "rw_wa", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"AN", "field"=> "rw_AN", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"GE", "field"=> "rw_GE", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"ME", "field"=> "rw_ME", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"RA", "field"=> "rw_RA", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"ZR", "field"=> "rw_ZR", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"FA", "field"=> "rw_FA", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"WU", "field"=> "rw_WU", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"Jumlah", "field"=> "rw_Jumlah", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
            ,array("label"=>"IQ", "field"=> "IQ", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
                        
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else if($query->keterangan_ujian=='SJT')
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            // ,array("label"=>"Skor", "field"=> "hasil", "display"=>"",  "width"=>"80")
            // ,array("label"=>"JPM", "field"=> "jpm", "display"=>"",  "width"=>"80")
            // ,array("label"=>"Kategori Pengisian Jabatan", "field"=> "pengisian_jabatan", "display"=>"",  "width"=>"80")
            // ,array("label"=>"Kategori Pemetaan Kompetensi", "field"=> "pemetaan_kompetensi", "display"=>"",  "width"=>"80")
            ,array("label"=>"Status Pengerjaan", "field"=> "status", "display"=>"",  "width"=>"80")
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }
    else
    {
        $arrdata= array(
            // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
            array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
            ,array("label"=>"Nama", "field"=> "nama_pegawai", "display"=>"",  "width"=>"80")
            // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
            , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
            , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        );
    }

    $child=json_decode(json_encode($child), true);
    // print_r($query->keterangan_ujian); exit;
?>

<style>
    /* Style untuk tombol dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-button {
        background-color: #3699ff;
        color: white;
        padding: 9px 20px;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-family: Poppins, Helvetica, "sans-serif";
        font-weight: 600 !important;
    }
    .dropdown-button:hover {
        background-color: #0056b3;
    }

    /* Style untuk menu dropdown */
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 150px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        z-index: 1;
    }
    .dropdown-menu a {
        color: black;
        padding: 10px 20px;
        text-decoration: none;
        display: block;
    }
    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    /* Tampilkan menu dropdown saat aktif */
    .dropdown.active .dropdown-menu {
        display: block;
    }
</style>
@extends('app/index_surat') 
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Hasil Ujian</h3>
                    </div>
                </div>
                <div class="containerNew">
                    <div class="left" id="left-content"></div>
                    <div class="contentNew" id="contentNew">
                        <div class="container">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-notepad text-primary"></i>
                                        </span>
                                        <h3 class="card-label">Hasil Ujian <?=$query->tipe?></h3>
                                    </div>
                                   <div class="card-toolbar">
                                        &nbsp;
                                        <?php
                                        if($reqTipeUjian == "1" || $reqTipeUjian == "2"){?>
                                            <a onclick="lihat()" class="btn btn-primary font-weight-bolder">
                                                Lihat Jawaban
                                            </a>
                                            &nbsp;
                                        <?php }
                                        
                                        if($reqTipeUjian == "7"){?>
                                            <a onclick="cetakBaru()" class="btn btn-primary font-weight-bolder">
                                                Cetak Semua
                                            </a>
                                            &nbsp;
                                        <?php }

                                        if($query->keterangan_ujian=='SJT'){?>
                                            <a onclick="lihatSjt()" class="btn btn-primary font-weight-bolder">
                                                Lihat Jawaban
                                            </a>
                                            &nbsp;
                                            <div class="dropdown">
                                                <button class="dropdown-button" onclick="toggleDropdown()">Rekap Cetak</button>
                                                <div class="dropdown-menu">
                                                     <li><a class="dropdown-item" style="cursor: pointer;" onclick="cetakBaru()" class="btn btn-primary font-weight-bolder">Cetak Baru</a></li>
                                                     <li><a class="dropdown-item" style="cursor: pointer;" onclick="cetakPDF()" class="btn btn-primary font-weight-bolder">Cetak PDF</a></li>
                                                     <li><a class="dropdown-item" style="cursor: pointer;" onclick="cetakPenilaian()" class="btn btn-primary font-weight-bolder">Cetak Detil Penilaian</a></li>
                                                </div>
                                            </div>
                                            
                                            &nbsp;
                                            <?php if($queryFormula->tipe_formula==2){?>

                                            <a onclick="LihatDetil()" class="btn btn-primary font-weight-bolder">
                                                Lihat Detil
                                            </a>
                                            &nbsp;

                                            <?php
                                            }
                                        }
                                        if($query->keterangan_ujian=='SJT'){?>
                                            <a onclick="cetak()" class="btn btn-primary font-weight-bolder">
                                                Cetak Monitoring
                                            </a>
                                        &nbsp;
                                        <?php
                                        } 
                                        else if($reqTipeUjian == "40"||$reqTipeUjian == "7"||$reqTipeUjian == "42"||$reqTipeUjian == "66"){?>
                                            <a onclick="cetakIndividu()" class="btn btn-primary font-weight-bolder">
                                                Cetak
                                            </a>
                                        &nbsp;
                                        <?php }

                                        if(empty($child)){?>
                                            <a onclick="reset(<?=$reqTipeUjian?>)" class="btn btn-primary font-weight-bolder">
                                                Reset
                                            </a>
                                        <?php }
                                        else{?>
                                            <div class="dropdown">
                                                <button class="dropdown-button" onclick="toggleDropdown()">Reset</button>
                                                <div class="dropdown-menu">
                                                    <?php
                                                    for($i=0; $i<count($child);$i++){ ?>
                                                        <li><a class="dropdown-item" style="cursor: pointer;" onclick="reset(<?=$child[$i]['tipe_ujian_id']?>)"><?=$child[$i]['tipe']?></a></li>
                                                    <?php
                                                    }?>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="card-body">
				                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable" style="margin-top: 13px !important;width:100%">
				                        <thead>
				                            <tr>
				                                <?php
				                                foreach($arrdata as $valkey => $valitem) 
				                                {
				                                    echo "<th>".$valitem["label"]."</th>";
				                                }
				                                ?>
				                            </tr>
				                        </thead>
				                    </table>
				                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>

    <script type="text/javascript">
        var datanewtable;
        var infotableid= "kt_datatable";
        var carijenis= "";
        var arrdata= <?php echo json_encode($arrdata); ?>;
        var indexfieldid= arrdata.length - 1;
        var indexvalidasiid= arrdata.length - 3;
        var indexvalidasihapusid= arrdata.length - 4;
        var valinfoid = '';
        var valinfovalidasiid = '';
        var valinfovalidasihapusid = '';

        // var infoscrolly = 50;
        // var datainfoscrollx = 0;

        jQuery(document).ready(function() {

            var jsonurl= "/SettingJadwal/jsonHasil/<?=$reqId?>/<?=$reqTipeUjian?>";
            ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

             $("#triggercari").on("click", function () {
                if(carijenis == "1")
                {
                    pencarian= $('#'+infotableid+'_filter input').val();
                    datanewtable.DataTable().search( pencarian ).draw();
                }
            });

            $('#'+infotableid+' tbody').on( 'click', 'tr', function () {
                // untuk pilih satu data, kalau untuk multi comman saja
                $('#'+infotableid+' tbody tr').removeClass('selected');

                var el= $(this);
                el.addClass('selected');

                var dataselected= datanewtable.DataTable().row(this).data();
                // console.log(valinfoid);
                // console.log(Object.keys(dataselected).length);

                fieldinfoid= arrdata[indexfieldid]["field"]
                valinfoid= dataselected[fieldinfoid];
                // console.log(valinfoid);
                if (valinfoid == null)
                {
                    valinfoid = '';
                }
            });
        });

        function calltriggercari()
        {
            $(document).ready( function () {
              $("#triggercari").click();      
            });
        }

        fetch('/app/setting_jadwal/edit/<?=$pg?>/<?=$reqId?>/<?=$reqTipeUjian?>')
        .then(response => response.text())
        .then(data => {
            document.getElementById('left-content').innerHTML = data;
        })
        .catch(error => console.error('Terjadi kesalahan:', error));

        function reset(tipeid) {
            if(valinfoid == "")
            {
                Swal.fire({
                    text: "Pilih salah satu Pegawai terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
            }
            else
            {
                urlAjax= "/SettingJadwal/reset/<?=$reqId?>/"+tipeid+"/"+valinfoid+"";
                swal.fire({
                    title: 'Apakah anda yakin untuk hapus data?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function(result) { 
                    if (result.value) {
                        $.ajax({
                            url : urlAjax,
                            type : 'DELETE',
                            dataType:'json',
                            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                            beforeSend: function() {
                                swal.fire({
                                    title: 'Please Wait..!',
                                    text: 'Is working..',
                                    onOpen: function() {
                                        swal.showLoading()
                                    }
                                })
                            },
                            success : function(data) { 
                                swal.fire({
                                    position: 'center',
                                    icon: "success",
                                    type: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    document.location.href = "app/setting_jadwal/hasil/<?=$reqId?>/<?=$reqTipeUjian?>";
                                });
                            },
                            complete: function() {
                                swal.hideLoading();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                swal.hideLoading();
                                var err = JSON.parse(jqXHR.responseText);
                                Swal.fire("Error", err.message, "error");
                            }
                        });
                    }
                });
            }
        }        

        function lihat()
        {
            if(valinfoid == "")
            {
                Swal.fire({
                    text: "Pilih salah satu Pegawai terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
            }
            else
            {
                openAdd('/app/setting_jadwal/jawaban/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid);
                console.log('xxx')
            }
        }          

        function lihatSjt()
        {
            if(valinfoid == "")
            {
                Swal.fire({
                    text: "Pilih salah satu Pegawai terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
            }
            else
            {
                openAdd('/app/setting_jadwal/jawaban_sjt/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid);
                console.log('xxx')
            }
        }      

        function cetak()
        {
            <?php if($reqTipeUjian==18){?>
                window.open('/app/cetakan/addviewcetakIST/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php 
            }else if($reqTipeUjian==41){?>
                window.open('/app/cetakan/addviewcetakMSDT/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php 
            }else if($query->keterangan_ujian=='SJT'){?>
                window.open('/app/cetakan/addviewcetakSJT/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php 
            }else{?>
                window.open('/app/cetakan/addviewcetakCFID/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php }?>
            console.log('xxx')
        }     

        function cetakBaru()
        {
            <?php if($reqTipeUjian==7){?>
                window.open('/app/cetakan/addviewcetakPapiSemua/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php } else if($queryFormula->tipe_formula==2){?>
                window.open('/app/cetakan/addviewcetakRapidBaru/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php } else{?>
                window.open('/app/cetakan/addviewcetakSJTBaru/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
            <?php }?>
        }   

        function cetakPenilaian()
        {
            window.open('/app/cetakan/addviewcetakDetilPenilaianSJT/<?=$reqId?>/<?=$reqTipeUjian?>/', "_blank");
        }       

        function cetakPDF()
        {

            if(valinfoid == "")
            {
                Swal.fire({
                    text: "Pilih salah satu Pegawai terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
            }
            else
            {
                window.open('/app/cetakan/addviewcetakSJTPDF/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid, "_blank");
            }
        }            

        function LihatDetil()
        {
            openAdd('/app/setting_jadwal/lihat_detil/<?=$reqId?>/<?=$reqTipeUjian?>');
        }      

        function cetakIndividu()
        {
            if(valinfoid == "")
            {
                Swal.fire({
                    text: "Pilih salah satu Pegawai terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
            }
            else
            {
                <?php if($reqTipeUjian==40){?>
                    window.open('/app/cetakan/addviewcetak16pf/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid, "_blank"); 
                <?php } else if($reqTipeUjian==7){?>
                    window.open('/app/cetakan/addviewcetakPapikostik/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid, "_blank"); 
                <?php } else if($reqTipeUjian==42){?>
                    window.open('/app/cetakan/addviewcetakDISC/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid, "_blank"); 
                <?php } else if($reqTipeUjian==66){?>
                    window.open('/app/cetakan/addviewcetakMMPI/<?=$reqId?>/<?=$reqTipeUjian?>/'+valinfoid, "_blank"); 
                <?php }?>  
            }
        }

        function toggleDropdown() {
            // Dapatkan elemen dropdown
            const dropdown = document.querySelector('.dropdown');

            // Tambahkan atau hapus class "active"
            dropdown.classList.toggle('active');
        }

        // // Tutup dropdown jika klik di luar
        // window.onclick = function (event) {
        //     const dropdown = document.querySelector('.dropdown');
        //     if (!event.target.matches('.dropdown-button')) {
        //         dropdown.classList.remove('active');
        //     }
        // };
    </script>

@endsection