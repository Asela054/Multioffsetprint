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
							<div class="page-header-icon"><i data-feather="shopping-cart"></i></div>
							<span>New Delivery Plans</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-3">
								<form method="post" autocomplete="off" id="addjobform">
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Inquiry *</label>
										<select class="form-control form-control-sm" name="customerinquiry"
											id="customerinquiry" required>
											<option value="">Select</option>
											<?php foreach($inquirylist->result() as $rowinquirylist){ ?>
											<option value="<?php echo $rowinquirylist->idtbl_customerinquiry ?>">
												<?php echo $rowinquirylist->po_number . ' - ' . $rowinquirylist->name ?>
											</option>
											<?php } ?>
										</select>
									</div>
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Inquiry Details *</label>
										<select class="form-control form-control-sm" name="inquirydetailsid"
											id="inquirydetailsid" required>
											<option value="">Select</option>
										</select>
									</div>
									<!-- <div class="col-12">
										<label class="small font-weight-bold text-dark"> Job *</label>
										<select class="form-control form-control-sm" name="selectjobid" id="selectjobid"
											required>
											<option value="">Select</option>
										</select>
									</div> -->
									<!-- <div class="col-12">
										<label class="small font-weight-bold text-dark"> Required qty*</label>
										<input type="text" class="form-control form-control-sm"
											name="requiredqty" id="requiredqty" readonly>
									</div> -->
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Date*</label>
										<input type="date" class="form-control form-control-sm"
											value="<?php echo date("Y-m-d"); ?>" name="deliverydate" id="deliverydate"
											required>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">QTY :</label>
											<input type="number" step="any" name="qty"
												class="form-control form-control-sm" id="qty" required>
										</div>
									</div>
									<div class="form-group mt-2">
										&nbsp; <button type="button" name="BtnAdd" id="BtnAdd"
											class="btn btn-primary btn-m "><i class="fas fa-plus"></i>&nbsp;Add</button>
										<input type="submit" class="d-none" id="hidebtnaddlist">
									</div>

									<div class="form-group mt-2">
										<input type="hidden" name="hiddendeliveryplanid"
											class="form-control form-control-sm" id="hiddendeliveryplanid">
										<input type="hidden" name="deliveryplandetailsid"
											class="form-control form-control-sm" id="deliveryplandetailsid">
										<input type="hidden" name="rowid" class="form-control form-control-sm"
											id="rowid">
										&nbsp; <button type="button" name="Btnupdatelist" id="Btnupdatelist"
											class="btn btn-primary btn-m " style="display:none;"><i
												class="fas fa-plus"></i>&nbsp;Update List</button>
										<input type="submit" class="d-none" id="hidebtnupdatelist">

									</div>
								</form>

							</div>
							<div class="col-9">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tbldeliverylist">
										<thead>
											<tr>
												<th>Item</th>
												<th>Delivery Date</th>
												<th>Qty</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="tbldeliverylistbody">
										</tbody>
									</table>
								</div>
								<br>
								<div class="row">
									<div class="col-12">
										<div class="form-group mt-2">
											<input type="hidden" name="recordOption" id="recordOption" value="1">
											<input type="hidden" name="recordID" id="recordID" value="">
											<button type="button" name="Btnsubmit" id="Btnsubmit"
												class="btn btn-primary btn-m "><i
													class="far fa-save"></i>&nbsp;Save</button>
										</div>
									</div>
								</div>
								<br>
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
										id="tbldeliveryplans">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>PO-No</th>
												<th>Delivery Id</th>
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
	<!-- view details model -->
	<div class="modal fade" id="viewModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header p-2">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-12">
						<div class="scrollbar pb-3" id="style-2">
							<table class="table table-bordered table-striped table-sm nowrap" id="tbldeliverylist">
								<thead>
									<tr>
										<th>Item</th>
										<th>Delivery Id</th>
										<th>Delivery Date</th>
										<th>Qty</th>
									</tr>
								</thead>
								<tbody id="tblbodyshowdetails">
								</tbody>
							</table>
						</div>
						<div class="scrollbar pb-3 mt-4" id="style-2">
							<h3>Allocated Materials</h3>

							<table class="table table-bordered table-striped table-sm nowrap"
								id="tblallocatedmateriallist">
								<thead>
									<tr>
										<th>Material</th>
										<th>Delivery Id</th>
										<th>Qty</th>
									</tr>
								</thead>
								<tbody id="tblbodytblallocatedmateriallist">
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="allocateMaterialModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Allocate Materials</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
							<form id="materialAllocateForm" autocomplete="off">
								<div class="form-group mb-1">
									<label class="small font-weight-bold text-dark">Plan*</label>
									<select class="form-control form-control-sm" name="plan" id="plan" required>
										<option value="">Select</option>
									</select>
								</div>
								<div class="form-group mb-1">
									<label class="small font-weight-bold text-dark">Product*</label>
									<select class="form-control form-control-sm" name="product" id="product" required>
										<option value="">Select</option>
										<?php foreach($productlist->result() as $rowproductlist){ ?>
										<option value="<?php echo $rowproductlist->idtbl_print_material_info ?>">
											<?php echo $rowproductlist->materialname?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-row mb-1">
									<div class="col">
										<label class="small font-weight-bold text-dark">Qty*</label>
										<input type="text" id="newqty" name="newqty"
											class="form-control form-control-sm" required>
									</div>
								</div>
								<div class="form-group mb-1">
									<label class="small font-weight-bold text-dark">Comment</label>
									<textarea name="comment" id="comment"
										class="form-control form-control-sm"></textarea>
								</div>
								<div class="form-group mt-3 text-right">
									<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
										<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add
										to list</button>
									<input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
								</div>
							</form>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
							<table class="table table-striped table-bordered table-sm small" id="tblAllocation">
								<thead>
									<tr>
										<th>Plan</th>
										<th>Product</th>
										<th>Comment</th>
										<th class="d-none">ProductID</th>
										<th class="d-none">PlanID</th>
										<th class="text-center">Qty</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<hr>
							<div class="form-group">
								<input type="hidden" id="hiddendeliveryId">
							</div>
							<div class="form-group mt-2">
								<button type="button" id="btnAllocate"
									class="btn btn-outline-primary btn-sm fa-pull-right"><i
										class="fas fa-save"></i>&nbsp;Allocate</button>
							</div>
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

		$('#tbldeliveryplans').DataTable({
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
					title: 'Customer Inquiry  Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Customer Inquiry  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Customer Inquiry  Information',
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
				url: "<?php echo base_url() ?>scripts/deliveryplanlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_delivery_plan"
				},
				{
					"data": "name"
				},
				{
					"data": "po_number"
				},
				{
					"data": "specialdeliveryid"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-dark btn-sm btnView mr-1" id="' + full[
							'idtbl_delivery_plan'] + '"><i class="fas fa-eye"></i></button>';
						button +=
							'<button class="btn btn-secondary btn-sm btnAllocate mr-1" id="' +
							full['idtbl_delivery_plan'] + '"><i class="fa fa-bus"></i></button>';
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_delivery_plan'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanstatus/' +
								full['idtbl_delivery_plan'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanstatus/' +
								full['idtbl_delivery_plan'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button +=
							'<a href="<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanstatus/' +
							full['idtbl_delivery_plan'] +
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
			}
		});

		// jobs to table to insert to db
		$(document).on("click", "#BtnAdd", function () {
			if (!$("#addjobform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidebtnaddlist").click();
				// alert('in');
			} else {

				var deliverydate = $('#deliverydate').val();
				var qty = $('#qty').val();
				var comment = $('#comment').val();
				var inquirydetailsid = $('#inquirydetailsid').val();
				var inquirydetailstext = $('#inquirydetailsid option:selected').text();

				$('#tbldeliverylist> tbody:last').append('<tr><td class="d-none">' + inquirydetailsid +
					'</td><td class="text-center">' + inquirydetailstext +
					'</td><td class="text-center">' + deliverydate +
					'</td><td class="text-center">' + qty +
					'</td><td></td class = "d-none">-99<td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
				);

				resetfeild();
			}
		});

		$(document).on("click", ".btnAllocate", function () {
			var id = $(this).attr('id');
			$('#hiddendeliveryId').val(id)
			$('#allocateMaterialModal').modal('show');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('NewDeliveryPlan/GetPlanDetails'); ?>",
				data: {
					recordId: id
				},
				success: function (result) {
					var obj = JSON.parse(result);

					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						// alert(result[i].id);
						html1 += '<option value="' + obj[i]
							.idtbl_delivery_plan_details + '">';
						html1 += obj[i].special_id + '/Qty:' + obj[i].qty;
						html1 += '</option>';
					});
					$('#plan').empty().append(html1);
				}
			});
		});


		// bill data submit for process data
		$(document).on("click", "#Btnsubmit", function () {

			// get table data into array
			var tbody = $('#tbldeliverylist tbody');
			if (tbody.children().length > 0) {
				var jsonObj = []
				$("#tbldeliverylist tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});
			}
			// console.log(jsonObj);
			var customerinquiry = $('#customerinquiry').val();
			// var inquirydetailsid = $('#inquirydetailsid').val();
			// var selectjobid = $('#selectjobid').val();
			var recordOption = $('#recordOption').val();
			var recordID = $('#recordID').val();


			console.log(jsonObj)
			$.ajax({
				type: "POST",
				data: {
					tableData: jsonObj,
					customerinquiry: customerinquiry,
					// inquirydetailsid: inquirydetailsid,
					// selectjobid: selectjobid,
					recordOption: recordOption,
					recordID: recordID
				},
				url: '<?php echo base_url() ?>NewDeliveryPlan/Deliveryplaninsertupdate',
				success: function (result) {
					console.log(result);
					var objfirst = JSON.parse(result);
					if (objfirst.status == 1) {
						setTimeout(function () {
							location.reload();
						}, 1000);
					}
					action(objfirst.action)


				}
			});


		});

		//data edit function
		$(document).on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanedit',
					success: function (result) { //console.log(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#hiddendeliveryplanid').val(obj.id);
						$('#customerinquiry').val(obj.inquiryid);
						// changedCustomerInquiry(obj.inquiryid, obj.inquirydetailid)
						// changedCustomerInquiryDetail(obj.inquirydetailid, obj.costitemid)
						$('#recordOption').val('2');
						$('#Btnsubmit').html('<i class="far fa-save"></i>&nbsp;Update');

					}
				});
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanlistedit',
					success: function (result) { //alert(result);
						$('#tbldeliverylistbody').html(result);
					}
				});
			}
		});

		$(document).on('click', '.btnView', function () {
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanviewjoblist',
				success: function (result) { //alert(result);
					$('#tblbodyshowdetails').html(result);
				}
			});
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanviewmateriallist',
				success: function (result) { //alert(result);
					$('#tblbodytblallocatedmateriallist').html(result);
					$('#viewModel').modal('show');
				}
			});

		});

		// edit JOB list table

		$(document).on('click', '.btnEditlist', function () {
			var r = confirm("Are you sure, You want to Edit this? ");
			if (r == true) {
				var id = $(this).attr('id');

				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>NewDeliveryPlan/Deliveryplanlistitemsedit',
					success: function (result) { // console.log(result);
						var obj = JSON.parse(result);
						$('#deliveryplandetailsid').val(obj.id);
						$('#deliverydate').val(obj.deliverydate);
						$('#qty').val(obj.qty);
						$('#hiddendeliveryplanid').val(obj.idtbl_delivery_plan);
						$('#Btnupdatelist').show();
						$('#BtnAdd').hide();
						changedCustomerInquiry(obj.inquiryId, obj.inquirydetailsId)

						// inquirydetailsId
					}
				});

			}
		});
		// update job  list 
		$(document).on("click", "#Btnupdatelist", function () {
			if (!$("#addjobform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidebtnupdatelist").click();
				// alert('in');
			} else {

				var deliverydate = $('#deliverydate').val();
				var qty = $('#qty').val();
				var hiddendeliveryplanid = $('#hiddendeliveryplanid').val();
				var invoiceid = $('#invoiceid').val();
				var invoicedetailid = $('#deliveryplandetailsid').val();
				var inquirydetailsid = $('#inquirydetailsid').val();
				var inquirydetailstext = $('#inquirydetailsid option:selected').text();




				$('#tbldeliverylist> tbody:last').append('<tr><td class="d-none">' +
					inquirydetailsid +
					'</td><td class="text-center">' + inquirydetailstext +
					'</td><td class="text-center">' + deliverydate +
					'</td><td class="text-center">' + qty +
					'</td><td class = "d-none">-99</td><td class = "d-none">' + invoicedetailid +
					'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
				);


				$('#Btnupdatelist').hide();
				$('#BtnAdd').show();
				resetfeild();
			}
		});

	});

	$("#formsubmit").click(function () {
		if (!$("#materialAllocateForm")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#submitBtn").click();
		} else {
			var productID = $('#product').val();
			var planID = $('#plan').val();
			var comment = $('#comment').val();
			var newqty = $('#newqty').val();
			var product = $("#product option:selected").text();
			var plan = $("#plan option:selected").text();

			$('#tblAllocation > tbody:last').append('<tr class="pointer"><td>' + plan + '</td><td>' + product +
				'</td><td>' + comment + '</td><td class="d-none">' + productID + '</td><td class="d-none">' +
				planID + '</td><td class="text-center">' + newqty + '</td><td class="d-none">' + 1 +
				'</td></tr>');

			$('#product').val('');
			$('#comment').val('');
			$('#newqty').val('');

			$('#product').focus();
		}
	});

	$('#btnAllocate').click(function () { //alert('IN');
		// $('#btnAllocate').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
		var tbody = $("#tblAllocation tbody");

		if (tbody.children().length > 0) {
			jsonObj = [];
			$("#tblAllocation tbody tr").each(function () {
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
				},
				url: 'NewDeliveryPlan/AllocationInsertUpdate',
				success: function (result) { //alert(result);
					console.log(result);
					var obj = JSON.parse(result);
					if (obj.status == 1) {
						$('#allocateMaterialModal').modal('hide');
						setTimeout(window.location.reload(), 3000);
					}
					action(obj.action);
				}
			});
		}

	});

	$('#customerinquiry').change(function () {
		let recordId = $('#customerinquiry :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('NewDeliveryPlan/GetInquiryDetails'); ?>",
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
					html1 += obj[i].job + '/Qty:' + obj[i].qty;
					html1 += '</option>';
				});
				$('#inquirydetailsid').empty().append(html1);
			}
		});
	})

	// $('#inquirydetailsid').change(function () {
	//     let recordId = $('#inquirydetailsid :selected').val();
	//     $.ajax({
	//         type: "POST",
	//         url: "<?php echo site_url('NewDeliveryPlan/GetJobList'); ?>",
	//         data: {
	//             recordId: recordId
	//         },
	//         success: function (result) {
	//             var obj = JSON.parse(result);

	//             var html1 = '';
	//             html1 += '<option value="">Select</option>';
	//             $.each(obj, function (i, item) {
	//                 // alert(result[i].id);
	//                 html1 += '<option value="' + obj[i].idtbl_cost_items + '">';
	//                 html1 += obj[i].costitemname +'/Qty:' + obj[i].qty;
	//                 html1 += '</option>';
	//             });
	//             $('#selectjobid').empty().append(html1);
	//         }
	//     });
	// })

	function changedCustomerInquiry(recordId, inquirydetails) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('NewDeliveryPlan/GetInquiryDetails'); ?>",
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
				$('#inquirydetailsid').empty().append(html1);
				$('#inquirydetailsid').val(inquirydetails)
			}
		});
	}

	// function changedCustomerInquiryDetail(recordId, costitem){
	//     $.ajax({
	//         type: "POST",
	//         url: "<?php echo site_url('NewDeliveryPlan/GetJobList'); ?>",
	//         data: {
	//             recordId: recordId
	//         },
	//         success: function (result) {
	//             var obj = JSON.parse(result);

	//             var html1 = '';
	//             html1 += '<option value="">Select</option>';
	//             $.each(obj, function (i, item) {
	//                 // alert(result[i].id);
	//                 html1 += '<option value="' + obj[i].idtbl_cost_items + '">';
	//                 html1 += obj[i].costitemname +'/Qty:' + obj[i].qty;
	//                 html1 += '</option>';
	//             });
	//             $('#selectjobid').empty().append(html1);
	// 			$('#selectjobid').val(costitem)

	//         }
	//     });
	// }

	function productDelete(ctl) {
		$(ctl).parents("tr").remove();
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

	function resetfeild() {
		$('#deliveryDate').val('')
		$('#qty').val('')
		$('#inquirydetailsid').val('')

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
