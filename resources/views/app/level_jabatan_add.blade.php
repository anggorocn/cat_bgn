<?php
    $reqNama = $reqIntegritas = $reqKerjasama = $reqKomunikasi = $reqOPH = $reqPelayananPublik = $reqMengembangkanDiri = $reqMengelolahPerubahan = $reqPengambilanKeputusan = $reqPerekatBangsa = '';
    if(!empty($query)){
        $reqNama=$query->nama;    
        $reqIntegritas=$query->integritas;    
        $reqKerjasama=$query->kerjasama;    
        $reqKomunikasi=$query->komunikasi;    
        $reqOPH=$query->orientasi_hasil;    
        $reqPelayananPublik=$query->pelayanan_publik;    
        $reqMengembangkanDiri=$query->mengembangkan_diri;    
        $reqMengelolahPerubahan=$query->mengelolah_perubahan;    
        $reqPengambilanKeputusan=$query->pengambilan_keputusan;    
        $reqPerekatBangsa=$query->perekat_bangsa;    
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
                        <h3 class="card-label"> Kelola Level Jabatan</h3>
                    </div>
                </div>
                <div class="card-body">                    
                    <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nama Level Jabatan</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" name="reqNama" id="reqNama" value="<?=$reqNama?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Integritas</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqIntegritas" id="reqIntegritas" value="<?=$reqIntegritas?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Kerjasama</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqKerjasama" id="reqKerjasama" value="<?=$reqKerjasama?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Komunikasi</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqKomunikasi" id="reqKomunikasi" value="<?=$reqKomunikasi?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Orientasi Pada Hasil</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqOPH" id="reqOPH" value="<?=$reqOPH?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Pelayanan Publik</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqPelayananPublik" id="reqPelayananPublik" value="<?=$reqPelayananPublik?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Mengembangkan Diri</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqMengembangkanDiri" id="reqMengembangkanDiri" value="<?=$reqMengembangkanDiri?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Mengelolah Perubahan</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqMengelolahPerubahan" id="reqMengelolahPerubahan" value="<?=$reqMengelolahPerubahan?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Pengembilan Keputusan</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqPengambilanKeputusan" id="reqPengambilanKeputusan" value="<?=$reqPengambilanKeputusan?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nilai Perekat Bangsa</label>
                                <div class="col-lg-4 col-sm-12">
                                    <input type="text" class="form-control" name="reqPerekatBangsa" id="reqPerekatBangsa" value="<?=$reqPerekatBangsa?>" required />
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
            window.location.href='app/level_jabatan/index';
        }

        var url = "/level_jabatan/add";

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
                                    document.location.href = "app/level_jabatan/add/"+rowid;
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