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
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Purchase Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#staticBackdrop"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create
                                    Purchase Order</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>P-Order Number</th>
                                                <th>Date</th>
                                                <th>Order Type</th>
                                                <th>Supplier</th>
                                                <th>Confirm Status</th>
                                                <th>GRN Issue Status</th>
                                                <th>Total</th>
                                                <th class="text-right">Actions</th>
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
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
						<form id="createorderform" autocomplete="off">
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Order Date*</label>
								<input type="date" class="form-control form-control-sm" placeholder="" name="orderdate"
									id="orderdate" value="<?php echo date('Y-m-d')?>" required>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">PO Request*</label>
									<select class="form-control form-control-sm selecter2 px-0" name="porderrequest"
										id="porderrequest" required>
										<option value="">Select</option>
										<?php foreach($porderlist->result() as $rowporderlist){ ?>
										<option value="<?php echo $rowporderlist->idtbl_print_porder_req ?>">
											<?php echo $rowporderlist->porder_req_no ?></option>
										<?php } ?>
									</select>

								</div>
								<div class="col">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">PO Type*</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="" name="requestordertype" id="requestordertype" required readonly>
									</div>
								</div>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark d-none">Company*</label>
								<input type="text" id="f_company_name" name="f_company_name"
									class="form-control form-control-sm d-none" required readonly>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark d-none">Company Branch*</label>
								<input type="text" id="f_branch_name" name="f_branch_name"
									class="form-control form-control-sm d-none" required readonly>
							</div>
							<input type="hidden" name="f_company_id" id="f_company_id">
							<input type="hidden" name="f_branch_id" id="f_branch_id">

							<div id="supplierFields">
								<div class="form-group mb-1">
									<label class="small font-weight-bold text-dark">Supplier*</label>
									<select class="form-control form-control-sm" name="supplier" id="supplier">
										<option value="">Select</option>
										<?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
										<option value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
											<?php echo $rowsupplierlist->name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
                            <div class="form-group mb-1">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">PO Type*</label>
										<select class="form-control form-control-sm" name="ordertype" id="ordertype" required>
											<option value="">Select</option>
											<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
											<option value="<?php echo $rowordertypelist->idtbl_order_type ?>">
												<?php echo $rowordertypelist->type ?></option>
											<?php } ?>
										</select>
									</div>
							</div>
							<div class="form-row mb-1">
								<div class="col" id="productFields">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Spare Parts / Service / Material
											/ Machine *</label>
										<select class="form-control form-control-sm selecter2 px-0" name="product" id="product">
											<option value="">Select</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col" id="newQtyFields" style="display: none;">
									<label class="small font-weight-bold text-dark">Qty*</label>
									<input type="number" id="newqty" name="newqty" class="form-control form-control-sm" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">UOM*</label>
									<select class="form-control form-control-sm" name="uom"
										id="uom">
										<option value="">Select</option>
										<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
										<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
											<?php echo $rowmeasurelist->measure_type ?></option>
										<?php } ?>
									</select>
								</div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Convert Qty</label>
                                    <div class="input-group">
                                        <input type="text" id="piecesper_qty" name="piecesper_qty"
                                            class="form-control form-control-sm" value="0" readonly>
                                        <input type="text" id="piecesper_qty_uom" name="piecesper_qty_uom"
                                            class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
							</div>

							<div class="form-row mb-1">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="number" id="unitprice" name="unitprice" class="form-control form-control-sm"
                                        value="0" step="any">
							</div>

							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark" hidden>Vat (%)</label>
									<input type="number" id="vat" name="vat" class="form-control form-control-sm" value="0"
										hidden>
								</div>

								<div class="col">
									<label class="small font-weight-bold text-dark" hidden>Discount</label>
									<input type="number" id="discount" name="discount" class="form-control form-control-sm"
										value="0" hidden>
								</div>
							</div>


							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Comment</label>
								<textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
							</div>
							<div class="form-group mt-3 text-right">
								<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
									<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add
									to
									list</button>
								<input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
							</div>
							<input type="hidden" name="refillprice" id="refillprice" value="">
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
						<div id="materialmachinetblpart">
							<div class="scrollbar pb-3" id="style-3">
								<table class="table table-striped table-bordered table-sm small" id="tableorder">
									<thead>
										<tr>
											<th>Product Name</th>
											<th class="d-none">ProductID</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Uom</th>
											<th class="text-right">Unit Price</th>
                                            <th class="text-right">Price</th>
											<th class="d-none">HideTotal</th>
											<th class="text-right">Total</th>

										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
						<div id="vehicletblpart">
							<div class="scrollbar pb-3" id="style-3">
								<table class="table table-striped table-bordered table-sm small" id="vehicletableorder">
									<thead>
										<tr>
											<th>Service Name</th>
											<th class="d-none">ProductID</th>
											<th class="d-none">Unitprice</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Uom</th>
											<th class="text-right">Unit Price</th>
											<th class="d-none">HideTotal</th>
											<th class="text-right">Total</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col text-right">
								<h6 class="font-weight-600" id="divgrosstotal" style="margin-top: 10px;"> Rs. 0.00</h6>

							</div>
							<input type="hidden" id="hidegrosstotalorder" value="0">
						</div>
						<hr>
						<div class="form-group">
							<label class="small font-weight-bold text-dark">Remark</label>
							<textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
						</div>
						<div class="form-group mt-2">
							<button type="button" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i
									class="fas fa-save"></i>&nbsp;Create
								Purchase Order</button>
						</div>
                        <div class="row mt-5 col-12">
                        <div class="form-row mb-1">
                                <div class="col-12" id="productFields">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Requestion</label>
                                        <ul id="requestitem" class="list-group">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
