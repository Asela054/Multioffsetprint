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
							<div class="page-header-icon"><i class="fa fa-check-square"></i></div>
							<span><b>Issue Item Request</b></span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="container-fluid mt-2 p-0 p-2">
							<div class="card">
								<div class="card-body p-0 p-2">
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
											<form id="createorderform" autocomplete="off">
												<div class="form-row mb-1">
													<div class="col">
														<label class="small font-weight-bold text-dark">Issue
															Date*</label>
														<input type="date" class="form-control form-control-sm"
															placeholder="" name="issuedate" id="issuedate"
															onchange="getVat();" value="<?php echo date('Y-m-d') ?>"
															required>
													</div>
													<div class="col">
														<label class="small font-weight-bold text-dark">Item
															Request*</label>
														<select class="form-control form-control-sm" name="itemrequest"
															id="itemrequest">
															<option value="">Select</option>
															<?php foreach($grnlist->result() as $rowgrnlist){ ?>
															<option value="<?php echo $rowgrnlist->idtbl_grn_req ?>">
																<?php echo 'IR000'.$rowgrnlist->idtbl_grn_req ?>
															</option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Location*</label>
													<select class="form-control form-control-sm" name="company"
														id="company" required>
														<option value="">Select</option>
														<?php foreach($locationlist->result() as $rowlocationlist){ ?>
														<option value="<?php echo $rowlocationlist->idtbl_location ?>">
															<?php echo $rowlocationlist->location ?></option>
														<?php } ?>
													</select>
												</div>

												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Department*</label>
													<select class="form-control form-control-sm" name="department"
														id="department" required>
														<option value="">Select</option>
														<?php foreach($departmentlist->result() as $rowdepartmentlist){ ?>
														<option value="<?php echo $rowdepartmentlist->id ?>">
															<?php echo $rowdepartmentlist->name ?></option>
														<?php } ?>
													</select>
												</div>

												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Order Type*</label>
													<select class="form-control form-control-sm" name="ordertype"
														id="ordertype" required>
														<option value="">Select</option>
														<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
														<option
															value="<?php echo $rowordertypelist->idtbl_order_type ?>">
															<?php echo $rowordertypelist->type ?></option>
														<?php } ?>
													</select>
												</div>
												<!-- Add the error message container -->
												<!-- <div id="ordertypeError" class="text-danger" style="display: none;">
													Select only items related to one Order type per GRN equest!
												</div> -->

												<div id="productFields">
													<div class="form-group mb-1">
														<label class="small font-weight-bold text-dark">Item*</label>
														<select class="form-control form-control-sm" name="product"
															id="product">
															<option value="">Select</option>
														</select>
													</div>
												</div>

												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Batch No**</label>
													<select class="form-control form-control-sm" name="batchno"
														id="batchno" required>
														<option value="">Select</option>
													</select>
												</div>

												<div class="form-row mb-1">
													<div class="col">
														<label class="small font-weight-bold text-dark">Rate</label>
														<input type="text" id="unitprice" name="unitprice"
															class="form-control form-control-sm" value="0" readonly>
													</div>
													<div class="col" id="newQtyFields" style="display: none;">
														<label class="small font-weight-bold text-dark">Qty*</label>
														<label class="small font-weight-bold text-danger"
															id="qtylabel"></label>
														<input type="number" id="newqty" name="newqty"
															class="form-control form-control-sm" required>
													</div>

												</div>


												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Reason</label>
													<textarea name="comment" id="comment"
														class="form-control form-control-sm"></textarea>
												</div>
												<div class="form-group mt-3 text-right">
													<button type="button" id="formsubmit"
														class="btn btn-primary btn-sm px-4"
														<?php if($addcheck==0){echo 'disabled';} ?>><i
															class="fas fa-plus"></i>&nbsp;Add to
														list</button>
													<input name="submitBtn" type="submit" value="Save" id="submitBtn"
														class="d-none">
												</div>
												<input type="hidden" name="refillprice" id="refillprice" value="">
												<input type="hidden" name="totalprice" id="totalprice" value="0">
											</form>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
											<div id="materialmachinetblpart">
												<table class="table table-striped table-bordered table-sm small"
													id="tableorder">
													<thead>
														<tr>
															<th>Item</th>
															<th class="d-none">ProductID</th>
															<th class="text-center">Comment</th>
															<th class="text-center">Rate</th>
															<th class="text-center">Qty</th>
															<th class="text-center">Total</th>
															<th class="text-right">Action</th>
															<!-- <th class="d-none">HideTotal</th>
															<th class="text-right">Total</th> -->
														</tr>
													</thead>
													<tbody></tbody>
												</table>
											</div>

											<hr>

											<div class="form-group mt-2">
												<button type="button" id="btncreateorder"
													class="btn btn-outline-primary btn-sm fa-pull-right"><i
														class="fas fa-save"></i>&nbsp;Issue Item Request</button>
											</div>
										</div>
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
														id="dataTable">
														<thead>
															<tr>
																<th>#</th>
																<th>Location</th>
																<th>Department</th>
																<th>Order Type</th>
																<th>Date</th>
																<th>Approve Status</th>
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
					<h5 class="modal-title" id="staticBackdropLabel">View Good Receive Note Request</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2 style="margin-bottom: 2px;" class="text-right">Good Receive Note Request<span id="pr"></span>
					</h2>
					<p style="margin-bottom: 2px;" class="text-right">MO/GRNR-0000<span id="procode"></span></P>
					<!-- <p style="margin-bottom: 2px;" class="text-right">Multi Offset Print <span id="proname"></span></p>
					<p style="margin-bottom: 2px;" class="text-right">0775678923 <span id="pronumber"></span></p> -->
					<!-- <p style="margin-bottom: 2px;" class="text-right"><span id="porderdate"></span></p> -->

					<!-- <p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliername"></span></P>
					<p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliercontact"></span></p>
					<p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress1"></span></p>
					<p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress2"></span></p>
					<p style="margin-bottom: 2px;" class="text-left"><span id="pordercity"></span></p>
					<p style="margin-bottom: 2px;" class="text-left"><span id="porderstate"></span></p> -->

					<div id="viewhtml"></div>
				</div>
				<input type="hidden" id="viewissueid" name="viewissueid" />
				<div class="modal-footer">
					<button type="button" id="approvel" class="btn btn-outline-primary btn-sm fa-pull-right"><i
							class="far fa-save"></i>&nbsp;
						Approvel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		// ... (existing code)
		$('#vehicletblpart').hide();
		$('#newQtyFields').show();
		// $('#material&machinetblpart').show();

		$('#ordertype').change(function () {
			let ordertype = $(this).val();

			// Hide/show field group containers based on ordertype
			if (ordertype == 2) {
				$('#supplierFields').hide();
				$('#productFields').hide();
				$('#newQtyFields').show();
				$('#servisetypeFields').show();
				$('#supplier').removeAttr('required');
				$('#product').removeAttr('required');
				$('#servicetype').attr('required', 'required');
				$('#unitprice').val('0');
				// $('#servisetypeFields').val('0');
				$('#vehicletblpart').show();
				$('#materialmachinetblpart').hide();

			} else {
				$('#supplier').attr('required', 'required'); // Add 'required' attribute
				$('#product').attr('required', 'required');
				$('#servicetype').removeAttr('required');
				$('#supplierFields').show();
				$('#productFields').show();
				$('#newQtyFields').show();
				$('#servisetypeFields').hide();
				$('#vehicletblpart').hide();
				$('#materialmachinetblpart').show();

				//$('label2').hide();
			}
		});

		// ... (existing code)
	});

