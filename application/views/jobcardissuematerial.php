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
							<span>Issue Material</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
								<span class="badge bg-success-soft px-2 mb-2">&nbsp;</span> Issued
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Company</th>
                                                <th>Branch</th>
                                                <th>Customer</th>
                                                <th>Allocate No</th>
                                                <th>Job Desc</th>
                                                <!-- <th>Issue Qty</th> -->
                                                <!-- <th>Status</th> -->
                                                <th class="text-right"></th>
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
<!-- Modal View Job Card -->
<div class="modal fade" id="viewJobCard" tabindex="-1" aria-labelledby="viewJobCardLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewJobCardLabel">Issue Material Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div id="showdata"></div>
					</div>
					<div class="col-12 text-right">
						<hr>						
						<button id="btnapprovereject" class="btn btn-primary btn-sm px-3"><i class="fas fa-check mr-2"></i>Approve or Reject</button>
						<input type="hidden" name="jobcardid" id="jobcardid">
					</div>
					<div class="col-12 text-right">
						<?php if($addcheck==1){ ?>
						<button type="button" class="btn btn-primary btn-sm px-4" id="issuebtn">Issue Material</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal View Job Card Issue Note -->
<div class="modal fade" id="viewIssueNote" tabindex="-1" aria-labelledby="viewIssueNoteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewIssueNoteLabel">Issue Note Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="formissuenotelist">
							<div class="form-group">
								<label class="small font-weight-bold text-dark">Issue Note</label>
								<select class="form-control form-control-sm selecter2 px-0" name="issuenote" id="issuenote" required>
									<option value="">Select</option>
								</select>
							</div>
							<div class="form-group mt-3 text-right">
								<button type="button" id="formsubmit" class="btn btn-primary btn-sm font-weight-bold px-4"><i class="fas fa-print"></i>&nbsp;Print Issue Note</button>
								<?php if($accountstatus==1){ ?>
								<button type="button" id="formsubmitAccount" class="btn btn-dark btn-sm font-weight-bold px-4"><i class="fas fa-eye"></i>&nbsp;View Issue Note</button>
								<?php } ?>
								<input type="submit" class="d-none" id="hidesubmitissuenote">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal job Card Batch Select -->
<div class="modal fade" id="jobCardBatch" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="jobCardBatchLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="jobCardBatchLabel">Choose issue batch</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<table class="table table-striped table-bordered table-sm small" id="tableissue">
							<thead>
								<tr>
									<th class="d-none">JobCardOtherID</th>
									<th class="d-none">Type</th>
									<th>Material</th>
									<th class="text-center">Issue Qty</th>
									<th>Batch No</th>
									<th class="d-none">MaterialID</th>
									<th class="text-center">Unit Type</th>
									<th class="d-none">ReqIssueQty</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="row">
							<div class="col-12 text-right">
								<hr>
								<?php if($addcheck==1){ ?>
								<button type="button" id="allocateBatchBtn" class="btn btn-danger btn-sm px-4 mb-3" disabled><i class="far fa-save"></i>&nbsp;Allocate Batch</button>
								<?php } ?>
							</div>
						</div>
						<div id="warningdata"></div>
						<input type="hidden" name="warningsection" id="warningsection">
						<input type="hidden" name="batchJobcardID" id="batchJobcardID">
					</div>
				</div>
			</div>
		</div>
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
<!-- Modal Batch No List -->
<div class="modal fade" id="modalAccountTransfer" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Issue Note Approve</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewissueacc"></div>
				<input type="hidden" name="hideissuenote" id="hideissuenote" value="">
				<?php if($accountstatus==1){ ?>
				<hr>
				<div class="form-group mb-1 text-right">
					<button type="button" class="btn btn-primary btn-sm small px-3" id="btnIssueApprove" <?php if($accountstatus==0){echo 'disabled';} ?>>Approve</button>
				</div>
				<?php } ?>
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
	var accountcheck = '<?php echo $accountstatus; ?>';

	$('#batchnolist').select2();
	$("#batchnolist").on("select2:select", function (evt) {
		var element = evt.params.data.element;
		var $element = $(element);
		
		$element.detach();
		$(this).append($element);
		$(this).trigger("change");
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
			url: "<?php echo base_url() ?>scripts/jobcardapprovedlist.php",
			type: "POST", // you can use GET
		},
		"order": [
			[0, "desc"]
		],
		"columns": [
			{
                "data": null,
                "render": function(data, type, full, meta) {
                    return meta.row + 1 + meta.settings._iDisplayStart;
                }
            },
			{
				"data": "date"
			},
			{
				"data": "company"
			},
			{
				"data": "branch"
			},
			{
				"data": "customer"
			},
			{
				"data": "jobcardno"
			},
			{
				"data": "job_description"
			},
			// {
			// 	"data": "issueqty"
			// },
			// {
            //     "targets": -1,
            //     "className": 'text-right',
            //     "data": null,
            //     "render": function(data, type, full) {
			// 		if (full['approvestatus'] == 1) {
			// 			return '<span class="text-success font-weight-bold"><i class="fas fa-check-circle"></i> Inquiry Approved</span>';
			// 		} 
			// 		else if (full['approvestatus'] == 2) {
			// 			return '<span class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> Inquiry Rejected</span>';
			// 		} else {
			// 			return '<span class="text-warning font-weight-bold"><i class="fas fa-redo"></i> Pending</span>';
			// 		}
            //     }
            // },
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function (data, type, full) {
					var button = '';

					button+='<button type="button" class="btn btn-primary btn-sm btnBatchAllocation mr-1" id="'+full['idtbl_jobcard']+'" data-toggle="tooltip" title="Batch Allocation"><i class="fas fa-tasks"></i></button>';
					button+='<button type="button" class="btn btn-dark btn-sm btnView mr-1" id="'+full['idtbl_jobcard']+'" data-toggle="tooltip" title="View & Issue" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-eye"></i></button>';
					button+='<button type="button" class="btn btn-orange btn-sm btnListIssue mr-1" id="'+full['idtbl_jobcard']+'" data-toggle="tooltip" title="Issue note" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-file"></i></button>';
                    // if(full['issuematerialstatus'] == 1){
					//     button += '<a href="<?php echo base_url() ?>Jobcardissuematerial/jobCardIssueNote/' + full['idtbl_jobcard'] + '" data-toggle="tooltip" title="Issue Note" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a>';
                    // }
					
					return button;
				}
			}
		],
        createdRow: function( row, data, dataIndex){
			if ( data['issuematerialstatus']  == 1) {
				$(row).addClass('bg-success-soft');
			}
		},
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
    $('#dataTable tbody').on('click', '.btnView', async function() {
		var id = $(this).attr('id');
		$('#jobcardid').val(id);
		var approvestatus = $(this).attr('data-approvestatus');

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
					url: '<?php echo base_url() ?>Jobcardissuematerial/Getjobissuematerialinfo',
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
    $('#dataTable tbody').on('click', '.btnListIssue', async function() {
		var id = $(this).attr('id');
		$('#jobcardid').val(id);

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
					url: '<?php echo base_url() ?>Jobcardissuematerial/Getissuenotelist',
					success: function(result) {
						Swal.close();
						document.body.style.overflow = 'auto';

						var obj = JSON.parse(result);
						var html = '';
						html += '<option value="">Select</option>';
						$.each(obj, function (i, item) {
							html += '<option value="' + obj[i].idtbl_issue_note + '">';
							html += obj[i].issuenoteno;
							html += '</option>';
						});
						$('#issuenote').empty().append(html);
						$('#viewIssueNote').modal('show');
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
    $('#issuebtn').on('click', async function() {
        var r = await Otherconfirmation("You want to issue material ? ");
        if (r == true) {
            var jobcardid = $('#jobcardid').val();  

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
                            recordID: jobcardid
                        },
                        url: '<?php echo base_url() ?>Jobcardissuematerial/Materialissue',
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
    });
	$('#formsubmit').click(function(){
		if (!$("#formissuenotelist")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#hidesubmitissuenote").click();
		} else {
			var issuenoteID = $('#issuenote').val();
			var url = '<?php echo base_url() ?>Jobcardissuematerial/jobCardIssueNote/' + issuenoteID;
        	window.open(url, '_blank');
		}
	});
	$('#formsubmitAccount').click(function(){
		if (!$("#formissuenotelist")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#hidesubmitissuenote").click();
		} else {
			var issuenoteID = $('#issuenote').val();
			$('#hideissuenote').val(issuenoteID);

			$.ajax({
				type: "POST",
				data: {
					recordID: issuenoteID
				},
				url: '<?php echo base_url() ?>Jobcardissuematerial/Getissuenoteaccounttransfer',
				success: function(result) {
					$('#viewissueacc').html(result);
					$('#modalAccountTransfer').modal('show');
					$('#viewIssueNote').modal('hide');
				},
				error: function(error) {					
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

	$('#dataTable tbody').on('click', '.btnBatchAllocation', async function() {
		var id = $(this).attr('id');
		$('#batchJobcardID').val(id);
		var approvestatus = $(this).attr('data-approvestatus');

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
					url: '<?php echo base_url() ?>Jobcardissuematerial/Getjobcardissuematerialbatchlist',
					success: function(result) {
						Swal.close();
						document.body.style.overflow = 'auto';

						var obj = JSON.parse(result);
						$('#tableissue > tbody').append(obj.tabledata);
						if(obj.warnstatus==1){
							$('#warningdata').html('<div class="alert alert-danger" role="alert">Some Product quantity not enough for you production. Please check stock in these material '+obj.warntext+' and production start again.</div>');
							$('#warningsection').val(obj.warningsection);
							$('#allocateBatchBtn').prop('disabled', true);
						}
						else{
							$('#allocateBatchBtn').prop('disabled', false);
							$('#warningdata').html('');
						}
						$('#jobCardBatch').modal('show');
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
	$('#tableissue tbody').on('click', 'tr .batchnolist', function () {
		var row = $(this);
		// console.log(row);
		var materialID = row.closest("tr").find('td:eq(5)').text();
		rowID = row.closest("tr")[0].rowIndex;

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
						materialID: materialID
					},
					url: '<?php echo base_url() ?>Jobcardissuematerial/Getbatchnolistaccomaterial',
					success: function(result) { //alert(result);
						Swal.close();
						document.body.style.overflow = 'auto';

						var objfirst = JSON.parse(result);

						var html = '';
						$.each(objfirst, function(i, item) {
							//alert(objfirst[i].id);
							html += '<option value="' + objfirst[i].batchno + '">';
							html += objfirst[i].batchno+' - '+objfirst[i].qty+' - ('+objfirst[i].grndate+')';
							html += '</option>';
						});

						$('#batchnolist').empty().append(html);
						$('#batchnolist').trigger('change');
						$('#modalbatchno').modal('show');
					},
					error: function(error) {
						$('#submitBtn').prop('disabled', false);
						$('#issueMaterialBtn').prop('disabled', true);
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

	$('#allocateBatchBtn').click(function(){
		$('#allocateBatchBtn').prop('disabled', true);
		var batchJobcardID = $('#batchJobcardID').val();
		var jobcardtype = 0;

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
		// console.log(jsonObj);
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
							batchJobcardID: batchJobcardID,
							tableData: jsonObj
						},
						url: '<?php echo base_url() ?>Jobcardissuematerial/Issuematerialbatchupdate',
						success: function(result) { //alert(result);
							Swal.close();
							document.body.style.overflow = 'auto';

							var obj = JSON.parse(result);
							if(obj.status==1){
								actionreload(obj.action);
							}
							else{
								action(obj.action);
								$('#issueMaterialBtn').prop('disabled', false);
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

	$('#jobCardBatch').on('hidden.bs.modal', function (event) {
        window.location.reload();
    });

	$('#btnIssueApprove').click(async function() {
		var r = await Otherconfirmation("Are you sure you want to approve & transfer this issue note? ");
        if (r == true) {
			var issuenoteID = $('#hideissuenote').val();
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
							recordID: issuenoteID
						},
						url: '<?php echo base_url() ?>Jobcardissuematerial/Approveissuenote',
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
});
</script>
<?php include "include/footer.php"; ?>
