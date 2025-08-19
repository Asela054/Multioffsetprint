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
							<div class="page-header-icon"><i class="fas fa-list"></i></div>
							<span>Job Summary Report</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<form id="searchform">
							<div class="form-row">
								<div class="col-3">
									<label class="small font-weight-bold text-dark">Customers*</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="customer" id="customer"
											required>
											<option value="">Select</option>
											<?php foreach ($customerlist->result() as $rowcustomer) { ?>
											<option value="<?php echo $rowcustomer->idtbl_customer ?>">
												<?php echo $rowcustomer->customer ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<label class="small font-weight-bold text-dark">PO Number*</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="inquiryid" id="inquiryid"
											required>
											<option value="">Select</option>

										</select>
									</div>
								</div>
								<div class="col-3">
									<label class="small font-weight-bold text-dark">Jobs*</label>
									<div class="input-group input-group-sm mb-3">
										<select type="text" class="form-control dpd1a rounded-0" id="selectedjob"
											name="selectedjob" required>
											<option value="">Select</option>

										</select>
									</div>
								</div>
							</div>
							<input type="submit" class="d-none" id="hidesubmit">
						</form>
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="machineAllocationTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Job</th>
												<th>Qty</th>
												<th>Cost Item Name</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody id="machineAllocationTableBody">

										</tbody>
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
<!-- Modal -->
<div class="modal fade" id="jobsummarymodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Summary deliveries and Allocations</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="alert"></div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<h4>Delivery Plans</h4>
						<input type="hidden" class="form-control form-control-sm" name="costitemid" id="costitemid"
							required>
						<input type="hidden" class="form-control form-control-sm" name="hiddenselectjobid"
							id="hiddenselectjobid" required>
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table" id="style-2">

									<table class="table table-bordered table-striped  nowrap display"
										id="tbldeliveryplanlist">
										<thead>
											<th>#</th>
											<th>Delivery ID</th>
											<th>Delivery Date</th>
											<th>Quantity</th>
											<th>Status</th>
										</thead>
										<tbody id="tbldeliveryplanlistbody">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-12 col-md-12">
						<h4>Allocations</h4>
						<div class="table mt-2" id="style-2">
							<table class="table table-bordered table-striped  nowrap display" id="tblmachinelist">
								<thead>
									<th class="d-none">Costing ID</th>
									<th>#</th>
									<th>Machine</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Complete Qty</th>
									<th>Wastage Qty</th>
									<th>Wastage Price</th>
								</thead>
								<tbody id="tblmachinebody">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';
		
		$('#machineAllocationTable tbody').on('click', '.btnAdd', function () {
			var costItemId = $(this).attr('id');
			var jobId = $('#selectedjob').val();
			$('#costitemid').val(costItemId);
			$('#hiddenselectjobid').val(jobId);
			$.ajax({
				type: "POST",
				data: {
					costItemId: costItemId,
					jobId: jobId
				},
				url: "<?php echo site_url('JobSummaryReport/FetchDeliveryPlanData'); ?>",
				success: function (result) {
					$('#tbldeliveryplanlist> tbody:last').empty().append(result);
				}
			});
			$.ajax({
				type: "POST",
				data: {
					costItemId: costItemId,
					jobId: jobId
				},
				url: "<?php echo site_url('JobSummaryReport/FetchAllocationData'); ?>",
				success: function (result) {
					$('#tblmachinelist> tbody:last').empty().append(result);
					$('#jobsummarymodal').modal('show');
				}
			});
		});
	});

	$('#customer').change(function () {
		let recordId = $('#customer :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('JobSummaryReport/GetJobsAccoCustomer'); ?>",
			data: {
				recordId: recordId
			},
			success: function (result) {
				var obj = JSON.parse(result);

				var html1 = '';
				html1 += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					// alert(result[i].id);
					html1 += '<option value="' + obj[i].idtbl_customerinquiry + '">';
					html1 += obj[i].po_number;
					html1 += '</option>';
				});
				$('#inquiryid').empty().append(html1);
			}
		});
	})
	$('#inquiryid').change(function () {
		let recordId = $('#inquiryid :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('JobSummaryReport/GetInquieryDetails'); ?>",
			data: {
				recordId: recordId
			},
			success: function (result) {
				var obj = JSON.parse(result);

				var html1 = '';
				html1 += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					// alert(result[i].id);
					html1 += '<option value="' + obj[i].idtbl_customerinquiry_detail + '">';
					html1 += obj[i].job;
					html1 += '</option>';
				});
				$('#selectedjob').empty().append(html1);
			}
		});
	})
	$('#selectedjob').change(function () {
		let recordId = $('#selectedjob :selected').val();
		$.ajax({
			type: "POST",
			data: {
				recordId: recordId
			},
			url: "<?php echo site_url('JobSummaryReport/FetchItemDataForAllocation'); ?>",
			success: function (result) {
				$('#machineAllocationTable> tbody:last').empty().append(result);
			}
		});

	})




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
