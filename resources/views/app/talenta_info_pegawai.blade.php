
@extends('app/index_talenta') 
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Manajemen Talenta</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{url('app/manajemen_talenta/tabelninebox/')}}" class="btn btn-primary font-weight-bolder">
                            Kembali
                        </a>
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
                                        <h3 class="card-label">Identitas Peserta</h3>
                                    </div>
                                </div>
                                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">NIP</label>
                                            <label class="col-form-label col-lg-10 col-sm-12">197312282001121003</label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Nama</label>
                                            <label class="col-form-label col-lg-10 col-sm-12">Deni Ropikanur</label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Pangkat/Gol</label>
                                            <label class="col-form-label col-lg-10 col-sm-12">IV/a (Pembina)</label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Jabatan</label>
                                            <label class="col-form-label col-lg-10 col-sm-12">ANALIS PERENCANAAN, EVALUASI DAN PELAPORAN</label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Kuadran</label>
                                            <label class="col-form-label col-lg-10 col-sm-12">VIII</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-notepad text-primary"></i>
                                        </span>
                                        <h3 class="card-label">Tabel Nine Box</h3>
                                    </div>
                                </div>
                                <div id="container" style="width:100%; height:400px;"></div>
                            </div>
                            <br>
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-notepad text-primary"></i>
                                        </span>
                                        <h3 class="card-label">Grafik Potensi dan Kompetensi</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <br>
                                        <h5 style="color:black; text-align: center;">GRAFIK GAMBARAN POTENSI SAAT INI</h5>
                                        <div id="container1"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <br>
                                        <h5 style="color:black; text-align: center;">GRAFIK GAMBARAN KOMPETENSI SAAT INI</h5>
                                        <div id="container2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-notepad text-primary"></i>
                                        </span>
                                        <h3 class="card-label">Tabel Penilaian</h3>
                                    </div>
                                </div>
                                <table id="customers">
                                    <tr>
                                        <th width="50%">Indikator</th>
                                        <th width="40%">Sub Indikator</th>
                                        <th width="10%">Nilai</th>
                                    </tr>
                                    <tr>
                                        <td style="background-color:lightgray ; color: black;" colspan="3"><b>Potensi</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Potensi</td>
                                        <td >30</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Kompetensi</td>
                                        <td >40</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Pendidikan</td>
                                        <td >25</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Total</b></td>
                                        <td >30</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:lightgray ; color: black;" colspan="3"><b>Kinerja</b></td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2">Kinerja</td>
                                        <td>Predikat Kinerja</td>
                                        <td rowspan="2">25</td>
                                    </tr>
                                    <tr>
                                        <td>Perilaku</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Penghargaan</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Riwayat Hukuman Disiplin 5 Tahun Terakhir</td>
                                        <td>Riwayat Hukuman Disiplin</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Total</b></td>
                                        <td >36</td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const chart = Highcharts.chart('container', {
                chart: {
                    type: 'scatter',
                    plotBorderWidth: 1,
                    plotBorderColor: '#ccc'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    min: 0,
                    max: 100,
                    tickInterval: 25,
                    plotLines: [{
                        color: 'gray',
                        dashStyle: 'dash',
                        value: 33.33,
                        width: 1
                    }, {
                        color: 'gray',
                        dashStyle: 'dash',
                        value: 66.66,
                        width: 1
                    }],
                    plotBands: [{
                        from: 0,
                        to: 33.33,
                        color: 'rgba(255, 0, 0, 0.3)' // I, IV, VII
                    }, {
                        from: 33.33,
                        to: 66.66,
                        color: 'rgba(255, 255, 0, 0.3)' // II, V, VIII
                    }, {
                        from: 66.66,
                        to: 100,
                        color: 'rgba(0, 255, 0, 0.3)' // III, VI, IX
                    }],
                    title: {
                        text: 'Potensi'
                    }
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    tickInterval: 25,
                    plotLines: [{
                        color: 'gray',
                        dashStyle: 'dash',
                        value: 33.33,
                        width: 1
                    }, {
                        color: 'gray',
                        dashStyle: 'dash',
                        value: 66.66,
                        width: 1
                    }],
                    plotBands: [{
                        from: 0,
                        to: 33.33,
                        color: 'rgba(255, 0, 0, 0.3)' // I, II, III
                    }, {
                        from: 33.33,
                        to: 66.66,
                        color: 'rgba(255, 255, 0, 0.3)' // IV, V, VI
                    }, {
                        from: 66.66,
                        to: 100,
                        color: 'rgba(0, 255, 0, 0.3)' // VII, VIII, IX
                    }],
                    title: {
                        text: 'Kinerja'
                    }
                },
                
                tooltip: {
                    formatter: function () {
                        return 'Nama: <b>' + this.point.name + '</b><br/>Kinerja: <b>' + this.y + '</b><br/>Potensi: <b>' + this.x + '</b>';
                    }
                },
                series: [{
                    name: 'Employees',
                    color: 'rgba(0, 0, 255, .5)',
                    data: [
                        { x: 10, y: 90, name: 'Employee 1' },
                        { x: 50, y: 90, name: 'Employee 2' },
                        { x: 90, y: 90, name: 'Employee 3' },
                        { x: 10, y: 50, name: 'Employee 4' },
                        { x: 50, y: 50, name: 'Employee 5' },
                        { x: 90, y: 50, name: 'Employee 6' },
                        { x: 10, y: 10, name: 'Employee 7' },
                        { x: 50, y: 10, name: 'Employee 8' },
                        { x: 90, y: 10, name: 'Employee 9' }
                    ]
                }]
            });

            // Adding labels for each box
            const labels = [
                { text: 'I', x: 16.66, y: 16.66 },
                { text: 'II', x: 16.66, y: 50 },
                { text: 'III', x: 50, y: 16.66 },
                { text: 'VI', x: 83.33, y: 16.66 },
                { text: 'V', x: 50, y: 50 },
                { text: 'IV', x: 16.66, y: 83.33 },
                { text: 'VII', x: 50, y: 83.33 },
                { text: 'VIII', x: 83.33, y: 50 },
                { text: 'IX', x: 83.33, y: 83.33 }
            ];

            labels.forEach(label => {
                chart.renderer.text(
                    label.text,
                    chart.xAxis[0].toPixels(label.x),
                    chart.yAxis[0].toPixels(label.y)
                )
                .css({
                    fontSize: '16px',
                    fontWeight: 'bold'
                })
                .add();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const chart1 = Highcharts.chart('container1', {
                chart: {
                    polar: true,
                    type: 'line'
                },
                title: {
                    text: ''
                },
                pane: {
                    size: '80%'
                },
                xAxis: {
                    categories: [
                        'Emotional Quotient/Kecerdasan Emosi',
                        'Kesadaran Diri',
                        'Kemampuan Interpersonal',
                        'Kemampuan Pemecahan Masalah',
                        'Kemampuan Berpikir Kritis dan Strategis',
                        'Kemampuan Inti',
                        'Motivasi dan Komitmen (Grit)',
                        'Kemampuan Belajar Cepat dan Mengembangkan Diri (Growth Mindset)'
                    ],
                    tickmarkPlacement: 'on',
                    lineWidth: 0
                },
                yAxis: {
                    gridLineInterpolation: 'polygon',
                    lineWidth: 0,
                    min: 0,
                    max: 5,
                    tickInterval: 1
                },
                tooltip: {
                    shared: true,
                    pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y}</b><br/>'
                },
                series: [{
                    name: 'Current Potential',
                    data: [3, 2, 2, 3, 4, 3, 2, 4],
                    pointPlacement: 'on',
                    color: 'red'
                }, {
                    name: 'Target Potential',
                    data: [4, 3, 3, 4, 5, 4, 3, 5],
                    pointPlacement: 'on',
                    color: 'green'
                }]
            });

            const chart2 = Highcharts.chart('container2', {
                chart: {
                    polar: true,
                    type: 'line'
                },
                title: {
                    text: ''
                },
                pane: {
                    size: '80%'
                },
                xAxis: {
                    categories: [
                        'Integritas',
                        'Kerjasama',
                        'Komunikasi',
                        'Orientasi pada Hasil',
                        'Pelayanan Publik',
                        'Pengembangan Diri dan Orang Lain',
                        'Mengelola Perubahan',
                        'Kemampuan Pengambilan Keputusan',
                        'Perekat Bangsa'
                    ],
                    tickmarkPlacement: 'on',
                    lineWidth: 0
                },
                yAxis: {
                    gridLineInterpolation: 'polygon',
                    lineWidth: 0,
                    min: 0,
                    max: 5,
                    tickInterval: 1
                },
                tooltip: {
                    shared: true,
                    pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y}</b><br/>'
                },
                series: [{
                    name: 'Current Competency',
                    data: [2, 3, 3, 2, 3, 4, 3, 4, 3],
                    pointPlacement: 'on',
                    color: 'red'
                }, {
                    name: 'Target Competency',
                    data: [4, 4, 4, 3, 4, 5, 4, 5, 4],
                    pointPlacement: 'on',
                    color: 'green'
                }]
            });
        });
        
        fetch('/app/talenta/edit/<?=$reqId?>/<?=$pg?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));
    </script>

@endsection