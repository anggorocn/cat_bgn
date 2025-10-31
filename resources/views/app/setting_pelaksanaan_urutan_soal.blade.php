<?php
// print_r($query);exit;
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
                <form id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off" >
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
                                            <h3 class="card-label">Urutan Soal Ujian</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <input type="hidden" name="reqId" value="{{$reqId}}">
                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <table id='customers'>
                                                <tr>                                    
                                                    <th width="50%">
                                                        Tipe Ujian 
                                                    </th>
                                                    <th>Urutan</th>
                                                </tr>              
                                                <?php
                                                    foreach ($query as $key => $value) {?>
                                                    <tr>                                    
                                                        <td width="50%"><?=$value->nama_ujian?></td>
                                                        <td><input type='text' class=" form-control" value='<?=$value->urutan_tes?>' name='reqUrutan[]'>
                                                            <input type='hidden' class=" form-control" value='<?=$value->formula_assesment_ujian_tahap_id?>' name='reqFormulaAssesmentUjianTahapid[]'>
                                                        </td>
                                                    </tr>              
                                                <?php }?>
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

        var url = "SettingPelaksanaan/addUrutan";

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
                                    document.location.href = "app/setting_pelaksanaan/urutansoal/"+rowid;
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

        function openDirektorat(id)
        {

            reqUnitKerjaId= $("#reqUnitKerjaId").val();
            // console.log(reqUnitKerjaId);
            openAdd('app/pegawai/lookup/pegawai_satuan_kerja/'+reqUnitKerjaId);
        }

        function adddetil(param)
        {
            // console.log(param);

            $("#reqUnitKerjaId").val(param.SATUAN_KERJA_ID_PARENT);
            $("#reqIdDirektorat").val(param.id);
            $("#reqNamaDirektorat").val(param.NAMA);
            $("#reqJabatan").val(param.JABATAN);
        }

        function closePopup()
        {
            eModal.close();
        }


    </script>

@endsection