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
							<span>Allocated Machines</span>
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
									<label class="small font-weight-bold text-dark">Machines*</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="machines" id="machines"
											required>
											<option value="">Select</option>
											<?php foreach ($machineList->result() as $rowInquiry) { ?>
											<option value="<?php echo $rowInquiry->idtbl_machine ?>">
												<?php echo $rowInquiry->machine ?></option>
											<?php } ?>
										</select>
									</div>
									<input type="hidden" id="hiddenmachinevalue">
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
												<th>Customer</th>
												<th>Employee</th>
												<th>Po Number</th>
												<th>Job</th>
												<th>Cost Item</th>
												<th>Start</th>
												<th>End</th>
												<th>Hours</th>
												<th>Actions</th>
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
	<!-- QA Issues Modal-->
	<div class="modal fade" id="QaIssues" tabindex="-1" role="dialog" aria-labelledby="QaIssuesLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form id="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="QaIssuesLabel">Confirmation</h5>&nbsp;
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row mb-3">
							<div class="col-4">
								<label class="small font-weight-bold text-dark">Issue Category*</label>
								<select class="form-control form-control-sm" name="qaissuecategory" id="qaissuecategory" required>
									<option value="">Select</option>
									<?php foreach ($issuecategorylist->result() as $rowInquiry) { ?>
									<option value="<?php echo $rowInquiry->idtbl_machine_issue_category ?>">
										<?php echo $rowInquiry->type ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-8">
								<label class="small font-weight-bold text-dark">Please enter a QA issue*</label>
								<textarea class="form-control" id="qaissuefield" rows="3"></textarea>
							</div>

						</div>
						<div class="row">
							<table class="table table-bordered table-striped table-sm nowrap" id="qaIssuesTable">
								<thead>
									<tr>
										<th>#</th>
										<th>Category</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody id="qaIssuesTableBody">
								</tbody>
							</table>
						</div>

						<input type="hidden" id="hiddenallocationvalue">
					</div>
					<div class="modal-footer">
						<button type="button" id="btnqa" class="btn btn-primary" required="required">Enter</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- QA Issues Modal-->

	<!-- Hour details Modal-->
	<div class="modal fade modal" id="HourDetails" tabindex="-1" role="dialog" aria-labelledby="HourDetailsLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form id="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="HourDetailsLabel">Hourly Details</h5>&nbsp;
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<form method="post" autocomplete="off" id="hourdetailsform">
									<label class="small font-weight-bold text-dark">Hour*</label>
									<div class="form-row mb-1">
										<select class="form-control form-control-sm" name="hourlist" id="hourlist"
											required>
											<option value="">Select</option>
										</select>
									</div>
									<div class="form-row mb-1">
										<label class="small font-weight-bold">Finished quantity*</label>
										<input type="text" class="form-control form-control-sm" placeholder=""
											name="finishedquantity" id="finishedquantity" required>
									</div>
									<div class="form-row mb-1">
										<label class="small font-weight-bold">Wastage quantity*</label>
										<input type="text" class="form-control form-control-sm" placeholder=""
											name="wastagequantity" id="wastagequantity" required>
									</div>
									<div class="form-group mt-2">
										<button type="button" name="BtnAdd" id="BtnAdd"
											class="btn btn-primary btn-sm "><i
												class="fas fa-plus"></i>&nbsp;Add</button>
										<input type="submit" class="d-none" id="hidebtnaddlist">
									</div>
								</form>
							</div>
							<div class="col-8">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="machineHourDetails">
										<thead>
											<tr>
												<th>Hour</th>
												<th>Finished Qty</th>
												<th>Wastage Qty</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody id="machineHourDetailsBody">
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<input type="hidden" id="hiddenallocationvaluehourdetails">
					</div>
					<div class="modal-footer">
						<button type="button" id="btndetailssubmit" class="btn btn-primary"
							required="required">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Hour details Modal-->
</div>


<?php include "include/footerscripts.php"; ?>
<script>
	$('#machines').change(function () {
		var recordID = $(this).val()
		$('#hiddenmachinevalue').val(recordID)
		fetchMachineValueData(recordID)

	})

	$('#machineAllocationTable tbody').on('click', '.btnStartAllocation', function () {
		var r = confirm("Are you sure, You want to start this process");
		if (r == true) {
			var id = $(this).attr('id');
			machineId = $('#hiddenmachinevalue').val()
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>AllocatedMachines/StartAllocation',
				success: function (result) {
					fetchMachineValueData(machineId)
				}
			});
		}
	});

	$('#machineAllocationTable tbody').on('click', '.btnBreakDown', function () {
		var r = confirm("Are you sure, This machine is broken");
		if (r == true) {
			var id = $(this).attr('id');
			machineId = $('#hiddenmachinevalue').val()
			$.ajax({
				type: "POST",
				data: {
					recordID: id,
					machineId: machineId
				},
				url: '<?php echo base_url() ?>AllocatedMachines/MachineBreakDown',
				success: function (result) {
					console.log(result)
					fetchMachineValueData(machineId)
				}
			});
		}
	});
	$('#machineAllocationTable tbody').on('click', '.btnComplete', function () {
		var r = confirm("Are you sure, This allocation is completed");
		if (r == true) {
			var id = $(this).attr('id');
			machineId = $('#hiddenmachinevalue').val()
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>AllocatedMachines/AllocationComplete',
				success: function (result) {
					fetchMachineValueData(machineId)
				}
			});
		}
	});

	$('#machineAllocationTable tbody').on('click', '.btnQaIssues', function () {
		var id = $(this).attr('id');
		fetchallocatedqaissuedata(id)
		$('#hiddenallocationvalue').val(id)
		$('#QaIssues').modal('show');

	});

	$('#machineAllocationTable tbody').on('click', '.btnFixBreakDown', function () {
		var r = confirm("Are you sure, That you want to start this machine again");
		if (r == true) {
			var id = $(this).attr('id');
			machineId = $('#hiddenmachinevalue').val()
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>AllocatedMachines/StartBrokeDownMachine',
				success: function (result) {
					fetchMachineValueData(machineId)
				}
			});
		}
	});

	$('#btnqa').click(function () {
		qaissue = $('#qaissuefield').val()
		qaissuecategory = $('#qaissuecategory').val()
		allocationval = $('#hiddenallocationvalue').val()
		$.ajax({
			type: "POST",
			data: {
				qaissue: qaissue,
				allocationval: allocationval,
				qaissuecategory: qaissuecategory
			},
			url: '<?php echo base_url() ?>AllocatedMachines/EnterQaIssues',
			success: function (result) {
				$('#qaissuecategory').val('')
				$('#qaissuefield').val('')
				fetchallocatedqaissuedata(allocationval)
			}
		});
	})

	$('#BtnAdd').click(function () {
		// if (!$("#hourdetailsform")[0].checkValidity()) {
		// 	// If the form is invalid, submit it. The form won't actually submit;
		// 	// this will just cause the browser to display the native HTML5 error messages.
		// 	$("#hidebtnaddlist").click();
		// 	// alert('in');
		// } else {
		allocationval = $('#hiddenallocationvaluehourdetails').val()
		hourlistval = $('#hourlist').val()
		finishedquantity = $('#finishedquantity').val()
		wastagequantity = $('#wastagequantity').val()

		$('#machineHourDetails> tbody:last').append('<tr><td class = "d-none">' + allocationval +
			'</td><td class="text-center">' + hourlistval +
			'</td><td class="text-center">' + finishedquantity + '</td><td class="text-center">' +
			wastagequantity +
			'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
		);

		$('#hourlist').val('')
		$('#finishedquantity').val('')
		$('#wastagequantity').val('')
		// }
	})
	$('#btndetailssubmit').click(function () {
		var tbody = $('#machineHourDetails tbody');
		if (tbody.children().length > 0) {
			var jsonObj = []
			$("#machineHourDetails tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		var allocationval = $('#hiddenallocationvaluehourdetails').val()
		console.log(jsonObj)
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('AllocatedMachines/EnterHourlyDetails'); ?>",
			data: {
				allocationval: allocationval,
				tableData: jsonObj
			},
			success: function (result) {
				// console.log(result)
				location.reload()
			}
		});
	})

	$('#machineAllocationTable tbody').on('click', '.btnDetails', function () {
		var id = $(this).attr('id');
		$('#hiddenallocationvaluehourdetails').val(id)
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('AllocatedMachines/GetHourlyListData'); ?>",
			data: {
				recordId: id
			},
			success: function (result) {
				$('#machineHourDetails> tbody:last').empty().append(result);
			}
		});


		$.ajax({
			type: "POST",
			data: {
				recordId: id
			},
			url: '<?php echo base_url() ?>AllocatedMachines/GetAllocationHours',
			success: function (result) {
				$('#HourDetails').modal('show');

				var obj = JSON.parse(result);

				var html1 = '';
				html1 += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					// alert(result[i].id);
					html1 += '<option value="' + obj[i] + ' - ' + obj[i + 1] + '">';
					html1 += obj[i] + ' - ' + obj[i + 1];
					html1 += '</option>';
				});
				$('#hourlist').empty().append(html1);

			}
		});

	})
	$('#qaIssuesTable tbody').on('click', '.btnAllocatedIssue', function () {
		var id = $(this).attr('id');
		var allocationId = $('#hiddenallocationvalue').val()
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('AllocatedMachines/RemoveQaAllocatedIssue'); ?>",
			data: {
				recordId: id
			},
			success: function (result) {
				console.log(result)
				fetchallocatedqaissuedata(allocationId)
			}
		});
	})

	function fetchMachineValueData(recordID) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('AllocatedMachines/GetAllocationData'); ?>",
			data: {
				recordId: recordID
			},
			success: function (result) {
				$('#machineAllocationTable> tbody:last').empty().append(result);
			}
		});
	}
	function fetchallocatedqaissuedata(recordID) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('AllocatedMachines/GetQaIssueData'); ?>",
			data: {
				recordId: recordID
			},
			success: function (result) {
				$('#qaIssuesTable> tbody:last').empty().append(result);
			}
		});
	}

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}

	function productDelete(ctl) {
		$(ctl).parents("tr").remove();
	}
</script>
<?php include "include/footer.php"; ?>
