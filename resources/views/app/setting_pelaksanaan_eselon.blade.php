<?php
// print_r($queryFormula->tipe_formula);exit;
?>
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
                        <h3 class="card-label">Setting Formula</h3>
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                                            <h3 class="card-label">Formula Eselon</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <input type="hidden" name="reqId" value="<?=$reqId?>">
                                            <?php if(!empty($queryFormula->terpakai)){ ?>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 col-sm-12">
                                                        <span style="color:red; font-size: 12px;">*formula sudah di set di ujian. tipe formula tidak bisa diubah</span>
                                                    </div>
                                                </div>
                                            <?php } 
                                            else{
                                            ?>
                                                <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            
                                            <table id='customers'>
                                                <tr>                                    
                                                    <?php if($queryFormula->tipe_formula=='1'){?>
                                                        <th rowspan="2" width="50%">Eselon</th>
                                                        <th colspan="3" style="text-align: center;">Prosentase</th>
                                                    <?php }
                                                    else{?>
                                                        <th width="50%">Eselon</th>
                                                        <th style="text-align: center;">Pilih</th>
                                                    <?php }?>
                                                </tr>

                                                <tr>                                    
                                                    <?php if($queryFormula->tipe_formula =='1'){?>
                                                        <th>Potensi</th>
                                                        <th>Kompetensi</th>
                                                        <th>Total</th>
                                                    <?php }?>
                                                </tr>
                                                    <?php if($queryFormula->tipe_formula=='1'){
                                                        foreach ($query as $key => $value) {?>
                                                            <tr>
                                                                <input type="hidden" value="<?=$value->formula_eselon_id?>" name="reqFormulaEselonId[]">
                                                                <input type="hidden" value="<?=$value->eselon_id?>" name="reqEselonId[]">
                                                                <td><?=$value->nama_eselon?></td>
                                                                <td><input type="text" name="reqProsenPotensi[]" class="form-control" id='potensi<?=$value->eselon_id?>' value="<?=$value->prosen_kompetensi?>"></td>
                                                                <td><input type="text" name="reqProsenKomptensi[]" class="form-control" id='kompetensi<?=$value->eselon_id?>' value="<?=$value->prosen_potensi?>"></td>
                                                                <td><input type="text" name="reqProsenTotal[]" class="form-control" id='total<?=$value->eselon_id?>' value="<?=$value->prosen_total?>"></td>
                                                            </tr>
                                                        <?php }
                                                    }
                                                    else{                                                        
                                                        foreach ($query as $key => $value) {?>
                                                            <tr>
                                                                <input type="hidden" value="<?=$value->formula_eselon_id?>" name="reqFormulaEselonId[]">
                                                                <input type="hidden" value="<?=$value->eselon_id?>" name="reqEselonId[]">
                                                                <td><?=$value->nama_eselon?></td>
                                                                <td>
                                                                    <input type="text" name="reqProsenPotensi[]" class="form-control" id='potensi<?=$value->eselon_id?>' value="<?=$value->prosen_kompetensi?>">
                                                                    <input type="text" name="reqProsenKomptensi[]" class="form-control" id='kompetensi<?=$value->eselon_id?>' value="<?=$value->prosen_potensi?>" style="display: None;" >
                                                                    <input type="text" name="reqProsenTotal[]" class="form-control" id='total<?=$value->eselon_id?>' value="<?=$value->prosen_total?>"  style="display: None;">
                                                                </td>

                                                            </tr>
                                                        <?php }
                                                    }?>                                             
                                            </table>
                                        </div>
                                        
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        var url = "SettingPelaksanaan/addEselon";

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
                    isValid=true;
                    let jumlahPotensi = $("[id^='total']").length;
                    for (i=0; i<jumlahPotensi; i++){
                        total=$("#total"+i).val();
                        if (total){

                            if(total!=100){
                                Swal.fire("Error", "Jumlah total harus 100 dan harus berupa angka.", "error");
                                isValid = false; 
                            }                    
                        }
                    }

                    if (!isValid) {
                        return;
                    }

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
                                    document.location.href = "app/setting_pelaksanaan/eselon/"+rowid;
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

        fetch('/app/setting_pelaksanaan/edit/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));

        $("[id^='potensi'], [id^='kompetensi']").on('input', function() {
            id = $(this).attr('id');
            id=id.replace("potensi", "");
            id=id.replace("kompetensi", "");
            potensi=$("#potensi"+id).val();
            kompetensi=$("#kompetensi"+id).val();
            if(potensi=='' ||kompetensi==''){

            }
            else{
                total= parseInt(potensi)+parseInt(kompetensi);
                if(total>100){
                    $("#potensi"+id).val('');
                    $("#kompetensi"+id).val('');
                    $("#total"+id).val('');
                    Swal.fire("Error", 'total Lebih Dari 100', "error");
                }
                else{
                    $("#total"+id).val(total);
                }
            }
        });
    </script>

@endsection