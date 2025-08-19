<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <!-- <style>
			#viewmodal .modal-content {
				border: 3px solid #0982e6;
				/* Light blue color */
				border-radius: 25px;
				box-shadow: 0 0 30px 1px black;
				/* Optional: Add rounded corners */
			}

		</style> -->
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Good Receive Note</span>
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
                                    data-target="#staticBackdrop" onclick="getVat();"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create
                                    Good Receive Note</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>GRN No</th>
                                                <th>GRN Date</th>
                                                <th>GRN Type</th>
                                                <th>Batch No</th>
                                                <th>Supplier</th>
                                                <!-- <th>Invoice No</th>
                                                <th>Dispatch No</th> -->
                                                <th>Total</th>
                                                <th>Porder No</th>
                                                <th>Approved Status</th>
                                                <!-- <th>Quality Status</th> -->
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
                <h5 class="modal-title" id="staticBackdropLabel">Create Good Receive Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col-4">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder=""
                                        name="grndate" id="grndate" onchange="getVat();"
                                        value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-8">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm selecter2 px-0" name="supplier"
                                        id="supplier" required>
                                        <option value="">Select</option>
                                        <?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
                                        <option value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
                                            <?php echo $rowsupplierlist->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-7">
                                    <label class="small font-weight-bold text-dark">Purchase Order</label>
                                    <select class="form-control form-control-sm selecter2 px-0" name="porder"
                                        id="porder" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label class="small font-weight-bold text-dark">GRN Type*</label>
                                    <select class="form-control form-control-sm" name="grntype" id="grntype" required>
                                        <option value="">Select</option>
                                        <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                        <option value="<?php echo $rowordertypelist->idtbl_order_type ?>">
                                            <?php echo $rowordertypelist->type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Company*</label>
                                <select class="form-control form-control-sm" name="company_id" id="company_id" required
                                    readonly>
                                    <option value="">Select</option>
                                    <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                    <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                        <?php echo $rowcompanylist->company ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Company Branch*</label>
                                <select class="form-control form-control-sm" name="branch_id" id="branch_id" required
                                    readonly>
                                    <option value="">Select</option>
                                    <?php foreach($branchlist->result() as $rowbranchlist){ ?>
                                    <option value="<?php echo $rowbranchlist->idtbl_company_branch ?>">
                                        <?php echo $rowbranchlist->branch ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Location*</label>
                                <select class="form-control form-control-sm" name="location" id="location" required>
                                    <option value="">Select</option>
                                    <?php foreach($locationlist->result() as $rowlocationlist){ ?>
                                    <option value="<?php echo $rowlocationlist->idtbl_location ?>">
                                        <?php echo $rowlocationlist->location ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm selecter2 px-0" name="product"
                                        id="product" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark" hidden>MF Date*</label>
                                    <input type="date" id="mfdate" name="mfdate" class="form-control form-control-sm"
                                        value="<?php echo date('Y-m-d') ?>" required hidden>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <label class="small font-weight-bold text-danger" id="qtylabel"></label>
                                    <input type="text" id="newqty" name="newqty" class="form-control form-control-sm"
                                        <?php if($editcheck==0){echo 'readonly';} ?> required>
                                </div>
                                <div class="col">

                                    <label class="small font-weight-bold text-dark">UOM*</label>
                                    <select class="form-control form-control-sm" style="pointer-events: none;"
                                        name="uom" id="uom" readonly>
                                        <option value="">Select</option>
                                        <?php foreach($measurelist->result() as $rowmeasurelist){ ?>
                                        <option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
                                            <?php echo $rowmeasurelist->measure_type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="text" id="unitprice" name="unitprice"
                                        class="form-control form-control-sm"
                                        <?php if($editcheck==0){echo 'readonly';} ?> value="0">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Discount</label>
                                    <input type="text" id="unitdiscount" name="unitdiscount"
                                        class="form-control form-control-sm"
                                        <?php if($editcheck==0){echo 'readonly';} ?> value="0">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment" class="form-control form-control-sm"
                                    <?php if($editcheck==0){echo 'readonly';} ?>></textarea>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Batch No</label>
                                <input type="text" id="batchno" name="batchno" class="form-control form-control-sm"
                                    required readonly>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Vat Type*</label>
                                    <select class="form-control form-control-sm" name="vat_type" id="vat_type" required>
                                        <option value="">Select Vat Type</option>
                                        <option value="1">Inclusive</option>
                                        <option value="2">Exclusive</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Invoice No*</label>
                                    <input type="text" id="invoice" name="invoice" class="form-control form-control-sm"
                                        required>
                                </div>
                            </div>
                            <div class="form-group mb-1">

                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to
                                    list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                <!-- Table headers remain unchanged -->
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Comment</th>
                                        <!-- <th>MF Date</th> -->
                                        <!-- <th>EXP Date</th> -->
                                        <!-- <th class="d-none">Quater</th> -->
                                        <th class="d-none">ProductID</th>
                                        <th>Unitprice</th>
                                        <th class="d-none">Saleprice</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Uom</th>
                                        <th class="d-none">HideTotal</th>
                                        <th class="text-right">Discount</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col text-right">
                                <h4 class="font-weight-600" id="divtotal">Rs. 0.00</h4>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>

                        <!-- Input fields for Tax and Discount -->
                        <div class="row">
                            <div class="col-6">
                                <label class="small font-weight-bold text-dark">Discount*</label>
                                <input type="text" class="form-control form-control-sm" id="discount" value="0"
                                    onkeyup="finaltotalcalculate();" required>
                                <!-- <input type="text" class="form-control form-control-sm" id="discount"
									placeholder="Enter Discount"> -->
                            </div>
                            <div class="col-6">
                                <label class="small font-weight-bold text-dark">Sub Total </label>
                                <input type="number" step="any" name="hiddenfulltotal"
                                    class="form-control form-control-sm" id="hiddenfulltotal" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="small font-weight-bold text-dark">Vat (%)*</label>
                                <input type="number" id="vat" name="vat" class="form-control form-control-sm" value="0"
                                    onkeyup="finaltotalcalculate();" required>
                            </div>

                            <div class="col-6">
                                <label class="small font-weight-bold text-dark"><b>Total Payment</b></label>
                                <input type="number" step="any" name="modeltotalpayment"
                                    class="form-control form-control-sm small font-weight-bold text-dark"
                                    id="modeltotalpayment" readonly>
                            </div>
                        </div>

                        <!-- <div class="row">
							<div class="col text-right">
								<h4 class="font-weight-600" id="divtotal">Rs. 0.00</h4>
							</div>
							<input type="hidden" id="hidetotalorder" value="0">
						</div> -->

                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Create
                                Good Receive Note</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Good Recieve Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="GRNView">
                <div class="row">
                    <div class="col-6 text-left">
                        <img src="./images/book.jpg" alt="" width="40%" style="margin-top: -20px;">
                    </div>
                    <div class="col-6">
                        <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                            class="text-right" class="text-right">Good Recieve Note<span id="pr"></span>
                        </h2>
                        <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                            class="text-right" class="text-right">Multi Offset Printers (PVT) LTD <span
                                id="proname"></span>
                        </p>
                        <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                            class="text-right" class="text-right">MO/GRN-0000<span id="grncode"></span>
                        </P>
                        <p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
                            class="text-right" class="text-right"><span id="porderdate"></span></p>
                    </div>
                </div>


                <div id="viewhtml"></div>

            </div>
            <div class="modal-footer">
                <button type="button" id="printgrn" class="btn btn-outline-primary btn-sm fa-pull-right"
                    <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Print GRN</button>
            </div>
        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    $('#printgrn').click(function() {
        printJS({
            printable: 'GRNView',
            type: 'html',
            css: 'assets/css/styles.css'
        });
    });
});

$(document).ready(function() {

    $('#supplier').select2({
        dropdownParent: $('#staticBackdrop'),
        width: '100%',
    });
    $('#porder').select2({
        dropdownParent: $('#staticBackdrop'),
        width: '100%',
    });
    $('#product').select2({
        dropdownParent: $('#staticBackdrop'),
        width: '100%',
    });

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
                title: 'Good Receive Note Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Good Receive Note Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Good Receive Note Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
            // 'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/goodreceivelist.php",
            type: "POST", // you can use GET
            // data: function(d) {}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": function(row) {
                    return "GRN000" + row.idtbl_print_grn;
                }
            },
            {
                "data": "grndate"
            },
            {
                "data": "type"
            },
            {
                "data": "batchno"
            },
            {
                "data": "name"
            },
            // {
            // 	"data": "invoicenum"
            // },
            // {
            // 	"data": "dispatchnum"
            // },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return addCommas(parseFloat(full['total']).toFixed(2));
                }
            },
            {
                "data": function(row) {
                    return "PO000" + row.tbl_print_porder_idtbl_print_porder;
                }
            },
            {
                "targets": -1,
                "className": '',
                "data": null,
                "render": function(data, type, full) {
                    if (full['approvestatus'] == 1) {
                        return '<i class="fas fa-check text-success mr-2"></i>Approved GRN';
                    } else {
                        return 'Not Approved GRN';
                    }
                }
            },
            // {
            // 	"targets": -1,
            // 	"className": '',
            // 	"data": null,
            // 	"render": function (data, type, full) {
            // 		if (full['qualitycheck'] == 1) {
            // 			return '<i class="fas fa-check text-success mr-2"></i>Quality Checked';
            // 		} else if (full['qualitycheck'] == 0) {
            // 			return '<i class="fas fa-times text-danger mr-2"></i>Pending';
            // 		}
            // 	}
            // },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<a href="<?php echo base_url() ?>Goodreceive/pdfgrnget/' +
                        full['idtbl_print_grn'] +
                        '" target="_self" class="btn btn-secondary btn-sm mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-file-pdf mr-2"></i></a>';


                    button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full[
                        'idtbl_print_grn'] + '"><i class="fas fa-eye"></i></button>';
                    if (full['approvestatus'] == 1) {
                        button += '<button class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></button>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>Goodreceive/Goodreceivestatus/' +
                            full['idtbl_print_grn'] + '/1/' + full[
                                'tbl_print_porder_idtbl_print_porder'] +
                            '" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    if (full['approvestatus'] == 0) {
                        button +=
                            '<a href="<?php echo base_url() ?>Goodreceive/Goodreceivestatus/' +
                            full['idtbl_print_grn'] +
                            '/3/PLACEHOLDER" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-trash-alt"></i></a>';
                    }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });


    // $('#dataTable tbody').on('click', '.btnAddCosting', function () {
    // 	var id = $(this).attr('id');
    // 	$.ajax({
    // 		type: "POST",
    // 		data: {
    // 			recordID: id
    // 		},
    // 		url: '<?php echo base_url() ?>Goodreceive/Getgoodreceiveid',
    // 		success: function (result) { //alert(result);
    // 			var obj = JSON.parse(result);
    // 			$('#addCostModal').modal('show');
    // 			$('#grnid').val(obj[0].idtbl_print_grn);
    // 			$('#grnid').html(obj[0].idtbl_print_grn);

    // 			preparelist(obj[0].idtbl_print_grn);

    // 		}
    // 	});
    // });
    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#grncode').html(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Goodreceive/Goodreceiveview',
            success: function(result) { //alert(result);
                $('#viewmodal').modal('show');
                $('#viewhtml').html(result);
            }
        });
    });



    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {
            var productID = $('#product').val();
            var comment = $('#comment').val();
            var product = $("#product option:selected").text();
            var unitprice = parseFloat($('#unitprice').val());
            var newqty = parseFloat($('#newqty').val());
            var discount = $('#unitdiscount').val();
            var uomID = $('#uom').val();
            var uom = $("#uom option:selected").text();
            var expdate = $('#expdate').val();

            var newtotal = parseFloat((unitprice * newqty) - discount);

            var total = parseFloat(newtotal);
            var showtotal = addCommas(parseFloat(total).toFixed(2));

            $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' +
                comment + '</td><td class="d-none">' + productID +
                '</td><td class="text-center">' + unitprice + '</td><td class="text-center">' +
                newqty +
                '</td><td class="text-center">' + uom +
                '</td><td class="text-center">' + discount + '</td><td class="d-none">' + uomID +
                '</td><td class="total d-none">' + total + '</td><td class="text-right">' +
                showtotal +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
            );

            $('#product').val('');
            $('#unitprice').val('0');
            $('#uom').val('');
            $('#comment').val('');
            $('#unitdiscount').val('');
            $('#newqty').val('');
            // $('#mfdate').val("<?php echo date('Y-m-d') ?>");
            $('#qtylabel').text('0');
            // $('#expdate').val('');
            $('#porder').prop('readonly', true).css('pointer-events', 'none');


            var sum = 0;
            $(".total").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divtotal').html('<strong style="background-color: yellow;"> Rs. <strong>' + showsum);

            // html('<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
            // 		showgrosstot);
            $('#hidetotalorder').val(sum);
            $('#product').focus();
        }

        finaltotalcalculate();

    });

    //calculate Sub Total

    $(document).on("keyup", "#discount", function(event) {
        var checkdiscount = parseFloat($("#discount").val()); //alert(checkdiscount);
        if (!checkdiscount == "") {
            finaltotalcalculate();
        } else {

        }

    });

    //calculate Final Total

    $(document).on("keyup", "#vat", function(event) {
        var checkvat = parseFloat($("#vat").val()); //alert(checkdiscount);
        if (!checkvat == "") {
            finaltotalcalculate();
        } else {

        }

    });


    $('#tableorder').on('click', 'tr', function() {
        var r = confirm("Are you sure, You want to remove this product ? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".total").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divtotal').html('Rs. ' + showsum);
            $('#hidetotalorder').val(sum);
            $('#product').focus();
        }
    });

    $('#tblcost').on('click', 'tr', function() {
        var r = confirm("Are you sure, You want to remove this cost? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".totalamount").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#labelcosttotal').html('Rs. ' + showsum);
            $('#totalcost').val(sum);
        }
    });

    $('#btncreateorder').click(function() { //alert('IN');
        $('#btncreateorder').prop('disabled', true).html(
            '<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Good Receive Note')
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
            // console.log(jsonObj);

            var grndate = $('#grndate').val();
            var remark = $('#remark').val();
            var total = $('#modeltotalpayment').val();
            var supplier = $('#supplier').val();
            var location = $('#location').val();
            var porder = $('#porder').val();
            var batchno = $('#batchno').val();
            var invoice = $('#invoice').val();
            var vat_type = $('#vat_type').val();
            var grntype = $('#grntype').val();
            var discount = $('#discount').val();
            var vat = $('#vat').val();
            var subtotal = $('#hiddenfulltotal').val();
			var branch_id = $('#branch_id').val();
			var company_id = $('#company_id').val();
            // alert(orderdate);
            $.ajax({
                type: "POST",
                data: {
                    tableData: jsonObj,
                    grndate: grndate,
                    total: total,
                    remark: remark,
                    supplier: supplier,
                    location: location,
                    porder: porder,
                    invoice: invoice,
                    subtotal: subtotal,
                    batchno: batchno,
                    grntype: grntype,
                    discount: discount,
                    vat: vat,
					company_id: company_id,
					branch_id: branch_id,
                    vat_type: vat_type
                },
                url: 'Goodreceive/Goodreceiveinsertupdate',
                success: function(result) { //alert(result);
                    //console.log(result);
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

    $('#supplier').change(function() {
        var supplierID = $(this).val();
        $('#porder').empty();
        $('#porder').prepend('<option value="" selected="selected">Select porder</option>');
        // $('#porder').val(null).trigger('change');
        // alert(supplierID);
        $.ajax({
            type: "POST",
            data: {
                recordID: supplierID
            },
            url: 'Goodreceive/Getporderaccsupllier',
            success: function(result) {
                //alert(result);
                var obj = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function(i, item) {
                    html1 += '<option value="' + obj[i].idtbl_print_porder + '">' +
                        'PO000' + obj[i].idtbl_print_porder + '</option>';
                    html1 += obj[i].idtbl_print_porder;
                    html1 += '</option>';
                });
                $('#porder').empty().append(html1);
            }
        });
        // $('#qtylabel').text('0');
        // $('#porder').empty();
        // $('#porder').prepend('<option value="" selected="selected">Select porder</option>');
    });

    var tempsupplier;
    var tempgrntype;
    $('#porder').change(function() {
        var porderID = $(this).val();

        $.ajax({
            type: "POST",
            data: {
                recordID: porderID
            },
            url: 'Goodreceive/Getcompanyaccoporder',
            success: function(result) { //alert(result);
                $('#company_id').val(result).css('pointer-events', 'none');
                // $('#company_id').val(result);
                // $('#company_id option').each(function() {
                //     if (!this.selected) {
                //         $(this).attr('disabled', true);
                //     }
                // });
            }
        });

		$.ajax({
            type: "POST",
            data: {
                recordID: porderID
            },
            url: 'Goodreceive/Getbranchaccoporder',
            success: function(result) { //alert(result);
                $('#branch_id').val(result).css('pointer-events', 'none');
                // $('#branch_id').val(result);
                // $('#branch_id option').each(function() {
                //     if (!this.selected) {
                //         $(this).attr('disabled', true);
                //     }
                // });
                // getbatchno();
            }
        });


        function getSupplier() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: porderID
                    },
                    url: 'Goodreceive/Getsupplieraccoporder',
                    success: function(result) {
                        $('#supplier').val(result).css('pointer-events', 'none');
                        // $('#supplier').val(result);
                        // $('#supplier option').each(function() {
                        //     if (!this.selected) {
                        //     	$(this).attr('disabled', true);
                        //     }
                        // });
                        tempsupplier = result;
                        resolve();
                    },
                    error: reject
                });
            });
        }

        function getGrntype() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: porderID
                    },
                    url: 'Goodreceive/Getpordertpeaccoporder',
                    success: function(result) {
                        $('#grntype').val(result).css('pointer-events', 'none');
                        // $('#grntype').val(result);
                        // $('#grntype option').each(function() {
                        //     if (!this.selected) {
                        //         $(this).attr('disabled', true);
                        //     }
                        // });
                        tempgrntype = result;
                        getitems(porderID, result);
                        resolve();
                    },
                    error: reject
                });
            });
        }


        getSupplier()
            .then(getGrntype)
            .then(function() {

                // console.log(tempsupplier, tempgrntype);
                getbatchno(tempsupplier, tempgrntype);
            })
            .catch(function(error) {
                console.error("An error occurred:", error);
            });

    });

    function getbatchno(supplierID, typeID) {

        $.ajax({
            type: "POST",
            data: {
                recordID: supplierID
            },
            url: 'Goodreceive/Getbatchnoaccosupplier',
            success: function(result) {
                // alert(result);
                //console.log(result);
                $('#batchno').val(result);
            }
        });
    }

    function getitems(porderID, grntype) {
        if (grntype == 4) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: porderID
                },
                url: 'Goodreceive/Getproductformachine',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function(i, item) {
                        html1 += '<option value="' + obj[i]
                            .idtbl_machine + '">';
                        html1 += obj[i].machine;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        } else if (grntype == 3) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: porderID
                },
                url: 'Goodreceive/Getproductaccoporder',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function(i, item) {
                        html1 += '<option value="' + obj[i]
                            .idtbl_print_material_info +
                            '">';
                        html1 += obj[i].materialname + ' / ' + obj[i]
                            .materialinfocode;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        } else if (grntype == 1) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: porderID
                },
                url: 'Goodreceive/Getproductforsparepart',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function(i, item) {
                        html1 += '<option value="' + obj[i]
                            .idtbl_spareparts +
                            '">';
                        html1 += obj[i].spare_part_name;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        }
    };

    $('#product').change(function() {
        var productID = $(this).val();
        var grntype = tempgrntype;
        var grn_id = $('#porder').val();

        console.log(productID, grntype);

        if (grntype == 3) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    grn_id: grn_id
                },
                url: 'Goodreceive/Getproductinfoaccoproduct',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    // $('#newqty').val(obj.qty);
                    $('#qtylabel').html(obj.qty);
                    $('#uom').val(obj.uom);
                    $('#unitprice').val(obj.unitprice);
                    $('#comment').val(obj.comment);
                }
            });
        } else if (grntype == 4) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    grn_id: grn_id
                },
                url: 'Goodreceive/Getproductinfoamachine',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    // $('#newqty').val(obj.qty);
                    $('#qtylabel').html(obj.qty);
                    $('#uom').val(obj.uom);
                    $('#unitprice').val(obj.unitprice);
                    $('#comment').val(obj.comment);
                }
            });
        } else if (grntype == 1) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    grn_id: grn_id
                },
                url: 'Goodreceive/Getproductinfosparepart',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    // $('#newqty').val(obj.qty);
                    $('#qtylabel').html(obj.qty);
                    $('#uom').val(obj.uom);
                    $('#unitprice').val(obj.unitprice);
                    $('#comment').val(obj.comment);
                }
            });
        }
    });


    // $('#quater').change(function () {
    // 	var quaterID = $(this).val();
    // 	var mfdate = $('#mfdate').val();

    // 	$.ajax({
    // 		type: "POST",
    // 		data: {
    // 			recordID: quaterID,
    // 			mfdate: mfdate
    // 		},
    // 		url: 'Goodreceive/Getexpdateaccoquater',
    // 		success: function (result) { //alert(result);
    // 			$('#expdate').val(result);
    // 		}
    // 	});
    // });

    $('#dataTable tbody').on('click', '.btnLabel', function() {
        var id = $(this).attr('id');
        $('#lablemodal').modal('show');

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Goodreceive/Getmateriallistaccogrn',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function(i, item) {
                    html1 += '<option value="' + obj[i]
                        .idtbl_print_material_info +
                        '">';
                    html1 += obj[i].materialname + ' / ' + obj[i]
                        .materialinfocode;
                    html1 += '</option>';
                });
                $('#materiallist').empty().append(html1);
            }
        });

        // $.ajax({
        // 	type: "POST",
        // 	data: {
        // 		recordID: id
        // 	},
        // 	url: '<?php echo base_url() ?>Goodreceive/Getgrninfoaccogrnid',
        // 	success: function (result) { //alert(result);
        // 		// console.log(result);
        // 		var obj = JSON.parse(result);
        // 		$('#grnno').val('UN|GRN-0000' + id);
        // 		$('#pono').val('UN|POD-0000' + obj
        // 			.tbl_print_porder_idtbl_print_porder);
        // 		$('#lmfdate').val(obj.mfdate);
        // 		$('#lexpdate').val(obj.expdate);
        // 		$('#lbatchno').val(obj.batchno);
        // 	}
        // });
    });
    // $('#materiallist').change(function () {
    // 	let optiontitle = $("#materiallist option:selected").text();
    // 	var result = optiontitle.split('/');
    // 	$('#mname').val(result[0]);
    // 	$('#mcode').val(result[1]);
    // });
    $('#btncreatelable').click(function() {
        if (!$("#formlable")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hidesubmitbtn").click();
        } else {
            let mname = $('#mname').val();
            let mcode = $('#mcode').val();
            let grnno = $('#grnno').val();
            let pono = $('#pono').val();
            let mfdate = $('#lmfdate').val();
            let expdate = $('#lexpdate').val();
            let batchno = $('#lbatchno').val();

            var link = '<?php echo base_url() ?>Goodreceive/Createlabel/' + mname + '/' +
                mcode + '/' +
                grnno + '/' + pono + '/' + mfdate + '/' + expdate + '/' + batchno;
            window.open(link, '_blank');
            $('#hideresetbtn').click();
            $('#lablemodal').modal('hide');
        }
    });
});

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to approve this good receive note?");
}

