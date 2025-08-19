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
							<span>Process Plan</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-3">
								<form method="post"
									autocomplete="off" id="addjobform">
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Cost Item Name :</label>
											<input type="text" name="processplanname" class="form-control form-control-sm"
												id="processplanname" required>
										</div>
									</div>
                                    <div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold">Plan Items*</label>
											<select class="form-control form-control-sm" name="processplanitem"
												id="processplanitem" required>
												<option value="">Select</option>
												<?php foreach ($jobtasklist->result() as $rowJobTaskList) { ?>
												<option value="<?php echo $rowJobTaskList->idtbl_job_task_list ?>">
													<?php echo $rowJobTaskList->name ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Sequence :</label>
											<input type="number" step="any" name="sequence"
												class="form-control form-control-sm" id="sequence" required>
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
											<label class="small font-weight-bold text-dark">No of days :</label>
											<input type="number" step="any" name="noofdates" class="form-control form-control-sm"
												id="noofdates" required>
										</div>
									</div>
									
									<div class="form-group mt-2">
										&nbsp;
										<button type="button" name="btnAddPlanItem" id="btnAddPlanItem"
											class="btn btn-secondary btn-sm "><i
												class="fas fa-plus"></i>&nbsp;Add</button>
										<button type="button" name="btnSubmit" id="btnSubmit"
											class="btn btn-primary btn-sm "><i
												class="fas fa-save"></i>&nbsp;Save</button>

										<input type="submit" class="d-none" id="hidebtnaddlist">

									</div>
									<div class="form-group mt-2">
										<input type="hidden" name="recordOption" id="recordOption" value="1">
										<input type="hidden" name="recordID" id="recordID" value="">
									</div>
								</form>

							</div>
							<div class="col-9">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblTaskSequence">
										<thead>
											<tr>
												<th>Sequence</th>
												<th>Task</th>
												<th>Qty</th>
												<th>No of days</th>
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
									<table class="table table-bordered table-striped table-sm nowrap" id="tblProcessPlan">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
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
		var jobId = 1

		$('#tblProcessPlan').DataTable({
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
				url: "<?php echo base_url() ?>scripts/processplanlist.php"
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_process_plan"
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
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_process_plan'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>Processplan/Processplansstatus/' +
								full['idtbl_process_plan'] + '/2"  onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Processplan/Processplansstatus/' +
								full['idtbl_process_plan'] + '/1 " onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Processplan/Processplansstatus/' +
							full['idtbl_process_plan'] + '/3 " onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
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

		$('#tblProcessPlan tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Processplan/Processplanedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						console.log(obj)
						$('#recordID').val(obj.id);
						$('#processplanname').val(obj.processplanname);
						$('#recordOption').val('2');
						var c = 1;
                        
                        $('#tblTaskSequence tbody').empty()
						$.each(obj.arrayList, function (i, item) {
							$('#tblTaskSequence> tbody:last').append('<tr><td class="d-none text-center">' +
							obj.arrayList[i].taskId + '</td><td class="text-center">' + obj.arrayList[i].sequenceno +
								'</td><td class="text-center">' + obj.arrayList[i].taskName +
								'</td><td class="text-center">' + obj.arrayList[i].qty +
								'</td><td class="text-center">' + obj.arrayList[i].noofdays +
								'</td><td> <button type="button" onclick= "productDelete(this);" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
							);
						});

						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});
		$('#btnAddPlanItem').click(function () {
			var planitemid = $('#processplanitem').val()
			var processitemname = $('#processplanitem option:selected').text()
			var noofdates = $('#noofdates').val()
			var sequence = $('#sequence').val()
			var qty = $('#qty').val()
			var c = 1;

			$('.btnDeleterow').each(function (i, obj) {
				c++;
			});

			$('#tblTaskSequence> tbody:last').append('<tr><td class="d-none text-center">' +
            planitemid + '</td><<td class="text-center">' + sequence + 
				'</td><td class="text-center">' + processitemname +
				'</td><<td class="text-center">' + qty +
				'</td><<td class="text-center">' + noofdates +
				'</td><<td> <button type="button" onclick= "productDelete(this);" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
			);

            $('#processplanitem').val('')
            $('#noofdates').val('')
            $('#sequence').val('')
            $('#qty').val('')
		})

		$('#btnSubmit').click(function () {
			var tbody = $('#tblTaskSequence tbody');
			if (tbody.children().length > 0) {
				var jsonObj = []
				$("#tblTaskSequence tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});
			}

			var processplanname = $('#processplanname').val()
			var recordOption = $('#recordOption').val()
			var recordID = $('#recordID').val()

			$.ajax({
				type: "POST",
				data: {
					tableData: jsonObj,
					processplanname: processplanname,
					recordOption: recordOption,
					recordID: recordID
				},
				url: '<?php echo base_url() ?>Processplan/ProcessPlaninsertupdate',
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
		document.getElementById("noofdates").value = "";

	}

	function productDelete(ctl) {
		$(ctl).parents("tr").remove();
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
