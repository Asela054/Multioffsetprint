<?php

if ($check === 1) { // Customer
    echo '<div class="page-header page-header-light bg-light shadow">
    <div class="container-fluid">
        <div class="page-header-content py-1">
            <h1 class="page-header-title font-weight-light">
                <span class="text-dark">Customer Delete Details</span>
            </h1>
        </div>
    </div>
</div>
    <input type="hidden" name="recordOptionCustomer" id="recordOptionCustomer" value="1">
    <input type="hidden" name="recordIDCustomer" id="recordIDCustomer" value="">
<div class="container-fluid mt-2 p-0 p-2">
    <div class="card">
        <div class="card-body p-0 p-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableCustomer">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>NIC</th>
                                        <th>Bussines Reg No</th>
                                        <th>NBT No</th>
                                        <th>SVAT No</th>
                                        <th>Contact No</th>
                                        <th>Fax No</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

} else if ($check === 2) {  // Supplier
    echo '<div class="page-header page-header-light bg-light shadow">
    <div class="container-fluid">
        <div class="page-header-content py-1">
            <h1 class="page-header-title font-weight-light">
                <span class="text-dark">Supplier Delete Details</span>
            </h1>
        </div>
    </div>
</div>
    <input type="hidden" name="recordOptionSupplier" id="recordOptionSupplier" value="1">
    <input type="hidden" name="recordIDSupplier" id="recordIDSupplier" value="">
<div class="container-fluid mt-2 p-0 p-2">
    <div class="card">
        <div class="card-body p-0 p-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableSupplier">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Bussines Reg No</th>
                                        <th>NBT No</th>
                                        <th>SVAT No</th>
                                        <th>Contact No</th>
                                        <th>Fax No</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

} else if ($check === 3) {  // GRN
    echo '<div class="page-header page-header-light bg-light shadow">
    <div class="container-fluid">
        <div class="page-header-content py-1">
            <h1 class="page-header-title font-weight-light">
                <span class="text-dark">Good Receive Note Delete Details</span>
            </h1>
        </div>
    </div>
</div>
    <input type="hidden" name="recordOption" id="recordOption" value="1">
    <input type="hidden" name="recordID" id="recordID" value="">
<div class="container-fluid mt-2 p-0 p-2">
    <div class="card">
        <div class="card-body p-0 p-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableGRN">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>GRN Date</th>
                                        <th>GRN Type</th>
                                        <th>Batch Number</th>
                                        <th>Supplier</th>
                                        <th>Approve Status</th>
                                        <th>Invoice Number</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th colspan="6" class="text-right"></th>
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
</div>';

} else if ($check === 4) {  // PO
    echo '<div class="page-header page-header-light bg-light shadow">
    <div class="container-fluid">
        <div class="page-header-content py-1">
            <h1 class="page-header-title font-weight-light">
                <span>Purchase Order Delete Details</span>
            </h1>
        </div>
    </div>
</div>
    <input type="hidden" name="recordOption" id="recordOption" value="1">
    <input type="hidden" name="recordID" id="recordID" value="">
<div class="container-fluid mt-2 p-0 p-2">
    <div class="card">
        <div class="card-body p-0 p-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTablePO">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Due Date</th>
                                        <th>Order Type</th>
                                        <th>Supplier</th>
                                        <th>Approve Status</th>
                                        <th>GRN Issue Status</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th colspan="6" class="text-right"></th>
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
</div>';    
}
else {
    echo 'Page Not Found';
}

?>
<script>

var checkValue = <?php echo json_encode($check); ?>;

