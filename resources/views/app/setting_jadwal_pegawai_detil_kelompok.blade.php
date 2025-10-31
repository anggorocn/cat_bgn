<?php
    $queryhead=json_decode(json_encode($queryhead), true);
    $query=json_decode(json_encode($query), true);
    // print_r($queryhead);exit;
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
                                        <div class="col-lg-12" style="border: blue 0.5px solid;border-radius: 10px;height: 65vh;overflow: scroll;">
                                            <?php
                                            if(empty($reqDetilId)){?>
                                                <h1 style="color: black;text-align: center;">Pilih Asesor</h1>
                                            <?php 
                                            }else{?>    
                                                <div class="card-header row">
                                                    <div class="card-title" style="margin-bottom: 0rem;width: 75%;">
                                                        <div class="row">
                                                            <span class="card-icon">
                                                                <i class="flaticon2-notepad text-primary"></i>
                                                            </span>
                                                            <h3 class="card-label" style="color:black;width: 50%;margin-left: 25px;">Pilih Kelompok</h3>
                                                        </div>
                                                    </div>  
                                                    <div class="card-toolbar" style="width: 25%;text-align: right;">
                                                        <?php
                                                        if($IdentitasUjian->status_valid!=1){?>
                                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                                        <?php }?>
                                                        <a href="app/setting_jadwal/pegawai/<?=$reqId?>" class="btn btn-warning font-weight-bold mr-2">Kembali</a>
                                                        
                                                        <input type="hidden" name="reqId" id="reqId" value="{{$reqId}}">
                                                        <input type="hidden" name="reqDetilId" id="reqDetilId" value="{{$reqDetilId}}">
                                                        <input type="hidden" name="reqPenggalianId" id="reqPenggalianId" value="{{$reqPenggalianId}}">
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <table id="customers" class="tambahsini">
                                                            <tr>
                                                                <th style="width: 40%;">
                                                                    Nama Kelompok
                                                                    <?php
                                                                    if($IdentitasUjian->status_valid!=1){?>
                                                                        <a id="btnAdd" onClick="openDirektorat(1)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                                                    <?php }?>
                                                                </th>
                                                                <!-- <th>Jam Sehari</th> -->
                                                                <th>Aksi</th>
                                                            </tr>
                                                            <?php
                                                            for($i=0; $i<count($query);$i++){?>
                                                                <tr>
                                                                    <td>
                                                                        <?=$query[$i]['nama']?>
                                                                        <input type='hidden' value='<?=$query[$i]['kelompok_id']?>' name='reqKelompokId[]'>
                                                                    </td>
                                                                    <td style='margin 10px'>
                                                                        <?php
                                                                        if($IdentitasUjian->status_valid!=1){?>
                                                                            <a class="btn btn-danger mr-1 btn-sm detailProduct" onClick="deletedata('<?=$query[$i]['kelompok_id']?>')"><i class="fa fa-trash"></i></a>
                                                                        <?php }?>
                                                                    </td>
                                                                </tr>
                                                            <?php }?>
                                                            
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php }?>
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

        var url = "SettingJadwal/AddPegawaiKelompok";

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
                            rowDetilid= data[1];
                            reqPenggalianId= data[2];
                            infodata= data[3];

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
                                    document.location.href = "app/setting_jadwal/pegawai/"+rowid+"/"+rowDetilid+"/"+reqPenggalianId;
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
            openAdd('/app/setting_jadwal/lookup/pegawai_kelompok_pilih/<?=$reqId?>/<?=$reqPenggalianId?>');
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
                            <input type='hidden' value='`+value.id+`' name='reqKelompokId[]'>
                            </td>
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
            reqId=$('#reqId').val();
            reqDetilId=$('#reqDetilId').val();
            reqPenggalianId=$('#reqPenggalianId').val();
        
            urlAjax= "/SettingJadwal/deletePegawaiKelompok/"+id+"/"+reqId+"/"+reqDetilId+"/"+reqPenggalianId;
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
                                document.location.href = "app/setting_jadwal/pegawaidetilkelompok/<?=$reqId?>/<?=$reqDetilId?>/<?=$reqPenggalianId?>";
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