<?php
use App\Helper\InfoUjianFunc;
?>
@extends('ujian/index_ujian_popup') 
@section('content')
    <div class="d-flex flex-column-fluid" style="margin-top: 40px;">
        <div class="container">
            <div class="card card-custom">
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body">
                        <div class="form-group row">
                            <iframe src="template_soal/<?=$soalessay->kegiatan_file_file?>" width="100%" height="400vh"></iframe>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function selanjutnya() {
            window.parent.postMessage({
                action: "callMyFunction",
                value: '<?=$tahapid?>/<?=$urutan?>'
            }, "*");
        }
    </script>

@endsection