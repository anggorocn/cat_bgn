<?php
$reqNama=$reqTahun=$reqKeterangan=$reqTipeFormula='';
if (!empty($query))
{
  $reqNama=$query->nama ;
  $reqDetilId=$query->kelompok_id ;
}
$querypeserta=json_decode(json_encode($querypeserta), true);
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
                        <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="container">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="card-icon">
                                                <i class="flaticon2-notepad text-primary"></i>
                                            </span>
                                            <h3 class="card-label">Identitas Kelompok</h3>
                                        </div>
                                        <div class="card-toolbar">                                       
                                            <input type="hidden" name="idHead" value="{{$reqId}}">
                                            <input type="hidden" name="id" value="{{$reqDetilId}}">

                                            <input type="file" name="excelFile" class="form-control" style="width:200px;margin-right: 10px;" accept=".xlsx, .xls, .csv">
                                            <a onclick="upload()" class="btn btn-primary font-weight-bold mr-2">Import Excel</a>
                                            <a class="btn btn-primary font-weight-bold mr-2" href="template/template_undangan_pegawai.xlsx" target="_blank">Template</a>
                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                            <a onclick="simpanSemua(<?=$reqId?>,<?=$reqDetilId?>)" class="btn btn-primary font-weight-bold mr-2">Simpan Semua Pegawai</a>
                                            <a href="app/setting_jadwal/kelompok/<?=$reqId?>" class="btn btn-warning font-weight-bold mr-2">Kembali</a>

                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Nama Kelompok :</label>
                                            <label class="col-form-label col-lg-2 col-sm-12"><?=$reqNama?></label>
                                        </div>
                                        <table id="customers" class="tambahsini">
                                            <tr>
                                                <th style="width: 40%;">
                                                    Nama Pegawai
                                                    <?php
                                                    if($IdentitasUjian->status_valid!=1){?>
                                                        <a id="btnAdd" onClick="openDirektorat(1)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                                    <?php }?>
                                                </th>
                                                <!-- <th>Jam Sehari</th> -->
                                                <th>Nip</th>
                                                <th>Aksi</th>
                                            </tr>
                                            <?php
                                            for($i=0; $i<count($querypeserta);$i++){?>
                                                <tr>
                                                    <td>
                                                        <?=$querypeserta[$i]['nama_pegawai']?>
                                                        <input type='hidden' value='<?=$querypeserta[$i]['pegawai_id']?>' name='reqPegawaiId[]'>
                                                        <input type='hidden' value='<?=$querypeserta[$i]['kelompok_detil_id']?>' name='reqKelompokDetilId[]'>
                                                    </td>
                                                    <td>
                                                        <?=$querypeserta[$i]['nip_pegawai']?>
                                                    </td>
                                                    <td style='margin 10px'>
                                                        <?php
                                                        if($IdentitasUjian->status_valid!=1){?>
                                                            <a class="btn btn-danger mr-1 btn-sm detailProduct" onClick="deletedata('<?=$querypeserta[$i]['kelompok_detil_id']?>')"><i class="fa fa-trash"></i></a>
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        var url = "SettingJadwal/addKelompokAnggota";

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
                                    document.location.href = "app/setting_jadwal/add_kelompok_anggota/<?=$reqId?>/"+rowid;
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

        fetch('/app/setting_jadwal/edit/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));var datanewtable;



        function openDirektorat(id)
        {
            openAdd('/app/setting_jadwal/lookup/pegawai_kelompok/<?=$reqId?>');
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
                    $('.tambahsini tbody').append(`
                        <tr>
                            <td>`+value.nama+`
                            <input type='hidden' value='`+value.id+`' name='reqPegawaiId[]'>
                            <input type='hidden' value='' name='reqKelompokDetilId[]'>
                            </td>
                            <td>`+value.nip+`</td>
                            <td style='margin 10px'><button class="removeRow btn btn-danger mr-1 btn-sm detailProduct" ><i class="fa fa-trash"></i></button></td>
                        </tr>`);
                    console.log(value)

                }

            });

        });



        $('.tambahsini').on('click', '.removeRow', function(){
            $(this).closest('tr').remove();
        });

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
                urlAjax= "/SettingJadwal/deleteKelompokPegawai/"+id;
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
                                    document.location.href = "app/setting_jadwal/add_kelompok_anggota/<?=$reqId?>/<?=$reqDetilId?>";
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

        function simpanSemua(id,detil) {
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
                urlAjax= "/SettingJadwal/addKelompokSemua/"+id+"/"+detil;
                swal.fire({
                    title: 'Apakah anda yakin memasukkan semua peserta undangan?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function(result) { 
                    if (result.value) {
                        $.ajax({
                            url : urlAjax,
                            type : 'POST',
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
                                    document.location.href = "app/setting_jadwal/add_kelompok_anggota/<?=$reqId?>/<?=$reqDetilId?>";
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


        function upload() {
            var urlUpload = "SettingJadwal/ImportExcelKelompok/<?=$reqId?>/<?=$reqDetilId?>"; // URL untuk mengirimkan request

            // Ambil elemen form dan tombol submit
            var form = KTUtil.getById('ktloginform'); 
            var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');

            // Pastikan elemen form ada
            if (!form) {
                console.error("Form tidak ditemukan. Pastikan ID form benar.");
                return;
            }
            // KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
            var formData = new FormData(form);
            $.ajax({
                url: urlUpload,
                data: formData,
                contentType: false,
                processData: false,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') // Tambahkan CSRF token jika diperlukan
                },
                success: function (response) {
                    // Parsing respons JSON
                    var data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.message) {
                        var messageData = data.message.split("-");
                        var rowid = messageData[0];
                        var bermasalah = messageData[1];
                        var infoData = messageData[2];

                        if (rowid === "xxx") {
                            Swal.fire("Error", infoData, "error"); // Tampilkan error jika ada masalah
                        } else {
                            if (bermasalah === "xxx") {
                                Swal.fire({
                                    text: infoData,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    // Arahkan ke halaman baru jika berhasil
                                    document.location.href = "app/setting_jadwal/add_kelompok_anggota/<?=$reqId?>/<?=$reqDetilId?>";
                                });
                            }
                            else{
                                Swal.fire({
                                    text: infoData,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    // Arahkan ke halaman baru jika berhasil
                                    document.location.href = "app/setting_jadwal/add_kelompok_anggota/<?=$reqId?>/<?=$reqDetilId?>";

                                    // window.open('app/setting_awal/log/'+bermasalah, '_blank');
                                });

                            }
                        }
                    }
                },
                error: function (xhr, status, error) {
                    // Tampilkan error dari server
                    try {
                        var err = JSON.parse(xhr.responseText);
                        Swal.fire("Error", err.message, "error");
                    } catch (e) {
                        Swal.fire("Error", "Terjadi kesalahan saat memproses data.", "error");
                    }
                },
                beforeSend: function () {
                    Swal.fire({
                        title: "Sedang memproses...",
                        text: "Mohon tunggu sebentar",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                complete: function () {
                    Swal.close(); // Tutup loading setelah selesai
                    KTUtil.btnRelease(formSubmitButton);
                }
            });
        }
    </script>

@endsection