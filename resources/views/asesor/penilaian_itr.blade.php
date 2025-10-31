@extends('asesor/index') 
@section('content')
<?php
$queryPenialanPegawai=json_decode(json_encode($queryPenialanPegawai), true);
$queryPenialanPegawaiJawaban=json_decode(json_encode($queryPenialanPegawaiJawaban), true);
$jawaban=array();
// print_r($queryPenialanPegawaiJawaban);exit;
$user=Session::get('user');
$reqPegawaiId=$user->penilaian_pegawai_id;
$reqJadwalTesId = $user->penilaian_ujian_id;
$reqTgl = $user->penilaian_tgl;
$reqAsesorId = $user->pegawai_id;
$disabled='';
if($query->asesor_id!=$reqAsesorId){
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
                    <h3 class="card-label">Penilaian <?=$query->penggalian_nama?></h3>
                </div>
            </div>
            <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off" >
                <div style="height:60vh; overflow: scroll;">
                    <div class="card-body" style="border: solid gray 0.5px;border-radius: 10px; margin: 15px;">
                        <div class="card-title">
                            <h6> Jawaban Peserta</h6>
                            <table id="customers">
                                <tr>
                                    <th width="20%">Nama Soal</th>
                                    <th width="10%">File Soal</th>
                                    <th>Jawaban Peserta</th>
                                </tr>
                                <?php
                                for($i=0;$i<count($queryPenialanPegawaiJawaban);$i++){?>
                                    <tr>
                                        <td><?=$queryPenialanPegawaiJawaban[$i]['keterangan']?></td>
                                        <td style="text-align:center;">
                                            <a target="_blank" href="template_soal/itr/<?=$queryPenialanPegawaiJawaban[$i]['file']?>" class="btn btn-warning font-weight-bold mr-2" style="padding: 5px 15px;"> lihat file</a>
                                        </td>
                                        <td><?=$queryPenialanPegawaiJawaban[$i]['jawaban']?></td>
                                    </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                    <?php
                    $checkattirbut=''; 
                    $checkattirbutNext=$queryPenialanPegawai[0]['atribut_id']; 
                    for($i=0;$i<count($queryPenialanPegawai);$i++)
                    {
                        $atribut_nama=$queryPenialanPegawai[$i]['atribut_nama'];
                        $atribut_id=$queryPenialanPegawai[$i]['atribut_id'];
                        $nama_indikator=$queryPenialanPegawai[$i]['nama_indikator'];
                        $jadwal_pegawai_detil_id=$queryPenialanPegawai[$i]['jadwal_pegawai_detil_id'];
                        $penggalian_id=$queryPenialanPegawai[$i]['penggalian_id'];
                        $level_id=$queryPenialanPegawai[$i]['level_id'];
                        $indikator_id=$queryPenialanPegawai[$i]['indikator_id'];
                        $jadwal_pegawai_id=$queryPenialanPegawai[$i]['jadwal_pegawai_id'];
                        $jadwal_asesor_id=$queryPenialanPegawai[$i]['jadwal_asesor_id'];
                        $atribut_id=$queryPenialanPegawai[$i]['atribut_id'];
                        $form_permen_id=$queryPenialanPegawai[$i]['form_permen_id'];
                        $jadwal_pegawai_detil_atribut_id=$queryPenialanPegawai[$i]['jadwal_pegawai_detil_atribut_id'];
                        $nilai_standar=$queryPenialanPegawai[$i]['nilai_standar'];
                        $nilai=$queryPenialanPegawai[$i]['nilai'];
                        $gap=$queryPenialanPegawai[$i]['gap'];
                        $catatan=$queryPenialanPegawai[$i]['catatan'];
                        if($i+1<count($queryPenialanPegawai)){
                            $atribut_id_next=$queryPenialanPegawai[$i+1]['atribut_id'];
                        }
                        else{
                            $atribut_id_next='xxxxx';
                        }

                        $checked='';
                        $reqActive='';
                        if(!empty($jadwal_pegawai_detil_id)){
                            $checked='checked';
                            $reqActive='1';
                        }
                        if($atribut_id!=$checkattirbut){
                    ?>
                        
                        <div class="card-body" style="border: solid gray 0.5px;border-radius: 10px; margin: 15px;">
                            <div class="card-title">
                                <h6> <?=$atribut_nama?></h6>
                                <input type="hidden" name="reqJadwalPegawaiDetilAttributId[]" value="<?=$jadwal_pegawai_detil_atribut_id?>">
                                <input type="hidden" name="reqPenggalianIdAttribut[]" value="<?=$penggalian_id?>">
                                <input type="hidden" name="reqJadwalPegawaiIdAttribut[]" value="<?=$jadwal_pegawai_id?>">
                                <input type="hidden" name="reqJadwalAsesorIdAttribut[]" value="<?=$jadwal_asesor_id?>">
                                <input type="hidden" name="reqAtributIdAttribut[]" value="<?=$atribut_id?>">
                                <input type="hidden" name="reqFormPermenIdAttribut[]" value="<?=$form_permen_id?>">
                                <input type="hidden" name="reqNilaiStandartAttribut[]" value="<?=$nilai_standar?>">
                                <input type="hidden" name="reqGapAttribut[]" value="<?=$gap?>">
                            </div>
                            <div class="row">
                                <?php
                                if($query->penggalian_kode=='PE'){?>
                                    <div class="col-md-10" style="margin-left: 1%;">
                                <?php }else{?>
                                    <div class="col-md-5" style="margin-left: 1%;">
                            <?php
                                } 
                            $checkattirbut=$atribut_id;
                        }
                        if($checkattirbut==$checkattirbut){?>
                                    <div class="row" style="border: solid gray 0.5px;padding: 10px;border-radius: 10px;">
                                        <div style="width:5%">
                                            <input type="checkbox" <?=$disabled?> <?=$checked?> class="reqActiveCheckbox" id='reqActive-<?=$indikator_id?>' value="1">
                                            <input type="hidden" name="reqActive[]" id='reqActiveVal-<?=$indikator_id?>' value="<?=$reqActive?>">
                                        </div>
                                        <div style="width:95%">
                                            <?=$nama_indikator?>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" name="reqJadwalPegawaiDetilId[]" value="<?=$jadwal_pegawai_detil_id?>">
                                    <input type="hidden" name="reqPenggalianId[]" value="<?=$penggalian_id?>">
                                    <input type="hidden" name="reLevelId[]" value="<?=$level_id?>">
                                    <input type="hidden" name="reqIndikatorId[]" value="<?=$indikator_id?>">
                                    <input type="hidden" name="reqJadwalPegawaiId[]" value="<?=$jadwal_pegawai_id?>">
                                    <input type="hidden" name="reqJadwalAsesorId[]" value="<?=$jadwal_asesor_id?>">
                                    <input type="hidden" name="reqAtributId[]" value="<?=$atribut_id?>">
                                    <input type="hidden" name="reqFormPermenId[]" value="<?=$form_permen_id?>">
                        <?php 
                        }
                        if($checkattirbutNext!=$atribut_id_next)
                        {?>
                                </div>
                                <div class="col-md-1">
                                    <select class="form-control" name="reqNilaiAttribut[]" <?=$disabled?>>
                                        <option value="" <?php if(empty($nilai) ) {echo "selected";} ?> disabled></option>
                                        <option value="0" <?php if(strval($nilai=== 0)) {echo "selected";} ?>>0</option>
                                        <option value="1" <?php if($nilai==1) {echo "selected";} ?>>1</option>
                                        <option value="2" <?php if($nilai==2) {echo "selected";} ?>>2</option>
                                        <option value="3" <?php if($nilai==3) {echo "selected";} ?>>3</option>
                                        <option value="4" <?php if($nilai==4) {echo "selected";} ?>>4</option>
                                        <option value="5" <?php if($nilai==5) {echo "selected";} ?>>5</option>
                                    </select>
                                </div>
                                <?php
                                if($query->penggalian_kode!='PE'){?>
                                    <div class="col-md-5">
                                        <textarea class="form-control" style="height: 100%;" name="reqCatatanAttribut[]" <?=$disabled?>><?=$catatan?></textarea>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php
                            $checkattirbutNext=$atribut_id_next;
                        } 
                    }?>
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
                            <input type="hidden" name="reqJadwalTesId" value="<?=$reqJadwalTesId?>">
                            <input type="hidden" name="reqPegawaiId" value="<?=$reqPegawaiId?>">
                            <input type="hidden" name="reqAsesorId" value="<?=$reqAsesorId?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var url = "Asesor/addAsesor";

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
                                document.location.href = "app/asesor/penilaian/<?=$reqId?>";
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

    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll('.reqActiveCheckbox');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var id = this.id.split('-')[1];
                var textField = document.getElementById('reqActiveVal-' + id);
                if (this.checked) {
                    textField.value = "1"; // Or any other value you want to set
                } else {
                    textField.value = ""; // Clear the value if checkbox is unchecked
                }
            });
        });
    });
</script>
@endsection








        
