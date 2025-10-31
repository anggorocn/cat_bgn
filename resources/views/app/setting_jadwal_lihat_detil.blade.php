
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">

    <!-- jQuery dan DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
    <style type="text/css">
    	.datatable:not(.table){
    		display: block !important;
    	}
    	 /* Agar tabel bisa di-scroll dengan baik */
        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
<?php
// print_r($arrayVal);exit;
?>
@extends('app/index_kosong') 
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Lihat Hasil</h3>
                    </div>
                </div>
                <div class="containerNew">
                    <div class="contentNew" id="contentNew" style="height:75vh">
                        <div class="container" >                        	
							<div class="w3-bar w3-black">
							  <button class="w3-bar-item w3-button" id="btnLondon" onclick="openCity('London')" style="background-color:lightblue">JPM Potensi</button>
							  <button class="w3-bar-item w3-button" id="btnParis" onclick="openCity('Paris')">JPM Kompetensi</button>
							</div>

							<div id="London" class="w3-container city">
								<div style=" width: 100%;">
        							<table id="myTable" class="display nowrap stripe row-border" style="color:black;">
             							<thead>
                                            <tr>
                                                <th rowspan="2" >No</th>
                                                <th rowspan="2" style="min-width:300px !important;text-align:center;">Nama</th>
                                                <th rowspan="2" style="min-width:300px !important;text-align:center;" >Jabatan</th>
                                                <th colspan="2" style=";text-align:center;">Kemampuan Intelektual</th>
                                                <th colspan="5" style=";text-align:center;">Kemampuan Berpikir Kritis dan Strategis</th>
                                                <th colspan="5" style=";text-align:center;">Kemampuan Menyelesaikan Permasalahan<br>(Problem Solving)</th>
                                                <th colspan="6" style=";text-align:center;">Motivasi dan Komitmen<br>(Grit)</th>
                                                <th colspan="4" style=";text-align:center;">Kesadaran Diri<br>(Self Awareness)</th>
                                                <th colspan="5" style=";text-align:center;">Kecerdasan Emosional<br>(Emotional Quotient)</th>
                                                <th colspan="4" style=";text-align:center;">Kemampuan Belajar Cepat dan Mengembangkan Diri<br>(Growth Mindset)</th>
                                                <th colspan="9" style=";text-align:center;">Kemampuan Interpersonal</th>
                                                <th rowspan="2" style=";text-align:center;">Rating Total<br>(JPM Potensi)</th>
                                                <th rowspan="2" style=";text-align:center;">Kategori<br>Pemetaan Potensi</th>
                                            </tr>
                                            <tr>
                                                <th>IQ</th>
                                                <th>Rating</th>

                                                <th>Nilai Subtes 2</th>
                                                <th>Rating Subtes 2</th>
                                                <th>Nilai Subtes 3</th>
                                                <th>Rating Subtes 3</th>
                                                <th>Rating</th>
                                                
                                                <th>n</th>
                                                <th>i</th>
                                                <th>N</th>
                                                <th>I</th>
                                                <th>Rating</th>

                                                <th>g</th>
                                                <th>a</th>
                                                <th>N</th>
                                                <th>G</th>
                                                <th>A</th>
                                                <th>Rating</th>

                                                <th>r</th>
                                                <th>N</th>
                                                <th>R</th>
                                                <th>Rating</th>

                                                <th>e</th>
                                                <th>k</th>
                                                <th>E</th>
                                                <th>K</th>
                                                <th>Rating</th>

                                                <th>z</th>
                                                <th>Z</th>
                                                <th>R</th>
                                                <th>Rating</th>

                                                <th>s</th>
                                                <th>b</th>
                                                <th>o</th>
                                                <th>x</th>
                                                <th>S</th>
                                                <th>B</th>
                                                <th>O</th>
                                                <th>X</th>
                                                <th>Rating</th>
                                            </tr>
        								</thead>
        								<tbody>
								           <?php
								           $no=1;
								           foreach ($arrayVal as $rowData) { ?>
												<tr>
												    <td style="background-color:yellow"><?=$no?></td>
												    <td style="text-align: left;background-color:yellow"><?=$rowData['nama_pegawai']?><br><?=$rowData['nip_baru']?></td>
												    <td style="text-align: left;background-color:yellow"><?=$rowData['last_jabatan']?></td>
												    <td ><?=$rowData['nilai_hasil']?></td>
												    <td ><?=$rowData['rating1']?></td>
												    <td ><?=$rowData['jumlah_benar_0102']?></td>
												    <td ><?=$rowData['rating22']?></td>
												    <td ><?=$rowData['jumlah_benar_0103']?></td>
												    <td ><?=$rowData['rating23']?></td>
												    <td ><?=$rowData['rating2']?></td>
												    <td ><?=$rowData['n']?></td>
												    <td ><?=$rowData['i']?></td>
												    <td ><?=round((($rowData['n']+1)/2))?></td>
												    <td ><?=round((($rowData['i']+1)/2))?></td>
												    <td ><?=$rowData['rating3']?></td>
												    <td ><?= $rowData['g']?></td>
												    <td ><?=$rowData['a']?></td>
												    <td ><?=round((($rowData['n']+1)/2))?></td>
												    <td ><?=round((($rowData['g']+1)/2))?></td>
												    <td ><?=round((($rowData['a']+1)/2))?></td>
												    <td ><?=round($rowData['rating4'],2)?></td>
												    <td ><?=$rowData['r']?></td>
												    <td ><?=round((($rowData['n']+1)/2))?></td>
												    <td ><?=round((($rowData['r']+1)/2))?></td>
												    <td ><?=round($rowData['rating5'],2)?></td>
												    <td ><?=$rowData['e']?></td>
												    <td ><?=$rowData['k']?></td>
												    <td ><?=round((($rowData['e']+1)/2))?></td>
												    <td ><?=round((($rowData['k']+1)/2))?></td>
												    <td ><?=round($rowData['rating6'],2)?></td>
												    <td ><?=$rowData['z']?></td>
												    <td ><?=round((($rowData['z']+1)/2))?></td>
												    <td ><?=round((($rowData['r']+1)/2))?></td>
												    <td ><?=round($rowData['rating7'],2)?></td>
												    <td ><?=$rowData['s']?></td>
												    <td ><?=$rowData['b']?></td>
												    <td ><?=$rowData['o']?></td>
												    <td ><?=$rowData['x']?></td>
												    <td ><?=round((($rowData['s']+1)/2))?></td>
												    <td ><?=round((($rowData['b']+1)/2))?></td>
												    <td ><?=round((($rowData['o']+1)/2))?></td>
												    <td ><?=round((($rowData['x']+1)/2))?></td>
												    <td ><?=round($rowData['rating8'],2)?></td>
												    <td ><?=round($rowData['jpm_potensi'],2)?></td>
												    <td ><?=$rowData['hasil_potensi']?></td>
												</tr>
            									<?php
												$no++;
           									}?>
        								</tbody>
       		 						</table>
								</div>
							</div>

							<div id="Paris" class="w3-container city">
							  <div style="width: 100%;">
        							<table id="myTable2" class="display nowrap stripe row-border" style="color:black;">
             							<thead>
                                            <tr>
                                                <th>No</th>
                                                <th style="min-width:300px !important;text-align:center;">Nama</th>
                                                <th style="min-width:300px !important;text-align:center;" >Jabatan</th>
                                                <th style="text-align:center;" >1. INTEGRITAS</th>
                                                <th style="text-align:center;" >2. KERJASAMA</th>
                                                <th style="text-align:center;" >3. KOMUNIKASI</th>
                                                <th style="text-align:center;" >4. ORIENTASI PADA HASIL</th>
                                                <th style="text-align:center;" >5. PELAYANAN PUBLIK</th>
                                                <th style="text-align:center;" >6. PENGEMBANGAN DIRI DAN ORANG LAIN</th>
                                                <th style="text-align:center;" >7. MENGELOLA PERUBAHAN</th>
                                                <th style="text-align:center;" >8. PENGAMBILAN KEPUTUSAN</th>
                                                <th style="text-align:center;" >9. PEREKAT BANGSA</th>
                                                <th style="text-align:center;" >TOTAL</th>
                                                <th style="text-align:center;" >JPM Kompetensi</th>
                                                <th style="text-align:center;" >Kategori Pemetaan Kompetensi</th>
                                            </tr>
        								<tbody>
								           <?php
								           $no=1;
								           foreach ($arrayVal as $rowData) { ?>
												<tr>
												    <td style="background-color:yellow"><?=$no?></td>
												    <td style="text-align: left;background-color:yellow"><?=$rowData['nama_pegawai']?><br><?=$rowData['nip_baru']?></td>
												    <td style="text-align: left;background-color:yellow"><?=$rowData['last_jabatan']?></td>
												    <td><?=$rowData['int']?></td>
												    <td><?=$rowData['kjsm']?></td>
												    <td><?=$rowData['kom']?></td>
												    <td><?=$rowData['oph']?></td>
												    <td><?=$rowData['pp']?></td>
												    <td><?=$rowData['pdol']?></td>
												    <td><?=$rowData['mp']?></td>
												    <td><?=$rowData['pk']?></td>
												    <td><?=$rowData['pb']?></td>
												    <td><?=$rowData['nilai']?></td>
												    <td><?=$rowData['jpm2']?></td>
												    <td><?=$rowData['pengisian_jabatan']?></td>
												</tr>
            									<?php
												$no++;
           									}?>
        								</tbody>
       		 						</table>
								</div> 
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">		    	
		function openCity(cityName) {
		  var i;
		  var x = document.getElementsByClassName("city");
		  for (i = 0; i < x.length; i++) {
		    x[i].style.display = "none";  
		  }
		  document.getElementById(cityName).style.display = "block"; 
		  document.querySelectorAll('[id^="btn"]').forEach(function (btn) {
			    btn.style.backgroundColor = "black"; // Ganti warna latar belakang
			});
		  document.getElementById("btn"+cityName).style.backgroundColor = "lightblue"; 
           $.fn.dataTable
            .tables({ visible: true, api: true })
            .columns.adjust()
            .fixedColumns().relayout();
		}
    </script>
    <script>
       $(document).ready(function () {
            // $('#Paris').hide()
        document.getElementById('Paris').style.display = "none"
            $('#myTable').DataTable({
                scrollY: "400px",   // Tinggi tabel yang bisa di-scroll
                scrollX: true,      // Aktifkan scroll horizontal
                scrollCollapse: true,
                paging: true,
                fixedHeader: true,  // Membekukan header
                fixedColumns: {     // Membekukan kolom pertama (ID)
                    leftColumns: 3
                },
                pageLength: 5,
            });

            $('#myTable2').DataTable({
                scrollY: "400px",   // Tinggi tabel yang bisa di-scroll
                scrollX: true,      // Aktifkan scroll horizontal
                scrollCollapse: true,
                paging: true,
                fixedHeader: true,  // Membekukan header
                fixedColumns: {     // Membekukan kolom pertama (ID)
                    leftColumns: 3
                },
                pageLength: 5,
            });
        });
    </script>

@endsection