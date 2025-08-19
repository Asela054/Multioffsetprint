<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
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
            <style>
            .disabled-pointer-events {
                pointer-events: none;
            }

            .vl {
                border-left: 4px solid rgb(60, 90, 180);
                height: 200px;
            }
            </style>

            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                    <div class="col-12" style="text-align: end;">
                        <button type="button" class="btn btn-outline-danger btn-sm " name="company_btn"
                            id="company_btn"><i class="fas fa-building"></i>&nbsp;Select Company</button>
                    </div>
                        <div class="container-fluid mt-2 p-0 p-2">
                            <div class="card">
                                <div class="card-body p-0 p-2">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <form id="createorderform" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Date*</label>
                                                        <input type="date" class="form-control form-control-sm"
                                                            placeholder="" name="date" id="date" onchange="getVat();"
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
                                                        <label
                                                            class="small font-weight-bold text-dark">Customer*</label>
                                                        <select class="form-control form-control-sm  px-0"
                                                            name="customer" id="customer" required>
                                                            <option value="">Select</option>
                                                            <?php foreach($customerlist->result() as $rowcustomerlist){ ?>
                                                            <option
                                                                value="<?php echo $rowcustomerlist->idtbl_customer ?>">
                                                                <?php echo $rowcustomerlist->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Job*</label>
                                                        <select class="form-control form-control-sm  px-0" name="job"
                                                            id="job" required>
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>


                                                    <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Dispatch
                                                            Note*</label>
                                                        <select class="form-control form-control-sm  px-0"
                                                            name="dispath_note" id="dispath_note" required>
                                                            <option value="">Select</option>
                                                        </select>
                                                        <input type="text" id="dispath_noteid" name="dispath_noteid"
                                                            class="form-control form-control-sm" value="" readonly
                                                            hidden>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Job No*</label>
                                                        <input type="text" id="job_no" name="job_no"
                                                            class="form-control form-control-sm" required readonly>

                                                        <!-- <input type="hidden" id="dispath_noteid" name="dispath_noteid"
															class="form-control form-control-sm" value="" readonly> -->
                                                        <!-- <select class="form-control form-control-sm" name="dispath_note"
														id="dispath_note" required>
														<option value="">Select</option>

													</select> -->
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
                                                        <select class="form-control form-control-sm" name="uom" id="uom"
                                                            required readonly>
                                                            <option value="">Select</option>
                                                            <?php foreach($measurelist->result() as $rowmeasurelist){ ?>
                                                            <option
                                                                value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
                                                                <?php echo $rowmeasurelist->measure_type ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Unit
                                                            Price</label>
                                                        <!-- <label2 class="small font-weight-bold text-dark">Amount</label2> -->
                                                        <input type="number" id="unitprice" name="unitprice"
                                                            class="form-control form-control-sm" value="0" step="any">

                                                    </div>
                                                </div>
                                                <input type="hidden" id="inquerydetailsid" name="inquerydetailsid"
                                                    class="form-control form-control-sm" />

                                                <!-- <div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Comment</label>
													<textarea name="comment" id="comment"
														class="form-control form-control-sm"></textarea>
												</div> -->
                                                <div class="form-group mt-2 text-right">
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
                                    </div>
                                </div>

                                <hr
                                    style="height:3px; border:none; color:rgb(60,90,180); background-color:rgb(60,90,180);">
                                <div class="card">
                                    <div class="card-body p-0 p-2">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
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
                                                                <!-- <th class="d-none">HideTotal</th>
															<th class="text-right">Total</th> -->
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
                                            <div class="vl"></div>
                                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form id="expensesform" autocomplete="off">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Charge
                                                                        Type
                                                                    </label>
                                                                    <select class="form-control form-control-sm"
                                                                        name="chargetype" id="chargetype" required>
                                                                        <option value="">Select Charge</option>
                                                                        <?php foreach($chargelist->result() as $rowchargelist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowchargelist->idtbl_charges ?>">
                                                                            <?php echo $rowchargelist->charges_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-4">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Amount
                                                                    </label>
                                                                    <input type="number" step="any" name="chargeamount"
                                                                        class="form-control form-control-sm"
                                                                        id="chargeamount" required>
                                                                </div>
                                                                <div class="col-1">
                                                                </div>
                                                                <div class="form-group mt-3  md-8 sm-12 text-right">
                                                                    <button style="position: absolute;bottom:0"
                                                                        type="button" id="secondformsubmit"
                                                                        class="btn btn-secondary btn-sm px-6"
                                                                        <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                                            class="fas fa-plus"></i>&nbsp;Add
                                                                        Charge</button>
                                                                    <input name="chargesubmitBtn" type="submit"
                                                                        value="Save" id="chargesubmitBtn"
                                                                        class="d-none">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class='row'>
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <div id="materialmachinetblpart">
                                                            <table
                                                                class="table table-striped table-bordered table-sm small"
                                                                id="chargetableorder">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Charge Type</th>
                                                                        <th class="text-right">Amount</th>
                                                                        <th class="text-right">Action</th>
                                                                        <!-- <th class="d-none">HideTotal</th>
															<th class="text-right">Total</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                            <div class="row">
                                                                <div class="col text-right">
                                                                    <h4 class="font-weight-600" id="divchargestotal">Rs.
                                                                        0.00
                                                                    </h4>
                                                                    <input type="hidden" id="hidechargestotal"
                                                                        value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="row">
												<div class="col-3">
													<label class="small font-weight-bold text-dark">Plate
														Charges* &nbsp;<input type="checkbox"
															class="small font-weight-bold text-dark"
															name="platechargescheck" id="platechargescheck"></label>
													<input type="number" class="form-control form-control-sm"
														id="platecharges" value="0" onkeyup="finaltotalcalculate();"
														disabled>
													
												</div>
												<div class="col-3">
													<label class="small font-weight-bold text-dark">Ink Charges*
														&nbsp;<input type="checkbox"
															class="small font-weight-bold text-dark"
															name="inkchargescheck" id="inkchargescheck"></label>
													<input type="number" class="form-control form-control-sm"
														id="inkcharges" onkeyup="finaltotalcalculate();" value="0"
														disabled>
													
												</div>
												<div class="col-3">
													<label class="small font-weight-bold text-dark">Process
														Charges* &nbsp;<input type="checkbox"
															class="small font-weight-bold text-dark"
															name="processchargescheck" id="processchargescheck"></label>
													<input type="number" class="form-control form-control-sm"
														id="processcharges" value="0" onkeyup="finaltotalcalculate();"
														disabled>
													
												</div>
												
											</div> -->
                                <div class="card-body p-0 p-2">
                                    <div class="container-fluid mt-2 p-0 p-2">
                                        <div class="row">
                                            <div class="col-2">
                                                <label class="small font-weight-bold text-dark">Discount </label>
                                                <input type="number" step="any" name="discount"
                                                    class="form-control form-control-sm" id="discount" value="0"
                                                    onkeyup="finaltotalcalculate();" required>
                                            </div>
                                            <div class="col-2">
                                                <label class="small font-weight-bold text-dark">Sub Total </label>
                                                <input type="number" step="any" name="hiddenfulltotal"
                                                    class="form-control form-control-sm" id="hiddenfulltotal" readonly>
                                            </div>
                                            <div class="col-2">
                                                <label class="small font-weight-bold text-dark">Vat (%)*</label>
                                                <input type="number" id="vat" name="vat"
                                                    class="form-control form-control-sm" value="18"
                                                    onkeyup="finaltotalcalculate();" required>
                                            </div>

                                            <div class="col-2">
                                                <label class="small font-weight-bold text-dark">Vat Amount*</label>
                                                <input type="number" id="vatamount" name="vatamount"
                                                    class="form-control form-control-sm" value="0" required readonly>
                                            </div>
                                            <div class="col-3">
                                                <label class="small font-weight-bold text-dark"><b>Total
                                                        Payment</b></label>
                                                <input type="number" step="any" name="modeltotalpayment"
                                                    class="form-control form-control-sm small font-weight-bold text-dark"
                                                    id="modeltotalpayment" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="small font-weight-bold text-dark">Remark</label>
                                            <textarea name="remark" id="remark"
                                                class="form-control form-control-sm"></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mt-2">
                                                    <button type="button" id="btncreateorder"
                                                        class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                                            class="fas fa-save"></i>&nbsp;Create Invoice</button>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>



                                    </div>
                                </div>
                            </div>

                            <hr style="height:5px;border-width:0;color:gray;background-color:gray">

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
                                                                <th>Invoice Number</th>
                                                                <th>Date</th>
                                                                <th>Customer</th>
                                                                <!-- <th>Dispatch Number</th> -->
                                                                <th>Total Amount</th>
                                                                <!-- <th>Confirm Status</th> -->
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
                    <h5 class="modal-title" id="staticBackdropLabel">View Invoice</h5>
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
                                class="text-right" class="text-right">MO/INV-000<span id="procode"></span>
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
                <!-- <input type="hidden" id="viewissueid" name="viewissueid" />
				<div class="modal-footer">
					<button type="button" id="approvel" class="btn btn-outline-primary btn-sm fa-pull-right"><i
							class="far fa-save"></i>&nbsp;
						Approvel</button>
				</div> -->
                <input type="hidden" class="form-control form-control-sm" name="tableId" id="tableId" required readonly>
            </div>
        </div>

    </div>
</div>


<?php include "include/footerscripts.php"; ?>

<script>
$(document).ready(function() {
    // Open the modal when the page loads
    if (!sessionStorage.getItem('invoice_company_id')) {
                $('#companymodal').modal('show');
    }
    else{
        $('#company_id').val(sessionStorage.getItem('invoice_company_id'));
        $('#company_id').trigger('change');
        setTimeout(function() {
            $('#company_id').trigger('change');
            setTimeout(function() {
                $('#branch_id').val(sessionStorage.getItem('invoice_branch_id'));
            }, 200);
        }, 100);

        $('#savecompaydata').prop('checked', true);

        $('#f_company_id').val(sessionStorage.getItem('invoice_company_id'));
        $('#f_company_name').val(sessionStorage.getItem('invoice_company_name'));
        $('#f_branch_id').val(sessionStorage.getItem('invoice_branch_id'));
        $('#f_branch_name').val(sessionStorage.getItem('invoice_branch_name'));

    }

    // Show the main content and hide the modal when the button is clicked
    $('#sub_btn').on('click', function() {
        $('#customer').val('').trigger('change');
        $('#job').val('').trigger('change');
        $('#dispath_note').val('').trigger('change');
        
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

        var isCompanyDataChecked = $('#savecompaydata').prop('checked');
        if (isCompanyDataChecked) {
                sessionStorage.setItem('invoice_company_id', company_id);
                sessionStorage.setItem('invoice_company_name', companyname);
                sessionStorage.setItem('invoice_branch_id', branch_id);
                sessionStorage.setItem('invoice_branch_name', branchname);
            } else {
                sessionStorage.removeItem('invoice_company_id');
                sessionStorage.removeItem('invoice_company_name');
                sessionStorage.removeItem('invoice_branch_id');
                sessionStorage.removeItem('invoice_branch_name');
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
        $('#company_id').change(function() {
            var company_id = $(this).val();
            if (company_id != '') {
                $.ajax({
                    url: '<?php echo base_url('Customerinquiry/Getcompanybranch'); ?>', // Replace with your actual controller and method
                    type: 'post',
                    data: {company_id: company_id},
                    dataType: 'json',
                    success:function(response) {
                        var len = response.length;
                        $('#branch_id').empty();
                        $('#branch_id').append("<option value=''>Select</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['idtbl_company_branch'];
                            var name = response[i]['branch'];
                            $('#branch_id').append("<option value='" + id + "'>" + name + "</option>");
                        }
                    }
                });
            } else {
                $('#branch_id').empty();
                $('#branch_id').append("<option value=''>Select</option>");
            }
        });
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
            // data: function(d) {}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": function(row) {
                    return "INV000" + row.idtbl_print_invoice;
                }
            },
            {
                "data": "date"
            },
            {
                "data": "name"
            },
            // {
            // 	"data": function (row) {
            // 		return "DPN000" + row.tbl_print_dispatch_idtbl_print_dispatch;
            // 	}
            // },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return addCommas(parseFloat(full['total']).toFixed(2));
                }
            },

            // {
            // 	"targets": -1,
            // 	"className": '',
            // 	"data": null,
            // 	"render": function (data, type, full) {
            // 		if (full['confirmstatus'] == 1) {
            // 			return '<i class="fas fa-check text-success mr-2"></i>Confirm Order Request';
            // 		} else {
            // 			return '<i class="fa fa-times text-danger mr-2"></i>Not Confirm Order Request';
            // 		}
            // 	}
            // },

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
                        '" target="_blank" class="btn btn-secondary btn-sm btnPdf mr-1 id="' +
                        full['idtbl_print_invoice'] +
                        '"><i class="fas fa-file-pdf"></i></a>'; //pdf
                    if (editcheck != 1) {
                        button += 'd-none';
                    }

                    button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' +
                        full[
                            'idtbl_print_invoice'] + '" aproval_id="' + full[
                            'approvestatus'] + '" request_id="' + full[
                            'tbl_print_dispatch_idtbl_print_dispatch'] +
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
                            '/3/" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    }

                    if (full['approvestatus'] == 1 && full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>Invoice/Invoicestatus/' +
                            full['idtbl_print_invoice'] +
                            '/4/" onclick="return cacel_confirm()" target="_self" class="btn btn-info btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '" title="Cancel"><i class="fa fa-ban"></i></a>';
                    }
                    // button += '<button class="btn btn-yellow btn-sm btncancel mr-1" id="' +
                    // 	full[
                    // 		'idtbl_print_invoice'] + '" aproval_id="' + full[
                    // 		'status'] + '" request_id="' + full[
                    // 		'tbl_print_dispatch_idtbl_print_dispatch'] +
                    // 	'"><i class="fas fa-eye"></i></button>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        },
        rowCallback: function(row, data) {
            if (data.status == 4) {
                $(row).css('background-color', '#FFADB0'); /* Light yellow color */
            }
        }
    });



    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#reqestid').val($(this).attr('request_id'));
        $('#statusid').val($(this).attr('aproval_id'));
        $('#tableId').val(id);
        $('#approvebtn').val(id);
        $('#procode').html(id);
        //alert(reqestid);

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
            url: '<?php echo base_url() ?>Invoice/Invoiceview',
            success: function(result) {
                //alert(result);
                console.log(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
            }
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
                //console.log(obj);
            }
        });
    });


    // $('#dataTable tbody').on('click', '.btncancel', function () {
    // 	var id = $(this).attr('id');
    // 	$('#reqestid').val($(this).attr('request_id'));
    // 	$('#statusid').val($(this).attr('aproval_id'));
    // 	$('#tableId').val(id);
    // 	$('#approvebtn').val(id);
    // 	$('#procode').html(id);
    // 	//alert(reqestid);

    // 	var statusid = $(this).attr('aproval_id');

    // 	if (statusid == 4) {
    // 		$('#approve').addClass('d-none');
    // 	} else {
    // 		$('#approve').removeClass('d-none');
    // 	}
    // 	$.ajax({
    // 		type: "POST",
    // 		data: {
    // 			recordID: id
    // 		},
    // 		url: '<?php echo base_url() ?>Invoice/Invoicestatus',
    // 		success: function (result) {
    // 			alert(result);

    // 			// $('#porderviewmodal').modal('show');
    // 			// $('#viewhtml').html(result);
    // 		}
    // 	});

    // });



    $('#approve').click(function() {
        var r = confirm("Are you sure you want to confirm this Invoice?");
        if (r == true) {
            let approvebtn = $('#approvebtn').val();
            let dispatchid = $('#reqestid').val();

            var tbody = $("#viewtable tbody");
            //alert(result)
            jsonObj = [];
            if (tbody.children().length > 0) {
                $("#viewtable tbody tr").each(function() {
                    item = {}
                    $(this).find('td').each(function(col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });

                    jsonObj.push(item);
                });
            }
            console.log(jsonObj);

            $.ajax({
                type: "POST",
                data: {
                    approvebtn: approvebtn,
                    dispatchid: dispatchid,
                    tableData: jsonObj
                },
                url: 'Invoice/Approinvoice',
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


    //Details table form Material And Machine

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

            // Check for duplicate dispath_noteid
            var duplicate = false;
            $('#tableorder > tbody > tr').each(function() {
                if ($(this).find('td[name="dispath_noteid"]').text() === dispath_noteid) {
                    duplicate = true;
                    return false; // Exit loop
                }
            });

            if (duplicate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'This dispath already added to table',
                });
            } else {
                $('#tableorder > tbody:last').append('<tr class="pointer"><td name="dispatch">DPN000' +
                    dispath_note + '</td><td name="job">' +
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

                // $('#job').val('');
                // $('#job').val(null).trigger('change');
                $('#newqty').val('');
                $('#unitprice').val('');
                $('#dispath_note').val('');
                $('#dispath_note').val(null).trigger('change');
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

                // Hide the dispath_note field after adding its value to the table
                $('#dispath_note').hide();
            }

            finaltotalcalculate();
        }
    });


    //calculate  plate charges

    // $(document).on("keyup", "#platecharges", function (event) {
    // 	var platecharges = parseFloat($("#platecharges").val()); //alert(checkdiscount);
    // 	if (!platecharges == "") {
    // 		finaltotalcalculate();
    // 	} else {

    // 	}

    // });
    //calculate  process charges

    // $(document).on("keyup", "#processcharges", function (event) {
    // 	var processcharges = parseFloat($("#processcharges").val()); //alert(checkdiscount);
    // 	if (!processcharges == "") {
    // 		finaltotalcalculate();
    // 	} else {

    // 	}

    // });
    //calculate  ink charges

    // $(document).on("keyup", "#inkcharges", function (event) {
    // 	var inkcharges = parseFloat($("#inkcharges").val()); //alert(checkdiscount);
    // 	if (!inkcharges == "") {
    // 		finaltotalcalculate();
    // 	} else {

    // 	}

    // });


    //calculate Final Total

    // $(document).on("keyup", "#vat", function (event) {
    // 	var checkvat = parseFloat($("#vat").val()); //alert(checkdiscount);
    // 	if (!checkvat == "") {
    // 		finaltotalcalculate();
    // 	} else {

    // 	}

    // });
    $("#secondformsubmit").click(function() {
        if (!$("#expensesform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#chargesubmitBtn").click();
        } else {
            var chargetypeID = $('#chargetype').val();
            var chargeamount = $('#chargeamount').val();
            var chargetype = $("#chargetype option:selected").text();
            // var dispath_note = $('#dispath_note').val();
            // var dispath_noteid = $('#dispath_noteid')


            $('#chargetableorder > tbody:last').append('<tr class="pointer"><td name="chargetype">' +
                chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
                chargeamount + '</td><td name="chargetypeid" class="d-none">' + chargetypeID +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
            );


            $('#chargetype').val('');
            $('#chargeamount').val('0');
            // $('#dispath_note').prop('readonly', true).css('pointer-events', 'none');
            // $('#customer').next('.select2-container').first().addClass('disabled-pointer-events');


            /////////////////////////////////////////////////Final Total/////////////////////////////////////////////////
            var sum = 0;
            $(".chargesamount").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#divchargestotal').html('<strong style="background-color: yellow;"> Rs. <strong>' +
                showsum);

            // html('<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
            // 		showgrosstot);
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

    $('#btncreateorder').click(function() { //alert('IN');
        // var ordertype = $('#ordertype').val();
        // if (ordertype == 3 || ordertype == 4) {
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
                $("#tableorder tbody tr").each(function() {
                    item = {}
                    $(this).find('td').each(function(col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });

                    jsonObj.push(item);
                });
            }

            if (chargestbody.children().length > 0) {
                $("#chargetableorder tbody tr").each(function() {
                    item = {}
                    $(this).find('td').each(function(col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });

                    charges_jsonObj.push(item);
                });
            }
            console.log("tableorder");
            console.log(jsonObj);
            console.log(charges_jsonObj);
            //alert("click");
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

            // alert(orderdate);
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
                success: function(result) {
                    //alert(result);
                    //console.log(result);
                    var objfirst = JSON.parse(result);
                    if (objfirst.status == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                    action(objfirst.action)
                }
            });
            //}
        }


    });


});