$(document).ready(function () {

    // Table Customer
    var dataTableCustomer = $('#dataTableCustomer').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: "<?php echo base_url() ?>scripts/deletelist.php",
            type: "POST",
            "data": function (d) {
                d.type = 1;
            }
        },
        "order": [[0, "desc"]],
        "columns": [
            { "data": "idtbl_customer" },
            { "data": "customer" },
            { "data": "nic" },
            { "data": "bus_reg_no" },
            { "data": "nbt_no" },
            { "data": "svat_no" },
            { "data": "telephone_no" },
            { "data": "fax_no" }
        ],
        dom: 'Bfrtip',
        dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All'],
        ],
        buttons: [{
                extend: 'pdf',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                title: 'Customer Delete Item Report',
                filename: 'Customer Delete Item Report ',
                footer: true,
                messageTop: {
                    text: 'Customer Delete Item Report',
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
                filename: 'Customer Delete Item Report ',
                text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                footer: true,
                title: 'MULTI OFFSET PRINTERS Customer Delete Report - By Erav Technology'
            },
            {
                extend: 'csv',
                className: 'btn btn-info btn-sm',
                filename: 'Customer Delete Item Report ',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                footer: true
            },
            {
                extend: 'print',
                className: 'btn btn-warning btn-sm',
                text: '<i class="fas fa-print mr-2"></i> PRINT',
                title: 'Customer Delete Item Report',
                filename: 'Customer Delete Item Report ',
                footer: true,
                messageTop: 'Customer Delete Item Report ',
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
    //_________________________________________________________________

    // Supplier Table
    $('#dataTableSupplier').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: "<?php echo base_url() ?>scripts/deletelist.php",
            type: "POST",
            "data": function (d) {
                d.type = 2;
            }
        },
        "order": [[0, "desc"]],
        "columns": [
            { "data": "idtbl_supplier" },
            { "data": "suppliername" },
            { "data": "bus_reg_no" },
            { "data": "nbt_no" },
            { "data": "svat_no" },
            { "data": "telephone_no" },
            { "data": "fax_no" }
        ],
        dom: 'Bfrtip',
        dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All'],
        ],
        buttons: [{
                extend: 'pdf',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                title: 'Supplier Delete Item Report',
                filename: 'Supplier Delete Item Report ',
                footer: true,
                messageTop: {
                    text: 'Supplier Delete Item Report',
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
                filename: 'Supplier Delete Item Report ',
                text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                footer: true,
                title: 'MULTI OFFSET PRINTERS Supplier Delete Report - By Erav Technology'
            },
            {
                extend: 'csv',
                className: 'btn btn-info btn-sm',
                filename: 'Supplier Delete Item Report ',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                footer: true
            },
            {
                extend: 'print',
                className: 'btn btn-warning btn-sm',
                text: '<i class="fas fa-print mr-2"></i> PRINT',
                title: 'Supplier Delete Item Report',
                filename: 'Supplier Delete Item Report ',
                footer: true,
                messageTop: 'Supplier Delete Item Report ',
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
    //_________________________________________________________________

    // GRN Table
    $('#dataTableGRN').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: "<?php echo base_url() ?>scripts/deletelist.php",
            type: "POST",
            "data": function (d) {
                d.type = 3;
            }
        },
        "order": [[0, "desc"]],
        "columns": [
            { "data": "idtbl_print_grn" },
            { "data": "grndate" },
            {
                "data": null,
                "render": function(data, type, row) {
                    if (data.grntype == 1) {
                        return 'Normel GRN'; 
                    } else {
                        return 'Direct GRN';
                    }
                }
            },
            { "data": "batchno" },
            { "data": "name" },
            { "data": "approvestatus",
              "className": "text-center"
            },
            { "data": "invoicenum" },
            {
                "data": "total",
                "className": "text-right",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return Number(data).toLocaleString();
                    }
                    return data;
                }
            }
        ],
        "columnDefs": [
            {
                "targets": [5],
                "render": function(data, type, row) {
                    return data == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
                }
            }
        ],
        dom: 'Bfrtip',
        dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All'],
        ],
        buttons: [{
                extend: 'pdf',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                title: 'GRN Delete Item Report',
                filename: 'GRN Delete Item Report ',
                footer: true,
                messageTop: {
                    text: 'GRN Delete Item Report',
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
                filename: 'GRN Delete Item Report ',
                text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                footer: true,
                title: 'MULTI OFFSET PRINTERS GRN Delete Report - By Erav Technology'
            },
            {
                extend: 'csv',
                className: 'btn btn-info btn-sm',
                filename: 'GRN Delete Item Report ',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                footer: true
            },
            {
                extend: 'print',
                className: 'btn btn-warning btn-sm',
                text: '<i class="fas fa-print mr-2"></i> PRINT',
                title: 'GRN Delete Item Report',
                filename: 'GRN Delete Item Report ',
                footer: true,
                messageTop: 'GRN Delete Item Report ',
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

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            var totalColumn3 = api
                .column(7)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var pageTotalColumn3 = api
                .column(7, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(intVal(a) + intVal(b)).toFixed(2);
                }, 0);

            var formattedPageTotalColumn3 = parseFloat(pageTotalColumn3).toLocaleString(); 

            $(api.column(7).footer()).html('Rs. ' + formattedPageTotalColumn3); 
        },
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }

    });
    //_________________________________________________________________

     // PO Table
    $('#dataTablePO').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: "<?php echo base_url() ?>scripts/deletelist.php",
            type: "POST",
            "data": function (d) {
                d.type = 4;
            }
        },
        "order": [[0, "desc"]],
        "columns": [
            { "data": "idtbl_print_porder" },
            { "data": "orderdate" },
            { "data": "duedate" },
            { "data": "type" },
            { "data": "name" },
            { "data": "confirmstatus",
              "className": "text-center"
            },
            { "data": "grnconfirm",
              "className": "text-center"
            },
            {
                "data": "nettotal",
                "className": "text-right",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return Number(data).toLocaleString();
                    }
                    return data;
                }
            }
        ],
        "columnDefs": [
            {
                "targets": [5, 6],
                "render": function(data, type, row) {
                    return data == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
                }
            }
        ],
        dom: 'Bfrtip',
        dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All'],
        ],
        buttons: [{
                extend: 'pdf',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                title: 'Purchase Order Delete Item Report',
                filename: 'Purchase Order Delete Item Report ',
                footer: true,
                messageTop: {
                    text: 'Purchase Order Delete Item Report',
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
                filename: 'Purchase Order Delete Item Report ',
                text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                footer: true,
                title: 'MULTI OFFSET PRINTERS Purchase Order Delete Report - By Erav Technology'
            },
            {
                extend: 'csv',
                className: 'btn btn-info btn-sm',
                filename: 'Purchase Order Delete Item Report ',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                footer: true
            },
            {
                extend: 'print',
                className: 'btn btn-warning btn-sm',
                text: '<i class="fas fa-print mr-2"></i> PRINT',
                title: 'Purchase Order Delete Item Report',
                filename: 'Purchase Order Delete Item Report ',
                footer: true,
                messageTop: 'Purchase Order Delete Item Report ',
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

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            var pageTotalColumn3 = api
                .column(7, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(intVal(a) + intVal(b)).toFixed(2);
                }, 0);

            var formattedPageTotalColumn3 = parseFloat(pageTotalColumn3).toLocaleString();

            $(api.column(7).footer()).html('Rs. ' + formattedPageTotalColumn3);
        },
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }

    });
    //_________________________________________________________________

});

</script>
