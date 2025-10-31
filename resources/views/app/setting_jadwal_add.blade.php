<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php
$asesor=json_decode(json_encode($asesor), true);

if(empty($query->waktu_mulai)){
    $reqWaktuMulai='08:45';
}
else{
    $reqWaktuMulai=$query->waktu_mulai;
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
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="containerNew">
                        <?php
                        if(!empty($asesor)){?>
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
                                            <h3 class="card-label">Identitas Jadwal</h3>
                                        </div>


                                        <div class="card-toolbar">
                                            <input type="hidden" name="reqId" value="{{$reqId}}">
                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="height:54vh;overflow:scroll;">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Formula :</label>
                                            <label class="col-form-label col-lg-10 col-sm-12"><?=$query->nama_formula?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tanggal Tes :</label>
                                            <label class="col-form-label col-lg-2 col-sm-12"><?=$query->tanggal_tes?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Acara :</label>
                                            <label class="col-form-label col-lg-10 col-sm-12"><?=$query->acara?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tempat :</label>
                                            <label class="col-form-label col-lg-10 col-sm-12"><?=$query->tempat?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Alamat :</label>
                                            <label class="col-form-label col-lg-10 col-sm-12"><?=$query->alamat?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Keterangan :</label>
                                            <label class="col-form-label col-lg-10 col-sm-12"><?=$query->keterangan?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tipe Ujian :</label>
                                            <label class="col-form-label col-lg-4 col-sm-12">
                                                <select class="form-control" name="reqStatusJenis">
                                                    <option value="" <?php if($query->status_jenis==''){ echo "selected"; }?>>Seleksi</option>
                                                    <option value="1" <?php if($query->status_jenis=='1'){ echo "selected"; }?>>Pemetaan</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">TTD Asesor :</label>
                                            <label class="col-form-label col-lg-4 col-sm-12">
                                                <select class="form-control" name="reqTtdAsesor">
                                                    <option value="" disabled <?php if($query->ttd_asesor==''){ echo "selected"; }?>>Pilih Pegawai</option>
                                                    <?php
                                                    for($i=0; $i<count($asesor);$i++){
                                                    ?>
                                                        <option value="<?=$asesor[$i]['asesor_id']?>" <?php if($query->ttd_asesor==$asesor[$i]['asesor_id']){ echo "selected"; }?>><?=$asesor[$i]['nama']?></option>
                                                    <?php }?>
                                                </select>
                                            </label>
                                            <label class="col-form-label col-lg-4 col-sm-12">
                                                <input type="file" class="form-control" name="reqLinkFileAsesor" accept="image/png">
                                                <span style="color:red; font-size:10px">*upload gambar tanpa background dengan format png</span>
                                            </label>
                                            <label class="col-form-label col-lg-2 col-sm-12">
                                                <?php
                                                    $infolinkfile='uploads/tes/'.$reqId.'/asesor_ttd.png';
                                                    if(file_exists($infolinkfile))
                                                    {
                                                    ?>
                                                    <a href="<?=$infolinkfile?>" target="_blank">
                                                        <i class="fas fa-eye" style="font-size: 30px;color: blue;"></i>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">TTD Pemimpin :</label>
                                            <label class="col-form-label col-lg-4 col-sm-12" >
                                                <input type="text" class="form-control" name='reqTtdPimpinan' value="<?=$query->ttd_pimpinan?>">
                                            </label>
                                            <label class="col-form-label col-lg-4 col-sm-12">
                                                <input type="file" class="form-control" name="reqLinkFilePimpinan" accept="image/png">
                                                <span style="color:red; font-size:10px">*upload gambar tanpa background dengan format png</span>
                                            </label>
                                            <label class="col-form-label col-lg-2 col-sm-12">
                                                <?php
                                                    $infolinkfile='uploads/tes/'.$reqId.'/pimpinan_ttd.png';
                                                    if(file_exists($infolinkfile))
                                                    {
                                                    ?>
                                                    <a href="<?=$infolinkfile?>" target="_blank">
                                                        <i class="fas fa-eye" style="font-size: 30px;color: blue;"></i>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </label>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Link Zoom</label>
                                            <label class="col-form-label col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqZoom" value="<?=$query->link_soal?>">
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Status :</label>
                                            <label class="col-form-label col-lg-2 col-sm-12">
                                                <?php if($query->status_valid==1){?>
                                                    Tutup
                                                    <input type="hidden" name="reqStatus" value="1">
                                                <?php
                                                }
                                                else{?>
                                                    <select name="reqStatus" class="form-control">
                                                        <option value="">Buka</option>
                                                        <option value="1">Tutup</option>
                                                    </select>
                                                <?php }?>
                                            </label>

                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Waktu Mulai</label>
                                            <label class="col-form-label col-lg-4 col-sm-12">
                                                <input type="time" class="form-control" name="reqWaktuMulai" id="reqWaktuMulai" value="<?=$reqWaktuMulai?>">
                                            </label>
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

        var url = "SettingJadwal/EditStatus";

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
                                    document.location.href = "app/setting_jadwal/add/"+rowid;
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
                    $('#reqFormula').val(value.nama)
                    $('#reqFormulaId').val(value.id)

                }

            });

        });
        flatpickr("#reqWaktuMulai", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i", // Format 24 jam
                        time_24hr: true
                    });
    </script>

@endsection