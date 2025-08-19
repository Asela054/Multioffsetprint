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
							<div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
							<!-- <span><b>Un Invoice Dispatch Report</b></span> -->
                            <span>&nbsp; Un Invoice Dispatch Report</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searchunda">
								<div class="col-12">
									<div class="form-row">
										<!-- <div class="col-2">
											<label class="small font-weight-bold text-dark">Report Type*</label>
											<div class="input-group input-group-sm">
												<select class="form-control form-control-sm" name="report_type"
													id="report_type">
													<option value="0">Select</option>
													<option value="1">Daily</option>
													<option value="2">Weekly</option>
													<option value="3">Monthly</option>
													<option value="4">Date Range</option>
													<option value="5">All GRN</option>
												</select>
											</div>
										</div> -->

										
										<!-- <div class="col-2">
                                            <label class="small font-weight-bold">Type*</label>
                                            <select class="form-control form-control-sm" name="type" id="type" required>
                                                <option value="">Select</option>
                                                <option value="1">Material</option>
                                                <option value="2">Machine</option>
                                            </select>
                                        </div> -->
										<div class="col-2">
											<label class="small font-weight-bold">Customer*</label>
											<select class="form-control form-control-sm selecter2 px-0" name="customer"
												id="customer" required>
												<option value="">Select</option>
												<option value="all">All</option>
												<?php foreach ($getcustomer->result() as $rowgetcustomer) { ?>
												<option value="<?php echo $rowgetcustomer->idtbl_customer ?>">
													<?php echo $rowgetcustomer->name ?></option>
												<?php } ?>
											</select>
										</div>
                                    <div class="col-2"><br>
                                        <button type="submit" id="searchButton" class="btn btn-info mb-2"><span id="boot-icon" class="bi bi-search" style="font-size: 15px;">&nbsp;Search</span></button>
                                    </div>
										<!-- <div class="col-1" style="display: none;" id="searchButton">&nbsp;<br>
											<button type="submit"
												class="btn btn-info btn-sm ml-auto w-25 mt-2 px-5">Search</button>
										</div> -->
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
												<th>Dispatch Number</th>
												<th>Customer Name</th>
                                                <th>Date</th>
												<th>PO Number</th>
												<th>Customer Inqury Number</th>
                                                <th>Job</th>
                                                <th>Job Number</th>
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
		
		$("#searchunda").submit(function (event) {
			event.preventDefault();


			var table = $('#dataTable').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				//scrollY: 350,
				ajax: {
					url: "<?php echo base_url() ?>scripts/uninvoicedalistreport.php",
					type: "POST", // you can use GET 
					"data": function (d) {
						return $.extend({}, d, {
							"search_date": $("#date").val(),
							"search_week": $("#week").val(),
							"search_month": $("#month").val(),
							"search_from_date": $("#date_from").val(),
							"search_to_date": $("#date_to").val(),
							"report_type": "5",
							"customer": $("#customer").val(),
						});
					}
				},
				"order": [
					[0, "desc"]
				],
				"columns": [
					{
					"data": function (row) {
						return "DPN000" + row.idtbl_print_dispatch;
					}
				},  
					{
						"data": "name"
					},
                    {
						"data": "date"
					},
					{
						"data": "ponum"
					},
					{
					"data": function (row) {
						return "CUI000" + row.tbl_customerinquiry_idtbl_customerinquiry;
					}
				},
					{
						"data": "job"
					},
					{
						"data": "job_no"
					}
                  
					
				],
				dom: 'Bfrtip',
				dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				responsive: true,
				lengthMenu: [
					[-1],
					['All'],
				],
				buttons: [{
						extend: 'pdf',
						className: 'btn btn-primary btn-sm',
						text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
						title: 'Un Invoice Dispatch Report',
						filename: 'Un Invoice Dispatch Report ',
						footer: true,
						messageTop: {
							text: 'Un Invoice Dispatch Report',
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
						filename: 'Un Invoice Dispatch Report ',
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true,
						title: 'MULTI OFFSET PRINTERS Un Invoice Dispatch Report - By Erav Technology'
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Un Invoice Dispatch Report ',
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'Un Invoice Dispatch Report',
						filename: 'Un Invoice Dispatch Report ',
						footer: true,
						messageTop: 'Un Invoice Dispatch Report ',
						customize: function (doc) {
							doc.styles.title = {
								color: 'black',
								fontSize: '30',
								alignment: 'center',
							}
						}
					}
				],
				footerCallback: function (row, data, start, end, display) {
					var api = this.api();

					// Remove the formatting to get integer data for summation
					var intVal = function (i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
							i : 0;
					};

					// Total over all pages for column 3 (index 2)
					var totalColumn3 = api
						.column(4)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Total over this page for column 3 (index 2)
					var pageTotalColumn3 = api
						.column(4, {
							page: 'current'
						})
						.data()
						.reduce(function (a, b) {
							return parseFloat(intVal(a) + intVal(b)).toFixed(2);
						}, 0);

					// Update footer of column 3 with the page total
					$(api.column(4).footer()).html('Rs. ' + pageTotalColumn3);
				},
				drawCallback: function (settings) {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});
	});

</script>

<?php include "include/footer.php"; ?>
