<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">

	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; ?>
	</div>
	<div id="layoutSidenav_content">
		<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<h1 class="page-header-title font-weight-light">
							<div class="page-header-icon"><i class="fa fa-shopping-bag"></i></div>
							<span><b>Service Order Inquiry</b></span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<form id="addserviceform" action="<?php echo base_url() ?>Serviceorder/Serviceorderinsertupdate"
							method="post" autocomplete="off" enctype="multipart/form-data">


							<div class="row">
								<div class="col-4">
									<div class="form-group">
										<label class="small font-weight-bold">Vehicle Reg NO*</label>
										<select class="form-control form-control-sm" name="vehicleregno"
											id="vehicleregno" required>
											<option value="">Select</option>
											<?php foreach ($VehicleRegNo->result() as $rowvehicleregno) { ?>
											<option value="<?php echo $rowvehicleregno->idtbl_vehicle ?>">
												<?php echo $rowvehicleregno->vehicle_reg_no ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label class="small font-weight-bold">Supplier*</label>
										<select class="form-control form-control-sm" name="supplier" id="supplier"
											required>
											<option value="">Select</option>
											<?php foreach ($Supplier->result() as $rowsupplier) { ?>
											<option value="<?php echo $rowsupplier->idtbl_supplier ?>">
												<?php echo $rowsupplier->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>


								<div class="col-4">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Comments :</label>
										<input type="text" name="comment" class="form-control form-control-sm"
											id="comment" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<div class="form-group mt-2 text-right" style="padding-top: 5px;">
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-5"
											<?php if($addcheck==0){echo 'disabled';} ?>><i
												class="far fa-save"></i>&nbsp;Add</button>
									</div>
								</div>
							</div>

							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
						</form>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblserviceorder">
										<thead>
											<tr>
												<th>#</th>
												<th>Vehicle Reg NO</th>
												<th>Supplier</th>
												<th>Comment</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		$('#tblserviceorder').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			responsive: true,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			"buttons": [{
					extend: 'csv',
					className: 'btn btn-success btn-sm',
					title: 'Service Order Inquiry Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Service Order Inquiry Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Service Order Inquiry Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function (win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'copy', 'csv', 'excel', 'pdf', 'print'
			],

			ajax: {
				url: "<?php echo base_url() ?>scripts/serviceorderlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_service_order"
				},
				{
					"data": "vehicle_reg_no"
				},
				{
					"data": "name"
				},
				{
					"data": "comment"
				},

				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';

						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_service_order'] +
							'"><i class="fas fa-pen"></i></button>';
						button +=
							'<a href="<?php echo base_url() ?>Serviceorder/Serviceorderstatusapprove/' +
							full['idtbl_service_order'] +
							'" onclick="return approve_confirm()" target="_self" class="btn btn-outline-info btn-sm mr-1 ';
						if (statuscheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-exclamation-triangle"></i></a>';
						if (full['status'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>Serviceorder/Serviceorderstatus/' +
								full['idtbl_service_order'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Serviceorder/Serviceorderstatus/' +
								full['idtbl_service_order'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button +=
							'<a href="<?php echo base_url() ?>Serviceorder/Serviceorderstatus/' +
							full['idtbl_service_order'] +
							'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
						if (deletecheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-trash-alt"></i></a>';

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			},


		});

		$('#tblserviceorder tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Serviceorder/Serviceorderedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#comment').val(obj.comment);
						$('#vehicleregno').val(obj.vehicleregno);
						$('#supplier').val(obj.supplier);
						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});




	});

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}
	function approve_confirm() {
		return confirm("Are you sure you want to Approve this?");
	}
</script>
<?php include "include/footer.php"; ?>