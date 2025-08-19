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
							<div class="page-header-icon"><i data-feather="users"></i></div>
							<span>Internal Use</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-5">
								<form action="<?php echo base_url() ?>InternalUse/InternalUseinsertupdate" method="post"
									autocomplete="off">
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Product</label>
											<select class="form-control form-control-sm" name="product" id="product"
												required>
												<option value="">Select</option>
												<?php foreach($productlist->result() as $rowproductlist){ ?>
												<option value="<?php echo $rowproductlist->idtbl_material_info ?>">
													<?php echo $rowproductlist->materialname?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Quantity</label>
											<input type="text" class="form-control form-control-sm" name="qty" id="qty">
										</div>
									</div>

									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Available Stock</label>
											<input type="text" class="form-control form-control-sm"
												name="availablestock" id="availablestock" readonly>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Reason</label>
											<textarea type="text" class="form-control form-control-sm" name="reason"
												id="reason"></textarea>
										</div>

									</div>
									<div class="form-group mt-2 text-right">
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>><i
												class="far fa-save"></i>&nbsp;Add</button>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</form>
							</div>
							<div class="col-7">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="employeedataTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Product</th>
												<th>Quantity</th>
												<th>Reason</th>
												<!-- <th class="text-right">Actions</th> -->
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

		$('#employeedataTable').DataTable({
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
					title: 'Employee Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Employee Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Employee Information',
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
				url: "<?php echo base_url() ?>scripts/internaluselist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_internal_use"
				},
				{
					"data": "materialname"
				},
				{
					"data": "qty"
				},
				{
					"data": "reason"
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#product').change(function () {
			var id = $(this).val()

			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>InternalUse/FetchAvailableStock',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					$('#availablestock').val(obj.quantity);
				}
			});
		})
		// $('#employeedataTable tbody').on('click', '.btnEdit', function () {
		// 	var r = confirm("Are you sure, You want to Edit this ? ");
		// 	if (r == true) {
		// 		var id = $(this).attr('id');
		// 		$.ajax({
		// 			type: "POST",
		// 			data: {
		// 				recordID: id
		// 			},
		// 			url: '<?php echo base_url() ?>Employee/Employeeedit',
		// 			success: function (result) { //alert(result);
		// 				var obj = JSON.parse(result);
		// 				$('#recordID').val(obj.id);
		// 				$('#title').val(obj.title);
		// 				$('#fname').val(obj.fname);
		// 				$('#mname').val(obj.mname);
		// 				$('#lname').val(obj.lname);
		// 				$('#empno').val(obj.empno);
		// 				$('#joindate').val(obj.joindate);
		// 				$('#designation').val(obj.designation);
		// 				$('#contact').val(obj.contact);
		// 				$('#contact2').val(obj.contact2);
		// 				$('#email').val(obj.email);
		// 				$('#address').val(obj.address);

		// 				$('#recordOption').val('2');
		// 				$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
		// 			}
		// 		});
		// 	}
		// });
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
</script>
<?php include "include/footer.php"; ?>
