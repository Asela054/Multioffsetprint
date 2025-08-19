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
							<span>Job Details(Job = <?php echo json_decode($jobDetails,true)[0]['job']; ?>)</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-3">
								<form action="<?php echo base_url() ?>Jobdetails/Jobdetailsinsertupdate" method="post"
									autocomplete="off" id="addjobform">
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Cost Item Name :</label>
											<input type="text" name="costitemname" class="form-control form-control-sm"
												id="costitemname" required>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">QTY :</label>
											<input type="number" step="any" name="qty"
												class="form-control form-control-sm" id="qty" required>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Comments :</label>
											<input type="text" name="comment" class="form-control form-control-sm"
												id="comment" required>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold">Machine*</label>
											<select class="form-control form-control-sm" name="machineSteps"
												id="machineSteps" required>
												<option value="">Select</option>
												<?php foreach ($machineList->result() as $rowMachine) { ?>
												<option value="<?php echo $rowMachine->idtbl_machine ?>">
													<?php echo $rowMachine->machine ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group mt-2">
										&nbsp;
										<button type="button" name="btnSubmitAllocation" id="btnSubmitAllocation"
											class="btn btn-secondary btn-sm "><i
												class="fas fa-plus"></i>&nbsp;Add</button>
										<button type="button" name="btnSubmit" id="btnSubmit"
											class="btn btn-primary btn-sm "><i
												class="fas fa-save"></i>&nbsp;Save</button>

										<input type="submit" class="d-none" id="hidebtnaddlist">

									</div>
									<div class="form-group mt-2">
										<input type="hidden" name="inquirerydetailsId"
											class="form-control form-control-sm" id="inquirerydetailsId"
											value='<?php echo $jobId; ?>' required>

										<input type="hidden" name="recordOption" id="recordOption" value="1">
										<input type="hidden" name="recordID" id="recordID" value="">
									</div>
								</form>

							</div>
							<div class="col-9">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblallocationsteps">
										<thead>
											<tr>
												<th>Step</th>
												<th>Machine</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
								<br>
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="tblcostitems">
										<thead>
											<tr>
												<th>#</th>
												<th>Cost Item name</th>
												<th>Qty</th>
												<th>Estimated Cost</th>
												<th>Comments</th>
												<th>Action</th>
											</tr>
										</thead>
									</table>
								</div>
								<br>
								<br>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- View details Modal -->
			<div class="modal fade" id="detailsmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
				aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Estimation Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="viewhtml">
								<div class = "row">
									<div class = "col-md-4">
										<h4>Quantity: <span id = 'infoqty'></span></h4>
									</div>
									<div class = "col-md-4">
										<h4>No of Ups: <span id = 'noofups'></span></h4>
									</div>
									<div class = "col-md-4">
										<h4>Wastage: <span id = 'wastagepercentage'></span>%</h4>
									</div>
									<div class = "col-md-4">
										<h4>No of sheets: <span id = 'noofsheets'></span></h4>
									</div>
									<div class = "col-md-4">
										<h4>No of packets: <span id = 'noofpackets'></span></h4>
									</div>
									<div class = "col-md-4">
										<h4>Speed: <span id = 'speed'></span></h4>
									</div>
									<div class = "col-md-4">
										<h4>Total Hours: <span id = 'totalhours'></span></h4>
									</div>
									<div class = "col-md-8">
										<h4>Total Cost: Rs.<span id = 'totalcost'></span></h4>
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
<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		var addcheck = 1;
		var editcheck = 1;
		var statuscheck = 1;
		var deletecheck = 1;
		var jobId = <?php echo $jobId; ?>

		$('#tblcostitems').DataTable({
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
					title: 'Cost Items Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Cost Items  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Cost Items  Information',
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
				type: "POST", // you can use GET
				data: {
					recordId: jobId
				},
				url: "<?php echo base_url() ?>scripts/costitemlist.php"
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_cost_items"
				},
				{
					"data": "costitemname"
				},
				{
					"data": "qty"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						return addCommas(parseFloat(full['total_sum']).toFixed(2));
					}
				},
				{
					"data": "comment"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href = "<?php echo base_url() ?>Jobs/FetchPassedValue/' +
							full['idtbl_cost_items'] +
							'"><button class="btn btn-dark btn-sm btnCost mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_cost_items'] +
							'"><i class="fas fa-plus"></i></button></a>';
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_cost_items'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['total_sum'] != null) {
							button += '<button class="btn btn-secondary btn-sm btnView mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_cost_items'] +
							'"><i class="fas fa-eye"></i></button>';
						}
						if (full['status'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>Jobdetails/Jobdetailsstatus/' +
								full['idtbl_cost_items'] + '/2/' + jobId +
								'" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Jobdetails/Jobdetailsstatus/' +
								full['idtbl_cost_items'] + '/1/' + jobId +
								'" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Jobdetails/Jobdetailsstatus/' +
							full['idtbl_cost_items'] + '/3/' + jobId +
							'" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
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

		$('#tblcostitems tbody').on('click', '.btnView', function () {
			var id = $(this).attr('id');

			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Jobdetails/FetchJobInfo',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					
					$('#infoqty').html(obj.qty)
					$('#noofups').html(obj.noofups)
					$('#wastagepercentage').html(obj.wastagepercentage)
					$('#noofsheets').html(obj.noofsheets)
					$('#noofpackets').html(obj.noofpackets)
					$('#hourcost').html(obj.hourcost)
					$('#speed').html(obj.speed)
					$('#totalhours').html(obj.totalhours)
					$('#totalcost').html(obj.totalcost)

					$('#detailsmodal').modal('show');
				}
			});
		});

		$('#tblcostitems tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Jobdetails/Jobdetailsedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						console.log(obj)
						$('#recordID').val(obj.id);
						$('#costitemname').val(obj.name);
						$('#qty').val(obj.qty);
						$('#comment').val(obj.comment);
						$('#recordOption').val('2');
						var c = 1;

						$.each(obj.arrayList, function (i, item) {
							$('.btnDeleterow').each(function (i, obj) {
								c++;
							});

							$('#tblallocationsteps> tbody:last').append(
								'<tr><td class="d-none text-center">' +
								obj.arrayList[i].machineId +
								'</td><td class="text-center">' + c +
								'</td><td class="text-center">' + obj.arrayList[i]
								.machineName +
								'</td><td> <button type="button" onclick= "productDelete(this);" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
							);
						});

						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});

		$('#btnCost tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Jobdetails/Jobdetailsedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#costitemname').val(obj.name);
						$('#qty').val(obj.qty);
						$('#comment').val(obj.comment);

						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});

		$('#btnSubmitAllocation').click(function () {
			var machineid = $('#machineSteps').val()
			var machinename = $('#machineSteps option:selected').text()
			var c = 1;

			$('.btnDeleterow').each(function (i, obj) {
				c++;
			});

			$('#tblallocationsteps> tbody:last').append('<tr><td class="d-none text-center">' +
				machineid + '</td><td class="text-center">' + c +
				'</td><td class="text-center">' + machinename +
				'</td><td> <button type="button" onclick= "productDelete(this);" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
			);
		})

		$('#btnSubmit').click(function () {
			var tbody = $('#tblallocationsteps tbody');
			if (tbody.children().length > 0) {
				var jsonObj = []
				$("#tblallocationsteps tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});
			}

			var costitemname = $('#costitemname').val()
			var qty = $('#qty').val()
			var comment = $('#comment').val()
			var recordOption = $('#recordOption').val()
			var recordID = $('#recordID').val()
			var inquirerydetailsId = $('#inquirerydetailsId').val()

			$.ajax({
				type: "POST",
				data: {
					tableData: jsonObj,
					costitemname: costitemname,
					qty: qty,
					comment: comment,
					recordOption: recordOption,
					recordID: recordID,
					inquirerydetailsId: inquirerydetailsId,
				},
				url: '<?php echo base_url() ?>Jobdetails/Jobdetailsinsertupdate',
				success: function (result) { //alert(result);
					location.reload()
				}
			});
		})

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

	function resetfeild() {
		document.getElementById("job").value = "";
		document.getElementById("qty").value = "";
		document.getElementById("comment").value = "";

	}

	function productDelete(ctl) {
		$(ctl).parents("tr").remove();
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
