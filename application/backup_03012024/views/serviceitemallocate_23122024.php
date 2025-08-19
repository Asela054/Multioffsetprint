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
                            <div class="page-header-icon"><i class="fas fa-cog"></i></div>
                            <span>Service Item Allocate</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-3 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" id="addNewAllocateBtn" class="btn btn-dark btn-sm px-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="far fa-save"></i>&nbsp;New Allocate</button>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap small" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service No</th>
                                                <th>Job Type</th>
												<th>Machine Name</th>
                                                <th>Machine Type</th>
												<th>Service Date From</th>
                                                <th>Service Date To</th>
												<th>Factory Code</th>
                                                <th>Estimated Service Hours</th>
                                                <th>Actions</th>
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
<div class="modal fade" id="ServiceItemAllocate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ServiceItemAllocateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ServiceItemAllocateLabel"><i class="fas fa-cog mr-2"></i>New Service Item Allocate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form id="ServiceItemAllocateform" autocomplete="off">
                	<div class="row">
                    	<div class="col-3">
							<div class="form-row mb-1">
                                <div class="col">
									<label class="small font-weight-bold text-black">Service No*</label>
									<select class="form-control form-control-sm" style="width: 100%;" name="serviceNo" id="serviceNo" required>
										<option value="">Select</option>
										<?php foreach ($serviceno->result() as $row) { ?>
											<?php $formattedServiceNo = 'SRV' . str_pad($row->idtbl_machine_service, 4, '0', STR_PAD_LEFT); ?>
											<option value="<?php echo $row->idtbl_machine_service ?>"><?php echo $formattedServiceNo ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                            <div class="form-row mb-1" id="viewMachineType">
							
                            </div>
							<div class="form-row mb-1" id="viewMachineName">
							
                            </div>
						</div>
						<div class="col-9">
							<div class="scrollbar pb-3" id="style-3">
								<table class="table table-striped table-bordered table-sm small" id="view_tableorder">
									<thead>
										<tr>
											<th class="d-none">Spare Part ID</th>
											<th>Spare Part</th>
											<th>Estimated Quantity</th>
											<th>Allocated Quantity</th>
											<th>New Allocated Quantity</th>
											<th></th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
						<div class="col-12"><hr>
							<div class="form-row pt-2">
								<div class="col text-right">
									<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {echo 'disabled';} ?>><i class="fas fa-cog mr-2"></i>&nbsp;Add Service Item Allocate</button>
								</div>
							</div>
						</div>
						<input type="submit" class="d-none" id="hidesubmit">
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ViewServiceItemAllocate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ViewServiceItemAllocateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewServiceItemAllocateLabel"><i class="fas fa-cog mr-2"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="scrollbar pb-3" id="style-3">
							<table class="table table-striped table-bordered table-sm small" id="viewAllocatedServiceTable">
								<thead>
									<tr>
										<th>Spare Part</th>
										<th class="text-right">Estimated Quantity</th>
										<th class="text-right">Allocated Quantity</th>
										<th class="text-right">Unit Price</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12"><br>
						<h3>Allocated Records</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="scrollbar pb-3" id="style-3">
							<table class="table table-striped table-bordered table-sm small" id="viewAllocatedServiceTableDetails">
								<thead>
									<tr>
										<th>Spare Part</th>
										<th class="text-right">Allocated Quantity</th>
										<th class="text-right">Unit Price</th>
										<th class="text-right">Allocated At</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="EditServiceItemAllocate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="EditServiceItemAllocateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditServiceItemAllocateLabel"><i class="fas fa-cog mr-2"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form id="EditServiceItemAllocateform" autocomplete="off">
					<div class="row">
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-3">
								<table class="table table-striped table-bordered table-sm small" id="editAllocatedServiceTable">
									<thead>
										<tr>
											<th class="d-none">Spare Part ID</th>
											<th>Spare Part</th>
											<th class="text-right">Estimated Quantity</th>
											<th class="text-right">Allocated Quantity</th>
											<th class="text-right">Unit Price</th>
											<th></th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
						<div class="col-12"><hr>
							<div class="form-row pt-2">
								<div class="col text-right">
									<button type="button" id="editformsubmit" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {echo 'disabled';} ?>><i class="fas fa-cog mr-2"></i>&nbsp;Edit Service Item Allocate</button>
								</div>
							</div>
						</div>
						<input type="submit" class="d-none" id="hidesubmit">
						<input type="hidden" name="editServiceID" id="editServiceID">
					</div>
				</form>
			</div>
		</div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {

	var addcheck = '<?php echo $addcheck; ?>';
	var editcheck = '<?php echo $editcheck; ?>';
	var statuscheck = '<?php echo $statuscheck; ?>';
	var deletecheck = '<?php echo $deletecheck; ?>';

	$('#serviceNo').select2({
		dropdownParent: $('#ServiceItemAllocateform')
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
				title: 'Color',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Color',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Color',
				className: 'btn btn-primary btn-sm',
				text: '<i class="fas fa-print mr-2"></i> Print',
				customize: function(win) {
					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				},
			},
			// 'copy', 'csv', 'excel', 'pdf', 'print'
		],
		ajax: {
			url: "<?php echo base_url() ?>scripts/serviceitemallocatelist.php",
			type: "POST",
			// data: function(d) {}
		},
		"order": [
			[0, "desc"]
		],
		"columns": [{
				"data": "idtbl_machine_service"
			},
			{
				"data": function(data, type, full) {
					return "SRV000" + data.idtbl_machine_service;
				}
			},
			{
				"data": null,
				"render": function(data, type, row) {
					if (data.job_type == 1) {
						return 'Service';
					} else {
						return 'Repair';
					}
				}
			},
			{
				"data": "machine"
			},
			{
				"data": "type"
			},
			{
				"data": "service_date_from"
			},
			{
				"data": "sevice_date_to"
			},
			{
				"data": "factory_code"
			},
			{
				"data": "estimated_sevice_hours"
			},
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function(data, type, full) {
					var button = '';
					button += '<button class="btn btn-dark btn-sm btnView mr-1" id="' + full['idtbl_machine_service'] + '"><i class="fas fa-eye"></i></button>';

					button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
					if (editcheck != 1) {
						button += 'd-none';
					}
					button += '" id="' + full['idtbl_machine_service'] + '"><i class="fas fa-pen"></i></button>';

					return button;
				}
			}
		],
		drawCallback: function(settings) { 
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$('#addNewAllocateBtn').click(function() {
		$('#ServiceItemAllocate').modal('show');
	});

	$('#serviceNo').change(function(){
		var serviceID = $(this).val();
		$('#view_tableorder > tbody').html('');
		$('#viewMachineType').html('');
		$('#viewMachineName').html('');

		$.ajax({
			type: "POST",
			data: {
				recordID: serviceID
			},
			url: '<?php echo base_url() ?>ServiceItemAllocate/Getmachineservicedetails',
			success: function(result) {
				var obj = JSON.parse(result);

				$('#view_tableorder > tbody').html(obj.view);
				$('#viewMachineType').html(obj.viewmachinetype);
				$('#viewMachineName').html(obj.viewmachinename);
			}
		});
	});

	$('#view_tableorder').on('input', 'input[name^="newAllocatedQuantity"]', function () {
		var $row = $(this).closest('tr'); 
		var estimatedQuantity = parseInt($row.find('input[name^="estimatedQuantity"]').val().trim());
		var allocatedQuantity = parseInt($row.find('input[name^="allocatedQuantity"]').val().trim());
		var newAllocatedQty = parseInt($(this).val());

		var allocatedQty = estimatedQuantity - allocatedQuantity;

		if (isNaN(newAllocatedQty) || newAllocatedQty < 0 || allocatedQty < newAllocatedQty) {
        	$(this).addClass('is-invalid');
		} else {
			$(this).removeClass('is-invalid');
		}
	});

	$("#formsubmit").click(function() {
		if(!$('#ServiceItemAllocateform')[0].checkValidity()){
			$('#hidesubmit').click();
		}
		else{
			var serviceID = $('#serviceNo').val();
			var allocatedDetails = [];
            $('#view_tableorder tbody tr').each(function () {
				var sparepartID = $(this).find('td:eq(0)').text();
				var estimatedQuantity = parseInt($(this).find('input[name^="estimatedQuantity"]').val().trim());
				var allocatedQuantity = parseInt($(this).find('input[name^="allocatedQuantity"]').val().trim());
				var newAllocatedQty = $(this).find('input[name^="newAllocatedQuantity"]').val();

				var allocatedQty = estimatedQuantity - allocatedQuantity;

				if(allocatedQty<newAllocatedQty){
                	alert('Exceeded New Allocated Quantity');
					return false;
				}
				if( newAllocatedQty==0){
					alert('New Allocated QTY 0');
					return false;
				}

				allocatedDetails.push({
					sparepartID: sparepartID,
					newAllocatedQty: newAllocatedQty
				});
			});

			$.ajax({
				type: "POST",
				data: {
					serviceID: serviceID,
					allocatedDetails: allocatedDetails
				},
				url: '<?php echo base_url() ?>ServiceItemAllocate/ServiceItemAllocateinsert',
				success: function(result) {
					var obj = JSON.parse(result);
					if (obj.status == 1) {
					setTimeout(function() {
						window.location.reload();
					}, 2000);
				}
				action(obj.action)
				}
			});
		}
	});

	$('#view_tableorder,#editAllocatedServiceTable').on('click', '.btnRowRemove', function() {
		var r = confirm("Are you sure, You want to remove this ? ");
		if (r == true) {
			$(this).closest('tr').remove();
		}
	});

	$('#dataTable tbody').on('click', '.btnView', function() {
		var id = $(this).attr('id');
		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>ServiceItemAllocate/AllocatedServiceItemView',
			success: function(result) {
				var obj = JSON.parse(result);
				$('#viewAllocatedServiceTable tbody').html(obj.allocatedService);
				$('#viewAllocatedServiceTableDetails tbody').html(obj.allocatedServiceDetails);

				var newServiceId = 'SRV' + id.toString().padStart(4, '0');
				$('#ViewServiceItemAllocateLabel').html('View Allocated Service Items - '+newServiceId);

				$('#ViewServiceItemAllocate').modal('show');
			}
		});
	});

	$('#dataTable tbody').on('click', '.btnEdit', function() {
		var r = confirm("Are you sure, You want to Edit this ? ");
		if (r == true) {
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>ServiceItemAllocate/ServiceItemAllocateedit',
				success: function(result) {
					var obj = JSON.parse(result);
					$('#editAllocatedServiceTable tbody').html(obj.allocatedServiceEdit);
					var newServiceId = 'SRV' + id.toString().padStart(4, '0');
					$('#EditServiceItemAllocateLabel').html('Edit Allocated Service Items - '+newServiceId);

					$('#EditServiceItemAllocate').modal('show');
					$('#editServiceID').val(obj.serviceID);
				}
			});
		}
	});

	$("#editformsubmit").click(function() {
		if(!$('#EditServiceItemAllocateform')[0].checkValidity()){
			$('#hidesubmit').click();
		}
		else{
			var serviceID = $('#editServiceID').val();
			var allocatedDetails = [];
            $('#editAllocatedServiceTable tbody tr').each(function () {
				var sparepartID = $(this).find('td:eq(0)').text();
				var estimatedQuantity = parseInt($(this).find('input[name^="estimatedQuantity"]').val().trim());
				var allocatedQuantity = parseInt($(this).find('input[name^="allocatedQuantity"]').val().trim());

				allocatedDetails.push({
					sparepartID: sparepartID,
					allocatedQuantity: allocatedQuantity,
					estimatedQuantity: estimatedQuantity
				});
			});

			var quantitiesBySparepartID = {};

			allocatedDetails.forEach(function (detail) {
				var sparepartID = detail.sparepartID;
				var allocatedQty = detail.allocatedQuantity;
				var estimatedQty = detail.estimatedQuantity;

				if (!quantitiesBySparepartID[sparepartID]) {
					quantitiesBySparepartID[sparepartID] = {
						estimatedQuantity: estimatedQty,
						allocatedQuantity: 0
					};
				}

				quantitiesBySparepartID[sparepartID].allocatedQuantity += allocatedQty;
				quantitiesBySparepartID[sparepartID].estimatedQuantity = estimatedQty;
			});

			// console.log('Quantities per sparepartID:');
			for (var sparepartID in quantitiesBySparepartID) {
				var estimatedQty = quantitiesBySparepartID[sparepartID].estimatedQuantity;
				var allocatedQty = quantitiesBySparepartID[sparepartID].allocatedQuantity;
				// console.log('SparepartID: ' + sparepartID + ', Estimated Quantity: ' + estimatedQty + ', Allocated Quantity: ' + allocatedQty);

				if(estimatedQty<allocatedQty){
                	alert('Exceeded Allocated Quantity.');
					return false;
				}
			}
			$.ajax({
				type: "POST",
				data: {
					serviceID: serviceID,
					allocatedDetails: allocatedDetails
				},
				url: '<?php echo base_url() ?>ServiceItemAllocate/ServiceItemAllocateupdate',
				success: function(result) {
					var obj = JSON.parse(result);
					if (obj.status == 1) {
					setTimeout(function() {
						window.location.reload();
					}, 2000);
				}
				action(obj.action)
				}
			});
		}
	});
});

function action(data) {
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
		delay: 500,
		timer: 100,
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
