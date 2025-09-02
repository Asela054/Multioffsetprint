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
        					<span>Stock Report</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="col-12">
                            <form id="searchGrn">
                                <div class="col-12">
                                <div class="form-row">
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
                                                    <!-- <option value="5">All GRN</option> -->
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
                                            <label class="small font-weight-bold">Type*</label>
                                            <select class="form-control form-control-sm" name="type" id="type" required>
                                                <option value="">Select</option>
                                                <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                                <option value="<?php echo $rowordertypelist->idtbl_material_group ?>">
                                                    <?php echo $rowordertypelist->group ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold">Supplier*</label>
                                            <select class="form-control form-control-sm selecter2 px-0" name="supplier" id="supplier" required>
                                                <option value="">Select</option>
                                                <option value="0">All</option>
                                                <?php foreach ($getsuppier->result() as $rowgetsuppier) { ?>
                                                <option value="<?php echo $rowgetsuppier->idtbl_supplier ?>"><?php echo $rowgetsuppier->suppliername ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-1" style="display: none;" id="hidesumbit">&nbsp;<br>
                                            <button type="submit"
                                                class="btn btn-info btn-sm ml-auto w-25 mt-2 px-5">Search</button>
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
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead class="thead-light">
        									<tr>
        										<th>#</th>
												<th>Product Name</th>
        										<th>Batch No</th>
                                                <th>Location</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
        									</tr>
        								</thead>
										<tbody>
                                    	</tbody>
                                    	<tfoot class="thead-light">
                                    		<tr>
                                    			<th colspan="4" class="text-right"></th>
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

<script>
    $(document).ready(function () {
        $('.selecter2').select2();
        $(function () {
        $("#report_type").change(function () {
            if ($(this).val() == 1) {
                $("#select_date").show();
                $("#hidesumbit").show();
                $("#select_week").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 2) {
                $("#select_week").show();
                $("#hidesumbit").show();
                $("#select_date").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 3) {
                $("#select_month").show();
                $("#hidesumbit").show();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 4) {
                $("#select_from").show();
                $("#select_to").show();
                $("#hidesumbit").show();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_month").hide();
            } else if ($(this).val() == 5) {
                $("#hidesumbit").show();
            } else {
                $("#inv_type").hide();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
                $("#hidesumbit").hide();
            }
        });
    });


		$("#searchGrn").submit(function (event) {
			event.preventDefault();

			var selectedType = $("#type").val();

			var table = $('#dataTable').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				//scrollY: 350,
				ajax: {
					url: "<?php echo base_url() ?>scripts/advancegrnreportlist.php",
					type: "POST", // you can use GET
                    "data": function (d) {
                        return $.extend({}, d, {
                            "search_date": $("#date").val(),
                            "search_week": $("#week").val(),
                            "search_month": $("#month").val(),
                            "search_from_date": $("#date_from").val(),
                            "search_to_date": $("#date_to").val(),
                            "report_type": "5",
                            "search_type": $("#type").val(),
                            "supplier": $("#supplier").val(),
                        });
                    }
				},
				"order": [
					[0, "desc"]
				],
				"columns": [
					{
						"data": "idtbl_print_grn"
					},
					// {
					// 	"data": "machine"
					// },
					{
						"data": null,
						render:function(data, type, full) {
							if (selectedType == 1) {
								return full.spare_part_name; 
							} else if (selectedType == 2) {
								return full.materialname;
							} else {
								return full.machine;
							}
						}
                    },
                    {
						"data": "batchno"
					},
					{
						"data": "batchno"
					},
                    {
						"data": "location"
					},
                    {
						"data": "qty"
					},
                    {
						"data": "unitprice",
						"className": "text-right"
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
						title: 'Grn Report',
						filename: 'Grn Report ',
						footer: true,
						messageTop: {
							text: 'Grn Report',
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
						filename: 'Grn Report ',
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true,
						title: 'MULTI OFFSET PRINTERS Grn Report - By Erav Technology'
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Grn Report ',
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'Grn Report',
						filename: 'Grn Report ',
						footer: true,
						messageTop: 'Grn Report ',
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
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page for column 3 (index 2)
                    var pageTotalColumn3 = api
                        .column(5, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function (a, b) {
                            return parseFloat(intVal(a) + intVal(b)).toFixed(2);
                        }, 0);

                    // Update footer of column 3 with the page total
                    $(api.column(5).footer()).html('Rs. ' + pageTotalColumn3);
                },
				drawCallback: function (settings) {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});
	});
</script>

<?php include "include/footer.php"; ?>
