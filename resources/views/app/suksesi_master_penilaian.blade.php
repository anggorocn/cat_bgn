<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.theme.default.css">
@extends('app/index_suksesi') 
@section('content')
<div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">Master Rencana Suksesi</h3>
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
										<h3 class="card-label"> Unsur Penilaian</h3>
									</div>
				<!-- 					<div class="card-toolbar">
										<a href="{{url('app/pegawai/add')}}" class="btn btn-primary font-weight-bolder">
											Tambah
										</a>
									</div> -->
								</div>
								<div class="card-body">
									<table id="customers" class="" style="color:black; font-size: 14px;">
								        <thead>
								            <tr>
								                <th>Nama</th>
								                <th>Aksi</th>
								            </tr>
								        </thead>
								        <tbody>
								            <tr data-tt-id="1">
								                <td>Root</td>
								                <td>Root details</td>
								            </tr>
								            <tr data-tt-id="2" data-tt-parent-id="1">
								                <td>Child 1</td>
								                <td>Child 1 details</td>
								            </tr>
								            <tr data-tt-id="3" data-tt-parent-id="1">
								                <td>Child 2</td>
								                <td>Child 2 details</td>
								            </tr>
								            <tr data-tt-id="4" data-tt-parent-id="1">
								                <td>Child 3</td>
								                <td>Child 3 details</td>
								            </tr>
								            <tr data-tt-id="5" data-tt-parent-id="4">
								                <td>Grandchild 1</td>
								                <td>Grandchild 1 details</td>
								            </tr>
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
	<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/jquery.treetable.js"></script>
    <script>
        $(document).ready(function() {
            $("#customers").treetable({
			    expandable: true,
			    initialState: "collapsed",  // Set initial state to collapsed
			    stringCollapse: "Collapse",
			    stringExpand: "Expand"
			});
        });

        fetch('/app/suksesi/menumaster/<?=$pg?>')
            .then(response => response.text())
            .then(data => {
                document.getElementById('left-content').innerHTML = data;
            })
            .catch(error => console.error('Terjadi kesalahan:', error));

	</script>
@endsection








		
