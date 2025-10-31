<?php
$disabled='';
if($query->penggalian_kode_status==0){
    $disabled='disabled';
}

// print_r($profil_kelemahan);exit;
if(!empty($profil_kekuatan)){
    $profil_kekuatan_nama=$profil_kekuatan->keterangan;
    $profil_kekuatan_id=$profil_kekuatan->penilaian_rekomendasi_id;
}
else{
    $profil_kekuatan_nama=$profil_kekuatan_id='';
}

if(!empty($profil_kelemahan)){
    $profil_kelemahan_nama=$profil_kelemahan->keterangan;
    $profil_kelemahan_id=$profil_kelemahan->penilaian_rekomendasi_id;
}
else{
    $profil_kelemahan_nama=$profil_kelemahan_id='';
}

if(!empty($profil_rekomendasi)){
    $profil_rekomendasi_nama=$profil_rekomendasi->keterangan;
    $profil_rekomendasi_id=$profil_rekomendasi->penilaian_rekomendasi_id;
}
else{
    $profil_rekomendasi_nama=$profil_rekomendasi_id='';
}

if(!empty($profil_saran_pengembangan)){
    $profil_saran_pengembangan_nama=$profil_saran_pengembangan->keterangan;
    $profil_saran_pengembangan_id=$profil_saran_pengembangan->penilaian_rekomendasi_id;
}
else{
    $profil_saran_pengembangan_nama=$profil_saran_pengembangan_id='';
}

if(!empty($profil_saran_penempatan)){
    $profil_saran_penempatan_nama=$profil_saran_penempatan->keterangan;
    $profil_saran_penempatan_id=$profil_saran_penempatan->penilaian_rekomendasi_id;
}
else{
    $profil_saran_penempatan_nama=$profil_saran_penempatan_id='';
}

if(!empty($profil_kepribadian)){
    $profil_kepribadian_nama=$profil_kepribadian->keterangan;
    $profil_kepribadian_id=$profil_kepribadian->penilaian_rekomendasi_id;
}
else{
    $profil_kepribadian_nama=$profil_kepribadian_id='';
}
?>
@extends('asesor/index') 
@section('content')
<div class="d-flex flex-column-fluid">        
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Kesimpulan</h3>
                </div>
            </div>
            <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="card-body" style="height:60vh; overflow: scroll;">
                    <table id='customers'>
                        <tr>
                            <th style="text-align: left;"> Kelebihan 
                                <!-- <button type="submit" id="ktloginformsubmitbutton" class="btn btn-warning font-weight-bold mr-2" style="padding:5px"><i class="fa fa-plus" style="padding: 0px;"></i></button> -->
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" name='reqKeterangan[]' <?=$disabled?>><?=$profil_kekuatan_nama?></textarea>
                                <input type="hidden" name='reqPenilaianRekomendasiId[]' value="<?=$profil_kekuatan_id?>">
                                <input type="hidden" name='reqTipeInputan[]' value="profil_kekuatan">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id='customers'>
                        <tr>
                            <th style="text-align: left;"> Kelemahan</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" name='reqKeterangan[]' <?=$disabled?>><?=$profil_kelemahan_nama?></textarea>
                                <input type="hidden" name='reqPenilaianRekomendasiId[]' value="<?=$profil_kelemahan_id?>">
                                <input type="hidden" name='reqTipeInputan[]' value="profil_kelemahan">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id='customers'>
                        <tr>
                            <th style="text-align: left;"> Rekomendasi</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" name='reqKeterangan[]' <?=$disabled?>><?=$profil_rekomendasi_nama?></textarea>
                                <input type="hidden" name='reqPenilaianRekomendasiId[]' value="<?=$profil_rekomendasi_id?>">
                                <input type="hidden" name='reqTipeInputan[]' value="profil_rekomendasi">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id='customers'>
                        <tr>
                            <th style="text-align: left;"> Saran Pengembangan</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" name='reqKeterangan[]' <?=$disabled?>><?=$profil_saran_pengembangan_nama?></textarea>
                                <input type="hidden" name='reqPenilaianRekomendasiId[]' value="<?=$profil_saran_pengembangan_id?>">
                                <input type="hidden" name='reqTipeInputan[]' value="profil_saran_pengembangan">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id='customers'>
                        <tr>
                            <th style="text-align: left;"> Saran Penempatan</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" name='reqKeterangan[]' <?=$disabled?>><?=$profil_saran_penempatan_nama?></textarea>
                                <input type="hidden" name='reqPenilaianRekomendasiId[]' value="<?=$profil_saran_penempatan_id?>">
                                <input type="hidden" name='reqTipeInputan[]' value="profil_saran_penempatan">
                            </td>
                        </tr>
                    </table>
                    <br>
                    <!--<table id='customers'>-->
                    <!--    <tr>-->
                    <!--        <th style="text-align: left;"> Ringkasan Profil Kompetensi</th>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--        <td>-->
                    <!--            <textarea class="form-control" name='reqKeterangan[]' <?=$disabled?>><?=$profil_kepribadian_nama?></textarea>-->
                    <!--            <input type="hidden" name='reqPenilaianRekomendasiId[]' value="<?=$profil_kepribadian_id?>">-->
                    <!--            <input type="hidden" name='reqTipeInputan[]' value="profil_kepribadian">-->
                    <!--        </td>-->
                    <!--    </tr>-->
                    <!--</table>-->
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
    var url = "Asesor/addKesimpulan";

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
                                document.location.href = "app/asesor/kesimpulan/<?=$reqId?>";
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








        
