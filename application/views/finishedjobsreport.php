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
							<div class="page-header-icon"><i class="fas fa-check-circle"></i></div>
                            <span>&nbsp; Finished Jobs</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searchfinishedjobs">
								<div class="col-12">
									<div class="form-row">
										<div class="col-2">
											<label class="small font-weight-bold">Customer</label>
											<select class="form-control form-control-sm selecter2 px-0" name="customer"
												id="customer">
												<option value="">Select</option>
												<option value="all">All</option>
												<?php foreach ($getcustomer->result() as $rowgetcustomer) { ?>
												<option value="<?php echo $rowgetcustomer->idtbl_customer ?>">
													<?php echo $rowgetcustomer->customer ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-2">
											<label class="small font-weight-bold">Date From</label>
											<input type="date" class="form-control form-control-sm" id="date_from" name="date_from">
										</div>
										<div class="col-2">
											<label class="small font-weight-bold">Date To</label>
											<input type="date" class="form-control form-control-sm" id="date_to" name="date_to">
										</div>
										<div class="col-2">
											<label class="small font-weight-bold">Job / Job No</label>
											<input type="text" class="form-control form-control-sm" id="job" name="job" placeholder="Job or number">
										</div>
										<div class="col-2"><br>
										<button type="submit" id="searchButton" class="btn btn-info mb-2"><span id="boot-icon" class="bi bi-search" style="font-size: 15px;">&nbsp;Search</span></button>
									</div>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</div>

								<div class="col-12">
									<div class="form-group mb-1">
										<hr style="border: 1px solid #ddd;">
									</div>
								</div>
							</form>
							<div class="col-12 mt-4">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap w-100"
										id="dataTable">
										<thead class="thead-light">
											<tr>
												<th>Customer</th>
												<th>Date</th>
												<th>Job No</th>
												<th>Job Name</th>
												<th>Po Number</th>
												<th>Qty</th>
												<th>UOM</th>
												<th>Dispatch No</th>
												<th>Dispatch Date</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									
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
	$(document).ready(function () {
		$('.selecter2').select2();

		$("#searchfinishedjobs").submit(function (event) {
			event.preventDefault();

			var table = $('#dataTable').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				ajax: {
					url: "<?php echo base_url() ?>scripts/finishedjobslistreport.php",
					type: "POST",
					"data": function (d) {
						return $.extend({}, d, {
							"search_from_date": $("#date_from").val(),
							"search_to_date": $("#date_to").val(),
							"job": $("#job").val(),
							"customer": $("#customer").val(),
							"company_id": '<?php echo $_SESSION['company_id']; ?>',
						});
					}
				},
				"order": [
					[1, "desc"]
				],
				"columns": [
					{ data: 'customer',      title: 'Customer' },
                    { data: 'inquiry_date',  title: 'Date' },      
                    { data: 'job_no',        title: 'Job No' },
                    { data: 'job',           title: 'Job Name' },
                    { data: 'po_number',     title: 'Po Number' },
                    { data: 'qty',           title: 'Qty' },
                    { data: 'uom',           title: 'UOM' },
                    { data: 'dispatch_no',   title: 'Dispatch No' },
                    { data: 'dispatch_date', title: 'Dispatch Date' }
				],
				dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				responsive: true,
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, 'All'],
				],
				buttons: [{
						extend: 'pdf',
						className: 'btn btn-primary btn-sm',
						text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
						title: 'Finished Jobs Report',
						filename: 'Finished Jobs Report',
						footer: true,
						messageTop: {
							text: 'Finished Jobs Report',
							fontSize: 15,
							bold: true,
							alignment: 'center'
						},
						customize: function (doc) {
							doc.styles.title = {
								color: 'black',
								fontSize: '30',
								alignment: 'center',
							}
						}
					},
					{
						extend: 'excel',
						className: 'btn btn-success btn-sm',
						filename: 'Finished Jobs Report',
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true,
						title: 'Finished Jobs Report'
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Finished Jobs Report',
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'Finished Jobs Report',
						filename: 'Finished Jobs Report',
						footer: true,
						messageTop: 'Finished Jobs Report',
						customize: function (doc) {
							doc.styles.title = {
								color: 'black',
								fontSize: '30',
								alignment: 'center',
							}
						}
					}
				],
				drawCallback: function (settings) {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});
	});
</script>

<?php include "include/footer.php"; ?>