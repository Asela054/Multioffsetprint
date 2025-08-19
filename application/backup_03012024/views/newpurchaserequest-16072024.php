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
			#porderviewmodal .modal-content {
				border: 4px solid #0982e6;
				/* Light blue color */
				border-radius: 25px;
				/* Optional: Add rounded corners */
			}

		</style> -->

        <!-- <style>
        .input-like {
            display: inline-block;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            /* Matches the default Bootstrap input border color */
            border-radius: 4px;
            /* Matches the default Bootstrap input border radius */
            background-color: #fff;
            /* White background */
            color: #495057;
            /* Text color */
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            /* Inner shadow to match input fields */
            width: 100%;
            height: 50%;
        }
        </style> -->
        <!-- Modal -->
        <div id="companyview">
            <div class="modal fade" id="companymodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Company Information</h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> -->
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
                                        <?php foreach($branchlist->result() as $rowbranchlist){ ?>
                                        <option value="<?php echo $rowbranchlist->idtbl_company_branch ?>">
                                            <?php echo $rowbranchlist->branch ?></option>
                                        <?php } ?>
                                    </select>
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
                            <div class="page-header-icon"><i class="fa fa-shopping-cart"></i></div>
                            <span>New Purchase Order Request</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="container-fluid mt-2 p-0 p-2">
                            <div class="card">
                                <div class="card-body p-0 p-2">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                            <form id="createorderform" autocomplete="off">
                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Company*</label>
                                                        <input type="text" id="f_company_name" name="f_company_name"
                                                            class="form-control form-control-sm" required readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Company
                                                            Branch*</label>
                                                        <input type="text" id="f_branch_name" name="f_branch_name"
                                                            class="form-control form-control-sm" required readonly>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="f_company_id" id="f_company_id">
                                                <input type="hidden" name="f_branch_id" id="f_branch_id">

                                                <div class="form-group mb-1">
                                                    <label class="small font-weight-bold text-dark">Purchase Order
                                                        Type*</label>
                                                    <select class="form-control form-control-sm" name="ordertype"
                                                        id="ordertype" required>
                                                        <option value="">Select</option>
                                                        <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                                        <option
                                                            value="<?php echo $rowordertypelist->idtbl_order_type ?>">
                                                            <?php echo $rowordertypelist->type ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div id="servisetypeFields">
                                                    <div class="form-group mb-1">
                                                        <label class="small font-weight-bold text-dark">Service
                                                            Type*</label>
                                                        <select class="form-control form-control-sm selecter2 px-0"
                                                            name="servicetype" id="servicetype">
                                                            <option value="">Select</option>
                                                            <?php foreach($servicetypelist->result() as $rowservicetypelist){ ?>
                                                            <option
                                                                value="<?php echo $rowservicetypelist->idtbl_service_type ?>">
                                                                <?php echo $rowservicetypelist->service_name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Order Date*</label>
													<input type="date" class="form-control form-control-sm"
														placeholder="" name="orderdate" id="orderdate"
														value="<?php echo date('Y-m-d') ?>" required>
												</div> -->
                                                <div id="supplierFields">
                                                    <div class="form-group mb-1">
                                                        <label
                                                            class="small font-weight-bold text-dark">Supplier*</label>
                                                        <select class="form-control form-control-sm selecter2 px-0"
                                                            name="supplier" id="supplier">
                                                            <option value="">Select</option>
                                                            <?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
                                                            <option
                                                                value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
                                                                <?php echo $rowsupplierlist->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="productFields">
                                                    <div class="form-group mb-1">
                                                        <label class="small font-weight-bold text-dark">Product*</label>
                                                        <select class="form-control form-control-sm selecter2 px-0"
                                                            name="product" id="product">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row mb-1">
                                                    <div class="col" id="newQtyFields" style="display: none;">
                                                        <label class="small font-weight-bold text-dark">Qty*</label>
                                                        <input type="text" id="newqty" name="newqty"
                                                            class="form-control form-control-sm" required>
                                                    </div>
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">UOM*</label>
                                                        <select class="form-control form-control-sm" name="uom" id="uom"
                                                            required>
                                                            <option value="">Select</option>
                                                            <?php foreach($measurelist->result() as $rowmeasurelist){ ?>
                                                            <option
                                                                value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
                                                                <?php echo $rowmeasurelist->measure_type ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group mb-1">

                                                    <label class="small font-weight-bold text-dark">Unit Price </label>
                                                    <!-- <label2 class="small font-weight-bold text-dark">Amount</label2> -->
                                                    <input type="number" id="unitprice" name="unitprice"
                                                        class="form-control form-control-sm" value="0" step="any">
                                                </div>


                                                <!-- <div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Comment</label>
													<textarea name="comment" id="comment"
														class="form-control form-control-sm"></textarea>
												</div> -->
                                                <div class="form-group mt-3 text-right">
                                                    <button type="button" id="formsubmit"
                                                        class="btn btn-primary btn-sm px-4"
                                                        <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                            class="fas fa-plus"></i>&nbsp;Add
                                                        to
                                                        list</button>
                                                    <input name="submitBtn" type="submit" value="Save" id="submitBtn"
                                                        class="d-none">
                                                </div>
                                                <input type="hidden" name="refillprice" id="refillprice" value="">
                                                <input type="hidden" name="recordOption" id="recordOption" value="1">
                                            </form>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                                            <div id="materialmachinetblpart">
                                                <table class="table table-striped table-bordered table-sm small"
                                                    id="tableorder">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <!-- <th>Comment</th> -->
                                                            <th class="d-none">ProductID</th>
                                                            <!-- <th class="d-none">Unitprice</th> -->
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-center">UOM</th>
                                                            <th class="text-right">Unit Price</th>
                                                            <th class="text-right">Action</th>
                                                            <!-- <th class="d-none">HideTotal</th>
															<th class="text-right">Total</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <div id="vehicletblpart">
                                                <table class="table table-striped table-bordered table-sm small"
                                                    id="vehicletableorder">
                                                    <thead>
                                                        <tr>
                                                            <th class="d-none">Product</th>
                                                            <th>Service Type</th>
                                                            <!-- <th>Comment</th> -->
                                                            <th class="d-none">ProductID</th>
                                                            <!-- <th class="d-none">Unitprice</th> -->
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-center">UOM</th>
                                                            <th class="text-right">Action</th>
                                                            <!-- <th class="d-none">HideTotal</th>
															<th class="text-right">Total</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>


                                            <!-- <div class="row">
												<div class="col text-right">
													<h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
												</div>
												<input type="hidden" id="hidetotalorder" value="0">
											</div> -->
                                            <hr>
                                            <!-- <div class="form-group">
												<label class="small font-weight-bold text-dark">Remark</label>
												<textarea name="remark" id="remark"
													class="form-control form-control-sm"></textarea>
											</div> -->
                                            <div class="form-group mt-2">
                                                <button type="button" id="btncreateorder"
                                                    class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                                        class="fas fa-save"></i>&nbsp;Create
                                                    Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-2 p-0 p-2">
                                <div class="card">
                                    <div class="card-body p-0 p-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="scrollbar pb-3" id="style-2">
                                                    <table class="table table-bordered table-striped table-sm nowrap"
                                                        id="dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>P-Order Req Number</th>
                                                                <th>Branch</th>
                                                                <th>Order Type</th>
                                                                <th>Supplier</th>
                                                                <th>Confirm Status</th>
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
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
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
                    <h5 class="modal-title" id="staticBackdropLabel">View Purchase Order Request</h5>
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
                                class="text-right">Purchase Order Request<span id="pr"></span></h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
                                class="text-right">Multi Offset Printers (PVT) LTD <span id="proname"></span></p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
                                class="text-right">MO/POR-0000<span id="procode"></span></p>
                            <!-- <p style="margin-bottom: 2px;" class="text-right">0775678923 <span id="pronumber"></span>
							</p> -->
                            <!-- Other elements go here -->

                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-6">
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliername"></span></P>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliercontact"></span>
                            </p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress1"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress2"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordercity"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderstate"></span></p>
                        </div>
                    </div>



                    <div id="viewhtml"></div>
                    <div class="card-body p-0 p-2">
                        <br>
                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4">
                                <button type="button" name="approve" id="approve"
                                    class="btn btn-success btn-m fa-pull-right animated-button" title="Approve"><i
                                        class="fas fa-check"></i>&nbsp;Approve</button>
                                <input type="hidden" id="approvebtn" name="approvebtn">
                            </div>
                            <!-- <div class="col-2">
								<button type="button" name="reject" id="reject"
									class="btn btn-danger btn-m fa-pull-right" title="Reject"><i
										class="fas fa-ban"></i>&nbsp;Reject</button>
							</div> -->
                        </div>
                    </div>
                </div>
                <input type="hidden" class="form-control form-control-sm" name="tableId" id="tableId" required readonly>
                <!-- <div class="modal-footer">
					<button type="button" id="printporder" class="btn btn-outline-primary btn-sm fa-pull-right"
						<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Print Purchase
						Order Request</button>
				</div> -->
            </div>
        </div>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    // Open the modal when the page loads
    $('#companymodal').modal('show');

    // Show the main content and hide the modal when the button is clicked
    $('#sub_btn').on('click', function() {
        var company_id = $('#company_id').val();
        var companyname = $('#company_id option:selected').text().trim();
        var branch_id = $('#branch_id').val();
        var branchname = $('#branch_id option:selected').text().trim();
        console.log(companyname);

        // Check if the required fields are selected
        if (!company_id || !branch_id) {
            alert('Please select both Company and Branch.');
            return; // Prevent further execution if fields are not selected
        }

        $('#companymodal').modal('hide');
        $('main').show();

        $('#f_company_id').val(company_id);
        $('#f_branch_id').val(branch_id);

        $('#f_company_name').val(companyname);
        $('#f_branch_name').val(branchname);
    });
});
</script>



