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
							<div class="page-header-icon"><i class="fas fa-users"></i></div>
							<span>Customer Job Details</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<form action="<?php echo base_url()?>Customerjobs/Customerjobsinsertupdate" method="post"
							autocomplete="off">
							<div class="row">
								<div class="col-6">
									<div class="row">
										<div class="col-6">
											<div class="form-group mb-1">
												<label class="small font-weight-bold text-dark">Job Name*</label>
												<input type="text" class="form-control form-control-sm" name="jobname" id="jobname"
													required>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group mb-1">
												<label class="small font-weight-bold text-dark">Job Code*</label>
												<input type="text" class="form-control form-control-sm" name="jobcode" id="jobcode"
													required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-6">
											<div class="form-group mb-1">
												<label class="small font-weight-bold text-dark">Unit Price*</label>
												<input type="number" class="form-control form-control-sm" name="unitprice" id="unitprice" value="0"
													step="any" required>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group mb-1">
												<label class="small font-weight-bold text-dark">UOM*</label>
												<select class="form-control form-control-sm" name="uom" id="uom" value="0" step="any">
													<option value="">Select</option>
													<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
													<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
														<?php echo $rowmeasurelist->measure_type ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
						
									<div class="form-row">
										<div class="col">
											<label class="font-weight-bold small"><b>Size Carton</b>:</label>
											<div class="form-row">
												<div class="col">
													<label for="sizeL" class="font-weight-bold small">L</label>
													<input type="number" name="sizeL" id="sizeL" class="form-control form-control-sm mt-2" >
												</div>
												<div class="col">
													<label for="sizeW" class="font-weight-bold small">W</label>
													<input type="number" name="sizeW" id="sizeW" class="form-control form-control-sm mt-2">
												</div>
												<div class="col">
													<label for="sizeH" class="font-weight-bold small">H</label>
													<input type="number" name="sizeH" id="sizeH" class="form-control form-control-sm mt-2" >
												</div>
											</div>
										</div>
										<div class="col">
											<label class="font-weight-bold small"><b>Size Label</b>:</label>
											<div class="form-row">
												<div class="col">
													<label for="sizelabelL" class="font-weight-bold small">L:</label>
													<input type="number" name="sizelabelL" id="sizelabelL" class="form-control form-control-sm mt-2">
												</div>
												<div class="col">
													<label for="sizelabelW" class="font-weight-bold small ">W:</label>
													<input type="number" name="sizelabelW" id="sizelabelW" class="form-control form-control-sm mt-2">
												</div>
											</div>
										</div>
									</div>
									
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Job Discription*</label>
										<textarea class="form-control" name="jobdiscription" id="jobdiscription"></textarea>
									</div>

									<!-- <div class="form-group mb-1">
										<label class="small font-weight-bold">Any other Instruction*</label>
										<textarea class="form-control" name="otherinstruction" id="otherinstruction"></textarea>
									</div> -->

									<br>
								
									<div class="form-group mt-2 text-right">
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"><i
												class="far fa-save"></i>&nbsp;Add</button>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
									<input type="hidden" name="customerid" id="customerid" value="<?php echo $Customerbankdetails ?>">
									<input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $Customerbankdetails ?>">
								</div>

								<div class="col-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="card m-0">
                                        <div class="card-header p-2" id="headingOne">
                                            <h5 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    Material Section
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
												<div class="form-row">
													<div class="col-6">
														<lable class="font-weight-bold small">Printing Format Section*</lable>
														<select name="cutmaterial" id="cutmaterial"
															class="form-control form-control-sm mt-2">
															<option value="">Select</option>
															<?php foreach ($printingformatlist->result() as $rowprintingformatlist) { ?>
																<option value="<?php echo $rowprintingformatlist->idtbl_printing_format ?>">
																	<?php echo $rowprintingformatlist->format_name ?> - 
																	<?php echo $rowprintingformatlist->printing_width ?>mm X <?php echo $rowprintingformatlist->printing_height ?>mm</option> <?php } ?>
														</select>
													</div>
											    </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <lable class="font-weight-bold small">Paper / Board*</lable>
                                                        <select name="paperboard" id="paperboard"
                                                            class="form-control form-control-sm mt-2">
                                                            <option value="">Select</option>
                                                            <?php foreach ($materiallist->result() as $rowmaterial) { ?>
                                                                <option value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
                                                                    <?php echo $rowmaterial->materialname ?></option> <?php } ?>

                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <lable class="font-weight-bold small">Cutting Size*</lable>
														<div class="row">
															<div class="col-5">
															   <input type="number" step="any" name="cutsize1" id="cutsize1" class="form-control form-control-sm mt-2">
															</div>
															<div class="col-2">
															<lable style="margin-top:20px;">X</lable>
															</div>
															<div class="col-5">
														    	<input type="number" step="any" name="cutsize2" id="cutsize2" class="form-control form-control-sm mt-2">
															</div>
														</div>
                                                    </div>
													<div class="col">
                                                        <lable class="font-weight-bold small">No of Ups*</lable>
                                                        <input type="number" name="noups" id="noups"
                                                            class="form-control form-control-sm mt-2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card m-0">
                                        <div class="card-header p-2" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left p-0 btn-sm text-decoration-none text-dark collapsed"
                                                    type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    Color Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-parent="#accordionExample" >
                                            <div class="card-body p-2">
												<div class="form-row">
														<div class="col-6">
															<lable class="font-weight-bold small">Printing Color*</lable>
															<select name="printingcolor" id="printingcolor"
																class="form-control form-control-sm mt-2">
																<option value="">Select Color</option>
																<?php foreach ($colorlist->result() as $rowcolorlist) { ?>
                                                                <option value="<?php echo $rowcolorlist->idtbl_print_color ?>">
                                                                    <?php echo $rowcolorlist->color_name ?></option> <?php } ?>

															</select>
														</div>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card m-0">
                                        <div class="card-header p-2" id="headingFive">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseFive"
                                                    aria-expanded="false" aria-controls="collapseFive">
                                                    Coating Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
											    <div class="form-row">
											 			<div class="col-6">
															<lable class="font-weight-bold small">Varnish*</lable>
															<select name="coatingvarnish" id="coatingvarnish"
																class="form-control form-control-sm mt-2">
																<option value="">Select Varnish</option>
																<?php foreach ($varnishlist->result() as $rowvarnishlist) { ?>
                                                                <option value="<?php echo $rowvarnishlist->idtbl_varnish ?>">
                                                                    <?php echo $rowvarnishlist->varnish ?></option> <?php } ?>
															</select>
														</div>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                     
									<div class="card m-0">
                                        <div class="card-header p-2" id="headingThree">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    Lamination Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
                                                    <div class="form-row">
                                                    	<div class="col-6">
                                                    		<lable class="font-weight-bold small">Lamination*</lable>
                                                    		<select name="laminations" id="laminations"
                                                    			class="form-control form-control-sm mt-2">
                                                    			<option value="">Select Lamination</option>
																<?php foreach ($laminationlist->result() as $rowlaminationlist) { ?>
                                                                <option value="<?php echo $rowlaminationlist->idtbl_lamination ?>">
                                                                    <?php echo $rowlaminationlist->lamination ?></option> <?php } ?>
                                                    		</select>
                                                    	</div>
                                                         	<div class="col form-check" style="margin-top:35px; margin-left:40px;">
																<input type="checkbox" class="form-check-input" name="lam_option" id="lam_oneside" value="One Side">
																<label class="form-check-label" for="lam_oneside">One Side</label>
															</div>
															<div class="col form-check" style="margin-top:35px;">
																<input type="checkbox" class="form-check-input" name="lam_option" id="lam_bothside" value="Both Side">
																<label class="form-check-label" for="lam_bothside">Both Side</label>
															</div>
                                                    </div>
                                                        <br>
                                                    <div class="form-row">
                                                        <div class="col-4">
                                                            <lable class="font-weight-bold small">Film Size*</lable>
                                                            <input type="text" name="filmsize" id="filmsize"
                                                                class="form-control form-control-sm mt-2">
                                                        </div>
														<div class="col-4">
                                                            <lable class="font-weight-bold small">Micron*</lable>
                                                            <input type="text" name="micron" id="micron"
                                                                class="form-control form-control-sm mt-2">
                                                        </div>
                                                    </div>    
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card m-0">
                                        <div class="card-header p-2" id="headingFive">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseSix"
                                                    aria-expanded="false" aria-controls="collapseSix">
                                                    Other Finishing Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseSix" class="collapse" aria-labelledby="headingFive"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
											       <div class="form-row">
														<div class="col-6">
																<lable class="font-weight-bold small">Foiling*</lable>
																<select name="foiling" id="foiling"
																	class="form-control form-control-sm mt-2">
																	<option value="">Select Foiling</option>
																	<?php foreach ($foilinglist->result() as $rowfoilinglist) { ?>
                                                                <option value="<?php echo $rowfoilinglist->idtbl_foiling ?>">
                                                                    <?php echo $rowfoilinglist->foiling ?></option> <?php } ?>
																</select>
															</div>
                                                    </div>
													<div class="form-row">
                                                    	<div class="col-4">
                                                    		<lable class="font-weight-bold small">Rimming*</lable>
                                                    		<select name="rimming" id="rimming"
                                                    			class="form-control form-control-sm mt-2">
                                                    			<option value="">Select Rimming</option>
																<?php foreach ($rimminglist->result() as $rowrimminglist) { ?>
                                                                <option value="<?php echo $rowrimminglist->idtbl_rimming ?>">
                                                                    <?php echo $rowrimminglist->rimming ?></option> <?php } ?>
                                                    		</select>
                                                    	</div>
                                                    	<div class="col form-check" style="margin-top:35px; margin-left:40px;">
                                                    		<input type="checkbox" class="form-check-input"
                                                    			name="rimm_option" id="rimm_oneside" value="One Side">
                                                    		<label class="form-check-label" for="lam_oneside">One
                                                    			Side</label>
                                                    	</div>
                                                    	<div class="col form-check" style="margin-top:35px;">
                                                    		<input type="checkbox" class="form-check-input"
                                                    			name="rimm_option" id="rimm_bothside" value="Both Side">
                                                    		<label class="form-check-label" for="rimm_bothside">Both
                                                    			Side</label>
                                                    	</div>
														<div class="col">
                                                            <lable class="font-weight-bold small">Length*</lable>
                                                            <input type="text" name="rimm_length" id="rimm_length"
                                                                class="form-control form-control-sm mt-2">
                                                        </div>
                                                    </div>
													<div class="form-row">
														<div class="col-6">
															<lable class="font-weight-bold small">others*</lable>
															<select name="otherfinish" id="otherfinish" class="form-control form-control-sm mt-2">
																<option value="">Select others</option>
																<?php foreach ($otherfinishinglist->result() as $rowotherfinishinglist) { ?>
                                                                <option value="<?php echo $rowotherfinishinglist->idtbl_finishing_other ?>">
                                                                    <?php echo $rowotherfinishinglist->finishing_other ?></option> <?php } ?>
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="col">
															<lable class="font-weight-bold small">Window Patching Film Size*</lable>
															<div class="row">
																<div class="col-6">
																<lable class="font-weight-bold small">L</lable>
																	<input type="number" step="any" name="pachingl" id="pachingl" class="form-control form-control-sm mt-2">
																</div>
																<div class="col-6">
																<lable class="font-weight-bold small">W</lable>
																	<input type="number" step="any" name="pachingw" id="pachingw" class="form-control form-control-sm mt-2">
																</div>
															</div>
														</div>
														<div class="col" style="margin-top:25px;">
															<lable class="font-weight-bold small">Micron*</lable>
															<input type="text" name="patchmicron" id="patchmicron" class="form-control form-control-sm mt-2">
														</div>
													</div>
                                            </div>
                                        </div>
                                    </div>

									<div class="card m-0">
                                        <div class="card-header p-2" id="headingFour">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    Die Cutting & Pasting Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
                                                <div class="form-row">
												        <div class="col-6">
															<lable class="font-weight-bold small">Die Cutting*</lable>
															<select name="diecutting" id="diecutting" class="form-control form-control-sm mt-2">
																<option value="">Select</option>
																<?php foreach ($diecuttinglist->result() as $rowdiecuttinglist) { ?>
                                                                <option value="<?php echo $rowdiecuttinglist->idtbl_diecutting ?>">
                                                                    <?php echo $rowdiecuttinglist->diecutting_name ?></option> <?php } ?>
															</select>
														</div>
                                                </div>
												<div class="form-row">
												        <div class="col-6">
															<lable class="font-weight-bold small">Pasting*</lable>
															<select name="pasting" id="pasting" class="form-control form-control-sm mt-2">
																<option value="">Select</option>
																<?php foreach ($pastinglist->result() as $rowpastinglist) { ?>
                                                                <option value="<?php echo $rowpastinglist->idtbl_pasting ?>">
                                                                    <?php echo $rowpastinglist->pasting_name ?></option> <?php } ?>
															</select>
														</div>
														<div class="col-6">
                                                            <lable class="font-weight-bold small">Adhesives Name*</lable>
                                                            <input type="text" name="Adhesivesname" id="Adhesivesname"
                                                                class="form-control form-control-sm mt-2">
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card m-0">
                                        <div class="card-header p-2" id="headingseven">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseseven"
                                                    aria-expanded="false" aria-controls="collapseseven">
                                                    Bindery Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseseven" class="collapse" aria-labelledby="headingseven"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
											        <div class="form-row">
												        <div class="col-6">
															<lable class="font-weight-bold small">Bindery*</lable>
															<select name="bindery" id="bindery" class="form-control form-control-sm mt-2">
																<option value="">Select</option>
																<?php foreach ($binderylist->result() as $rowbinderylist) { ?>
                                                                <option value="<?php echo $rowbinderylist->idtbl_bindery ?>">
                                                                    <?php echo $rowbinderylist->bindery_name ?></option> <?php } ?>
															</select>
														</div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="card m-0">
                                        <div class="card-header p-2" id="headingeight">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
                                                    type="button" data-toggle="collapse" data-target="#collapseeight"
                                                    aria-expanded="false" aria-controls="collapseeight">
													Delivery Section
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseeight" class="collapse" aria-labelledby="headingeight"
                                            data-parent="#accordionExample">
                                            <div class="card-body p-2">
                                                    <div class="form-row">
                                                        <div class="col-4">
                                                            <div class="col-12 form-check"
                                                                style="margin-top:20px; margin-left:70px;">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="delivery_option" id="bycustomer" value="By Customer">
                                                                <label class="form-check-label" for="bycustomer">By Customer</label>
                                                            </div>
                                                            <div class="col-12 form-check" style="margin-left:70px;">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="delivery_option" id="byus" value="By Us">
                                                                <label class="form-check-label" for="byus">By Us</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                    <br>
                            </div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-bordered table-striped table-sm nowrap" id="tblsupplierbank">
									<thead>
										<tr>
											<th>#</th>
											<th>Job Name</th>
											<th>Job Code</th>
											<th>UOM</th>
											<th>Unit Price</th>
											<th class="text-right">Actions</th>
										</tr>
									</thead>
								</table>
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

		$('#tblsupplierbank').DataTable({
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
					title: 'Customer Job Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Customer Job Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Customer Job Information',
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
				url: "<?php echo base_url() ?>scripts/customerjoblist.php",
				type: "POST", // you can use GET
				data: function (d) {
					return $.extend({}, d, {
						"customer": $("#hiddenid").val()
					});
				}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_customer_job_details"
				},
				{
					"data": "job_name"
				},
				{
					"data": "job_code"
				},
				{
					"data": "measure_type"
				},
				{
					"data": "unitprice"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1" id="' +
							full['idtbl_customer_job_details'] +
							'"><i class="fas fa-pen"></i></button>';

						if (full['status'] == 1) {
							button +=
								'<a href="<?php echo base_url() ?>Customerjobs/Customerjobsstatus/' +
								full['idtbl_customer_job_details'] + '/' + full[
									'tbl_customer_idtbl_customer'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 "><i class="fas fa-check"></i></a>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Customerjobs/Customerjobsstatus/' +
								full['idtbl_customer_job_details'] + '/' + full[
									'tbl_customer_idtbl_customer'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1"><i class="fas fa-times"></i></a>';
						}
						button +=
							'<a href="<?php echo base_url() ?>Customerjobs/Customerjobsstatus/' +
							full['idtbl_customer_job_details'] + '/' + full[
								'tbl_customer_idtbl_customer'] +
							'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#tblsupplierbank tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Customerjobs/Customerjobsedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#jobname').val(obj.job_name);
						$('#jobcode').val(obj.job_code);
						$('#uom').val(obj.measure_type_id);
					    $('#unitprice').val(obj.unitprice);

						$('#sizeL').val(obj.carton_L);
						$('#sizeW').val(obj.carton_W);
						$('#sizeH').val(obj.carton_H);
						$('#sizelabelL').val(obj.Label_L);
						$('#sizelabelW').val(obj.label_W);
						$('#jobdiscription').val(obj.job_discription);

						$('#cutmaterial').val(obj.idtbl_printing_format);
						$('#paperboard').val(obj.idtbl_print_material_info);
						$('#cutsize1').val(obj.cutsize_W);
						$('#cutsize2').val(obj.cutsize_H);
						$('#noups').val(obj.no_of_ups);
						$('#printingcolor').val(obj.idtbl_print_color);
						$('#coatingvarnish').val(obj.idtbl_varnish);

						$('#laminations').val(obj.idtbl_lamination);
						$('#filmsize').val(obj.lamination_filmsize);
						$('#micron').val(obj.lamination_micron);

						let lamOptionValue = obj.printside; 
						$('input[name="lam_option"]').prop('checked', false);
						if (lamOptionValue === 'One Side') {
							$('#lam_oneside').prop('checked', true);
						} else if (lamOptionValue === 'Both Side') {
							$('#lam_bothside').prop('checked', true);
                        }

						$('#foiling').val(obj.idtbl_foiling);
						$('#rimming').val(obj.idtbl_rimming);
						$('#rimm_length').val(obj.rimming_length);
						$('#otherfinish').val(obj.idtbl_finishing_other);
						$('#pachingl').val(obj.windowpatch_L);
						$('#pachingw').val(obj.windowpatch_W);
						$('#patchmicron').val(obj.windowpatch_micron);

						let RammingOptionValue = obj.rimming_side; 
						$('input[name="rimm_option"]').prop('checked', false);
						if (RammingOptionValue === 'One Side') {
							$('#rimm_oneside').prop('checked', true);
						} else if (RammingOptionValue === 'Both Side') {
							$('#rimm_bothside').prop('checked', true);
                        }

						$('#diecutting').val(obj.idtbl_diecutting);
						$('#pasting').val(obj.idtbl_pasting);
						$('#Adhesivesname').val(obj.adhesive_name);
						$('#bindery').val(obj.idtbl_bindery);

						let deliveryOptionValue = obj.delivery_by; 
						$('input[name="delivery_option"]').prop('checked', false);
						if (deliveryOptionValue === 'By Customer') {
							$('#bycustomer').prop('checked', true);
						} else if (deliveryOptionValue === 'By Us') {
							$('#byus').prop('checked', true);
                        }



						
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
