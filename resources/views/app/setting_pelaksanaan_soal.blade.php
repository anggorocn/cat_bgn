<?php
use App\Helper\StringFunc;
$tipeSOal=json_decode(json_encode($query), true);
// print_r($list);exit;

?>
<script>
    let arrSOalTerpilih = [];
</script>
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
                                            <h3 class="card-label" style="color:black;">Simulasi Soal Ujian</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <input type="hidden" name="reqId" value="{{$reqId}}">
                                            <?php if(!empty($data->terpakai)){ ?>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 col-sm-12">
                                                        <span style="color:red; font-size: 12px;">*formula sudah di set di ujian. tipe formula tidak bisa diubah</span>
                                                    </div>
                                                </div>
                                            <?php } 
                                            else{
                                            ?>
                                                <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <table id='customers'>
                                                <tr>                                    
                                                    <th width="50%">
                                                        Tipe Ujian 
                                                        <a id="btnAdd" onClick="openDirektorat(1)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                                    </th>
                                                    <!-- <th>Jumlah Soal</th> -->
                                                    <th>Menit</th>
                                                    <th>Aksi</th>
                                                </tr>
                                                <?php
                                                foreach ($list as $key => $value) {?>
                                                    <tr>
                                                        <td>
                                                            <?php if($value->parent_id!=0){?>
                                                                &nbsp;&nbsp;&nbsp;⦾
                                                            <?php }?>
                                                                <?=$value->nama_ujian?>

                                                        <input type='hidden' value='<?=$value->tipe_ujian_id?>' name='reqTipeUjian[]'>
                                                        <input type='hidden' value='<?=$value->formula_assesment_ujian_tahap_id?>' name='reqFormulaAssesmentUjianTahapid[]'>
                                                        </td>
                                                        <td>
                                                            <?php if($value->anak==0){?>
                                                                <input type='text' class=" form-control" value='<?=$value->menit_soal?>' name='reqMenit[]'>
                                                            <?php } else{?>
                                                                <input type='hidden' class=" form-control" value='<?=$value->menit_soal?>' name='reqMenit[]'>
                                                            <?php }?>
                                                            </td>
                                                        <td>
                                                            <?php if($value->parent_id==0){?>
                                                                <a onclick='deletedata(<?=$value->tipe_ujian_id?>)' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>
                                                                <script>
                                                                    arrSOalTerpilih.push(<?=$value->tipe_ujian_id?>);
                                                                </script>
                                                            <?php }?>
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

        var url = "SettingPelaksanaan/addSoal";

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
                                    document.location.href = "app/setting_pelaksanaan/soal/"+rowid;
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
            openAdd('/app/setting_pelaksanaan/lookup/soal');
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
                    $('#customers tbody').append(`
                        <tr>
                            <td>`+value.nama+`
                            <input type='hidden' value='`+value.id+`' name='reqTipeUjian[]'>
                            <input type='hidden' value='' name='reqFormulaAssesmentUjianTahapid[]'>
                            </td>
                            <td></td>
                            <td style='margin 10px'><button class="removeRow btn btn-danger mr-1 btn-sm detailProduct" ><i class="fa fa-trash"></i></button></td>
                        </tr>`);
                    console.log(value)

                }

            });

        });

        $('#customers').on('click', '.removeRow', function(){
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
                urlAjax= "/SettingPelaksanaan/deleteSoal/<?=$reqId?>/"+id;
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
                                    document.location.href = "app/setting_pelaksanaan/soal/<?=$reqId?>";
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