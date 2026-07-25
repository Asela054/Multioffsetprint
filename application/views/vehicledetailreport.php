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
								<i class="fas fa-car"></i>
							</div>
							<span>&nbsp; Vehicle Full Detail Report</span>
						</h1>
					</div>
				</div>
			</div>


			<div class="container-fluid mt-2 p-0 p-2">

				<div class="card">

					<div class="card-body p-0 p-2">

						<div class="col-12">


							<form id="searchvehicle">


								<div class="col-12">

									<div class="form-row">


										<div class="col-3">

											<label class="small font-weight-bold">
												Vehicle Model
											</label>

											<select class="form-control form-control-sm selecter2" 
												id="model">

												<option value="all">
													All
												</option>


												<?php foreach($vehiclemodel->result() as $row){ ?>

												<option value="<?php echo $row->idtbl_vehicle_model; ?>">
													<?php echo $row->vehicle_model; ?>
												</option>

												<?php } ?>


											</select>


										</div>




										<div class="col-3">

											<label class="small font-weight-bold">
												Vehicle Brand
											</label>


											<select class="form-control form-control-sm selecter2" 
												id="brand">


												<option value="all">
													All
												</option>


												<?php foreach($vehiclebrand->result() as $row){ ?>

												<option value="<?php echo $row->idtbl_vehicle_brand; ?>">
													<?php echo $row->vehicle_brand; ?>
												</option>

												<?php } ?>


											</select>


										</div>




										<div class="col-3">

											<label class="small font-weight-bold">
												Vehicle / Engine / Chassis
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

												<th>Vehicle Reg No</th>
												<th>Vehicle Model</th>
												<th>Vehicle Brand</th>
												<th>Vehicle Type</th>
												<th>Engine No</th>
												<th>Chassis No</th>
												<th>Current Mileage(Km)</th>

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



	$("#searchvehicle").submit(function(event){

		event.preventDefault();



		$('#dataTable').DataTable({

			"destroy":true,

			"processing":true,

			"serverSide":true,


			ajax:{

				url:"<?php echo base_url()?>scripts/vehicledetaillistreport.php",

				type:"POST",


				data:function(d){

					return $.extend({},d,{

						"model":$("#model").val(),

						"brand":$("#brand").val(),

						"search":$("#search").val()

					});

				}

			},



			"order":[
				[0,"asc"]
			],



			"columns":[


				{
					data:'vehicle_reg_no'
				},

				{
					data:'vehicle_model'
				},

				{
					data:'vehicle_brand'
				},

				{
					data:'vehicle_type'
				},

				{
					data:'engine_no'
				},

				{
					data:'chassis_no'
				},

				{
					data:'mileage',
					className:'text-right',
					render:function(data){

						return Number(data).toLocaleString();

					}
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
					title:'Vehicle Full Detail Report'
				},


				{
					extend:'excel',
					className:'btn btn-success btn-sm',
					text:'<i class="fas fa-file-excel mr-2"></i> EXCEL',
					title:'Vehicle Full Detail Report'
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
					title:'Vehicle Full Detail Report'
				}


			]



		});


	});


});


</script>


<?php include "include/footer.php"; ?>