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
							<div class="page-header-icon"><i class="fas fa-archive"></i></div>
							<span>Manual Material Allocate</span>
						</h1>
					</div>
				</div>
			</div>

			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-3">
								<form id="formbommaterialinfo" method="post" autocomplete="off">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark"> Customer *</label>
										<select class="form-control form-control-sm px-0" name="customer" id="customer" style="width: 100%;" required>
											<option value="">Select</option>
										</select>
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Job No*</label>
										<select class="form-control form-control-sm  px-0" name="cusinquiry" id="cusinquiry" style="width: 100%;" required>
											<option value="">Select</option>
										</select>
									</div>
									<input type="hidden" name="bominfo" id="bominfo" value="0">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Section</label>
										<select class="form-control form-control-sm  px-0" name="section" id="section" required>
											<option value="">Select</option>
											<option value="1">Material Section</option>
											<option value="2">Printing Section</option>
											<option value="3">Coating Section</option>
											<option value="4">Foiling Section</option>
											<option value="5">Lamination Section</option>
											<option value="6">Pasting Section</option>
											<option value="7">Rimming Section</option>
										</select>
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Material Info *</label>
										<select class="form-control form-control-sm  px-0" name="materialinfo" id="materialinfo" required>
											<option value="">Select</option>
										</select>
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Issue Qty</label>
										<input type="text" id="issueqty" name="issueqty" class="form-control form-control-sm">
									</div>
									<div class="form-group mt-3 text-right">
										<?php if($addcheck==1){ ?>
										<button type="button" id="submitBtn" class="btn btn-primary btn-sm px-4"><i class="fas fa-search"></i>&nbsp;Check Issue Info</button>
										<?php } ?>
									</div>
									<input type="submit" class="d-none" id="hidesubmitcheck">
								</form>
							</div>

							<div class="col-9">
								<table class="table table-striped table-bordered table-sm small" id="tableissue">
									<thead>
										<tr>
											<th class="d-none">Type</th>
											<th>Material</th>
											<th class="text-center">Issue Qty</th>
											<th>Batch No</th>
											<th class="d-none">MaterialID</th>
											<th class="d-none">IssueReqQty</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>

								<hr>
								<div class="row">
									<div class="col-12 text-right">
										<?php if($addcheck==1){ ?>
										<button type="button" id="issueMaterialBtn" class="btn btn-danger btn-sm px-4 mb-3" disabled><i class="far fa-save"></i>&nbsp;Allocate Complete</button>
										<?php } ?>
									</div>
								</div>

								<div id="warningdata"></div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row mt-3 mb-3 p-3">
						<div class="col-12">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-sm small" id="dataTable">
									<thead>
										<tr class="bg-light">
											<th>#</th>
											<th>Issue Date</th>
											<th>Job Card No</th>
											<th>Customer</th>
											<th>Contact</th>
											<th>Job Card Type</th>
											<th>Job Description</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>

<!-- Modal Batch No List -->
<div class="modal fade" id="modalbatchno" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Material Issue Batch No</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="formbatchno">
							<div class="form-group">
								<label class="small font-weight-bold">Stock Batch No</label><br>
								<select class="form-control form-control-sm" name="batchnolist[]" id="batchnolist" style="width: 100%;" multiple required>
								</select>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitbatch" <?php if($addcheck==0){echo 'disabled';} ?>>Done</button>
								<input type="submit" id="hidesubmitbatch" class="d-none">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal View Job Card -->
