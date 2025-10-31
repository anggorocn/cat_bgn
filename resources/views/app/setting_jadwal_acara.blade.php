<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php
// print_r($IdentitasUjian->status_valid) ;exit;
$penggalian_id=$pukul1=$pukul2=$keterangan_acara=$tanggal='';

if (!empty($query)){
    $penggalian_id=$query->penggalian_id;
    $pukul1=$query->pukul1;
    $pukul2=$query->pukul2;
    $keterangan_acara=$query->keterangan_acara;
    $tanggal=explode(' ',$query->tanggal) ;
    $tanggal=$tanggal[0];
}
$disabled='';
if($IdentitasUjian->status_valid==1){
    $disabled='disabled';
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
                        <h3 class="card-label">Setting Jadwal</h3>
                    </div>
                </div>
                <div class="containerNew">
                    <div class="left" id="left-content"></div>
                    <div class="contentNew" id="contentNew">
                        <div class="container">
                            <div class="card card-custom">
                                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-lg-6" >
                                             <div class="left" id="content-head"></div>
                                        </div>
                                        <div class="col-lg-6" style="border: blue 0.5px solid;border-radius: 10px;height: 65vh;overflow: scroll;">
                                            <div class="card-header row">
                                                <div class="card-title" style="margin-bottom: 0rem;width: 75%;">
                                                    <div class="row">
                                                        <span class="card-icon">
                                                            <i class="flaticon2-notepad text-primary"></i>
                                                        </span>
                                                        <h3 class="card-label" style="color:black;width: 50%;margin-left: 25px;">Edit Acara</h3>
                                                    </div>
                                                </div>  
                                                <div class="card-toolbar" style="width: 25%;text-align: right;">
                                                    <?php 
                                                    if($IdentitasUjian->status_valid!=1){?>
                                                        <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                                    <?php }?>
                                                    <input type="hidden" name="reqId" value="{{$reqId}}">
                                                    <input type="hidden" name="reqDetilId" value="{{$reqDetilId}}">
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-3 col-sm-12">Penggalian</label>
                                                    <select class="form-control" style="width:70%" <?=$disabled?> required name="reqPenggalian">
                                                        <?php 
                                                        foreach ($comboPenggalian as $key => $value) {?>
                                                            <option value="<?=$value->penggalian_id?>" <?php if($penggalian_id == $value->penggalian_id){echo 'selected';}?>><?=$value->nama?> ( <?=$value->kode?> )</option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <!--<div class="form-group row">-->
                                                <!--    <label class="col-form-label text-right col-lg-3 col-sm-12">Tanggal</label>-->
                                                <!--    <input type="date" <?=$disabled?> class="form-control" name="reqTanggal" style="width:70%" value="<?=$tanggal?>"required>-->
                                                <!--</div>-->
                                                <!--<div class="form-group row">-->
                                                <!--    <label class="col-form-label text-right col-lg-3 col-sm-12">Pukul</label>-->
                                                <!--    <input type="time" <?=$disabled?> class="form-control" name="reqPukulAwal" id="reqPukulAwal" style="width:30%" required value="<?=$pukul1?>">-->
                                                <!--    <label class="col-form-label" style="width:50px;text-align: center;">s/d</label>-->
                                                <!--    <input type="time" <?=$disabled?> class="form-control" name="reqPukulAkhir" id="reqPukulAkhir" style="width:30%" value="<?=$pukul2?>"required>-->
                                                <!--</div>-->
                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-3 col-sm-12">Keterangan</label>
                                                    <input type="text" <?=$disabled?> class="form-control" name="reqKeterangan" id="reqKeterangan" style="width:70%" value="<?=$keterangan_acara?>" required>
                                                </div>
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

// menu samping
        fetch('/app/setting_jadwal/edit/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));

// monitoring kiri
        <?php if(empty($reqDetilId)){?>
        fetch('/app/setting_jadwal/acarahead/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('content-head').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));
        <?php }
        else{?>
                fetch('/app/setting_jadwal/acarahead/<?=$pg?>/<?=$reqId?>/<?=$reqDetilId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('content-head').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));

        <?php }?>


        var url = "SettingJadwal/addAcara";

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
                            rowDetil= data[1];
                            infodata= data[2];

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
                                    document.location.href = "app/setting_jadwal/acara/"+rowid;
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
        flatpickr("#reqPukulAwal,#reqPukulAkhir", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // Format 24 jam
            time_24hr: true
        });



        function deletedata(id) {
            urlAjax= "/SettingJadwal/deleteAcara/"+id;
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
                                document.location.href = "app/setting_jadwal/acara/<?=$reqId?>";
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