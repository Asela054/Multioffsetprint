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
							<span>Issue Materials</span>
						</h1>
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
										id="tblmaterialissue">
										<thead>
											<tr>
												<th>Quotation Id</th>
												<th>Job</th>
												<th>Job Id</th>
												<th>Job No</th>
												<th>Qty</th>
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
		<!--  view model -->
		<div class="modal fade" id="editmodelview" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
			aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">View Customer Inquary</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">


						<div class="col-12">
							<div class="row">
								<div class="col-4">
									<label class="small font-weight-bold text-dark"> Date*</label>
									<input type="date" class="form-control form-control-sm" name="dateview"
										id="dateview" readonly>
								</div>
								<div class="col-4">
									<label class="small font-weight-bold text-dark"> Po No*</label>
									<input type="text" class="form-control form-control-sm" name="ponumberview"
										id="ponumberview" readonly>
								</div>
								<div class="col-4">
									<label class="small font-weight-bold text-dark"> Customer *</label>
									<input type="text" class="form-control form-control-sm" name="customerview"
										id="customerview" readonly>
								</div>
							</div>

						</div>
						<hr>
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-bordered table-striped table-sm nowrap" id="tbljoblist">
									<thead>
										<tr>
											<th>Job</th>
											<th>Qty</th>
											<th>UOM</th>
											<th>Unitprice</th>
											<th>Job No</th>
											<th>Comments</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody id="tbljobinquarybodyview">
									</tbody>
								</table>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="issuematerialmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Job List</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-12">
								<table class="table table-striped table-bordered table-sm small"
									id="tblmaterialdetails">
									<thead>
										<tr>
											<th>Material</th>
											<th>Qty</th>
											<th>Unit Price</th>
											<th>Total</th>
											<th>Issued Status</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<div class="row">
									<div class="col text-right">
										<h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
									</div>
									<input type="hidden" id="hidetotalorder" value="0">
									<input type="hidden" id="hiddedninquryid" value="0">
								</div>
								<hr>
								<div class="form-group mt-2">
									<button type="button" id="btnissuematerials"
										class="btn btn-outline-primary btn-sm fa-pull-right"><i
											class="fas fa-save"></i>&nbsp;Issue</button>
								</div>
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

		$('#tblmaterialissue').DataTable({
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
					title: 'Approved Customer Inquiry  Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Approved Customer Inquiry  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Approved Customer Inquiry  Information',
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
				url: "<?php echo base_url() ?>scripts/allcustomerquotationlist.php",
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
			"columns": [
				{
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.settings._iRecordsDisplay - meta.row;
                    }
                },
				{
					"data": "job"
				},
				{
					"data": "job_id"
				},
				{
					"data": "job_no"
				},
				{
					"data": "qty"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';

						button += '<button class="btn btn-dark btn-sm btnView mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_jobquatation'] +
						'"><i class="fas fa-eye"></i></button>';
						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#tblmaterialissue tbody').on('click', '.btnView', function () {
			var inquiryId = $(this).attr('id');
			var approvestatus = $(this).data('approvestatus');
			var notissued = 0;
			$('#tblmaterialdetails tbody').empty();
			$('#hiddedninquryid').val(inquiryId)
			$.ajax({
				type: "POST",
				data: {
					inquiryId: inquiryId
				},
				url: '<?php echo base_url(); ?>IssueMaterials/Fetchinsertedmaterials',
				success: function (result) {
					//console.log(result);
					var obj = JSON.parse(result);
					$.each(obj, function (i, item) {

						var sum = obj[i].qty * obj[i].unitprice;
						var showsum = addCommas(parseFloat(sum).toFixed(2));
						var issuedStatusText = obj[i].issued_status == 0 ? 'Not Issued' : 'Issued';

						$('#tblmaterialdetails> tbody:last').append(
							'<tr><td class="text-center">' + obj[i].materialname +
							'</td><td class="text-center">' + obj[i].qty +
							'</td></td><td class="text-center">' + obj[i]
							.unitprice +
							'</td><td class="text-center">' + showsum +
							'</td><td class="d-none">' + obj[i]
							.idtbl_print_material_info +
							'</td><td class="d-none materialtotal">' + sum +
							'</td><td class="d-none">' + obj[i].unitprice +
							'</td><td class="d-none">2</td><td class="d-none">' +
							obj[i].idtbl_inquiry_allocated_materials + '</td><td class="d-none">' +
							obj[i].issued_status + '</td><td class="">' +
							issuedStatusText + '</td></tr>'
							);

							if(obj[i].issued_status == 0){
								notissued = 1;
							}
					});

					calculateMaterialTableTotal()
					$('#issuematerialmodal').modal('show');
					if(notissued == 1){
						$('#btnissuematerials').prop('disabled', false);
					}else{
						$('#btnissuematerials').prop('disabled', true);
					}
				}
			});

		});
	});

	$('#btnissuematerials').click(function () {
		var tbody = $('#tblmaterialdetails tbody');
		if (tbody.children().length > 0) {
			var jsonObj = []
			$("#tblmaterialdetails tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		var inquirydetailsid = $('#hiddedninquryid').val();
		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				inquirydetailsid: inquirydetailsid,
			},
			url: '<?php echo base_url() ?>IssueMaterials/UpdateStockForMaterialIssue',
			success: function (result) {
				//console.log(result);
				var objfirst = JSON.parse(result);
				action(objfirst.action)
				$('#issuematerialmodal').modal('hide');

			}
		});


		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				inquirydetailsid: inquirydetailsid,
			},
			url: '<?php echo base_url() ?>IssueMaterials/ApproveMaterialIssue',
			success: function (result) {
				//console.log(result);
				var objfirst = JSON.parse(result);
				action(objfirst.action)
				$('#issuematerialmodal').modal('hide');

			}
		});
	})

	function calculateMaterialTableTotal() {
		var totsum = 0;
		$("#tblmaterialdetails .materialtotal").each(function () {
			totsum += parseFloat($(this).text());
		});
		var showtotsum = addCommas(parseFloat(totsum).toFixed(2));


		$('#divtotal').html('Rs. ' + showtotsum);
		$('#hidetotalmaterial').val(totsum);
	}

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

	function issue_confirm() {
		return confirm("Are you sure you want to approve this Material Issue?");
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
