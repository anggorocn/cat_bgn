@extends('asesor/index') 
@section('content')
<?php
$queryPenialanPegawai=json_decode(json_encode($queryPenialanPegawai), true);
$arrPegawaiAsesor=json_decode(json_encode($arrPegawaiAsesor), true);
$arrPegawaiPenilaian=json_decode(json_encode($arrPegawaiPenilaian), true);
// print_r($queryPenialanPegawai);exit;
$disabled='';
if($query->penggalian_kode_status==0){
    $disabled='disabled';
}
?>
<div class="d-flex flex-column-fluid">        
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Nilai Akhir</h3>
                </div>
            </div>
            <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="card-body" style="height:60vh; overflow: scroll;">
                    <table id='customers'>
                        <tr>
                            <th> No</th>
                            <th> ATRIBUT & INDIKATOR</th>
                            <?php
                            for($index_loop=0; $index_loop < count($arrPegawaiAsesor); $index_loop++)
                            {
                              $reqInfoPenggalianKode= $arrPegawaiAsesor[$index_loop]["penggalian_kode"];
                            ?>
                            <th style="text-align:center">Nilai <?=$reqInfoPenggalianKode?></th>
                            <?php
                            }
                            ?>
                            <th> Standar<br>Rating</th>
                            <th> Hasil Individu</th>
                            <th> Gap</th>
                        </tr>
                        <?php
                            $nohead=1;

                            for($i=0;$i<count($queryPenialanPegawai);$i++)
                            {
                                $penilaian_detil_id=$queryPenialanPegawai[$i]['penilaian_detil_id'];
                                $nama=$queryPenialanPegawai[$i]['nama'];
                                $nilai_standar=$queryPenialanPegawai[$i]['nilai_standar'];
                                $nilai=$queryPenialanPegawai[$i]['nilai'];
                                $gap=$queryPenialanPegawai[$i]['gap'];
                                $catatan=$queryPenialanPegawai[$i]['catatan'];
                                $aspek_id=$queryPenialanPegawai[$i]['aspek_id'];
                                $reqPenilaianKompetensiAtributId=$queryPenialanPegawai[$i]['atribut_id'];
                                if($aspek_id==2){
                                    if(empty($penilaian_detil_id)){?>
                                        <tr>
                                            <td colspan="<?=count($arrPegawaiAsesor)+5?>" style="font-size:20px ;">
                                                <b> <?=StringFunc::romanic_number($nohead)?>. <?=$nama?></b>
                                            </td>
                                        </tr>
                                    <?php
                                        $no=1;
                                        $nohead++;
                                    }else{?>
                                        <tr>
                                            <td><?=$no?></td>
                                            <td><?=$nama?></td>
                                            <?php
                                            for($index_loop=0; $index_loop < count($arrPegawaiAsesor); $index_loop++)
                                            {
                                              $reqInfoPenggalianKode= $arrPegawaiAsesor[$index_loop]["penggalian_kode"];

                                              $tempCariDataDetilNilai= $arrPegawaiAsesor[$index_loop]["penggalian_id"]."-".$reqPenilaianKompetensiAtributId;

                                              $arrayDetilKey= [];
                                              $arrayDetilKey= StringFunc::in_array_column($tempCariDataDetilNilai, "penggalian_atribut", $arrPegawaiPenilaian);
                                              // print_r($arrayDetilKey);exit;
                                              $tempInfoDataPenggalianAtributNilai= "-";
                                              if(empty($arrayDetilKey)){}
                                              else
                                              {
                                                $index_detil_row= $arrayDetilKey[0];
                                                $tempInfoDataPenggalianAtributNilai= $arrPegawaiPenilaian[$index_detil_row]["nilai"];
                                              }

                                              //============================
                                              $tempCariDataDetilNilai= $reqPenilaianKompetensiAtributId."-".$tempAsesorId."-".$arrPegawaiAsesor[$index_loop]["penggalian_id"];
                                              $arrayDetilKey= [];
                                              $arrayDetilKey= StringFunc::in_array_column($tempCariDataDetilNilai, "penggalian_asesor_id", $arrAsesorPenilaianKompetensi);
                                              // print_r($arrAsesorPenilaianKompetensi);exit();
                                              // print_r($arrayDetilKey);exit;
                                              if($arrayDetilKey == ''){}
                                              else
                                              {
                                                $index_detil_row= $arrayDetilKey[0];
                                                $reqInfoDataPenggalianAsesorId= $arrAsesorPenilaianKompetensi[$index_detil_row]["asesor_id"];

                                                // echo $reqInfoDataPenggalianAsesorId."<br/>";

                                                // kalau data asesor kosong maka set untuk validasi entri
                                                if($reqInfoDataPenggalianAsesorDataId == "")
                                                {
                                                  $reqInfoDataPenggalianAsesorDataId= $reqInfoDataPenggalianAsesorId;
                                                }
                                              }
                                            ?>
                                              <td style="text-align:center;"><?=$tempInfoDataPenggalianAtributNilai?></td>
                                            <?php
                                            }
                                            // exit();
                                            ?>
                                            <td style="text-align: center;"><?=$nilai_standar?></td>
                                            <td>
                                                <input type="hidden" name="reqPenilaianDetilId[]" value="<?=$penilaian_detil_id?>">
                                                <input type="hidden" name="reqNilaiStandart[]" value="<?=$nilai_standar?>">
                                                <select class="form-control" name="reqNilai[]" <?=$disabled?>>
                                                    <option value="" <?php if(empty($nilai) ) {echo "selected";} ?> disabled></option>
                                                    <option value="0" <?php if(strval($nilai=== 0)) {echo "selected";} ?>>0</option>
                                                    <option value="1" <?php if($nilai==1){echo "selected";}?> >1</option>
                                                    <option value="2" <?php if($nilai==2){echo "selected";}?> >2</option>
                                                    <option value="3" <?php if($nilai==3){echo "selected";}?> >3</option>
                                                    <option value="4" <?php if($nilai==4){echo "selected";}?> >4</option>
                                                    <option value="5" <?php if($nilai==5){echo "selected";}?> >5</option>
                                                </select>
                                            </td>
                                            <td><?=$gap?></td>
                                        </tr>
<!--                                         <tr>
                                            <td colspan="<?=count($arrPegawaiAsesor)+6?>">
                                                Deskripsi
                                                <textarea class="form-control" style="height: 100%;" name="reqCatatan[]" <?=$disabled?>><?=$catatan?></textarea>
                                            </td>
                                        </tr> -->
                                <?php 
                                        $no++;
                                    }
                                }
                            }?>
                        
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9">
                            <?php
                            if($disabled=='disabled'){?>
                                <span style="color:black;">anda hanya bisa melihat, karena anda tidak bertugas di penilaian ini</span>
                            <?php }
                            else{?>
                                <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var url = "Asesor/addNilaiAkhir";

    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
    jQuery(document).ready(function() {
        var form = KTUtil.getById('ktloginform');
        var formSubmitUrl = url;
        var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');
        if (!form) {
            return;
        }
        FormValidation
        .formValidation(
            form,
            {
                fields: {

                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
            )
        .on('core.form.valid', function() {
                // Show loading state on button
                KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
                var formData = new FormData(form);
                
                $.ajax({
                    url: formSubmitUrl,
                    data: formData,
                    contentType: false,
                    processData: false,
                    type: 'POST'
                    // dataType: 'json'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    // , 'Content-Type': 'application/json' 
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        // console.log(data); return false;
                        data= data.message;
                        data= data.split("-");
                        rowid= data[0];
                        infodata= data[1];

                        if(rowid == "xxx")
                        {
                            Swal.fire("Error", infodata, "error");
                        }
                        else
                        {
                            Swal.fire({
                                text: infodata,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                document.location.href = "app/asesor/nilaiakhir/<?=$reqId?>";
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = JSON.parse(xhr.responseText);
                        Swal.fire("Error", err.message, "error");
                    },
                    complete: function () {
                        KTUtil.btnRelease(formSubmitButton);
                    }
                });
            })
        .on('core.form.invalid', function() {
            Swal.fire({
                text: "Check kembali isian pada form",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            }).then(function() {
                KTUtil.scrollTop();
            });
        });
    });
</script>
@endsection








        
