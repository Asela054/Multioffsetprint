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
                            <div class="page-header-icon"><i data-feather="car"></i></div>
                            <span>Renew Details</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
        						<form action="<?php echo base_url()?>Renewdetails/Renewdetailsinsertupdate" method="post" autocomplete="off">
                                <div class="form-group">
                                        <label class="small font-weight-bold">Renew Type*</label>
                                        <select class="form-control form-control-sm" name="renewtype" id="renewtype" required>
                                            <option value="">Select</option>
                                            <?php foreach ($RenewType->result() as $rowrenewtype) { ?>
                                            <option value="<?php echo $rowrenewtype->idtbl_renew_type ?>"><?php echo $rowrenewtype->renew_type ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                        
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Supplier Name*</label>
                                        <select class="form-control form-control-sm" name="insurance" id="insurance" required>
                                            <option value="">Select</option>
                                            <?php foreach ($Insurance->result() as $rowinsurance) { ?>
                                            <option value="<?php echo $rowinsurance->idtbl_supplier ?>"><?php echo $rowinsurance->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold">Renew Date*</label>
                                        <input type="date" class="form-control form-control-sm" name="renewdate" id="renewdate" value="<?php echo date("Y-m-d"); ?>" required>
                                    </div>
                                
                                    <div class="form-group mb-2">
                                        <label class="small font-weight-bold">Next Renew Date*</label>
                                        <input type="date" class="form-control form-control-sm" name="nextrenewdate" id="nextrenewdate" value="<?php echo date('Y-m-d', strtotime('1 years')); ?>" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="small font-weight-bold">Amount*</label>
                                        <input type="text" class="form-control form-control-sm" name="amount" id="amount" required>
                                    </div>
                                    
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Comment*</label>
                                        <input type="text" rows="4" cols="50" class="form-control form-control-sm" name="comment" id="comment" required>
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
									<input type="hidden" name="vehicleid" id="vehicleid" value="<?php echo $vehicleid ?>">
        						</form>
                            </div>
								<input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $vehicleid ?>">
        							<div class="col-9">
        								<div class="scrollbar pb-3" id="style-2">
        									<table class="table table-bordered table-striped table-sm nowrap"
        										id="tblrenewlist">
        										<thead>
        											<tr>
                                                    <th>#</th>
                                                    <th>RENEW TYPE</th>
                                                    <th>SUPPLIER NAME</th>
                                                    <th>AMOUNT</th>
                                                    <th>RENEW DATE</th>
                                                    <th>NEXT RENEW DATE</th>
                                                    <th>COMMENT</th>
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
       
        $('#tblrenewlist').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Renew Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Renew Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Renew Information',
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
                url: "<?php echo base_url() ?>scripts/renewdetailslist.php",
                type: "POST", // you can use GET
                 data: function ( d ) {
                 return $.extend( {}, d, {
                 "vehicleid": $("#hiddenid").val()
         } );
       }
            },
            "order": [[ 0, "desc" ]],
            "createdRow": function( row, data, dataIndex){
                
                var vals = data['next_renew_date'].split('-'); 
                
                var y = vals[0];
                var m = vals[1];
                var d = vals[2];

                var year =parseInt(y)
                var month=m-1
                var date=parseInt(d)
 
                currentdate = new Date();
                currentyear = currentdate.getFullYear();
                currentmonth = currentdate.getMonth() + 1;
                currentday = currentdate.getDate();
// console.log(currentyear,currentmonth,currentday,month,date)
                if(data['renew_type']  == 'Insurance' && currentmonth >= month && date<=currentday  && year==currentyear){
                    $(row).addClass('bg-cyan');
                }else if(data['renew_type']  == 'License'  && currentmonth >= month && date<=currentday  && year==currentyear){
                    $(row).addClass('bg-secondary-soft');
                }
            },
            "columns": [
                {
                    "data": "idtbl_renew_details"
                },
                {
                    "data": "renew_type"
                },
                {
                    "data": "name"
                },
                {
                    "data": "amount"
                },
                {
                    "data": "renew_date"
                },
                {
                    "data": "next_renew_date"
                },
                {
                    "data": "comments"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        $vehicleid =$("#hiddenid").val()
                        var button='';
						button+='<button class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_renew_details ']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Renewdetails/Renewdetailsstatus/'+full['idtbl_renew_details']+'/2/'+[$vehicleid]+'" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 "><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Renewdetails/Renewdetailsstatus/'+full['idtbl_renew_details']+'/1/'+[$vehicleid]+'" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Renewdetails/Renewdetailsstatus/'+full['idtbl_renew_details']+'/3/'+[$vehicleid]+'"onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#tblrenewlist tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                // var id = $(this).attr('id');
                var currentRow=$(this).closest("tr");
                var id =currentRow.find("td:eq(0)").html();
                console.log(id);
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Renewdetails/Renewdetailsedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#renewtype').val(obj.renewtype); 
                        $('#insurance').val(obj.insurance); 
                        $('#amount').val(obj.amount); 
                        $('#renewdate').val(obj.renewdate); 
                        $('#nextrenewdate').val(obj.nextrenewdate); 
                        $('#comment').val(obj.comment); 

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
<!-- <script>
   function disableInput() {
  var select = document.getElementById("renewtype");
  var input = document.getElementById("insurance");
  if (select.value != "2") {
    input.disabled = true;
  } else {
    input.disabled = false;
  }
  onchange="disableInput()"
}
</script> -->

<?php include "include/footer.php"; ?>
