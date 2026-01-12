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
                            <div class="page-header-icon"><i class="fas fa-archive"></i></div>
                            <span>Customer Inquiry</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form method="post" autocomplete="off" id="addjobform">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Company*</label>
                                            <input type="text" id="f_company_name" name="f_company_name" class="form-control form-control-sm" value="<?php echo ($_SESSION['companyname']); ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Company Branch*</label>
                                            <input type="text" id="f_branch_name" name="f_branch_name" class="form-control form-control-sm" value="<?php echo ($_SESSION['branchname']); ?>" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark"> Date*</label>
                                            <input type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>" name="date" id="date" required>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark"> Po No*</label>
                                            <input type="text" class="form-control form-control-sm" name="ponumber" id="ponumber" required>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark"> Customer *</label>
                                            <select class="form-control form-control-sm selecter2 px-0" name="customer" id="customer" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Job</label>
                                            <select class="form-control form-control-sm  selecter2 px-0" name="job" id="job" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">QTY</label>
                                            <input type="number" step="any" name="qty" class="form-control form-control-sm" id="qty" required>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">UOM</label>
                                            <input type="text" name="uom" class="form-control form-control-sm" id="uom" required readonly>
                                            <input type="hidden" name="uom_id" class="form-control form-control-sm" id="uom_id">
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Unit Price</label>
                                            <input type="number" id="unitprice" name="unitprice" class="form-control form-control-sm" value="0" step="any">
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Delivery Date</label>
                                            <input type="date" name="deliverydate" id="deliverydate" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-3">
                                            <lable class="font-weight-bold small">Delivery by</lable><br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="deliveryby1" name="deliveryby" value="By Customer" class="custom-control-input">
                                                <label class="custom-control-label small" for="deliveryby1">By Customer</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="deliveryby2" name="deliveryby" value="By Us" class="custom-control-input" checked>
                                                <label class="custom-control-label small" for="deliveryby2">By Us</label>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <label class="small font-weight-bold text-dark">Job BOM Infomation</label>
                                            <select class="form-control form-control-sm  selecter2 px-0" name="jobbom" id="jobbom">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Comments :</label>
                                            <textarea name="comment" class="form-control form-control-sm" id="comment" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 text-right">
                                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                                        <input type="hidden" name="recordID" id="recordID" value="">
                                        <button type="button" name="Btnsubmit" id="Btnsubmit" class="btn btn-primary btn-sm px-4"><i class="far fa-save"></i>&nbsp;Save</button>
                                    </div>
                                    <input type="submit" class="d-none" id="hidebtnaddlist">
                                </form>
                                <hr class="border-dark">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <span class="badge bg-danger-soft px-2 mb-2">&nbsp;</span> Rejected
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap small" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>Job No</th>
                                                <th>Po Number</th>
                                                <th>Job</th>
                                                <th class="text-center">Status</th>
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
<!-- view details model -->
<div class="modal fade" id="viewModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header p-2">
                <h6 class="modal-title">Job Information</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-12">
                        <div id="showdatainfo"></div>
                    </div>
                    <div class="col-12 text-right">
                        <hr>
                        <?php if($approvecheck==1){ ?>
                        <button id="btnapprovereject" class="btn btn-primary btn-sm px-3"><i class="fas fa-check mr-2"></i>Approve or Reject</button>
                        <?php } ?>
                        <input type="hidden" name="jobinqueryid" id="jobinqueryid">
                    </div>
                    <div class="col-12 text-center">
                        <div id="alertdiv"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- view job card model -->
