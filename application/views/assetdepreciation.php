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
                            <span>Asset Depreciation</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                        <div class="col-12">
                            <h2 style="text-align: center;">All Asset List</h2>
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="tblmachinetype">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Asset</th>
												<th>Purchase Date</th>
												<th>Purchase Price</th>
												<th>Location</th>
                                                <th>Code</th>
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
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                        <div class="col-12">
                            <h2 style="text-align: center;">Depreciated Asset List</h2>
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="tbldepreciated">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Asset</th>
												<th>Purchase Price</th>
												<th>Depreciation Affective Date</th>
                                                <th>Depreciation Months</th>
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
<!-- 
        asset depreciated model -->

        
        <div class="modal fade" id="dipmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        	aria-hidden="true">
        	<div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        		<div class="modal-content">
        			<div class="modal-header">
        				<h5 class="modal-title" id="exampleModalCenterTitle">Asset Depreciation</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>
        			</div>
        			<div class="modal-body">
                        <form action="<?php echo base_url() ?>Assetdepreciation/Assetdepreciationinsertupdate" method="post" autocomplete="off">
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
                        						name="dip_months" id="dip_months" required>
                        				</div>
                        			</div>
                        			<div class="col-4">
                        				<div class="form-group mb-1">
                        					<label class="small font-weight-bold">Depreciation Affective Date*</label>
                        					<input type="date" class="form-control form-control-sm" name="affectivedate"
                        						id="affectivedate" required>
                        				</div>
                        			</div>
                        	</div>
                        	<div class="row">
                                <div class="col-4">
                                <div class="form-group mt-2 ">
                        			<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                        				<?php if($addcheck==0){echo 'disabled';} ?>><i
                        					class="far fa-save"></i>&nbsp;Add</button>
                        		</div>
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
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';
  // asset list tbl
        $('#tblmachinetype').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Asset Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Asset Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Asset Information',
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
                url: "<?php echo base_url() ?>scripts/assetlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_asset"
                },
                {
                    "data": "sub_category"
                },
				{
                    "data": "Purchase_date"
                },
				{
                    "data": "purchase_price"
                },
                {
                    "data": "location"
                },
                {
                    "data": "code"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_asset']+'"><i class="fas fa-pen"></i></button>';
                       
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        // depreciated asset list

        $('#tbldepreciated').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Depreciated Asset Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Depreciated Asset Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Depreciated Asset Information',
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
                url: "<?php echo base_url() ?>scripts/assetdepreciationlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_asset_depreciation"
                },
                {
                    "data": "sub_category"
                },
				{
                    "data": "purchest_price"
                },
				{
                    "data": "depreciation_affective_date"
                },
                {
                    "data": "depreciation_months"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEditdip mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_asset_depreciation']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Assetdepreciation/Assetdepreciationstatus/'+full['idtbl_asset_depreciation']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Assetdepreciation/Assetdepreciationstatus/'+full['idtbl_asset_depreciation']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Assetdepreciation/Assetdepreciationstatus/'+full['idtbl_asset_depreciation']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#tblmachinetype tbody').on('click', '.btnEdit', function() {
           
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Asset/Assetedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
						$('#purprice').val(obj.purprice);  
                        $('#dipmodel').modal('show');
                       
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
                   $('#dipmodel').modal('show');
                   $('#recordOption').val('2');
                $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
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
