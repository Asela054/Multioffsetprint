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
                            <div class="page-header-icon"><i data-feather="shopping-cart"></i></div>
                            <span>Approved Customer Inquiry</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="tblcustomer">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>Po Number</th>
                                                <th>Job</th>
                                                <th>Job Number</th>

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
        <!--  Edit model -->
        <div class="modal fade" id="editmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Customer Inquary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <form method="post" autocomplete="off" id="addjobform">
                                    <div class="col-12">
                                        <label class="small font-weight-bold text-dark"> Date*</label>
                                        <input type="date" class="form-control form-control-sm"
                                            value="<?php echo date("Y-m-d"); ?>" name="date" id="date" required
                                            readonly>
                                    </div>
                                    <div class="col-12">
                                        <label class="small font-weight-bold text-dark"> Po No*</label>
                                        <input type="text" class="form-control form-control-sm" name="ponumber"
                                            id="ponumber" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label class="small font-weight-bold text-dark"> Customer *</label>
                                        <select class="form-control form-control-sm" name="customer" id="customer"
                                            required readonly>
                                            <option value="">Select</option>
                                            <?php foreach($customerlist->result() as $rowcustomerlist){ ?>
                                            <option value="<?php echo $rowcustomerlist->idtbl_customer ?>">
                                                <?php echo $rowcustomerlist->customer?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Job :</label>
                                            <input type="text" name="job" class="form-control form-control-sm" id="job"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">QTY :</label>
                                            <input type="number" step="any" name="qty"
                                                class="form-control form-control-sm" id="qty" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Comments :</label>
                                            <input type="text" name="comment" class="form-control form-control-sm"
                                                id="comment" required readonly>
                                        </div>
                                    </div>


                                    <div class="form-group mt-2">
                                        &nbsp; <button type="button" name="BtnAdd" id="BtnAdd"
                                            class="btn btn-primary btn-m "><i class="fas fa-plus"></i>&nbsp;Add</button>
                                        <input type="submit" class="d-none" id="hidebtnaddlist">

                                    </div>

                                    <div class="form-group mt-2">
                                        <input type="hidden" name="invoiceid" class="form-control form-control-sm"
                                            id="invoiceid">
                                        <input type="hidden" name="invoicedeiailsid"
                                            class="form-control form-control-sm" id="invoicedeiailsid">
                                        <input type="hidden" name="rowid" class="form-control form-control-sm"
                                            id="rowid">
                                        &nbsp; <button type="button" name="Btnupdatelist" id="Btnupdatelist"
                                            class="btn btn-primary btn-m " style="display:none;"><i
                                                class="fas fa-plus"></i>&nbsp;Update List</button>
                                        <input type="submit" class="d-none" id="hidebtnupdatelist">

                                    </div>
                                </form>

                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="tbljoblist">
                                        <thead>
                                            <tr>
                                                <th>Job</th>
                                                <th>Qty</th>
                                                <th>Comments</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbljobinquarybody">
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mt-2">
                                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                                            <input type="hidden" name="recordID" id="recordID" value="">
                                            <button type="button" name="Btnsubmit" id="Btnsubmit"
                                                class="btn btn-primary btn-m "><i
                                                    class="far fa-save"></i>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </div>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  view model -->
        <div class="modal fade" id="editmodelview" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">View Customer Inquary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <label class="small font-weight-bold text-dark"> Date*</label>
                                    <input type="date" class="form-control form-control-sm" name="dateview"
                                        id="dateview" readonly>
                                </div>
                                <div class="col-4">
                                    <label class="small font-weight-bold text-dark"> Po No*</label>
                                    <input type="text" class="form-control form-control-sm" name="ponumberview"
                                        id="ponumberview" readonly>
                                </div>
                                <div class="col-4">
                                    <label class="small font-weight-bold text-dark"> Customer *</label>
                                    <input type="text" class="form-control form-control-sm" name="customerview"
                                        id="customerview" readonly>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap" id="tbljoblist">
                                    <thead>
                                        <tr>
                                            <th>Job</th>
                                            <th>Qty</th>
                                            <th>UOM</th>
                                            <th>Unitprice</th>
                                            <th>Job No</th>
                                            <th>Comments</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbljobinquarybodyview">
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!--  Model Allocate Material -->
        <div class="modal fade" id="modelallocatematerial" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Allocate Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <form method="post" autocomplete="off" id="addjobmaterialform">
                                    <div class="col-12">
                                        <label class="small font-weight-bold text-dark"> Material Type*</label>
                                        <select class="form-control form-control-sm" name="materialtype"
                                            id="materialtype" required>
                                            <option value="">Select</option>
                                            <?php foreach($materialtypelist->result() as $rowmaterialtypelist){ ?>
                                            <option value="<?php echo $rowmaterialtypelist->idtbl_material_type ?>">
                                                <?php echo $rowmaterialtypelist->paper?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="small font-weight-bold text-dark"> Gauge Type*</label>
                                        <select class="form-control form-control-sm" name="gaugetype" id="gaugetype"
                                            required>
                                            <option value="">Select</option>
                                            <?php foreach($gaugetypelist->result() as $rowgaugetypelist){ ?>
                                            <option value="<?php echo $rowgaugetypelist->idtbl_categorygauge ?>">
                                                <?php echo $rowgaugetypelist->categorygauge_type?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="small font-weight-bold text-dark"> Material*</label>
                                        <select class="form-control form-control-sm" name="modalmaterial"
                                            id="modalmaterial" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Unit Price:</label>
                                            <input type="number" step="any" name="materialunitprice"
                                                class="form-control form-control-sm" id="materialunitprice" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">QTY :</label>
                                            <input type="number" step="any" name="allocateqty"
                                                class="form-control form-control-sm" id="allocateqty" required>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        &nbsp; <button type="button" name="BtnAddMaterial" id="BtnAddMaterial"
                                            class="btn btn-primary btn-m "><i class="fas fa-plus"></i>&nbsp;Add</button>
                                        <input type="submit" class="d-none" id="hidebtnaddmateriallist">

                                    </div>

                                    <div class="form-group mt-2">

                                        &nbsp; <button type="button" name="Btnmaterialupdatelist"
                                            id="Btnmaterialupdatelist" class="btn btn-primary btn-m "
                                            style="display:none;"><i class="fas fa-plus"></i>&nbsp;Update List</button>

                                    </div>
                                </form>

                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap"
                                        id="tblmateriallist">
                                        <thead>
                                            <tr>
                                                <th>Material</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblmateriallistbody">
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col text-right">
                                            <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                                        </div>
                                        <input type="hidden" id="hidetotalorder" value="0">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mt-2">
                                            <input type="hidden" name="hiddenjobdetailsid" id="hiddenjobdetailsid"
                                                value="1">
                                            <input type="hidden" name="hiddenallocatedmaterial"
                                                id="hiddenallocatedmaterial" value="0">
                                            <input type="hidden" name="materialrecordOption" id="materialrecordOption"
                                                value="0">
                                            <input type="hidden" name="materialrecordID" id="materialrecordID" value="">
                                            <button type="button" name="btnMaterialSubmit" id="btnMaterialSubmit"
                                                class="btn btn-primary btn-m "><i
                                                    class="far fa-save"></i>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </div>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#tblcustomer').DataTable({
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
                title: 'Approved Customer Inquiry  Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Approved Customer Inquiry  Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Approved Customer Inquiry  Information',
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
            url: "<?php echo base_url() ?>scripts/approvedinquarylist.php",
            type: "POST", // you can use GET
            "data": function(d) {
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
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.settings._iRecordsDisplay - meta.row;
                    }
                },
            {
                "data": "customer"
            },
            {
                "data": "date"
            },
            {
                "data": "po_number"
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
                    var button = '';


					button += '<a href="<?php echo base_url() ?>Approvedcustomerinquiry/pdfgrnget/' +
                        full['idtbl_customerinquiry'] +
                        '" target="_self" class="btn btn-secondary btn-sm mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-file-pdf mr-1"></i></a>';

                    button += '<button class="btn btn-dark btn-sm btnView mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_customerinquiry'] +
                        '"><i class="fas fa-eye"></i></button>';
                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_customerinquiry'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquirystatus/' +
                            full['idtbl_customerinquiry'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquirystatus/' +
                            full['idtbl_customerinquiry'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a href="<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquirystatus/' +
                        full['idtbl_customerinquiry'] +
                        '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
                    if (deletecheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-trash-alt"></i></a>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    //data View function

    $(document).on('click', '.btnView', function() {
        // var r = confirm("Are you sure, You want to Edit this ? ");
        // if (r == true) {
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryedit',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                $('#recordID').val(obj.id);
                $('#dateview').val(obj.date);
                $('#ponumberview').val(obj.po_number);
                $('#customerview').val(obj.customer);
                $('#editmodelview').modal('show');

                $('#tblmateriallist tbody').empty();

            }
        });
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryjobeditview',
            success: function(result) { //alert(result);
                $('#tbljobinquarybodyview').html(result);
            }
        });
        //}
    });

    // jobs to table to insert to db
    $(document).on("click", "#BtnAdd", function() {
        if (!$("#addjobform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hidebtnaddlist").click();
            // alert('in');
        } else {

            var job = $('#job').val();
            var qty = $('#qty').val();
            var comment = $('#comment').val();

            $('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job +
                '</td><td class="text-center">' + qty + '</td><td class="text-center">' + comment +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
            );

            resetfeild();
        }
    });


    // bill data submit for process data
    $(document).on("click", "#Btnsubmit", function() {

        // get table data into array
        var tbody = $('#tbljoblist tbody');
        if (tbody.children().length > 0) {
            var jsonObj = []
            $("#tbljoblist tbody tr").each(function() {
                item = {}
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });
        }
        // console.log(jsonObj);
        var date = $('#date').val();
        var ponumber = $('#ponumber').val();
        var customer = $('#customer').val();
        var recordOption = $('#recordOption').val();
        var recordID = $('#recordID').val();



        $.ajax({
            type: "POST",
            data: {
                tableData: jsonObj,
                date: date,
                ponumber: ponumber,
                customer: customer,
                recordOption: recordOption,
                recordID: recordID
            },
            url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryinsertupdate',
            success: function(result) {
                //console.log(result);
                var objfirst = JSON.parse(result);
                if (objfirst.status == 1) {
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
                action(objfirst.action)
            }
        });
    });


    //data edit function
    $(document).on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Approvedcustomerinquiry/Customerinquiryapproveedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#date').val(obj.date);
                    $('#ponumber').val(obj.po_number);
                    $('#customer').val(obj.customer);
                    $('#recordOption').val('2');
                    $('#Btnsubmit').html('<i class="far fa-save"></i>&nbsp;Update');
                    $('#editmodel').modal('show');
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryjobedit',
                success: function(result) { //alert(result);
                    $('#tbljobinquarybody').html(result);
                }
            });
        }
    });

    // edit JOB list table

    $(document).on('click', '.btnEditlist', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryjoblistedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#invoicedeiailsid').val(obj.id);
                    $('#job').val(obj.job);
                    $('#qty').val(obj.qty);
                    $('#comment').val(obj.comments);
                    $('#invoiceid').val(obj.idtbl_customerinquiry);
                    $('#Btnupdatelist').show();
                    $('#BtnAdd').hide();
                }
            });

        }
    });

    // update job  list 
    $(document).on("click", "#Btnupdatelist", function() {

        if (!$("#addjobform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hidebtnupdatelist").click();
            // alert('in');
        } else {

            var job = $('#job').val();
            var qty = $('#qty').val();
            var comment = $('#comment').val();
            var invoiceid = $('#invoiceid').val();
            var invoicedetailid = $('#invoicedeiailsid').val();

            // $("#tbljoblist> tbody").find('input[name="hiddenid"]').each(function () {
            // 	 var idhidden  = $('#hiddenid').val();
            // 	if(idhidden == invoicedetailid) {
            // 		$("#8").remove();
            // 	}

            // });

            $('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job +
                '</td><td class="text-center">' + qty + '</td><td class="text-center">' + comment +
                '</td><td class=" d-none">' + invoiceid + '</td><td class=" d-none">' +
                invoicedetailid +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
            );

            $('#Btnupdatelist').hide();
            $('#BtnAdd').show();

            resetfeild();
        }
    });

    $('#tbljoblist tbody').on('click', '.btnAssignMaterials', function() {
        var id = $(this).attr('id');
        $('#hiddenjobdetailsid').val(id);
        $('#tblmateriallist> tbody').empty();

        $.ajax({
            type: "POST",
            data: {
                detailsId: id
            },
            url: '<?php echo base_url(); ?>Approvedcustomerinquiry/Fetchinsertedmaterials',
            success: function(result) {
                //console.log(result);
                var obj = JSON.parse(result);
                $.each(obj, function(i, item) {

                    var sum = obj[i].qty * obj[i].unitprice;
                    var showsum = addCommas(parseFloat(sum).toFixed(2));
                    $('#tblmateriallist> tbody:last').append(
                        '<tr><td class="text-center">' + obj[i].materialname +
                        '</td><td class="text-center">' + obj[i].qty +
                        '</td><td class="text-center">' + showsum +
                        '</td><td><button type="button" id="' + obj[i]
                        .idtbl_inquiry_allocated_materials +
                        '" class=" btn btn-primary btn-sm float-right btnEditMaterials"><i class="fa fa-pen"></i></button></td><td class="d-none">' +
                        obj[i]
                        .idtbl_print_material_info +
                        '</td><td class="d-none">' + obj[i]
                        .tbl_material_type_idtbl_material_type +
                        '</td><td class="d-none">' + obj[i]
                        .tbl_categorygauge_idtbl_categorygauge +
                        '</td><td class="d-none materialtotal">' + sum +
                        '</td><td class="d-none">' + obj[i].unitprice +
                        '</td><td class="d-none">2</td><td class="d-none">' +
                        obj[i].idtbl_inquiry_allocated_materials + '</td></tr>');

                });
                calculateMaterialTableTotal()

                $('#modelallocatematerial').modal('show');
            }
        });
    });





    $('#btndom').on('click', function() {
        var doc = new jsPDF();
        var elementHTML = $('#tblmateriallist').html();
        var specialElementHandlers = {
            '#ignorePDF': function(element, renderer) {
                return true;
            }
        };

        doc.fromHTML(elementHTML, 15, 15, {
            'width': 170,
            'elementHandlers': specialElementHandlers
        });

        doc.save('material-list.pdf');
    });

























