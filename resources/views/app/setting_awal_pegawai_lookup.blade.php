<?php
    $arrdata= array(
        array("label"=>"Nama", "field"=> "nama", "alias"=> "nama", "display"=>"",  "width"=>"80")
        ,array("label"=>"NIP", "field"=> "nip_baru", "alias"=> "nip_baru", "display"=>"",  "width"=>"80")
        // , array("label"=>"Direktorat", "field"=> "DEPARTEMEN", "alias"=> "A.DEPARTEMEN", "display"=>"",  "width"=>"10")
        // , array("label"=>"Jenis", "field"=> "JENIS_PEGAWAI", "alias"=> "A.JENIS_PEGAWAI", "display"=>"",  "width"=>"10")
        // , array("label"=>"Email", "field"=> "EMAIL", "alias"=> "A.EMAIL", "display"=>"",  "width"=>"10")

        // buat tombol aksi
        , array("label"=>"Aksi", "field"=> "aksi",  "display"=>"",  "width"=>"10")
        
        // untuk dua ini kunci, data akhir id, data sebelum akhir untuk order
        , array("label"=>"sorderdefault", "field"=> "idpeg",  "alias"=> "A.idpeg", "display"=>"1", "width"=>"")
        , array("label"=>"fieldid", "field"=> "idpeg", "alias"=> "A.idpeg", "display"=>"1", "width"=>"")

    );

?>
@extends('app/index_lookup') 
@section('content')

<link href="assets/jquery-easyui-1.4.2/themes/default/easyui.css" rel="stylesheet" type="text/css" />
<link href="assets/jquery-easyui-1.4.2/themes/icon.css" rel="stylesheet" type="text/css" />
<script src="assets/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/jquery-easyui-1.4.2/themes/default/easyui.css">
<script src="assets/js/jquery-ui.js"></script>


<meta name="csrf_token" content="{{ csrf_token() }}" />

<style type="text/css">
    /****/
#infodetilparaf{        
}
#infodetilparaf ol{
    list-style-position: inside;
    padding: 0 0;
}
#infodetilparaf .alert,
#infodetilparaf .text-danger {
    /*padding: 6px 10px ;*/
    font-size: 12px;
}
#infodetilparaf .btn.btn-primary{
    float: right;
}
#infodetilparaf .Nodot {
}
#infodetilparaf .ListItem{
    padding: 0 5px 2px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px; 
}
#infodetilparaf .ListItem:Hover {
    cursor: pointer;
    background: rgba(0,0,0,0.1);
}


#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 1000; /* Ensure loading screen is above other elements */
/*    display: none;*/
}

.spinner {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#main-content {
    padding: 20px;
}

/****/

</style>
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">Pilih Peserta</h3>
                </div>
                <div class="card-toolbar">
                    <a onclick="save()" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                        </span>Pilih Data
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="info" class="tabcontent" style="display: block;">
                    <div class="form-group row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="row" >
                                <div id="infodetilparaf">
                                    <div class="col-lg-12" style="color: black;">
                                        <b> Peserta Terpilih</b>
                                    </div>
                                    <div class="col-lg-12" id='reqData0'  style="color: black;">
                                        Pilih salah satu data!
                                    </div>
                                    <div class="col-lg-12" style="color: black;">
                                        <table id="data">
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <!-- Pilih salah satu data! -->
                                    </div>
                                </div>
                                <div  id="new_chq">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-sm-12">
                            <div class="card-title">
                                <h3 class="card-label">List Peserta</h3>
                            </div>
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
<div id="loading-screen">
    <div class="spinner"></div>
    <p>Loading...</p>
</div>
<div id="main-content" style="display: none;">
    <h1>Welcome to the Main Page</h1>
    <p>This is the main content of the page.</p>
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
        array=[];
        arrayid=[<?=$filter?>];
        console.log(arrayid);
        $("#reqUnitKerja,#reqJenis").change(function() {
            var cari = ''; 
            var reqUnitKerja= $("#reqUnitKerja").val();
            var reqJenis= $("#reqJenis").val();
            jsonurl= "/SettingAwal/jsonpegawai/<?=$reqId?>/"+arrayid;
            datanewtable.DataTable().ajax.url(jsonurl).load();
        });

        var reqUnitKerja= $("#reqUnitKerja").val();

        var jsonurl= "/SettingAwal/jsonpegawai/<?=$reqId?>";
        ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

         $("#triggercari").on("click", function () {
            if(carijenis == "1")
            {
                pencarian= $('#'+infotableid+'_filter input').val();
                datanewtable.DataTable().search( pencarian ).draw();
            }
        });
         loadingDiactive()
    });




         
    function calltriggercari()
    {
        $(document).ready( function () {
          $("#triggercari").click();      
        });
    }
    function tampil(id, nama, nip){
        loadingActive()
        $("#reqData0").hide();
        var newRow = `<tr>
            <td>`+nama+`(`+nip+`) <input type='hidden' value='`+id+`'> </td>
            <td style='margin 10px'><button class="removeBtn btn btn-danger mr-1 btn-sm detailProduct" id='hapus-`+id+`'><i class="fa fa-trash"></i></button></td>
          </tr>`;
        $('#data tbody').append(newRow);

        array[id] = {
            id: id,
            nama: nama,
            nip: nip
        };

        arrayid.push(id);
        console.log(array)

        var newUrl = "/SettingAwal/jsonpegawai/<?=$reqId?>/"+arrayid; // URL JSON baru

        // Ubah URL sumber data
        datanewtable.DataTable().ajax.url(newUrl).load(function() {
            loadingDiactive(); // Fungsi ini akan dipanggil setelah data selesai dimuat
        });
    }

    $('#data').on('click', '.removeBtn', function() {
        loadingActive()
        var buttonId = $(this).attr('id'); // Mendapatkan ID tombol yang diklik
        var selectedValue = buttonId.split('-')[1];
        var ambilval=$('#dataterpilih').val();
        var ambilval=ambilval.replace("'"+selectedValue+"',", "");
        var ambilval=ambilval.replace("'"+selectedValue+"'", "");
        delete array[selectedValue];
        arrayid = arrayid.filter(function(item) {
            return item !== selectedValue;  // Menyaring elemen yang tidak sama dengan 5
        });
        
        var newUrl = "/SettingAwal/jsonpegawai/<?=$reqId?>/"+arrayid; // URL JSON baru
        // Ubah URL sumber data
        $(this).closest('tr').remove();
        datanewtable.DataTable().ajax.url(newUrl).load(function() {
            loadingDiactive(); // Fungsi ini akan dipanggil setelah data selesai dimuat
        });
    });

    function save() {
        var ambilval=$('#dataterpilih').val();
        if(ambilval == '')
        {
            $.messager.alert('Info', "Pilih data terlebih dahulu.", 'info');
            return;
        }
        else{
            if (typeof window.parent.closeIFrame === 'function')
            {
                
                window.parent.postMessage(array)
                parent.closeIFrame();
            }
        }

    }

    function loadingActive () {
        var loadingScreen = document.getElementById("loading-screen");
        var mainContent = document.getElementById("main-content");

        $('#loading-screen').show();
        mainContent.style.display = "block";  // Show main content

        document.body.style.overflow = "auto"; // Enable scrolling
        console.log('xxx')
    };

    function loadingDiactive() {
        var loadingScreen = document.getElementById("loading-screen");
        $('#loading-screen').hide();
        console.log('yyy')
    }
</script>
@endsection
