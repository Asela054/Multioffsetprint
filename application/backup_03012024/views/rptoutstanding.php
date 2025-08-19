<?php 
include "include/header.php"; 

include "include/topnavbar.php"; 
?>

<style>
    content-display {
        display: none;
    }
</style>


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
							<span>&nbsp; Customer Outstanding Report</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body">

						<div class="row">
							<div class="col-12">
								<form id="searchReport">
									<div class="form-row">
										<div class="col-2">
											<div class="form-group">
												<label class="small font-weight-bold">Customer*</label>
												<select class="form-control form-control-sm selecter2 px-0"
													name="customer" id="customer" required>
													<option value="">Select</option>
													<?php foreach ($getcustomer->result() as $rowgetcustomer) { ?>
													<option value="<?php echo $rowgetcustomer->idtbl_customer ?>">
														<?php echo $rowgetcustomer->name ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-2">
											<label class="small font-weight-bold text-dark">Report Type*</label>
											<div class="input-group input-group-sm">
												<select class="form-control form-control-sm" name="report_type"
													id="report_type">
													<option value="0">Select</option>
													<option value="1">Daily</option>
													<option value="2">Weekly</option>
													<option value="3">Monthly</option>
													<option value="4">Date Range</option>
												</select>
											</div>
										</div>
										<div class="col-2" style="display: none" id="select_date">
											<label class="small font-weight-bold text-dark"> Date*</label>
											<input type="date" class="form-control form-control-sm " placeholder=""
												name="date" id="date">
										</div>

										<div class="col-2" style="display: none" id="select_week">
											<label class="small font-weight-bold text-dark"> Week*</label>
											<input type="week" class="form-control form-control-sm" placeholder=""
												name="week" id="week">
										</div>
										<div class="col-2" style="display: none" id="select_month">
											<label class="small font-weight-bold text-dark"> Month*</label>
											<input type="month" class="form-control form-control-sm" placeholder=""
												name="month" id="month">
										</div>
										&nbsp;
										<div class="col-2" style="display: none" id="select_from">
											<label class="small font-weight-bold text-dark"> From*</label>
											<input type="date" class="form-control form-control-sm" placeholder=""
												name="date_from" id="date_from">
										</div>
										&nbsp;
										<div class="col-2" style="display: none" id="select_to">
											<label class="small font-weight-bold text-dark"> To*</label>
											<input type="date" class="form-control form-control-sm" placeholder=""
												name="date_to" id="date_to">
										</div>
										<div class="col-2">
											<div class="custom-control custom-checkbox mt-4">
												<input class="custom-control-input" type="checkbox" value="1" id="all" name="all" checked>
												<label class="custom-control-label" for="all">
													All Outstanding
												</label>
											</div>
										</div>
										<div id="hidesumbit">&nbsp;<br>
											<button type="submit"
												class="btn btn-outline-primary btn-sm mr-5 w-25 mt-2 px-5">Search</button>
										</div>
										<br>
										<p class="text-danger">If you want to get outstandings of the customers, Please uncheck the "All Outstanding" checkbox</p>
									</div>
								</form>
							</div>
							<div class="col-12">
								<hr class="border-dark">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap w-100"
										id="dataTable">
										<thead class="thead-light">
											<tr>
												<th>Customer Name</th>
												<th>Invoice No</th>
												<th>Invoice Amount</th>
												<th>Pay Amount</th>
												<th>Balance</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										<tfoot class="thead-light">
											<tr>
												<th colspan="3" class="text-right"></th>
												<th class="text-right">Total:</th>
												<th></th>
											</tr>
										</tfoot>
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


<script type="text/javascript">
    let today = new Date().toISOString().slice(0, 10)

    $(function () {
        $("#report_type").change(function () {
            if ($(this).val() == 1) {
                $("#select_date").show();
                $("#select_week").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 2) {
                $("#select_week").show();
                $("#select_date").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 3) {
                $("#select_month").show();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 4) {
                $("#select_from").show();
                $("#select_to").show();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_month").hide();
			}
			 else {
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            }
        });
    });

	$(document).ready(function () {
		toggleInputFields();

		$("#all").change(function () {
			toggleInputFields();
		});

		function toggleInputFields() {
			const isChecked = $("#all").is(':checked');
			$("#date, #week, #month, #date_from, #date_to, #customer").prop("disabled", isChecked);
		}
	});



    $(document).ready(function () {

        $("#customer").select2();

        $("#searchReport").submit(function (event) {
            event.preventDefault();

            $('#dataTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: "scripts/rptoutstandinglist.php",
                    type: "POST", // you can use GET
                    "data": function (d) {
						return $.extend({}, d, {
							"search_date": $("#date").val(),
							"search_week": $("#week").val(),
							"search_month": $("#month").val(),
							"search_from_date": $("#date_from").val(),
							"search_to_date": $("#date_to").val(),
							"customer": $("#customer").val(),
							"all": $("#all").is(':checked') ? 1 : 0
						});
					}
                },
                "order": [
                    [0, "desc"]
                ],
                "columns": [
                    {
                        "data": "name"
                    },
                    {
                        "data": "inv_no"
                    },  
					{
						"data": "total",
						"render": function(data, type, row) {
							return parseFloat(data).toLocaleString(); 
						}
					},
					{
						"data": "amount",
						"render": function(data, type, row) {
							return parseFloat(data).toLocaleString();
						}
					},
					{
						"data": null,
						"render": function(data, type, row) {
							let total = parseFloat(row.total) || 0;
							let amount = parseFloat(row.amount) || 0;
							let balance = total - amount;
							return balance.toFixed(2).toLocaleString();
						},
						"title": "Balance"
					}
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
                dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                responsive: true,
                buttons: [
                    {
                        extend: 'csv',
                        className: 'btn btn-success btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: 'Sales Order Report'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-info btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: 'Sales Order Report'
                    },
                    {
                        extend: 'pdf',
                        pageSize: 'A3',
                        className: 'btn btn-danger btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: {
                            text: 'Sales Order Report',
                            fontSize: 20,
                            bold: true,
                            alignment: 'center'
                        },
                        customize: function (doc) {
                            doc.styles.title = {
                                bold: 60,
                                color: '#2F5233',
                                fontSize: '30',
                                alignment: 'center',
                            }
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-print mr-2"></i> PRINT',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: 'Sales Order Report',
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

					var intVal = function (i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ? i : 0; 
					};

					total = api
					.column(4)
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);


					pageTotal = api
						.column(4, { page: 'current' })
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					$(api.column(4).footer()).html(
						'Rs. ' + pageTotal.toLocaleString()
					);
				}
            });



        });
    });
</script>

<?php include "include/footer.php"; ?>