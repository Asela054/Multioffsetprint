<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<style>
@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }
}

#approve:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    background-color: #4CAF50;
    color: #fff;
}
</style>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; ?>
	</div>
	<div id="layoutSidenav_content">
		<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i class="fas fa-industry"></i></div>
							<span>Dispatch Note</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-3">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
								<form id="createorderform" autocomplete="off">
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold text-dark">Date*</label>
											<input type="date" class="form-control form-control-sm" placeholder="" name="date"
												id="date" value="<?php echo date('Y-m-d') ?>" required>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Job*</label>
											<select class="form-control form-control-sm selecter2 px-0" name="job" id="job" required>
                                                <option value="">Select</option>
                                            </select>
										</div>

									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold text-dark">Customer*</label>
											<select id="customer" name="customer" class="form-control form-control-sm" required readonly>
												<option value="">Select Customer</option>
											</select>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Job No*</label>
											<input type="text" id="job_no" name="job_no" class="form-control form-control-sm"
												required readonly>
										</div>
									</div>

									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold text-dark">Customer
												Inquiry*</label>
											<input type="text" id="customerinqury" name="customerinqury"
												class="form-control form-control-sm" required readonly>
											<input type="hidden" id="customerinquryid" name="customerinquryid"
												class="form-control form-control-sm" required readonly>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">PO Num*</label>
											<input type="text" id="ponum" name="ponum" class="form-control form-control-sm"
												required readonly>
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold text-dark">Qty*</label>
											<label class="small font-weight-bold text-danger" id="qtylabel"></label>
											<input type="number" id="newqty" name="newqty" class="form-control form-control-sm"
												required>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">UOM*</label>
											<select id="uom" name="uom" class="form-control form-control-sm" required readonly>
												<option value="">Select UOM</option>
											</select>
										</div>
									</div>

									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark" style="display: none;">unit
											Price*</label>
										<input type="number" id="unitprice" name="unitprice" class="form-control form-control-sm"
											value="0" step="any" style="display: none;">
									</div>

									<input type="hidden" id="inquerydetailsid" name="inquerydetailsid"
										class="form-control form-control-sm" />

									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Comment</label>
										<textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
									</div>
									<div class="form-group mt-3 text-right">
										<button type="button" id="formsubmit" class="btn btn-warning font-weight-bold btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to
											list</button>
										<input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
									</div>
									<input type="hidden" name="refillprice" id="refillprice" value="">
									<input type="hidden" name="totalprice" id="totalprice" value="0">
								</form>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
								<div id="materialmachinetblpart">
									<table class="table table-striped table-bordered table-sm small" id="tableorder">
										<thead>
											<tr>
												<th>Job</th>
												<th class="d-none">ProductID</th>
												<th class="text-center">Job No</th>
												<th class="text-center">Comment</th>
												<th class="text-center">Qty</th>
												<th class="text-center">UOM</th>
												<th class="text-right">Action</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>

								<hr>
								<div class="form-group">
									<label class="small font-weight-bold text-dark">Remark</label>
									<textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
								</div>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="finishInquiryCheckbox"
											id="finishInquiryCheckbox" value="1">
										<label class="custom-control-label small font-weight-bold text-dark"
											for="finishInquiryCheckbox">Finish this Job</label>
									</div>
								</div>

								<div class="form-group mt-2">
									<button type="button" id="btncreateorder"
										class="btn btn-primary btn-sm fa-pull-right"><i
											class="fas fa-save"></i>&nbsp;Create Dispatch Note</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid mt-2 p-0">
					<div class="card">
						<div class="card-body p-0 p-3">
							<div class="row">
								<div class="col-12">
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
											<thead>
												<tr>
													<th>Dispatch Number</th>
													<th>Date</th>
													<th>Customer Name</th>
													<th>PO Num</th>
													<th>Job</th>
													<th>Job Number</th>
													<th>Status</th>
													<th>Invoice Status</th>
													<th>Check By</th>
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
			</div>
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<!-- Modal -->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">View Dispatch Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
						<div class="col-6">
							<p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliername"></span>
							</P>
							<p style="margin-bottom: 2px;" class="text-left"><span
									id="pordersuppliercontact"></span>
							</p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress1"></span>
							</p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress2"></span>
							</p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="pordercity"></span></p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="porderstate"></span></p>
						</div>
                        <div class="col-6">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-right" class="text-right">Dispatch Note<span id="pr"></span>
                            </h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="viewcompanyname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"> <span id="viewbranchname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="viewdispatch_no"></span>
                            </P>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="porderdate"></span></p>
                        </div>
                    </div>
                    <div id="viewhtml"></div>
					<div class="col-12 text-right">
                        <hr>
						<?php if($approvecheck==1){ ?>
                        <button id="btnapprovereject" class="btn btn-primary btn-sm px-3 mb-2"><i class="fas fa-check mr-2"></i>Approve or Reject</button>
						<?php } ?>
                        <input type="hidden" name="dispatchid" id="dispatchid">
						<input type="hidden" name="inq_id" id="inq_id">
						<?php if($checkstatus==1){ ?>
						<button id="btncheck" class="btn btn-info btn-sm px-3 mb-2"><i class="fas fa-user-check mr-2"></i>Check By</button>
						<?php } ?>
                    </div>
                    <div class="col-12 text-center">
                        <div id="alertdiv"></div>
                    </div>
					<div class="col-12 text-center">
						<div id="checkalertdiv"></div>
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

	$('#job').select2({
        width: '100%',
    });

	$('#printporder').click(function () {

		printJS({
			printable: 'purchaseview',
			type: 'html',
			css: 'assets/css/styles.css',
			header: 'Purchase Order Request',
			onPrintSuccess: function () {
				var printButton = document.getElementById('printporder');
				printButton.style.display = 'none';
			}
		});
	});

	$("#job").select2({
        ajax: {
            url: "<?php echo base_url() ?>Dispatchnote/Getjoblist",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

	$('#dataTable').DataTable({
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
				title: 'Dispatch Note Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Dispatch Note Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Dispatch Note Information',
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
			url: "<?php echo base_url() ?>scripts/dispatchlist.php",
			type: "POST", // you can use GET
            "data": function (d) {
                return $.extend({}, d, {
                    "company_id": '<?php echo ($_SESSION['company_id']); ?>',
                });
            }
		},
		"order": [
			[0, "desc"]
		],
		"columns": [{
				"data": "dispatch_no"
			},
			{
				"data": "date"
			},
			{
				"data": "customer"
			},
			{
				"data": "ponum"
			},
			{
				"data": "job"
			},
			{
				"data": "job_no"
			},
			{
                "targets": -1,
                "className": '',
                "data": "approvestatus_display",
                "render": function(data, type, row) {
                    return data;
                }
            },
			{
				"data": "invoice_status",
				"render": function(data, type, row) {
					if (data == 0) {
						return '<i class=\"fa fa-spinner text-warning mr-2\"></i>Invoice not issued';
					} else if (data == 1) {
						return '<i class=\"fas fa-check text-success mr-2\"></i>Invoice issued';
					}
					return data;
				}
			},
			{
				"data": "name"
			},
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function (data, type, full) {
					var button = '';
					button += '<a href="<?php echo base_url() ?>Dispatchnote/pdfget/' + full[
							'idtbl_print_dispatch'] +
						'" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print Dispatch" class="btn btn-secondary btn-sm btnPdf mr-1 id="' +
						full['idtbl_print_dispatch'] +
						'"><i class="fas fa-file-pdf"></i></a>';
					if (full['status'] == 1) {
						button += '<button data-toggle="tooltip" data-placement="bottom" title="View Dispatch" class="btn btn-dark btn-sm btnview mr-1" id="' +
							full[
								'idtbl_print_dispatch'] + '" inq_id="' +
							full[
								'tbl_customerinquiry_idtbl_customerinquiry'] + '" aproval_id="' + full[
								'approvestatus'] + '" check_status="' + full[
                            'check_by'] + '"><i class="fas fa-eye"></i></button>';
					}
					if (full['approvestatus'] == 0) {
						button +=
							'<a href="<?php echo base_url() ?>Dispatchnote/Dispatchnotestatus/' +
							full['idtbl_print_dispatch'] +
							'/3/' + full['tbl_customerinquiry_idtbl_customerinquiry'] +
							'" onclick="return delete_confirm()" target="_self" data-toggle="tooltip" data-placement="bottom" title="Delete" class="btn btn-danger btn-sm mr-1 ';
						if (statuscheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-trash-alt"></i></a>';
					}
					return button;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		},
		rowCallback: function(row, data) {
            if (data.status == 4) {
                $(row).css('background-color', '#FFADB0');
            } else if (data.approvestatus == 2) {
                $(row).css('background-color', '#FFCCCB');
            }
        }
	});
	$('#dataTable tbody').on('click', '.btnview', function () {
		var id = $(this).attr('id');
		var inq_id = $(this).attr('inq_id');

		var approvestatus = $(this).attr('aproval_id');
		var checkstatus = $(this).attr('check_status');

		$('#dispatchid').val(id);
		$('#inq_id').val(inq_id);


		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Dispatchnote/Dispatchview',
			success: function (result) {
				$('#porderviewmodal').modal('show');
				$('#viewhtml').html(result);
				if (approvestatus > 0) {
                	$('#btnapprovereject').addClass('d-none').prop('disabled', true);
                	if (approvestatus == 1) {
                		$('#alertdiv').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle mr-2"></i> Dispatch Note approved</div>');
                	} else if (approvestatus == 2) {
                		$('#alertdiv').html('<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle mr-2"></i> Dispatch Note rejected</div>');
                	}
                } else {
                	if (checkstatus == 0) {
                		$('#btnapprovereject').addClass('d-none').prop('disabled', true);
                	} else {
						$('#btnapprovereject').removeClass('d-none').prop('disabled', false);
						$('#btncheck').addClass('d-none').prop('disabled', true);
                	}
                }
			}
		});

			$('#porderviewmodal').on('hidden.bs.modal', function (event) {
				$('#alertdiv').html('');
				$('#checkalertdiv').html('');
				$('#btnapprovereject').removeClass('d-none').prop('disabled', false);
				$('#btncheck').removeClass('d-none').prop('disabled', false);
			});

		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Dispatchnote/dispatchviewheader',
			success: function (result) { //alert(result);
				var obj = JSON.parse(result);
				$('#porderdate').text(obj.date);

				$('#pordersuppliername').text(obj.customername);
				$('#pordersuppliercontact').text(obj.customercontact);
				$('#porderaddress1').text(obj.address1);
				$('#porderaddress2').text(obj.address2);
				$('#pordercity').text(obj.city);
				$('#porderstate').text(obj.state);

				$('#viewcompanyname').text(obj.companyname);
				$('#viewbranchname').text(obj.branchname);
				$('#viewdispatch_no').text(obj.dispatch_no);
			}
		});
	});

	$('#btnapprovereject').click(function(){
        Swal.fire({
            title: "Do you want to approve this Dispatch Note?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Approve",
            denyButtonText: `Reject`
        }).then((result) => {
            if (result.isConfirmed) {
                var confirmnot = 1;
                approvejob(confirmnot);
            } else if (result.isDenied) {
                var confirmnot = 2;
                approvejob(confirmnot);
            } 
        });
    });

	$('#btncheck').click(function () {
		Swal.fire({
			title: "Do you want to check this Dispatch Note?",
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: "Check",
		}).then((result) => {
			if (result.isConfirmed) {
				var confirmnot = 1;
				checkjob(confirmnot);
			}
		});
	});

	let dataAdded = false;

	$("#formsubmit").click(function () {
		if (!$("#createorderform")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#submitBtn").click();
		} else {
			if (dataAdded) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'This Inquiry already added to the table',
				});
			} else {
				var jobID = $('#job').val();
				var comment = $('#comment').val();
				var job_no = $('#job_no').val();
				var job = $("#job option:selected").text();
				var uomID = $('#uom').val();
				var uom = $("#uom option:selected").text();
				var newqty = parseFloat($('#newqty').val());
				var unitprice = parseFloat($('#unitprice').val());
				var inquerydetailsid = parseFloat($('#inquerydetailsid').val());

				$('#tableorder > tbody:last').append('<tr class="pointer"><td name="job">' +
					job + '</td><td name="job_no" class="text-center">' +
					job_no + '</td><td name="comment" class="text-center">' +
					comment + '</td><td name="qty" class="text-center">' + newqty +
					'</td><td name="uom"class="text-center">' + uom +
					'</td> <td name="uomID" class="d-none">' + uomID +
					'</td><td name="jobid" class="d-none">' + jobID +
					'</td><td name="inquerydetailsid" class="d-none">' + inquerydetailsid +
					'</td><td name="unitprice" class="d-none">' + unitprice +
					'</td><td><button type="button" onclick="productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
				);

				dataAdded = true;

				$('#comment').val('');
				$('#newqty').val('');
				$('#unitprice').val('');
				$('#qtylabel').html('0');
				$('#inquerydetailsid').val('');
				$('#customerinqury').prop('readonly', true).css('pointer-events', 'none');
				$('#customer').prop('readonly', true).css('pointer-events', 'none');
				$('#job').next('.select2-container').first().addClass('disabled-pointer-events');
				$('#customerinqury').next('.select2-container').first().addClass(
					'disabled-pointer-events');
				$('#customer').next('.select2-container').first().addClass('disabled-pointer-events');

				var sum = 0;
				$(".total").each(function () {
					sum += parseFloat($(this).text());
				});
				$('#totalprice').val(sum);
			}
		}
	});

	$('#tableorder').on('click', 'tr', function () {
		var r = confirm("Are you sure, You want to remove this Job ? ");
		if (r == true) {
			$(this).closest('tr').remove();
		}
	});

	$('#btncreateorder').click(function () {
		$('#btncreateorder').prop('disabled', true).html(
			'<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
		var tbody = $("#tableorder tbody");

		if (tbody.children().length > 0) {
			jsonObj = [];
			$("#tableorder tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});

				jsonObj.push(item);
			});
			console.log("tableorder");
			console.log(jsonObj);

			var date = $('#date').val();
			var customerinqury = $('#customerinquryid').val();
			var ponum = $('#ponum').val();
			var customer = $('#customer').val();
			var branch_id = $('#f_branch_id').val();
			var company_id = $('#f_company_id').val();
			var remark = $('#remark').val();
			var jobFinishValue = $('#finishInquiryCheckbox').is(':checked') ? 1 : 0;

			Swal.fire({
				title: "",
				html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
				allowOutsideClick: false,
				showConfirmButton: false,
				backdrop: "rgba(255, 255, 255, 0.5)",
				customClass: {
					popup: "fullscreen-swal"
				},
				didOpen: () => {
					document.body.style.overflow = "hidden";

					$.ajax({
						type: "POST",
						data: {
							tableData: jsonObj,
							date: date,
							customerinqury: customerinqury,
							ponum: ponum,
							customer: customer,
							company_id: company_id,
							jobFinishValue: jobFinishValue,
							branch_id: branch_id,
							remark: remark

						},
						url: 'Dispatchnote/Dispatchnoteinsertupdate',
						success: function (result) {
							Swal.close();
							document.body.style.overflow = "auto";

							var response = JSON.parse(result);
							if (response.status == 1) {
								Swal.fire({
									icon: "success",
									title: "Dispatch Note Created!",
									text: "Dispatch Note successfully!",
									timer: 2000,
									showConfirmButton: false
								}).then(() => {
									window.location.reload();
								});
							} else {
								Swal.fire({
									icon: "error",
									title: "Error",
									text: "Something went wrong. Please try again later.",
								});
							}
						},
						error: function () {
							Swal.close();
							document.body.style.overflow = "auto";
							Swal.fire({
								icon: "error",
								title: "Error",
								text: "Something went wrong. Please try again later.",
							});
						}
					});
				},
			});
		}
	});
});