$('#tblmateriallist').on('click', 'tr', function() {
    var detailsid = $(this).closest("tr").find('td:eq(9)').html();

    if (detailsid != 0) {
        return
    }
    var r = confirm("Are you sure, You want to remove this material? ");
    if (r == true) {
        $(this).closest('tr').remove();
        calculateMaterialTableTotal();
    }
});
$('#tblmateriallist tbody').on('click', '.btnEditMaterials', function() {
    var detailsId = $(this).attr('id');

    var modalmaterial = $(this).closest("tr").find('td:eq(4)').html();
    var materialtext = $(this).closest("tr").find('td:eq(0)').html();
    var materialtype = $(this).closest("tr").find('td:eq(5)').html();
    var gaugetype = $(this).closest("tr").find('td:eq(6)').html();
    var allocateqty = $(this).closest("tr").find('td:eq(1)').html();
    var materialunitprice = $(this).closest("tr").find('td:eq(8)').html();
    var allocatedmaterialId = $(this).closest("tr").find('td:eq(10)').html();

    $('#modalmaterial').val(modalmaterial)
    $('#materialtype').val(materialtype)
    $('#gaugetype').val(gaugetype)
    $('#allocateqty').val(allocateqty)
    $('#materialunitprice').val(materialunitprice)
    $('#hiddenallocatedmaterial').val(allocatedmaterialId)
    $('#materialrecordOption').val(1)

    var html1 = '';
    html1 += '<option value="' + modalmaterial + '">';
    html1 += materialtext;
    html1 += '</option>';
    $('#modalmaterial').empty().append(html1);

    $(this).closest('tr').remove();
    calculateMaterialTableTotal();
});

