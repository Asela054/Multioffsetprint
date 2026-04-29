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
							<div class="page-header-icon"><i class="fas fa-clipboard"></i></div>
                            <span>Credit Note</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searchvat">
								<div class="col-12">
									<div class="form-row">
										<div class="col-2">
											<label class="small font-weight-bold">Customer*</label>
											<select class="form-control form-control-sm selecter2 px-0" name="customer"
												id="customer" required>
												<option value="">Select</option>
												<option value="all">All</option>
												<?php foreach ($getcustomer->result() as $rowgetcustomer) { ?>
												<option value="<?php echo $rowgetcustomer->idtbl_customer ?>">
													<?php echo $rowgetcustomer->customer ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-1" id="hidesumbit">&nbsp;<br>
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
									<table class="table table-bordered table-striped table-sm nowrap w-100"
										id="dataTable">
										<thead class="thead-light">
                                            <tr>
                                                <th>Invoice Number</th>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Total Amount</th>
                                                <th class="text-right">Actions</th>
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
<!-- Modal Return Invoice -->
<div class="modal fade" id="modalReturninvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="dailycompletemodaldropLabel">Return Invoice</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
							<input type="hidden" name="hideinvoiceid" id="hideinvoiceid" value="">
							<input type="hidden" name="f_company_id" id="f_company_id">
							<input type="hidden" name="f_branch_id" id="f_branch_id">
							<div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Dispatch No.*</label>
                                        <select class="form-control form-control-sm" id="dispatchno" name="dispatchno" required>
                                            <option value="">Select</option>
                                        </select>
                                </div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Job No.</label>
                                    <input type="hidden" name="jobid" id="jobid" class="form-control form-control-sm"
                                    readonly>
									<input type="text" name="jobno" id="jobno" class="form-control form-control-sm"
										readonly>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Qty</label>
									<input type="number" name="qty" id="qty" class="form-control form-control-sm">
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Unit Price</label><br>
									<input type="text" name="unitprice" id="unitprice"
										class="form-control form-control-sm">
								</div>
							</div>
                            <div class="form-group mb-1">
                                    <label class="small font-weight-bold">Job</label>
                                    <input type="text" name="job" id="job" class="form-control form-control-sm" readonly>
							</div>
							<div class="form-group mb-1">
                                <label class="small font-weight-bold">Return Type*</label><br>
                                        <select class="form-control form-control-sm materialinfo" style="width: 100%;" name="returntype" id="returntype" required>
                                            <option value="">Select</option>
                                            <option value="1">Create New Job Card</option>
                                            <option value="2">Edit Previous Job</option>
                                        </select>
							</div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-warning font-weight-bold btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
						<div class="scrollbar pb-3" id="style-3">
							<table class="table table-striped table-bordered table-sm small" id="tableorder">
								<thead>
									<tr>
										<th>Job</th>
                                        <th>Dispatch No</th>
                                        <th>Return Type</th>
										<th class="d-none">JobID</th>
                                        <th class="d-none">DispatchID</th>
                                        <th class="d-none">ReturntypeID</th>
										<th class="d-none">Saleprice</th>
                                        <th>Unitprice</th>
										<th class="text-center">Return Qty</th>
										<th class="d-none">HideTotal</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="row">
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">
                                <h4>Total : </h4>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                <h3 class="text-dark" id="divtotal">0.00</h3>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">
                                <h4>Vat (%) : </h4>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
								<h3 class="text-dark" id="showVathtml">%</h3>
							</div>
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">
                                <h4>Vat Amount : </h4>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                <h3 class="text-dark" id="showtaxAmount">0.00</h3>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">
                                <h4>Total + (VAT) : </h4>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                <h3 class="text-dark" id="showPrice">0.00</h3>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="">
                            <input type="hidden" id="showVat" value="">
                            <input type="hidden" id="txtShowtaxAmount" value="">
                            <input type="hidden" id="txtShowPrice" value="">
                        </div>
						<hr>
						<div class="form-group">
							<label class="small font-weight-bold text-dark">Remark</label>
							<textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
						</div>
						<div class="form-group mt-2">
							<button type="button" id="btncreateorder" class="btn btn-primary btn-sm fa-pull-right"><i
									class="fas fa-save"></i>&nbsp;Create
								Return Invoice</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewReturnInvoicelist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">View Return Invoice List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewreturninvoicedata"></div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Return Invoice -->
<div class="modal fade" id="modalprintinvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="dailycompletemodaldropLabel">Print Credit Note</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div id="viewreceiptprint"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm fa-pull-right" id="btnreceiptprint"><i class="fas fa-print"></i>&nbsp;Print Receipt</button>
            </div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
    var addcheck='<?php echo $addcheck; ?>';
    var editcheck='<?php echo $editcheck; ?>';
    var statuscheck='<?php echo $statuscheck; ?>';
    var deletecheck='<?php echo $deletecheck; ?>';

	$(document).ready(function () {
		$('.selecter2').select2();

		$('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
        $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
        $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
        $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');

		$("#searchvat").submit(function (event) {
			event.preventDefault();

			var table = $('#dataTable').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				//scrollY: 350,
				ajax: {
					url: "<?php echo base_url() ?>scripts/creditnotelist.php",
					type: "POST", // you can use GET 
					"data": function (d) {
						return $.extend({}, d, {
							"customer": $("#customer").val(),
							"company_id": $("#f_company_id").val(),
						});
					}
				},
				"order": [
					[0, "desc"]
				],
				"columns": [
                    {
                        "data": "inv_no"
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "customer"
                    },
                    {
                        "data": null,
                        "render": function(data, type, full) {
                            return addCommas(parseFloat(full['total']).toFixed(2));
                        }
                    },
                    {
                        "targets": -1,
                        "className": 'text-right',
                        "data": null,
                        "render": function(data, type, full) {
                            var button = '';
                                button+='<button data-toggle="tooltip" data-placement="bottom" title="Return Invoice"  class="btn btn-dark btn-sm btnReturn mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_print_invoice']+'"><i class="fas fa-undo-alt"></i></button>';
								button+='<button data-toggle="tooltip" data-placement="bottom" title="Print Credit Note" class="btn btn-danger btn-sm btnreturnviewList mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_print_invoice']+'"><i class="fas fa-file-alt"></i></button>';
                            return button;
                        }
                    }
                ],
				dom: 'Bfrtip',
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
						title: 'Vat Report',
						filename: 'Vat Report ',
						footer: true,
						messageTop: {
							text: 'Vat Report',
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
						filename: 'Vat Report ',
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true,
						title: 'MULTI OFFSET PRINTERS Vat Report - By Erav Technology'
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Vat Report ',
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'Vat Report',
						filename: 'Vat Report ',
						footer: true,
						messageTop: 'Vat Report ',
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

		$(document).on("click", ".btnreturnviewList", function () {
        	var id = $(this).attr('id');
        	$('#viewReturnInvoicelist').modal('show');
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Creditnote/Getretruninvoicedetails',
        		success: function (result) { //alert(result);

        			$('#viewreturninvoicedata').html(result);
        			$('#tblReturnInvoicelist').DataTable({
        				"ordering": false,
        				dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        				responsive: true,
        				lengthMenu: [
        					[10, 25, 50, -1],
        					[10, 25, 50, 'All'],
        				],
        				"buttons": [{
        						extend: 'csv',
        						className: 'btn btn-success btn-sm',
        						title: 'Invoice List',
        						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
        					},
        					{
        						extend: 'pdf',
        						className: 'btn btn-danger btn-sm',
        						title: 'Invoice List',
        						text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
        					},
        					{
        						extend: 'print',
        						title: 'Invoice List',
        						className: 'btn btn-primary btn-sm',
        						text: '<i class="fas fa-print mr-2"></i> Print',
        						customize: function (win) {
        							$(win.document.body).find('table')
        								.addClass('compact')
        								.css('font-size', 'inherit');
        						},
        					},
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

        					// Total over all pages
        					total = api
        						.column(3)
        						.data()
        						.reduce(function (a, b) {
        							return intVal(a) + intVal(b);
        						}, 0);

        					// Total over this page
        					pageTotal = api
        						.column(3, {
        							page: 'current'
        						})
        						.data()
        						.reduce(function (a, b) {
        							return parseFloat(intVal(a) + intVal(b)).toFixed(2);
        						}, 0);

        					// Update footer
        					$(api.column(3).footer()).html(
        						// pageTotal=parseFloat(pageTotal).toFixed(2);
        						'Rs. ' + pageTotal
        					);

        				},
        				drawCallback: function (settings) {
        					$('[data-toggle="tooltip"]').tooltip();
        				}
        			});;


        		}
        	});
        });

		$(document).on("click", ".btnprintReturn", function () {
			var id = $(this).attr('id');

			$('#modalprintinvoice').modal('show');
			$('#viewreceiptprint').html('<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>');

			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: "<?php echo base_url() ?>Creditnote/Getinvoiceprint",
				success: function (result) { //alert(result);
					$('#viewreceiptprint').html(result);
				}
			});
		});
		document.getElementById('btnreceiptprint').addEventListener("click", print);


        $("#formsubmit").click(function () {
            if (!$("#createorderform")[0].checkValidity()) {
                $("#submitBtn").click();
            } else {
                var unitprice = parseFloat($('#unitprice').val());
                var qty = parseFloat($('#qty').val());

                var newtotal = parseFloat(unitprice * qty);
                var total = parseFloat(newtotal);
                var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + 
                    $('#job').val() + '</td><td>' + 
                    $("#dispatchno option:selected").text() + '</td><td>' + 
                    $("#returntype option:selected").text() + '</td><td class="d-none">' + 
                    $('#jobid').val() + '</td><td class="d-none">' + 
                    $('#dispatchno').val() + '</td><td class="d-none">' + 
                    $('#returntype').val() + '</td><td class="d-none">' + 
                    unitprice + '</td><td>' + unitprice + '</td><td class="text-center">' + 
                    qty + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + 
                    showtotal + '</td></tr>');

                $('#dispatchno, #returntype, #returnqty, #comment').val('');

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var vatPercentage = parseFloat($('#showVat').val()) || 0;
                var vatAmount = (sum * vatPercentage) / 100;
                var totalWithVat = sum + vatAmount;

                $('#divtotal').html('Rs. ' + addCommas(parseFloat(sum).toFixed(2)));
                $('#showtaxAmount').html('Rs. ' + addCommas(parseFloat(vatAmount).toFixed(2)));
                $('#showPrice').html('Rs. ' + addCommas(parseFloat(totalWithVat).toFixed(2)));

                $('#hidetotalorder').val(sum);
                $('#txtShowtaxAmount').val(vatAmount);
                $('#txtShowPrice').val(totalWithVat);

                $('#productlist').focus();
            }
        });

    	$('#tableorder').on('click', 'tr', function () { 
            var r = confirm("Are you sure, you want to remove this product?");
            if (r == true) {
                $(this).closest('tr').remove();

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var vatPercentage = parseFloat($('#showVat').val()) || 0;

                var vatAmount = (sum * vatPercentage) / 100;
                var totalWithVat = sum + vatAmount;

                var showsum = addCommas(parseFloat(sum).toFixed(2));
                var showVatAmount = addCommas(parseFloat(vatAmount).toFixed(2));
                var showTotalWithVat = addCommas(parseFloat(totalWithVat).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
                $('#showtaxAmount').html('Rs. ' + showVatAmount);
                $('#showPrice').html('Rs. ' + showTotalWithVat);

                $('#hidetotalorder').val(sum);
                $('#txtShowtaxAmount').val(vatAmount);
                $('#txtShowPrice').val(totalWithVat);

                $('#product').focus();
            }
        });
    	$('#btncreateorder').click(function () {
    		$('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Return Invoice')
    		var tbody = $("#tableorder tbody");

    		if (tbody.children().length > 0) {
    			jsonObj = [];
    			$("#tableorder tbody tr").each(function () {
    				item = {}
    				$(this).find('td').each(function (col_idx) {
    					item["col_" + (col_idx + 1)] = $(this).text();
    				});
    				jsonObj.push(item);
    			});

    			var hideinvoiceID = $('#hideinvoiceid').val();
    			var remark = $('#remark').val();
    			var total = $('#hidetotalorder').val();
    			var tax = $('#txtShowtaxAmount').val();
    			var totalwithtax = $('#txtShowPrice').val();
    			var f_company_id = $('#f_company_id').val();
    			var f_branch_id = $('#f_branch_id').val();

    			Swal.fire({
    				title: "",
    				html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
    				allowOutsideClick: false,
    				showConfirmButton: false,
    				backdrop: "rgba(255, 255, 255, 0.5)",
    				customClass: {
    					popup: "fullscreen-swal"
    				},
    				didOpen: () => {
    					document.body.style.overflow = "hidden";

    					$.ajax({
    						type: "POST",
    						data: {
    							tableData: jsonObj,
    							hideinvoiceID: hideinvoiceID,
    							total: total,
    							tax: tax,
    							totalwithtax: totalwithtax,
    							f_company_id: f_company_id,
    							f_branch_id: f_branch_id,
    							remark: remark
    						},
    						url: 'Creditnote/Returninvoiceinsertupdate',
    						success: function (result) {
    							Swal.close();
    							document.body.style.overflow = "auto";

    							var response = JSON.parse(result);
    							if (response.status == 1) {
    								$('#modalReturninvoice').modal('hide');
    								Swal.fire({
    									icon: "success",
    									title: "Dispatch Note Created!",
    									text: "Dispatch Note successfully!",
    									timer: 2000,
    									showConfirmButton: false
    								}).then(() => {
    									window.location.reload();
    								});
    							} else {
    								Swal.fire({
    									icon: "error",
    									title: "Error",
    									text: "Something went wrong. Please try again later.",
    								});
    							}
    						},
    						error: function () {
    							Swal.close();
    							document.body.style.overflow = "auto";
    							Swal.fire({
    								icon: "error",
    								title: "Error",
    								text: "Something went wrong. Please try again later.",
    							});
    						}
    					});
    				},
    			});
    		}
    	});

        $('#dispatchno').change(function () {
        	let dispatchID = $(this).val();

        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: dispatchID
        		},
        		url: '<?php echo base_url() ?>Creditnote/Getjobdetails',
        		dataType: 'json',
        		success: function (result) { //alert(result);
        			$('#qty').val(result.qty);
        			$('#unitprice').val(result.unitprice);
        			$('#jobid').val(result.job_id);
                    $('#jobno').val(result.job_no);
        			$('#job').val(result.job);

        		}
        	});
        });

        $(document).on("click", ".btnReturn", function () {
            var id = $(this).attr("id");
            $("#hideinvoiceid").val(id);
            $("#modalReturninvoice").modal("show");

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>Creditnote/fetchDispatchList",
                data: { hideinvoiceid: id },
                dataType: "json",
                success: function (response) {
                    var dispatchDropdown = $("#dispatchno");
                    dispatchDropdown.empty();
                    dispatchDropdown.append('<option value="">Select</option>');

                    $.each(response.dispatchList, function (index, item) {
                        dispatchDropdown.append('<option value="' + item.id + '">' + item.dispatch_no + '</option>');
                    });

                    $("#showVathtml").text(response.percentage + "%");
                    $("#showVat").val(response.percentage);
                },
                error: function () {
                    alert("Failed to fetch dispatch numbers!");
                }
            });
        });
        $('#modalReturninvoice').on('hidden.bs.modal', function () {
        	$(this).find('input').val('');
        	$(this).find('select').val('');
        	$(this).find('.error-message').hide();
        	$(this).find('.is-invalid').removeClass('is-invalid');
        	$(this).find('.is-valid').removeClass('is-valid');
        	$(this).find('textarea').val('');
        });
	});
	
	function print() {
        printJS({
            printable: 'viewreceiptprint',
            type: 'html',
            style: '@page { size: A4 portrait; margin:0.25cm; }',
            targetStyles: ['*']
        })
    }

    function addCommas(nStr) {
    	nStr += '';
    	x = nStr.split('.');
    	x1 = x[0];
    	x2 = x.length > 1 ? '.' + x[1] : '';
    	var rgx = /(\d+)(\d{3})/;
    	while (rgx.test(x1)) {
    		x1 = x1.replace(rgx, '$1' + ',' + '$2');
    	}
    	return x1 + x2;
    }

</script>

<?php include "include/footer.php"; ?>