//////////////////////////////////////////////// get Informations  acording to Dispatch Note //////

// $('#dispath_note').change(function () {
// 	var dispatchID = $(this).val();
// 	// get jobs

// 	$.ajax({
// 		type: "POST",
// 		data: {
// 			recordID: dispatchID
// 		},
// 		url: 'Invoice/Getjobsaccodispatch',
// 		success: function (result) {
// 			//alert(result);
// 			var obj = JSON.parse(result);
// 			var html1 = '';
// 			html1 += '<option value="">Select</option>';
// 			$.each(obj, function (i, item) {
// 				html1 += '<option value="' + obj[i]
// 					.idtbl_print_dispatchdetail + '">';
// 				html1 += obj[i].job;
// 				html1 += '</option>';
// 			});
// 			$('#job').empty().append(html1);
// 		}
// 	});

// 	//get Supplier
// 	$.ajax({
// 		type: "POST",
// 		data: {
// 			recordID: dispatchID
// 		},
// 		url: 'Invoice/Getcustomer',
// 		success: function (result) {
// 			//alert(result);
// 			$('#customer').val(result);
// 			console.log(result);
// 			$('#customer').val(result).css('pointer-events', 'none');
// 		}
// 	});

// 	$('#qtylabel').text('0');
// 	$('#newqty').val('0');
// 	$('#comment').val('');

