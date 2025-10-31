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
                        <h3 class="card-label">Setting Awal</h3>
                    </div>
                </div>
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
                                        <h3 class="card-label">Hapus Tanggal Ujian</h3>
                                    </div>
                                </div>
                                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <table id='customers'>
                                                <tr>                                    
                                                    <th width="50%">Tanggal</th>
                                                    <th >Aksi</th>
                                                </tr>
                                                <?php 
                                                foreach ($query as $key => $value) 
                                                {
                                                    $tanggal_tes=explode(' ', $value->tanggal_tes);
                                                    ?>
                                                    <tr>
                                                        <td><?=DateFunc::getDayMonthYear($tanggal_tes[0])?></td>
                                                        <td><a onclick="hapus(<?=$value->jadwal_tes_id?>)" class="btn btn-danger font-weight-bold mr-2"><i class="fa fa-trash "></i>  </td>
                                                    </tr>
                                                <?php }?>
                                            </table>
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

        var url = "SettingAwal/addJadwal";

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
                                    document.location.href = "app/setting_awal/add/"+rowid;
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

        function openDirektorat(id)
        {
            openAdd('/app/setting_awal/lookup/formula/');
        }

         fetch('/app/setting_awal/edit/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));

        window.addEventListener('message', function(event) {
            // Pastikan pesan berasal dari iframe yang tepat (jika diperlukan)
            if (event.origin !== window.location.origin) {
                // Validasi asal pesan jika perlu
                return;
            }

            // Akses data yang dikirimkan dari iframe
            const data = event.data;

            // Proses data tersebut (misalnya untuk memperbarui halaman induk)

            $.each(data, function(index, value) {
                if (value === undefined) {
                    // $('#customers tbody').append('<tr><td>'+value+'</td></tr>');
                }
                else{
                    $('#reqFormula').val(value.nama)
                    $('#reqFormulaId').val(value.id)

                }

            });

        });

        function hapus(id) {
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
                urlAjax= "/SettingAwal/deleteJadwal/"+id;
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
                                    document.location.href = "app/setting_awal/hapustanggal/<?=$reqId?>";
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
    </script>

@endsection