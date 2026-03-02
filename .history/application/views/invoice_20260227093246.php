<?php 
include "include/header.php";  
include "include/topnavbar.php"; 

$companyID = $_SESSION['company_id'];
$vatValue = ($companyID == 3) ? "0" : "18"; 
?>
<style>
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

#approve:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    background-color: #4CAF50;
    color: #fff;
}
.disabled-pointer-events {
    pointer-events: none;
}

.vl {
    border-left: 4px solid rgb(60, 90, 180);
    height: 200px;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">


        <!-- Modal -->
        <div id="companyview">
            <div class="modal fade" id="companymodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Company Information</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <label class="small font-weight-bold text-dark">Company*</label>
                                    <select class="form-control form-control-sm " name="company_id" id="company_id"
                                        required>
                                        <option value="">Select</option>
                                        <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                        <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                            <?php echo $rowcompanylist->company ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12">

                                <label class="small font-weight-bold text-dark">Company
                                        Branch*</label>
                                    <select class="form-control form-control-sm" name="branch_id" id="branch_id"
                                        required>
                                        <option value="">Select</option>
                                        
                                    </select>
                                </div>
                                
                                <div class="col-12" style="margin-top: 10px;">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="savecompaydata" name="savecompaydata" style="width: 1.2rem;height: 1.2rem;margin-right: 10px;"/>
                                        <label class="form-check-label font-weight-bold text-dark" for="savecompaydata">Save Data*</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0 p-2">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" name="sub_btn" id="sub_btn"
                                            class="btn btn-success btn-m fa-pull-right animated-button"
                                            title="submit"><i class="fas fa-check"></i>&nbsp;Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-file"></i></div>
                            <span>Invoice</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
            	<div class="card">
            		<div class="card-body p-0 p-3">
            			<div class="row">
            				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            					<form id="createorderform" autocomplete="off">
            						<div class="row">
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Date*</label>
            								<input type="date" class="form-control form-control-sm" placeholder=""
            									name="date" id="date" onchange="getVat();"
            									value="<?php echo date('Y-m-d') ?>" required>
            							</div>
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Company*</label>
            								<input type="text" id="f_company_name" name="f_company_name"
            									class="form-control form-control-sm" required readonly>
            							</div>
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Company
            									Branch*</label>
            								<input type="text" id="f_branch_name" name="f_branch_name"
            									class="form-control form-control-sm" required readonly>
            							</div>
            							<input type="hidden" name="f_company_id" id="f_company_id">
            							<input type="hidden" name="f_branch_id" id="f_branch_id">

            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Customer*</label>
            								<select class="form-control form-control-sm  px-0" name="customer"
            									id="customer" required onchange="checkCustomerVatStatus()">
            									<option value="">Select</option>
            									<?php foreach($customerlist->result() as $rowcustomerlist){ ?>
            									<option value="<?php echo $rowcustomerlist->idtbl_customer ?>">
            										<?php echo $rowcustomerlist->customer ?></option>
            									<?php } ?>
            								</select>

                                            <input type="hidden" id="customer_vat_status" value="0">
            							</div>
            						</div>

            						<div class="row">
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Job*</label>
            								<select class="form-control form-control-sm  px-0" name="job" id="job"
            									required>
            									<option value="">Select</option>
            								</select>
            							</div>

            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Dispatch
            									Note*</label>
            								<select class="form-control form-control-sm  px-0" name="dispath_note"
            									id="dispath_note" required>
            									<option value="">Select</option>
            								</select>
            								<input type="text" id="dispath_noteid" name="dispath_noteid"
            									class="form-control form-control-sm" value="" readonly hidden>
            							</div>
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Job No*</label>
            								<input type="text" id="job_no" name="job_no"
            									class="form-control form-control-sm" required readonly>
            							</div>

            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Qty*</label>
            								<input type="number" id="newqty" name="newqty"
            									class="form-control form-control-sm" required readonly>
            							</div>
            						</div>

            						<div class="row">
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">UOM*</label>
            								<select class="form-control form-control-sm" name="uom" id="uom" required
            									readonly>
            									<option value="">Select</option>
            									<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
            									<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
            										<?php echo $rowmeasurelist->measure_type ?></option>
            									<?php } ?>
            								</select>
            							</div>
            							<div class="col-3">
            								<label class="small font-weight-bold text-dark">Unit
            									Price</label>
            								<input type="number" id="unitprice" name="unitprice"
            									class="form-control form-control-sm" value="0" step="any">
            							</div>
                                        <div class="col-3 mt-4 p-1">
                                            <button type="button" id="formsubmit" class="btn btn-warning font-weight-bold btn-sm px-4"
                                                <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                    class="fas fa-plus"></i>&nbsp;Add
                                                to
                                                list</button>
                                            <input name="submitBtn" type="submit" value="Save" id="submitBtn"
                                                class="d-none">
            							</div>
            						</div>
            						<input type="hidden" id="inquerydetailsid" name="inquerydetailsid"
            							class="form-control form-control-sm" />

            						<input type="hidden" name="refillprice" id="refillprice" value="">
            						<input type="hidden" name="recordOption" id="recordOption" value="1">
            					</form>

            				</div>
            			</div>
            		</div>
                    <div class="row p-3">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <h6 class="title-style small"><span><b>Invoice Details</b></span></h6>
                            <div id="materialmachinetblpart">
                                <table class="table table-striped table-bordered table-sm small"
                                    id="tableorder">
                                    <thead>
                                        <tr>
                                            <th>Dispatch No</th>
                                            <th>Job</th>
                                            <th class="d-none">ProductID</th>
                                            <th class="text-left">Job No</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">UOM</th>
                                            <th class="text-center">Unit Price</th>
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
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <h6 class="title-style small"><span><b>Other Charges</b></span></h6>
                            <div class="row">
                                <div class="col-12">
                                    <form id="expensesform" autocomplete="off">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="small font-weight-bold text-dark">Charge
                                                    Type
                                                </label>
                                                <select class="form-control form-control-sm" name="chargetype"
                                                    id="chargetype" required>
                                                    <option value="">Select Charge</option>
                                                    <?php foreach($chargelist->result() as $rowchargelist){ ?>
                                                    <option value="<?php echo $rowchargelist->idtbl_charges ?>">
                                                        <?php echo $rowchargelist->charges_type ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-4">
                                                <label class="small font-weight-bold text-dark">Amount
                                                </label>
                                                <input type="number" step="any" name="chargeamount"
                                                    class="form-control form-control-sm" id="chargeamount"
                                                    required>
                                            </div>
                                            <div class="form-group mt-4 p-1  md-8 sm-12 text-right">
                                                <button type="button"
                                                    id="secondformsubmit" class="btn btn-secondary btn-sm"
                                                    <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                        class="fas fa-plus"></i>&nbsp;Add
                                                    Charge</button>
                                                <input name="chargesubmitBtn" type="submit" value="Save"
                                                    id="chargesubmitBtn" class="d-none">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div id="materialmachinetblpart">
                                        <table class="table table-striped table-bordered table-sm small"
                                            id="chargetableorder">
                                            <thead>
                                                <tr>
                                                    <th>Charge Type</th>
                                                    <th class="text-right">Amount</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col text-right">
                                                <h4 class="font-weight-600" id="divchargestotal">Rs.
                                                    0.00
                                                </h4>
                                                <input type="hidden" id="hidechargestotal" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-2 p-0 p-3">
                    <h6 class="title-style small"><span><b>Discount & VAT</b></span></h6>
                        <div class="row">
                            <div class="col-2">
                                <label class="small font-weight-bold text-dark">Discount </label>
                                <input type="text" step="any" name="discount" class="form-control form-control-sm"
                                    id="discount" value="0" onkeyup="finaltotalcalculate();" required>
                            </div>
                            <div class="col-3">
                                <label class="small font-weight-bold text-dark">Sub Total </label>
                                <input type="text" step="any" name="hiddenfulltotal"
                                    class="form-control form-control-sm" id="hiddenfulltotal" readonly>
                            </div>
                            <div class="col-1">
                                <label class="small font-weight-bold text-dark">Vat (%)*</label>
                                <input type="text" id="vat" name="vat" class="form-control form-control-sm"
                                    value="<?php echo $vatValue; ?>" onkeyup="finaltotalcalculate();" required readonly>
                            </div>

                            <div class="col-3">
                                <label class="small font-weight-bold text-dark">Vat Amount*</label>
                                <input type="text" id="vatamount" name="vatamount"
                                    class="form-control form-control-sm" value="0" required readonly>
                            </div>
                            <div class="col-3">
                                <label class="small font-weight-bold text-dark"><b>Total
                                        Payment</b></label>
                                <input type="text" step="any" name="modeltotalpayment"
                                    class="form-control form-control-sm small font-weight-bold text-dark"
                                    id="modeltotalpayment" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mt-2">
                                    <button type="button" id="btncreateorder"
                                        class="btn btn-primary btn-sm fa-pull-right"><i
                                            class="fas fa-save"></i>&nbsp;Create Invoice</button>
                                </div>
                            </div>

                        </div>
                        <hr>
                    </div>
            	</div>

            	<div class="container-fluid mt-2 p-0">
            		<div class="card">
            			<div class="card-body p-0 p-3">
            				<div class="row">
            					<div class="col-12">
            						<div class="scrollbar pb-3" id="style-2">
            							<table class="table table-bordered table-striped table-sm nowrap"
            								id="dataTable">
            								<thead>
            									<tr>
            										<th>Invoice Number</th>
            										<th>Date</th>
            										<th>Customer</th>
                                                    <th>Job Name</th>
            										<th>Job Number</th>
            										<th>Total Amount</th>
                                                    <th>Status</th>
                                                    <th>Check By</th>
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
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<!-- Modal -->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">View Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-right" class="text-right">Invoice<span id="pr"></span>
                            </h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span
                                    id="viewcompanyname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"> <span
                                    id="viewbranchname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="procode"></span>
                            </P>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="porderdate"></span></p>
                        </div>
                    </div>
                    <div id="viewhtml"></div>
                    <div class="col-12 text-right">
                        <hr>
                        <?php if($approvecheck==1){ ?>
                        <button id="btnapprovereject" class="btn btn-primary btn-sm px-3 mb-2"><i class="fas fa-check mr-2"></i>Approve or Reject</button>
                        <?php } ?>
                        <input type="hidden" name="invoiceid" id="invoiceid">
                        <input type="hidden" id="reqestid" name="reqestid">
                        <input type="hidden" id="job_id" name="job_id">
                        <?php if($checkstatus==1){ ?>
						<button id="btncheck" class="btn btn-info btn-sm px-3 mb-2"><i class="fas fa-user-check mr-2"></i>Check By</button>
						<?php } ?>
                    </div>
                    <div class="col-12 text-center">
                        <div id="alertdiv"></div>
                    </div>
                    <div class="col-12 text-center">
						<div id="checkalertdiv"></div>
					</div>
                </div>
            </div>
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
    $('#customer').select2({
        width: '100%',
    });
    $('#job').select2({
        width: '100%',
    });
    $('#dispath_note').select2({
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
            header: 'Purchase Order Request',
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
                title: 'New Purchase Order Request Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'New Purchase Order Request Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'New Purchase Order Request Information',
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
            url: "<?php echo base_url() ?>scripts/invoicelist.php",
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
                "data": "inv_no"
            },
            {
                "data": "date"
            },
            {
                "data": "customer"
            },
            { 
                "data": "job" 
            },
            { 
                "data": "job_no" 
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return addCommas(parseFloat(full['total']).toFixed(2));
                }
            },
                                    {
                "targets": -1,
                "className": '',
                "data": "approvestatus_display",
                "render": function(data, type, row) {
                    return data;
                }
            },
            { 
                "data": "name" 
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<a href="<?php echo base_url() ?>' +
                        full['idtbl_print_porder_req'] +
                        '" target="_self" class="btn btn-secondary btn-sm mr-1 ';
                    var button = '';
                    button += '<a href="<?php echo base_url() ?>Invoice/pdfget/' + full[
                            'idtbl_print_invoice'] +
                        '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print Invoice" class="btn btn-secondary btn-sm btnPdf mr-1 id="' +
                        full['idtbl_print_invoice'] +
                        '"><i class="fas fa-file-pdf"></i></a>'; //pdf
                    if (editcheck != 1) {
                        button += 'd-none';
                    }

                    button += '<button data-toggle="tooltip" data-placement="bottom" title="View Invoice" class="btn btn-dark btn-sm btnview mr-1" id="' +
                        full[
                            'idtbl_print_invoice'] + '" aproval_id="' + full[
                            'approvestatus'] + '" check_status="' + full[
                            'check_by'] + '" request_id="' + full[
                            'tbl_print_dispatch_idtbl_print_dispatch'] + '" job_id="' + full[
                            'job_id'] + + '" job_id="' + full[
                            'job_id'] +
                        '"><i class="fas fa-eye"></i></button>';

                    if (full['porderconfirm'] == 1) {
                        button += '<button class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></button>';
                    }
                    if (full['approvestatus'] == 0) {
                        button +=
                            '<a href="<?php echo base_url() ?>Invoice/Invoicestatus/' +
                            full['idtbl_print_invoice'] +
                            '/3/" onclick="return delete_confirm()" target="_self" data-toggle="tooltip" data-placement="bottom" title="Delete" class="btn btn-danger btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        },
        rowCallback: function(row, data) {
            if (data.status == 4) {
                $(row).css('background-color', '#FFADB0');
            } else if (data.approvestatus == 2) {
                $(row).css('background-color', '#FFCCCB');
            }
        }
    });



    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#reqestid').val($(this).attr('request_id'));
        $('#job_id').val($(this).attr('job_id'));
        $('#procode').html(id);
        var statusid = $(this).attr('aproval_id');

        var approvestatus = $(this).attr('aproval_id');
        var checkstatus = $(this).attr('check_status');

        $('#invoiceid').val(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Invoice/Invoiceview',
            success: function(result) {
                console.log(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
                if (approvestatus > 0) {
                	$('#btnapprovereject').addClass('d-none').prop('disabled', true);
                	if (approvestatus == 1) {
                		$('#alertdiv').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle mr-2"></i> Invoice approved</div>');
                	} else if (approvestatus == 2) {
                		$('#alertdiv').html('<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle mr-2"></i> Invoice rejected</div>');
                	}
                } else {
					if (checkstatus == 0) {
						$('#btnapprovereject').addClass('d-none').prop('disabled', true);
					} else {
						$('#btnapprovereject').removeClass('d-none').prop('disabled', false);
						$('#btncheck').addClass('d-none').prop('disabled', true);
					}
				}
                if(checkstatus>0){
                    $('#btncheck').addClass('d-none').prop('disabled', true);
                    if(checkstatus==1){$('#checkalertdiv').html('<div class="alert alert-secondary" role="alert"><i class="fas fa-check-circle mr-2"></i> Invoice checked</div>');}
                }
            }
        });

            $('#porderviewmodal').on('hidden.bs.modal', function (event) {
                $('#alertdiv').html('');
                $('#checkalertdiv').html('');
                $('#btnapprovereject').removeClass('d-none').prop('disabled', false);
                $('#btncheck').removeClass('d-none').prop('disabled', false);
            });

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Invoice/Invoiceviewheader',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                $('#porderdate').text(obj.date);

                $('#pordersuppliername').text(obj.customername);
                $('#pordersuppliercontact').text(obj.customercontact);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);

                $('#viewcompanyname').text(obj.companyname);
                $('#viewbranchname').text(obj.branchname);
            }
        });
    });

    $('#btnapprovereject').click(function () {
        Swal.fire({
            title: "Do you want to approve this inquiry?",
            html: `
                <div style="text-align:center;margin-top:10px;">
                    <input type="checkbox" id="finishJob" />
                    <label for="finishJob" style="margin-left:6px;">
                        Do you want to finish this job?
                    </label>
                </div>
            `,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Approve",
            denyButtonText: "Reject",
            preConfirm: () => {
                return {
                    finishJob: $('#finishJob').is(':checked') ? 1 : 0
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                approvejob(1, result.value.finishJob);
            } else if (result.isDenied) {
                approvejob(2, 0);
            }
        });
    });

    $('#btncheck').click(function () {
		Swal.fire({
			title: "Do you want to check this Invoice?",
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: "Check",
		}).then((result) => {
			if (result.isConfirmed) {
				var confirmnot = 1;
				checkjob(confirmnot);
			}
		});
	});
    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {
            $('#company_btn').prop('disabled', true);

            var jobID = $('#job').val();
            var unitprice = $('#unitprice').val();
            var job = $("#job option:selected").text();
            var dispath_note = $('#dispath_note').val();
            var dispath_note_text = $('#dispath_note option:selected').text();
            var dispath_noteid = $('#dispath_noteid').val();
            var newqty = parseFloat($('#newqty').val());
            var unitprice = parseFloat($('#unitprice').val());
            var newtotal = parseFloat(unitprice * newqty);
            var total = parseFloat(newtotal);
            var showtotal = addCommas(parseFloat(total).toFixed(2));
            var dispatchdetailsid = parseFloat($('#dispatchdetailsid').val());
            var job_no = $('#job_no').val();
            var uomID = $('#uom').val();
            var uom = $("#uom option:selected").text();

            var duplicate = false;
            $('#tableorder > tbody > tr').each(function() {
                if ($(this).find('td[name="dispath_noteid"]').text() === dispath_noteid) {
                    duplicate = true;
                    return false;
                }
            });

            if (duplicate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'This dispath already added to table',
                });
            } else {
                $('#tableorder > tbody:last').append('<tr class="pointer"><td name="dispatch">'+
                    dispath_note_text + '</td><td name="job">' +
                    job + '</td><td name="job_no" class="text-left">' +
                    job_no + '</td><td name="qty" class="text-center">' + newqty +
                    '</td><td name="uom" class="text-center">' + uom +
                    '</td><td name="uomID" class="d-none">' + uomID +
                    '</td><td name="unitprice" class="text-center">' +
                    unitprice + '</td><td name="productid" class="d-none">' + jobID +
                    '</td><td name="dispatchdetailsid" class="d-none">' + dispatchdetailsid +
                    '</td><td class="total d-none">' + total +
                    '</td><td class="text-right">' +
                    showtotal +
                    '</td><td name="dispath_noteid" class="text-right d-none">' +
                    dispath_noteid +
                    '</td><td><button type="button" onclick="productDelete(this);" id="btnDeleterow" class="btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
                );

                $('#newqty').val('');
                $('#unitprice').val('');
                $('#dispath_note').val('');
                // $('#dispath_note').val(null).trigger('change');
                $('#dispath_noteid').val('');
                $('#dispatchdetailsid').val('');
                $('#customer').next('.select2-container').first().addClass('disabled-pointer-events');


                var sum = 0;
                $(".total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));
                $('#divtotal').html('<strong style="background-color: yellow;"> Rs. <strong>' +
                    showsum);
                $('#hidetotalorder').val(sum);
                $('#job').focus();

                $('#dispath_note').hide();
            }

            finaltotalcalculate();
        }
    });

    $("#secondformsubmit").click(function() {
        if (!$("#expensesform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#chargesubmitBtn").click();
        } else {
            var chargetypeID = $('#chargetype').val();
            var chargeamount = $('#chargeamount').val();
            var chargetype = $("#chargetype option:selected").text();


            $('#chargetableorder > tbody:last').append('<tr class="pointer"><td name="chargetype">' +
                chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
                chargeamount + '</td><td name="chargetypeid" class="d-none">' + chargetypeID +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
            );


            $('#chargetype').val('');
            $('#chargeamount').val('0');


            var sum = 0;
            $(".chargesamount").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divchargestotal').html('<strong style="background-color: yellow;"> Rs. <strong>' +
                showsum);

            $('#hidechargestotal').val(sum);
            $('#job').focus();

        }

        finaltotalcalculate();

    });


    $('#tableorder').on('click', 'tr', function() {
        var r = confirm("Are you sure, You want to remove this product ? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".total").each(function() {
                sum += parseFloat($(this).text());
            });
            $('#totalprice').val(sum);
            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divtotal').html('Rs. ' + showsum);
            $('#hidetotalorder').val(sum);
            $('#job').focus();
            finaltotalcalculate();
        }
    });
    $('#chargetableorder').on('click', 'tr', function() {
        var r = confirm("Are you sure, You want to remove this charge? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".chargesamount").each(function() {
                sum += parseFloat($(this).text());
            });
            $('#totalprice').val(sum);
            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divchargestotal').html('Rs. ' + showsum);
            $('#hidechargestotal').val(sum);
            $('#job').focus();
            finaltotalcalculate();
        }
    });

    $('#btncreateorder').click(function () {

    	if ($('#tableorder > tbody').is(':empty')) {
    		alert("Can't Create! Table is Empty!!!")
    	} else {
    		$('#btncreateorder').prop('disabled', true).html(
    			'<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
    		var tbody = $("#tableorder tbody");
    		var chargestbody = $("#chargetableorder tbody");

    		jsonObj = [];
    		charges_jsonObj = [];

    		if (tbody.children().length > 0) {
    			$("#tableorder tbody tr").each(function () {
    				item = {}
    				$(this).find('td').each(function (col_idx) {
    					item["col_" + (col_idx + 1)] = $(this).text();
    				});

    				jsonObj.push(item);
    			});
    		}

    		if (chargestbody.children().length > 0) {
    			$("#chargetableorder tbody tr").each(function () {
    				item = {}
    				$(this).find('td').each(function (col_idx) {
    					item["col_" + (col_idx + 1)] = $(this).text();
    				});

    				charges_jsonObj.push(item);
    			});
    		}
    		console.log("tableorder");
    		console.log(jsonObj);
    		console.log(charges_jsonObj);

    		var date = $('#date').val();
    		var proces_charges = $('#processcharges').val();
    		var plate_charges = $('#platecharges').val();
    		var ink_charges = $('#inkcharges').val();
    		var customer = $('#customer').val();
    		var total = $('#modeltotalpayment').val();
    		var vat = $('#vat').val();
    		var discount = $('#discount').val();
    		var vatamount = $('#vatamount').val();
    		var subtotal = $('#hiddenfulltotal').val();
    		var branch_id = $('#f_branch_id').val();
    		var company_id = $('#f_company_id').val();
    		var remark = $('#remark').val();

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
    						chargestableData: charges_jsonObj,
    						date: date,
    						total: total,
    						subtotal: subtotal,
    						vat: vat,
    						discount: discount,
    						proces_charges: proces_charges,
    						plate_charges: plate_charges,
    						ink_charges: ink_charges,
    						vatamount: vatamount,
    						customer: customer,
    						company_id: company_id,
    						branch_id: branch_id,
    						remark: remark

    					},
    					url: 'Invoice/Invoiceinsertupdate',
    					success: function (result) {
    						Swal.close();
    						document.body.style.overflow = "auto";

    						var response = JSON.parse(result);
    						if (response.status == 1) {
    							Swal.fire({
    								icon: "success",
    								title: "Invoice Created!",
    								text: "Invoice successfully!",
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
});

$('#customer').change(function() {
    var customerID = $(this).val();
    var companyID = $('#f_company_id').val();
	var branchID = $('#f_branch_id').val();
    // $('#job').empty();
    // $('#job').prepend('<option value="" selected="selected">Select job</option>');
    // $('#job').val(null).trigger('change');
    // $('#dispath_note').empty();
    // $('#dispath_note').prepend('<option value="" selected="selected">Select Dispath Note</option>');

    $.ajax({
        type: "POST",
        data: {
            recordID: customerID,
			companyID: companyID,
			branchID: branchID
        },
        url: 'Invoice/Getjobsaccodispatch',
        success: function(result) {
            var obj = JSON.parse(result);
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $.each(obj, function(i, item) {
                html1 += '<option value="' + obj[i]
                    .job_id + '">';
                html1 += obj[i].job;
                html1 += '</option>';
            });
            $('#job').empty().append(html1);
        }
    });

    $('#qtylabel').text('0');
    $('#newqty').val('0');
    $('#unitprice').val('0');
    $('#dispath_note').val('');
    $('#uom').val('');

});

$('#job').change(function() {
    var jobID = $(this).val();
    var companyID = $('#f_company_id').val();
	var branchID = $('#f_branch_id').val();
    // $('#dispath_note').val('').trigger('change');

    $.ajax({
        type: "POST",
        data: {
            recordID: jobID,
            companyID: companyID,
			branchID: branchID
        },
        url: 'Invoice/Getdispatchaccjob',
        success: function(result) {
            var obj = JSON.parse(result);
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $.each(obj, function(i, item) {
                html1 += '<option value="' + obj[i]
                    .tbl_print_dispatch_idtbl_print_dispatch + '">';
                html1 += obj[i].dispatch_no;
                html1 += '</option>';
            });
            $('#dispath_note').empty().append(html1);
        }
    });
    $('#qtylabel').text('0');
    $('#newqty').val('0');
    $('#unitprice').val('0');
    $('#job_no').val('0');
    $('#uom').val('');
});


$('#dispath_note').change(function() {
    var dispatchID = $(this).val();

    $.ajax({
        type: "POST",
        data: {
            recordID: dispatchID
        },
        url: 'Invoice/Getqtyaccdispatch',
        success: function(result) {
            console.log(result);
            var obj = JSON.parse(result);
            console.log(obj.dispath_note);

            $('#newqty').val(obj.qty);
            $('#unitprice').val(obj.unitprice);
            $('#job_no').val(obj.job_no);
            $('#uom').val(obj.uom);
            $('#dispath_noteid').val(obj.dispath_note);
            $('#inquerydetailsid').val(obj.detailsid);
        }
    });
});

$("#company_btn").click(function() {
    $('#companymodal').modal('show');
});

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to confirm this purchase order Request?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this Invoice?");
}

function cacel_confirm() {
    return confirm("Are you sure you want to Cancel this Invoice?");
}


function finaltotalcalculate() {
    var vat = parseFloat($("#vat").val());
    var discount = parseFloat($("#discount").val());
    var processcharge = parseFloat($("#processcharges").val());
    var platecharge = parseFloat($("#platecharges").val());
    var inkcharge = parseFloat($("#inkcharges").val());
    var total = parseFloat($("#hidetotalorder").val());
    var chargestotal = parseFloat($("#hidechargestotal").val());
    var vatCustomerStatus = $('#customer_vat_status').val();

    if (isNaN(discount)) {
        discount = 0;
        $("#discount").val(0);
    }

    if (isNaN(vat)) {
        vat = 0;
        $("#vat").val(0);
    }

    var finalsubtot = (total + chargestotal) - discount;
    $('#hiddenfulltotal').val(finalsubtot.toFixed(2));

    var vatamount = 0;
    if (vatCustomerStatus != '2') {
        vatamount = parseFloat((finalsubtot / 100) * vat);
    }
    
    $('#vatamount').val(vatamount.toFixed(2));
    var finaltotal = finalsubtot + vatamount;

    $('#modeltotalpayment').val(finaltotal.toFixed(2));
}

function checkCustomerVatStatus() {
    var customerId = $('#customer').val();

    if (customerId) {
        $.ajax({
            url: 'Invoice/getCustomerVatStatus',
            method: 'POST',
            data: {customer_id: customerId},
            success: function(response) {
                $('#customer_vat_status').val(response.vat_customer);
                finaltotalcalculate();
            }
        });
    } else {
        $('#customer_vat_status').val('0');
        finaltotalcalculate();
    }
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

$(document).ready(function() {
    $('input[type="checkbox"]').change(function() {
        var isChecked = $(this).prop('checked');
        var inputField = $(this).closest('.col-3').find('input[type="number"]');
        inputField.prop('disabled', !isChecked);
        if (!isChecked) {
            inputField.val(0);
        }
        finaltotalcalculate();
    });
});

function approvejob(confirmnot, finishJob) {
	Swal.fire({
		title: '',
		html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
		allowOutsideClick: false,
		showConfirmButton: false,
        backdrop: `
            rgba(255, 255, 255, 0.5) 
        `,
        customClass: {
            popup: 'fullscreen-swal'
        },
		didOpen: () => {

			let jsonObj = [];
			$("#viewtable tbody tr").each(function () {
				let item = {};
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});

			$.ajax({
				type: "POST",
				url: '<?php echo base_url() ?>Invoice/Approinvoice',
				data: {
					invoiceid: $('#invoiceid').val(),
					reqestid: $('#reqestid').val(),
					hiddenjobid: $('#job_id').val(),
					confirmnot: confirmnot,
					finish_job: finishJob,
					tableData: jsonObj
				},
				success: function (result) {
					Swal.close();
					var obj = JSON.parse(result);
					obj.status == 1 ? actionreload(obj.action) : action(obj.action);
				}
			});
		}
	});
}


function checkjob(confirmnot){
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
                    requestid: $('#invoiceid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>Invoice/Invoicecheckstatus',
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
</script>



<?php include "include/footer.php"; ?>