<div class="modal fade" id="viewJobCard" tabindex="-1" aria-labelledby="viewJobCardLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewJobCardLabel">Job Card Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div id="showdata"></div>
					</div>
					<div class="col-12 text-center">
						<div id="alertdiv"></div>
					</div>
				</div>
				<input type="hidden" name="jobcardid" id="jobcardid">
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
	var approvecheck = '<?php echo $approvecheck; ?>';
	var materialsectiontype;

	$('#tableissue').on('click', 'tr', function () {
		var r = confirm("Are you sure you want to remove this product?");
		if (r == true) {
			$(this).closest('tr').remove();
		}
	});

	$('#batchnolist').select2();
	$("#batchnolist").on("select2:select", function (evt) {
		var element = evt.params.data.element;
		var $element = $(element);
		
		$element.detach();
		$(this).append($element);
		$(this).trigger("change");
	});
	$("#customer").select2({
		dropdownParent: $('#formbommaterialinfo'),
		ajax: {
			url: "<?php echo base_url() ?>MaterialAllocationManual/Getcustomerlist",
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term // search term
				};
			},
			processResults: function (response) {
				return {
					results: response
				};
			},
			cache: true
		}
	});
	$("#cusinquiry").select2({
		dropdownParent: $('#formbommaterialinfo'),
		ajax: {
			url: "<?php echo base_url() ?>MaterialAllocationManual/Getcustomerinquirylist",
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					customerid: $("#customer").val()
				};
			},
			processResults: function (response) {
				return {
					results: response.map(function (item) {
						return {
							id: item.id,
							text: item.text,
							data: {
								reqqty: item.qty,
								issuedqty: item.issueqty
							}
						};
					})
				}
				// return {
				// 	results: response
				// };
			},
			cache: true
		}
	});
	$('#section').change(function(){
		if ($(this).val() == '1') {
			materialsectiontype = JSON.stringify(["1", "2"]);

		} else if ($(this).val() == '2') {
			materialsectiontype = JSON.stringify(["3"]);

		} else if ($(this).val() == '3') {
			materialsectiontype = JSON.stringify(["8"]);

		} else if ($(this).val() == '4') {
			materialsectiontype = JSON.stringify(["5"]);

		} else if ($(this).val() == '5') {
			materialsectiontype = JSON.stringify(["6"]);

		} else if ($(this).val() == '6') {
			materialsectiontype = JSON.stringify(["7"]);

		} else if ($(this).val() == '7') {
			materialsectiontype = JSON.stringify([]);
		}

	});
	$("#materialinfo").select2({
		// dropdownParent: $('#modalBomInfo'),
		ajax: {
			url: "<?php echo base_url() ?>MaterialAllocationManual/GetMaterialList",
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					searchCategory: materialsectiontype
				};
			},
			processResults: function (response) {
				return {
					results: response.map(function (item) {
						return {
							id: item.id,
							text: item.text,
							data: {
								code: item.code
							}
						};
					})
				}
			},
			cache: true
		}
	});



	$('#submitBtn').click(function () {

		if (!$("#formbommaterialinfo")[0].checkValidity()) {
			$("#hidesubmitcheck").click();
			return;
		}

		$('#submitBtn').prop('disabled', true);

		var inquiryqty = $('#inquiryqty').val();
		var issueqty = $('#issueqty').val();
		var section = $('#section').val();
		var materialid = $('#materialinfo').val();

		var balqty = parseFloat(inquiryqty) - parseFloat(issueqty);

		var typeIDs = [];
		$('#tableissue tbody tr').each(function () {
			var typeID = $(this).find('td:eq(0)').text().trim();
			if (typeID && $.inArray(typeID, typeIDs) === -1) {
				typeIDs.push(typeID);
			}
		});

		if ($.inArray(section, typeIDs) !== -1) {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'You selected section already set to issue table.'
			});
			$('#submitBtn').prop('disabled', false);
			return;
		}

		if (balqty < 0) {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Issued qty exceeds request qty.'
			});
			$('#submitBtn').prop('disabled', false);
			return;
		}

		Swal.fire({
			title: '',
			html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
			allowOutsideClick: false,
			showConfirmButton: false,
			backdrop: 'rgba(255,255,255,0.5)',
			customClass: {
				popup: 'fullscreen-swal'
			},
			didOpen: () => {

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>MaterialAllocationManual/CheckBomMaterialInfo",
					data: {
						materialid: materialid,
						issueqty: issueqty
					},
					success: function (result) {

						var obj = JSON.parse(result);

						Swal.close();
						document.body.style.overflow = 'auto';

						if (obj.warnstatus == 1) {
							Swal.fire({
								icon: 'error',
								title: 'Stock Warning',
								text: obj.warntext
							});
							$('#submitBtn').prop('disabled', false);
							return;
						}

						$('#tableissue > tbody:last').append(
							'<tr>' +
							'<td class="d-none">' + section + '</td>' + 
							'<td>' + $("#materialinfo option:selected").text() + '</td>' +
							'<td class="text-center">' + issueqty + '</td>' +
							'<td class="batchnolist text-primary" style="cursor:pointer">Select Batch Number</td>' +
							'<td class="d-none materialid">' + materialid + '</td>' + 
							'<td class="text-center d-none">' + issueqty + '</td>' +
							'</tr>'
						);

						$('#issueqty').val('');
						$('#section').val('');
						$('#materialinfo').val('').trigger('change');

						$('#submitBtn').prop('disabled', false);
						$('#issueMaterialBtn').prop('disabled', false);
					},

					error: function () {
						Swal.close();
						$('#submitBtn').prop('disabled', false);
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Server error!'
						});
					}
				});
			}
		});
	});
	var rowID = 0;

	$('#tableissue tbody').on('click', '.batchnolist', function () {

		var row = $(this).closest("tr");
		rowID = row.index();
		var materialID = row.find('.materialid').text();

		Swal.fire({
			title: '',
			html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
			allowOutsideClick: false,
			showConfirmButton: false,
			backdrop: 'rgba(255,255,255,0.5)',
			customClass: {
				popup: 'fullscreen-swal'
			},
			didOpen: () => {

				$.ajax({
					type: "POST",
					data: {
						materialID: materialID
					},
					url: '<?php echo base_url() ?>MaterialAllocationManual/Getbatchnolistaccomaterial',

					success: function (result) {

						Swal.close();

						var obj = JSON.parse(result);
						var html = '';

						$.each(obj, function (i, item) {
							html += '<option value="' + item.batchno + '">';
							html += item.batchno + ' - ' + item.qty;
							html += '</option>';
						});

						$('#batchnolist').empty().append(html);
						$('#modalbatchno').modal('show');
					},

					error: function () {
						Swal.close();
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Batch load failed!'
						});
					}
				});
			}
		});
	});
	$('#batchnolist').change(function () {
		var selectedBatch = $(this).val();

		$('#tableissue tbody tr').eq(rowID).find('td:eq(3)').text(selectedBatch);

		$('#modalbatchno').modal('hide');
	});
	$('#tableissue tbody').on('click', 'tr .sectionremove', async function () {
		var r = await Otherconfirmation("You want to remove this ? ");
        if (r == true) {
			const currentRow = $(this).closest('tr');
			const rowClass = currentRow.attr('data-otherrow');
			$('#tableissue tbody tr.'+rowClass).remove();	
			currentRow.remove();		
		}
	});
	$('#btnsubmitbatch').click(function(){
		if (!$("#formbatchno")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#hidesubmitbatch").click();
		} else {
			$('#tableissue').find('tr').eq(rowID).find('td:eq(4)').text($('#batchnolist').val());
			$('#batchnolist').empty().trigger('change');
			$('#modalbatchno').modal('hide');
		}
	});
	$('#issueMaterialBtn').click(function(){
		$('#issueMaterialBtn').prop('disabled', true);
		var customer = $('#customer').val();
		var cusinquiry = $('#cusinquiry').val();
		var bominfo = $('#bominfo').val();
		var issueqty = $('#issueqty').val();
		var jobcardtype = 1;

		var emptybatch = 0;
		var tbody = $('#tableissue tbody');
		if (tbody.children().length > 0) {
			var jsonObj = []
			$("#tableissue tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					if($(this).text()==''){
						emptybatch=1;
					}
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		console.log(jsonObj);
		if(emptybatch==1){
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Please select material stock batch no for issue materials.'
			});
			$('#issueMaterialBtn').prop('disabled', false);
		}
		else{
			Swal.fire({
				title: '',
				html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
				allowOutsideClick: false,
				showConfirmButton: false, // Hide the OK button
				backdrop: `
					rgba(255, 255, 255, 0.5) 
				`,
				customClass: {
					popup: 'fullscreen-swal'
				},
				didOpen: () => {
					document.body.style.overflow = 'hidden';

					$.ajax({
						type: "POST",
						data: {
							customer: customer,
							cusinquiry: cusinquiry,
							bominfo: bominfo,
							issueqty: issueqty,
							jobcardtype: jobcardtype,
							tableData: jsonObj
						},
						url: '<?php echo base_url() ?>MaterialAllocationManual/Issuematerialinsertupdate',
						success: function(result) { //alert(result);
							Swal.close();
							document.body.style.overflow = 'auto';

							var obj = JSON.parse(result);
							if(obj.status==1){
								actionreload(obj.action);
							}
							else{
								action(obj.action);
							}

							var objfirst = JSON.parse(result);
						},
						error: function(error) {
							$('#issueMaterialBtn').prop('disabled', false);
							// Close the SweetAlert on error
							Swal.close();
							document.body.style.overflow = 'auto';
							
							// Show an error alert
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Something went wrong. Please try again later.'
							});
						}
					}); 
				}
			});
		}
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
				className: 'btn btn-success btn-sm mr-2',
				title: 'Manual Material Allocation Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm mr-2',
				title: 'Manual Material Allocation Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Manual Material Allocation Information',
				className: 'btn btn-primary btn-sm mr-2',
				text: '<i class="fas fa-print mr-2"></i> Print',
				customize: function (win) {
					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				},
			},
		],

		ajax: {
			url: "<?php echo base_url() ?>scripts/manualallocationlist.php",
			type: "POST",
			data: function(d) {
				d.company_id = "<?php echo $_SESSION['company_id']; ?>";
			}
		},
		"order": [
			[1, "desc"]
		],
		"columns": [
			{
                "data": null,
                "render": function(data, type, full, meta) {
                    return meta.row + 1 + meta.settings._iDisplayStart;
                }
            },
			{
				"data": "issuedate"
			},
			{
				"data": "jobcardno"
			},
			{
				"data": "customer"
			},
			{
				"data": "telephone_no"
			},
			{
				"data": "jobcardtype"
			},
			{
				"data": "job_description"
			},
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function (data, type, full) {
					var button = '';

					button+='<button type="button" class="btn btn-dark btn-sm btnViewAllocation mr-1" id="'+full['idtbl_jobcard_manual_issue']+'" data-toggle="tooltip" title="View Details"><i class="fas fa-eye"></i></button>';
					
					return button;
				}
			}
		],
		createdRow: function( row, data, dataIndex){
			if ( data['status']  == 1) {
				$(row).addClass('bg-success-soft');
			}
		},
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	$('#dataTable tbody').on('click', '.btnViewAllocation', async function() {
		var id = $(this).attr('id');
		$('#jobcardid').val(id);

		Swal.fire({
			title: '',
			html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
			allowOutsideClick: false,
			showConfirmButton: false,
			backdrop: `
				rgba(255, 255, 255, 0.5) 
			`,
			customClass: {
				popup: 'fullscreen-swal'
			},
			didOpen: () => {
				document.body.style.overflow = 'hidden';

				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>MaterialAllocationManual/GetManualAllocationDetails',
					success: function(result) {
						Swal.close();
						document.body.style.overflow = 'auto';

						$('#showdata').html(result);
						$('#viewJobCard').modal('show');
					},
					error: function(error) {
						Swal.close();
						document.body.style.overflow = 'auto';
						
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Something went wrong. Please try again later.'
						});
					}
				});
			}
		}); 
	});
	$('#dataTable tbody').on('click', '.btnView', async function() {
		var id = $(this).attr('id');
		$('#jobcardid').val(id);
		var approvestatus = $(this).attr('data-approvestatus');
		var checkby = $(this).attr('data-checkby');

		if(approvecheck==1 && checkby==0){
			$('#btnapprovereject').addClass('d-none');
		}
		else{
			$('#btncheck').addClass('d-none');
		}

		Swal.fire({
			title: '',
			html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
			allowOutsideClick: false,
			showConfirmButton: false, // Hide the OK button
			backdrop: `
				rgba(255, 255, 255, 0.5) 
			`,
			customClass: {
				popup: 'fullscreen-swal'
			},
			didOpen: () => {
				document.body.style.overflow = 'hidden';

				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>MaterialAllocationManual/Getjobissuematerialinfo',
					success: function(result) {
						Swal.close();
						document.body.style.overflow = 'auto';

						$('#showdata').html(result);
						$('#viewJobCard').modal('show');

						if(approvestatus>0){
							$('#btnapprovereject').addClass('d-none').prop('disabled', true);
							if(approvestatus==1){$('#alertdiv').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle mr-2"></i> Job card approved</div>');}
							else if(approvestatus==2){$('#alertdiv').html('<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle mr-2"></i> Job card rejected</div>');}
						}
					},
					error: function(error) {
						// Close the SweetAlert on error
						Swal.close();
						document.body.style.overflow = 'auto';
						
						// Show an error alert
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Something went wrong. Please try again later.'
						});
					}
				});
			}
		}); 
	});
	$('#btnapprovereject').click(function(){
        Swal.fire({
            title: "Do you want to approve this inqury?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Approve",
            denyButtonText: `Reject`
        }).then((result) => {
            if (result.isConfirmed) {
                var confirmnot = 1;
                approvejob(confirmnot);
            } else if (result.isDenied) {
                var confirmnot = 2;
                approvejob(confirmnot);
            } 
        });
    });
	$('#viewJobCard').on('hidden.bs.modal', function (event) {
        $('#alertdiv').html('');
		$('#btnapprovereject').removeClass('d-none').prop('disabled', false);
    });
	$('#btncheck').click(function(){
        Swal.fire({
            title: "Do you want to check this Request?",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Check",
        }).then((result) => {
            if (result.isConfirmed) {
                var confirmnot = 1;
                checkjob(confirmnot);
            } 
        });
    });   
});

