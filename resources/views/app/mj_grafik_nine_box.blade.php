
@extends('app/index_talenta') 
@section('content')

<script src="https://code.highcharts.com/highcharts.js"></script>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Grafik Nine Box</h3>
                    </div>
                </div>
                <div class="containerNew">
                    <div class="left" id="left-content"></div>
                    <div class="contentNew" id="contentNew">
                        <div class="container">
                            <div class="card card-custom">
                                <form class="formadd" id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-lg-6" >
                                            <div id="container" style="width:100%; height:400px;"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <table id="customers">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 10px;">KUADRAN</th>
                                                        <th style="font-size: 10px;">JUMLAH</th>
                                                        <th style="font-size: 10px;">KETERANGAN</th>
                                                        <th style="font-size: 10px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(11)">
                                                        <td style="font-size: 12px;">I</td>
                                                        <td style="font-size: 12px;">47 orang</td>
                                                        <td style="font-size: 12px;">Tingkatkan Kompetensi</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(12)">
                                                        <td style="font-size: 12px;">II</td>
                                                        <td style="font-size: 12px;">0 orang</td>
                                                        <td style="font-size: 12px;">Tingkatkan Peran Saat Ini</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(21)">
                                                        <td style="font-size: 12px;">III</td>
                                                        <td style="font-size: 12px;">0 orang</td>
                                                        <td style="font-size: 12px;">Tingkatkan Peran Saat Ini</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(13)">
                                                        <td style="font-size: 12px;">IV</td>
                                                        <td style="font-size: 12px;">3 orang</td>
                                                        <td style="font-size: 12px;">Tingkatkan Peran Saat Ini</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(22)">
                                                        <td style="font-size: 12px;">V</td>
                                                        <td style="font-size: 12px;">0 orang</td>
                                                        <td style="font-size: 12px;">Siap Untuk Peran Masa Depan Dengan Pengembangan</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(31)">
                                                        <td style="font-size: 12px;">VI</td>
                                                        <td style="font-size: 12px;">47 orang</td>
                                                        <td style="font-size: 12px;">Pertimbangkan (Mutasi)</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(23)">
                                                        <td style="font-size: 12px;">VII</td>
                                                        <td style="font-size: 12px;">0 orang</td>
                                                        <td style="font-size: 12px;">Siap Untuk Peran Masa Depan Dengan Pengembangan</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(32)">
                                                        <td style="font-size: 12px;">VIII</td>
                                                        <td style="font-size: 12px;">0 orang</td>
                                                        <td style="font-size: 12px;">Siap Untuk Peran Masa Depan Dengan Pengembangan</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                    <tr style="cursor:pointer" onclick="setkuadran(33)">
                                                        <td style="font-size: 12px;">IX</td>
                                                        <td style="font-size: 12px;">0 orang</td>
                                                        <td style="font-size: 12px;">Siap Untuk Peran Di Masa Depan</td>
                                                        <td><a onClick="openDirektorat('1')"> lihat</a></td>
                                                    </tr>
                                            
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
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
     
        function openDirektorat(id)
        {
            openAdd('/app/manajemen_talenta/lookup/');
        }
    </script>

@endsection