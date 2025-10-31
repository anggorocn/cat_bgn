<?php
    $reqPertanyaan=$reqKategori=$reqBankSoalId='';
    if(!empty($query)){
        $reqPertanyaan=$query->pertanyaan;    
        $reqKategori=$query->kategori;
        $reqBankSoalId=$query->bank_soal_id;    
    }  
        $queryJawaban=json_decode(json_encode($queryJawaban), true);

?>
@extends('app/index_surat') 
@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <form id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-supermarket text-primary"></i>
                            </span>
                            <h3 class="card-label"> Kelola Soal</h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                            <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button>
                            <input type='hidden' value='<?=$reqBankSoalId?>' name='reqBankSoalId'> 
                            <input type='hidden' value='<?=$reqId?>' name='reqId'> 
                        </div>
                    </div>
                    <div class="card-body">                    
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Pertanyaan</label>
                                <div class="col-lg-10 col-sm-12">
                                    <textarea class="form-control" name="reqPertanyaan" ><?=$reqPertanyaan?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-2 col-sm-12">Kategori</label>
                                <div class="col-lg-10 col-sm-12">
                                    <select name="reqKategori" class="form-control">
                                        <option value="" disabled  {{ $reqKategori == '' ? 'selected' : '' }}>Pilih Kategori</option>
                                        <option value="int" {{ $reqKategori == 'int' ? 'selected' : '' }}>Integritas</option>
                                        <option value="kjsm" {{ $reqKategori == 'kjsm' ? 'selected' : '' }}>Kerja Sama</option>
                                        <option value="kom" {{ $reqKategori == 'kom' ? 'selected' : '' }}>Komunikasi</option>
                                        <option value="oph" {{ $reqKategori == 'oph' ? 'selected' : '' }}>Orientasi pada Hasil</option>
                                        <option value="pp" {{ $reqKategori == 'pp' ? 'selected' : '' }}>Pelayanan Publik</option>
                                        <option value="pdol" {{ $reqKategori == 'pdol' ? 'selected' : '' }}>Pengembangan Diri dan Orang Lain</option>
                                        <option value="mp" {{ $reqKategori == 'mp' ? 'selected' : '' }}>Mengelola Perubahan</option>
                                        <option value="pk" {{ $reqKategori == 'pk' ? 'selected' : '' }}>Pengambilan Keputusan</option>
                                        <option value="pb" {{ $reqKategori == 'pb' ? 'selected' : '' }}>Perekat Bangsa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table id="customers" class="tambahsini">
                            <tr>
                                <th>Jawaban
                                    <a id="btnAdd" onClick="openDirektorat()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                </th>
                                <th>Nilai</th>
                                <th></th>
                            </tr>
                            <?php
                            if(!empty($queryJawaban)){
                                for($i=0; $i<count($queryJawaban);$i++){?>                                
                                    <tr>
                                        <td>
                                            <input type="hidden" name="reqJawabanId[]" value="<?=$queryJawaban[$i]['bank_soal_pilihan_id']?>">
                                            <textarea class="form-control" name="reqJawaban[]" ><?=$queryJawaban[$i]['jawaban']?></textarea>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="reqNilai[]" value="<?=$queryJawaban[$i]['grade_prosentase']?>">
                                        </td>
                                        <td style='margin 10px'> 
                                            <a class="btn btn-danger mr-1 btn-sm detailProduct" onClick="deletedata('<?=$queryJawaban[$i]['bank_soal_pilihan_id']?>')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                            }?>    
                        </table>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function kembali() {
            window.location.href='app/soal/detilsjt/<?=$reqId?>';
        }

        var url = "/Soal/addsjt";

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
                        reqNip: {
                            validators: {
                                notEmpty: {
                                    message: 'Nip harus diisi'
                                }
                            }
                        },
                        reqNama: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama harus diisi'
                                }
                            }
                        },
                        reqJabatan: {
                            validators: {
                                notEmpty: {
                                    message: 'Jabatan harus diisi'
                                }
                            }
                        },
                         reqEselon: {
                            validators: {
                                notEmpty: {
                                    message: 'Eselon harus diisi'
                                }
                            }
                        },
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
                                    document.location.href = "app/soal/addsjt/<?=$reqId?>/"+rowid;
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
        function openDirektorat(argument) {
            $('.tambahsini tbody').append(`
            <tr>
                <td>
                    <input type="hidden" name="reqJawabanId[]">
                    <textarea class="form-control" name="reqJawaban[]"></textarea>
                </td>
                <td>
                    <input type="text" class="form-control" name="reqNilai[]">
                </td>
                <td style='margin 10px'><button class="removeRow btn btn-danger mr-1 btn-sm detailProduct" ><i class="fa fa-trash"></i></button></td>
            </tr>`);
        }


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
                urlAjax= "/Soal/deletejawaban/"+id;
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
                                    document.location.href = "app/soal/addsjt/<?=$reqId?>/<?=$reqSoalId?>";
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