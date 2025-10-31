<?php
    $querySoal=json_decode(json_encode($querySoal), true);
    for($index_data=0; $index_data < count($querySoal); $index_data++)
    {
        $arrData[$index_data]["ROW_ID"]= $querySoal[$index_data]["ujian_id"]."-".$querySoal[$index_data]["pegawai_id"].$querySoal[$index_data]["bank_soal_id"];
        $arrData[$index_data]["UJIAN_ID"]= $querySoal[$index_data]["ujian_id"];
        $arrData[$index_data]["PEGAWAI_ID"]= $querySoal[$index_data]["pegawai_id"];
        $arrData[$index_data]["BANK_SOAL_ID"]= $querySoal[$index_data]["bank_soal_id"];
        $arrData[$index_data]["PERTANYAAN"]= $querySoal[$index_data]["pertanyaan"];
        $arrData[$index_data]["PATH_GAMBAR"]= str_replace("../cat/main/uploads/","images/soal/",$querySoal[$index_data]["path_gambar"]);
        $arrData[$index_data]["PATH_SOAL"]= $querySoal[$index_data]["path_soal"];
        $arrData[$index_data]["TIPE_SOAL"]= $querySoal[$index_data]["tipe_soal"];
        $arrData[$index_data]["TIPE_UJIAN_ID"]= $querySoal[$index_data]["tipe_ujian_id"];
        $arrData[$index_data]["TIPE_UJIAN_NAMA"]= $querySoal[$index_data]["tipe_ujian_nama"];
        $arrData[$index_data]["URUT"]= $querySoal[$index_data]["urut"];
    }
    // print_r($arrData);exit;

    $queryJawaban=json_decode(json_encode($queryJawaban), true);
    for($index_data=0; $index_data < count($queryJawaban); $index_data++)
    {
        $arrDataJawaban[$index_data]["ROW_ID"]= $queryJawaban[$index_data]["ujian_id"]."-".$queryJawaban[$index_data]["pegawai_id"].$queryJawaban[$index_data]["bank_soal_id"];
        $arrDataJawaban[$index_data]["UJIAN_ID"]= $queryJawaban[$index_data]["ujian_id"];
        $arrDataJawaban[$index_data]["PEGAWAI_ID"]= $queryJawaban[$index_data]["pegawai_id"];
        $arrDataJawaban[$index_data]["BANK_SOAL_ID"]= $queryJawaban[$index_data]["bank_soal_id"];
        $arrDataJawaban[$index_data]["JAWABAN"]= $queryJawaban[$index_data]["jawaban"];
        $arrDataJawaban[$index_data]["PATH_GAMBAR"]= str_replace("../cat/main/uploads/","images/soal/",$queryJawaban[$index_data]["path_gambar"]);
        $arrDataJawaban[$index_data]["PATH_SOAL"]= $queryJawaban[$index_data]["path_soal"];
        $arrDataJawaban[$index_data]["TIPE_SOAL"]= $queryJawaban[$index_data]["tipe_soal"];
        $arrDataJawaban[$index_data]["TIPE_UJIAN_ID"]= $queryJawaban[$index_data]["tipe_ujian_id"];
        $arrDataJawaban[$index_data]["URUT"]= $queryJawaban[$index_data]["urut"];
    }

    $arrDataJawabanPegawai=array();
    $queryJawabanPegawai=json_decode(json_encode($queryJawabanPegawai), true);
    for($index_data=0; $index_data < count($queryJawabanPegawai); $index_data++)
    {
        $arrDataJawabanPegawai[$index_data]["ROW_ID"]= $queryJawabanPegawai[$index_data]["ujian_id"]."-".$queryJawabanPegawai[$index_data]["pegawai_id"].$queryJawabanPegawai[$index_data]["bank_soal_id"];
        $arrDataJawabanPegawai[$index_data]["UJIAN_ID"]= $queryJawabanPegawai[$index_data]["ujian_id"];
        $arrDataJawabanPegawai[$index_data]["PEGAWAI_ID"]= $queryJawabanPegawai[$index_data]["pegawai_id"];
        $arrDataJawabanPegawai[$index_data]["BANK_SOAL_ID"]= $queryJawabanPegawai[$index_data]["bank_soal_id"];
        $arrDataJawabanPegawai[$index_data]["JAWABAN"]= $queryJawabanPegawai[$index_data]["jawaban"];
        $arrDataJawabanPegawai[$index_data]["PATH_GAMBAR"]= str_replace("../cat/main/uploads/","images/soal/",$queryJawabanPegawai[$index_data]["path_gambar"]);
        $arrDataJawabanPegawai[$index_data]["PATH_SOAL"]= $queryJawabanPegawai[$index_data]["path_soal"];
        $arrDataJawabanPegawai[$index_data]["TIPE_SOAL"]= $queryJawabanPegawai[$index_data]["tipe_soal"];
        $arrDataJawabanPegawai[$index_data]["TIPE_UJIAN_ID"]= $queryJawabanPegawai[$index_data]["tipe_ujian_id"];
        $arrDataJawabanPegawai[$index_data]["URUT"]= $queryJawabanPegawai[$index_data]["urut"];
    }

    // print_r($arrDataJawabanPegawai);exit;
    $arrCheckDataJawabanPegawai=array();
    $queryDataJawabanPegawai=json_decode(json_encode($queryDataJawabanPegawai), true);
    for($index_data=0; $index_data < count($queryDataJawabanPegawai); $index_data++)
    {
        $arrCheckDataJawabanPegawai[$index_data]["ROW_ID"]= $queryDataJawabanPegawai[$index_data]["ujian_id"]."-".$queryDataJawabanPegawai[$index_data]["pegawai_id"].$queryDataJawabanPegawai[$index_data]["bank_soal_id"];
    }
    // print_r($arrCheckDataJawabanPegawai);exit;

    $queryJawabanBenar=json_decode(json_encode($queryJawabanBenar), true);
    for($index_data=0; $index_data < count($queryJawabanBenar); $index_data++)
    {
        $arrDataSoalBenarJawaban[$index_data]["ROW_ID"]= $queryJawabanBenar[$index_data]["ujian_id"]."-".$queryJawabanBenar[$index_data]["pegawai_id"].$queryJawabanBenar[$index_data]["bank_soal_id"];
        $arrDataSoalBenarJawaban[$index_data]["UJIAN_ID"]= $queryJawabanBenar[$index_data]["ujian_id"];
        $arrDataSoalBenarJawaban[$index_data]["PEGAWAI_ID"]= $queryJawabanBenar[$index_data]["pegawai_id"];
        $arrDataSoalBenarJawaban[$index_data]["BANK_SOAL_ID"]= $queryJawabanBenar[$index_data]["bank_soal_id"];
        $arrDataSoalBenarJawaban[$index_data]["JAWABAN"]= $queryJawabanBenar[$index_data]["jawaban"];
        $arrDataSoalBenarJawaban[$index_data]["PATH_GAMBAR"]= str_replace("../cat/main/uploads/","images/soal/",$queryJawabanBenar[$index_data]["path_gambar"]);
        $arrDataSoalBenarJawaban[$index_data]["PATH_SOAL"]= $queryJawabanBenar[$index_data]["path_soal"];
        $arrDataSoalBenarJawaban[$index_data]["TIPE_SOAL"]= $queryJawabanBenar[$index_data]["tipe_soal"];
        $arrDataSoalBenarJawaban[$index_data]["TIPE_UJIAN_ID"]= $queryJawabanBenar[$index_data]["tipe_ujian_id"];
    }
    // print_r($arrDataSoalBenarJawaban);exit;
