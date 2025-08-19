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
							<div class="page-header-icon"><i class="fa fa-check-circle"></i></div>
							<span><b>Approved Internal Item Request</b></span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="container-fluid mt-2 p-0 p-2">
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
																<th>Company</th>
																<th>Department</th>
                                                                <th>Order Type</th>
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
					<h5 class="modal-title" id="staticBackdropLabel">View Internal Item Request</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2 style="margin-bottom: 2px;" class="text-right">Internal Item Request<span id="pr"></span></h2>
					<p style="margin-bottom: 2px;" class="text-right">MO/GRNR-0000<span id="procode"></span></P>

					<div id="viewhtml"></div>
				</div>
				<div class="modal-footer">
					<button type="button" id="printporder" class="btn btn-outline-primary btn-sm fa-pull-right"
						<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Print Internal
						Item Request</button>
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
					title: 'Approved GRN Request Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Approved GRN Request Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Approved GRN Request Information',
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
				url: "<?php echo base_url() ?>scripts/approvedgoodreceiverequestlist.php",
				type: "POST", // you can use GET
				"data": function(d) {
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
					"data": "companyname"
				},
				{
					"data": "departmentname"
				},
				{
					"data": "type"
				},
				{
					"targets": -1,
					"className": '',
					"data": null,
					"render": function (data, type, full) {
						if (full['confirmstatus'] == 1) {
							return '<i class="fas fa-check text-success mr-2"></i>Confirm Order Request';
						} else {
							return 'Not Confirm Order Request';
						}
					}
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';

						button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full[
							'idtbl_grn_req'] + '"><i class="fas fa-eye"></i></button>';
						if (full['confirmstatus'] == 1) {
							button += '<button class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></button>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Goodreceiverequest/Goodreceiverequeststatus/' +
								full['idtbl_grn_req'] +
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
			$('#procode').html(id);
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Goodreceiverequest/Grnorderview',
				success: function (result) { //alert(result);

					$('#porderviewmodal').modal('show');
					$('#viewhtml').html(result);
				}
			});
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
