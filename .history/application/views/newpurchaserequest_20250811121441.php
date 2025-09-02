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
                            <div class="page-header-icon"><i class="fa fa-shopping-cart"></i></div>
                            <span>New Purchase Order Request</span>   
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
            	<div class="card">
            		<div class="card-body p-0 p-3">
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

            						<div class="form-row mb-1">
            							<div class="col">
            								<label class="small font-weight-bold text-dark">Purchase Order
            									Type*</label>
            								<select class="form-control form-control-sm" name="ordertype" id="ordertype"
            									required>
            									<option value="">Select</option>
            									<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
            									<option value="<?php echo $rowordertypelist->idtbl_order_type ?>">
            										<?php echo $rowordertypelist->type ?></option>
            									<?php } ?>
            								</select>
            							</div>
            							<div class="col">
            								<label class="small font-weight-bold text-dark">Request
            									Date</label>
            								<input type="date" class="form-control form-control-sm" placeholder=""
            									name="date" id="date" value="<?php echo date('Y-m-d')?>">
            							</div>

            						</div>
            						<div id="productFields">
            							<div class="form-group mb-1">
            								<label class="small font-weight-bold text-dark">Spare
            									Part/Service/Material/Machine*</label>
            								<input class="form-control form-control-sm" list="materials" name="product"
            									id="product">
            								<datalist id="materials">
            								</datalist>
            							</div>
            						</div>
            						<div id="qtyFields">
            							<div class="form-row mb-1">
            								<div class="col">
            									<label class="small font-weight-bold text-dark">Qty*</label>
            									<span class="text-danger font-weight-bold" id="stockqty"></span>
            									<input type="text" id="newqty" name="newqty"
            										class="form-control form-control-sm" required>
            								</div>
            								<div class="col">
            									<label class="small font-weight-bold text-dark">UOM*</label>
            									<select class="form-control form-control-sm" name="uom" id="uom"
            										required>
            										<option value="">Select</option>
            										<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
            										<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
            											<?php echo $rowmeasurelist->measure_type ?></option>
            										<?php } ?>
            									</select>
            								</div>
            							</div>
            						</div>

            						<div class="form-group mt-3 text-right">
            							<button type="button" id="formsubmit" class="btn btn-warning btn-sm font-weight-bold px-4"
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
            						<table class="table table-striped table-bordered table-sm small" id="tableorder">
            							<thead>
            								<tr>
            									<th>Product</th>
            									<th class="text-center">Qty</th>
            									<th class="text-center">UOM</th>
            									<th class="text-right">Action</th>
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
            									<th>Service Type</th>
            									<th class="text-center">Qty</th>
            									<th class="text-center">UOM</th>
            									<th class="text-right">Action</th>
            								</tr>
            							</thead>
            							<tbody></tbody>
            						</table>
            					</div>


            					<hr>
            					<div class="form-group mt-2">
            						<button type="button" id="btncreateorder"
            							class="btn btn-primary btn-sm fa-pull-right"><i
            								class="fas fa-save"></i>&nbsp;Create
            							Order</button>
            					</div>
            				</div>
            			</div>
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
            										<th>P-Order Req Number</th>
            										<th>Date</th>
            										<th>Order Type</th>
            										<th>Confirm Status</th>
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

