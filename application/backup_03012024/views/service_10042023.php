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
							<span>Service Details</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<form action="<?php echo base_url() ?>Service/serviceinsertupdate" method="post"
							autocomplete="off" enctype="multipart/form-data">
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Service Date*</label>
										<input type="date" class="form-control form-control-sm" name="servicedate"
											id="servicedate" value="<?php echo date("Y-m-d"); ?>" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group">
										<label class="small font-weight-bold">Vehicle Reg NO*</label>
										<select class="form-control form-control-sm" name="vehicleregno"
											id="vehicleregno" onchange="getmileage();" required>
											<option value="">Select</option>
											<?php foreach ($VehicleRegNo->result() as $rowvehicleregno) { ?>
											<option value="<?php echo $rowvehicleregno->idtbl_vehicle ?>">
												<?php echo $rowvehicleregno->vehicle_reg_no ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Service Location*</label>
										<input type="text" class="form-control form-control-sm" name="servicelocation"
											id="servicelocation" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Next Service Date*</label>
										<input type="date" class="form-control form-control-sm" name="nextservicedate"
											id="nextservicedate"
											value="<?php echo date("Y-m-d", strtotime(" +12months")); ?>"
											required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Discription*</label>
										<input type="text" rows="4" cols="50" class="form-control form-control-sm"
											name="discription" id="discription" required>
									</div>
								</div>

                                <div class="col-3">
                                <div class="form-group">
                                        <label class="small font-weight-bold">Supplier*</label>
                                        <select class="form-control form-control-sm" name="supplier" id="supplier" required>
                                            <option value="">Select</option>
                                            <?php foreach ($Supplier->result() as $rowsupplier) { ?>
                                            <option value="<?php echo $rowsupplier->idtbl_supplier ?>"><?php echo $rowsupplier->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </div>

                                    <div class="col-3">
                                <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Current Mileage*</label>
										<input type="text" rows="4" cols="50" class="form-control form-control-sm"
											name="currentmileage" id="currentmileage" required readonly>
                                    </div>
                                    </div>

                                    <div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Next Service Mileage (Km)*</label>
										<input type="number" rows="4" cols="50" class="form-control form-control-sm"
											name="mileage" id="mileage" value="0" onkeyup="calculation();" required>
									</div>
								</div>
                            </div>
                            <div class="row">
								<div class="col-6">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Bill*</label>
										<div class="filebody">
											<div class="fileuploadcard">
												<div class="top">
													<p>Drag & drop image uploading</p>
												
												</div>
												<div class="drag-area">
													<span class="visible">
														Drag & drop image here or
														<span class="select" role="button">Browse</span>
													</span>
													<span class="on-drop">Drop images here</span>
													<input name="files[]" type="file" class="file" multiple />
												</div>

												<!-- IMAGE PREVIEW CONTAINER -->
												<div class="container"></div>
											</div>
										</div>

									</div>
								</div>

                                <div class="col-3"></div>
                                <div class="col-3">
									<div class="form-group mb-1">	
										<input type="text" rows="4" cols="50" class="form-control form-control-sm"
											name="nextservicemileage" id="nextservicemileage" value="0" readonly >
									</div>
								</div>
							</div>

							<div class="form-group mt-5 text-right">
								<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
									<?php if($addcheck==0){echo 'disabled';} ?>>
									<i class="far fa-save"></i>&nbsp;Add</button>
							</div>
							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
						</form>
					</div>
					<div class="container-fluid mt-2 p-0 p-2">
						<div class="card">
							<div class="card-body p-0 p-2">
								<div class="row">
									<div class="col-12">
										<div class="scrollbar pb-3" id="style-2">
											<table class="table table-bordered table-striped table-sm nowrap"
												id="dataTable">
												<thead>
													<tr>
														<th>#</th>
														<th>SERVICE DATE</th>
														<th>VEHICLE REG NO</th>
														<th>SERVICE LOCATION</th>
                                                        <th>SUPPLIER</th>
														<th>NEXT SERVICE DATE</th>
														<th>DISCRIPTION</th>

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
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		$('#dataTable').DataTable({
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
					title: 'Service Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Service Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Service  Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function (win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'copy', 'csv', 'excel', 'pdf', 'print'
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/servicelist.php",
				type: "POST", // you can use GET
				// data: function(d) { }
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_service"
				},
				{
					"data": "service_date"
				},
				{
					"data": "vehicle_reg_no"
				},
				{
					"data": "service_location"
				},
				{
                    "data": "name"
                },
				{
					"data": "next_service_date"
				},
				{
					"data": "discription"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href="<?php echo base_url() ?>Servicesitem/index/' + full[
								'idtbl_service'] +
							'" target="_self" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-file"></i></a>';

                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_service']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Service/servicestatus/'+full['idtbl_service']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Service/servicestatus/'+full['idtbl_service']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Service/servicestatus/'+full['idtbl_service']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
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
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Service/serviceedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#servicedate').val(obj.servicedate); 
                        $('#vehicleregno').val(obj.vehicleregno); 
                        $('#servicelocation').val(obj.servicelocation); 
                        $('#nextservicedate').val(obj.nextservicedate); 
                        $('#discription').val(obj.discription); 
						$('#supplier').val(obj.supplier); 
						$('#currentmileage').val(obj.currentmileage); 
						$('#mileage').val(obj.mileage); 
						$('#nextservicemileage').val(obj.nextservicemileage); 
                        // $('#bill').val(obj.bill); 
                       // $('#comment').val(obj.comment); 
					  
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

<script>
	/** Variables */
	let files = [],
		dragArea = document.querySelector('.drag-area'),
		input = document.querySelector('.drag-area input'),
		button = document.querySelector('.card button'),
		select = document.querySelector('.drag-area .select'),
		container = document.querySelector('.container');

	/** CLICK LISTENER */
	select.addEventListener('click', () => input.click());

	/* INPUT CHANGE EVENT */
	input.addEventListener('change', () => {
		let file = input.files;

		// if user select no image
		if (file.length == 0) return;

		for (let i = 0; i < file.length; i++) {
			if (file[i].type.split("/")[0] != 'image') continue;
			if (!files.some(e => e.name == file[i].name)) files.push(file[i])
		}

		showImages();
	});

	/** SHOW IMAGES */
	function showImages() {
		container.innerHTML = files.reduce((prev, curr, index) => {
			return `${prev}
		    <div class="image">
			    <span onclick="delImage(${index})">&times;</span>
			    <img src="${URL.createObjectURL(curr)}" />
			</div>`
		}, '');
	}

	/* DELETE IMAGE */
	function delImage(index) {
		files.splice(index, 1);
		showImages();
	}

	/* DRAG & DROP */
	dragArea.addEventListener('dragover', e => {
		e.preventDefault()
		dragArea.classList.add('dragover')
	})

	/* DRAG LEAVE */
	dragArea.addEventListener('dragleave', e => {
		e.preventDefault()
		dragArea.classList.remove('dragover')
	});

	/* DROP EVENT */
	dragArea.addEventListener('drop', e => {
		e.preventDefault()
		dragArea.classList.remove('dragover');

		let file = e.dataTransfer.files;
		for (let i = 0; i < file.length; i++) {
			/** Check selected file is image */
			if (file[i].type.split("/")[0] != 'image') continue;

			if (!files.some(e => e.name == file[i].name)) files.push(file[i])
		}
		showImages();
	});

</script>
<script>
     function calculation() {
            
            var currentmileage=parseFloat($("#currentmileage").val());
        	var mileage = parseFloat($("#mileage").val());

        	if (!(currentmileage || mileage) == "") {
        		var nextservicemileage = currentmileage + mileage
        		$("#nextservicemileage").val(nextservicemileage.toFixed(2));
            }
            }


		function getmileage(){
			var vehicleregno = $("#vehicleregno").val();
			if(!vehicleregno==""){
				$.ajax({
                    type: "POST",
                    data: {
                     recordID:vehicleregno
                    },
                    url: '<?php echo base_url() ?>Service/mileage',
                    success: function (result) {
                        var obj = JSON.parse(result);
                        $('#currentmileage').val(obj.currentmileage);              
                    }
                });
			}
			else{
				$('#currentmileage').val('0'); 
				$('#mileage').val('0'); 
				$('#nextservicemileage').val('0'); 
			}
			
		}
</script>


<?php include "include/footer.php"; ?>