?>
@extends('app/index_lookup') 
@section('content')

<link href="assets/jquery-easyui-1.4.2/themes/default/easyui.css" rel="stylesheet" type="text/css" />
<link href="assets/jquery-easyui-1.4.2/themes/icon.css" rel="stylesheet" type="text/css" />
<script src="assets/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/jquery-easyui-1.4.2/themes/default/easyui.css">
<script src="assets/js/jquery-ui.js"></script>

<div class="d-flex flex-column-fluid" style="margin-top: 20px">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">Jawaban Peserta</h3>
                </div>
            </div>
            <div class="card-body" style="height:80vh; overflow: scroll;">
                <?php
                $chektablebaru= $tempCheckValue= "";
                for($index_data=0; $index_data < count($arrData); $index_data++)
                {
                    $reqBankSoalRowId= $arrData[$index_data]["ROW_ID"];
                    $req= $arrData[$index_data]["UJIAN_ID"];
                    $req= $arrData[$index_data]["PEGAWAI_ID"];
                    $reqBankSoalId= $arrData[$index_data]["BANK_SOAL_ID"];
                    $reqBankSoalPertanyaan= $arrData[$index_data]["PERTANYAAN"];
                    $reqBankSoalPertanyaan=str_replace("&emsp;","  ",$reqBankSoalPertanyaan);
                    // echo $reqBankSoalPertanyaan;

                    $reqBankSoalPathGambar= $arrData[$index_data]["PATH_GAMBAR"];
                    $reqBankSoalPathSoal= $arrData[$index_data]["PATH_SOAL"];
                    $reqBankSoalTipeSoal= $arrData[$index_data]["TIPE_SOAL"];
                    $reqBankSoalTipeUjianId= $arrData[$index_data]["TIPE_UJIAN_ID"];
                    $reqBankSoalTipeUjianNama= $arrData[$index_data]["TIPE_UJIAN_NAMA"];
                    $req= $arrData[$index_data]["URUT"];

                    if($tempCheckValue == $reqBankSoalTipeUjianId)
                        $chektablebaru= "";
                    else
                        $chektablebaru= "1";

                ?>

                <?php
                if($index_data > 0 && $chektablebaru == "1")
                {
                ?>
                    </tbody>
                </table>
                <?php
                }
                ?>

                <?php
                if($chektablebaru == "1")
                {
                ?>
                <table id='customers'>
                    <tbody class="example altrowstable" id="alternatecolor"> 
                      <?php
                      // echo $reqBankSoalTipeSoal;
                      if($reqBankSoalTipeUjianId == "20" || $reqBankSoalTipeSoal == "3" || $reqBankSoalTipeSoal == "8" || $reqBankSoalTipeSoal == "9"|| $reqBankSoalTipeSoal == "10"|| $reqBankSoalTipeSoal == "5")
                      {
                      ?>
                          <tr>
                              <th colspan="3" style="text-align: center; font-size: 20px;"><b><?= strtoupper($reqBankSoalTipeUjianNama)?></b></th>
                          </tr>
                          <tr>
                              <th style="width: 30%">Soal</th>
                              <th>Jawaban Peserta</th>
                              <th style="width: 20%">Kunci Jawaban</th>
                          </tr>
                      <?php
                      }
                      else
                      {
                      ?>
                          <tr>
                              <th colspan="4" style="text-align: center; font-size: 20px;"><b><?= strtoupper($reqBankSoalTipeUjianNama)?></b></th>
                          </tr>
                          <tr>
                              <th style="width: 30%">Soal</th>
                              <th style="width: 40%">Jawaban</th>
                              <th>Jawaban Peserta</th>
                              <th style="width: 10%">Kunci Jawaban</th>
                          </tr>
                      <?php
                      }
                      ?>
                <?php
                }
                ?>
                
                <tr>
                    <?php
                    if($reqBankSoalTipeUjianId == "20"){}
                    else
                    {
                    ?>
                    <td style="text-align: center;">
                        <?php
                        // echo $reqBankSoalTipeSoal;
                        if($reqBankSoalTipeSoal == "1" || $reqBankSoalTipeSoal == "8" || $reqBankSoalTipeSoal == "9" || $reqBankSoalTipeSoal == 10)
                        {
                        ?>
                            <label><?=$reqBankSoalPertanyaan?></label>
                        <?php
                        }
                        elseif($reqBankSoalTipeSoal == "2"||$reqBankSoalTipeSoal == "5")
                        {
                            if($reqBankSoalPathSoal == ""){}
                            else
                            {
                                if(file_exists($reqBankSoalPathGambar.$reqBankSoalPathSoal))
                                {
                            ?>
                                <!-- <img src="<?=$reqBankSoalPathGambar.$reqBankSoalPathSoal?>" style="max-width:100%; height:auto; display: block; text-align: center;" /> -->
                                <img src="<?=$reqBankSoalPathGambar.$reqBankSoalPathSoal?>" style="max-width:100%; display: block; text-align: center;width: auto;" height="75" />
                            <?php
                                }
                            }
                        }
                        elseif($reqBankSoalTipeSoal == "3")
                        {
                            $arrayKey= "";
                            $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataJawaban);
                            // print_r($arrayKey);exit;

                            if($arrayKey == ""){}
                            else
                            {
                                for($i_detil=0; $i_detil < count($arrayKey); $i_detil++)
                                {
                                    $index_data_detil= $arrayKey[$i_detil];
                                    $reqBankSoalPathGambar= $arrDataJawaban[$index_data_detil]["PATH_GAMBAR"];
                                    $reqBankSoalPathSoal= $arrDataJawaban[$index_data_detil]["PATH_SOAL"];

                                    if($reqBankSoalPathSoal == ""){}
                                    else
                                    {
                                        if(file_exists($reqBankSoalPathGambar.$reqBankSoalPathSoal))
                                        {
                                    ?>
                                        <img src="<?=$reqBankSoalPathGambar.$reqBankSoalPathSoal?>" height="75" />
                                    <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </td>
                    <?php
                    }
                    ?>

                    <?php
                    if($reqBankSoalTipeSoal == "1" || $reqBankSoalTipeSoal == "2" || $reqBankSoalTipeSoal == "10000")
                    {
                    ?>
                    <td style="text-align: center;">
                        <?php
                        if($reqBankSoalTipeSoal == "1000")
                        {
                            $arrayKey= "";
                            $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataIstJawaban);
                            // print_r($arrayKey);exit;

                            if($arrayKey == ""){}
                            else
                            {
                                for($i_detil=0; $i_detil < count($arrayKey); $i_detil++)
                                {
                                    $index_data_detil= $arrayKey[$i_detil];
                                    $reqBankSoalJawaban= $arrDataIstJawaban[$index_data_detil]["JAWABAN_KETERANGAN"];
                        ?>
                                    <label><?=$reqBankSoalJawaban?></label><br/>
                        <?php
                                }
                            }
                        }
                        else
                        {
                            $arrayKey= "";
                            $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataJawaban);
                            // print_r($arrayKey);exit;

                            if($arrayKey == ""){}
                            else
                            {
                                for($i_detil=0; $i_detil < count($arrayKey); $i_detil++)
                                {
                                    $index_data_detil= $arrayKey[$i_detil];
                                    $reqBankSoalPathGambar= $arrDataJawaban[$index_data_detil]["PATH_GAMBAR"];
                                    $reqBankSoalPathSoal= $arrDataJawaban[$index_data_detil]["PATH_SOAL"];
                                    $reqBankSoalJawaban= $arrDataJawaban[$index_data_detil]["JAWABAN"];

                                    if($reqBankSoalPathSoal == "")
                                    {
                                    ?>
                                        <label>- <?=$reqBankSoalJawaban?></label><br/>
                                    <?php
                                    }
                                    else
                                    {
                                        if(file_exists($reqBankSoalPathGambar.$reqBankSoalPathSoal))
                                        {
                                    ?>
                                        <img src="<?=$reqBankSoalPathGambar.$reqBankSoalPathSoal?>" height="75" />
                                    <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </td>
                    <?php
                    }
                    ?>

                    <?php
                    $stylebenarcheck= "";
                    $arrayKey= "";

                    if($reqBankSoalTipeSoal == "1000"){}
                    else
                    {
                        // $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrCheckDataJawabanPegawai);
                        if($reqBankSoalTipeSoal == "8"){
                                // $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrCheckDataJawabanPegawai56);
                            $arrayKey=array_search($reqBankSoalRowId,$arrCheckDataJawabanPegawai56);

                        // print_r($reqBankSoalRowId); echo "xxxx->";print_r($arrCheckDataJawabanPegawai); echo "<br>";

                        }
                        else if($reqBankSoalTipeSoal == "10"){
                            $arrayKey=array_search($reqBankSoalRowId,$arrCheckDataJawabanPegawai6r);
                        }
                        else    {
                            $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrCheckDataJawabanPegawai);
                        }

                        if(empty($arrayKey)){
                        }
                        else
                        {
                            $stylebenarcheck= ";background-color: green;";
                        }
                    ?>

                    <td style="text-align: center; <?=$stylebenarcheck?>">
                        <?php  
                            // print_r($arrayKey);
                            $arrayKey= "";
                            if($reqBankSoalTipeSoal == "8"){
                                $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataJawabanPegawai56);  

                                // echo $arrayKey;
                            }
                            else if($reqBankSoalTipeSoal == "10"){
                                $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataJawabanPegawai6r);
                                // print_r($arrayKey);
                            }
                            else{ 
                                $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataJawabanPegawai);
                            }

                            if($arrayKey == ""){}
                            else
                            {
                                for($i_detil=0; $i_detil < count($arrayKey); $i_detil++)
                                {
                                    $index_data_detil= $arrayKey[$i_detil];
                                    if($reqBankSoalTipeSoal == "8")
                                    {
                                        $reqBankSoalPathGambar= $arrDataJawabanPegawai56[$index_data_detil]["PATH_GAMBAR"];
                                        $reqBankSoalPathSoal= $arrDataJawabanPegawai56[$index_data_detil]["PATH_SOAL"];
                                        $reqBankSoalJawaban= $arrDataJawabanPegawai56[$index_data_detil]["JAWABAN"];
                                    }
                                    else if($reqBankSoalTipeSoal == "10")
                                    {
                                        $reqBankSoalPathGambar= $arrDataJawabanPegawai6r[$index_data_detil]["PATH_GAMBAR"];
                                        $reqBankSoalPathSoal= $arrDataJawabanPegawai6r[$index_data_detil]["PATH_SOAL"];
                                        $reqBankSoalJawaban= $arrDataJawabanPegawai6r[$index_data_detil]["JAWABAN"];
                                    }
                                    else
                                    {
                                        $reqBankSoalPathGambar= $arrDataJawabanPegawai[$index_data_detil]["PATH_GAMBAR"];
                                        $reqBankSoalPathSoal= $arrDataJawabanPegawai[$index_data_detil]["PATH_SOAL"];
                                        $reqBankSoalJawaban= $arrDataJawabanPegawai[$index_data_detil]["JAWABAN"];
                                        
                                    }
                                    
                                    // echo "xxxx".$reqBankSoalPathSoal;
                                    if($reqBankSoalPathSoal == "")
                                    {
                                    ?>
                                        <label><?=$reqBankSoalJawaban?></label>
                                    <?php
                                    }
                                    else
                                    {
                                        if(file_exists($reqBankSoalPathGambar.$reqBankSoalPathSoal))
                                        {
                                    ?>
                                        <img src="<?=$reqBankSoalPathGambar.$reqBankSoalPathSoal?>" height="75" />
                                    <?php
                                        }
                                    }
                                }
                            }
                    ?>
                        </td>
                    <?php
                    }
                    ?>

                    <td style="text-align: center;">
                    <?php
                        $arrayKey= "";

                        // if($reqBankSoalTipeSoal == "8")
                        //  $arrayKey= StringFunc::in_array_column($reqBankSoalId, "ROW_ID", $arrDataIstKunciJawaban);
                        // else
                            // $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataJawabanPegawai);
                            $arrayKey= StringFunc::in_array_column($reqBankSoalRowId, "ROW_ID", $arrDataSoalBenarJawaban);

                        // print_r($arrayKey);exit;

                        if($arrayKey == ""){}
                        else
                        {
                            for($i_detil=0; $i_detil < count($arrayKey); $i_detil++)
                            {
                                $index_data_detil= $arrayKey[$i_detil];

                                if($reqBankSoalTipeSoal == "8")
                                {
                                    $reqBankSoalPathSoal= ";

                                    $separator= ";
                                    if($i_detil > 0)
                                        $separator= "<br/>";

                                    $reqBankSoalJawaban= $separator.$arrDataIstKunciJawaban[$index_data_detil]["JAWABAN_KETERANGAN"];
                                    $reqBankSoalJawaban= $arrDataSoalBenarJawaban[$index_data_detil]["JAWABAN"];
                                }
                                else
                                {
                                    $reqBankSoalPathGambar= $arrDataSoalBenarJawaban[$index_data_detil]["PATH_GAMBAR"];
                                    $reqBankSoalPathSoal= $arrDataSoalBenarJawaban[$index_data_detil]["PATH_SOAL"];
                                    $reqBankSoalJawaban= $arrDataSoalBenarJawaban[$index_data_detil]["JAWABAN"];
                                }

                                if($reqBankSoalPathSoal == "")
                                {
                                ?>
                                    <label><?=$reqBankSoalJawaban?></label>
                                <?php
                                }
                                else
                                {
                                    if(file_exists($reqBankSoalPathGambar.$reqBankSoalPathSoal))
                                    {
                                ?>
                                    <img src="<?=$reqBankSoalPathGambar.$reqBankSoalPathSoal?>" height="75" />
                                <?php
                                    }
                                }
                            }
                        }
                    ?>
                    </td>

                </tr>

                <?php
                    $tempCheckValue= $reqBankSoalTipeUjianId;
                }
                ?>

                <?php
                if($index_data > 0)
                {
                ?>
                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

@endsection
