<?php
$nama_formula=$formula_eselon_id=$tanggal_tes=$tanggal_tes_akhir=$acara=$tempat=$alamat=$keterangan=$reqLimitDRH=$reqPE='';
// print_r($query);exit;
if(!empty($query)){
    $tanggal_tes=explode(' ', $query->tanggal_tes);
    $tanggal_tes=$tanggal_tes[0];
    $tanggal_tes_akhir=explode(' ', $query->tanggal_tes_akhir);
    $tanggal_tes_akhir=$tanggal_tes_akhir[0];
    $nama_formula=$query->nama_formula;    
    $formula_eselon_id=$query->formula_eselon_id; 
    $acara=$query->acara;
    $tempat=$query->tempat;
    $alamat=$query->alamat;
    $keterangan=$query->keterangan ;
    $reqLimitDRH=$query->limit_drh ;
    $reqPE=$query->link_pe ;
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
                        <h3 class="card-label">Setting Awal</h3>
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
                                            <h3 class="card-label">Identitas Ujian</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <input type="hidden" name="reqId" value="{{$reqId}}">
                                            <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Formula</label>
                                            <div class="col-lg-3 col-sm-12">
                                                <input type="text" class="form-control" name="reqFormula" id="reqFormula" value="<?=$nama_formula?>" required disabled />
                                                <input type="hidden" class="form-control" name="reqFormulaId" id="reqFormulaId" value="<?=$formula_eselon_id?>" required />
                                            </div>
                                            <div class="col-lg-1 col-sm-12">
                                                <a id="btnAdd" onClick="openDirektorat('1')"><i class="fa fa-plus-square fa-lg" aria-hidden="true"  style="margin-top: 10px;"></i> </a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tanggal Tes</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="date" class="form-control" name="reqTanggalMulai" value="<?=$tanggal_tes?>" required />
                                            </div>
                                            <label class="col-form-label text-right col-lg-1 col-sm-12" style="text-align: center !important;">s/d</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="date" class="form-control" name="reqTanggalSelesai" value="<?=$tanggal_tes_akhir?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Acara</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqAcara" value="<?=$acara?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Tempat</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqTempat" value="<?=$tempat?>" required />
                                            </div>
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Alamat</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqAlamat" value="<?=$alamat?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Keterangan</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqKeterangan" value="<?=$keterangan?>" required />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Mulai DRH</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" class="form-control" name="reqLimitDRH" value="<?=$reqLimitDRH?>"/> 
                                                <span style="color:red">* isi jika menggunakan DRH</span>
                                            </div>
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Hari Sebelum Tes</label>
                                        </div>

                                        <div class="form-group row" style="display:none;">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">PE</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="form-control" name="reqPE" value="<?=$reqPE?>"/> 
                                                <span style="color:red">* Upload fIle jika menggunakan PE</span>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <?php
                                                $infolinkfile='uploads/pe/'.$reqId.'/'.$reqPE;
                                                // print_r($reqId.'/'.$reqPegawaiId);
                                                if(file_exists($infolinkfile)){?>
                                                    <a  href="uploads/pe/<?=$reqId?>/<?=$reqPE?>" class="btn btn-success font-weight-bolder" style="margin-right:10px;" target="_blank">
                                                        Lihat Soal PE
                                                    </a>
                                                    <input type="hidden" id="filecek" value="1">
                                                <?php  
                                                }
                                                else{?>
                                                    <input type="hidden" id="filecek" value="">
                                                <?php 
                                                }
                                                ?>
                                            </div>
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
            openAdd('/app/setting_awal/lookup/formula');
        }

        <?php if(!empty($query))
        {?>
         fetch('/app/setting_awal/edit/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));
        <?php }?>

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
    </script>

@endsection