<?php
    $reqPertanyaan='';
    if(!empty($query)){
        // $reqPertanyaan=$query->pertanyaan;  
        $path_gambar=str_replace('main/uploads/', 'images/soal/', $query->path_gambar);
        $reqPertanyaan = $path_gambar.'/'.$query->path_soal;  
        $reqBankSoalId=$query->bank_soal_id;    
    }
    
    $queryJawaban=json_decode(json_encode($queryJawaban), true);
    // print_r($queryJawaban);exit;
?>
@extends('app/index_surat') 
@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <form id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-supermarket text-primary"></i>
                            </span>
                            <h3 class="card-label"> Kelola Soal</h3>
                        </div>
                        <div class="card-toolbar">
                            <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button>
                            <!-- <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button> -->
                            <input type='hidden' value='<?=$reqBankSoalId?>' name='reqBankSoalId'> 
                        </div>
                    </div>
                    <div class="card-body">                    
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Pertanyaan</label>
                                <div class="col-lg-10 col-sm-12">
                                    <img src="<?=$reqPertanyaan?>" style="height: 100px;" >
                                </div>
                            </div>
                        </div>
                        <table id="customers">
                            <tr>
                                <th>Jawaban</th>
                                <th>Grade Penilaian</th>
                            </tr>
                            <?php
                            for($i=0; $i<count($queryJawaban);$i++){
                                $reqJawaban = $path_gambar.'/'.$queryJawaban[$i]['jawaban'];  
                                ?>                                
                                <tr>
                                    <td>
                                        <input type="hidden" name="reqJawabanId[]" value="<?=$queryJawaban[$i]['bank_soal_pilihan_id']?>">
                                        <img src="<?=$reqJawaban?>" style="height: 100px;" >
                                    </td>
                                    <td>
                                        <input class="form-control" name="reqJawaban[]" type="text" value="<?=$queryJawaban[$i]['grade_prosentase']?>">
                                    </td>
                                </tr>
                            <?php }?>    
                        </table>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function kembali() {
            window.location.href='app/soal/detil/<?=$reqId?>';
        }

        var url = "/Soal/Update";

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
                                    document.location.href = "app/soal/add/<?=$reqId?>/"+rowid;
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