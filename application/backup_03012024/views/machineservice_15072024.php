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
                            <span>Machine Service</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-3 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" id="addMachineServiceBtn" class="btn btn-dark btn-sm px-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="far fa-save"></i>&nbsp;Add Machine Service</button>
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
<div class="modal fade" id="machineservice" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="machineserviceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="machineserviceLabel"><i class="fas fa-cog mr-2"></i>Machine Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form id="machineserviceform" autocomplete="off">
                	<div class="row">
                    	<div class="col-6">
                            <div class="form-row mb-1">
                                <div class="col">
									<label class="small font-weight-bold text-black">Service No*</label>
                                	<input type="text" class="form-control form-control-sm" name="idtbl_machine_service" id="idtbl_machine_service" readonly>
                                </div>
								<div class="col">
									<label class="small font-weight-bold text-black">Job Type*</label><br>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="job_type" id="service" checked value="1">
										<label class="form-check-label" for="service">Service</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="job_type" id="repair" value="2">
										<label class="form-check-label" for="repair">Repair</label>
									</div>
								</div>
                            </div>
                            <div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-black">Service Date From*</label>
                                    <input type="datetime-local" class="form-control form-control-sm" name="service_date_from" id="service_date_from">
                                </div>
                                <div class="col">
									<label class="small font-weight-bold text-black">Service Date To*</label>
                                	<input type="datetime-local" class="form-control form-control-sm" name="sevice_date_to" id="sevice_date_to" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
									<label class="small font-weight-bold text-black">Machine Type*</label>
									<select class="form-control form-control-sm" style="width: 100%;" name="machine_type" id="machine_type" required>
										<option value="">Select</option>
										<?php foreach ($machinetype->result() as $row) { ?>
											<option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col">
									<label class="small font-weight-bold text-black">Machine Name*</label>
									<select class="form-control form-control-sm" style="width: 100%;" name="machine_name" id="machine_name" required>
										<option value="">Select</option>
									</select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
									<label class="small font-weight-bold text-black">Factory Code*</label>
                                    <input type="text" class="form-control form-control-sm" name="factory_code" id="factory_code" readonly>
                                </div>
                                <div class="col">
									<label class="small font-weight-bold text-black">Estimated Hours*</label>
                                    <input type="text" class="form-control form-control-sm" name="estimated_sevice_hours" id="estimated_sevice_hours" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
									<label class="small font-weight-bold text-black">Estimated Service items*</label>
									<select class="form-control form-control-sm" style="width: 100%;" name="service_machine" id="service_machine" required>
										<option value="">Select</option>
									</select>
                                </div>
                                <div class="col">
									<label class="small font-weight-bold text-black">Quantity*</label>
                                    <input type="text" class="form-control form-control-sm" name=">quantity" id="quantity" required>
                                </div>
                            </div>
							<div class="form-row mb-1">
                                <div class="col text-right">
									<button type="button" id="submitdata" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add</button>
                                </div>
                            </div>
						</div>
						<div class="col-6">
							<div class="scrollbar pb-3" id="style-3">
								<table class="table table-striped table-bordered table-sm small" id="view_tableorder">
									<thead>
										<tr>
											<th class="d-none">Service ID</th>
											<th>Estimated Service Items</th>
											<th>Quantity</th>
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
									<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {echo 'disabled';} ?>><i class="fas fa-cog mr-2"></i>&nbsp;Add Machine Service</button>
								</div>
							</div>
						</div>
						<input type="hidden" name="recordOption" id="recordOption" value="1">
						<input type="hidden" name="recordID" id="recordID">
						<input type="submit" class="d-none" id="hidesubmit">
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="servicedetails" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="servicedetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="servicedetailsLabel"><i class="fas fa-cog mr-2"></i>Show Estimated Service Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="showservicedetails">
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

	$('#machine_type').select2({
		dropdownParent: $('#machineservice')
	});
	
	$('#machine_name').select2({
		dropdownParent: $('#machineservice')
	});

	$('#service_machine').select2({
		dropdownParent: $('#machineservice')
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
			url: "<?php echo base_url() ?>scripts/machineservicelist.php",
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

					if (full['status'] == 1) {
						button +=
							'<a href="<?php echo base_url() ?>MachineService/Machineservicestatus/' + full['idtbl_machine_service'] + '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
						if (statuscheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-check"></i></a>';
					} else {
						button +=
							'<a href="<?php echo base_url() ?>MachineService/Machineservicestatus/' + full['idtbl_machine_service'] + '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
						if (statuscheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-times"></i></a>';
					}
					button +=
						'<a href="<?php echo base_url() ?>MachineService/Machineservicestatus/' + full['idtbl_machine_service'] + '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
					if (deletecheck != 1) {
						button += 'd-none';
					}
					button += '"><i class="fas fa-trash-alt"></i></a>';

					return button;
				}
			}
		],
		drawCallback: function(settings) { 
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$('#addMachineServiceBtn').click(function() {
		$('#machineservice').modal('show');

		var dataTable = $('#dataTable').DataTable();
		var lastServiceId = dataTable.rows().data().length > 0 ? dataTable.row(dataTable.rows().data().length - 1).data().idtbl_machine_service : 'SRV0000';
		var numericPart = parseInt(lastServiceId.replace('SRV', ''));
		var newNumericPart = numericPart + 1;
		var newServiceId = 'SRV' + newNumericPart.toString().padStart(4, '0');
		$('#idtbl_machine_service').val(newServiceId);
	});

	$('#machine_type').change(function(){
		$('#machine_name').val('').trigger('change');
		var id = $(this).val();
		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>MachineService/Getmachinename',
			success: function(result) {
				var obj = JSON.parse(result);
				var html = '';
				html += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					html += '<option value="' + obj[i].idtbl_machine +'">' + obj[i].machine + '</option>';
				});
				$('#machine_name').empty().append(html);

				$('#machine_type').trigger('machineNameLoaded');
			}
		});

		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>MachineService/Getsparepartname',
			success: function(result) {
				var obj = JSON.parse(result);
				console.log(obj);
				var html = '';
				html += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					html += '<option value="' + obj[i].idtbl_spareparts +'">' + obj[i].spare_part_name + '</option>';
				});
				$('#service_machine').empty().append(html);
			}
		});
	});

	$('#machine_name').change(function(){
		var id = $(this).val();
		$('#factory_code').val('');

		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>MachineService/Getfactorycode',
			success: function(result) {
				var obj = JSON.parse(result);
				$('#factory_code').val(obj.factorycode);
			}
		});
	});

	$("#submitdata").click(function() {
		if(!$('#machineserviceform')[0].checkValidity()){
			$('#hidesubmit').click();
		}
		else{
			var serviceID = $('#service_machine').val();
			var serviceText = $('#service_machine option:selected').text();
			var quantity = $('#quantity').val();

			$('#view_tableorder > tbody:last').append('<tr class="pointer"><td class="d-none">' + serviceID +'</td><td>' + serviceText +'</td><td>' + quantity +'</td><td class="text-right"><button class="btn btn-danger btn-sm btnRowRemove mr-1"><i class="fas fa-times"></i></button></td></tr>');

			$('#service_machine').val('').trigger('change');
			$('#quantity').val('');
		}
	});

	$('#formsubmit').click(function(){
		var tbody = $('#view_tableorder tbody');

		if(tbody.children().length > 0){
			jsonObj = [];
			$('#view_tableorder tbody tr').each(function(){
				item = {}
				$(this).find('td').each(function(col_idx){
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		// console.log(jsonObj);

		var idtbl_machine_service = $('#idtbl_machine_service').val();
		var job_type = $('input[name="job_type"]:checked').val();
		var sevice_date_to = $('#sevice_date_to').val();
		var service_date_from = $('#service_date_from').val();
		var machine_type = $('#machine_type').val();
		var machine_name = $('#machine_name').val();
		var factory_code = $('#factory_code').val();
		var estimated_sevice_hours = $('#estimated_sevice_hours').val();
		var recordOption = $('#recordOption').val();
		var recordID = $('#recordID').val();

		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				idtbl_machine_service: idtbl_machine_service,
				job_type: job_type,
				sevice_date_to: sevice_date_to,
				service_date_from: service_date_from,
				machine_type: machine_type,
				machine_name: machine_name,
				factory_code: factory_code,
				estimated_sevice_hours: estimated_sevice_hours,
				recordOption: recordOption,
				recordID: recordID
			},
			url: '<?php echo base_url() ?>Machineservice/Machineserviceinsertupdate',
			success: function(result) {
				$('#machineservice').modal('hide');
				var obj = JSON.parse(result);
				if (obj.status == 1) {
					setTimeout(function() {
						window.location.reload();
					}, 2000);
				}
				action(obj.action)
			}
		});
	});

	$('#dataTable tbody').on('click', '.btnEdit', function() {
		var r = confirm("Are you sure, You want to Edit this ? ");
		if (r == true) {
			$('#machineservice').modal('show');
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>MachineService/Machineserviceedit',
				success: function(result) {
					var obj = JSON.parse(result);
					$('#recordID').val(obj.id);

					var showServiceId = 'SRV' + obj.id.toString().padStart(4, '0');
					$('#idtbl_machine_service').val(showServiceId);
		
					if (obj.job_type == 1) {
						$('input[name="job_type"][value="1"]').prop('checked', true);
					} else {
						$('input[name="job_type"][value="2"]').prop('checked', true);
					}
					$('#service_date_from').val(obj.service_date_from);
					$('#sevice_date_to').val(obj.sevice_date_to);
					$('#machine_type').val(obj.machinetypeid).trigger('change');

					$('#machine_type').one('machineNameLoaded', function() {
						$('#machine_name').val(obj.machineid).trigger('change');
					});
					
					$('#estimated_sevice_hours').val(obj.estimated_sevice_hours);

					$('#view_tableorder > tbody:last').append(obj.view);


					$('#recordOption').val('2');
					$('#formsubmit').html('<i class="far fa-save"></i>&nbsp;Update');
				}
			});
		}
	});

	$('#view_tableorder').on('click', '.btnRowRemove', function() {
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
			url: '<?php echo base_url() ?>MachineService/Getmachineservicedetails',
			success: function(result) {
				$('#showservicedetails').html(result);
				$('#servicedetails').modal('show');
			}
		});
	});

	$('#machineservice').on('hidden.bs.modal', function(event) {
		window.location.reload();
	});
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
            element: 'body #machineservice',
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
