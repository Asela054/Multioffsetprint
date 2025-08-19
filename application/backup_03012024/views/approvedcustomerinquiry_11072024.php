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
										value="<?php echo date("Y-m-d"); ?>" name="date" id="date" required readonly>
								</div>
								<div class="col-12">
									<label class="small font-weight-bold text-dark"> Po No*</label>
									<input type="text" class="form-control form-control-sm" name="ponumber" id="ponumber" readonly>
								</div>
								<div class="col-12">
									<label class="small font-weight-bold text-dark"> Customer *</label>
									<select class="form-control form-control-sm" name="customer" id="customer" required readonly>
										<option value="">Select</option>
										<?php foreach($customerlist->result() as $rowcustomerlist){ ?>
										<option value="<?php echo $rowcustomerlist->idtbl_customer ?>">
											<?php echo $rowcustomerlist->name?></option>
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
										<input type="number" step="any" name="qty" class="form-control form-control-sm"
											id="qty" required>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Comments :</label>
										<input type="text" name="comment" class="form-control form-control-sm" id="comment"
											required readonly>
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
											class="btn btn-primary btn-m "><i class="far fa-save"></i>&nbsp;Save</button>
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
								<input type="date" class="form-control form-control-sm" name="dateview" id="dateview" readonly>
							</div>
							<div class="col-4">
								<label class="small font-weight-bold text-dark"> Po No*</label>
								<input type="text" class="form-control form-control-sm" name="ponumberview" id="ponumberview"
									readonly>
							</div>
							<div class="col-4">
								<label class="small font-weight-bold text-dark"> Customer *</label>
								<input type="text" class="form-control form-control-sm" name="customerview" id="customerview"
									readonly>
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

        $('#tblcustomer').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Approved Customer Inquiry  Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Approved Customer Inquiry  Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Approved Customer Inquiry  Information',
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
                url: "<?php echo base_url() ?>scripts/approvedinquarylist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_customerinquiry"
                },
                {
                    "data": "name"
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
                        var button='';
                        
						button+='<button class="btn btn-dark btn-sm btnView mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_customerinquiry']+'"><i class="fas fa-eye"></i></button>';
							button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_customerinquiry']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquirystatus/'+full['idtbl_customerinquiry']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquirystatus/'+full['idtbl_customerinquiry']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquirystatus/'+full['idtbl_customerinquiry']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

	

		 //data View function

		 $(document).on('click', '.btnView', function () {
		 	// var r = confirm("Are you sure, You want to Edit this ? ");
		 	// if (r == true) {
		 		var id = $(this).attr('id');
		 		$.ajax({
		 			type: "POST",
		 			data: {
		 				recordID: id
		 			},
		 			url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryedit',
		 			success: function (result) { //alert(result);
		 				var obj = JSON.parse(result);
		 				$('#recordID').val(obj.id);
		 				$('#dateview').val(obj.date);
		 				$('#ponumberview').val(obj.po_number);
		 				$('#customerview').val(obj.customer);
						 $('#editmodelview').modal('show');
		 			}
		 		});
		 		$.ajax({
		 			type: "POST",
		 			data: {
		 				recordID: id
		 			},
		 			url: '<?php echo base_url() ?>Approvedcustomerinquiry/Approvedcustomerinquiryjobeditview',
		 			success: function (result) { //alert(result);
		 				$('#tbljobinquarybodyview').html(result);
		 			}
		 		});
		 	//}
		 });

		  

		




		 // jobs to table to insert to db
		 $(document).on("click", "#BtnAdd", function () {
			if (!$("#addjobform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hidebtnaddlist").click();
                // alert('in');
            } else {

		 	var job = $('#job').val();
		 	var qty = $('#qty').val();
		 	var comment = $('#comment').val();

		 	$('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job + '</td><td class="text-center">' + qty + '</td><td class="text-center">' + comment +
		 		'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>');
		
				 resetfeild();
		}
		 });


		 // bill data submit for process data
		 $(document).on("click", "#Btnsubmit", function () {

		 	// get table data into array
		 	var tbody = $('#tbljoblist tbody');
		 	if (tbody.children().length > 0) {
		 		var jsonObj = []
		 		$("#tbljoblist tbody tr").each(function () {
		 			item = {}
		 			$(this).find('td').each(function (col_idx) {
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
		 		success: function (result) {
		 			//console.log(result);
		 			var objfirst = JSON.parse(result);
		 			if (objfirst.status == 1) {
						setTimeout(function(){
						location.reload();
						}, 500);
		 			} 
					 action(objfirst.action)


		 		}
		 	});


		 });


		 //data edit function
		 $(document).on('click', '.btnEdit', function () {
		 	var r = confirm("Are you sure, You want to Edit this ? ");
		 	if (r == true) {
		 		var id = $(this).attr('id');
		 		$.ajax({
		 			type: "POST",
		 			data: {
		 				recordID: id
		 			},
		 			url: '<?php echo base_url() ?>Approvedcustomerinquiry/Customerinquiryapproveedit',
		 			success: function (result) { //alert(result);
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
		 			success: function (result) { //alert(result);
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
		 $(document).on("click", "#Btnupdatelist", function () {

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

		 	$('#tbljoblist> tbody:last').append('<tr><td class="text-center">' + job + '</td><td class="text-center">' + qty + '</td><td class="text-center">' + comment +
		 		'</td><td class=" d-none">' + invoiceid + '</td><td class=" d-none">' + invoicedetailid + '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>');

		 	$('#Btnupdatelist').hide();
		 	$('#BtnAdd').show();

			 resetfeild();
			}
		 });

    });

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

</script>
<?php include "include/footer.php"; ?>
