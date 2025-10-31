@extends('app/index_kosong') 
@section('content')
<form id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-supermarket text-primary"></i>
						</span>
						<h3 class="card-label"> Upload file Pra Assesment</h3>
					</div>
					<div class="card-toolbar" style="color:black;">
						<input type="hidden" name="reqId" value="<?=$reqId?>">
						<a href="{{url('app/')}}" class="btn btn-warning font-weight-bolder mr-2">
							Kembali
						</a>
                        <button type="button" id="ktloginformsubmitbutton"  class="btn btn-success font-weight-bold mr-2">Simpan</button>
					</div>
				</div>
                <div class="card-body">         

                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Upload DRH</label>
                        <div class="col-lg-3 col-sm-12">
                            <input type="file" class="form-control" style="width: 200px;margin: 0px 10px;" name="reqLinkFile" accept=".pdf,application/pdf">
                        </div>
                        <?php
                        $infolinkfile='uploads/drh/'.$reqId.'/'.md5($reqId.'-'.$reqPegawaiId).".docx";
                        if(file_exists($infolinkfile)){?>
                            <a  href="uploads/drh/<?=$reqId?>/<?=md5($reqId.'-'.$reqPegawaiId)?>.docx" class="btn btn-success font-weight-bolder" style="margin-right:10px;" target="_blank">
                                Lihat DRH
                            </a>
                            <input type="hidden" id="filecek" value="1">
                        <?php  
                        }
                        else{?>
                            <input type="hidden" id="filecek" value="">
                        <?php 
                        }
                        ?>

                        <a  href="template/Form DRH.docx" class="btn btn-success font-weight-bolder" style="margin-right:10px;">
                            Download Template DRH
                        </a>
                    </div>           
                    <?php
                    if(!empty($query->link_pe)){?>
                        <div class="form-group row">
                            <label class="col-form-label text-right col-lg-2 col-sm-12">Upload PE</label>
                            <div class="col-lg-3 col-sm-12">
                               <input type="file" class="form-control" style="width: 200px;margin: 0px 10px;" name="reqLinkFilePE" accept=".pdf,application/pdf">
                            </div>
                            <?php
                            $infolinkfile='uploads/pe/'.$reqId.'/'.md5($reqId.'-'.$reqPegawaiId).".docx";
                            // print_r($reqId.'/'.$reqPegawaiId);
                            if(file_exists($infolinkfile)){?>
                                <a  href="uploads/pe/<?=$reqId?>/<?=md5($reqId.'-'.$reqPegawaiId)?>.docx" class="btn btn-success font-weight-bolder" style="margin-right:10px;" target="_blank">
                                    Lihat PE
                                </a>
                                <input type="hidden" id="filecek" value="1">
                            <?php  
                            }
                            else{?>
                                <input type="hidden" id="filecek" value="">
                            <?php 
                            }
                            ?>

                            <a  href="uploads/pe/pe<?=$reqId?>/<?=$query->link_pe?>" class="btn btn-success font-weight-bolder" style="margin-right:10px;">
                                Download Template PE
                            </a>
                        </div>     

                    <?php }?>
                </div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">

    var url = "Pegawai/addDRH/<?=$reqId?>";
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ktloginform');
        const formSubmitButton = document.getElementById('ktloginformsubmitbutton');
        const formSubmitUrl = url; // Ganti dengan URL sebenarnya
        const _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

        if (!form || !formSubmitButton) return;

        // Jika pakai FormValidation.js dari Metronic
        const fv = FormValidation.formValidation(form, {
            fields: {
                nama: {
                    validators: {
                        notEmpty: {
                            message: 'Nama wajib diisi'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap()
            }
        });

        formSubmitButton.addEventListener('click', function (e) {
            e.preventDefault();

            fv.validate().then(function (status) {
                if (status === 'Valid') {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin mengirim data ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, kirim!',
                        cancelButtonText: 'Batal',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-secondary'
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Show loading
                            formSubmitButton.disabled = true;
                            formSubmitButton.innerHTML = '<span class="' + _buttonSpinnerClasses + '"></span> Mohon tunggu...';

                            const formData = new FormData(form);

                            fetch(formSubmitUrl, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]')?.content || ''
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message?.startsWith('xxx')) {
                                    Swal.fire('Error', data.message, 'error');
                                } else {
                                    Swal.fire({
                                        text: data.message || 'Data berhasil disimpan!',
                                        icon: 'success',
                                        confirmButtonText: 'Ok',
                                        customClass: {
                                            confirmButton: 'btn btn-light-primary font-weight-bold'
                                        },
                                        buttonsStyling: false
                                    }).then(() => {
                                        // window.location.href = "app/ujian/pilihujian";
                                        document.location.href = "app/ujian/uploaddrh/<?=$reqId?>";
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire("Error", "Terjadi kesalahan saat mengirim data.", "error");
                                console.error(error);
                            })
                            .finally(() => {
                                formSubmitButton.disabled = false;
                                formSubmitButton.innerHTML = 'Kirim Jawaban';
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Cek kembali isian form kamu.",
                        icon: "error",
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-light-danger font-weight-bold"
                        },
                        buttonsStyling: false
                    });
                }
            });
        });
    });

</script>
@endsection








		
