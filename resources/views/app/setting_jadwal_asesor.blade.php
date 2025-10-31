<?php
    $queryhead=json_decode(json_encode($queryhead), true);
    $query=json_decode(json_encode($query), true);
    // echo $reqDetilId;exit;
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
                                        <div class="col-lg-12" >
                                            <div style="margin: 0px 20px; border: blue 0.5px solid;border-radius: 10px;height: 65vh;">
                                                <div class="card-header row" style="margin: 10px;">
                                                    <div class="card-title" style="margin-bottom: 0rem;width: 75%;">
                                                        <div class="row">
                                                            <span class="card-icon">
                                                                <i class="flaticon2-notepad text-primary"></i>
                                                            </span>
                                                            <h3 class="card-label" style="color:black;width: 50%;margin-left: 25px;">List Acara</h3>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="card-body" style="height:45vh;overflow: scroll;">
                                                    <div class="form-group row">
                                                        <table id="customers">
                                                            <tr>
                                                                <th>Penggalian</th>
                                                                <th>Jam</th>
                                                                <th>Keterangan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                            <?php 
                                                            for($i=0; $i<count($queryhead);$i++){?>
                                                                <tr 
                                                                <?php 
                                                                    if($reqDetilId==$queryhead[$i]['jadwal_acara_id'])
                                                                        { echo 'style="background-color: yellow;"';} ?> >
                                                                    <td><?=$queryhead[$i]['nama']?> (<?=$queryhead[$i]['kode']?>)</td>
                                                                    <td><?=$queryhead[$i]['pukul1']?> s/d <?=$queryhead[$i]['pukul2']?></td>
                                                                    <td><?=$queryhead[$i]['keterangan_acara']?></td>
                                                                    <td>
                                                                        <?php if($reqDetilId!=$queryhead[$i]['jadwal_acara_id']){?> 
                                                                            <a href='app/setting_jadwal/asesordetil/<?=$reqId?>/<?=$queryhead[$i]["jadwal_acara_id"]?>' class="btn btn-warning font-weight-bold mr-2"><i class="fa fa-edit"></i></a>
                                                                        <?php }?>
                                                                        <!-- <a type="submit"  class="btn btn-danger font-weight-bold mr-2"><i class="fa fa-trash"></i></a> -->
                                                                    </td>
                                                                </tr>
                                                            <?php }?>
                                                        </table>
                                                    </div>
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

        var url = "SettingJadwal/addAsesor";
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
                            rowDetilid= data[1];
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
                                    document.location.href = "app/setting_jadwal/asesor/"+rowid+"/"+rowDetilid;
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
            openAdd('/app/setting_jadwal/lookup/asesor/<?=$reqDetilId?>/'+arrTerpilih);
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
                            <input type='hidden' value='`+value.id+`' name='reqAsesorId[]'>
                            <input type='hidden' value='' name='reqAsesorUjianId[]'>
                            </td>
                            <td><input type="text" class="form-control" name="reqBatas[]"/></td>
                            <td><input type="text" class="form-control" name="reqKeterangan"/></td>
                            <td style='margin 10px'><button class="removeRow btn btn-danger mr-1 btn-sm detailProduct" ><i class="fa fa-trash"></i></button></td>
                        </tr>`);
                    arrTerpilih.push(value.id);


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
                urlAjax= "/SettingJadwal/deleteAsesor/"+id;
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
                                    document.location.href = "app/setting_jadwal/asesor/<?=$reqId?>/<?=$reqDetilId?>";
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