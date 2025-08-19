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
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i class="fas fa-cog"></i></div>
                            <span>Machine Service</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-3 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" id="addMachineServiceBtn" class="btn btn-dark btn-sm px-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="far fa-save"></i>&nbsp;Add Machine Service
                            </div>
                            <div class="col-12 mt-3">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap small" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service No</th>
                                                <th>Job Type</th>
                                                <th>Machine Type</th>
                                                <th>Machine Serial No</th>
                                                <th>Service Date From</th>
                                                <th>Service Date To</th>
                                                <th>Estimated Service Hours</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="machineservice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h5 class="modal-title d-flex align-items-center text-white">
                                <i class="fas fa-cog mr-2"></i>
                                Machine Service
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form autocomplete="off" id="machineserviceform">
                                <div id="accordion">
                                    <div class="card mb-2">

                                        <div class="card-body" style="background-color: lightblue;">

                                            <div class="container-fluid p-2">
                                                <div class="row">
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Service No*</label>
                                                        <input type="text" class="form-control form-control-sm" name="idtbl_machine_service" id="idtbl_machine_service" readonly>
                                                    </div>                                            
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Service Date From*</label>
                                                        <input type="datetime-local" class="form-control form-control-sm" name="service_date_from" id="service_date_from">
                                                    </div>
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Job Type*</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="job_type" id="service" checked value="1">
                                                            <label class="form-check-label" for="service">Service</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="job_type" id="repair" value="2">
                                                            <label class="form-check-label" for="repair">Repair</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Service Date To*</label>
                                                        <input type="datetime-local" class="form-control form-control-sm" name="sevice_date_to" id="sevice_date_to" required>
                                                    </div>
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Machine Type*</label>
                                                        <select class="form-control form-control-sm" style="width: 100%;" name="machine" id="machine" required>
                                                        <option value="">Select</option>
                                                        <?php foreach($machine->result() as $rowmachine){ ?>
                                                        <option value="<?php echo $rowmachine->idtbl_machine ?>"><?php echo $rowmachine->machine ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    </div>
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Estimated Hours*</label>
                                                        <input type="text" class="form-control form-control-sm" name="estimated_sevice_hours" id="estimated_sevice_hours">
                                                    </div>
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Factory Code*</label>
                                                        <input type="text" class="form-control form-control-sm" name="factory_code" id="factory_code">
                                                    </div>
                                                    <div class="form-group col-6 ps-0 mb-1">
                                                        <label class="small font-weight-bold text-black">Estimated Service Items*</label>
                                                        <input type="text" class="form-control form-control-sm" name="estimated_sevice_items" id="estimated_sevice_items">
                                                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                                                        <input type="hidden" name="recordID" id="recordID" value="">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group col-12 mt-2 text-right p-2">
                                            <button type="button" id="submitdata" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {
                                                                                                                                echo 'disabled';
                                                                                                                            } ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
    $('#machine').select2({dropdownParent: $('#machineservice')});

    $(document).ready(function() {
        $('#addMachineServiceBtn').click(function() {
            $('#machineservice').modal('show');
            
        var lastServiceId = $('#dataTable').DataTable().rows().data().length > 0 ?
                            $('#dataTable').DataTable().row(0).data().idtbl_machine_service : 0;
        var numericPart = parseInt(lastServiceId.replace('SRV000', ''));
        var newNumericPart = numericPart + 1;
        var newServiceId = 'SRV000' + newNumericPart;
        $('#idtbl_machine_service').val(newServiceId);
        });
    });

    $('#machineservice').on('click', '#submitdata', function(e) { 
        e.preventDefault();

            var recordOption = $('#recordOption').val();
            var recordID = $('#recordID').val();

            var idtbl_machine_service = $('#idtbl_machine_service').val();
            var job_type = $('input[name="job_type"]:checked').val();//alert(job_type);
            var machine = $('#machine').val();
            var factory_code = $('#factory_code').val();
            var service_date_from = $('#service_date_from').val();
            var sevice_date_to = $('#sevice_date_to').val();
            var estimated_sevice_hours = $('#estimated_sevice_hours').val();
            var estimated_sevice_items = $('#estimated_sevice_items').val();

            $.ajax({
                type: "POST",
                data: {

                    recordOption: recordOption,
                    recordID: recordID,

                    idtbl_machine_service: idtbl_machine_service,
                    job_type: job_type,
                    machine: machine,
                    factory_code: factory_code,
                    service_date_from: service_date_from,
                    sevice_date_to: sevice_date_to,
                    estimated_sevice_hours: estimated_sevice_hours,
                    estimated_sevice_items: estimated_sevice_items,
                    
                },
                url: '<?php echo base_url() ?>Machineservice/Machineserviceinsertupdate',
                success: function(result) {
                    $('#machineservice').modal('hide');
                    resetMachineServiceForm();
                    $('#dataTable').DataTable().ajax.reload();
                }
            });
    });

    $(document).ready(function() {

        var addcheck = '<?php echo $addcheck; ?>';
        var editcheck = '<?php echo $editcheck; ?>';
        var statuscheck = '<?php echo $statuscheck; ?>';
        var deletecheck = '<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [{
                    extend: 'csv',
                    className: 'btn btn-success btn-sm',
                    title: 'Color',
                    text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    title: 'Color',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                },
                {
                    extend: 'print',
                    title: 'Color',
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
                url: "<?php echo base_url() ?>scripts/machineservicelist.php",
                type: "POST",
                // data: function(d) {}
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [
                {
                    "data": "idtbl_machine_service"
                },
                {
                    "data": function(data, type, full) {
                        return "SRV000" + data.idtbl_machine_service;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        if (data.job_type == 1) {
                            return 'Service'; 
                        } else {
                            return 'Repair';
                        }
                    }
                },
                {
                    "data": "machine"
                },
                {
                    "data": "machine_serial_no"
                },
                {
                    "data": "service_date_from"
                },
                {
                    "data": "sevice_date_to"
                },
                {
                    "data": "estimated_sevice_hours"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_machine_service']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>MachineService/Machineservicestatus/'+full['idtbl_machine_service']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>MachineService/Machineservicestatus/'+full['idtbl_machine_service']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>MachineService/Machineservicestatus/'+full['idtbl_machine_service']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';

                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                $('#machineservice').modal('show');
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>MachineService/Machineserviceedit',
                    success: function(result) {
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#idtbl_machine_service').val(obj.idtbl_machine_service);
                        if (obj.job_type == 1) {
                            $('input[name="job_type"][value="1"]').prop('checked', true);
                        } else {
                            $('input[name="job_type"][value="2"]').prop('checked', true);
                        }
                        $('#machine').val(obj.machine).trigger('change');
                        $('#factory_code').val(obj.factory_code);
                        $('#machine_serial_no').val(obj.machine_serial_no);
                        $('#service_date_from').val(obj.service_date_from);
                        $('#sevice_date_to').val(obj.sevice_date_to);
                        $('#estimated_sevice_hours').val(obj.estimated_sevice_hours);
                        $('#estimated_sevice_items').val(obj.estimated_sevice_items);

                        $('#recordOption').val('2');
                        $('#submitdata').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });

    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
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
            element: 'body #machineservice',
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
            delay: 500,
            timer: 100,
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

function resetMachineServiceForm() {
    $('#machineserviceform')[0].reset();
    $('#recordOption').val('1');
    $('#recordID').val('');
    $('input[name="job_type"][value="1"]').prop('checked', true);
    $('#machine').val('').trigger('change');
    $('#submitdata').html('<i class="far fa-save"></i>&nbsp;Add');
}
</script>

<?php include "include/footer.php"; ?>
