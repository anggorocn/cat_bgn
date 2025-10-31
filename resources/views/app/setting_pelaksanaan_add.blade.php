<?php
$reqId=$reqFormula=$reqTahun=$reqKeterangan=$reqTipeFormula='';
// print_r($query);exit;
if (!empty($query))
{
  $reqId=$query->formula_id ;
  $reqFormula=$query->formula ;
  $reqTahun=$query->tahun ;
  $reqKeterangan=$query->keterangan ;
  $reqTipeFormula=$query->tipe_formula ;
  $reqTerpakai=$query->terpakai ;

}
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
                <div class="containerNew">
                    <?php
                    if(!empty($query)){?>
                        <div class="left" id="left-content"></div>
                    <?php } ?>
                    <div class="contentNew" id="contentNew">
                        <div class="container">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-notepad text-primary"></i>
                                        </span>
                                        <h3 class="card-label">Identitas Formula</h3>
                                    </div>
                                </div>

                                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tahun</label>
                                            <div class="col-lg-3 col-sm-12">
                                                <select name='reqTahun' class="form-control">
                                                    <?php
                                                    $tahunini=date('Y');
                                                    $batastahun=$tahunini+3;
                                                    for($i=$tahunini; $i<$batastahun; $i++)
                                                    {
                                                        ?>
                                                        <option><?=$i?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <!-- <input type="text" class="form-control" name="reqTahun" id="reqTahun" value="{{$reqTahun}}" required /> -->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Formula</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqFormula" id="reqFormula" value="{{$reqFormula}}" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Keterangan</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <textarea class="form-control" name="reqKeterangan" >{{$reqKeterangan}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tipe Formula</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <select class="form-control" name="reqTipeFormula" <?php if(!empty($reqTerpakai)){ ?> disabled <?php } ?>>
                                                    <option <?php if($reqTipeFormula==1){ echo 'selected';}?> value="1">Assesmet Center</option>
                                                    <option <?php if($reqTipeFormula==2){ echo 'selected';}?> value="2">Rapid Tes</option>
                                                    <option <?php if($reqTipeFormula==3){ echo 'selected';}?> value="3">SJT Tes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php if(!empty($reqTerpakai)){ ?>
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-lg-2 col-sm-12"></label>
                                                <div class="col-lg-8 col-sm-12">
                                                    <span style="color:red; font-size: 12px;">*formula sudah di set di ujian. tipe formula tidak bisa diubah</span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <input type="hidden" name="reqId" value="{{$reqId}}">
                                                <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        var url = "SettingPelaksanaan/addFormula";

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
                                    document.location.href = "app/setting_pelaksanaan/add/"+rowid;
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
    </script>

@endsection