function approvejob(confirmnot){
    Swal.fire({
        title: '',
        html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false, // Hide the OK button
        backdrop: `
            rgba(255, 255, 255, 0.5) 
        `,
        customClass: {
            popup: 'fullscreen-swal'
        },
        didOpen: () => {
            document.body.style.overflow = 'hidden';

            $.ajax({
                type: "POST",
                data: {
                    recordID: $('#jobcardid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>MaterialAllocationManual/MaterialAllocationManualapprove',
                success: function(result) {
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        actionreload(obj.action);
                    }
                    else{
                        action(obj.action);
                    }
                },
                error: function(error) {
                    // Close the SweetAlert on error
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    
                    // Show an error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.'
                    });
                }
            });
        }
    });
}
function checkjob(confirmnot){
    Swal.fire({
        title: '',
        html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false, // Hide the OK button
        backdrop: `
            rgba(255, 255, 255, 0.5) 
        `,
        customClass: {
            popup: 'fullscreen-swal'
        },
        didOpen: () => {
            document.body.style.overflow = 'hidden';

            $.ajax({
                type: "POST",
                data: {
                    jobcardid: $('#jobcardid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>MaterialAllocationManual/MaterialAllocationManualcheckstatus',
                success: function(result) {
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        actionreload(obj.action);
                    }
                    else{
                        action(obj.action);
                    }
                },
                error: function(error) {
                    // Close the SweetAlert on error
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    
                    // Show an error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.'
                    });
                }
            });
        }
    });
}
</script>
<?php include "include/footer.php"; ?>
