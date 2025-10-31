<?php
    $eselon=json_decode(json_encode($eselon), true);
    $satker=json_decode(json_encode($satker), true);
    // print_r($satker);exit;
    $reqNip=$reqNama=$reqJabatan=$reqEselon=$reqSatker='';
    if(!empty($query)){
        $reqNip=$query->nip_baru;    
        $reqNama=$query->nama;    
        $reqJabatan=$query->last_jabatan;    
        $reqEselon=$query->last_eselon_id;    
        $reqSatker=$query->satker_id;    
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
                            <i class="flaticon2-supermarket text-primary"></i>
                        </span>
                        <h3 class="card-label"> Kelola Peserta</h3>
                    </div>
                </div>
                <div class="card-body">                    
                    <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">NIP</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" name="reqNip" id="reqNip" value="<?=$reqNip?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nama</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqNama" id="reqNama" value="<?=$reqNama?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Jabatan</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqJabatan" id="reqJabatan" value="<?=$reqJabatan?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Kelompok Level Jabatan</label>
                                <div class="col-lg-4 col-sm-12">
                                    <select class="form-control"  name="reqEselon" id="reqEselon">
                                        <option <?php if($reqEselon==''){echo 'selected';}?> disabled value=""> Pilih Eselon </option>
                                        <?php
                                            for($i=0;$i<count($eselon);$i++){?>
                                            <option <?php if($reqEselon==$eselon[$i]['eselon_id']){echo 'selected';}?>  value="<?=$eselon[$i]['eselon_id']?>"><?=$eselon[$i]['note']?> <?=$eselon[$i]['nama']?></option>
                                            <?php 
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Satuan Kerja</label>
                                <div class="col-lg-4 col-sm-12">
                                    <select class="form-control"  name="reqSatker" id="reqSatker">
                                        <option <?php if($reqSatker==''){echo 'selected';}?> disabled value=""> Pilih Satuan Kerja </option>
                                        <?php
                                            for($i=0;$i<count($satker);$i++){?>
                                            <option <?php if($reqSatker==$satker[$i]['satker_id']){echo 'selected';}?>  value="<?=$satker[$i]['satker_id']?>"><?=$satker[$i]['nama']?></option>
                                            <?php 
                                        }?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9">
                                    <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button>
                                    <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                    <input type='hidden' value='<?=$reqId?>' name='reqId'> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function kembali() {
            window.location.href='app/pegawai/index';
        }

        var url = "/Pegawai/add";

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
                        reqNip: {
                            validators: {
                                notEmpty: {
                                    message: 'Nip harus diisi'
                                }
                            }
                        },
                        reqNama: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama harus diisi'
                                }
                            }
                        },
                        reqJabatan: {
                            validators: {
                                notEmpty: {
                                    message: 'Jabatan harus diisi'
                                }
                            }
                        },
                         reqEselon: {
                            validators: {
                                notEmpty: {
                                    message: 'Eselon harus diisi'
                                }
                            }
                        },
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
                                    document.location.href = "app/pegawai/add/"+rowid;
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