/* Add this style block to your HTML or external CSS file */

/* Define the animation */
@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }
}

/* Apply the animation to the button on hover */
#approve:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    /* Change border color on hover */
    background-color: #4CAF50;
    /* Change background color on hover */
    color: #fff;
    /* Change text color on hover */
}
</style>
<!-- Modal -->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">View Purchase Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-left">
                            <img src="./images/book.jpg" alt="" width="40%" style="margin-top: -20px;">
                        </div>
                        <div class="col-6">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-right" class="text-right">Purchase Order<span id="pr"></span>
                            </h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="viewcompanyname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"> <span id="viewbranchname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right">MO/POD-0000<span id="procode"></span>
                            </P>

                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="porderdate"></span></p>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12">
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliername"></span>
                            </P>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliercontact"></span>
                            </p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress1"></span>
                            </p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress2"></span>
                            </p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordercity"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderstate"></span></p>
                        </div>
                    </div>
                    <div id="viewhtml"></div>
                    <div class="col-7">
                        <button type="button" name="approve" id="approve"
                            class="btn btn-success btn-m fa-pull-right animated-button" title="Approve"><i
                                class="fas fa-check"></i>&nbsp;Approve</button>
                        <input type="text" id="approvebtn" name="approvebtn" hidden>
                        <input type="text" id="reqestid" name="reqestid" hidden>
                        <input type="text" id="statusid" name="statusid" hidden>
                    </div>
                </div>
            </div>
            <input type="hidden" class="form-control form-control-sm" name="tableId" id="tableId" required readonly>

        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>

