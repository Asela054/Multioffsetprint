<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; ?>
	</div>
	<div id="layoutSidenav_content">
		<!-- <style>
			#viewmodal .modal-content {
				border: 3px solid #0982e6;
				/* Light blue color */
				border-radius: 25px;
				box-shadow: 0 0 30px 1px black;
				/* Optional: Add rounded corners */
			}

		</style> -->
		<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i class="fas fa-truck"></i></div>
							<span>Good Receive Note Voucher</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12 text-right">
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
									data-target="#staticBackdrop" onclick="getVat();"
									<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create
									Good Receive Note Voucher</button>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
										<thead>
											<tr>
												<th>#</th>
												<th>GRN No</th>
												<th>GRN Voucher Date</th>
												<th>Supplier</th>
												<th>Total</th>
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
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Good Receive Note Voucher</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
						<form id="createorderform" autocomplete="off">
							<div class="form-group mb-1">
								<!-- <div class="col"> -->
								<label class="small font-weight-bold text-dark">Date*</label>
								<input type="date" class="form-control form-control-sm" placeholder="" name="grndate"
									id="grndate" onchange="getVat();" value="<?php echo date('Y-m-d') ?>" required>
								<!-- </div> -->

							</div>
							<div class="form-group mb-1">
								<!-- <div class="col"> -->
								<label class="small font-weight-bold text-dark">Supplier*</label>
								<select class="form-control form-control-sm selecter2 px-0" name="supplier"
									id="supplier" required>
									<option value="">Select</option>
									<?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
									<option value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
										<?php echo $rowsupplierlist->name ?></option>
									<?php } ?>
								</select>
								<!-- </div> -->
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">GRN No.</label>
									<select class="form-control form-control-sm selecter2 px-0" name="grnno"
										id="grnno" required>
										<option value="">Select</option>
									</select>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Cost Type*</label>
									<select class="form-control form-control-sm" name="costtype" id="costtype" required>
										<option value="">Select</option>
										<?php foreach($costtypelist->result() as $rowcosttype){ ?>
										<option value="<?php echo $rowcosttype->idtbl_import_cost_types ?>">
											<?php echo $rowcosttype->cost_type ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Cost Amount</label>
									<input type="text" id="amount" name="amount"
										class="form-control form-control-sm"
										<?php if($editcheck==0){echo 'readonly';} ?> value="0">
								</div>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Comment</label>
								<textarea name="comment" id="comment" class="form-control form-control-sm"
									<?php if($editcheck==0){echo 'readonly';} ?>></textarea>
							</div>
							<div class="form-group mt-3 text-right">
								<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
									<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to
									list</button>
								<input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
							</div>
							<input type="hidden" name="refillprice" id="refillprice" value="">
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
						<div class="scrollbar pb-3" id="style-3">
							<table class="table table-striped table-bordered table-sm small" id="tableorder">
								<!-- Table headers remain unchanged -->
								<thead>
									<tr>
										<th>Comment</th>
										<th class="d-none">GrnID</th>
										<th>Cost Type</th>
                                        <th class="text-right">Cost Amount</th>
                                        <th class="text-right">Remove</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>

						<div class="row">
							<div class="col text-right mt-3">
								<h4 class="font-weight-600" id="divtotal">Rs. 0.00</h4>
							</div>
							<input type="hidden" id="hidetotalorder" value="0">
						</div>
						<hr>
						<div class="form-group">
							<label class="small font-weight-bold text-dark">Remark</label>
							<textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
						</div>
						<div class="form-group mt-2">
							<button type="button" id="btncreateorder"
								class="btn btn-outline-primary btn-sm fa-pull-right"><i
									class="fas fa-save"></i>&nbsp;Create
								Good Receive Note Voucher</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="viewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">View Good Recieve Note Voucher</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="GRNView">
				<div class="row">
					<div class="col-6 text-left">
						<img src="./images/book.jpg" alt="" width="40%" style="margin-top: -20px;">
					</div>
					<div class="col-6">
						<h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
							class="text-right" class="text-right">Good Recieve Note Voucher<span id="pr"></span>
						</h2>
						<p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
							class="text-right" class="text-right">Multi Offset Printers (PVT) LTD <span
								id="proname"></span>
						</p>
						<p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
							class="text-right" class="text-right">MO/GRNV-0000<span id="grncode"></span>
						</P>
						<p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
							class="text-right" class="text-right"><span id="porderdate"></span></p>
					</div>
				</div>


				<div id="viewhtml"></div>

			</div>
			<div class="modal-footer">
				<button type="button" id="printgrn" class="btn btn-outline-primary btn-sm fa-pull-right"
					<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Print GRN Voucher</button>
			</div>
		</div>
	</div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		$('#printgrn').click(function () {
			printJS({
				printable: 'GRNView',
				type: 'html',
				css: 'assets/css/styles.css'
			});
		});
	});

	$(document).ready(function () {

		$('#supplier').select2({
			dropdownParent: $('#staticBackdrop'),
			width: '100%',
		});
		$('#porder').select2({
			dropdownParent: $('#staticBackdrop'),
			width: '100%',
		});
		$('#product').select2({
			dropdownParent: $('#staticBackdrop'),
			width: '100%',
		});

		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

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
					title: 'Good Receive Note Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Good Receive Note Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Good Receive Note Information',
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
				url: "<?php echo base_url() ?>scripts/grnvoucherlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [
				{
					"data": "idtbl_grn_vouchar_import_cost"
				},
				{
					"data": function (row) {
						return "MO/GRN-0000" + row.tbl_print_grn_idtbl_print_grn;
					}
				},
				{
					"data": "date"
				},
				{
					"data": "name"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						return addCommas(parseFloat(full['total']).toFixed(2));
					}
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href="<?php echo base_url() ?>Goodreceive/pdfgrnget/' +
							full['idtbl_print_grn'] +
							'" target="_self" class="btn btn-secondary btn-sm mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-file-pdf mr-2"></i></a>';


						button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full[
							'idtbl_grn_vouchar_import_cost'] + '"><i class="fas fa-eye"></i></button>';
						if (full['approvestatus'] == 1) {
							button += '<button class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></button>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>GRNVoucher/Goodreceivevoucherstatus/' +
								full['idtbl_grn_vouchar_import_cost'] + '/1/' + full[
									'tbl_print_porder_idtbl_print_porder'] +
								'" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						if (full['approvestatus'] == 0) {
							button +=
								'<a href="<?php echo base_url() ?>GRNVoucher/Goodreceivevoucherstatus/' +
								full['idtbl_grn_vouchar_import_cost'] +
								'/3/PLACEHOLDER" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
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
			}
		});


		// $('#dataTable tbody').on('click', '.btnAddCosting', function () {
		// 	var id = $(this).attr('id');
		// 	$.ajax({
		// 		type: "POST",
		// 		data: {
		// 			recordID: id
		// 		},
		// 		url: '<?php echo base_url() ?>Goodreceive/Getgoodreceiveid',
		// 		success: function (result) { //alert(result);
		// 			var obj = JSON.parse(result);
		// 			$('#addCostModal').modal('show');
		// 			$('#grnid').val(obj[0].idtbl_print_grn);
		// 			$('#grnid').html(obj[0].idtbl_print_grn);

		// 			preparelist(obj[0].idtbl_print_grn);

		// 		}
		// 	});
		// });
		$('#dataTable tbody').on('click', '.btnview', function () {
			var id = $(this).attr('id');
			$('#grncode').html(id);
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>GRNVoucher/Goodreceivevoucherview',
				success: function (result) { //alert(result);
					$('#viewmodal').modal('show');
					$('#viewhtml').html(result);
				}
			});
		});



		$("#formsubmit").click(function () {
			if (!$("#createorderform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#submitBtn").click();
			} else {
				var costtypeID = $('#costtype').val();
				var comment = $('#comment').val();
				var costtype = $("#costtype option:selected").text();
				var unitprice = parseFloat($('#amount').val());

				$('#tableorder > tbody:last').append('<tr class="pointer"><td>' +
					comment + '</td><td>' + costtype + '</td><td class="d-none">' + costtypeID +
					'</td><td class="total text-right">' + unitprice + '</td>' +
					'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
				);

				$('#costtype').val('');
				$('#amount').val('0');
				$('#comment').val('')


				var sum = 0;
				$(".total").each(function () {
					sum += parseFloat($(this).text());
				});

				var showsum = addCommas(parseFloat(sum).toFixed(2));

				$('#divtotal').html('<strong style="background-color: yellow;"> Rs. <strong>' + showsum);

				// html('<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
				// 		showgrosstot);
				$('#hidetotalorder').val(sum);
				$('#product').focus();
			}

			finaltotalcalculate();

		});

		//calculate Sub Total

		$(document).on("keyup", "#discount", function (event) {
			var checkdiscount = parseFloat($("#discount").val()); //alert(checkdiscount);
			if (!checkdiscount == "") {
				finaltotalcalculate();
			} else {

			}

		});

		//calculate Final Total

		$(document).on("keyup", "#vat", function (event) {
			var checkvat = parseFloat($("#vat").val()); //alert(checkdiscount);
			if (!checkvat == "") {
				finaltotalcalculate();
			} else {

			}

		});


		$('#tableorder').on('click', 'tr', function () {
			var r = confirm("Are you sure, You want to remove this product ? ");
			if (r == true) {
				$(this).closest('tr').remove();

				var sum = 0;
				$(".total").each(function () {
					sum += parseFloat($(this).text());
				});

				var showsum = addCommas(parseFloat(sum).toFixed(2));

				$('#divtotal').html('Rs. ' + showsum);
				$('#hidetotalorder').val(sum);
				$('#product').focus();
			}
		});

		$('#tblcost').on('click', 'tr', function () {
			var r = confirm("Are you sure, You want to remove this cost? ");
			if (r == true) {
				$(this).closest('tr').remove();

				var sum = 0;
				$(".totalamount").each(function () {
					sum += parseFloat($(this).text());
				});

				var showsum = addCommas(parseFloat(sum).toFixed(2));

				$('#labelcosttotal').html('Rs. ' + showsum);
				$('#totalcost').val(sum);
			}
		});

		$('#btncreateorder').click(function () { //alert('IN');
			$('#btncreateorder').prop('disabled', true).html(
				'<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Good Receive Note Voucher')
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
				// console.log(jsonObj);

				var grndate = $('#grndate').val();
				var remark = $('#remark').val();
				var supplier = $('#supplier').val();
				var grnno = $('#grnno').val();
				var total = $('#hidetotalorder').val();

				$.ajax({
					type: "POST",
					data: {
						tableData: jsonObj,
						grndate: grndate,
						total: total,
						remark: remark,
						supplier: supplier,
						grnno: grnno
					},
					url: 'GRNVoucher/GRNvoucherinsertupdate',
					success: function (result) { //alert(result);
						//console.log(result);
						$('#staticBackdrop').modal('hide');
						var objfirst = JSON.parse(result);
						if (objfirst.status == 1) {
							setTimeout(function () {
								window.location.reload();
							}, 2000);
						}
						action(objfirst.action)
					}
				});
			}

		});

		$('#supplier').change(function () {
			var supplierID = $(this).val();
			$('#grnno').empty();
			$('#grnno').prepend('<option value="" selected="selected">Select GRN</option>');

			$.ajax({
				type: "POST",
				data: {
					recordID: supplierID
				},
				url: 'GRNVoucher/Getgrnaccsupllier',
				success: function (result) {
					//alert(result);
					var obj = JSON.parse(result);
					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						html1 += '<option value="' + obj[i].idtbl_print_grn + '">' +
							'MO/GRN-0000' + obj[i].idtbl_print_grn + '</option>';
						html1 += obj[i].idtbl_print_grn;
						html1 += '</option>';
					});
					$('#grnno').empty().append(html1);
				}
			});

		});

		var tempsupplier;
		var tempgrntype;
		$('#porder').change(function () {
			var porderID = $(this).val();

			$.ajax({
				type: "POST",
				data: {
					recordID: porderID
				},
				url: 'Goodreceive/Getlocationaccoporder',
				success: function (result) { //alert(result);
					$('#location').val(result);
					$('#location option').each(function () {
						if (!this.selected) {
							$(this).attr('disabled', true);
						}
					});
					// getbatchno();
				}
			});


			function getSupplier() {
				return new Promise(function (resolve, reject) {
					$.ajax({
						type: "POST",
						data: {
							recordID: porderID
						},
						url: 'Goodreceive/Getsupplieraccoporder',
						success: function (result) {
							$('#supplier').val(result);
							$('#supplier option').each(function () {
								// if (!this.selected) {
								// 	$(this).attr('disabled', true);
								// }
							});
							tempsupplier = result;
							resolve();
						},
						error: reject
					});
				});
			}

			function getGrntype() {
				return new Promise(function (resolve, reject) {
					$.ajax({
						type: "POST",
						data: {
							recordID: porderID
						},
						url: 'Goodreceive/Getpordertpeaccoporder',
						success: function (result) {
							$('#grntype').val(result);
							$('#grntype option').each(function () {
								if (!this.selected) {
									$(this).attr('disabled', true);
								}
							});
							tempgrntype = result;
							getitems(porderID, result);
							resolve();
						},
						error: reject
					});
				});
			}


			getSupplier()
				.then(getGrntype)
				.then(function () {

					// console.log(tempsupplier, tempgrntype);
					getbatchno(tempsupplier, tempgrntype);
				})
				.catch(function (error) {
					console.error("An error occurred:", error);
				});

		});

		function getbatchno(supplierID, typeID) {

			$.ajax({
				type: "POST",
				data: {
					recordID: supplierID
				},
				url: 'Goodreceive/Getbatchnoaccosupplier',
				success: function (result) {
					// alert(result);
					//console.log(result);
					$('#batchno').val(result);
				}
			});
		}

		function getitems(porderID, grntype) {
			if (grntype == 4) {
				$.ajax({
					type: "POST",
					data: {
						recordID: porderID
					},
					url: 'Goodreceive/Getproductformachine',
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
			}else if (grntype == 3) {
				$.ajax({
					type: "POST",
					data: {
						recordID: porderID
					},
					url: 'Goodreceive/Getproductaccoporder',
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
			}else if (grntype == 1) {
				$.ajax({
					type: "POST",
					data: {
						recordID: porderID
					},
					url: 'Goodreceive/Getproductforsparepart',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						var html1 = '';
						html1 += '<option value="">Select</option>';
						$.each(obj, function (i, item) {
							html1 += '<option value="' + obj[i]
								.idtbl_spareparts +
								'">';
							html1 += obj[i].spare_part_name ;
							html1 += '</option>';
						});
						$('#product').empty().append(html1);
					}
				});
			}
		};

		$('#product').change(function () {
			var productID = $(this).val();
			var grntype = tempgrntype;
			var grn_id = $('#porder').val();

			console.log(productID, grntype);

			if (grntype == 3) {
				$.ajax({
					type: "POST",
					data: {
						recordID: productID,
						grn_id: grn_id
					},
					url: 'Goodreceive/Getproductinfoaccoproduct',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						// $('#newqty').val(obj.qty);
						$('#qtylabel').html(obj.qty);
						$('#uom').val(obj.uom);
						$('#unitprice').val(obj.unitprice);
						$('#comment').val(obj.comment);
					}
				});
			} else if (grntype == 4) {
				$.ajax({
					type: "POST",
					data: {
						recordID: productID,
						grn_id: grn_id
					},
					url: 'Goodreceive/Getproductinfoamachine',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						// $('#newqty').val(obj.qty);
						$('#qtylabel').html(obj.qty);
						$('#uom').val(obj.uom);
						$('#unitprice').val(obj.unitprice);
						$('#comment').val(obj.comment);
					}
				});
			}else if (grntype == 1) {
				$.ajax({
					type: "POST",
					data: {
						recordID: productID,
						grn_id: grn_id
					},
					url: 'Goodreceive/Getproductinfosparepart',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						// $('#newqty').val(obj.qty);
						$('#qtylabel').html(obj.qty);
						$('#uom').val(obj.uom);
						$('#unitprice').val(obj.unitprice);
						$('#comment').val(obj.comment);
					}
				});
			}
		});


		// $('#quater').change(function () {
		// 	var quaterID = $(this).val();
		// 	var mfdate = $('#mfdate').val();

		// 	$.ajax({
		// 		type: "POST",
		// 		data: {
		// 			recordID: quaterID,
		// 			mfdate: mfdate
		// 		},
		// 		url: 'Goodreceive/Getexpdateaccoquater',
		// 		success: function (result) { //alert(result);
		// 			$('#expdate').val(result);
		// 		}
		// 	});
		// });

		$('#dataTable tbody').on('click', '.btnLabel', function () {
			var id = $(this).attr('id');
			$('#lablemodal').modal('show');

			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Goodreceive/Getmateriallistaccogrn',
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
					$('#materiallist').empty().append(html1);
				}
			});

			// $.ajax({
			// 	type: "POST",
			// 	data: {
			// 		recordID: id
			// 	},
			// 	url: '<?php echo base_url() ?>Goodreceive/Getgrninfoaccogrnid',
			// 	success: function (result) { //alert(result);
			// 		// console.log(result);
			// 		var obj = JSON.parse(result);
			// 		$('#grnno').val('UN|GRN-0000' + id);
			// 		$('#pono').val('UN|POD-0000' + obj
			// 			.tbl_print_porder_idtbl_print_porder);
			// 		$('#lmfdate').val(obj.mfdate);
			// 		$('#lexpdate').val(obj.expdate);
			// 		$('#lbatchno').val(obj.batchno);
			// 	}
			// });
		});
		// $('#materiallist').change(function () {
		// 	let optiontitle = $("#materiallist option:selected").text();
		// 	var result = optiontitle.split('/');
		// 	$('#mname').val(result[0]);
		// 	$('#mcode').val(result[1]);
		// });
		$('#btncreatelable').click(function () {
			if (!$("#formlable")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidesubmitbtn").click();
			} else {
				let mname = $('#mname').val();
				let mcode = $('#mcode').val();
				let grnno = $('#grnno').val();
				let pono = $('#pono').val();
				let mfdate = $('#lmfdate').val();
				let expdate = $('#lexpdate').val();
				let batchno = $('#lbatchno').val();

				var link = '<?php echo base_url() ?>Goodreceive/Createlabel/' + mname + '/' +
					mcode + '/' +
					grnno + '/' + pono + '/' + mfdate + '/' + expdate + '/' + batchno;
				window.open(link, '_blank');
				$('#hideresetbtn').click();
				$('#lablemodal').modal('hide');
			}
		});
	});

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to approve this good receive note Voucher?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to reject this good receive note Voucher?");
	}

	// function subtotatalcalculate() {
	// 	var discount = parseFloat($("#discount").val());
	// 	var total = parseFloat($("#hidetotalorder").val());
	// 	var finalsubtot = total - discount

	// 	$('#hiddenfulltotal').val(finalsubtot.toFixed(2));
	// }

	// function defultsubtotatal() {
	// 	var defultnetsale = parseFloat($("#hidetotalorder").val());

	// 	$('#hiddenfulltotal').val(defultnetsale.toFixed(2));

	// }

	function finaltotalcalculate() {
		var vat = parseFloat($("#vat").val());
		var discount = parseFloat($("#discount").val());
		var total = parseFloat($("#hidetotalorder").val());

		if (isNaN(discount)) {
			discount = 0;
			$("#discount").val(0);
		}

		if (isNaN(vat)) {
			vat = 0;
			$("#vat").val(0);
		}

		// subtotal calculation
		var finalsubtot = total - discount
		$('#hiddenfulltotal').val(finalsubtot.toFixed(2))

		// vat calculaton
		var vatamount = parseFloat((finalsubtot / 100) * vat);
		var finaltotal = finalsubtot + vatamount



		$('#modeltotalpayment').val(finaltotal.toFixed(2));
	}

	// function defultfinaltotal() {
	// 	var defultfinaltotal = parseFloat($("#hiddenfulltotal").val());

	// 	$('#modeltotalpayment').val(defultfinaltotal.toFixed(2));

	// }




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
<script>
	function getVat() {
		var currentDate = $('#grndate').val();

		$.ajax({
			type: "POST",
			data: {
				currentDate: currentDate,
			},
			url: 'Goodreceive/Getvatpresentage',
			success: function (result) { //alert(result);
				var obj = JSON.parse(result);

				$('#vat').val(obj);
			}
		});
	}

</script>
<?php include "include/footer.php"; ?>
