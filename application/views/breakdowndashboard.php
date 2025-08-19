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
							<span>Breakdown Dashboard</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row row-cols-1 row-cols-md-4">
							<div class="col mb-3">
								<div class="card shadow-none border-danger card-icon p-0">
									<div class="row no-gutters h-100 m-2">
										<div class="col-auto card-icon-aside-new text-danger">
											<i class="fa fa-wrench"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<h1 class=" text-danger my-1">
													<?php echo $newBreakdown; ?>
												</h1>
												<h6 class="card-title m-0 small">New</h6>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-danger" role="progressbar"
														style="width: <?php echo $newBreakdown; ?>%;"
														aria-valuenow="<?php echo 5 ?>" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col mb-3">
								<div class="card shadow-none border-info card-icon p-0">
									<div class="row no-gutters h-100 m-2">
										<div class="col-auto card-icon-aside-new text-info">
											<i class="fa fa-handshake"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<h1 class=" text-info my-1">
													<?php echo $acceptedbreakdown; ?>
												</h1>
												<h6 class="card-title m-0 small">Accepted</h6>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-info" role="progressbar"
														style="width: <?php echo $acceptedbreakdown; ?>%;"
														aria-valuenow="<?php echo $acceptedbreakdown; ?>"
														aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col mb-3">
								<div class="card shadow-none border-success card-icon p-0">
									<div class="row no-gutters h-100 m-2">
										<div class="col-auto card-icon-aside-new text-success">
											<i class="fas fa-check"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<h1 class=" text-success my-1">
													<?php echo $fixedBreakdowns; ?>
												</h1>
												<h6 class="card-title m-0 small">Fixed</h6>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: <?php echo $fixedBreakdowns; ?>%;"
														aria-valuenow="<?php echo 5 ?>" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col mb-3">
								<div class="card shadow-none border-warning card-icon p-0">
									<div class="row no-gutters h-100 m-2">
										<div class="col-auto card-icon-aside-new text-warning">
											<i class="fa fa-hourglass-end"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<h1 class="text-warning my-1">
													<?php echo $fixedAndNotStarted; ?>
												</h1>
												<h6 class="card-title m-0 small">Fixed & Not started</h6>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-warning" role="progressbar"
														style="width: <?php echo $fixedAndNotStarted;  ?>%;"
														aria-valuenow="<?php echo $fixedAndNotStarted;  ?>"
														aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="tblbreakdown">
										<thead>
											<tr>
												<th>#</th>
												<th>Machine</th>
												<th>Machine Code</th>
												<th>Date</th>
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

		$('#tblbreakdown').DataTable({
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
					title: 'Customer Inquiry  For Approve  Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Customer Inquiry  For Approve  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Customer Inquiry  For Approve Information',
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
				url: "<?php echo base_url() ?>scripts/machinebreakdownlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_machine_breakdown"
				},
				{
					"data": "machine"
				},
				{
					"data": "machinecode"
				},
				{
					"data": "insertdatetime"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						if (full['acceptstatus'] == 0) {
							button +=
								'<a href="<?php echo base_url() ?>BreakDownDashboard/AcceptBreakDown/' +
								full['idtbl_machine_breakdown'] +
								'" onclick="return accept_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fa fa-tools"></i></a>';
						} else {
							button += '<button target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fa fa-tools"></i></button>';
						}
						if (full['status'] == 0 && full['acceptstatus'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>BreakDownDashboard/CompleteBreakdown/' +
								full['idtbl_machine_breakdown'] + '/' + full[
									'tbl_machine_allocation_idtbl_machine_allocation'] +
								' " onclick="return complete_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fa fa-times-circle"></i></a>';
						} else if (full['status'] == 1 && full['acceptstatus'] == 1) {
							button += '<button target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fa fa-check"></i></button>';
						}

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

				var job = $('#job').val();
				var qty = $('#qty').val();
				var comment = $('#comment').val();

				$('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job +
					'</td><td class="text-center">' + qty + '</td><td class="text-center">' + comment +
					'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
				);

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
				url: '<?php echo base_url() ?>Customerinquiryforapprove/Customerinquiryapproveinsertupdate',
				success: function (result) {
					//console.log(result);
					var objfirst = JSON.parse(result);
					if (objfirst.status == 1) {
						setTimeout(function () {
							location.reload();
						}, 500);
					}
					action(objfirst.action)


				}
			});


		});

		$(document).on('click', '.btnView', function () {
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Customerinquiryforapprove/Customerinquiryviewjoblist',
				success: function (result) { //alert(result);
					$('#tblbodyshowdetails').html(result);
					$('#viewModel').modal('show');

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
					url: '<?php echo base_url() ?>Customerinquiryforapprove/Customerinquiryapproveedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#date').val(obj.date);
						$('#ponumber').val(obj.po_number);
						$('#customer').val(obj.customer);
						$('#recordOption').val('2');
						$('#Btnsubmit').html('<i class="far fa-save"></i>&nbsp;Update');
						$('#editmodel').modal('show');
					}
				});
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Customerinquiryforapprove/Customerinquiryapprovejobedit',
					success: function (result) { //alert(result);
						$('#tbljobinquarybody').html(result);
					}
				});
			}
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
					url: '<?php echo base_url() ?>Customerinquiryforapprove/Customerinquiryapprovejoblistedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#invoicedeiailsid').val(obj.id);
						$('#job').val(obj.job);
						$('#qty').val(obj.qty);
						$('#comment').val(obj.comments);
						$('#invoiceid').val(obj.idtbl_machine_breakdown);
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

				var job = $('#job').val();
				var qty = $('#qty').val();
				var comment = $('#comment').val();
				var invoiceid = $('#invoiceid').val();
				var invoicedetailid = $('#invoicedeiailsid').val();

				// $("#tbljoblist> tbody").find('input[name="hiddenid"]').each(function () {
				// 	 var idhidden  = $('#hiddenid').val();
				// 	if(idhidden == invoicedetailid) {
				// 		$("#8").remove();
				// 	}

				// });

				$('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job +
					'</td><td class="text-center">' + qty + '</td><td class="text-center">' + comment +
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

	function approve_confirm() {
		return confirm("Are you sure you want to Approve this?");
	}

	function accept_confirm() {
		return confirm("Are you sure you want to Accept this?");
	}

	function complete_confirm() {
		return confirm("Are you sure that the issue is fixed now");
	}

	function resetfeild() {
		document.getElementById("job").value = "";
		document.getElementById("qty").value = "";
		document.getElementById("comment").value = "";

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

