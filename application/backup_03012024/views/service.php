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
							<div class="page-header-icon"><i data-feather="car"></i></div>
							<span><b>Service Details</b></span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<form id="addserviceform" action="<?php echo base_url() ?>Service/serviceinsertupdate"
							method="post" autocomplete="off" enctype="multipart/form-data">
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Service Type*</label>
										<select class="form-control form-control-sm" name="servicetype" id="servicetype"
											required>
											<option value="">Select</option>
											<option value="1">Repair</option>
											<option value="2">Regular Service</option>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group">
										<label class="small font-weight-bold">Supplier*</label>
										<select class="form-control form-control-sm" name="supplier" id="supplier"
											required>
											<option value="">Select</option>
											<?php foreach ($Supplier->result() as $rowsupplier) { ?>
											<option value="<?php echo $rowsupplier->idtbl_supplier ?>">
												<?php echo $rowsupplier->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-3">
									<div class="form-group">
										<label class="small font-weight-bold">Vehicle Reg NO*</label>
										<select class="form-control form-control-sm" name="vehicleregno"
											id="vehicleregno" onchange="getmileage();" required>
											<option value="">Select</option>
											<?php foreach ($VehicleRegNo->result() as $rowvehicleregno) { ?>
											<option value="<?php echo $rowvehicleregno->idtbl_vehicle ?>">
												<?php echo $rowvehicleregno->vehicle_reg_no ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Service Date*</label>
										<input type="date" class="form-control form-control-sm" name="servicedate"
											id="servicedate" value="<?php echo date("Y-m-d"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Service Location*</label>
										<input type="text" class="form-control form-control-sm" name="servicelocation"
											id="servicelocation" required>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Discription*</label>
										<textarea id="discription" name="discription" rows="1"
											class="form-control form-control-sm" required></textarea>
										<!-- <input type="text" rows="4" cols="50" class="form-control form-control-sm"
											name="discription" id="discription" required> -->
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Amount*</label>
										<input type="number" rows="4" cols="50" class="form-control form-control-sm"
											name="amount" id="amount" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Current Mileage*</label>
										<input type="text" rows="4" cols="50" class="form-control form-control-sm"
											name="currentmileage" id="currentmileage" required readonly>
									</div>
								</div>

								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold"> Add Mileage (Km)*</label>
										<input type="number" rows="4" cols="50" class="form-control form-control-sm"
											name="mileage" id="mileage" value="0" onkeyup="calculation();" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Next Service Mileage (Km)*</label>
										<input type="text" rows="4" cols="50" class="form-control form-control-sm"
											name="nextservicemileage" id="nextservicemileage" value="0" readonly>
									</div>
								</div>
							</div>
							<hr>
							<div class="row" style="background-color:#f1f0f0">
								<div class="col-3">
									<div class="form-group">
										<label class="small font-weight-bold">Service Item*</label>
										<select class="form-control form-control-sm" name="serviceitem" id="serviceitem"
											required>
											<option value="">Select</option>
											<?php foreach ($ServiceType->result() as $rowserviceType) { ?>
											<option value="<?php echo $rowserviceType->idtbl_service_item_list ?>">
												<?php echo $rowserviceType->service_type ?></option>
											<?php } ?>
										</select>
										<input type="hidden" name="itemid" class="form-control form-control-sm"
											id="itemid">
										<input type="hidden" name="service_type" class="form-control form-control-sm"
											id="service_type">
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold ">QTY*</label>
										<input type="number" step="any" name="qty" class="form-control form-control-sm"
											id="qty" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mt-4">
										&nbsp; <button type="button" name="BtnAdd" id="BtnAdd"
											class="btn btn-primary btn-m "><i class="fas fa-plus"></i>&nbsp;Add</button>
										<input type="submit" class="d-none" id="hidebtnaddlist">
									</div>
								</div>

								<div class="form-group mt-4">
									<input type="hidden" name="invoiceid" class="form-control form-control-sm"
										id="invoiceid">
									<input type="hidden" name="invoicedeiailsid" class="form-control form-control-sm"
										id="invoicedeiailsid">
									<input type="hidden" name="rowid" class="form-control form-control-sm" id="rowid">
									&nbsp; <button type="button" name="Btnupdatelist" id="Btnupdatelist"
										class="btn btn-primary btn-m " style="display:none;"><i
											class="fas fa-plus"></i>&nbsp;Update List</button>
									<input type="submit" class="d-none" id="hidebtnupdatelist">

								</div>
							</div>

							<div class="row" style="background-color:#f1f0f0">
								<div class="col-12">
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap"
											id="tblserviceitemlist">
											<thead>
												<tr>
													<th>Service Item</th>
													<th>Qty</th>
													<th></th>
												</tr>
											</thead>
											<tbody id="tblserviceitembody">
											</tbody>
										</table>
									</div>
								</div>
							</div>



							<div class="row">
								<div class="col-6">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Bill*</label>
										<div class="filebody">
											<div class="fileuploadcard">
												<div class="top">
													<p>Drag & drop image uploading</p>

												</div>
												<div class="drag-area">
													<span class="visible">
														Drag & drop image here or
														<span class="select" role="button">Browse</span>
													</span>
													<span class="on-drop">Drop images here</span>
													<input name="files[]" id="file" type="file" class="file" multiple />
												</div>

												<!-- IMAGE PREVIEW CONTAINER -->
												<div class="container"></div>
											</div>
										</div>

									</div>
									<!-- <div class="col-6">
										<form id="myForm">
											<input type="file" name="fileimg" id="fileimg">
											<button type="submit">Upload File</button>
										</form>


									</div> -->

								</div>

								<div class="col-1">
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
									<div class="form-group mt-10 text-right">
										<button type="button" id="submitBtn" class="btn btn-primary btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>>
											<i class="far fa-save"></i>&nbsp;Save</button>
									</div>
								</div>
							</div>

						</form>


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
														<th>SERVICE TYPE</th>
														<th>SERVICE DATE</th>
														<th>VEHICLE REG NO</th>
														<th>SERVICE LOCATION</th>
														<th>SUPPLIER</th>
														<th>AMOUNT</th>
														<th>DISCRIPTION</th>

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
<?php include "include/footerscripts.php"; ?>
<script>
	function productDelete(ctl) {
		$(ctl).parents("tr").remove();
	}

	$(document).ready(function () {
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
					title: 'Service Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Service Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Service  Information',
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
				url: "<?php echo base_url() ?>scripts/servicelist.php",
				type: "POST", // you can use GET
				// data: function(d) { }
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
				// {
				// 	"data": "servicetype"
				// },
				{
					"targets": -1,
					"className": 'text-left',
					"data": null,
					"render": function (data, type, full) {
						var text = '';

						if (full['servicetype'] == 1) {
							text += '<label class="font-weight">Repair</label>';
						} else {
							text += '<label class="font-weight">Regular Service</label>';
						}

						return text;
					}
				},
				{
					"data": "service_date"
				},
				{
					"data": "vehicle_reg_no"
				},
				{
					"data": "service_location"
				},
				{
					"data": "name"
				},
				{
					"data": "amount"
				},
				{
					"data": "discription"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href="<?php echo base_url() ?>Servicesitem/index/' + full[
								'idtbl_service'] +
							'" target="_self" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-file"></i></a>';

						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_service'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button += '<a href="<?php echo base_url() ?>Service/servicestatus/' +
								full['idtbl_service'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button += '<a href="<?php echo base_url() ?>Service/servicestatus/' +
								full['idtbl_service'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Service/servicestatus/' + full[
								'idtbl_service'] +
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



		// get item details according to item select
		$(document).on("change", "#serviceitem", function () {
			var item = $("#serviceitem").val();
			$.ajax({
				type: "POST",
				data: {
					recordID: item
				},
				url: '<?php echo base_url() ?>Service/getitem',
				success: function (result) {
					var obj = JSON.parse(result);
					$('#itemid').val(obj.id);
					$('#service_type').val(obj.service_type);

				}
			});
		});

		$(document).on("click", "#BtnAdd", function () {
			if (!$("#addserviceform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidebtnaddlist").click();
				// alert('in');
			} else {

				var itemID = $('#itemid').val();
				var itemtype = $('#service_type').val();
				var qty = $('#qty').val();

				$('#tblserviceitemlist> tbody:last').append('<tr><td class="text-center">' + itemtype +
					'</td><td class="text-center">' + qty + '</td><td class="nettotal d-none">' +
					itemID +
					'</td><td> <button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
				);

			}
		});

		// delete bill row
		$(document).on("click", "#btnDeleterow", function () {
			$("#tblserviceitemlist> tbody").each(function () {
				$(this).parents("tr").remove();

			});
		});









// chat gpt file  upload
		$('#submit').click(function () {
					var formData = new FormData($('#fileimg')[0]);

					$.ajax({
						url: '<?php echo base_url() ?>Service/uploadimg',
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,

						success: function (response) { //alert(response);
							action(response);
							$('#resetBtn').click();
						}
					});
				});









		// bill data submit for process data
		$(document).on("click", "#submitBtn", function () {

			// get table data into array
			var tbody = $('#tblserviceitemlist tbody');
			if (tbody.children().length > 0) {
				var jsonObj = []
				$("#tblserviceitemlist tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});







			}
			var date = $('#date').val();
			var servicetype = $('#servicetype').val();
			var servicedate = $('#servicedate').val();
			var vehicleregno = $('#vehicleregno').val();
			var servicelocation = $('#servicelocation').val();
			var amount = $('#amount').val();
			var discription = $('#discription').val();
			var supplier = $('#supplier').val();
			var currentmileage = $('#currentmileage').val();
			var mileage = $('#mileage').val();
			var nextservicemileage = $('#nextservicemileage').val();
			var file = $('#file').val();
			var recordOption = $('#recordOption').val();
			var recordID = $('#recordID').val();
			$.ajax({
				type: "POST",
				data: {
					tableData: jsonObj,
					servicetype: servicetype,
					servicedate: servicedate,
					vehicleregno: vehicleregno,
					servicelocation: servicelocation,
					amount: amount,
					discription: discription,
					supplier: supplier,
					currentmileage: currentmileage,
					mileage: mileage,
					nextservicemileage: nextservicemileage,
					file: file,
					recordID: recordID,
					recordOption: recordOption,

				},
				url: '<?php echo base_url() ?>Service/serviceinsertupdate',
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

		$('#dataTable tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');

				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Service/serviceedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#servicetype').val(obj.servicetype);
						$('#servicedate').val(obj.servicedate);
						$('#vehicleregno').val(obj.vehicleregno);
						$('#servicelocation').val(obj.servicelocation);
						$('#amount').val(obj.amount);
						$('#discription').val(obj.discription);
						$('#supplier').val(obj.supplier);
						$('#currentmileage').val(obj.currentmileage);
						$('#mileage').val(obj.mileage);
						$('#nextservicemileage').val(obj.nextservicemileage);
						// $('#bill').val(obj.bill); 
						// $('#comment').val(obj.comment); 

						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});
	});


	function uploadFile() {
		const fileInput = document.getElementById('file');
		const file = fileInput.files[0];
		const formData = new FormData();
		formData.append('file', file);
		$.ajax({
			url: '/upload',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function (data) {
				// handle success
			},
			error: function (xhr, textStatus, errorThrown) {
				// handle error
			}
		});
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

</script>

<script>
	/** Variables */
	let files = [],
		dragArea = document.querySelector('.drag-area'),
		input = document.querySelector('.drag-area input'),
		button = document.querySelector('.card button'),
		select = document.querySelector('.drag-area .select'),
		container = document.querySelector('.container');

	/** CLICK LISTENER */
	select.addEventListener('click', () => input.click());

	/* INPUT CHANGE EVENT */
	input.addEventListener('change', () => {
		let file = input.files;

		// if user select no image
		if (file.length == 0) return;

		for (let i = 0; i < file.length; i++) {
			if (file[i].type.split("/")[0] != 'image') continue;
			if (!files.some(e => e.name == file[i].name)) files.push(file[i])
		}

		showImages();
	});

	/** SHOW IMAGES */
	function showImages() {
		container.innerHTML = files.reduce((prev, curr, index) => {
			return `${prev}
		    <div class="image">
			    <span onclick="delImage(${index})">&times;</span>
			    <img src="${URL.createObjectURL(curr)}" />
			</div>`
		}, '');
	}

	/* DELETE IMAGE */
	function delImage(index) {
		files.splice(index, 1);
		showImages();
	}

	/* DRAG & DROP */
	dragArea.addEventListener('dragover', e => {
		e.preventDefault()
		dragArea.classList.add('dragover')
	})

	/* DRAG LEAVE */
	dragArea.addEventListener('dragleave', e => {
		e.preventDefault()
		dragArea.classList.remove('dragover')
	});

	/* DROP EVENT */
	dragArea.addEventListener('drop', e => {
		e.preventDefault()
		dragArea.classList.remove('dragover');

		let file = e.dataTransfer.files;
		for (let i = 0; i < file.length; i++) {
			/** Check selected file is image */
			if (file[i].type.split("/")[0] != 'image') continue;

			if (!files.some(e => e.name == file[i].name)) files.push(file[i])
		}
		showImages();
	});

</script>
<script>
	function calculation() {

		var currentmileage = parseFloat($("#currentmileage").val());
		var mileage = parseFloat($("#mileage").val());

		if (!(currentmileage || mileage) == "") {
			var nextservicemileage = currentmileage + mileage
			$("#nextservicemileage").val(nextservicemileage.toFixed(2));
		}
	}


	function getmileage() {
		var vehicleregno = $("#vehicleregno").val();
		if (!vehicleregno == "") {
			$.ajax({
				type: "POST",
				data: {
					recordID: vehicleregno
				},
				url: '<?php echo base_url() ?>Service/mileage',
				success: function (result) {
					var obj = JSON.parse(result);
					$('#currentmileage').val(obj.currentmileage);
				}
			});
		} else {
			$('#currentmileage').val('0');
			$('#mileage').val('0');
			$('#nextservicemileage').val('0');
		}

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
				'<button type="button" aria-hidden="true" class="close" data-notify="dismiss"></button>' +
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
// chat gpt file  upload
	$('#myForm').submit(function (e) {
		e.preventDefault();
		uploadFile();
	});

</script>


<?php include "include/footer.php"; ?>
