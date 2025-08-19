<?php include "include/header.php"; ?>

<?php

if ($check === 1) { // Customer
    echo '<div class="page-header page-header-light bg-gray shadow">
            <div class="container-fluid">
                <div class="page-header-content py-1">
                    <h1 class="page-header-title font-weight-light">
                        <span>Customer Delete Details</span>
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
                                        <thead>
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
    echo '<div class="page-header page-header-light bg-gray shadow">
            <div class="container-fluid">
                <div class="page-header-content py-1">
                    <h1 class="page-header-title font-weight-light">
                        <span>Supplier Delete Details</span>
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
                                        <thead>
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
    echo 'GRN';

} else if ($check === 4) {  // POR
    echo 'POR';    
}
else {
    echo 'Page Not Found';
}

?>

<?php include "include/footerscripts.php"; ?>
<script>

$(document).ready(function () {

    // Table Customer
    $('#dataTableCustomer').DataTable({
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
            { "data": "name" },
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
            { "data": "name" },
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

});

</script>
<?php include "include/footer.php"; ?>