<script>
$(document).ready(function() {
    // ... (existing code)
    $('#vehicletblpart').hide();
    $('#newQtyFields').show();
    // $('#material&machinetblpart').show();

    $('#ordertype').change(function() {
        let ordertype = $(this).val();

        // Hide/show field group containers based on ordertype
        if (ordertype == 2) {
            $('#supplierFields').hide();
            $('#productFields').hide();
            $('#newQtyFields').show();
            $('#servisetypeFields').show();
            $('#supplier').removeAttr('required');
            $('#product').removeAttr('required');
            $('#servicetype').attr('required', 'required');
            $('#unitprice').val('0');
            // $('#servisetypeFields').val('0');
            $('#vehicletblpart').show();
            $('#materialmachinetblpart').hide();

        } else {
            $('#supplier').attr('required', 'required'); // Add 'required' attribute
            $('#product').attr('required', 'required');
            $('#servicetype').removeAttr('required');
            $('#supplierFields').show();
            $('#productFields').show();
            $('#newQtyFields').show();
            $('#servisetypeFields').hide();
            $('#vehicletblpart').hide();
            $('#materialmachinetblpart').show();

            //$('label2').hide();
        }
    });

    // ... (existing code)
});
</script>


<script>
$(document).ready(function() {
    $('#servicetype').select2({
        width: '100%',
    });
    $('#supplier').select2({
        width: '100%',
    });
    $('#product').select2({
        width: '100%',
    });
    // $('#branch_id').select2({
    //     width: '100%',
    // });
    // $('#company_id').select2({
    //     width: '100%',
    // });

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
            url: "<?php echo base_url() ?>scripts/newpurchaserequestlist.php",
            type: "POST", // you can use GET
            // data: function(d) {}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": function(row) {
                    return "POR000" + row.idtbl_print_porder_req;
                }
            },
            {
                "data": "branch"
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
                        return '<i class="fas fa-check text-success mr-2"></i>Confirm Order Request';
                    } else {
                        return '<i class="fa fa-times text-danger mr-2"></i>Not Confirm Order Request';
                    }
                }
            },

            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<a href="<?php echo base_url() ?>Newpurchaserequest/Printinvoice/' +
                        full['idtbl_print_porder_req'] +
                        '" target="_self" class="btn btn-secondary btn-sm mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-file-pdf mr-2"></i></a>';

                    button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' +
                        full[
                            'idtbl_print_porder_req'] +
                        '"><i class="fas fa-eye"></i></button>';

                    if (full['porderconfirm'] == 1) {
                        button += '<button class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></button>';
                    } else {
                        // button += '<button class="btn btn-danger btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        // button += '"><i class="fas fa-times"></i></a>';
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
        $('#tableId').val(id);
        $('#approvebtn').val(id);
        $('#procode').html(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Newpurchaserequest/Purchaseorderview',
            success: function(result) { //alert(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
            }
        });

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Newpurchaserequest/porderviewheader',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                // $('#porderdate').text(obj.orderdate);

                $('#pordersuppliername').text(obj.suppliername);
                $('#pordersuppliercontact').text(obj.suppliercontact);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);
                //console.log(obj);
            }
        });
    });

    $('#approve').click(function() {
        var r = confirm("Are you sure you want to confirm this purchase order Request?");
        if (r == true) {
            let approvebtn = $('#approvebtn').val();
            $.ajax({
                type: "POST",
                data: {
                    approvebtn: approvebtn
                },
                url: 'Newpurchaserequest/Newpurchaserequeststatus',
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


    $('#supplier').change(function() {
        let supplierID = $(this).val();
        let ordertype = $('#ordertype').val(); // Assuming ordertype is selected elsewhere on the page.

        // Check if ordertype is equal to 3 Materials
        if (ordertype == 3) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: supplierID
                },
                url: 'Newpurchaserequest/Getproductaccosupplier',
                success: function(result) {
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function(i, item) {
                        html1 += '<option value="' + obj[i]
                            .idtbl_print_material_info + '">';
                        html1 += obj[i].materialname + ' / ' + obj[i]
                            .materialinfocode;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        } else if (ordertype == 1) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: supplierID
                },
                url: 'Newpurchaserequest/Getsparepartaccosupplier',
                success: function(result) {
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function(i, item) {
                        html1 += '<option value="' + obj[i]
                            .idtbl_spareparts + '">';
                        html1 += obj[i].spare_part_name;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        }
    });


    $('#ordertype').change(function() {
        let ordertype = $(this).val();

        // Check if ordertype is equal to 2 Vehicle service
        if (ordertype == 2) {
            $.ajax({
                type: "POST",

                url: 'Newpurchaserequest/Getproductforvehicle',
                success: function(result) {
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function(i, item) {
                        html1 += '<option value="' + obj[i]
                            .idtbl_service_item_list + '">';
                        html1 += obj[i].service_type;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        } // Check if ordertype is equal to 4 machine
        else if (ordertype == 1) {
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $('#product').empty().append(html1);
        } else if (ordertype == 4) {
            $.ajax({
                type: "POST",

                url: 'Newpurchaserequest/Getproductformachine',
                success: function(result) {
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
        } else if (ordertype == 3) {

            var html1 = '';
            html1 += '<option value="">Select</option>';
            $('#product').empty().append(html1);

        }
    });
    // Get Unit Price for Materials

    $('#product').change(function() {
        var productID = $(this).val();
        var ordertype = $('#ordertype').val();

        // alert(productID);
        console.log(ordertype, productID);
        if (ordertype == 3) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                },
                url: 'Newpurchaserequest/Getproductprice',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#unitprice').val(obj.unitprice);
                }
            });
        } else if (ordertype == 1) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                },
                url: 'Newpurchaserequest/Getproductpricespare',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#unitprice').val(obj.unitprice);
                }
            });
        }
        // else if (ordertype == 1) {
        // 	$.ajax({
        // 		type: "POST",
        // 		data: {
        // 			recordID: productID,
        // 			purchaseorder_id: purchaseorder_id
        // 		},
        // 		url: 'Purchaseorder/Getproductinfosparepart',
        // 		success: function (result) { //alert(result);
        // 			var obj = JSON.parse(result);
        // 			$('#newqty').val(obj.qty);
        // 			$('#unitprice').val(obj.unitprice);
        // 			$('#uom').val(obj.uom);
        // 		}
        // 	});
        // }
    });

    //Details table form Material And Machine

    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.F
            $("#submitBtn").click();
        } else {
            var ordertype = $('#ordertype').val();
            if (ordertype == 1 || ordertype == 3 || ordertype == 4) {

                var productID = $('#product').val();
                var comment = $('#comment').val();
                var product = $("#product option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var newqty = parseFloat($('#newqty').val());
                var uomID = $('#uom').val();
                var uom = $("#uom option:selected").text();

                // var newtotal = parseFloat(unitprice * newqty);

                // var total = parseFloat(newtotal);
                // var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product +
                    '</td><td class="d-none">' + productID + '</td><td class="text-center">' +
                    newqty + '</td> <td class="text-center">' +
                    uom + '</td> <td class="text-right">' +
                    unitprice + '</td><td class="d-none">' + uomID +
                    '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
                );

                $('#product').val('');
                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#newqty').val('0');
                $('#uom').val('');

                // var sum = 0;
                // $(".total").each(function () {
                // 	sum += parseFloat($(this).text());
                // });

                // var showsum = addCommas(parseFloat(sum).toFixed(2));

                // $('#divtotal').html('Rs. ' + showsum);
                // $('#hidetotalorder').val(sum);
                $('#product').focus();
            }
            //Details table forn Service
            else {
                var productID = $('#servicetype').val();
                var comment = $('#comment').val();
                var product = $("#servicetype option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var newqty = parseFloat($('#newqty').val());
                var uomID = $('#uom').val();
                var uom = $("#uom option:selected").text();


                var newtotal = parseFloat(unitprice * newqty);

                var total = parseFloat(newtotal);
                var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#vehicletableorder > tbody:last').append('<tr class="pointer"><td>' +
                    product + '</td><td class="d-none">' + productID +
                    '</td><td class="text-center">' + newqty +
                    '</td><td class="text-center">' +
                    uom + '</td> <td class="d-none">' + uomID +
                    '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
                );

                $('#servicetype').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#newqty').val('0');
                $('#uom').val('');

                var sum = 0;
                $(".total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
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
            $(".total").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divtotal').html('Rs. ' + showsum);
            $('#hidetotalorder').val(sum);
            $('#product').focus();
        }
    });
    $('#vehicletableorder').on('click', 'tr', function() {
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
    $('#btncreateorder').click(function() { //alert('IN');
        var ordertype = $('#ordertype').val();
        if (ordertype == 1 || ordertype == 3 || ordertype == 4) {
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
                //alert("click");
                // var orderdate = $('#orderdate').val();
                // var duedate = $('#duedate').val();
                var branch_id = $('#f_branch_id').val();
                var company_id = $('#f_company_id').val();
                var supplier = $('#supplier').val();
                // var location = $('#location').val();
                var ordertype = $('#ordertype').val();
                var recordOption = $('#recordOption').val();

                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        supplier: supplier,
                        ordertype: ordertype,
                        company_id: company_id,
                        branch_id: branch_id,
                        recordOption: recordOption

                    },
                    url: 'Newpurchaserequest/Newpurchaserequestinsertupdate',
                    success: function(result) { //alert(result);
                        console.log(result);
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

            // var orderdate = $('#orderdate').val();
            // var duedate = $('#duedate').val();
            // var remark = $('#remark').val();
            var branch_id = $('#branch_id').val();
            var company_id = $('#company_id').val();
            var supplier = $('#supplier').val();
            var servicetype = $('#servicetype').val();
            var recordOption = $('#recordOption').val();


            $.ajax({
                type: "POST",
                data: {
                    ordertype: ordertype,
                    tableData: jsonObj, // Send the correct data based on ordertype
                    // orderdate: orderdate,
                    // duedate: duedate,
                    // total: total,
                    // remark: remark,
                    // location: location,
                    supplier: supplier, // Include supplier based on your needs
                    servicetype: servicetype,
                    company_id: company_id,
                    branch_id: branch_id,
                    recordOption: recordOption,
                },
                url: 'Newpurchaserequest/Newpurchaserequestinsertupdate',
                success: function(result) {
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
});

// $(document).on("click", "#approve", function () {
// 	var tableId = $('#tableId').val();;
// 	var confirmstatus = 1;
// 	// var comment = $('#comments').val();

// 	$.ajax({
// 		type: "POST",
// 		data: {
// 			confirmstatus: confirmstatus,
// 			tableId: tableId,
// 			// comment: comment,
// 		},
// 		url: '<?php echo base_url() ?>Newpurchaserequest/Newpurchaserequestinsertupdate',
// 		success: function (result) {
// 			//console.log(result);
// 			var objfirst = JSON.parse(result);
// 			$('#recordOption').val('2');
// 			if (objfirst.status == 1) {
// 				setTimeout(function () {
// 					location.reload();
// 				}, 1000);
// 			}
// 			action(objfirst.action)
// 		}
// 	});
// });

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to confirm this purchase order Request?");
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
<?php include "include/footer.php"; ?>