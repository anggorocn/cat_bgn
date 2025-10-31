<?php
$query=json_decode(json_encode($query), true);
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
                        <h3 class="card-label">Setting Jadwal</h3>
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
                                            <h3 class="card-label">Ujian Essay</h3>
                                        </div>

                                        <div class="card-toolbar">
                                            <input type="hidden" name="reqId" value="{{$reqId}}">
                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row" style="display:none;">
                                            <label class="col-form-label text-right col-lg-3 col-sm-12">Batas Pengisian</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="date" class="form-control" name='reqBatas' value="<?=$batas->kompetensi_tanggal_selesai?>" />
                                            </div>
                                        </div>
                                        <?php
                                        for($j=0; $j<count($query);$j++)
                                        {
                                            $reqFileJenisId=$query[$j]['penggalian_id'];
                                            $nama=$query[$j]['nama'];
                                            $reqFileJenisKode=$query[$j]['kode'];
                                            $reqEssaySoal=$query[$j]['essay_soal_id'];
                                            $reqKegiatanFileId=$query[$j]['kegiatan_file_id'];
                                            $reqKegiatanFile=$query[$j]['kegiatan_file_nama'];
                                            ?>
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-lg-3 col-sm-12"><?=$nama?></label>
                                                <div class="col-lg-6 col-sm-12">
                                                    <input type="text" class="form-control" name="reqKegiatanFile[]" id="reqFormula<?=$reqFileJenisKode?>" value="<?=$reqKegiatanFile?>" disabled/>
                                                    <input type="hidden" class="form-control" name="reqFileJenisId[]" value="<?=$reqFileJenisId?>" />
                                                    <input type="hidden" class="form-control" name="reqEssaySoal[]" value="<?=$reqEssaySoal?>" />
                                                    <input type="hidden" class="form-control" name="reqKegiatanFileId[]" id="reqFormulaId<?=$reqFileJenisKode?>" value="<?=$reqKegiatanFileId?>" />
                                                </div>
                                                <div class="col-lg-1 col-sm-12">
                                                    <a id="btnAdd" onClick="openDirektorat('<?=$reqFileJenisKode?>')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"  style="margin-top: 10px;"></i> </a>
                                                </div>
                                            </div>
                                        <?php }?>        
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

        var url = "SettingJadwal/addEssay";

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
                                    document.location.href = "app/setting_jadwal/upload/"+rowid;
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
            openAdd('/app/setting_jadwal/lookup/kegiatan_file/'+id);
        }

         fetch('/app/setting_jadwal/edit/<?=$pg?>/<?=$reqId?>')
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
                    $('#reqFormula'+value.kode).val(value.nama)
                    $('#reqFormulaId'+value.kode).val(value.id)

                }

            });

        });

        function deletedata(id) {
            urlAjax= "/SettingJadwal/deleteUpload/"+id;
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
                                document.location.href = "app/setting_jadwal/upload/<?=$reqId?>";
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
    </script>

@endsection