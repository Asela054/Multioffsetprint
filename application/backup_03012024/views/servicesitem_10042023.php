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
        					<div class="page-header-icon"><i class="fas fa-users"></i></div>
        					<span>Services Item Details</span>
        				</h1>
        			</div>
        		</div>
        	</div>
        	<div class="container-fluid mt-2 p-0 p-2">
        		<div class="card">
        			<div class="card-body p-0 p-2">
        				<div class="row">
        					<div class="col-3">
        						<form action="<?php echo base_url()?>Servicesitem/Servicesiteminsertupdate" method="post" autocomplete="off">
        						
                                        <div class="form-group">
                                        <label class="small font-weight-bold">Service Item*</label>
                                        <select class="form-control form-control-sm" name="serviceitem" id="serviceitem" required>
                                            <option value="">Select</option>
                                            <?php foreach ($ServiceType->result() as $rowserviceType) { ?>
                                            <option value="<?php echo $rowserviceType->idtbl_service_item_list ?>"><?php echo $rowserviceType->service_type ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                  
        							
        								<div class="form-group mt-2 text-right">
        									<div class="form-group mt-2 text-right">
        										<button type="submit" id="submitBtn"
        											class="btn btn-primary btn-sm px-4"><i
        												class="far fa-save"></i>&nbsp;Add</button>
        									</div>
        								</div>
        							
        							<input type="hidden" name="recordOption" id="recordOption" value="1">
        							<input type="hidden" name="recordID" id="recordID" value="">
									<input type="hidden" name="serviceid" id="serviceid" value="<?php echo $Serviceid ?>">
        						</form>
                            </div>
								<input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $Serviceid ?>">
        						<hr style="border: 1px solid black;">
        						
        							<div class="col-9">
        								<div class="scrollbar pb-3" id="style-2">
        									<table class="table table-bordered table-striped table-sm nowrap"
        										id="tblservicelist">
        										<thead>
        											<tr>
        												<th>#</th>
        												<th>SERVICE ITEM</th>
        												<th>SUPPLIER</th>
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
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {

        $('#tblservicelist').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Service Item Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Service Item Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Service Item Information',
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
                url: "<?php echo base_url() ?>scripts/servicesitemlist.php",
                type: "POST", // you can use GET
                 data: function ( d ) {
                 return $.extend( {}, d, {
                 "serviceid": $("#hiddenid").val()
         } );
       }
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_service_details"
                },
                {
                    "data": "service_type"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        $service=$("#hiddenid").val()
                        
						button+='<button class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_service_has_tbl_service_item_list']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Servicesitem/Servicesitemstatus/'+full['idtbl_service_details']+'/2/'+[$service]+'" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 "><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Servicesitem/Servicesitemstatus/'+full['idtbl_service_details']+'/1/'+[$service]+'" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Servicesitem/Servicesitemstatus/'+full['idtbl_service_details']+'/3/'+[$service]+'" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#tblservicelist tbody').on('click', '.btnEdit', function() {
          
            var r = confirm("Are you sure, You want to Edit this ? ");
            
            if (r == true) {
                var currentRow=$(this).closest("tr");
		        var id=currentRow.find("td:eq(0)").html();
                // var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    
                    url: '<?php echo base_url() ?>Servicesitem/Servicesitemedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#serviceitem').val(obj.serviceitem); 
                       
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
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
</script>
<?php include "include/footer.php"; ?>
