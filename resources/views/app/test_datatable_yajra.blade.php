	@php
	$arrdata= array(
		array("label"=>"Users Id", "field"=> "NIP_BARU", "display"=>"",  "width"=>"")
		, array("label"=>"Nama", "field"=> "NAMA_PEGAWAI", "display"=>"",  "width"=>"")
		
		// untuk dua ini kunci, data akhir id, data sebelum akhir untuk order

	);
	@endphp
	@extends('app/index') 
	@section('content')
	<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">Server-side processing Examples</h5>
					<!--end::Page Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Crud</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Datatables.net</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Data sources</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Ajax Server-side</a>
						</li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page Heading-->
			</div>
			<div class="d-flex align-items-center">
				<a href="#" class="btn btn-light-primary font-weight-bolder btn-sm">Actions</a>
				<div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
					<a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="svg-icon svg-icon-success svg-icon-2x">
							
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0">
						<ul class="navi navi-hover">
							<li class="navi-header font-weight-bold py-4">
								<span class="font-size-lg">Choose Label:</span>
								<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
							</li>
							<li class="navi-separator mb-3 opacity-70"></li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-text">
										<span class="label label-xl label-inline label-light-success">Customer</span>
									</span>
								</a>
							</li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-text">
										<span class="label label-xl label-inline label-light-danger">Partner</span>
									</span>
								</a>
							</li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-text">
										<span class="label label-xl label-inline label-light-warning">Suplier</span>
									</span>
								</a>
							</li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-text">
										<span class="label label-xl label-inline label-light-primary">Member</span>
									</span>
								</a>
							</li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-text">
										<span class="label label-xl label-inline label-light-dark">Staff</span>
									</span>
								</a>
							</li>
							<li class="navi-separator mt-3 opacity-70"></li>
							<li class="navi-footer py-4">
								<a class="btn btn-clean font-weight-bold btn-sm" href="#">
									<i class="ki ki-plus icon-sm"></i>Add new</a>
								</li>
							</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-supermarket text-primary"></i>
						</span>
						<h3 class="card-label">Ajax Sourced Server-side Processing</h3>
					</div>
					<div class="card-toolbar">
						<div class="dropdown dropdown-inline mr-2">
							<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="svg-icon svg-icon-md">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
											<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
										</g>
									</svg>
								</span>Export</button>
								<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
									<ul class="navi flex-column navi-hover py-2">
										<li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
										<li class="navi-item">
											<a href="#" class="navi-link">
												<span class="navi-icon">
													<i class="la la-print"></i>
												</span>
												<span class="navi-text">Print</span>
											</a>
										</li>
										<li class="navi-item">
											<a href="#" class="navi-link">
												<span class="navi-icon">
													<i class="la la-copy"></i>
												</span>
												<span class="navi-text">Copy</span>
											</a>
										</li>
										<li class="navi-item">
											<a href="#" class="navi-link">
												<span class="navi-icon">
													<i class="la la-file-excel-o"></i>
												</span>
												<span class="navi-text">Excel</span>
											</a>
										</li>
										<li class="navi-item">
											<a href="#" class="navi-link">
												<span class="navi-icon">
													<i class="la la-file-text-o"></i>
												</span>
												<span class="navi-text">CSV</span>
											</a>
										</li>
										<li class="navi-item">
											<a href="#" class="navi-link">
												<span class="navi-icon">
													<i class="la la-file-pdf-o"></i>
												</span>
												<span class="navi-text">PDF</span>
											</a>
										</li>
									</ul>
								</div>
						</div>
						<a href="#" class="btn btn-primary font-weight-bolder">
							<span class="svg-icon svg-icon-md">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<circle fill="#000000" cx="9" cy="15" r="6" />
										<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
									</g>
								</svg>
							</span>Tambah
						</a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
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

<script type="text/javascript">


$(document).ready(function () {
	// console.log(1);
   $('#kt_datatable').DataTable({
        processing: true,
        serverSide: true,
     	type: 'POST',
        ajax: "/TestDatatable/json/"
        , columns: [
            { data: 'users_id', name: 'users_id' },
            { data: 'nama', name: 'nama' }
        ]
    });
 });

	
</script>
@endsection








		
