<?php
$reqBatas='';
if(!empty($queryInfo)){
    $reqBatas=$queryInfo->batas_pegawai;
}
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
                                            <h3 class="card-label">Undangan Pegawai</h3>
                                        </div>
                                        <div class="card-toolbar">                                            
                                            <input type="hidden" name="reqId" value="{{$reqId}}">
                                            <input type="hidden" name="reqDetil" value="{{$reqDetil}}">
                                            <span style="color: black;margin-right: 20px;">Batas Pegawai :</span>
                                            <input type="text" name="reqBatas" value="<?=$reqBatas?>" class="form-control" style="width:30%; margin-right: 20px;">
                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                            <a onclick="simpanSemua(<?=$reqId?>,<?=$reqDetil?>)" class="btn btn-primary font-weight-bold mr-2">Simpan Semua Pegawai</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <table id='customers'>
                                                <tr>                
                                                    <th>No</th>
                                                    <th width="50%">
                                                        Nama Pegawai 
                                                        <a id="btnAdd" onClick="openDirektorat('{{1}}')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                                    </th>
                                                    <th>Nip</th>
                                                    <th>Aksi</th>
                                                    <?php
                                                    $i=1;
                                                    foreach ($query as $key => $value) {?>
                                                        <tr>
                                                            <td><?=$i?></td>
                                                            <td><?=$value->pegawai_nama?>
                                                            <!--<input type='hidden' value='<?=$value->pegawai_id?>' name='reqPegawaiId[]'>-->
                                                            <!--<input type='hidden' value='<?=$value->jadwal_awal_tes_simulasi_pegawai_id?>' name='reqPegawaiTesId[]'>-->
                                                            </td>
                                                            <td><?=$value->pegawai_nip?></td>
                                                            <td style='margin:10px'><a class="btn btn-danger mr-1 btn-sm detailProduct" onClick="deletedata('<?=$value->jadwal_awal_tes_simulasi_pegawai_id?>')"><i class="fa fa-trash"></i></button></td>
                                                        </tr>
                                                    <?php 
                                                    $i++;
                                                    }?>  
                                                </tr>                            
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

        var url = "SettingAwal/addSimulasi";
        let arrTerpilih = [];

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
                            rowidDetil= data[1];
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
                                    document.location.href = "app/setting_awal/simulasi/"+rowid+"/"+rowidDetil;
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
            openAdd('/app/setting_awal/lookup/pegawaisimulasi/<?=$reqId?>');
        }

        fetch('/app/setting_awal/edit/<?=$pg?>/<?=$reqId?>/<?=$reqDetil?>')
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
                    tampil=`
                        <tr>
                            <td>`+value.nama+`
                            <input type='hidden' value='`+value.id+`' name='reqPegawaiId[]'>
                            <input type='hidden' value='' name='reqPegawaiTesId[]'>
                            </td>
                            <td>`+value.nip+`</td>
                            <td style='margin 10px'><button class="removeRow btn btn-danger mr-1 btn-sm detailProduct" ><i class="fa fa-trash"></i></button></td>
                        </tr>`;
                    $('#customers tbody').append(tampil);
                    arrTerpilih.push(value.id);
                    console.log(arrTerpilih)

                }

            });

        });

        $('#customers').on('click', '.removeRow', function(){
            $(this).closest('tr').remove();
        });


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
                urlAjax= "/SettingAwal/addSimulasiSemua/"+id+"/"+detil;
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
                                    document.location.href = "app/setting_awal/simulasi/<?=$reqId?>/<?=$reqDetil?>";
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
                urlAjax= "/SettingAwal/deleteSimulasi/"+id;
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
                                    document.location.href = "app/setting_awal/simulasi/<?=$reqId?>/<?=$reqDetil?>";
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