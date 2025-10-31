<?php
    $reqNama='';
    if(!empty($query)){
        $reqNama=$query->nama;    
        $reqFile=$query->file;    
    }
    $queryDetil=json_decode(json_encode($queryDetil), true);

    // print_r(count($queryDetil));exit;
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
                        <h3 class="card-label"> Kelola Soal</h3>
                    </div>
                </div>
                <div class="card-body">                    
                    <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Nama</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="text" class="form-control" name="reqNama" value="<?=$reqNama?>"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Upload Kondisi</label>
                                <div class="col-lg-3 col-sm-12">
                                    <input type="file" class="form-control" name="reqLinkFile" accept="application/pdf"/>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <?php
                                    if(!empty($reqFile)){
                                        $infolinkfile='template_soal/'.$reqFile;
                                        ?>                                
                                        <a href="<?=$infolinkfile?>" target="_blank">
                                            <i class="fas fa-eye" style="font-size: 30px;color: blue;"></i>
                                        </a>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Surat</label>
                                <div class="col-lg-9 col-sm-12">
                                    <table id="customers" class="tambahsini">
                                        <thead>
                                            <tr>
                                                <th>Keterangan
                                                    <a id="btnAdd" onClick="openDirektorat(1)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                                </th>
                                                <th>Upload File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($queryDetil)){
                                                    for($i=0; $i<count($queryDetil);$i++){?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="reqNamaItr[]" value="<?=$queryDetil[$i]['keterangan']?>"/>
                                                            <input type="hidden" class="form-control" name="reqIdItr[]" value="<?=$queryDetil[$i]['kegiatan_file_itr_id']?>" />
                                                        </td>
                                                        <td><input type="file" class="form-control" name="reqFileItr[]" /></td>
                                                        <td style='margin 10px'>
                                                            <?php
                                                            if(!empty($queryDetil[$i]['file'])){
                                                                $infolinkfile='template_soal/itr/'.$queryDetil[$i]['file'];
                                                                ?>                                
                                                                <a class=" btn btn-success mr-1 btn-sm detailProduct" href="<?=$infolinkfile?>" target="_blank">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            <?php }?>
                                                            <a class="removeRow btn btn-danger mr-1 btn-sm detailProduct" onClick="deletedata('<?=$queryDetil[$i]['kegiatan_file_itr_id']?>')"><i class="fa fa-trash"></i></a>
                                                        </td>

                                                    </tr>
                                                <?php
                                                } 
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9">
                                    <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button>
                                    <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                    <input type='hidden' value='<?=$reqId?>' name='reqId'> 
                                    <input type='hidden' value='ITR' name='reqKode'> 
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
            window.location.href='app/soal/index_intray';
        }




        function deletedata(id) {
            if(id == "")
            {
                Swal.fire({
                    text: "Pilih salah satu data terlebih dahulu.",
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
                urlAjax= "Soal/deleteItr/"+id;
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
                                    document.location.href = "app/soal/soal_detil_intray/<?=$reqId?>";
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


        function openDirektorat(id)
        {    
            $('.tambahsini tbody').append(`
            <tr>
                <td>
                    <input type="text" class="form-control" name="reqNamaItr[]"/>
                    <input type="hidden" class="form-control" name="reqIdItr[]"/>
                </td>
                <td><input type="file" class="form-control" name="reqFileItr[]" /></td>
                <td style='margin 10px'>
                    <a class="removeRow btn btn-danger mr-1 btn-sm detailProduct" ><i class="fa fa-trash"></i></a></td>
            </tr>`);
        }


        $('.tambahsini').on('click', '.removeRow', function(){
            $(this).closest('tr').remove();
        });

        var url = "/Soal/addessay";

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
                                    document.location.href = "app/soal/soal_detil_intray/"+rowid;
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