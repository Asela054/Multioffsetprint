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
							<span>Machine Allocation</span>
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
									<label class="small font-weight-bold text-dark">PO Number*</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="inquiryid" id="inquiryid"
											required>
											<option value="">Select</option>
											<?php foreach ($inquiryinfo->result() as $rowInquiry) { ?>
											<option value="<?php echo $rowInquiry->idtbl_customerinquiry ?>">
												<?php echo $rowInquiry->po_number ?></option>
											<?php } ?>
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
												<th>Customer</th>
												<th>Po Number</th>
												<th>Job</th>
												<th>Qty</th>
												<th>Cost Item Name</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
                                        <tbody id = "machineAllocationTableBody">

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
<div class="modal fade" id="machineallocatemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Machine Allocation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="alert"></div>
			<div class="modal-body">
				<div class="row">
					<div class="col-4">
						<form action="" id="allocationform" autocomplete="off">
							<div class="form-row mb-1">
								<input type="hidden" class="form-control form-control-sm" name="costitemid"
									id="costitemid" required>
								<input type="hidden" class="form-control form-control-sm" name="hiddenselectjobid"
									id="hiddenselectjobid" required>
								<label class="small font-weight-bold text-dark">Machine*</label><br>
								<select class="form-control form-control-sm" style="width: 100%;" name="machine"
									id="machine" required>
									<option value="">Select</option>
									<?php foreach($machine->result() as $rowmachine){ ?>
									<option value="<?php echo $rowmachine->idtbl_machine ?>">
										<?php echo $rowmachine->machine.' - '.$rowmachine->machinecode ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold text-dark">Employee*</label><br>
								<select class="form-control form-control-sm" style="width: 100%;" name="employee"
									id="employee" required>
									<option value="">Select</option>
									<?php foreach($employee->result() as $rowemployee){ ?>
									<option value="<?php echo $rowemployee->idtbl_employee ?>">
										<?php echo $rowemployee->fullname.' - '.$rowemployee->empno ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold text-dark">Delivery Plan*</label>
								<div class="input-group input-group-sm">
									<select type="text" class="form-control dpd1a rounded-0" id="deliveryplan"
											name="deliveryplan" required>
										<option value="">Select</option>
                                    </select>
								</div>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold">Allocation Qty*</label>
								<input type="number" class="form-control form-control-sm" placeholder=""
									name="allocationqty" id="allocationqty" required>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold">Start Date*</label>
								<input type="datetime-local" class="form-control form-control-sm" placeholder=""
									name="startdate" id="startdate" required>
							</div>
							<div class="form-row mb-1">
								<label class="small font-weight-bold">End Date*</label>
								<input type="datetime-local" class="form-control form-control-sm" placeholder=""
									name="enddate" id="enddate" required>
							</div>
							<div class="form-group mt-3 px-2 text-right">
								<button type="button" name="BtnAddmachine" id="BtnAddmachine"
									class="btn btn-primary btn-m  fa-pull-right"><i
										class="fas fa-plus"></i>&nbsp;Add</button>
							</div>
							<button type="submit" id="allocationsubmit" class='d-none'>Submit</button>
						</form>
					</div>
					<div class="col-8">
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table" id="style-2">
									<table class="table table-bordered table-striped  nowrap display"
										id="tblmachinelist">
										<thead>
											<th class="d-none">Costing ID</th>
											<th>Machine</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Allocated Qty</th>
										</thead>
										<tbody id="tblmachinebody">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group mt-3 text-right">
							<button type="button" id="submitBtn2" class="btn btn-outline-primary btn-sm fa-pull-right"
								<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Allocate
								Machine</button>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-12 col-md-12">
						<div class="table" id="style-2">
							<table class="table table-bordered table-striped  nowrap display" id="tblallocationlist">
								<thead>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Cost Item</th>
									<th>Quantity</th>
								</thead>
								<tbody id="tblallocationlistbody">

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
	$("#tblmachinelist").on('click', '.btnDeleterow', function () {
		$(this).closest('tr').remove();
	});

	$(document).on("click", "#BtnAddmachine", function () {
		if (!$("#allocationform")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#allocationsubmit").click();
		} else {
			var machine = $('#machine').val();
			var machinelist = $("#machine option:selected").text();
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();
			var allocationqty = $('#allocationqty').val();

			$.ajax({
				type: "POST",
				data: {
					machineid: machine,
					startdate: startdate,
					enddate: enddate,
				},
				url: '<?php echo base_url() ?>Machinealloction/Checkmachineavailability',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					var html = '';

					if (obj.actiontype == 1) {
						html +=
							'<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Sorry!</strong> Machine is Not Available.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
						$('#alert').html(html);
					} else {
						
						$('#tblmachinelist> tbody:last').append('<tr><td class="text-center">' +
							machinelist + '</td><td class="d-none text-center">' + machine +
							'</td><td class="text-center">' + startdate +
							'</td><td class="text-center">' + enddate +
							'</td> <td class="text-center">' + allocationqty +
							'</td><td> <button type="button" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
						);
						$('#machine').val('');
						$('#startdate').val('');
						$('#enddate').val('');
					}

				}
			});


		}
	});

	$(document).on("click", "#submitBtn2", function () {

		var costitemid = $('#costitemid').val();
		var jobid = $('#hiddenselectjobid').val();
		var deliveryplan = $('#deliveryplan').val();
		var employee = $('#employee').val();

		// get table data into array
		var tbody = $('#tblmachinelist tbody');
		if (tbody.children().length > 0) {
			var jsonObj = []
			$("#tblmachinelist tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		//console.log(jsonObj);

		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				jobid: jobid,
				deliveryplan: deliveryplan,
				employee: employee,
				costitemid: costitemid
			},
			url: '<?php echo base_url() ?>Machinealloction/Machineinsertupdate',
			success: function (result) {
				//console.log(result);
				location.reload();
			}
		});

	});

	$('#machine').change(function () {
		var recordID = $(this).val()

		$.ajax({
            type: "POST",
            url: "<?php echo site_url('Machinealloction/FetchAllocationData'); ?>",
            data: {
                recordID: recordID
            },
            success: function (result) {
                $('#tblallocationlist> tbody:last').empty().append(result);
            }
        });
	})

	$('#inquiryid').change(function () {
        let recordId = $('#inquiryid :selected').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Machinealloction/GetInquieryDetails'); ?>",
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
            url: "<?php echo site_url('Machinealloction/FetchItemDataForAllocation'); ?>",
            success: function (result) {
                $('#machineAllocationTable> tbody:last').empty().append(result);
            }
        });

		$.ajax({
            type: "POST",
            url: "<?php echo site_url('Machinealloction/GetDeliveryPlanDetails'); ?>",
            data: {
                recordId: recordId
            },
            success: function (result) {
                var obj = JSON.parse(result);

                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function (i, item) {
                    // alert(result[i].id);
                    html1 += '<option value="' + obj[i].idtbl_delivery_plan_details + '">';
                    html1 += 'Id: ' + obj[i].special_id + ' /Date: ' + obj[i].deliveryDate + ' /Qty: ' + obj[i].qty;
                    html1 += '</option>';
                });
                $('#deliveryplan').empty().append(html1);
            }
        });
	})


	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		// $('#machineAllocationTable').DataTable({
		// 	"destroy": true,
		// 	"processing": true,
		// 	"serverSide": true,
		// 	dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
		// 		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
		// 	responsive: true,
		// 	lengthMenu: [
		// 		[10, 25, 50, -1],
		// 		[10, 25, 50, 'All'],
		// 	],
		// 	"buttons": [{
		// 			extend: 'csv',
		// 			className: 'btn btn-success btn-sm',
		// 			title: 'Production View Information',
		// 			text: '<i class="fas fa-file-csv mr-2"></i> CSV',
		// 		},
		// 		{
		// 			extend: 'pdf',
		// 			className: 'btn btn-danger btn-sm',
		// 			title: 'Production View Information',
		// 			text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
		// 		},
		// 		{
		// 			extend: 'print',
		// 			title: 'Production View Information',
		// 			className: 'btn btn-primary btn-sm',
		// 			text: '<i class="fas fa-print mr-2"></i> Print',
		// 			customize: function (win) {
		// 				$(win.document.body).find('table')
		// 					.addClass('compact')
		// 					.css('font-size', 'inherit');
		// 			},
		// 		},
		// 		// 'copy', 'csv', 'excel', 'pdf', 'print'
		// 	],
		// 	ajax: {
		// 		url: "<?php echo base_url() ?>scripts/machineallocationlist.php",
		// 		type: "POST", // you can use GET
		// 		// data: function(d) {}
		// 	},
		// 	"order": [
		// 		[0, "desc"]
		// 	],
		// 	"columns": [{
		// 			"data": "idtbl_customerinquiry"
		// 		},
		// 		{
		// 			"data": "name"
		// 		},
		// 		{
		// 			"data": "po_number"
		// 		},
		// 		{
		// 			"data": "job"
		// 		},
		// 		{
		// 			"data": "qty"
		// 		},
		// 		{
		// 			"data": "costitemname"
		// 		},
		// 		{
		// 			"targets": -1,
		// 			"className": 'text-right',
		// 			"data": null,
		// 			"render": function (data, type, full) {
		// 				var button = '';
		// 				button += '<button class="btn btn-dark btn-sm btnAdd mr-1" id="' + full[
		// 					'idtbl_cost_items'] + '"><i class="fas fa-tools"></i></button>';
		// 				return button;
		// 			}
		// 		}
		// 	],
		// 	drawCallback: function (settings) {
		// 		$('[data-toggle="tooltip"]').tooltip();
		// 	}
		// });

		$('#machineAllocationTable tbody').on('click', '.btnAdd', function () {
			var costItemId = $(this).attr('id');
			var jobId = $('#selectedjob').val();
			$('#costitemid').val(costItemId);
			$('#hiddenselectjobid').val(jobId);
			$('#machineallocatemodal').modal('show');
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
</script>
<?php include "include/footer.php"; ?>
