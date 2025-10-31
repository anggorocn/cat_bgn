<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.theme.default.css">
<?php
    $query=json_decode(json_encode($query), true);
    // print_r($query);exit;
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
                        <h3 class="card-label">Master Satuan Kerja</h3>
                    </div>
                </div>
                <div class="containerNew">
        			<div class="card-body">
						<table id="customers" class="" style="color:black; font-size: 14px;">
					        <thead>
					            <tr>
					                <th width="85%">Nilai</th>
					                <th>Aksi</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php for($i=0;$i<count($query);$i++){
					        		if($query[$i]['satker_id']=='0'){?>
							            <tr data-tt-id="<?=$query[$i]['satker_id']?>" class="branch">
							                <td colspan="2"><?=$query[$i]['nama']?></td>
							            </tr>
							        <?php } else{?>
							            <tr data-tt-id="<?=$query[$i]['satker_id']?>" data-tt-parent-id="<?=$query[$i]['satker_id_parent']?>">
							                <td><?=$query[$i]['nama']?></td>
							                <td>
							                	<?php if($query[$i]['total_child']!=0){?>
								                	<a class="btn btn-primary font-weight-bold mr-2" href="app/satuan_kerja/add/<?=$query[$i]['satker_id']?>"  ><i class="fa fa-plus" aria-hidden="true"></i></a>
								                <?php }?>
							                	<a class="btn btn-warning font-weight-bold mr-2" href="app/satuan_kerja/edit/<?=$query[$i]['satker_id']?>" ><i class="fa fa-edit" aria-hidden="true"></i></a>
							                	<a class="btn btn-danger font-weight-bold mr-2" onclick="deletedata(<?=$query[$i]['satker_id']?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
							                </td>
							            </tr>
					        		<?php
						        	} 
						        }?>
					        </tbody>
					    </table>
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
			    initialState: "expand",  // Set initial state to collapsed
			    stringCollapse: "Collapse",
			    stringExpand: "Expand"
			});
        });
        $("#customers").treetable("expandNode", "0000");

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
				urlAjax= "/SatuanKerja/delete/"+id;
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
									document.location.href = "app/satuan_kerja/index";
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








		
