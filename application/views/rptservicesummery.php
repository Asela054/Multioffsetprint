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
									<span>&nbsp; Service Summary Report</span>
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
									<div class="col-3">
										<label class="small font-weight-bold text-dark">Report Type*</label>
										<div class="input-group input-group-sm">
											<select class="form-control form-control-sm" name="report_type"
												id="report_type">
												<option value="0">Select</option>
												<option value="1">Vehicle Reg NO</option>
												<option value="2">Supplier</option>
											</select>
										</div>
									</div>

									<div class="col-2" id="select_from" style="display: none" >
										<label class="small font-weight-bold text-dark"> From*</label>
										<input type="date" class="form-control form-control-sm" placeholder=""
											name="date_from" id="date_from"  value="<?php echo date("Y-m-d"); ?>"
											required>
									</div>
									&nbsp;
									<div class="col-2" id="select_to" style="display: none" >
										<label class="small font-weight-bold text-dark"> To*</label>
										<input type="date" class="form-control form-control-sm" placeholder=""
											name="date_to" id="date_to" value="<?php echo date("Y-m-d"); ?>" required>
									</div>

									<div class="col-2">
										<div id="lblvehicle" style="display: none">
											<label class="small font-weight-bold" name="lblvehicle" id="">Vehicle
												Reg NO*</label>
											<select class="form-control form-control-sm" name="vehicleregno" id="vehicleregno" >
												<option value="">Select</option>
												<option value="all">All</option>
												<?php foreach ($VehicleRegNo->result() as $rowvehicleregno) { ?>
												<option value="<?php echo $rowvehicleregno->idtbl_vehicle ?>">
													<?php echo $rowvehicleregno->vehicle_reg_no ?></option>
												<?php } ?>
											</select>
										</div>

									</div>

									<div class="col-2" style="display: none" id="lblsuplier">
										<div class="form-group">
											<label class="small font-weight-bold" name="lblsuplier"
												>Supplier*</label>
											<select class="form-control form-control-sm" name="supplier" id="supplier"
												>
												<option value="">Select</option>
												<option value="all">All</option>
												<?php foreach ($Supplier->result() as $rowsupplier) { ?>
												<option value="<?php echo $rowsupplier->idtbl_supplier ?>">
													<?php echo $rowsupplier->suppliername ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									</div>
									<div class="row">
									<div class="col-2" style="display: none;" id="hidesumbit">&nbsp;<br>
										<button type="submit" class="btn btn-info mb-2"><span id="boot-icon"
												class="bi bi-search"
												style="font-size: 15px;">&nbsp;Search</span></button></div>
									</div>
									
								
							</form>



							<!-- <div class="col-2" id="select_from">
                       				<label class="small font-weight-bold text-dark"> From*</label>
                       				<input type="date" class="form-control form-control-sm" placeholder=""
                       					name="date_from" id="date_from" value="<?php echo date("Y-m-d"); ?>" required>
                       			</div>
                       			&nbsp;
                       			<div class="col-2" id="select_to">
                       				<label class="small font-weight-bold text-dark"> To*</label>
                       				<input type="date" class="form-control form-control-sm" placeholder=""
                       					name="date_to" id="date_to" value="<?php echo date("Y-m-d"); ?>" required>
                       			</div> -->

							<div class="col-12">
								<hr class="border-dark">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-striped table-bordered table-sm nowrap"
										id="tblservicesummary" style="width:100%">
										<thead class="thead-light">
											<tr>

												<th>Vehicle Reg NO</th>
												<th>Service Type</th>
												<th>Supplier</th>
												<th>Service Date</th>
												<th>Next Renew Date</th>
												<th>Current Mileage (Km)</th>
												<th>Next Service Mileage</th>
												<th>Amount</th>
												<!-- <th>BATTA</th> -->
											</tr>
										</thead>
										<tbody>
										</tbody>
										<tfoot>
											<tr>

												<th colspan="6"></th>
												<th style="text-align:right">Total:</th>
												<th class="text-right"></th>


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

<script type="text/javascript">
	$(function () {
		$("#report_type").change(function () {
			if ($(this).val() == 1) {
                $("#select_from").show();
                $("#select_to").show();
				$("#hidesumbit").show();
				$("#vehicleregno").show();
				$("#supplier").hide();
				$("#lblvehicle").show();
				$("#lblsuplier").hide();
			} else if ($(this).val() == 2) {
				$("#select_from").show();
                $("#select_to").show();
				$("#hidesumbit").show();
				$("#vehicleregno").hide();
				$("#supplier").show();
				$("#lblvehicle").hide();
				$("#lblsuplier").show();
			} else {
                $("#select_from").hide();
                $("#select_to").hide();
				$("#vehicleregno").hide();
				$("#supplier").hide();
				$("#hidesumbit").hide();
				$("#lblvehicle").hide();
				$("#lblsuplier").hide();
			}
		});
	});
</script>



<script>
	let today = new Date().toISOString().slice(0, 10)

	$(document).ready(function () {
		$("#search").submit(function (event) {
			event.preventDefault();

			$('#tblservicesummary').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				scrollY: 350,
				ajax: {
					url: "<?php echo base_url() ?>scripts/rptservicesum.php",
					type: "POST", // you can use GET
					"data": function (d) {
						return $.extend({}, d, {
							"search_from_date": $("#date_from").val(),
							"search_to_date": $("#date_to").val(),
							"search_vehicle": $("#vehicleregno").val(),
                            "search_supplier": $("#supplier").val(),

							// var :ser_type = data($("#servicetype").val()),
							// "search_type": $(ser_type).val()

						});
					}
				},
				"order": [
					[0, "desc"]
				],

				"createdRow": function (row, data, dataIndex) {
					var checkdate = data['next_renew_date'];
					if (checkdate !== null) {
						var vals = data['next_renew_date'].split('-');

						var y = vals[0];
						var m = vals[1];
						var d = vals[2];

						var year = parseInt(y)
						var month = m - 1
						var date = parseInt(d)

						currentdate = new Date();
						currentyear = currentdate.getFullYear();
						currentmonth = currentdate.getMonth() + 1;
						currentday = currentdate.getDate();
						// console.log(currentyear,currentmonth,currentday,month,date)
						if (currentmonth >= month && date <= currentday && year ==
							currentyear) {
							$(row).addClass('bg-pink text-white');
						}

					}


				},





				"columns": [

					{
						"data": "vehicle_reg_no"
					},
					{
						"targets": -1,
						"className": 'text-left',
						"data": null,
						"render": function (data, type, full) {
							var text = '';

							if (full['servicetype'] == 1) {
								text += '<label class="font-weight">Repair</label>';
							} else {
								text +=
									'<label class="font-weight">Regular Service</label>';
							}

							return text;
						}
					},
					{
						"data": "name"
					},
					{
						"data": "service_date"
					},
					{
						"data": "next_renew_date"
					},
					{
						"data": "mileage"
					},
					{
						"data": "next_service_mileage"
					},
					
					// {
					//     "data": "servicetype"
					// },
					
					{
						"data": "amount",
						"className": 'text-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},

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
						title: 'MULTI_DVMT',
						filename: 'Service Summary Report' + today,
						footer: true,
						messageTop: {
							text: 'Service Summary Report',
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
						filename: 'Service Summary Report' + today,
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Service Summary Report' + today,
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'MULTI_DVMT',
						filename: 'Service Summary Report' + today,
						footer: true,
						messageTop: 'Service Summary Report',
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
						.column(7)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Total over this page
					amount_pageTotal = api
						.column(7, {
							page: 'current'
						})
						.data()
						.reduce(function (a, b) {
							return parseFloat(intVal(a) + intVal(b)).toFixed(2);
						}, 0);

					// Update footer
					$(api.column(7).footer()).html(
						// pageTotal=parseFloat(pageTotal).toFixed(2);
						'Rs ' + amount_pageTotal
					);
				},
				drawCallback: function (settings) {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});
	});
</script>