$('#job').change(function () {
    var jobID = $('#job').val();
    console.log(jobID);

    $.ajax({
        type: "POST",
        data: { recordID: jobID },
        url: 'Dispatchnote/Getqtyaccjob',
        success: function (result) {
            var obj = JSON.parse(result);

            $('#job_no').val(obj.job_no);
            $('#customerinqury').val('CUI000' + obj.customerinquryid);
            $('#customerinquryid').val(obj.customerinquryid);
            $('#ponum').val(obj.pono);

            var newqty = (obj.qty) - (obj.actual_qty);
            $('#newqty').val(newqty);
            $('#qtylabel').html(newqty);
            $('#comment').val(obj.comment);
            $('#unitprice').val(obj.unitprice);
            $('#inquerydetailsid').val(obj.detailsid);

			$('#uom').empty(); // Clear previous UOMs
			$('#uom').append('<option value="' + obj.uom_id + '">' + obj.uom + '</option>');
        }
    });

    // Reset fields to default
    $('#qtylabel').text('0');
    $('#newqty').val('0');
    $('#unitprice').val('0');
    $('#job_no').val('0');
    $('#uom').val('');
    $('#porder').empty();
    $('#comment').val('');

    // Get related customer
	$.ajax({
		type: "POST",
		data: {
			recordID: jobID
		},
		url: 'Dispatchnote/Getcustomeraccjob',
		success: function (result) {
			var obj = JSON.parse(result);

			// Clear existing customer options
			$('#customer').empty();

			// Append the related customer as a new option with the name shown
			$('#customer').append('<option value="' + obj.id + '">' + obj.customer + '</option>');
		}
	});
});

