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
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Good Receive Note Voucher</span>
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
                        <div class="container-fluid mt-2 p-0 p-2">
                            <div class="card">
                                <div class="card-body p-0 p-2">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <form id="createorderform" autocomplete="off">
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Date*</label>
                                                        <input type="date" class="form-control form-control-sm"
                                                            placeholder="" name="date" id="date" onchange="getVat();"
                                                            value="<?php echo date('Y-m-d') ?>" required>

                                                    </div>

                                                    <div class="col">
                                                        <label
                                                            class="small font-weight-bold text-dark">Supplier*</label>
                                                        <select class="form-control form-control-sm  px-0"
                                                            name="supplier" id="supplier" required>
                                                            <option value="">Select</option>
                                                            <?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
                                                            <option
                                                                value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
                                                                <?php echo $rowsupplierlist->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">GRN No.</label>
                                                        <select class="form-control form-control-sm selecter2 px-0"
                                                            name="grnno" id="grnno" required>
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <input type="hidden" id="inquerydetailsid" name="inquerydetailsid"
                                                    class="form-control form-control-sm" />

                                                <div class="form-group mt-2 text-right">
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
                                                                <th>Product</th>
                                                                <th>Comment</th>
                                                                <th class="d-none">ProductID</th>
                                                                <th>Unitprice</th>
                                                                <th class="d-none">Saleprice</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">Uom</th>
                                                                <th class="d-none">HideTotal</th>
                                                                <th class="text-right">Discount</th>
                                                                <th class="text-right">Total</th>
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
                                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5  ml-5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form id="expensesform" autocomplete="off">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label class="small font-weight-bold text-dark">Cost
                                                                        Type
                                                                    </label>
                                                                    <select class="form-control form-control-sm"
                                                                        name="costtype" id="costtype" required>
                                                                        <option value="">Select Cost Type</option>
                                                                        <?php foreach($costlist->result() as $rowcostlist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowcostlist->idtbl_import_cost_types ?>">
                                                                            <?php echo $rowcostlist->cost_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-4">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Amount
                                                                    </label>
                                                                    <input type="number" step="any" name="costamount"
                                                                        class="form-control form-control-sm"
                                                                        id="costamount" required>
                                                                </div>
                                                                <div class="col-1">
                                                                </div>
                                                                <div class="form-group mt-3  md-8 sm-12 text-right">
                                                                    <button style="position: absolute;bottom:0"
                                                                        type="button" id="secondformsubmit"
                                                                        class="btn btn-secondary btn-sm px-6"
                                                                        <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                                            class="fas fa-plus"></i>&nbsp;Add
                                                                        Costing</button>
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
                                                                        <th>Cost Type</th>
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

                                <div class="card-body p-0 p-2">
                                    <div class="container-fluid mt-2 p-0 p-2">
                                        <div class="form-group col-4">
                                            <label class="small font-weight-bold text-dark">Remark</label>
                                            <textarea name="remark" id="remark"
                                                class="form-control form-control-sm"></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mt-2">
                                                    <button type="button" id="btncreateorder"
                                                        class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                                            class="fas fa-save"></i>&nbsp;Create GRN Voucher</button>
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
                                                                <th>#</th>
                                                                <th>GRN No</th>
                                                                <th>GRN Voucher Date</th>
                                                                <th>Supplier</th>
                                                                <th>Total</th>
                                                                <th>GRN Total After Add Costs</th>
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

<div class="modal fade" id="viewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Good Recieve Note Voucher</h5>
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
                            class="text-right" class="text-right">Good Recieve Note Voucher<span id="pr"></span>
                        </h2>
                        <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                            class="text-right" class="text-right">Multi Offset Printers (PVT) LTD <span
                                id="proname"></span>
                        </p>
                        <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                            class="text-right" class="text-right">MO/GRNV-0000<span id="grncode"></span>
                        </P>
                        <p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
                            class="text-right" class="text-right"><span id="porderdate"></span></p>
                    </div>
                </div>


                <div id="viewvoucher"></div>

            </div>
            <div class="modal-footer">
                <button type="button" id="printgrn" class="btn btn-outline-primary btn-sm fa-pull-right"
                    <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Print GRN
                    Voucher</button>
            </div>
        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>


<script>
$(document).ready(function() {
    $('#supplier').select2({
        width: '100%',
    });
    $('#grnno').select2({
        width: '100%',
    });

    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';


    $('#printgrn').click(function() {
        printJS({
            printable: 'GRNView',
            type: 'html',
            css: 'assets/css/styles.css'
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
            url: "<?php echo base_url() ?>scripts/grnvoucherlist.php",
            type: "POST", // you can use GET
            // data: function(d) {}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_grn_vouchar_import_cost"
            },
            {
                "data": function(row) {
                    return "MO/GRN-0000" + row.tbl_print_grn_idtbl_print_grn;
                }
            },
            {
                "data": "date"
            },
            {
                "data": "name"
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
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return addCommas(parseFloat(full['grntotal']).toFixed(2));
                }
            },
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
                            'idtbl_grn_vouchar_import_cost'] +
                        '"><i class="fas fa-eye"></i></button>';
                    if (full['approvestatus'] == 1) {
                        button += '<button class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></button>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>GRNVoucher/Goodreceivevoucherstatus/' +
                            full['idtbl_grn_vouchar_import_cost'] + '/1/' + full[
                                'tbl_print_porder_idtbl_print_porder'] +
                            '" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    if (full['approvestatus'] == 0) {
                        button +=
                            '<a href="<?php echo base_url() ?>GRNVoucher/Goodreceivevoucherstatus/' +
                            full['idtbl_grn_vouchar_import_cost'] +
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

    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#grncode').html(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>GRNVoucher/Goodreceivevoucherview',
            success: function(result) { //alert(result);
                $('#viewmodal').modal('show');
                $('#viewvoucher').html(result);
            }
        });
    });


    $('#supplier').change(function() {
        var supplierID = $(this).val();
        $('#grnno').empty();
        $('#grnno').prepend('<option value="" selected="selected">Select GRN</option>');

        $.ajax({
            type: "POST",
            data: {
                recordID: supplierID
            },
            url: 'GRNVoucher/Getgrnaccsupllier',
            success: function(result) {
                alert(result);
                var obj = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function(i, item) {
                    html1 += '<option value="' + obj[i].idtbl_print_grn + '">' +
                        'MO/GRN-0000' + obj[i].idtbl_print_grn + '</option>';
                    html1 += obj[i].idtbl_print_grn;
                    html1 += '</option>';
                });
                $('#grnno').empty().append(html1);
            }
        });

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
    var grnTotal = 0;
    var totalCosts = 0;

    $('#grnno').change(function() {
        var grnno = $(this).val();
        if (grnno !== '') {
            $.ajax({
                url: 'GRNVoucher/get_grn_details',
                type: 'POST',
                data: {
                    grnno: grnno
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        var tbody = $('#tableorder tbody');
                        tbody.empty();
                        grnTotal = 0; // Reset GRN total

                        $.each(response.data, function(index, grn) {
                            var row = '<tr>' +
                                '<td>' + grn.materialname + '</td>' +
                                '<td>' + grn.comment + '</td>' +
                                '<td class="d-none">' + grn
                                .idtbl_print_material_info + '</td>' +
                                '<td class="unitprice">' + grn.unitprice + '</td>' +
                                '<td class="d-none">' + grn.saleprice + '</td>' +
                                '<td class="text-center qty">' + grn.qty + '</td>' +
                                '<td class="text-center">' + grn.measure_type +
                                '</td>' +
                                '<td class="d-none">' + grn.hidetotal + '</td>' +
                                '<td class="text-right">' + grn.unit_discount +
                                '</td>' +
                                '<td class="text-right total">' + grn.total +
                                '</td>' +
                                '</tr>';
                            tbody.append(row);
                            grnTotal += parseFloat(grn.total);
                        });

                        // Update the total in the hidden field and the h4 element
                        $('#hidetotalorder').val(grnTotal.toFixed(2));
                        $('#divtotal').text('Rs. ' + addCommas(grnTotal.toFixed(2)));
                    } else {
                        alert('No data found for the selected GRN');
                    }
                }
            });
        }
    });

    $("#secondformsubmit").click(function() {
        if (!$("#expensesform")[0].checkValidity()) {
            $("#chargesubmitBtn").click();
        } else {
            var chargetypeID = $('#costtype').val();
            var chargeamount = parseFloat($('#costamount').val());
            var chargetype = $("#costtype option:selected").text();

            $('#chargetableorder > tbody:last').append('<tr class="pointer"><td name="chargetype">' +
                chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
                chargeamount.toFixed(2) + '</td><td name="chargetypeid" class="d-none">' +
                chargetypeID +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
            );

            $('#costtype').val('');
            $('#costamount').val('');

            // Update the total costs
            totalCosts += chargeamount;

            var showsum = addCommas(totalCosts.toFixed(2));
            $('#divchargestotal').html('<strong style="background-color: yellow;"> Rs. <strong>' +
                showsum);
            $('#hidechargestotal').val(totalCosts.toFixed(2));

            // Update the final total including the new cost
            updateFinalTotal(chargeamount);
        }
    });

    $("#btncreateorder").click(function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        var grnDetails = [];
        var costDetails = [];

        $('#tableorder tbody tr').each(function() {
            var row = $(this);
            var grnDetail = {
                materialname: row.find('td:eq(0)').text(),
                comment: row.find('td:eq(1)').text(),
                idtbl_print_material_info: row.find('td:eq(2)').text(),
                unitprice: parseFloat(row.find('td:eq(3)').text()),
                saleprice: row.find('td:eq(4)').text(),
                qty: parseFloat(row.find('td:eq(5)').text()),
                measure_type: row.find('td:eq(6)').text(),
                hidetotal: row.find('td:eq(7)').text(),
                unit_discount: parseFloat(row.find('td:eq(8)').text()),
                total: parseFloat(row.find('td:eq(9)').text())
            };
            grnDetails.push(grnDetail);
        });

        $('#chargetableorder tbody tr').each(function() {
            var row = $(this);
            var costDetail = {
                chargetype: row.find('td[name="chargetype"]').text(),
                chargeamount: parseFloat(row.find('td[name="chargeamount"]').text()),
                chargetypeid: row.find('td[name="chargetypeid"]').text()
            };
            costDetails.push(costDetail);
        });

        $.ajax({
            url: 'GRNVoucher/Insertgrnvoucher',
            type: 'POST',
            data: {
                grnDetails: grnDetails,
                costDetails: costDetails,
                totalGRN: $('#hidetotalorder').val(),
                totalCost: $('#hidechargestotal').val(),
                date: $('#date').val(),
                grnno: $('#grnno').val(),
                remark: $('#remark').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    // Reload the page after a successful insertion
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
                action(response.action);
            },
            error: function() {
                console.error('Error while saving GRN and cost details.');
            }
        });
    });


    function updateFinalTotal(chargeamount) {
        // Retrieve the current GRN total
        var grnTotalVal = parseFloat($('#hidetotalorder').val());
        // Add the new charge amount to the current GRN total
        var finalTotal = grnTotalVal + chargeamount;
        $('#divtotal').text('Rs. ' + addCommas(finalTotal.toFixed(2)));
        $('#hidetotalorder').val(finalTotal.toFixed(2));

        // Calculate the cost per unit
        var totalQty = 0;
        $('#tableorder tbody tr').each(function() {
            totalQty += parseFloat($(this).find('.qty').text());
        });

        var costPerUnit = chargeamount / totalQty;

        // Update each row's unit price and total
        $('#tableorder tbody tr').each(function() {
            var unitPrice = parseFloat($(this).find('.unitprice').text());
            var qty = parseFloat($(this).find('.qty').text());
            var newUnitPrice = unitPrice + costPerUnit;
            var newTotal = newUnitPrice * qty;
            $(this).find('.unitprice').text(newUnitPrice.toFixed(2));
            $(this).find('.total').text(newTotal.toFixed(2));
        });
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    // Function to delete a product row
    window.productDelete = function(button) {
        var row = $(button).closest('tr');
        var chargeamount = parseFloat(row.find('td[name="chargeamount"]').text());
        totalCosts -= chargeamount;
        row.remove();
        var showsum = addCommas(totalCosts.toFixed(2));
        $('#divchargestotal').html('<strong style="background-color: yellow;"> Rs. <strong>' + showsum);
        $('#hidechargestotal').val(totalCosts.toFixed(2));
        updateFinalTotal(-chargeamount);
    };
});
</script>


<?php include "include/footer.php"; ?>