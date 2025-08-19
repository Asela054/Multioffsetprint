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
							<span>Job card Issue Material</span>
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
                                                <th>Job Card No</th>
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
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
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
								<button type="button" id="formsubmit" class="btn btn-primary btn-sm font-weight-bold px-4"><i class="fas fa-file-pdf"></i>&nbsp;View Issue Note</button>
								<input type="submit" class="d-none" id="hidesubmitissuenote">
							</div>
						</form>
					</div>
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

					button+='<button type="button" class="btn btn-dark btn-sm btnView mr-1" id="'+full['idtbl_jobcard']+'" data-toggle="tooltip" title="View & Issue" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-eye"></i></button>';
					button+='<button type="button" class="btn btn-orange btn-sm btnListIssue mr-1" id="'+full['idtbl_jobcard']+'" data-toggle="tooltip" title="Issue note" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-list"></i></button>';
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
});
</script>
<?php include "include/footer.php"; ?>
