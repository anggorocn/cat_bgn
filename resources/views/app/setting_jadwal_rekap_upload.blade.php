<?php
    $query=json_decode(json_encode($query), true);
    // print_r($query);exit;
    $arrdata= array(
        // array("label"=>"No", "field"=> "nomor_urut_generate", "display"=>"",  "width"=>"80")
        array("label"=>"Nip", "field"=> "nip_baru", "display"=>"",  "width"=>"80")
        ,array("label"=>"Nama", "field"=> "nama", "display"=>"",  "width"=>"80")
        ,array("label"=>"Jabatan", "field"=> "last_jabatan", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
        ,array("label"=>"Status", "field"=> "status_html", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
        // ,array("label"=>"Hasil", "field"=> "bukti_pendukung", "alias"=> "A.keterangan", "display"=>"",  "width"=>"80")
        // ,array("label"=>"Hasil", "field"=> "aksi", "alias"=> "A.keterangan", "display"=>"",  "width"=>"200")
                    
        // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
        , array("label"=>"sorderdefault", "field"=> "pegawai_id",  "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
        , array("label"=>"fieldid", "field"=> "pegawai_id", "alias"=> "A.pegawai_id", "display"=>"1", "width"=>"")
    );
?>
<style>
    /* Style untuk tombol dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-button {
        background-color: #3699ff;
        color: white;
        padding: 9px 20px;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-family: Poppins, Helvetica, "sans-serif";
        font-weight: 600 !important;
    }
    .dropdown-button:hover {
        background-color: #0056b3;
    }

    /* Style untuk menu dropdown */
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 150px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        z-index: 1;
    }
    .dropdown-menu a {
        color: black;
        padding: 10px 20px;
        text-decoration: none;
        display: block;
    }
    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    /* Tampilkan menu dropdown saat aktif */
    .dropdown.active .dropdown-menu {
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
                        <h3 class="card-label">Hasil Ujian</h3>
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
                                            <i class="flaticon2-notepad text-primary"></i>
                                        </span>
                                        <h3 class="card-label">Rekap Ujian Essay</h3>
                                    </div>
                                   <div class="card-toolbar">
                                        <div class="dropdown" id="dropdown2">
                                            <button class="dropdown-button" onclick="toggleDropdown(2)">Buka Submit</button>
                                            <div class="dropdown-menu">
                                                <?php
                                                for($i=0; $i<count($query);$i++){ ?>
                                                    <li><a class="dropdown-item" style="cursor: pointer;" onclick="reset(<?=$query[$i]['essay_soal_id']?>)"><?=$query[$i]['nama']?></a></li>
                                                <?php
                                                }?>
                                            </div>
                                        </div>
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
        var datanewtable;
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

            var jsonurl= "/SettingJadwal/jsonEssay/<?=$reqId?>";
            ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

             $("#triggercari").on("click", function () {
                if(carijenis == "1")
                {
                    pencarian= $('#'+infotableid+'_filter input').val();
                    datanewtable.DataTable().search( pencarian ).draw();
                }
            });

            $('#'+infotableid+' tbody').on( 'click', 'tr', function () {
                // untuk pilih satu data, kalau untuk multi comman saja
                $('#'+infotableid+' tbody tr').removeClass('selected');

                var el= $(this);
                el.addClass('selected');

                var dataselected= datanewtable.DataTable().row(this).data();
                // console.log(valinfoid);
                // console.log(Object.keys(dataselected).length);

                fieldinfoid= arrdata[indexfieldid]["field"]
                valinfoid= dataselected[fieldinfoid];
                // console.log(valinfoid);
                if (valinfoid == null)
                {
                    valinfoid = '';
                }
            });
        });

        function calltriggercari()
        {
            $(document).ready( function () {
              $("#triggercari").click();      
            });
        }

        fetch('/app/setting_jadwal/edit/<?=$pg?>/<?=$reqId?>')
        .then(response => response.text())
        .then(data => {
            document.getElementById('left-content').innerHTML = data;
        })
        .catch(error => console.error('Terjadi kesalahan:', error));
        
        function toggleDropdown(val) {
            // Dapatkan elemen dropdown
            const dropdown = document.querySelector('#dropdown'+val);

            // Tambahkan atau hapus class "active"
            dropdown.classList.toggle('active');
        }

        // Tutup dropdown jika klik di luar
        window.onclick = function (event) {
            const dropdown = document.querySelector('.dropdown');
            if (!event.target.matches('.dropdown-button')) {
                dropdown.classList.remove('active');
            }
        };
        
        function reset(tipeid) {
            if(valinfoid == "")
            {
                Swal.fire({
                    text: "Pilih salah satu Pegawai terlebih dahulu.",
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
                urlAjax= "/SettingJadwal/resetEssay/<?=$reqId?>/"+valinfoid+"/"+tipeid;
                swal.fire({
                    title: 'Apakah anda yakin untuk Reset data?',
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
                                    document.location.href = "app/setting_jadwal/rekap_upload/<?=$reqId?>";
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