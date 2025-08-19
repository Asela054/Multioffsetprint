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
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="shopping-cart"></i></div>
							<span>Customer Inquiry</span>
						</h1>
					</div>
				</div>
			</div>
			<style>
				.disabled-pointer-events {
					pointer-events: none;
				}

			</style>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-3">
								<form method="post" autocomplete="off" id="addjobform">
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Date*</label>
										<input type="date" class="form-control form-control-sm"
											value="<?php echo date("Y-m-d"); ?>" name="date" id="date" required>
									</div>
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Po No*</label>
										<input type="text" class="form-control form-control-sm" name="ponumber"
											id="ponumber">
									</div>
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Customer *</label>
										<select class="form-control form-control-sm selecter2 px-0" name="customer"
											id="customer" required>
											<option value="">Select</option>
											<?php foreach($customerlist->result() as $rowcustomerlist){ ?>
											<option value="<?php echo $rowcustomerlist->idtbl_customer ?>">
												<?php echo $rowcustomerlist->name?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Job :</label>
											<select class="form-control form-control-sm  selecter2 px-0" name="job"
												id="job" required>
												<option value="">Select</option>

											</select>
										</div>
									</div>
									<div class="col-12">
										<div class="form-row mb-1">
											<div class="col">
												<label class="small font-weight-bold text-dark">QTY :</label>
												<input type="number" step="any" name="qty"
													class="form-control form-control-sm" id="qty" required>
											</div>
											<div class="col">
												<label class="small font-weight-bold text-dark">UOM :</label>
												<input type="text" name="uom"
													class="form-control form-control-sm" id="uom" required readonly>
												<input type="text" name="uom_id"
													class="form-control form-control-sm" id="uom_id" required readonly hidden>
											</div>
										</div>
									</div>

									<div class="col-12">
										<label class="small font-weight-bold text-dark">Unit Price</label>
										<!-- <label2 class="small font-weight-bold text-dark">Amount</label2> -->
										<input type="number" id="unitprice" name="unitprice"
											class="form-control form-control-sm" value="0" step="any">
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Comments :</label>
											<input type="text" name="comment" class="form-control form-control-sm"
												id="comment" required>
										</div>
									</div>


									<div class="form-group mt-2">
										&nbsp; <button type="button" name="BtnAdd" id="BtnAdd"
											class="btn btn-primary btn-m "><i class="fas fa-plus"></i>&nbsp;Add</button>
										<input type="submit" class="d-none" id="hidebtnaddlist">
									</div>

									<div class="form-group mt-2">
										<input type="hidden" name="invoiceid" class="form-control form-control-sm"
											id="invoiceid">
										<input type="hidden" name="invoicedeiailsid"
											class="form-control form-control-sm" id="invoicedeiailsid">
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
									<table class="table table-bordered table-striped table-sm nowrap" id="tbljoblist">
										<thead>
											<tr>
												<th>Job</th>
												<th class="text-center">Qty</th>
												<th class="text-center">UOM</th>
												<th class="text-center">Unitprice</th>
												<th class="text-center">Comments</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody id="tbljobinquarybody">
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
									<table class="table table-bordered table-striped table-sm nowrap" id="tblcustomer">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>Date</th>
												<th>Po Number</th>
												<th>Job</th>
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
							<table class="table table-bordered table-striped table-sm nowrap" id="tbljoblist">
								<thead>
									<tr>
										<th>Job</th>
										<th>Qty</th>
										<th>UOM</th>
										<th>Unitprice</th>
										<th>Comments</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="tblbodyshowdetails">
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

		$('#customer').select2({
			width: '100%',
		});
		$('#job').select2({
			width: '100%',
		});

		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		$('#tblcustomer').DataTable({
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
				url: "<?php echo base_url() ?>scripts/customerinquarylist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_customerinquiry"
				},
				{
					"data": "name"
				},
				{
					"data": "date"
				},
				{
					"data": "po_number"
				},
				{
					"data": "job"
				},


				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-dark btn-sm btnView mr-1" id="' + full[
							'idtbl_customerinquiry'] + '"><i class="fas fa-eye"></i></button>';
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_customerinquiry'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>Customerinquiry/Customerinquirystatus/' +
								full['idtbl_customerinquiry'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Customerinquiry/Customerinquirystatus/' +
								full['idtbl_customerinquiry'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button +=
							'<a href="<?php echo base_url() ?>Customerinquiry/Customerinquirystatus/' +
							full['idtbl_customerinquiry'] +
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
				var jobID = $('#job').val();
				var job = $("#job option:selected").text();
				var qty = $('#qty').val();
				var uom = $('#uom').val();
				var uomID = $('#uom_id').val();
				var unitprice = $('#unitprice').val();
				var comment = $('#comment').val();
				var recordID = $('#recordID').val();

				var insertmethod = "NewRow";

				$('#tbljoblist> tbody:last').append('<tr><td name="job">' +
					job + '</td><td class="text-center">' + qty + '</td><td class="text-center" name="uom">' +
					uom + '</td><td class="text-center">' +
					unitprice + '</td><td class="text-center">' + comment +
					'</td><td name="jobid" class="d-none">' + jobID +
					'</td><td name="uomid" class="d-none">' + uomID +
					'</td><td class="text-center d-none">' + insertmethod +
					'</td><td class="text-center d-none">' + recordID +
					'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
				);
				$('#job').val('');
				$('#customer').next('.select2-container').first().addClass('disabled-pointer-events');
				resetfeild();

			}
		});


		// bill data submit for process data
		$(document).on("click", "#Btnsubmit", function () {

			// get table data into array
			var tbody = $('#tbljoblist tbody');
			if (tbody.children().length > 0) {
				var jsonObj = []
				$("#tbljoblist tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});
			}
			// console.log(jsonObj);
			var date = $('#date').val();
			var ponumber = $('#ponumber').val();
			var customer = $('#customer').val();
			var recordOption = $('#recordOption').val();
			var recordID = $('#recordID').val();



			$.ajax({
				type: "POST",
				data: {
					tableData: jsonObj,
					date: date,
					ponumber: ponumber,
					customer: customer,
					recordOption: recordOption,
					recordID: recordID
				},
				url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryinsertupdate',
				success: function (result) {
					//console.log(result);
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
					url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#date').val(obj.date);
						$('#ponumber').val(obj.po_number);
						$('#customer').val(obj.customer).trigger('change');
						$('#recordOption').val('2');
						$('#Btnsubmit').html('<i class="far fa-save"></i>&nbsp;Update');

					}
				});
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryjobedit',
					success: function (result) { //alert(result);
						$('#tbljobinquarybody').html(result);
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
				url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryviewjoblist',
				success: function (result) { //alert(result);
					$('#tblbodyshowdetails').html(result);
					$('#viewModel').modal('show');

				}
			});

		});

		// edit JOB list table

		$(document).on('click', '.btnEditlist', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');

				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryjoblistedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#invoicedeiailsid').val(obj.id);
						// $('#job').val(obj.job);
						$('#job').val(obj.job_id);
						$('#qty').val(obj.qty);
						$('#uom').val(obj.uom);
						$('#uom_id').val(obj.uom_id);
						$('#unitprice').val(obj.unitprice);
						$('#comment').val(obj.comments);
						$('#invoiceid').val(obj.idtbl_customerinquiry);
						$('#Btnupdatelist').show();
						$('#BtnAdd').hide();
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

				var jobID = $('#job').val();
				var job = $("#job option:selected").text();
				var qty = $('#qty').val();
				var uom = $('#uom').val();
				var uomID = $('#uom_id').val();
				var unitprice = $('#unitprice').val();
				var comment = $('#comment').val();
				var invoiceid = $('#invoiceid').val();
				var invoicedetailid = $('#invoicedeiailsid').val();
				var insertmethod = "Updated";

				$("#tbljoblist> tbody").find('input[name="hiddenid"]').each(function () {
					var idhidden = $(this).val();
					if (idhidden == invoicedetailid) {
						$(this).parents("tr").remove();
					}

				});

				$('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job +
					'</td><td class="text-center">' + qty + '</td><td class="text-center" name="uom">' +
					uom + '</td><td class="text-center">' +
					unitprice + '</td><td class="text-center">' + comment +
					'</td><td name="jobid" class="d-none">' + jobID +
					'</td><td name="uomid" class="d-none">' + uomID +
					'</td><td class="text-center d-none">' + insertmethod +
					'</td><td class=" d-none">' + invoiceid + '</td><td class=" d-none">' +
					invoicedetailid +
					'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
				);


				$('#Btnupdatelist').hide();
				$('#BtnAdd').show();
				resetfeild();
			}
		});

	});

	$('#customer').change(function () {
		var customerID = $(this).val();
		$('#job').empty();
		$('#job').prepend('<option value="" selected="selected">Select job</option>');
		$('#job').val(null).trigger('change');
		// get jobs
		//alert(customerID);
		$.ajax({
			type: "POST",
			data: {
				recordID: customerID
			},
			url: 'Customerinquiry/Getcustomejobs',
			success: function (result) {
				//alert(result);
				// console.log(result);
				var obj = JSON.parse(result);
				var html1 = '';
				html1 += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					html1 += '<option value="' + obj[i]
						.idtbl_customer_job_details + '">';
					html1 += obj[i].job_name;
					html1 += '</option>';
				});
				$('#job').empty().append(html1);
				// $('#uom').empty().append(html1);
			}
		});


	});

	$('#job').change(function () {
		var jobID = $(this).val();
		// $('#job').empty();
		// $('#job').prepend('<option value="" selected="selected">Select job</option>');
		// $('#job').val(null).trigger('change');
		// get jobs
		//alert(customerID);
		$.ajax({
			type: "POST",
			data: {
				recordID: jobID
			},
			url: 'Customerinquiry/Getjobuom',
			success: function (result) {
				// alert(result);
				// console.log(result);
				var obj = JSON.parse(result);
				$('#uom').val(obj.measure_type);
				$('#uom_id').val(obj.measure_type_id);
				$('#unitprice').val(obj.unitprice);

			}
		});


	});

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
		document.getElementById("job").value = "";
		document.getElementById("qty").value = "";
		document.getElementById("unitprice").value = "";
		document.getElementById("comment").value = "";
		document.getElementById("uom_id").value = "";
		document.getElementById("uom").value = "";

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