$('#BtnAddMaterial').on('click', function() {
    if (!$("#addjobmaterialform")[0].checkValidity()) {
        // If the form is invalid, submit it. The form won't actually submit;
        // this will just cause the browser to display the native HTML5 error messages.
        $("#hidebtnaddmateriallist").click();
    } else {
        var modalmaterial = $('#modalmaterial').val()
        var materialtext = $("#modalmaterial option:selected").text();
        var materialtype = $('#materialtype').val()

        var gaugetype = $('#gaugetype').val()
        var allocateqty = $('#allocateqty').val()
        var materialunitprice = $('#materialunitprice').val()
        var hiddenallocatedmaterial = $('#hiddenallocatedmaterial').val()

        var materialrecordOption = $('#materialrecordOption').val()
        var edited = 0;
        if (materialrecordOption == 0) {
            edited = 0;
        } else {
            edited = 1;
        }

        var sum = allocateqty * materialunitprice;
        var showsum = addCommas(parseFloat(sum).toFixed(2));

        $('#tblmateriallist> tbody:last').append('<tr><td class="text-center">' + materialtext +
            '</td><td class="text-center">' + allocateqty + '</td><td class="text-center">' +
            showsum +
            '</td><td><button type="button" id="btnEditrowMaterial" class=" btn btn-primary btn-sm float-right btnEditMaterials" disabled><i class="fa fa-pen"></i></button></td><td class="d-none">' +
            modalmaterial +
            '</td><td class="d-none">' + materialtype +
            '</td><td class="d-none">' + gaugetype +
            '</td><td class="d-none materialtotal">' + sum +
            '</td><td class="d-none">' + materialunitprice +
            '</td><td class="d-none">' + edited + '</td><td class="d-none">' + hiddenallocatedmaterial +
            '</td></tr>');

        $('#modalmaterial').val('')
        $('#materialtype').val('')
        $('#gaugetype').val('')
        $('#allocateqty').val('')
        $('#materialrecordOption').val('0')

        calculateMaterialTableTotal()

    }
});

