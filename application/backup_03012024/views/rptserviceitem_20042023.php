<?php 
include "include/header.php"; 

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<?php include "include/menubar.php"; 

        ?>
	</div>
	<div id="layoutSidenav_content">
		<main>
			<div class="page-header page-header-light bg-white shadow">
				<div class="container-fluid">
					<div class="page-header-content py-3">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<h1 class="page-header-title">
									<div class="page-header-icon"><i class="fas fa-file"></i></div>
									<span>&nbsp; Service Item Report</span>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<div class="col-12">
							<form id="search">
								<div class="row">

									<div class="col-2" id="select_from">
										<label class="small font-weight-bold text-dark"> From*</label>
										<input type="date" class="form-control form-control-sm" placeholder=""
											name="date_from" id="date_from" value="<?php echo date("Y-m-d"); ?>"
											required>
									</div>
									&nbsp;
									<div class="col-2" id="select_to">
										<label class="small font-weight-bold text-dark"> To*</label>
										<input type="date" class="form-control form-control-sm" placeholder=""
											name="date_to" id="date_to" value="<?php echo date("Y-m-d"); ?>" required>
									</div>
									<div class="col-3">
										<label class="small font-weight-bold" name="lblvehicle" id="">Vehicle
											Reg NO*</label>
										<select class="form-control form-control-sm" name="vehicleregno"
											id="vehicleregno" required>
											<option value="">Select</option>
											<?php foreach ($VehicleRegNo->result() as $rowvehicleregno) { ?>
											<option value="<?php echo $rowvehicleregno->idtbl_vehicle ?>">
												<?php echo $rowvehicleregno->vehicle_reg_no ?></option>
											<?php } ?>
										</select>
									</div>

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

									<div class="col-2" id="hidesumbit">&nbsp;<br>
										<button type="submit" class="btn btn-info mb-2"><span id="boot-icon"
												class="bi bi-search"
												style="font-size: 15px;">&nbsp;Search</span></button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-12">
							<hr class="border-dark">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-striped table-bordered table-sm nowrap" id="tblsalessummary"
									style="width:100%">
									<thead class="thead-light">
										<tr>
											<th>Service Item</th>
											<th>Quantity</th>

										</tr>
									</thead>
									<tbody>
									</tbody>
									<tfoot>
										<tr>
											<th style="text-align:right">Total:</th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<?php include "include/footer.php"; ?>
<script>
	let today = new Date().toISOString().slice(0, 10)

	$(document).ready(function () {
		$("#search").submit(function (event) {
			event.preventDefault();

			$('#tblsalessummary').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				scrollY: 350,
				ajax: {
					url: "<?php echo base_url() ?>scripts/rptserviceitemlist.php",
					type: "POST", // you can use GET
					"data": function (d) {
						return $.extend({}, d, {
							"search_from_date": $("#date_from").val(),
							"search_to_date": $("#date_to").val(),
							"search_vehicle": $("#vehicleregno").val(),
							"search_type": $("#servicetype").val(),
						});
					}
				},
				"order": [
					[0, "desc"]
				],
				"columns": [{
						"data": "service_type"
					},
					{
						"data": "quantity"
					}
					// {
					// 	"data": "rejection"
					// }

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
						title: 'Dairy ',
						filename: 'Ref Sale Route Report' + today,
						footer: true,
						messageTop: {
							text: 'Ref Sale Route Report',
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
						filename: 'Ref Sale Route Report' + today,
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Ref Sale Route Report' + today,
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'Dairy ',
						filename: 'Ref Sale Route Report' + today,
						footer: true,
						messageTop: 'Ref Sale Route Report',
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

					// Total Amount over all pages
					batta = api
						.column(1)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Total over this page
					amount_pageTotal = api
						.column(1, {
							page: 'current'
						})
						.data()
						.reduce(function (a, b) {
							return parseFloat(intVal(a) + intVal(b)).toFixed(2);
						}, 0);

					// Update footer
					$(api.column(1).footer()).html(
						// pageTotal=parseFloat(pageTotal).toFixed(2);
						 + amount_pageTotal
					);
				},
				drawCallback: function (settings) {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});
	});
</script>