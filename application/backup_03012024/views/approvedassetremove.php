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
                            <div class="page-header-icon"><i class="fas fa-couch"></i></div>
                            <span>Approved Asset Disposal</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                        <div class="col-12">
                            <h2 style="text-align: center;">Approved Disposal Asset List</h2>
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="tblremoved">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Asset</th>
												<th>Disposal Date</th>
												<th>Asset Disposal Type</th>
												<th>Asset Current Value</th>
                                                <th>Aprrove Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
		</main>
<!-- 
        asset depreciated model -->

        
        <div class="modal fade" id="dipmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        	aria-hidden="true">
        	<div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        		<div class="modal-content">
        			<div class="modal-header">
        				<h5 class="modal-title" id="exampleModalCenterTitle">Approved Asset Disposal</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>
        			</div>
        			<div class="modal-body">
                        <form action="<?php echo base_url() ?>ApprovedApprovedApprovedApprovedassetremove/ApprovedApprovedApprovedApprovedassetremoveinsertupdate" method="post" autocomplete="off">
                        	<div class="row">
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                        					<label class="small font-weight-bold">Purchase Price*</label>
                        					<input type="number" step="any" class="form-control form-control-sm"
                        						name="purprice" id="purprice" readonly>
                        				</div>
                        			</div>
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                        					<label class="small font-weight-bold">Depreciation Months*</label>
                        					<input type="number" step="any" class="form-control form-control-sm"
                        						name="dip_months" id="dip_months" readonly>
                        				</div>
                        			</div>
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                        					<label class="small font-weight-bold">Depreciation Affective Date*</label>
                        					<input type="date" class="form-control form-control-sm" name="affectivedate"
                        						id="affectivedate" readonly>
                        				</div>
                        			</div>
                        	</div>
                            <div class="row">
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                                        <label class="small font-weight-bold">Asset Disposal Type *</label>
                                        <select class="form-control form-control-sm" name="remove_type" id="remove_type" readonly>
                                            <option value="">Select</option>
                                            <option value="1">Sell</option>
                                            <option value="2">Discard</option>
                                            <option value="3">Bulk Sell</option>
                                        </select>
                        				</div>
                        			</div>
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                        					<label class="small font-weight-bold">Asset Current Value*</label>
                        					<input type="number" step="any" class="form-control form-control-sm"
                        						name="currentvalue" id="currentvalue" readonly>
                        				</div>
                        			</div>
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                        					<label class="small font-weight-bold">Disposal Date*</label>
                        					<input type="date" class="form-control form-control-sm" name="removedate"
                        						id="removedate" readonly>
                        				</div>
                        			</div>
                        	</div>
                        	<div class="row">
                                <div class="col-4">
                                <div class="form-group mt-2 ">
                        		</div>
                                <input type="hidden"  name="hiddenassetid" id="hiddenassetid">
                        		<input type="hidden" name="recordOption" id="recordOption" value="1">
                        		<input type="hidden" name="recordID" id="recordID" value="">
                                </div>
                        	</div>
                        </form>
        			</div>
        		</div>
        	</div>
        </div>
		<?php include "include/footerbar.php"; ?>
    </div>
</div>
<style>
    .approved-class {
   color: green; /* Set the desired color for Approved cells */
   /* Additional CSS styles */
}

.rejected-class {
   color: red; /* Set the desired color for Rejected cells */
   /* Additional CSS styles */
}
</style>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        // depreciated asset list



        $('#tblremoved').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Approved Asset Disposal Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Approved Asset Disposal Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Approved Asset Disposal Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            
            ajax: {
                url: "<?php echo base_url() ?>scripts/approvedassetremovelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_asset_remove"
                },
                {
                    "data": "sub_category"
                },
				{
                    "data": "remove_date"
                },
                {
                        "targets": -1,
                        "className": 'text-left',
                        "data": "removetype ",
                        "render": function (data, type, full) {
                            var label = '';

                            if (full['removetype'] == 1) {
                                label += '<label >Sell</label>';
                            }else if(full['removetype'] == 2){
                                label += '<label >Discard</label>';
                            } 
                            else {
                                label += '<label >Bulk Sell</label>';
                            }
                            return label;
                        }
                },
                {
                    "data": "asset_valuability"
                },
                {
                        "targets": -1,
                        "data": "approve_status ",
                       
                        "render": function (data, type, full) {
                            var className = '';
                            var label = '';
                            if (full['approve_status'] == 1) {
                                className = 'approved-class';
                                label += '<label >Approved</label>';
                            }
                            else {
                                className = 'rejected-class';
                                label += '<label >Rejected</label>';
                            }
                            return '<span class="' + className + '">' + label + '</span>';
                        }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-secondary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_asset_remove']+'"><i class="fas fa-eye"></i></button>';
                         return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


        $('#tblremoved tbody').on('click', '.btnEdit', function() {
           
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Approvedassetremove/Approvedassetremoveedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#purprice').val(obj.purprice);  
                        $('#affectivedate').val(obj.affective_date); 
                        $('#dip_months').val(obj.depmonths); 
                        $('#hiddenassetid').val(obj.assetid);  
                        $('#remove_type').val(obj.type); 
                        $('#removedate').val(obj.date); 
                        $('#currentvalue').val(obj.valuability); 
                        $('#dipmodel').modal('show');
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                       
                    }
                });
            
        });


        $('#tbldepreciated tbody').on('click', '.btnEditdip', function() {
           
           var id = $(this).attr('id');
           $.ajax({
               type: "POST",
               data: {
                   recordID: id
               },
               url: '<?php echo base_url() ?>Assetdepreciation/Assetdepreciationedit',
               success: function(result) { //alert(result);
                   var obj = JSON.parse(result);
                   $('#recordID').val(obj.id);
                   $('#purprice').val(obj.purprice);  
                   $('#affectivedate').val(obj.affective_date); 
                   $('#dip_months').val(obj.depmonths); 
                   $('#hiddenassetid').val(obj.assetid); 
                   $('#dipmodel').modal('show');
               }
           });
       
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
</script>
<?php include "include/footer.php"; ?>