<script>
$(document).ready(function() {

        $('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
        $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
        $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
        $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');
});
</script>
<script>
$(document).ready(function() {
    $('#vehicletblpart').hide();
    $('#neworderQtyFields').show();
    $('#newQtyFields').show();

    $('#ordertype').change(function() {
        let ordertype = $(this).val();

        if (ordertype == 2) {
            $('#supplierFields').hide();
            $('#productFields').hide();
            $('#newQtyFields').show();
            $('#neworderQtyFields').show();
            $('#servisetypeFields').show();
            $('#supplier').removeAttr('required');
            $('#product').removeAttr('required');
            $('#servicetype').attr('required', 'required');
            $('#unitprice').val('0');
            $('#vehicletblpart').show();
            $('#materialmachinetblpart').hide();

        } else {
            $('#supplier').attr('required', 'required');
            $('#product').attr('required', 'required');
            $('#servicetype').removeAttr('required');
            $('#supplierFields').show();
            $('#productFields').show();
            $('#newQtyFields').show();
            $('#neworderQtyFields').show();
            $('#servisetypeFields').hide();
            $('#vehicletblpart').hide();
            $('#materialmachinetblpart').show();

        }
    });

});
</script>

<script>
$(document).ready(function() {

    $('#porderrequest').select2({
        dropdownParent: $('#staticBackdrop'),
        width: '100%',
    });
    $('#location').select2({
        dropdownParent: $('#staticBackdrop'),
        width: '100%',
    });
    // $('#product').select2({
    //     dropdownParent: $('#staticBackdrop'),
    //     width: '100%',
    // });

    $("#product").select2({
		dropdownParent: $('#staticBackdrop'),
		width: '100%',
		ajax: {
			url: "<?php echo base_url() ?>Purchaseorder/GetProductList",
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term,  // search term
                    ordertype: $('#ordertype').val()
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

    $('#supplier').select2({
        dropdownParent: $('#staticBackdrop'),
        width: '100%',
    });


    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';


    $('#printporder').click(function() {

        printJS({
            printable: 'purchaseview',
            type: 'html',
            css: 'assets/css/styles.css',
            header: 'Purchase Order',
            onPrintSuccess: function() {
                var printButton = document.getElementById('printporder');
                printButton.style.display = 'none';
            }
        });
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
                title: 'Purchase Order Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Purchase Order Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Purchase Order Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/purchaseorderlist.php",
            type: "POST", // you can use GET
            "data": function (d) {
						return $.extend({}, d, {
							"company_id": '<?php echo ($_SESSION['company_id']); ?>',
						});
					}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [
            {
                "data": "porder_no"
            },
            {
                "data": "orderdate"
            },
            {
                "data": "type"
            },

            {
                "data": "name"
            },

            {
                "targets": -1,
                "className": '',
                "data": null,
                "render": function(data, type, full) {
                    if (full['confirmstatus'] == 1) {
                        return '<i class="fas fa-check text-success mr-2"></i>Confirm Order';
                    } else {
                        return '<i class="fa fa-times text-danger mr-2"></i>Not Confirm Order';
                    }
                }
            },
            {
                "targets": -1,
                "className": '',
                "data": null,
                "render": function(data, type, full) {
                    if (full['grnconfirm'] == 1) {
                        return '<i class="fas fa-check text-success mr-2"></i>Issue GRN';
                    } else {
                        return '<i class="fa fa-times text-danger mr-2"></i>Not Issue GRN';
                    }
                }
            }, {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return addCommas(parseFloat(full['nettotal']).toFixed(2));
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<a href="<?php echo base_url() ?>Purchaseorder/Printinvoice/' +
                        full['idtbl_print_porder'] +
                        '" target="_blank" class="btn btn-secondary btn-sm mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-file-pdf mr-2"></i></a>';

                    button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full[
                            'idtbl_print_porder'] + '" aproval_id="' + full[
                            'confirmstatus'] + '" request_id="' + full[
                            'tbl_print_porder_req_idtbl_print_porder_req'] +
                        '"><i class="fas fa-eye"></i></button>';

                    if (full['grnconfirm'] == 1) {
                        button += '<button class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></button>';
                    } else {

                    }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#reqestid').val($(this).attr('request_id'));
        $('#statusid').val($(this).attr('aproval_id'));
        $('#tableId').val(id);
        $('#approvebtn').val(id);
        $('#procode').html(id);

        var statusid = $(this).attr('aproval_id');

        if (statusid == 1) {
            $('#approve').addClass('d-none');
        } else {
            $('#approve').removeClass('d-none');
        }

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderview',
            success: function(result) { //alert(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
            }
        });

        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                status_id: statusid
            },
            url: '<?php echo base_url() ?>Purchaseorder/porderviewheader',
            success: function(result) {
                // alert(result);
                var obj = JSON.parse(result);
                $('#porderdate').text(obj.orderdate);

                $('#pordersuppliername').text(obj.suppliername);
                $('#pordersuppliercontact').text(obj.suppliercontact);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);

                $('#viewcompanyname').text(obj.companyname);
                $('#viewbranchname').text(obj.branchname);
            }
        });
    });

    $('#approve').click(function() {
        var r = confirm("Are you sure you want to confirm this purchase order ?");
        if (r == true) {
            let approvebtn = $('#approvebtn').val();
            let porderrequestid = $('#reqestid').val();
            $.ajax({
                type: "POST",
                data: {
                    approvebtn: approvebtn,
                    porderrequestid: porderrequestid
                    //porderid: porderid
                },
                url: 'Purchaseorder/Purchaseorderstatus',
                success: function(result) { //alert(result);
                    var objfirst = JSON.parse(result);
                    $('#porderviewmodal').modal('hide');
                    // console.log(objfirst);
                    if (objfirst.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                    action(objfirst.action)
                }

            });
        }
    });

    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {
            var ordertype = $('#ordertype').val();
            if (ordertype == 3 || ordertype == 4 || ordertype == 1) {

                var productID = $('#product').val();
                var comment = $('#comment').val();
                var product = $("#product option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var vat = parseFloat($('#vat').val());
                var discount = parseFloat($('#discount').val());
                var newqty = parseFloat($('#newqty').val());
                var uomID = $('#uom').val();
                var pieces = parseFloat($('#piecesper_qty').val());
                var uom = $("#uom option:selected").text();
                var newtotal;
                var newprice;
                if (pieces !== 0) {
                    newtotal = unitprice * pieces;
                    newprice = unitprice * pieces / newqty;
                } else {
                    newtotal = unitprice * newqty;
                    newprice = 0;
                }
                var vatamount = parseFloat(((newtotal - discount) / 100) * vat);
                var finaltotal = parseFloat((newtotal + vatamount) - discount);

                var totdiscount = parseFloat(discount);
                var totvat = parseFloat(vatamount);
                var total = parseFloat(newtotal);
                var finaltot = parseFloat(finaltotal);
                var showfinaltot = addCommas(parseFloat(finaltot).toFixed(2));
                var showtotal = addCommas(parseFloat(total).toFixed(2));
                var showtotdiscount = addCommas(parseFloat(totdiscount).toFixed(2));
                var showtotvat = addCommas(parseFloat(totvat).toFixed(2));


                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product +
                    '</td><td class="d-none">' +
                    comment + '</td><td class="d-none">' + productID +
                    '</td><td class="text-center">' + newqty +
                    '</td><td class="text-center">' + uom +
                    '</td><td class="d-none">' + uomID +
                    '</td><td class="text-right">' +
                    parseFloat(unitprice).toFixed(2) + '</td><td class="text-right">' +
                    parseFloat(newprice).toFixed(2) + '</td><td class="total d-none">' + total +
                    '</td><td class="text-right">' +
                    showtotal + '</td><td class="text-right d-none">' +
                    pieces + '</td></tr>');

                $('#product').val('');
                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#uom').val('');
                $('#newqty').val('0');
                $('#discount').val('0');
                $('#piecesper_qty').val('0');
                $('#piecesper_qty_uom').val('');
                $('#porderrequest').prop('readonly', true).css('pointer-events', 'none');


                var sum = 0;
                $(".total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showgrosstot = addCommas(parseFloat(sum).toFixed(2));

                $('#divgrosstotal').html(
                    '<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
                    showgrosstot);
                $('#hidegrosstotalorder').val(sum);
                $('#product').focus();


                var sum = 0;
                $(".total_vat").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotvat = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotalvat').html('Vat Total &nbsp; &nbsp; Rs.' + showtotvat);
                $('#hidevatlorder').val(sum);
                $('#product').focus();

                var sum = 0;
                $(".total_discount").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotdiscount = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotaldiscount').html('Discount &nbsp; &nbsp; Rs.' + showtotdiscount);
                $('#hidediscountlorder').val(sum);
                $('#product').focus();

                var sum = 0;
                $(".final_total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html(
                    '<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
                    showsum + '</strong>');
                $('#hidetotalorder').val(sum);
                $('#product').focus();

            }
            else {
                var productID = $('#product').val();
                var comment = $('#comment').val();
                var product = $("#product option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var vat = parseFloat($('#vat').val());
                var discount = parseFloat($('#discount').val());
                var newqty = parseFloat($('#newqty').val());
                var uom = $("#uom option:selected").text();
                var uomID = $('#uom').val();
                var newtotal = parseFloat(unitprice * newqty);
                var vatamount = parseFloat(((newtotal - discount) / 100) * vat);
                var finaltotal = parseFloat((newtotal + vatamount) - discount);

                var totdiscount = parseFloat(discount);
                var totvat = parseFloat(vatamount);
                var total = parseFloat(newtotal);
                var finaltot = parseFloat(finaltotal);
                var showfinaltot = addCommas(parseFloat(finaltot).toFixed(2));
                var showtotal = addCommas(parseFloat(total).toFixed(2));
                var showtotdiscount = addCommas(parseFloat(totdiscount).toFixed(2));
                var showtotvat = addCommas(parseFloat(totvat).toFixed(2));

                $('#vehicletableorder > tbody:last').append('<tr class="pointer"><td>' +
                    product +
                    '</td><td class="d-none">' +
                    comment + '</td><td class="d-none">' + productID +
                    '</td><td class="text-center">' + newqty +
                    '</td><td class="text-center">' + uom +
                    '</td><td class="d-none">' + uomID +
                    '</td><td class="text-right">' +
                    unitprice + '</td><td class="total d-none">' + total +
                    '</td><td class="text-right">' +
                    showtotal + '</td></tr>');

                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#uom').val('');
                $('#newqty').val('0');
                $('#servicetype').val('');
                $('#discount').val('0');
                $('#porderrequest').prop('readonly', true).css('pointer-events', 'none');

                var sum = 0;
                $(".total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showgrosstot = addCommas(parseFloat(sum).toFixed(2));

                $('#divgrosstotal').html(
                    '<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
                    showgrosstot);
                $('#hidegrosstotalorder').val(sum);
                $('#product').focus();


                var sum = 0;
                $(".total_vat").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotvat = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotalvat').html('Vat Total &nbsp; &nbsp; Rs.' + showtotvat);
                $('#hidevatlorder').val(sum);
                $('#product').focus();

                var sum = 0;
                $(".total_discount").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotdiscount = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotaldiscount').html('Discount &nbsp; &nbsp; Rs.' + showtotdiscount);
                $('#hidediscountlorder').val(sum);
                $('#product').focus();

                var sum = 0;
                $(".final_total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html(
                    '<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
                    showsum + '</strong>');
                $('#hidetotalorder').val(sum);
                $('#product').focus();
            }

        }
    });
    $('#tableorder').on('click', 'tr', function() {
        var r = confirm("Are you sure, You want to remove this product ? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".final_total").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divtotal').html('Rs. ' + showsum);
            $('#hidetotalorder').val(sum);
            $('#product').focus();
        }
    });
    $('#btncreateorder').click(function() {
        var ordertype = $('#ordertype').val();
        if (ordertype == 3 || ordertype == 4 || ordertype == 1) {
            $('#btncreateorder').prop('disabled', true).html(
                '<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
            var tbody = $("#tableorder tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tableorder tbody tr").each(function() {
                    item = {}
                    $(this).find('td').each(function(col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });

                    jsonObj.push(item);
                });
                console.log("tableorder");
                console.log(jsonObj);
                var orderdate = $('#orderdate').val();
                var duedate = $('#duedate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var discounttotal = $('#hidediscountlorder').val();
                var vatamounttotal = $('#hidevatlorder').val();
                var grosstotal = $('#hidegrosstotalorder').val();
                var supplier = $('#supplier').val();
                var ordertype = $('#ordertype').val();
                var branch_id = $('#f_branch_id').val();
                var company_id = $('#f_company_id').val();
                
                var porderrequest = $('#porderrequest').val();


                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        orderdate: orderdate,
                        duedate: duedate,
                        total: total,
                        discounttotal: discounttotal,
                        vatamounttotal: vatamounttotal,
                        grosstotal: grosstotal,
                        remark: remark,
                        supplier: supplier,
                        ordertype: ordertype,
                        company_id: company_id,
                        branch_id: branch_id,
                        porderrequest: porderrequest

                    },
                    url: 'Purchaseorder/Purchaseorderinsertupdate',
                    success: function(result) { //alert(result);
                        $('#staticBackdrop').modal('hide');
                        var objfirst = JSON.parse(result);
                        if (objfirst.status == 1) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                        action(objfirst.action)
                    }
                });
            }
        } else if (ordertype == 2) {
            $('#btncreateorder').prop('disabled', true).html(
                '<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order');

            var tbodySelector = ordertype == 2 ? "#vehicletableorder tbody" :
                "#tableorder tbody";
            var jsonObj = [];

            $(tbodySelector + " tr").each(function() {
                var item = {};
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });

            var orderdate = $('#orderdate').val();
            var duedate = $('#duedate').val();
            var remark = $('#remark').val();
            var total = $('#hidetotalorder').val();
            var discounttotal = $('#hidediscountlorder').val();
            var vatamounttotal = $('#hidevatlorder').val();
            var grosstotal = $('#hidegrosstotalorder').val();
            var location = $('#location').val();
            var supplier = $('#supplier').val();
            var branch_id = $('#f_branch_id').val();
            var company_id = $('#f_company_id').val();
            var porderrequest = $('#porderrequest').val();


            $.ajax({
                type: "POST",
                data: {
                    ordertype: ordertype,
                    tableData: jsonObj,
                    orderdate: orderdate,
                    duedate: duedate,
                    total: total,
                    discounttotal: discounttotal,
                    vatamounttotal: vatamounttotal,
                    grosstotal: grosstotal,
                    remark: remark,
                    location: location,
                    supplier: supplier,
                    company_id: company_id,
                    branch_id: branch_id,
                    porderrequest: porderrequest

                },
                url: 'Purchaseorder/Purchaseorderinsertupdate',
                success: function(result) {
                    $('#staticBackdrop').modal('hide');
                    var objfirst = JSON.parse(result);
                    if (objfirst.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                    action(objfirst.action)
                }
            });
        }

    });

    $('#uom').change(function() {
        let uomID = $(this).val(); 
        let productId = $('#product').val();
        let qty = $('#newqty').val();

        $.ajax({
            type: "POST",
            url: 'Purchaseorder/Getpiecesforqty',
            data: {
                recordID: uomID,
                productId: productId,
                qty: qty
            },
            success: function(result) {
                var obj = JSON.parse(result);
                $('#piecesper_qty').val(obj.piecesper_qty);
                $('#piecesper_qty_uom').val(obj.measure_type);
            }
        });
    });

    var tempgrntype;

    $('#porderrequest').change(function () {
    	var porderID = $(this).val();

    	$.ajax({
    		type: "POST",
    		data: {
    			recordID: porderID
    		},
    		url: 'Purchaseorder/Getporderreqdetails',
    		success: function (response) {
    			var result = JSON.parse(response);
    			$('#requestitem').empty();

    			if (result.length > 0) {
    				$.each(result, function (index, item) {
    					var listItem = '<li class="list-group-item bg-warning-soft">';
    					listItem += '<strong>' + item.requestname + '</strong> - ';
    					listItem += item.qty + ' ' + item.measure_type;
    					listItem += '</li>';
    					$('#requestitem').append(listItem);

    					if (index === 0) {
    						$('#requestordertype').val(item.order_type);
    					}
    				});
    			}
    		},
    	});
    });

    // $('#ordertype').change(function() {
    //     var orderTypeValue = $(this).val();

    //     $('#product').empty().append('<option value="">Select</option>');

    //     if (orderTypeValue) {
    //         $.ajax({
    //             url: 'Purchaseorder/GetProductList',
    //             type: 'POST',
    //             data: { ordertype: orderTypeValue },
    //             dataType: 'json',
    //             success: function(response) {
    //                 $.each(response, function(index, product) {
    //                     $('#product').append('<option value="' + product.id + '">' + product.name + '</option>');
    //                 });
    //             },
    //             error: function() {
    //                 alert('Failed to fetch products. Please try again.');
    //             }
    //         });
    //     }
    // });

    $('#product').change(function () {
    	var productID = $(this).val();
    	var ordertype = $('#ordertype').val();
    	var supplier = $('#supplier').val();

    	if (ordertype == 3) {
    		$.ajax({
    			type: "POST",
    			url: 'Purchaseorder/Getproductinfoaccoproduct',
    			data: {
    				recordID: productID,
    				supplier: supplier 			
                },
    			success: function (result) {
    				var obj = JSON.parse(result);
    				$('#unitprice').val(obj.unitprice);
    			}
    		});
    	} else if (ordertype == 1) {
    		$.ajax({
    			type: "POST",
    			url: 'Purchaseorder/Getproductinfosparepart',
    			data: {
    				recordID: productID
    			},
    			success: function (result) {
    				var obj = JSON.parse(result);
    				$('#unitprice').val(obj.unitprice);
    			}
    		});
    	}
    });

});



function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to confirm this purchase order?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
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

function action(data) { //alert(data);
    var obj = JSON.parse(data);
    $.notify({
        // options
        icon: obj.icon,
        title: obj.title,
        message: obj.message,
        url: obj.url,
        target: obj.target
    }, {
        // settings
        element: 'body',
        position: null,
        type: obj.type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 100,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
}
</script>
<script>
function typewiseSelect(ordertype) {

    if (ordertype == 2) {
        $('#supplierFields').hide();
        $('#productFields').hide();
        $('#newQtyFields').show();
        $('#servisetypeFields').show();
        $('#supplier').removeAttr('required');
        $('#product').removeAttr('required');
        $('#servicetype').attr('required', 'required');
        $('#unitprice').val('0');
        $('#vehicletblpart').show();
        $('#materialmachinetblpart').hide();

    } else {
        $('#supplier').attr('required', 'required');
        $('#product').attr('required', 'required');
        $('#servicetype').removeAttr('required');
        $('#supplierFields').show();
        $('#productFields').show();
        $('#newQtyFields').show();
        $('#servisetypeFields').hide();
        $('#vehicletblpart').hide();
        $('#materialmachinetblpart').show();
    }
}
</script>

<?php include "include/footer.php"; ?>