</script>
<script>
	var ordertypeSelected = false;

	document.getElementById('ordertype').addEventListener('change', function () {
		if (this.value !== '') {
			// Check if "ordertype" has been selected before
			if (ordertypeSelected) {
				// Show the error message
				document.getElementById('ordertypeError').style.display = 'block';
			} else {
				// Mark "ordertype" as selected for the first time
				ordertypeSelected = true;
			}
		}
	});

</script>







<script>
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';


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
					title: 'Good Receive Note Request Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Good Receive Note Request Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Good Receive Note Request Information',
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
				url: "<?php echo base_url() ?>scripts/issuelist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_print_issue"
				},
				{
					"data": "location"
				},
				{
					"data": "name"
				},
				{
					"data": "type"
				},
				{
					"data": "issuedate"
				},
				{
					"targets": -1,
					"className": '',
					"data": null,
					"render": function (data, type, full) {
						if (full['approvestatus'] == 1) {
							return '<i class="fas fa-check text-success mr-2"></i>Approved';
						} else {
							return 'Not Approved';
						}
					}
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						// button += '<a href="<?php echo base_url() ?>Newpurchaserequest/Printinvoice/' +
						// 	full['idtbl_invoice'] +
						// 	'" target="_self" class="btn btn-secondary btn-sm mr-1 ';
						// if (editcheck != 1) {
						// 	button += 'd-none';
						// }
						// button += '"><i class="fas fa-file-pdf mr-2"></i></a>';
						button += '<a href="<?php echo base_url() ?>Issuegoodreceive/Issuepdf/' + full['idtbl_print_issue'] + '" target="_blank" class="btn btn-secondary btn-sm btnPdf mr-1" data-toggle="tooltip" data-placement="bottom" title="Issue Item Request PDF"><i class="fas fa-file-pdf"></i></a>';
						if (full['approvestatus'] == 0) {
							button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' +
								full[
									'idtbl_print_issue'] + '"><i class="fas fa-eye"></i></button>';
						}
						if (full['approvestatus'] == 1) {
							button += '<button class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></button>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Goodreceiverequest/Goodreceiverequeststatus/' +
								full['idtbl_print_issue'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#dataTable tbody').on('click', '.btnview', function () {
			var id = $(this).attr('id');
			$('#viewissueid').val(id);
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Issuegoodreceive/Issueview',
				success: function (result) { //alert(result);

					$('#porderviewmodal').modal('show');
					$('#viewhtml').html(result);
				}
			});
		});

		// approvel issue
		$('#approvel').click(function () { //alert('IN');
			var viewissueid = $('#viewissueid').val();

			$('#approvel').prop('disabled', true).html(
				'<i class="fas fa-circle-notch fa-spin mr-2"></i> Approvel')
			var tbody = $("#approveltable tbody");

			if (tbody.children().length > 0) {
				jsonObj = [];
				$("#approveltable tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});

					jsonObj.push(item);
				});
				// console.log(jsonObj);

				$.ajax({
					type: "POST",
					data: {
						tableData: jsonObj,
						viewissueid: viewissueid

					},
					url: 'Issuegoodreceive/Approveissue',
					success: function (result) { //alert(result);
						//console.log(result);
						var objfirst = JSON.parse(result);
						if (objfirst.status == 1) {
							setTimeout(function () {
								window.location.reload();
							}, 500);
						}
						action(objfirst.action)
					}
				});
			}


		});





		$("#formsubmit").click(function () {
			if (!$("#createorderform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#submitBtn").click();
			} else {
				var productID = $('#product').val();
				var comment = $('#comment').val();
				var product = $("#product option:selected").text();
				var unitprice = parseFloat($('#unitprice').val());
				var newqty = parseFloat($('#newqty').val());
				var stockid = $('#batchno').val();
				//var discount = $('#discount').val();
				// var uomID = $('#uom').val();
				// var uom = $("#uom option:selected").text();
				// var issuedate = $('#issuedate').val();
				// alert('hello2');

				var newtotal = parseFloat(unitprice * newqty);

				var total = parseFloat(newtotal);
				var showtotal = addCommas(parseFloat(total).toFixed(2));


				$('#tableorder > tbody:last').append('<tr class="pointer"><td name="productname">' +
					product +
					'</td><td name="comment">' +
					comment + '</td><td name="unitprice" class="text-center">' + unitprice +
					'</td><td name="qty" class="text-center">' +
					newqty + '</td><td name="showtotal" class="text-right">' +
					showtotal + '</td><td name="productid" class="d-none">' + productID +
					'</td><td name="total" class="total d-none">' + total +
					'</td><td name="stockid" class="d-none">' + stockid +
					'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
					);

				$('#product').val('');
				$('#unitprice').val('0');
				$('#uom').val('');
				$('#comment').val('');
				$('#newqty').val('');
				// $('#mfdate').val("<?php echo date('Y-m-d') ?>");
				$('#qtylabel').val('0');
				// $('#expdate').val('');
				//$('#porder').prop('readonly', true).css('pointer-events', 'none');


				var sum = 0;
				$(".total").each(function () {
					sum += parseFloat($(this).text());
				});
				$('#totalprice').val(sum);
				// var showsum = addCommas(parseFloat(sum).toFixed(2));

				// $('#divtotal').html('<strong style="background-color: yellow;"> Rs. <strong>' +
				// 	showsum);

				// // html('<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
				// // 		showgrosstot);
				// $('#hidetotalorder').val(sum);
				// $('#product').focus();
			}

			// finaltotalcalculate();

		});
		$('#tableorder').on('click', 'tr', function () {
			var r = confirm("Are you sure, You want to remove this product ? ");
			if (r == true) {
				$(this).closest('tr').remove();

				var sum = 0;
				$(".total").each(function () {
					sum += parseFloat($(this).text());
				});
				$('#totalprice').val(sum);
				var showsum = addCommas(parseFloat(sum).toFixed(2));

				$('#divtotal').html('Rs. ' + showsum);
				$('#hidetotalorder').val(sum);
				$('#product').focus();
			}
		});

		$('#btncreateorder').click(function () { //alert('IN');
			var ordertype = $('#ordertype').val();
			if (ordertype == 3 || ordertype == 4) {
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
					//alert("click");
					var department = $('#department').val();
					var total = $('#totalprice').val();
					var itemrequest = $('#itemrequest').val();
					var location = $('#company').val();
					var ordertype = $('#ordertype').val();
					var issuedate = $('#issuedate').val();
					var issue = $('#itemrequest').val();

					// alert(orderdate);
					$.ajax({
						type: "POST",
						data: {
							tableData: jsonObj,
							issuedate: issuedate,
							department: department,
							ordertype: ordertype,
							location: location,
							issue: issue,
							total: total,
							itemrequest: itemrequest

						},
						url: 'Issuegoodreceive/Issuegoodreceiveinsertupdate',
						success: function (result) { //alert(result);
							//console.log(result);
							var objfirst = JSON.parse(result);
							if (objfirst.status == 1) {
								setTimeout(function () {
									window.location.reload();
								}, 500);
							}
							action(objfirst.action)
						}
					});
				}
			}

		});


	});

	//////////////////////////////////////////////// get Informations  acording to Item Request //////
	var tempgrntype;
	$('#itemrequest').change(function () {
		var itemreqID = $(this).val();
		// get Location
		$.ajax({
			type: "POST",
			data: {
				recordID: itemreqID
			},
			url: 'Issuegoodreceive/Getlocationaccoitemreq',
			success: function (result) { //alert(result);
				$('#company').val(result);
				// console.log(result);
				$('#company').val(result).css('pointer-events', 'none');
			}
		});

		// get Department
		$.ajax({
			type: "POST",
			data: {
				recordID: itemreqID
			},
			url: 'Issuegoodreceive/Getdepartmentaccoitemreq',
			success: function (result) { //alert(result);
				$('#department').val(result);
				console.log(result);
				$('#department').val(result).css('pointer-events', 'none');
			}
		});

		// get Order Type
		function getOrdertype() {
			return new Promise(function (resolve, reject) {
				$.ajax({
					type: "POST",
					data: {
						recordID: itemreqID
					},
					url: 'Issuegoodreceive/Getordertypeaccoitemreq',
					success: function (result) { //alert(result);
						$('#ordertype').val(result);
						console.log(result);
						$('#ordertype').val(result).css('pointer-events', 'none');
						tempgrntype = result;
						getitems(itemreqID, result);
						resolve();
					},
					error: reject
				});
			});
		}
		getOrdertype()
		// GetitemreQTY()
		$('#qtylabel').text('0');

	});

	function getitems(itemreqID, ordertype) {
		if (ordertype == 4) {
			$.ajax({
				type: "POST",
				data: {
					recordID: itemreqID
				},
				url: 'Issuegoodreceive/Getmachineitem',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						html1 += '<option value="' + obj[i]
							.idtbl_machine + '">';
						html1 += obj[i].machine;
						html1 += '</option>';
					});
					$('#product').empty().append(html1);
				}
			});
		} else if (ordertype == 3) {
			$.ajax({
				type: "POST",
				data: {
					recordID: itemreqID
				},
				url: 'Issuegoodreceive/Getmaterialitem',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						html1 += '<option value="' + obj[i]
							.idtbl_print_material_info +
							'">';
						html1 += obj[i].materialname + ' / ' + obj[i]
							.materialinfocode;
						html1 += '</option>';
					});
					$('#product').empty().append(html1);
				}
			});
		}
	};

	$('#product').change(function () {
		var productID = $(this).val();
		var ordertype = tempgrntype;
		var itemreq_id = $('#itemrequest').val();
		// var item_id = $('#product').val();

		// console.log(productID, ordertype);
		// alert(itemreq_id);

		if (ordertype == 3) {
			$.ajax({
				type: "POST",
				data: {
					recordID: productID,
					itemreq_id: itemreq_id,
					// item_id: item_id
				},
				url: 'Issuegoodreceive/Getproductinfoaccoproduct',
				success: function (result) {
					// alert(result);
					// console.log(result);
					var obj = JSON.parse(result);
					// console.log(obj);

					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						// console.log(obj);
						html1 += '<option value="' + obj[i]
							.idtbl_print_stock + '">';
						html1 += obj[i].batchno;
						html1 += '</option>';
					});
					$('#batchno').empty().append(html1);
				}
			});

			$.ajax({
				type: "POST",
				data: {
					recordID: productID,
					itemreq_id: itemreq_id,
				},
				url: 'Issuegoodreceive/Getqtyfromreq',
				success: function (result) {
					//alert(result);
					//console.log(result);
					var obj = JSON.parse(result);
					//console.log(obj.item);

					$('#qtylabel').html(obj.qtylabel);
				}
			});

		} else if (ordertype == 4) {
			$.ajax({
				type: "POST",
				data: {
					recordID: productID,
					itemreq_id: itemreq_id,
					// item_id: item_id
				},
				url: 'Issuegoodreceive/Getproductinfoaccomachine',
				success: function (result) {
					// alert(result);
					// console.log(result);
					var obj = JSON.parse(result);
					// console.log(obj);

					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						// console.log(obj);
						html1 += '<option value="' + obj[i]
							.idtbl_print_stock + '">';
						html1 += obj[i].batchno;
						html1 += '</option>';
					});
					$('#batchno').empty().append(html1);
				}
			});
			$.ajax({
				type: "POST",
				data: {
					recordID: productID,
					itemreq_id: itemreq_id,
				},
				url: 'Issuegoodreceive/Getqtyfromreqmachine',
				success: function (result) {
					//alert(result);
					//console.log(result);
					var obj = JSON.parse(result);
					//console.log(obj.item);

					$('#qtylabel').html(obj.qtylabel);
				}
			})
		}

	});

	$('#batchno').change(function () {
		var batchnoID = $(this).val();
	//alert(result);
		console.log(batchnoID);

		$.ajax({
			type: "POST",
			data: {
				recordID: batchnoID
			},
			url: 'Issuegoodreceive/GetBachnoInfo',
			success: function (result) {
				//alert(result);
				//console.log(result);
				var obj = JSON.parse(result);
				//console.log(obj.item);

				$('#unitprice').val(obj.item.unitprice);
			}
		});

		$.ajax({
			type: "POST",
			data: {
				recordID: batchnoID
			},
			url: 'Issuegoodreceive/GetitemreQTY',
			success: function (result) {
				//alert(result);
				// console.log(result);
				var obj = JSON.parse(result);
				//console.log(obj.item);

				$('#newqty').val(obj.qty);
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

</script>
<?php include "include/footer.php"; ?>