$('#btnMaterialSubmit').on('click', function() {
    var tbody = $("#tblmateriallist tbody");

    if (tbody.children().length > 0) {
        jsonObj = [];
        $("#tblmateriallist tbody tr").each(function() {
            item = {}
            $(this).find('td').each(function(col_idx) {
                item["col_" + (col_idx + 1)] = $(this).text();
            });
            jsonObj.push(item);
        });
        // console.log(jsonObj);

        var detailsId = $('#hiddenjobdetailsid').val();
        var materialrecordOption = $('#materialrecordOption').val();
        var materialrecordID = $('#materialrecordID').val();

        $.ajax({
            type: "POST",
            data: {
                tableData: jsonObj,
                detailsId: detailsId,
                materialrecordID: materialrecordID,
                materialrecordOption: materialrecordOption
            },
            url: '<?php echo base_url(); ?>Approvedcustomerinquiry/Insertupdateallocatedmaterials',
            success: function(result) {
                console.log(result);
                //setTimeout(window.location.reload(), 3000);
                action(result)
                $('#tblmateriallist> tbody').empty();
                calculateMaterialTableTotal()
                $('#modelallocatematerial').modal('hide');
            }
        });
    }
});

$('#gaugetype').change(function() {
    var gaugetype = $(this).val();
    var materialtype = $('#materialtype').val();

    $.ajax({
        type: "POST",
        data: {
            gaugetype: gaugetype,
            materialtype: materialtype
        },
        url: '<?php echo base_url(); ?>Approvedcustomerinquiry/Getfilteredmaterials',
        success: function(result) { //console.log(result)
            var obj = JSON.parse(result);
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $.each(obj, function(i, item) {
                html1 += '<option value="' + obj[i].idtbl_print_material_info +
                    '">';
                html1 += obj[i].materialname;
                html1 += '</option>';
            });
            $('#modalmaterial').empty().append(html1);
        }
    });
})