function deactive_confirm() {
	return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
	return confirm("Are you sure you want to confirm this Good Receive Note Request?");
}

function delete_confirm() {
	return confirm("Are you sure you want to remove this?");
}

function addCommas(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function action(data) { //alert(data);
	var obj = JSON.parse(data);
	$.notify({
		// options
		icon: obj.icon,
		title: obj.title,
		message: obj.message,
		url: obj.url,
		target: obj.target
	}, {
		// settings
		element: 'body',
		position: null,
		type: obj.type,
		allow_dismiss: true,
		newest_on_top: false,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "center"
		},
		offset: 100,
		spacing: 10,
		z_index: 1031,
		delay: 5000,
		timer: 1000,
		url_target: '_blank',
		mouse_over: null,
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		},
		onShow: null,
		onShown: null,
		onClose: null,
		onClosed: null,
		icon_type: 'class',
		template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
			'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
			'<span data-notify="icon"></span> ' +
			'<span data-notify="title">{1}</span> ' +
			'<span data-notify="message">{2}</span>' +
			'<div class="progress" data-notify="progressbar">' +
			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
			'</div>' +
			'<a href="{3}" target="{4}" data-notify="url"></a>' +
			'</div>'
	});
}
function approvejob(confirmnot){
    Swal.fire({
        title: '',
        html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false, // Hide the OK button
        backdrop: `
            rgba(255, 255, 255, 0.5) 
        `,
        customClass: {
            popup: 'fullscreen-swal'
        },
        didOpen: () => {
            document.body.style.overflow = 'hidden';

            $.ajax({
                type: "POST",
                data: {
                    dispatchid: $('#dispatchid').val(),
					inqid: $('#inq_id').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>Dispatchnote/Approdispatch',
                success: function(result) {
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        actionreload(obj.action);
                    }
                    else{
                        action(obj.action);
                    }
                },
                error: function(error) {
                    // Close the SweetAlert on error
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    
                    // Show an error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.'
                    });
                }
            });
        }
    });
}

function checkjob(confirmnot){
    Swal.fire({
        title: '',
        html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false, // Hide the OK button
        backdrop: `
            rgba(255, 255, 255, 0.5) 
        `,
        customClass: {
            popup: 'fullscreen-swal'
        },
        didOpen: () => {
            document.body.style.overflow = 'hidden';

            $.ajax({
                type: "POST",
                data: {
                    requestid: $('#dispatchid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>Dispatchnote/Dispatchnotecheckstatus',
                success: function(result) {
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        actionreload(obj.action);
                    }
                    else{
                        action(obj.action);
                    }
                },
                error: function(error) {
                    // Close the SweetAlert on error
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    
                    // Show an error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.'
                    });
                }
            });
        }
    });
}
</script>
<?php include "include/footer.php"; ?>