function delete_confirm() {
    return confirm("Are you sure you want to reject this good receive note?");
}

// function subtotatalcalculate() {
// 	var discount = parseFloat($("#discount").val());
// 	var total = parseFloat($("#hidetotalorder").val());
// 	var finalsubtot = total - discount

// 	$('#hiddenfulltotal').val(finalsubtot.toFixed(2));
// }

// function defultsubtotatal() {
// 	var defultnetsale = parseFloat($("#hidetotalorder").val());

// 	$('#hiddenfulltotal').val(defultnetsale.toFixed(2));

// }

function finaltotalcalculate() {
    var vat = parseFloat($("#vat").val());
    var discount = parseFloat($("#discount").val());
    var total = parseFloat($("#hidetotalorder").val());

    if (isNaN(discount)) {
        discount = 0;
        $("#discount").val(0);
    }

    if (isNaN(vat)) {
        vat = 0;
        $("#vat").val(0);
    }

    // subtotal calculation
    var finalsubtot = total - discount
    $('#hiddenfulltotal').val(finalsubtot.toFixed(2))

    // vat calculaton
    var vatamount = parseFloat((finalsubtot / 100) * vat);
    var finaltotal = finalsubtot + vatamount



    $('#modeltotalpayment').val(finaltotal.toFixed(2));
}

// function defultfinaltotal() {
// 	var defultfinaltotal = parseFloat($("#hiddenfulltotal").val());

// 	$('#modeltotalpayment').val(defultfinaltotal.toFixed(2));

// }




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
function getVat() {
    var currentDate = $('#grndate').val();

    $.ajax({
        type: "POST",
        data: {
            currentDate: currentDate,
        },
        url: 'Goodreceive/Getvatpresentage',
        success: function(result) { //alert(result);
            var obj = JSON.parse(result);

            $('#vat').val(obj);
        }
    });
}
</script>
<?php include "include/footer.php"; ?>