<div class="modal fade" id="viewJobCard" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-2">
                <h6 class="modal-title">Job Card Information</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <div id="showjobcard"></div>
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-danger btn-sm px-3" id="exporttopdf"><i class="fas fa-file-pdf mr-2"></i>Export PDF</button>
                    </div>
                </div>
                <input type="hidden" name="jobcardinqueryid" id="jobcardinqueryid">
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Remarks -->
<div class="modal fade" id="addremarksmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel"><i class="fas fa-marker"></i> ADD REMARK</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="addremarkform" autocomplete="off">
                            <div class="form-group mb-1">
                                <input type="hidden" class="form-control form-control-sm" id="hiddenid" name="hiddenid">
                            </div>
                            <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Remark*</label><br>
                                        <textarea rows="6" cols="50" type="text" class="form-control form-control-sm" id="remark" name="remark" required></textarea>
                                    </div>
                            <div class="form-group mt-2 text-right">
                                <button type="submit" id="submitBtnRemark" class="btn btn-primary btn-sm px-4"><i
                                        class="far fa-save"></i>&nbsp;Add</button>
                                        <input type="submit" class="d-none" id="hidesubmitremark" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';
    
    $("#customer").select2({
        // dropdownParent: $('#modalreceivable'),
        ajax: {
            url: "<?php echo base_url() ?>Customerinquiry/Getcustomerlist",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $('#job').select2({width: '100%'});

    $('#customer').change(function() {
        var customerID = $(this).val();
        $.ajax({
            type: "POST",
            data: {
                recordID: customerID
            },
            url: '<?php echo base_url() ?>Customerinquiry/Getcustomejobs',
            success: function(result) {
                var obj = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(obj, function(i, item) {
                    html1 += '<option value="' + obj[i].idtbl_customer_job_details + '">';
                    html1 += obj[i].job_name;
                    html1 += '</option>';
                });
                $('#job').empty().append(html1).trigger('change');
            }
        });
    });
    $('#job').change(function() {
        var jobID = $(this).val();
        if(jobID!=''){
            $.ajax({
                type: "POST",
                data: {
                    recordID: jobID
                },
                url: '<?php echo base_url() ?>Customerinquiry/Getjobuom',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#uom').val(obj.measure_type);
                    $('#uom_id').val(obj.measure_type_id);
                    $('#unitprice').val(obj.unitprice);
                }
            });
            getBomlist(jobID, '');
        }
    });
    //Add List
    // $('#BtnAdd').click(function() {
    //     if (!$("#addjobform")[0].checkValidity()) {
    //         // If the form is invalid, submit it. The form won't actually submit;
    //         // this will just cause the browser to display the native HTML5 error messages.
    //         $("#hidebtnaddlist").click();
    //         // alert('in');
    //     } else {
    //         var jobID = $('#job').val();
    //         var job = $("#job option:selected").text();
    //         var qty = $('#qty').val();
    //         var uom = $('#uom').val();
    //         var uomID = $('#uom_id').val();
    //         var unitprice = $('#unitprice').val();
    //         var comment = $('#comment').val();
    //         var recordID = $('#recordID').val();

    //         var insertmethod = "NewRow";

    //         $('#tbljoblist> tbody:last').append('<tr class="btnDeleteJobList"><td name="job">' + job + '</td><td class="text-center">' + qty + '</td><td class="text-center" name="uom">' + uom + '</td><td class="text-center">' + unitprice + '</td><td class="text-center">' + comment + '</td><td name="jobid" class="d-none">' + jobID + '</td><td name="uomid" class="d-none">' + uomID + '</td></tr>');

    //         $('#job').val('').trigger('change');
    //         $('#customer').next('.select2-container').first().addClass('disabled-pointer-events');
    //         resetfeild();
    //     }
    // });
    $('#tbljoblist tbody').on('click', '.btnDeleteJobList', async function() {
        var r = await Otherconfirmation("You want to remove this ? ");
        if (r == true) {
            $(this).closest('tr').remove();
        }
    });
    // Full Submit
    $('#Btnsubmit').click(function() {        
        if (!$("#addjobform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hidebtnaddlist").click();
            // alert('in');
        } else {
            var jobID = $('#job').val();
            var job = $("#job option:selected").text();
            var qty = $('#qty').val();
            var uom = $('#uom').val();
            var uomID = $('#uom_id').val();
            var unitprice = $('#unitprice').val();
            var comment = $('#comment').val();

            var date = $('#date').val();
            var ponumber = $('#ponumber').val();
            var customer = $('#customer').val();
            var jobbom = $('#jobbom').val();
            var deliveryby = $('input[name="deliveryby"]:checked').val();
            var deliverydate = $('#deliverydate').val();
            var recordOption = $('#recordOption').val();
            var recordID = $('#recordID').val();

            if (uom === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please update UOM type you selected job.'
                });
                return;
            }

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
                            date: date,
                            ponumber: ponumber,
                            customer: customer,
                            jobID: jobID,
                            job: job,
                            qty: qty,
                            uom: uom,
                            uomID: uomID,
                            unitprice: unitprice,
                            comment: comment,
                            jobbom: jobbom,
                            deliveryby: deliveryby,
                            deliverydate: deliverydate,
                            recordOption: recordOption,
                            recordID: recordID
                        },
                        url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryinsertupdate',
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
    });

    $('#datatable').DataTable({
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
                title: 'Customer Inquiry  Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Customer Inquiry  Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Customer Inquiry  Information',
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
            url: "<?php echo base_url() ?>scripts/customerinquarylist.php",
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
                "data": "job_no"
            },
            {
                "data": "po_number"
            },
            {
                "data": "job"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": "status_display",
                "render": function(data, type, full) {
                    if (full['job_finish_status'] == 1) {
                        return '<span class="text-primary font-weight-bold"><i class="fas fa-check-circle"></i> ' + full['status_display'] + '</span>';
                    }
                    else{
                        if (full['approvestatus'] == 1) {
                            return '<span class="text-success font-weight-bold"><i class="fas fa-check-circle"></i> ' + full['status_display'] + '</span>';
                        } 
                        else if (full['approvestatus'] == 2) {
                            return '<span class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> ' + full['status_display'] + '</span>';
                        } else {
                            return '<span class="text-warning font-weight-bold"><i class="fas fa-redo"></i> ' + full['status_display'] + '</span>';
                        }
                    }
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button+='<button class="btn btn-outline-primary btn-sm btnAddremarks mr-1" id="'+full['idtbl_customerinquiry']+'" data-toggle="tooltip" data-placement="bottom" title="Add Salesrep"><i class="fas fa-marker"></i></button>';
                    button += '<button class="btn btn-primary btn-sm btnJobCard mr-1" id="' + full['idtbl_customerinquiry'] + '" data-toggle="tooltip" title="Job Card"><i class="fas fa-file"></i></button>';
                    if(full['approvestatus']==0){
                        button += '<button class="btn btn-dark btn-sm btnView mr-1" id="' + full['idtbl_customerinquiry'] + '" data-approvestatus="'+full['approvestatus']+'" data-toggle="tooltip" title="View & Approve"><i class="fas fa-eye"></i></button>';
                        if(editcheck==1){
                            button+='<button type="button" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_customerinquiry']+'" data-toggle="tooltip" title="Edit" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-pen"></i></button>';
                        }
                        if(full['status']==1 && statuscheck==1){
                            button+='<button type="button" data-url="Customerinquiry/Customerinquirystatus/'+full['idtbl_customerinquiry']+'/2" data-toggle="tooltip" title="Active" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        }else if(full['status']==2 && statuscheck==1){
                            button+='<button type="button" data-url="Customerinquiry/Customerinquirystatus/'+full['idtbl_customerinquiry']+'/1" data-toggle="tooltip" title="Deactive" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
                        }
                        if(deletecheck==1){
                            button+='<button type="button" data-url="Customerinquiry/Customerinquirystatus/'+full['idtbl_customerinquiry']+'/3" data-toggle="tooltip" title="Delete" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }
                    }
                    else{
                        button += '<button class="btn btn-dark btn-sm btnView mr-1" id="' + full['idtbl_customerinquiry'] + '" data-toggle="tooltip" title="View" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-eye"></i></button>';
                        // if(editcheck==1 && full['approvestatus']==1 && full['job_finish_status']==0){
                        if(editcheck==1 && full['approvestatus']==1){
                            button+='<button type="button" class="btn btn-orange btn-sm btnEdit mr-1" id="'+full['idtbl_customerinquiry']+'" data-toggle="tooltip" title="Edit Some" data-approvestatus="'+full['approvestatus']+'"><i class="fas fa-pencil-alt"></i></button>';
                        }
                    }

                    return button;
                }
            }
        ],
		createdRow: function( row, data, dataIndex){
            if(data['approvestatus']  ==  2){
				$(row).addClass('bg-danger-soft');
			}
		},
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    $('#datatable tbody').on('click', '.btnEdit', async function() {
        var r = await Otherconfirmation("You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            var approvestatus = $(this).attr('data-approvestatus');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#date').val(obj.date);
                    $('#ponumber').val(obj.po_number);
                    var newOptiondr = new Option(obj.customer, obj.customerid, true, true);
                    $('#customer').append(newOptiondr);
                    
                    var newOptionjob = new Option(obj.job_name, obj.job_id, true, true);
                    $('#job').append(newOptionjob);

                    getBomlist(obj.job_id, obj.jobbomid);

                    $('#qty').val(obj.qty);
                    $('#uom').val(obj.uom);
                    $('#uom_id').val(obj.uom_id);
                    $('#unitprice').val(obj.unitprice);
                    $('#comment').val(obj.comments);

                    $('input[name="deliveryby"][value="' + obj.deliveryby + '"]').prop('checked', true);
                    $('#deliverydate').val(obj.deliverydate);

                    if(approvestatus==1){
                        $('#date').prop('readonly', true);
                        // $('#ponumber').prop('readonly', true);
                        $('#customer').prop('disabled', true);
                        $('#job').prop('disabled', true);
                        $('#unitprice').prop('readonly', true);
                        $('#comment').prop('readonly', true);
                    }
                    
                    $('#recordOption').val('2');
                    $('#Btnsubmit').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });
    $('#dataTable tbody').on('click', '.btnAddremarks', function () {
        var id = $(this).attr('id');
        $("#hiddeninquiryid").val(id);

        $('#addremarksmodal').modal('show');

    });
    $('#datatable tbody').on('click', '.btnView', function() {
        var id = $(this).attr('id');
        var approvestatus = $(this).attr('data-approvestatus');

        $('#jobinqueryid').val(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryviewjoblist',
            success: function(result) { //alert(result);
                $('#showdatainfo').html(result);
                $('#viewModel').modal('show');
                if(approvestatus>0){
                    $('#btnapprovereject').addClass('d-none').prop('disabled', true);
                    if(approvestatus==1){$('#alertdiv').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle mr-2"></i> Inquiry approved</div>');}
                    else if(approvestatus==2){$('#alertdiv').html('<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle mr-2"></i> Inquiry rejected</div>');}
                }
            }
        });
    });
    $('#viewModel').on('hidden.bs.modal', function (event) {
        $('#alertdiv').html('');
        $('#btnapprovereject').removeClass('d-none').prop('disabled', false);
    });
    $('#datatable tbody').on('click', '.btnJobCard', function() {
        var id = $(this).attr('id');
        $('#jobcardinqueryid').val(id);

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
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryviewjobcard',
                    success: function(result) { //alert(result);
                        Swal.close();
                        document.body.style.overflow = 'auto';
                        $('#showjobcard').html(result);
                        $('#viewJobCard').modal('show');
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
    });

    $('#btnapprovereject').click(function(){
        Swal.fire({
            title: "Do you want to approve this inqury?",
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
                url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryjoblistedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#invoicedeiailsid').val(obj.id);
                    // $('#job').val(obj.job);
                    $('#job').val(obj.job_id);
                    $('#qty').val(obj.qty);
                    $('#uom').val(obj.uom);
                    $('#uom_id').val(obj.uom_id);
                    $('#unitprice').val(obj.unitprice);
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

            var jobID = $('#job').val();
            var job = $("#job option:selected").text();
            var qty = $('#qty').val();
            var uom = $('#uom').val();
            var uomID = $('#uom_id').val();
            var unitprice = $('#unitprice').val();
            var comment = $('#comment').val();
            var invoiceid = $('#invoiceid').val();
            var invoicedetailid = $('#invoicedeiailsid').val();
            var insertmethod = "Updated";

            $("#tbljoblist> tbody").find('input[name="hiddenid"]').each(function() {
                var idhidden = $(this).val();
                if (idhidden == invoicedetailid) {
                    $(this).parents("tr").remove();
                }

            });

            $('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job +
                '</td><td class="text-center">' + qty + '</td><td class="text-center" name="uom">' +
                uom + '</td><td class="text-center">' +
                unitprice + '</td><td class="text-center">' + comment +
                '</td><td name="jobid" class="d-none">' + jobID +
                '</td><td name="uomid" class="d-none">' + uomID +
                '</td><td class="text-center d-none">' + insertmethod +
                '</td><td class=" d-none">' + invoiceid + '</td><td class=" d-none">' +
                invoicedetailid +
                '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
            );


            $('#Btnupdatelist').hide();
            $('#BtnAdd').show();
            resetfeild();
        }
    });

    $('#exporttopdf').click(function(){
        var id = $('#jobcardinqueryid').val();
        var url = '<?php echo base_url() ?>Customerinquiry/Customerinquiryexportpdf/'+id;
        window.open(url, '_blank');
    });
});

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
                    inquiryid: $('#jobinqueryid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>Customerinquiry/Customerinquiryapprove',
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
function getBomlist(jobID, setValue){
    $.ajax({
        type: "POST",
        data: {
            recordID: jobID
        },
        url: '<?php echo base_url() ?>Customerinquiry/Getjobbominfo',
        success: function(result) {
            var obj = JSON.parse(result);
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $.each(obj, function(i, item) {
                html1 += '<option value="' + obj[i].idtbl_jobcard_bom + '">';
                html1 += obj[i].jobbomname;
                html1 += '</option>';
            });
            $('#jobbom').empty().append(html1);

            if(setValue!=''){
                $('#jobbom').val(setValue);
            }
        }
    });
}
</script>
<?php include "include/footer.php"; ?>