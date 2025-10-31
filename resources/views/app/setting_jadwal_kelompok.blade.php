  <style>
    .toggle {
      color: blue;
      cursor: pointer;
      text-decoration: underline;
      font-size: 15px;
      margin-top: 10px;
      width: 100%;
    }
    #content-belumdaftar {
      display: none;
      margin-top: 10px;
      padding: 10px;
      background: #2c3e50;
      border-radius: 5px;
      width: 100%;

    }
  </style>
<?php
    $queryhead=json_decode(json_encode($queryhead), true);
    $query=json_decode(json_encode($query), true);
    $total=json_decode(json_encode($total), true);
    // print_r($total);exit;
    if($IdentitasUjian->status_valid==1){
        $disabled='disabled';
    }

    $arrdata= array(
        array("label"=>"Nama", "field"=> "nama", "alias"=> "A.nama", "display"=>"",  "width"=>"80")
        , array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
        
        // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
        , array("label"=>"sorderdefault", "field"=> "kelompok_id",  "alias"=> "A.jadwal_awal_tes_id", "display"=>"1", "width"=>"")
        , array("label"=>"fieldid", "field"=> "kelompok_id", "alias"=> "A.jadwal_awal_tes_id", "display"=>"1", "width"=>"")
    );

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
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-supermarket text-primary"></i>
                                        </span>
                                        <h3 class="card-label"> Setting Kelompok</h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <a href='app/setting_jadwal/add_kelompok/<?=$reqId?>' class="btn btn-primary font-weight-bolder">
                                            Tambah
                                        </a>
                                    </div>

                                    <p class="toggle" onclick="toggleText()"> pegawai yang belum terdaftar <?=count($total)?> orang</p>
                                    <div id="content-belumdaftar">
                                        <?php
                                        for($i=0;$i<count($total);$i++){?>
                                            <?=$i+1?>. <?=$total[$i]['nama']?> ( <?=$total[$i]['nip_baru']?> )<br>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable" style="margin-top: 13px !important;width:100%">
                                        <thead>
                                            <tr>
                                                <?php
                                                foreach($arrdata as $valkey => $valitem) 
                                                {
                                                    echo "<th>".$valitem["label"]."</th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>

    <script type="text/javascript">

// menu samping
        fetch('/app/setting_jadwal/edit/<?=$pg?>/<?=$reqId?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));var datanewtable;
        
        var infotableid= "kt_datatable";
        var carijenis= "";
        var arrdata= <?php echo json_encode($arrdata); ?>;
        var indexfieldid= arrdata.length - 1;
        var indexvalidasiid= arrdata.length - 3;
        var indexvalidasihapusid= arrdata.length - 4;
        var valinfoid = '';
        var valinfovalidasiid = '';
        var valinfovalidasihapusid = '';

        // var infoscrolly = 50;
        // var datainfoscrollx = 0;

        jQuery(document).ready(function() {
            
            $("#reqUnitKerja,#reqJenis").change(function() {
                var cari = ''; 
                var reqUnitKerja= $("#reqUnitKerja").val();
                var reqJenis= $("#reqJenis").val();
                jsonurl= "/SettingJadwal/jsonKelompok/<?=$reqId?>";
                datanewtable.DataTable().ajax.url(jsonurl).load();
            });

            var reqUnitKerja= $("#reqUnitKerja").val();

            var jsonurl= "/SettingJadwal/jsonKelompok/<?=$reqId?>";
            ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

             $("#triggercari").on("click", function () {
                if(carijenis == "1")
                {
                    pencarian= $('#'+infotableid+'_filter input').val();
                    datanewtable.DataTable().search( pencarian ).draw();
                }
            });
        });

        function calltriggercari()
        {
            $(document).ready( function () {
              $("#triggercari").click();      
            });
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
                urlAjax= "/SettingJadwal/deleteKelompok/"+id;
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
                                    document.location.href = "app/setting_jadwal/kelompok/<?=$reqId?>";
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

    function toggleText() {
      var content = document.getElementById("content-belumdaftar");
      if (content.style.display === "none"||content.style.display === '' ) {
        content.style.display = "block";
      } else {
        content.style.display = "none";
      }
    }
    </script>

@endsection