$('#modalmaterial').change(function() {
    var id = $(this).val();
    var gaugetype = $('#gaugetype').val();

    $.ajax({
        type: "POST",
        data: {
            recordId: id
        },
        url: '<?php echo base_url(); ?>Approvedcustomerinquiry/Getmaterialunitprice',
        success: function(result) { //console.log(result)
            var obj = JSON.parse(result);
            $('#materialunitprice').val(obj.unitprice)
        }
    });
})

$('#materialtype').change(function() {
var materialtype = $(this).val();
var gaugetype = $('#gaugetype').val();

$.ajax({
    type: "POST",
    data: {
        gaugetype: gaugetype,
        materialtype: materialtype
    },
    url: '<?php echo base_url(); ?>Approvedcustomerinquiry/Getfilteredmaterials',
    success: function(result) { //console.log(result)
        var obj = JSON.parse(result);
        var html1 = '';
        html1 += '<option value="">Select</option>';
        $.each(obj, function(i, item) {
            html1 += '<option value="' + obj[i].idtbl_print_material_info +
                '">';
            html1 += obj[i].materialname;
            html1 += '</option>';
        });
        $('#modalmaterial').empty().append(html1);
    }
});
})

});


function calculateMaterialTableTotal() {
    var totsum = 0;
    $("#tblmateriallist .materialtotal").each(function() {
        totsum += parseFloat($(this).text());
    });
    var showtotsum = addCommas(parseFloat(totsum).toFixed(2));


    $('#divtotal').html('Rs. ' + showtotsum);
    $('#hidetotalmaterial').val(totsum);
}

function productDelete(ctl) {
    $(ctl).parents("tr").remove();
}

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
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