<?php
use App\Helper\InfoUjianFunc;
?>
@extends('ujian/index_ujian_popup') 
@section('content')
    <div class="d-flex flex-column-fluid" style="margin-top: 40px;">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Petunjuk Pengerjaan Soal</h3>
                    </div>
                </div>
                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body">
                        <div class="form-group row">
                            <?=InfoUjianFunc::setinfo($reqId, $urutan)?>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <button onclick="kembali()" type="button" class="btn btn-warning font-weight-bold mr-2">Kembali</button> -->
                                <?php if($reqTipe=='open'){?>
                                    <button onclick="selanjutnya()" type="button" class="btn btn-warning font-weight-bold mr-2" style="  float: right;">Masuk Ke ujian</button>
                                <?php }?>
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