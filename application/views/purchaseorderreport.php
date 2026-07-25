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
							<div class="page-header-icon">
								<i class="fas fa-file-invoice"></i>
							</div>
							<span>&nbsp; Purchase Order Report</span>
						</h1>
					</div>
				</div>
			</div>


			<div class="container-fluid mt-2 p-0 p-2">

				<div class="card">

					<div class="card-body p-0 p-2">

						<div class="col-12">


							<form id="searchpo">


								<div class="col-12">

									<div class="form-row">


										<div class="col-3">

											<label class="small font-weight-bold">
												Supplier
											</label>

											<select class="form-control form-control-sm selecter2" 
												id="supplier">

												<option value="all">
													All
												</option>


												<?php foreach($supplier->result() as $row){ ?>

												<option value="<?php echo $row->idtbl_supplier; ?>">
													<?php echo $row->suppliername; ?>
												</option>

												<?php } ?>


											</select>


										</div>



										<div class="col-2">

											<label class="small font-weight-bold">
												Status
											</label>

											<select class="form-control form-control-sm selecter2" 
												id="postatus">

												<option value="all">
													All
												</option>

												<option value="unapproved">
													Unapproved
												</option>

												<option value="approved">
													Approved
												</option>

												<option value="grncreated">
													GRN Created
												</option>

												<option value="grnapproved">
													GRN Approved
												</option>

											</select>


										</div>



										<div class="col-2">

											<label class="small font-weight-bold">
												Date Type
											</label>

											<select class="form-control form-control-sm selecter2" 
												id="date_type">

												<option value="po">
													PO Date
												</option>

												<option value="grn">
													GRN Date
												</option>

											</select>


										</div>



										<div class="col-2">

											<label class="small font-weight-bold">
												Date From
											</label>

											<input type="date" 
											class="form-control form-control-sm"
											id="date_from">

										</div>



										<div class="col-2">

											<label class="small font-weight-bold">
												Date To
											</label>

											<input type="date" 
											class="form-control form-control-sm"
											id="date_to">

										</div>



									</div>


									<div class="form-row mt-2">


										<div class="col-3">

											<label class="small font-weight-bold">
												PO No / GRN No / Invoice / Batch
											</label>

											<input type="text" 
											class="form-control form-control-sm"
											id="search"
											placeholder="Search">

										</div>



										<div class="col-2">
											<br>

											<button type="submit" 
											class="btn btn-info btn-sm">

												<i class="fas fa-search"></i>
												&nbsp;Search

											</button>


										</div>


									</div>


								</div>



								<div class="col-12">

									<div class="form-group mb-1">

										<hr style="border:1px solid #ddd;">

									</div>

								</div>


							</form>





							<div class="col-12 mt-4">


								<div class="scrollbar pb-3" id="style-2">


									<table class="table table-bordered table-striped table-sm nowrap w-100"
									id="dataTable">


										<thead class="thead-light">

											<tr>

												<th>PO No</th>
												<th>PO Date</th>
												<th>Supplier</th>
												<th>GRN No</th>
												<th>GRN Date</th>
												<th>INV No</th>
												<th>Batch No</th>

											</tr>


										</thead>


										<tbody>

										</tbody>


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

$(document).ready(function(){


	$('.selecter2').select2();



	$("#searchpo").submit(function(event){

		event.preventDefault();



		$('#dataTable').DataTable({

			"destroy":true,

			"processing":true,

			"serverSide":true,


			ajax:{

				url:"<?php echo base_url()?>scripts/purchaseorderlistreport.php",

				type:"POST",


				data:function(d){

					return $.extend({},d,{

						"supplier":$("#supplier").val(),

						"postatus":$("#postatus").val(),

						"date_type":$("#date_type").val(),

						"date_from":$("#date_from").val(),

						"date_to":$("#date_to").val(),

						"search":$("#search").val()

					});

				}

			},



			"order":[
				[1,"desc"]
			],



			"columns":[

				{
					data:'po_no'
				},

				{
					data:'po_date'
				},

				{
					data:'supplier'
				},

				{
					data:'grn_no'
				},

				{
					data:'grn_date'
				},

				{
					data:'inv_no'
				},

				{
					data:'batch_no'
				}


			],




			dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",



			responsive:true,


			lengthMenu:[

				[-1],

				['All']

			],



			buttons:[


				{
					extend:'pdf',
					className:'btn btn-primary btn-sm',
					text:'<i class="fas fa-file-pdf mr-2"></i> PDF',
					title:'Purchase Order Report'
				},


				{
					extend:'excel',
					className:'btn btn-success btn-sm',
					text:'<i class="fas fa-file-excel mr-2"></i> EXCEL',
					title:'Purchase Order Report'
				},


				{
					extend:'csv',
					className:'btn btn-info btn-sm',
					text:'<i class="fas fa-file-csv mr-2"></i> CSV'
				},


				{
					extend:'print',
					className:'btn btn-warning btn-sm',
					text:'<i class="fas fa-print mr-2"></i> PRINT',
					title:'Purchase Order Report'
				}


			]



		});


	});


});


</script>


<?php include "include/footer.php"; ?>