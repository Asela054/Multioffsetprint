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
				border: 3px solid #0982e6;
				/* Light blue color */
				border-radius: 25px;
				/* Optional: Add rounded corners */
			}

		</style> -->
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
                                    data-target="#staticBackdrop" onclick="getVat();"
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

                                                <!-- <th>Remark</th> -->
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
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Order Date*</label>
                                <input type="date" class="form-control form-control-sm" placeholder="" name="orderdate"
                                    id="orderdate" onchange="getVat();" value="<?php echo date('Y-m-d')?>" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Purchase Order Request*</label>
                                <select class="form-control form-control-sm selecter2 px-0" name="porderrequest"
                                    id="porderrequest" required>
                                    <option value="">Select</option>
                                    <?php foreach($porderlist->result() as $rowporderlist){ ?>
                                    <option value="<?php echo $rowporderlist->idtbl_print_porder_req ?>">
                                        <?php echo 'POR000'.$rowporderlist->idtbl_print_porder_req ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Company*</label>
                                <input type="text" id="f_company_name" name="f_company_name"
                                    class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Company Branch*</label>
                                <input type="text" id="f_branch_name" name="f_branch_name"
                                    class="form-control form-control-sm" required readonly>
                            </div>
                            <input type="hidden" name="f_company_id" id="f_company_id">
                            <input type="hidden" name="f_branch_id" id="f_branch_id">

                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Purchase Order Type*</label>
                                <select class="form-control form-control-sm" name="ordertype" id="ordertype" required>
                                    <option value="">Select</option>
                                    <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                    <option value="<?php echo $rowordertypelist->idtbl_order_type ?>">
                                        <?php echo $rowordertypelist->type ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="servisetypeFields">
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Service Type*</label>
                                    <select class="form-control form-control-sm" name="servicetype" id="servicetype">
                                        <option value="">Select</option>
                                        <?php foreach($servicetypelist->result() as $rowservicetypelist){ ?>
                                        <option value="<?php echo $rowservicetypelist->idtbl_service_type ?>">
                                            <?php echo $rowservicetypelist->service_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
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
                            <div id="productFields">
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm selecter2 px-0" name="product"
                                        id="product">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col" id="newQtyFields" style="display: none;">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="number" id="newqty" name="newqty" class="form-control form-control-sm"
                                        required readonly>
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
                            <div class="form-group mb-1">

                                <label class="small font-weight-bold text-dark">Unit Price / Amount</label>
                                <!-- <label2 class="small font-weight-bold text-dark">Amount</label2> -->
                                <input type="number" id="unitprice" name="unitprice"
                                    class="form-control form-control-sm" value="0" step="any">
                            </div>

                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark" hidden>Vat (%)</label>
                                    <input type="number" id="vat" name="vat" class="form-control form-control-sm"
                                        value="0" hidden>
                                </div>

                                <div class="col">
                                    <label class="small font-weight-bold text-dark" hidden>Discount</label>
                                    <input type="number" id="discount" name="discount"
                                        class="form-control form-control-sm" value="0" hidden>
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
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div id="materialmachinetblpart">
                            <div class="scrollbar pb-3" id="style-3">
                                <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <!-- <th>Comment</th> -->
                                            <th class="d-none">ProductID</th>
                                            <th class="d-none">Unitprice</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Uom</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="d-none">HideTotal</th>
                                            <th class="text-right">Total</th>

                                            <!-- <th class="text-right">Discount</th>
											<th class="text-right">Vat(%)</th>
											<th class="text-right">Vat(Amount)</th>
											<th class="text-right">Total</th> -->
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
                                            <!-- <th>Comment</th> -->
                                            <th class="d-none">ProductID</th>
                                            <th class="d-none">Unitprice</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Uom</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="d-none">HideTotal</th>
                                            <th class="text-right">Total</th>

                                            <!-- <th class="text-right">Discount</th>
											<th class="text-right">Vat(%)</th>
											<th class="text-right">Vat(Amount)</th>
											<th class="text-right">Total</th> -->
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- <div class="row">
							<div class="col text-right">
								<h8 class="font-weight-600" id="divgrosstotal"></h8>
							</div>
							<input type="hidden" id="hidegrosstotalorder" value="0">
						</div>
						<div class="row">
							<div class="col text-right">
								<h8 class="font-weight-600" id="divtotaldiscount"></h8>
							</div>
							<input type="hidden" id="hidediscountlorder" value="0">
						</div>
						<div class="row">
							<div class="col text-right">
								<h8 class="font-weight-600" id="divtotalvat"></h8>
							</div>
							<input type="hidden" id="hidevatlorder" value="0">
						</div> -->
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
                            <button type="button" id="btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Create
                                Purchase Order</button>
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

                            <!-- <p style="margin-bottom: 2px;" class="text-right">0775678923 <span
										id="pronumber"></span></p> -->
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
    // // Open the modal when the page loads
    // if (!sessionStorage.getItem('invoice_company_id')) {
    //             $('#companymodal').modal('show');
    // }
    // else{
    //     $('#company_id').val(sessionStorage.getItem('invoice_company_id'));
    //     $('#company_id').trigger('change');
    //     setTimeout(function() {
    //         $('#company_id').trigger('change');
    //         setTimeout(function() {
    //             $('#branch_id').val(sessionStorage.getItem('invoice_branch_id'));
    //         }, 200);
    //     }, 100);

    //     $('#savecompaydata').prop('checked', true);

    //     $('#f_company_id').val(sessionStorage.getItem('invoice_company_id'));
    //     $('#f_company_name').val(sessionStorage.getItem('invoice_company_name'));
    //     $('#f_branch_id').val(sessionStorage.getItem('invoice_branch_id'));
    //     $('#f_branch_name').val(sessionStorage.getItem('invoice_branch_name'));

    // }

        $('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
        $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
        $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
        $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');

    // Show the main content and hide the modal when the button is clicked
    // $('#sub_btn').on('click', function() {
    //     $('#customer').val('').trigger('change');
    //     $('#job').val('').trigger('change');
    //     $('#dispath_note').val('').trigger('change');
        
    //     var company_id = $('#company_id').val();
    //     var companyname = $('#company_id option:selected').text().trim();
    //     var branch_id = $('#branch_id').val();
    //     var branchname = $('#branch_id option:selected').text().trim();
    //     console.log(companyname);

    //     // Check if the required fields are selected
    //     if (!company_id || !branch_id) {
    //         alert('Please select both Company and Branch.');
    //         return; // Prevent further execution if fields are not selected
    //     }

    //     var isCompanyDataChecked = $('#savecompaydata').prop('checked');
    //     if (isCompanyDataChecked) {
    //             sessionStorage.setItem('invoice_company_id', company_id);
    //             sessionStorage.setItem('invoice_company_name', companyname);
    //             sessionStorage.setItem('invoice_branch_id', branch_id);
    //             sessionStorage.setItem('invoice_branch_name', branchname);
    //         } else {
    //             sessionStorage.removeItem('invoice_company_id');
    //             sessionStorage.removeItem('invoice_company_name');
    //             sessionStorage.removeItem('invoice_branch_id');
    //             sessionStorage.removeItem('invoice_branch_name');
    //         }

    //     $('#companymodal').modal('hide');
    //     $('main').show();

    //     $('#f_company_id').val(company_id);
    //     $('#f_branch_id').val(branch_id);

    //     $('#f_company_name').val(companyname);
    //     $('#f_branch_name').val(branchname);
    // });
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
<!-- <script>
	// Add an event listener to the orderrequest select element
	$("#porderrequest").change(function () {
		// Clear the contents of vehicletableorder
		$('#vehicletableorder tbody').empty();

		// Clear the contents of tableorder
		$('#tableorder tbody').empty();
	});

	// Add the existing code for form submission after the change event listener
	$("#formsubmit").click(function () {
		// Your existing form submission code here...
	});

</script> -->

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
    $('#product').select2({
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
            // 'copy', 'csv', 'excel', 'pdf', 'print'
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
        "columns": [{
                "data": function(row) {
                    return "PO000" + row.idtbl_print_porder;
                }
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
            // {
            // 	"data": "location"
            // },

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
                        '" target="_self" class="btn btn-secondary btn-sm mr-1 ';
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
                //console.log(obj);
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


    // $('#supplier').change(function () {
    // 	let supplierID = $(this).val();
    // 	let ordertype = $('#ordertype')
    // 		.val(); // Assuming ordertype is selected elsewhere on the page.

    // 	// Check if ordertype is equal to 3 Materials
    // 	if (ordertype == 3) {
    // 		$.ajax({
    // 			type: "POST",
    // 			data: {
    // 				recordID: supplierID
    // 			},
    // 			url: 'Purchaseorder/Getproductaccosupplier',
    // 			success: function (result) {
    // 				var obj = JSON.parse(result);
    // 				var html1 = '';
    // 				html1 += '<option value="">Select</option>';
    // 				$.each(obj, function (i, item) {
    // 					html1 += '<option value="' + obj[i]
    // 						.idtbl_print_material_info + '">';
    // 					html1 += obj[i].materialname + ' / ' + obj[i]
    // 						.materialinfocode;
    // 					html1 += '</option>';
    // 				});
    // 				$('#product').empty().append(html1);
    // 			}
    // 		});
    // 	}
    // });


    // $('#ordertype').change(function () {
    // 	let ordertype = $(this).val();

    // 	// Check if ordertype is equal to 2 Vehicle service
    // 	if (ordertype == 2) {
    // 		$.ajax({
    // 			type: "POST",

    // 			url: 'Purchaseorder/Getproductforvehicle',
    // 			success: function (result) {
    // 				var obj = JSON.parse(result);
    // 				var html1 = '';
    // 				html1 += '<option value="">Select</option>';
    // 				$.each(obj, function (i, item) {
    // 					html1 += '<option value="' + obj[i]
    // 						.idtbl_service_item_list + '">';
    // 					html1 += obj[i].service_type;
    // 					html1 += '</option>';
    // 				});
    // 				$('#product').empty().append(html1);
    // 			}
    // 		});
    // 	} // Check if ordertype is equal to 4 machine
    // 	else if (ordertype == 4) {
    // 		$.ajax({
    // 			type: "POST",

    // 			url: 'Purchaseorder/Getproductformachine',
    // 			success: function (result) {
    // 				var obj = JSON.parse(result);
    // 				var html1 = '';
    // 				html1 += '<option value="">Select</option>';
    // 				$.each(obj, function (i, item) {
    // 					html1 += '<option value="' + obj[i]
    // 						.idtbl_machine + '">';
    // 					html1 += obj[i].machine;
    // 					html1 += '</option>';
    // 				});
    // 				$('#product').empty().append(html1);
    // 			}
    // 		});
    // 	} else if (ordertype == 3) {

    // 		var html1 = '';
    // 		html1 += '<option value="">Select</option>';
    // 		$('#product').empty().append(html1);

    // 	}
    // });

    //Details table form Material And Machine

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
                var uom = $("#uom option:selected").text();
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


                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product +
                    '</td><td class="d-none">' +
                    comment + '</td><td class="d-none">' + productID +
                    '</td><td class="text-center">' + newqty +
                    '</td><td class="text-center">' + uom +
                    '</td><td class="d-none">' + uomID +
                    '</td><td class="text-right">' +
                    unitprice + '</td><td class="total d-none">' + total +
                    '</td><td class="text-right">' +
                    showtotal + '</td></tr>');

                $('#product').val('');
                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#uom').val('');
                $('#newqty').val('0');
                $('#discount').val('0');
                // $('#vat').val('0');
                $('#porderrequest').prop('readonly', true).css('pointer-events', 'none');


                //////////////////////////////////////////// Gross Total ////////////////////////////////////////////////

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


                //////////////////////////////////////////// Total Vat ////////////////////////////////////////////////

                var sum = 0;
                $(".total_vat").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotvat = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotalvat').html('Vat Total &nbsp; &nbsp; Rs.' + showtotvat);
                $('#hidevatlorder').val(sum);
                $('#product').focus();


                //////////////////////////////////////////// Total Discount ////////////////////////////////////////////////
                var sum = 0;
                $(".total_discount").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotdiscount = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotaldiscount').html('Discount &nbsp; &nbsp; Rs.' + showtotdiscount);
                $('#hidediscountlorder').val(sum);
                $('#product').focus();


                /////////////////////////////////////////////////Final Total/////////////////////////////////////////////////
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
            //Details table forn Service
            else {
                var productID = $('#servicetype').val();
                var comment = $('#comment').val();
                var product = $("#servicetype option:selected").text();
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

                //////////////////////////////////////////// Gross Total ////////////////////////////////////////////////

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


                //////////////////////////////////////////// Total Vat ////////////////////////////////////////////////

                var sum = 0;
                $(".total_vat").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotvat = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotalvat').html('Vat Total &nbsp; &nbsp; Rs.' + showtotvat);
                $('#hidevatlorder').val(sum);
                $('#product').focus();


                //////////////////////////////////////////// Total Discount ////////////////////////////////////////////////
                var sum = 0;
                $(".total_discount").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotdiscount = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotaldiscount').html('Discount &nbsp; &nbsp; Rs.' + showtotdiscount);
                $('#hidediscountlorder').val(sum);
                $('#product').focus();


                /////////////////////////////////////////////////Final Total/////////////////////////////////////////////////
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
    $('#btncreateorder').click(function() { //alert('IN');
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
                //alert("click");
                var orderdate = $('#orderdate').val();
                var duedate = $('#duedate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var discounttotal = $('#hidediscountlorder').val();
                var vatamounttotal = $('#hidevatlorder').val();
                var grosstotal = $('#hidegrosstotalorder').val();
                var supplier = $('#supplier').val();
                // var location = $('#location').val();
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
                        // location: location,
                        ordertype: ordertype,
                        company_id: company_id,
                        branch_id: branch_id,
                        porderrequest: porderrequest

                    },
                    url: 'Purchaseorder/Purchaseorderinsertupdate',
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
            var branch_id = $('#branch_id').val();
            var company_id = $('#company_id').val();
            // var servicetype = $('#servicetype').val();
            var porderrequest = $('#porderrequest').val();


            $.ajax({
                type: "POST",
                data: {
                    ordertype: ordertype,
                    tableData: jsonObj, // Send the correct data based on ordertype
                    orderdate: orderdate,
                    duedate: duedate,
                    total: total,
                    discounttotal: discounttotal,
                    vatamounttotal: vatamounttotal,
                    grosstotal: grosstotal,
                    remark: remark,
                    location: location,
                    supplier: supplier, // Include supplier based on your needs
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
    var tempgrntype;
    // get supplier acording to porder request //////
    $('#porderrequest').change(function() {
        //   resetTable();
        var porderID = $(this).val(); //alert(porderID);


        $.ajax({
            type: "POST",
            data: {
                recordID: porderID
            },
            url: 'Purchaseorder/Getsupplieraccoporderreq',
            success: function(result) { //alert(result);
                $('#supplier').val(result).css('pointer-events', 'none');
                // $('#supplier').val(result);
                // $('#supplier option').each(function() {
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
            url: 'Purchaseorder/Getcompanyaccoporderreq',
            success: function(result) {
                //alert(result);
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
            url: 'Purchaseorder/Getbranchaccoporderreq',
            success: function(result) {
                //alert(result);
                $('#branch_id').val(result).css('pointer-events', 'none');
                // $('#branch_id').val(result);
                // $('#branch_id option').each(function() {
                //     if (!this.selected) {
                //         $(this).attr('disabled', true);
                //     }
                // });
            }
        });
        //**********************************Materials and Machine and service get product acording to order type***************** */
        function getitems(ordertype) {
            if (ordertype == 4) {
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: porderID
                    },
                    url: 'Purchaseorder/Getproductformachine',
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
            } else if (ordertype == 3) {
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: porderID
                    },
                    url: 'Purchaseorder/Getproductaccoporder',
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
            } else if (ordertype == 1) {
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: porderID
                    },
                    url: 'Purchaseorder/Getproductforsparepart',
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
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: porderID
                    },
                    url: 'Purchaseorder/Getservicetyperequest',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        var html1 = '';
                        html1 += '<option value="">Select</option>';
                        $.each(obj, function(i, item) {
                            html1 += '<option value="' + obj[i]
                                .idtbl_service_type + '">';
                            html1 += obj[i].service_name;
                            html1 += '</option>';
                        });
                        $('#servicetype').empty().append(html1);
                    }
                });
            }
        };

        ///////////////////////////////////////// get ordertype acording to request /////////////////////////////////////////////////

        // $.ajax({
        // 	type: "POST",
        // 	data: {
        // 		recordID: porderID
        // 	},
        // 	url: 'Purchaseorder/Getpordertpeaccoporderrequest',
        // 	success: function (result) { //alert(result);
        // 		$('#ordertype').val(result);
        // 		$('#ordertype option').each(function () {
        // 			if (!this.selected) {
        // 				$(this).attr('disabled', true);
        // 			}
        // 		});
        // 		tempgrntype = result;
        // 		getitems(result);
        // 		typewiseSelect(result)
        // 		getqty(result)

        // 	}
        // });
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: porderID
                },
                url: 'Purchaseorder/Getpordertpeaccoporderrequest',
                success: function(result) {
                    $('#ordertype').val(result).css('pointer-events', 'none');
                    // $('#ordertype option').each(function () {
                    // 	if (!this.selected) {
                    // 		$(this).css('pointer-events', 'none');
                    // 	}

                    // });
                    tempgrntype = result;
                    getitems(result);
                    typewiseSelect(result)
                    /////////////////////////////////// when swich type then qty and uom null ////////////////////////
                    $('#newqty').val('');
                    $('#uom').val('');
                },
                error: reject
            });
        });
        // $.ajax({
        // 	type: "POST",
        // 	data: {
        // 		recordID: porderID
        // 	},
        // 	url: 'Purchaseorder/Getmesuretpeaccorproduct',
        // 	success: function (result) { alert(result);
        // 		$('#uom').val(result);
        // 		$('#uom option').each(function () {
        // 			if (!this.selected) {
        // 				$(this).attr('disabled', true);
        // 			}
        // 		});

        // 	}
        // });

        ///////////////////////////////////////// get qty acording product from request /////////////////////////////////////////////////
        // 		function resetTable() {
        //     // Assuming 'orderTable' is the ID of your table
        //     $('#orderTable tbody').empty(); // Clear the table body
        // 	  $('#materialmachinetblpart tbody').empty(); // Clear the table body
        //     // Additional code if needed to reset any other table-related components
        // }


    });
    $('#product').change(function() {
        var productID = $(this).val();
        var ordertype = tempgrntype;
        var purchaseorder_id = $('#porderrequest').val();
        console.log(ordertype, productID, purchaseorder_id);
        if (ordertype == 3) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    purchaseorder_id: purchaseorder_id,
                    ordertype: ordertype
                },
                url: 'Purchaseorder/Getproductinfoaccoproduct',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#newqty').val(obj.qty);
                    $('#unitprice').val(obj.unitprice);
                    $('#uom').val(obj.uom);
                }
            });
        } else if (ordertype == 4) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    purchaseorder_id: purchaseorder_id
                },
                url: 'Purchaseorder/Getproductinfoamachine',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#newqty').val(obj.qty);
                    $('#unitprice').val(obj.unitprice);
                    $('#uom').val(obj.uom);
                }
            });
        } else if (ordertype == 1) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    purchaseorder_id: purchaseorder_id
                },
                url: 'Purchaseorder/Getproductinfosparepart',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#newqty').val(obj.qty);
                    $('#unitprice').val(obj.unitprice);
                    $('#uom').val(obj.uom);
                }
            });
        }
    });
    $('#servicetype').change(function() {
        var productID = $(this).val();
        var ordertype = tempgrntype;
        var purchaseorder_id = $('#porderrequest').val();
        if (ordertype == 2) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    purchaseorder_id: purchaseorder_id
                },
                url: 'Purchaseorder/Getproductinfoservice',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#newqty').val(obj.qty);
                    $('#unitprice').val(obj.unitprice);
                    $('#uom').val(obj.uom);
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
}

function getVat() {
    var currentDate = $('#orderdate').val();

    $.ajax({
        type: "POST",
        data: {
            currentDate: currentDate,
        },
        url: 'Purchaseorder/Getvatpresentage',
        success: function(result) { //alert(result);
            var obj = JSON.parse(result);

            $('#vat').val(obj);
        }
    });
}
</script>

<?php include "include/footer.php"; ?>