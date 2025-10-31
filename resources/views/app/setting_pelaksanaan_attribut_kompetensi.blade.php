<?php
use App\Helper\StringFunc;

$dropdown=json_decode(json_encode($dropdown), true);
$penggalian=json_decode(json_encode($penggalian), true);
// print_r($query);exit;
?>
<style type="text/css">
    

.tabs {
    position: relative;
    color:black;
/*    margin: 3rem auto;
    width: 80%;*/
}

.tab-labels {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: space-between;
}

.tab-label {
    flex-grow: 1;
    width: 300px;
}

.tab-label label {
    display: block;
    padding: 1rem;
    background: #eee;
    border: 1px solid #ccc;
    cursor: pointer;
    text-align: center;
}

.tab-label label:hover {
    background: #ddd;
}

.tab-radio {
    display: none;
}

.content-tab-head {
    border: 1px solid #ccc;
    background: white;
/*    padding: 2rem;*/
    position: absolute;
    top: 3rem;
    width: 100%;
    overflow: hidden;
    height: 47vh;
    overflow: scroll;
}

.tab-content {
    display: none;
    width: 100%;
}

.tab-radio:checked + label {
    background: white;
    border-bottom: 1px solid white;
    position: relative;
    z-index: 2;
}

#tab1.tab-radio:checked ~ .content-tab-head .tab-content:nth-of-type(1),
#tab2.tab-radio:checked ~ .content-tab-head .tab-content:nth-of-type(2) {
    display: block;
}
</style>
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
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="containerNew">
                        <div class="left" id="left-content"></div>
                        <div class="contentNew" id="contentNew">
                            <div class="container">
                                <div class="card card-custom">

                                    <div class="card-header">
                                        <div class="row"  style="width:100%">
                                            <div class="col-lg-6">
                                                <div class="card-title" style="padding-top: 20px;">
                                                    <span class="card-icon">
                                                        <i class="flaticon2-notepad text-primary"></i>
                                                    </span>
                                                    <h3 class="card-label">Attribut Eselon</h3>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">                            
                                                <input type="hidden" name="reqId" value="{{$reqId}}">
                                                <input type="hidden" name="reqRowId" value="{{$formulaeselonid}}">
                                                <input type="hidden" name="reqTahun" value="{{$data->tahun}}">
                                                <input type="hidden" name="reqAspekId" value="2">
                                                
                                                <?php if(!empty($data->terpakai)){ ?>
                                                    <div class="form-group row">
                                                        <div class="col-lg-12 col-sm-12">
                                                            <span style="color:red; font-size: 12px;margin-top: 20px;float: right;">*formula sudah di set di ujian. tipe formula tidak bisa diubah</span>
                                                        </div>
                                                    </div>
                                                <?php } 
                                                else{
                                                ?>
                                                   <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2" style="margin-top: 20px;float: right;">Simpan</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tabs">
                                        <input type="radio" id="tab1" name="tab-control" class="tab-radio" checked>
                                        <ul class="tab-labels">                                            
                                            <li class="menu-item" aria-haspopup="true" style="width:50%">
                                                <a href="app/setting_pelaksanaan/attribut/<?=$reqId?>/<?=$formulaeselonid?>" style="width: 100%;display: block;text-align: center;">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text" style="width: 100%; display: block; vertical-align: center; padding-top: 10px;">Potensi</span>
                                                </a>
                                            </li>
                                            <li class="tab-label" title="Tab 1">
                                                <label for="tab1" role="button"  style="background-color: #0877b4;color: white;">
                                                    <span>Kompetensi</span>
                                                </label>
                                            </li>
                                        </ul>
                                        <div class="content-tab-head" style="overflow-y: hidden;">
                                            <div class="card-body" style="padding: 1rem 2rem;">
                                                <div class="form-group row">
                                                    <section class="tab-content">
                                                        <table id='customers'>
                                                            <tr>                                    
                                                                <th width="30%">Attribut</th>
                                                                <th width="10%">Level</th>
                                                                <th width="10%">Nilai Standart</th>
                                                                <th width="50%">Penggalian</th>    
                                                            </tr>
                                                        </table>
                                                        <div style="height: 35vh;overflow: scroll;">
                                                            <table id='customers'>
                                                                <?php foreach ($query as $key => $value) {?>
                                                                    <tr>
                                                                        <?php if($value->atribut_id_parent==0){?>
                                                                            <td colspan=4 style="padding: 15px;background-color: #cfe3f8;">
                                                                                <b><?=$value->nama?></b>
                                                                        </td>
                                                                            

                                                                        <?php }
                                                                        else{?>                         
                                                                            <td  width="30%" style="padding: 15px;">
                                                                                <?=$value->nama?>

                                                                            <input type="hidden" name="reqBobotStatusAtributId[]" value="1" />


                                                                            <input type="hidden" name="reqBobotAtributId[]" value="<?=$value->atribut_id?>" />

                                                                            <input type="hidden" name="reqFormulaAtributBobotId[]" value="<?=$value->formula_atribut_bobot_id?>" />
                                                                            <input type="hidden" name="reqFormulaAtributId[]" value="<?=$value->formula_atribut_id?>" />
                                                                            <input type="hidden" name="reqAtributParentId[]"value="<?=$value->atribut_id_parent?>" />
                                                                        </td>
                                                                        <?php } 

                                                                        if($value->atribut_id_parent==0){} 
                                                                        else {?>
                                                                            <td width="10%">
                                                                                <select class="form-control"  name="reqLevelId[]">
                                                                                    <option value='0' <?php if($value->level_id==''){
                                                                                        echo'selected';}
                                                                                    ?> > Pilih Level</option>
                                                                                <?php
                                                                                $dropdowns=StringFunc::in_array_column($value->atribut_id,'atribut_id',$dropdown);
                                                                                foreach ($dropdowns as $key => $value_data) {
                                                                                    $selected='';
                                                                                    if($value->level_id==$dropdown[$value_data]['level_id']){
                                                                                        $selected='selected';}
                                                                                    ?>
                                                                                    <option <?=$selected?> value=<?=$dropdown[$value_data]['level_id']?>><?=$dropdown[$value_data]['level']?></option>
                                                                                <?php }?>
                                                                                </select>
                                                                            </td>
                                                                            <td  style="padding: 10px;" width="10%">
                                                                                <select class="form-control" name="reqAtributNilaiStandar[]">
                                                                                    <option value="" <?php if ($value->atribut_nilai_standar==''){ echo 'selected';}?>>Pilih Nilai</option>
                                                                                    <option value="1" <?php if ($value->atribut_nilai_standar==1){ echo 'selected';}?>>1</option>
                                                                                    <option value="2" <?php if ($value->atribut_nilai_standar==2){ echo 'selected';}?>>2</option>
                                                                                    <option value="3" <?php if ($value->atribut_nilai_standar==3){ echo 'selected';}?>>3</option>
                                                                                    <option value="4" <?php if ($value->atribut_nilai_standar==4){ echo 'selected';}?>>4</option>
                                                                                    <option value="5" <?php if ($value->atribut_nilai_standar==5){ echo 'selected';}?>>5</option>
                                                                                </select>
                                                                            </td>
                                                                            <td width="50%">
                                                                                <?php
                                                                                $hasil=array();
                                                                                $reqpenggaliantotal='';
                                                                                $newArray=array();
                                                                                if($value->formula_atribut_id!=''){
                                                                                    $hasil=StringFunc::in_array_column($value->formula_atribut_id,'formula_atribut_id',$penggalian);
                                                                                    $a=0;
                                                                                    if (is_array($hasil) && !empty($hasil)) {
                                                                                       
                                                                                        foreach ($hasil as $key => $v_data)
                                                                                        {
                                                                                            $newArray['penggalian_id'][$a]=$penggalian[$v_data]['penggalian_id'];

                                                                                            $newArray['form_atribut_id'][$a]=$penggalian[$v_data]['form_atribut_id'];

                                                                                            $reqpenggaliantotal=$penggalian[$v_data]['penggalian_id'].','.$reqpenggaliantotal;
                                                                                            $a++;
                                                                                        }
                                                                                    } 
                                                                                }
                                                                                foreach ($checklist as $key => $value_data) {
                                                                                    $masuk='';
                                                                                if($value->formula_atribut_id!=''){

                                                                                    if (is_array($hasil) && !empty($hasil)) {
                                                                                        if (in_array($value_data->penggalian_id, $newArray['penggalian_id']) && in_array($value->atribut_id, $newArray['form_atribut_id'])){
                                                                                            $masuk='checked';
                                                                                        } 
                                                                                    }
                                                                                }?>
                                                                                    <input type="checkbox" <?=$masuk?> class='checklist' id='idcheck-<?=$value->atribut_id?>'name="" style="margin-left: 10px;" value="<?=$value_data->penggalian_id?>">
                                                                                    <?=$value_data->kode?>
                                                                                <?php }?>
                                                                                <input type="hidden" name="reqAtributPenggalianId[]" style="margin-left: 10px;" id='textcheck-<?=$value->atribut_id?>' value='<?=$reqpenggaliantotal?>'>

                                                                            </td>
                                                                        <?php }?>
                                                                    </tr>
                                                                <?php 
                                                                }?>
                                                            </table>
                                                        </div>
                                                    </section>
                                                </div>                            
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

        var url = "SettingPelaksanaan/addAtributKompetensi";

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
                            id= data[0];
                            rowid= data[1];
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
                                    document.location.href = "app/setting_pelaksanaan/attributkompetensi/"+id+'/'+rowid;
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

            $('.cekangka').change(function() {
                var selectedValue = $(this).val();
                if( 5 < selectedValue){
                    $(this).val('');
                    Swal.fire("Error", 'Maximal angka hanya 5', "error");
            }});

            $('.checklist').click(function() {
                var id = $(this).attr('id');
                var patokan=id.replace("idcheck", "");
                var ambilval=$('#textcheck'+patokan).val();
                
                if($(this).prop('checked')){
                    if(ambilval==''){
                        var selectedValue = $(this).val();
                    }
                    else{
                        var selectedValue = ambilval+','+$(this).val();
                    }
                    
                    $('#textcheck'+patokan).val(selectedValue)
                }
                else{
                    var selectedValue = $(this).val();
                    var ambilval=ambilval.replace(","+selectedValue, "");
                    var ambilval=ambilval.replace(selectedValue, "");
                    $('#textcheck'+patokan).val(ambilval)


                }
            });
        });

        fetch('/app/setting_pelaksanaan/edit/<?=$pg?>/<?=$reqId?>/<?=$formulaeselonid?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));
    </script>

@endsection