// });

$('#customer').change(function() {
    var customerID = $(this).val();
	var companyID = $('#company_id').val();
	var branchID = $('#branch_id').val();
    // $('#job').empty();
    // $('#job').prepend('<option value="" selected="selected">Select job</option>');
    //$('#job').val(null).trigger('change');
    $('#dispath_note').empty();
    $('#dispath_note').prepend('<option value="" selected="selected">Select Dispath Note</option>');
    //$('#dispath_note').val(null).trigger('change');
    // get jobs

    $.ajax({
        type: "POST",
        data: {
            recordID: customerID,
			companyID: companyID,
			branchID: branchID
        },
        url: 'Invoice/Getjobsaccodispatch',
        success: function(result) {
            //alert(result);
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
//////////////////////////////////////////// Get Dispatch No according to Job ///////////////////////////////////////////////

$('#job').change(function() {
    var jobID = $(this).val();
    $('#dispath_note').val('').trigger('change');
    // $('#dispath_note').prepend('<option value="" selected="selected">Select Dispatch No</option>');
    // $('#porder').val(null).trigger('change');
    //alert(jobID);
    $.ajax({
        type: "POST",
        data: {
            recordID: jobID
        },
        url: 'Invoice/Getdispatchaccjob',
        success: function(result) {
            // alert(result);
            var obj = JSON.parse(result);
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $.each(obj, function(i, item) {
                html1 += '<option value="' + obj[i]
                    .tbl_print_dispatch_idtbl_print_dispatch + '">' +
                    'DPN000' + obj[i].tbl_print_dispatch_idtbl_print_dispatch + '</option>';
                html1 += obj[i].tbl_print_dispatch_idtbl_print_dispatch;
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
    // var dispatchID = $('#dispath_note').val();
    //console.log(jobID);
    //alert(jobID);

    $.ajax({
        type: "POST",
        data: {
            recordID: dispatchID
            // inqury_id: dispatchID
        },
        url: 'Invoice/Getqtyaccdispatch',
        success: function(result) {
            //alert(result);
            console.log(result);
            var obj = JSON.parse(result);
            console.log(obj.dispath_note);

            $('#newqty').val(obj.qty);
            $('#unitprice').val(obj.unitprice);
            $('#job_no').val(obj.job_no);
            $('#uom').val(obj.uom);
            // $('#dispath_note').val("DPN000" + (obj.dispath_note));
            $('#dispath_noteid').val(obj.dispath_note);
            // $('#dispath_note').empty().append(html1);
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

    if (isNaN(discount)) {
        discount = 0;
        $("#discount").val(0);
    }

    if (isNaN(vat)) {
        vat = 0;
        $("#vat").val(0);
    }

    // subtotal calculation
    var finalsubtot = (total + chargestotal) - discount
    $('#hiddenfulltotal').val(finalsubtot.toFixed(2))

    // vat calculaton
    var vatamount = parseFloat((finalsubtot / 100) * vat);
    $('#vatamount').val(vatamount.toFixed(2))
    var finaltotal = finalsubtot + vatamount

    $('#modeltotalpayment').val(finaltotal.toFixed(2));
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
    // Set input fields as readonly by default
    // $('input[type="number"]').prop('readonly', true);

    // Toggle readonly state based on checkbox status
    $('input[type="checkbox"]').change(function() {
        var isChecked = $(this).prop('checked');
        // $(this).closest('.col-3').find('input[type="number"]').prop('disabled', !isChecked);
        var inputField = $(this).closest('.col-3').find('input[type="number"]');
        inputField.prop('disabled', !isChecked);
        if (!isChecked) {
            inputField.val(0); // Set value to 0 if checkbox is unchecked
        }
        finaltotalcalculate();
    });
});
</script>

<!-- <script>
	function getVat() {
		var currentDate = $('#date').val();
		//alert(currentDate);

		$.ajax({
			type: "POST",
			data: {
				currentDate: currentDate,
			},
			url: 'Invoice/Getprocescharges',
			success: function (result) { //alert(result);
				var obj = JSON.parse(result);


				$('#processcharges').val(obj.Process_Charges_Price);
				$('#platecharges').val(obj.Plate_Charges_Price);
				$('#inkcharges').val(obj.Ink_Charges_Price);
			}
		});
	}

</script> -->


<?php include "include/footer.php"; ?>