#approve:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    background-color: #4CAF50;
    color: #fff;
}
</style>
<!-- Modal -->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-left">Purchase Order Request<span id="pr"></span></h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left" class="text-left"><span
                                    id="viewcompanyname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left" class="text-left"> <span
                                    id="viewbranchname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
                                class="text-left"><span id="porder_number"></span></p>
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
                    <div class="col-12 text-right">
                        <hr>
                        <?php if($approvecheck==1){ ?>
                        <button id="btnapprovereject" class="btn btn-primary btn-sm px-3 mb-2"><i class="fas fa-check mr-2"></i>Approve or Reject</button>
                        <?php } ?>
                        <input type="hidden" name="requestid" id="requestid">
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
        $('#company_id').change(function() {
            var company_id = $(this).val();
            if (company_id != '') {
                $.ajax({
                    url: '<?php echo base_url('Customerinquiry/Getcompanybranch'); ?>',
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
    $('#supplierFields').hide();
    $('#productFields').hide();
    $('#qtyFields').hide();
    $('#servisetypeFields').hide();
    $('#vehicletblpart').hide();
    $('#materialmachinetblpart').hide();

    $('#ordertype').change(function() {
        let ordertype = $(this).val();

        if (ordertype == 2) {
            $('#supplierFields').hide();
            $('#productFields').show();
            $('#qtyFields').show();            
            $('#supplier').removeAttr('required');
            $('#product').removeAttr('required');

            $('#servicetype').attr('required', 'required');

            $('#unitprice').val('0');
            
            $('#vehicletblpart').show();
            $('#materialmachinetblpart').hide();
        } else { 
            $('#supplierFields').show();
            $('#productFields').show();
            $('#qtyFields').show();
            $('#servisetypeFields').hide();

            $('#supplier').attr('required', 'required');
            $('#product').attr('required', 'required');

            $('#servicetype').removeAttr('required');
            
            $('#vehicletblpart').hide();
            $('#materialmachinetblpart').show();
        }
    });
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

    $('#product').on('input', function() {
        let query = $(this).val();

        if (query.length >= 2) { 
            $.ajax({
                type: "POST",
                url: 'Newpurchaserequest/GetMaterials',
                data: { query: query },
                success: function(result) {
                    let options = '';
                    let materials = JSON.parse(result);

                    materials.forEach(function(material) {
                        let safeValue = material.materialname.replace(/"/g, '&quot;');
                        options += `<option value="${safeValue}">`;
                    });

                    $('#materials').html(options);
                }
            });
        }
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
                "data": "porder_req_no"
            },
            {
                "data": "date"
            },
            {
                "data": "type"
            },
            {
                "targets": -1,
                "className": '',
                "data": "confirmstatus_display",
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
                        '<a href="<?php echo base_url() ?>Newpurchaserequest/Printinvoice/' +
                        full['idtbl_print_porder_req'] +
                        '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print Request" class="btn btn-secondary btn-sm mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-file-pdf mr-2"></i></a>';

                    button += '<button data-toggle="tooltip" data-placement="bottom" title="View Request" class="btn btn-dark btn-sm btnview mr-1" id="' + full[
                            'idtbl_print_porder_req'] + '" aproval_id="' + full[
                            'confirmstatus'] + '" check_status="' + full[
                            'check_by'] + '"><i class="fas fa-eye"></i></button>';
                        
                    if (full['porderconfirm'] == 1) {
                        button += '<button data-toggle="tooltip" data-placement="bottom" title="Active" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></button>';
                    } else {
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
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
        var approvestatus = $(this).attr('aproval_id');
        var checkstatus = $(this).attr('check_status');

        $('#requestid').val(id);

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Newpurchaserequest/Purchaseorderview',
            success: function(result) { //alert(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);

                if (approvestatus > 0) {
                	$('#btnapprovereject').addClass('d-none').prop('disabled', true);
                	if (approvestatus == 1) {
                		$('#alertdiv').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle mr-2"></i> Request approved</div>');
                	} else if (approvestatus == 2) {
                		$('#alertdiv').html('<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle mr-2"></i> Request rejected</div>');
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
                    if(checkstatus==1){$('#checkalertdiv').html('<div class="alert alert-secondary" role="alert"><i class="fas fa-check-circle mr-2"></i> Request checked</div>');}
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
            url: '<?php echo base_url() ?>Newpurchaserequest/porderviewheader',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);

                $('#pordersuppliername').text(obj.suppliername);
                $('#pordersuppliercontact').text(obj.suppliercontact);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);
                $('#porder_number').text(obj.porder_no);

                $('#viewcompanyname').text(obj.companyname);
                $('#viewbranchname').text(obj.branchname);
            }
        });
    });

    $('#btnapprovereject').click(function(){
        Swal.fire({
            title: "Do you want to approve this Request?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Approve",
            denyButtonText: `Reject`
        }).then((result) => {
            if (result.isConfirmed) {
                var confirmnot = 1;
                approvejob(confirmnot);
            } else if (result.isDenied) {
                var confirmnot = 2;
                approvejob(confirmnot);
            } 
        });
    });

        $('#btncheck').click(function(){
        Swal.fire({
            title: "Do you want to check this Request?",
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

    $('#newqty').on('input', function() {
        $('#uom').trigger('change');
    });

    $('#product').change(function() {
        let productID = $(this).val();
        var ordertype = $('#ordertype').val();
        var companyID = $('#f_company_id').val();
        var branchID = $('#f_branch_id').val();

        if (ordertype == 3) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: productID,
                    companyID: companyID,
                    branchID: branchID
                },
                url: 'Newpurchaserequest/Getstockqty',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#stockqty').html(obj.qty);
                }
            });
        }
    });


    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.F
            $("#submitBtn").click();
        } else {
            var ordertype = $('#ordertype').val();
            if (ordertype == 1 || ordertype == 3 || ordertype == 4) {

                var product = $('#product').val();
                var newqty = parseFloat($('#newqty').val());
                var uomID = $('#uom').val();
                var uom = $("#uom option:selected").text();

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product +
                    '</td><td class="text-center">' +
                    newqty + '</td> <td class="text-center">' +
                    uom + '</td><td class="d-none">' + uomID +
                    '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
                );

                $('#product').val('');
                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#comment').val('');
                $('#newqty').val('0');
                $('#uom').val('');

                $('#product').focus();
            }else {
                var product = $('#product').val();
                var newqty = parseFloat($('#newqty').val());
                var uomID = $('#uom').val();
                var uom = $("#uom option:selected").text();


                $('#vehicletableorder > tbody:last').append('<tr class="pointer"><td>' +
                    product + '</td><td class="text-center">' + newqty +
                    '</td><td class="text-center">' +
                    uom + '</td> <td class="d-none">' + uomID +
                    '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
                );

                $('#servicetype').val('');
                $('#newqty').val('0');
                $('#uom').val('');

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
    $("#btncreateorder").click(function () {
    	var ordertype = $("#ordertype").val();
    	var tbodySelector = ordertype == 2 ? "#vehicletableorder tbody" : "#tableorder tbody";
    	var tbody = $(tbodySelector);

    	if (tbody.children().length === 0) {
    		Swal.fire({
    			icon: "warning",
    			title: "No Data",
    			text: "Please add items before creating an order.",
    		});
    		return;
    	}

    	$("#btncreateorder").prop("disabled", true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Creating Order');

    	var jsonObj = [];
    	$(tbodySelector + " tr").each(function () {
    		var item = {};
    		$(this).find("td").each(function (col_idx) {
    			item["col_" + (col_idx + 1)] = $(this).text();
    		});
    		jsonObj.push(item);
    	});

    	var requestData = {
    		ordertype: ordertype,
    		tableData: jsonObj,
    		company_id: $("#f_company_id").val(),
    		branch_id: $("#f_branch_id").val(),
    		date: $("#date").val(),
    		recordOption: $("#recordOption").val(),
    		servicetype: ordertype == 2 ? $("#servicetype").val() : undefined,
    	};

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
    				url: "Newpurchaserequest/Newpurchaserequestinsertupdate",
    				data: requestData,
    				success: function (result) {
    					Swal.close();
    					document.body.style.overflow = "auto";

    					var response = JSON.parse(result);
    					if (response.status == 1) {
    						actionreload(response.action);
    						setTimeout(() => window.location.reload(), 2000);
    					} else {
    						action(response.action);
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
    				},
    			});
    		},
    	});
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
    return confirm("Are you sure you want to remove this?");
}

function check_confirm() {
    return confirm("Are you sure you want to check this?");
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

function action(data) {
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

function approvejob(confirmnot){
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
                    requestid: $('#requestid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>Newpurchaserequest/Newpurchaserequeststatus',
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
                    requestid: $('#requestid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>Newpurchaserequest/Newpurchaserequestcheckstatus',
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