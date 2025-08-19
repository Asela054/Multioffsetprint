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
							<span>Job Card Allocation</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-7">
								<div class="accordion" id="accordionExample">
									<div class="card m-0">
										<div class="card-header p-2" id="JobSection">
											<h5 class="mb-0">
												<button
													class="btn btn-link btn-block text-left p-0 btn-sm text-decoration-none text-dark"
													type="button" data-toggle="collapse" data-target="#collapseJob"
													aria-expanded="true" aria-controls="collapseJob">
													Job Section
												</button>
											</h5>
										</div>
										<div id="collapseJob" class="collapse show" aria-labelledby="JobSection"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<div class="form-row">
													<div class="form-group col mb-1">
														<label class="font-weight-bold small">Customer*</label>
														<select class="form-control form-control-sm selecter2 px-0"
															name="customer" id="customer" required>
															<option value="">Select</option>
															<?php foreach($customerlist->result() as $rowcustomerlist){ ?>
															<option
																value="<?php echo $rowcustomerlist->idtbl_customer ?>">
																<?php echo $rowcustomerlist->name ?>
															</option>
															<?php } ?>
														</select>
													</div>
													<div class="form-group col mb-1">
														<label class="small font-weight-bold text-dark">Job*</label>
														<select class="form-control form-control-sm selecter2 px-0"
															name="job" id="job" required>
															<option value="">Select</option>
														</select>
													</div>
													<div class="form-group col mb-1">
														<label class="small font-weight-bold text-dark">Qty*</label>
														<input type="text"
															class="form-control form-control-sm selecter2 px-0"
															name="jobqty" id="jobqty" readonly>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col mb-1">
														<label
															class="small font-weight-bold text-dark">Description*</label>
														<textarea class="form-control" id="jobdescription"
															name="jobdescription" rows="3"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
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
										<div id="collapseOne" class="collapse" aria-labelledby="headingOne"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<form method="post" autocomplete="off" id="materialform">
													<div class="form-row">
														<div class="col-6">
															<lable class="font-weight-bold small">Printing Format
																Section*</lable>
															<select name="printingformat" id="printingformat"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select</option>
																<?php foreach ($printingformatlist->result() as $rowprintingformatlist) { ?>
																<option
																	value="<?php echo $rowprintingformatlist->idtbl_printing_format ?>">
																	<?php echo $rowprintingformatlist->format_name ?>
																	-
																	<?php echo $rowprintingformatlist->printing_width ?>mm
																	X
																	<?php echo $rowprintingformatlist->printing_height ?>mm
																</option> <?php } ?>
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="col mt-2">
															<lable class="font-weight-bold small">Paper / Board*
															</lable>
															<select name="paperboard" id="paperboard"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select</option>
																<?php foreach ($materiallist->result() as $rowmaterial) { ?>
																<option
																	value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
																	<?php echo $rowmaterial->materialname ?>
																</option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="col">
															<lable class="font-weight-bold small">Cutting Size*
															</lable>
															<input type="number" step="any" name="cutsize" id="cutsize"
																class="form-control form-control-sm mt-2" required>
														</div>
														<div class="col">
															<lable class="font-weight-bold small">Sheets*</lable>
															<input type="number" step="any" name="paperSheetsQty"
																id="paperSheetsQty"
																class="form-control form-control-sm mt-2" required>
														</div>
													</div>
													<div class="form-row mt-2">
														<button type="button" id="btnMaterialSubmit"
															class="btn btn-primary btn-sm px-4 ml-auto mr-1"
															<?php if($addcheck==0){echo 'disabled';} ?>>
															<i class="far fa-save"></i>&nbsp;Add
														</button>
														<input type="submit" class="d-none" id="hiddenmaterialsubmit">
													</div>
												</form>
												<div class="form-row mt-3 ml-1 mr-2">
													<table
														class="table table-bordered table-striped table-sm nowrap w-100"
														id="tblMaterialDetails">
														<thead>
															<tr>
																<th>Format</th>
																<th>Material</th>
																<th>Cut Size</th>
																<th>BOM Sheets</th>
																<th>Required Sheets</th>
																<th>Batches</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<!-- <div class="card m-0">
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
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<div class="form-row">
													<div class="col-6">
														<lable class="font-weight-bold small">Printing Color*
														</lable>
														<select name="printingcolor" id="printingcolor"
															class="form-control form-control-sm mt-2">
															<option value="">Select Color</option>
															<?php foreach ($colorlist->result() as $rowcolorlist) { ?>
															<option value="<?php echo $rowcolorlist->idtbl_color ?>">
																<?php echo $rowcolorlist->color ?></option>
															<?php } ?>

														</select>
													</div>
												</div>
											</div>
										</div>
									</div> -->
									<div class="card m-0">
										<div class="card-header p-2" id="headingThree">
											<h2 class="mb-0">
												<button
													class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
													type="button" data-toggle="collapse" data-target="#collapseFive"
													aria-expanded="false" aria-controls="collapseFive">
													Coating Section
												</button>
											</h2>
										</div>
										<div id="collapseFive" class="collapse" aria-labelledby="headingThree"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<form method="post" autocomplete="off" id="varnishform">
													<div class="form-row mt-2">
														<div class="col">
															<lable class="font-weight-bold small">Varnish*</lable>
															<select name="coatingvarnish" id="coatingvarnish"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select Varnish</option>
																<?php foreach ($varnishlist->result() as $rowvarnishlist) { ?>
																<option
																	value="<?php echo $rowvarnishlist->idtbl_varnish ?>">
																	<?php echo $rowvarnishlist->varnish ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col">
															<lable class="font-weight-bold small">Sheets*</lable>
															<input type="number" step="any" name="varnishSheetsQty"
																id="varnishSheetsQty"
																class="form-control form-control-sm mt-2" required>
														</div>
													</div>
													<div class="form-row mt-2">
														<div class="col">
															<lable class="font-weight-bold small">Material*
															</lable>
															<select name="varnishmaterial" id="varnishmaterial"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select</option>
																<?php foreach ($materiallist->result() as $rowmaterial) { ?>
																<option
																	value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
																	<?php echo $rowmaterial->materialname ?>
																</option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-row mt-2">
														<button type="button" id="btnVarnishSubmit"
															class="btn btn-primary btn-sm px-4 ml-auto mr-1"
															<?php if($addcheck==0){echo 'disabled';} ?>>
															<i class="far fa-save"></i>&nbsp;Add
														</button>
														<input type="submit" class="d-none" id="hiddenvarnishsubmit">
													</div>
												</form>
												<div class="form-row mt-3 ml-1 mr-2">
													<table
														class="table table-bordered table-striped table-sm nowrap w-100"
														id="tblCoatingDetails">
														<thead>
															<tr>
																<th>Varnish</th>
																<th>Material</th>
																<th>Sheets</th>
																<th>Required Sheets</th>
																<th>Batches</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

									<div class="card m-0">
										<div class="card-header p-2" id="headingFour">
											<h2 class="mb-0">
												<button
													class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
													type="button" data-toggle="collapse" data-target="#collapseThree"
													aria-expanded="false" aria-controls="collapseThree">
													Lamination Section
												</button>
											</h2>
										</div>
										<div id="collapseThree" class="collapse" aria-labelledby="headingFour"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<form method="post" autocomplete="off" id="laminationform">
													<div class="form-row">
														<div class="col-6">
															<lable class="font-weight-bold small">Lamination*</lable>
															<select name="laminations" id="laminations"
																class="form-control form-control-sm mt-2">
																<option value="">Select Lamination</option>
																<?php foreach ($laminationlist->result() as $rowlaminationlist) { ?>
																<option
																	value="<?php echo $rowlaminationlist->idtbl_lamination ?>">
																	<?php echo $rowlaminationlist->lamination ?>
																</option> <?php } ?>
															</select>
														</div>
														<div class="col form-check"
															style="margin-top:35px; margin-left:40px;">
															<input type="radio" class="form-check-input"
																name="laminationSide" id="lam_oneside" value="1">
															<label class="form-check-label" for="lam_oneside">One
																Side</label>
														</div>
														<div class="col form-check" style="margin-top:35px;">
															<input type="radio" class="form-check-input"
																name="laminationSide" id="lam_bothside" value="2">
															<label class="form-check-label" for="lam_bothside">Both
																Side</label>
														</div>
													</div>
													<br>
													<div class="form-row">
														<div class="col">
															<lable class="font-weight-bold small">Material*
															</lable>
															<select name="laminatingmaterial" id="laminatingmaterial"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select</option>
																<?php foreach ($materiallist->result() as $rowmaterial) { ?>
																<option
																	value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
																	<?php echo $rowmaterial->materialname ?>
																</option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="col">
															<lable class="font-weight-bold small">Film Size*</lable>
															<input type="text" name="filmsize" id="filmsize"
																class="form-control form-control-sm mt-2">
														</div>
														<div class="col">
															<lable class="font-weight-bold small">Micron*</lable>
															<input type="text" name="micron" id="micron"
																class="form-control form-control-sm mt-2">
														</div>
														<div class="col">
															<lable class="font-weight-bold small">Sheets*</lable>
															<input type="text" name="laminationSheets"
																id="laminationSheets"
																class="form-control form-control-sm mt-2">
														</div>
													</div>
													<div class="form-row mt-2">
														<button type="button" id="btnLaminationSubmit"
															class="btn btn-primary btn-sm px-4 ml-auto mr-1"
															<?php if($addcheck==0){echo 'disabled';} ?>>
															<i class="far fa-save"></i>&nbsp;Add
														</button>
														<input type="submit" class="d-none" id="hiddenlaminationsubmit">
													</div>
												</form>
												<div class="form-row mt-3 ml-1 mr-2">
													<table
														class="table table-bordered table-striped table-sm nowrap w-100"
														id="tblLaminationDetails">
														<thead>
															<tr>
																<th>Lamination</th>
																<th>Material</th>
																<th>Film Size</th>
																<th>Microne</th>
																<th>Sides</th>
																<th>BOM Sheets</th>
																<th>Required Sheets</th>
																<th>Batches</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
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
													Rimming Section
												</button>
											</h2>
										</div>
										<div id="collapseSix" class="collapse" aria-labelledby="headingFive"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<form method="post" autocomplete="off" id="rimmingForm">
													<div class="form-row">
														<div class="col-4">
															<lable class="font-weight-bold small">Rimming*</lable>
															<select name="rimming" id="rimming"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select Rimming</option>
																<?php foreach ($rimminglist->result() as $rowrimminglist) { ?>
																<option
																	value="<?php echo $rowrimminglist->idtbl_rimming ?>">
																	<?php echo $rowrimminglist->rimming ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col form-check"
															style="margin-top:35px; margin-left:40px;">
															<input type="radio" class="form-check-input"
																name="rimmingcheckbox" id="rimmingside" value="1">
															<label class="form-check-label" for="rimmingside">One
																Side</label>
														</div>
														<div class="col form-check" style="margin-top:35px;">
															<input type="radio" class="form-check-input"
																name="rimmingcheckbox" id="rimmingbothside" value="2">
															<label class="form-check-label" for="rimmingbothside">Both
																Side</label>
														</div>
													</div>
													<div class="form-row">
														<div class="col">
															<lable class="font-weight-bold small">Material*
															</lable>
															<select name="rimmingmaterial" id="rimmingmaterial"
																class="form-control form-control-sm mt-2" required>
																<option value="">Select</option>
																<?php foreach ($materiallist->result() as $rowmaterial) { ?>
																<option
																	value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
																	<?php echo $rowmaterial->materialname ?>
																</option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="col">
															<lable class="font-weight-bold small">Length*</lable>
															<input type="text" name="rimminglength" id="rimminglength"
																class="form-control form-control-sm mt-2" required>
														</div>
														<div class="col">
															<lable class="font-weight-bold small">Sheets*</lable>
															<input type="text" name="rimmingsheets" id="rimmingsheets"
																class="form-control form-control-sm mt-2" required>
														</div>
													</div>
													<div class="form-row mt-2">
														<button type="button" id="btnRimmingSubmit"
															class="btn btn-primary btn-sm px-4 ml-auto mr-1"
															<?php if($addcheck==0){echo 'disabled';} ?>>
															<i class="far fa-save"></i>&nbsp;Add
														</button>
														<input type="submit" class="d-none" id="hiddenrimmingsubmit">
													</div>
												</form>
												<div class="form-row mt-3 ml-1 mr-2">
													<table
														class="table table-bordered table-striped table-sm nowrap w-100"
														id="tblRimmingDetails">
														<thead>
															<tr>
																<th>Rimming Type</th>
																<th>Material</th>
																<th>Length</th>
																<th>Sides</th>
																<th>BOM Sheets</th>
																<th>Required Sheets</th>
																<th>Batches</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

									<div class="card m-0">
										<div class="card-header p-2" id="headingSix">
											<h2 class="mb-0">
												<button
													class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
													type="button" data-toggle="collapse" data-target="#collapseFour"
													aria-expanded="false" aria-controls="collapseFour">
													Die Cutting Section
												</button>
											</h2>
										</div>
										<div id="collapseFour" class="collapse" aria-labelledby="headingSix"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<form method="post" autocomplete="off" id="dieCuttingForm">
													<div class="form-row mb-3">
														<div class="col-6 form-group">
															<label class="font-weight-bold small">Qty*</label>
															<input type="text" name="dieCuttingQty" id="dieCuttingQty"
																class="form-control form-control-sm" required>
														</div>
													</div>
													<div class="form-row">
														<div class="col form-group d-flex align-items-center">
															<input type="checkbox" name="diecuttingOption"
																id="perforation" value="1">
															<label class="form-check-label ml-2"
																for="perforation">Perforation</label>
														</div>
														<div class="col form-group d-flex align-items-center">
															<input type="checkbox" name="diecuttingOption"
																id="halfcutting" value="1">
															<label class="form-check-label ml-2" for="halfcutting">Half
																Cutting</label>
														</div>
														<div class="col form-group d-flex align-items-center">
															<input type="checkbox" name="diecuttingOption"
																id="fullcutting" value="1">
															<label class="form-check-label ml-2" for="fullcutting">Full
																Cutting</label>
														</div>
													</div>
													<div class="form-row mt-2">
														<button type="button" id="btnDieCuttingSubmit"
															class="btn btn-primary btn-sm px-4 ml-auto mr-1"
															<?php if($addcheck==0){echo 'disabled';} ?>>
															<i class="far fa-save"></i>&nbsp;Add
														</button>
														<input type="submit" class="d-none" id="hiddendiecuttingsubmit">
													</div>
												</form>
												<div class="form-row mt-3 ml-1 mr-2">
													<table
														class="table table-bordered table-striped table-sm nowrap w-100"
														id="tblDieCuttingDetails">
														<thead>
															<tr>
																<th>BOM Qty</th>
																<th>Required Qty</th>
																<th>Perforation</th>
																<th>Half Cutting</th>
																<th>Full Cutting</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

									<!-- <div class="card m-0">
										<div class="card-header p-2" id="headingSeven">
											<h2 class="mb-0">
												<button
													class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
													type="button" data-toggle="collapse" data-target="#collapseseven"
													aria-expanded="false" aria-controls="collapseseven">
													Bindery Section
												</button>
											</h2>
										</div>
										<div id="collapseseven" class="collapse" aria-labelledby="headingSeven"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<div class="form-row">
													<div class="col-6">
														<lable class="font-weight-bold small">Bindery*</lable>
														<select name="bindery" id="bindery"
															class="form-control form-control-sm mt-2">
															<option value="">Select</option>
															<?php foreach ($binderylist->result() as $rowbinderylist) { ?>
															<option
																value="<?php echo $rowbinderylist->idtbl_bindery ?>">
																<?php echo $rowbinderylist->bindery_name ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card m-0">
										<div class="card-header p-2" id="headingEight">
											<h2 class="mb-0">
												<button
													class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark"
													type="button" data-toggle="collapse" data-target="#collapseeight"
													aria-expanded="false" aria-controls="collapseeight">
													Delivery Section
												</button>
											</h2>
										</div>
										<div id="collapseeight" class="collapse" aria-labelledby="headingEight"
											data-parent="#accordionExample">
											<div class="card-body p-2">
												<div class="form-row">
													<div class="col-4">
														<div class="col-12 form-check"
															style="margin-top:20px; margin-left:70px;">
															<input type="checkbox" class="form-check-input"
																name="delivery_option" id="bycustomer"
																value="By Customer">
															<label class="form-check-label" for="bycustomer">By
																Customer</label>
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
									</div> -->
									<div class="form-row mt-2">
										<button type="button" id="btnCreateJobCard"
											class="btn btn-primary btn-sm px-4 ml-auto mr-1"
											<?php if($addcheck==0){echo 'disabled';} ?>>
											<i class="far fa-save"></i>&nbsp;Create Job Card
										</button>
									</div>
								</div>
								<br>
							</div>
							<div class="col-5">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer</th>
												<th>Job</th>
												<th>Approved</th>
												<th>Stock Issued</th>
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

<!-- Job card view Modal -->
<div id="purchaseview">
	<div class="modal fade" id="printviewModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modalPrintBody">

				</div>
				<div class="modal-footer">
					<h5 class="modal-title" id="jobCardPrint"></h5>
					<button type="button" class="btn btn-danger" id="btnJobCardPrint">
						<i class="fas fa-print mr-1"></i>Print
					</button>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Modal Batch No List -->
<div class="modal fade" id="modalbatchno" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Material Issue Batch No</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="formbatchno">
							<div class="form-group">
								<label class="small font-weight-bold">Stock Batch No</label><br>
								<select class="form-control form-control-sm" name="batchnolist[]" id="batchnolist" style="width: 100%;" multiple required>
								</select>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitbatch" <?php if($addcheck==0){echo 'disabled';} ?>>Done</button>
								<input type="submit" id="hidesubmitbatch" class="d-none">
							</div>
							<input type="hidden" name="issuemateqty" id="issuemateqty">
							<input type="hidden" name="issueType" id="issueType" value = "0">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Grn view Modal -->
<div id="purchaseview">
	<div class="modal fade" id="grnviewModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-m">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Used Batch Numbers</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modalgrnBody">
					<div class="scrollbar pb-3" id="style-2">
						<table class="table table-bordered table-striped table-sm nowrap" id="BatchNoTbl">
							<thead>
								<tr>
									<th class="text-center">Batch No</th>
									<th class="text-center">Status</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>

				</div>
				<div class="modal-footer">
					<h5 class="modal-title" id="jobCardPrint"></h5>
					<input type="hidden" id="hiddencardid" name="hiddencardid">
					<button type="button" class="btn btn-danger" id="btnAddToAccounts">
						<i class="fas fa-exchange-alt mr-1"></i>Add to accounts
					</button>
				</div>
			</div>

		</div>
	</div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';
		var rowID;

		$('#batchnolist').select2();
		$("#batchnolist").on("select2:select", function (evt) {
			var element = evt.params.data.element;
			var $element = $(element);
			
			$element.detach();
			$(this).append($element);
			$(this).trigger("change");
		});
		$('#customer').select2({
			width: '100%',
		});
		$('#paperboard').select2({
			width: '100%',
		});

		$('#job').select2({
			width: '100%',
		});

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
					title: 'Location Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Location Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Location Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function (win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'csv', 'pdf', 'print'
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/jobcardlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_jobcard"
				},
				{
					"data": "name"
				},
				{
					"data": "job"
				},
				{
					"targets": -1,
					"className": 'text-center',
					"data": null,
					"render": function (data, type, full) {
						var html = '';
						if (full['approve_status'] == 1) {
							html += '<i class="fas fa-check text-success"></i>&nbsp;Yes';
						} else {
							html += '<i class="fas fa-times text-danger"></i>&nbsp;No';
						}
						return html;
					}
				},
				{
					"targets": -1,
					"className": 'text-center',
					"data": null,
					"render": function (data, type, full) {
						var html = '';
						if (full['stock_issue_status'] == 1) {
							html += '<i class="fas fa-check text-success"></i>&nbsp;Yes';
						} else {
							html += '<i class="fas fa-times text-danger"></i>&nbsp;No';
						}
						return html;
					}
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-primary btn-sm btnview mr-1" id="' +
							full['idtbl_jobcard'] + '"><i class="fas fa-eye"></i></button>';

						if (full['approve_status'] == 0) {
							button +=
								'<a href="<?php echo base_url() ?>JobCardAllocation/ApproveJobCard/' +
								full['idtbl_jobcard'] +
								'" onclick="return approve_confirm()" target="_self" title="Approve Job" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						} else {
							button +=
								'<button target="_self" class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
						}

						if (full['approve_status'] == 1) {
							if (full['stock_issue_status'] == 0 && full['approve_status'] == 1) {
								button +=
									'<a href="<?php echo base_url() ?>JobCardAllocation/IssueStock/' +
									full['idtbl_jobcard'] +
									'" onclick="return issue_stock_confirm()" title="Issue Stock" target="_self" class="btn btn-warning btn-sm mr-1 ';
								if (statuscheck != 1) {
									button += 'd-none';
								}
								button += '"><i class="fas fa-times"></i></a>';
							} else {
								button +=
									'<button target="_self" class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
							}
						}

						button +=
							'<button class="btn btn-secondary btn-sm btnInsertAccount mr-1" id="' +
							full['idtbl_jobcard'] +
							'"><i class="fas fa-exchange-alt"></i></button>';

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#customer').change(function () {
			var customerID = $(this).val();
			$('#job').empty();
			$('#job').prepend('<option value="" selected="selected">Select job</option>');
			$('#job').val(null).trigger('change');

			$.ajax({
				type: "POST",
				data: {
					recordID: customerID
				},
				url: 'JobCardAllocation/Getcustomerjobs',
				success: function (result) {
					//alert(result);
					// console.log(result);
					var obj = JSON.parse(result);
					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						html1 += '<option value="' + obj[i].job_id + '" ' +
							'data-inquiryId="' + obj[i].idtbl_customerinquiry_detail +
							'">';
						html1 += obj[i].job + ' / ' + obj[i].job_id;
						html1 += '</option>';
					});
					$('#job').empty().append(html1);
				}
			});
		});
		$('#job').change(function () {
			var inquiryId = $('#job').find(':selected').attr('data-inquiryId'); // Case-sensitive
			$.ajax({
				type: "POST",
				data: {
					recordID: inquiryId
				},
				url: 'JobCardAllocation/GetJobBOMDetails',
				success: function (result) {
					var obj = JSON.parse(result);
					$('#jobqty').val(obj.qty);

					var objLaminatingDetails = obj.laminationDetail;
					var objMaterialDetails = obj.materialDetail;
					var objRimmingDetails = obj.rimmingDetail;
					var objVarnishDetails = obj.varnishDetail;
					var objDiecuttingDetails = obj.diecuttingDetail;

					$.each(objLaminatingDetails, function (i, item) {
						$('#tblLaminationDetails > tbody:last').append(
							'<tr><td class="d-none">' +
							objLaminatingDetails[i]
							.tbl_lamination_idtbl_lamination +
							'</td><td class="d-none">' +
							objLaminatingDetails[i]
							.tbl_print_material_info_idtbl_print_material_info +
							'</td><td class="d-none">' +
							objLaminatingDetails[i].sides +
							'</td><td>' +
							objLaminatingDetails[i].lamination +
							'</td><td>' +
							objLaminatingDetails[i].materialname +
							'</td><td>' +
							objLaminatingDetails[i].filmsize +
							'</td><td>' +
							objLaminatingDetails[i].micron +
							'</td><td>' +
							(objLaminatingDetails[i].sides === '1' ? 'One Side' :
								'Double Sided') +
							'</td><td>' +
							objLaminatingDetails[i].lamination_qty +
							'</td><td>' +
							objLaminatingDetails[i].lamination_qty * obj.qty +
							'</td><td class="text-center"></td><td><button type="button" id="' +
							objLaminatingDetails[i]
							.tbl_lamination_idtbl_lamination +
							'" class="mr-1 btn btn-danger btn-sm float-right btnDeleteLamination"><i class="fa fa-trash"></i></button></td><td class="d-none">' +
							objLaminatingDetails[i]
							.tbl_lamination_idtbl_lamination +
							'</td></tr>'
						);
					});
					$.each(objMaterialDetails, function (i, item) {
						$('#tblMaterialDetails > tbody:last').append(
							'<tr><td class="d-none">' +
							objMaterialDetails[i].idtbl_printing_format +
							'</td><td class="d-none">' +
							objMaterialDetails[i]
							.tbl_print_material_info_idtbl_print_material_info +
							'</td><td>' +
							objMaterialDetails[i].format_name +
							'</td><td>' +
							objMaterialDetails[i].materialname +
							'</td><td>' +
							objMaterialDetails[i].cutsize +
							'</td><td class="text-center">' +
							objMaterialDetails[i].sheetqty +
							'</td><td class="text-center">' +
							objMaterialDetails[i].sheetqty * obj.qty +
							'</td><td class="text-center"></td><td><button type="button" id="' +
							objMaterialDetails[i]
							.tbl_print_material_info_idtbl_print_material_info +
							'" class=" mr-1 btn btn-danger btn-sm float-right btnDeleteMaterialtrash"><i class="fa fa-trash"></i></button></td><td class="d-none">' +
							objMaterialDetails[i]
							.tbl_print_material_info_idtbl_print_material_info +
							'</td></tr>'
						);
					});
					$.each(objRimmingDetails, function (i, item) {
						$('#tblRimmingDetails > tbody:last').append(
							'<tr><td class="d-none">' +
							objRimmingDetails[i].tbl_rimming_idtbl_rimming +
							'</td><td class="d-none">' +
							objRimmingDetails[i].tbl_print_material_info_idtbl_print_material_info +
							'</td><td class="d-none">' +
							objRimmingDetails[i].sides +
							'</td><td>' +
							objRimmingDetails[i].rimming +
							'</td><td>' +
							objRimmingDetails[i].materialname +
							'</td><td>' +
							objRimmingDetails[i].length +
							'</td><td>' +
							(objRimmingDetails[i].sides === '1' ? 'One Side' :
							'Double Sided') +
							'</td><td>' +
							objRimmingDetails[i].qty +
							'</td><td>' +
							objRimmingDetails[i].qty * obj.qty +
							'</td><td class="text-center"></td><td><button type="button" id="' +
							objRimmingDetails[i].tbl_rimming_idtbl_rimming +
							'" class="mr-1 btn btn-danger btn-sm float-right btnDeleteRimming"><i class="fa fa-trash"></i></button></td><td class="d-none">' +
							objRimmingDetails[i].tbl_rimming_idtbl_rimming +
							'</td></tr>'
						);
					});
					$.each(objVarnishDetails, function (i, item) {
						$('#tblCoatingDetails > tbody:last').append('<tr><td class="d-none">' +
							objVarnishDetails[i].tbl_varnish_idtbl_varnish +
							'</td><td class="d-none">' +
							objVarnishDetails[i].tbl_print_material_info_idtbl_print_material_info +
							'</td><td>' +
							objVarnishDetails[i].varnish +
							'</td><td>' +
							objVarnishDetails[i].materialname +
							'</td><td>' +
							objVarnishDetails[i].varnishQty +
							'</td><td>' +
							objVarnishDetails[i].varnishQty * obj.qty  +
							'</td><td class="text-center"></td><td><button type="button" id="' +
							objVarnishDetails[i].tbl_varnish_idtbl_varnish +
							'" class=" mr-1 btn btn-danger btn-sm float-right btnDeleteVarnish"><i class="fa fa-trash"></i></button></td><td class="d-none">' +
							objVarnishDetails[i].tbl_varnish_idtbl_varnish +
							'</td></tr>'
						);
					});
					$.each(objDiecuttingDetails, function (i, item) {
						$('#tblDieCuttingDetails > tbody:last').append('<tr><td class="d-none">' +
							objDiecuttingDetails[i].peraforation +
							'</td><td class="d-none">' +
							objDiecuttingDetails[i].halfCutting +
							'</td><td class="d-none">' +
							objDiecuttingDetails[i].fullCutting +
							'</td><td>' +
							objDiecuttingDetails[i].qty +
							'</td><td>' +
							objDiecuttingDetails[i].qty * obj.qty +
							'</td><td>' +
							(objDiecuttingDetails[i].peraforation == '1' ? 'Yes' : 'No') +
							'</td><td>' +
							(objDiecuttingDetails[i].halfCutting == '1' ? 'Yes' : 'No') +
							'</td><td>' +
							(objDiecuttingDetails[i].fullCutting == '1' ? 'Yes' : 'No') +
							'</td><td><button type="button" id="' +
							objDiecuttingDetails[i].idtbl_jobcard_bom_diecutting +
							'" class="mr-1 btn btn-danger btn-sm float-right btnDeleteCutting"><i class="fa fa-trash"></i></button></td></tr>'
						);

					});
				}
			});
		});

		$('#btnMaterialSubmit').click(function () {
			if (!$("#materialform")[0].checkValidity()) {
				$("#hiddenmaterialsubmit").click();
			} else {
				var materialId = $('#paperboard').val();
				var materialtext = $("#paperboard option:selected").text();
				var jobqty = $('#jobqty').val();

				var printingformat = $('#printingformat').val();
				var printingformattext = $("#printingformat option:selected").text();

				var cutsize = $('#cutsize').val();
				var paperSheetsQty = $('#paperSheetsQty').val();


				$('#tblMaterialDetails > tbody:last').append('<tr><td class="d-none">' +
					printingformat +
					'</td><td class="d-none">' +
					materialId +
					'</td><td>' +
					printingformattext +
					'</td><td>' +
					materialtext +
					'</td><td>' +
					cutsize +
					'</td><td class="text-center">' +
					paperSheetsQty + '</td><td class="text-center">' +
					paperSheetsQty * jobqty + '</td><td class="text-center"></td><td><button type="button" id="' +
					materialId +
					'" class=" mr-1 btn btn-danger btn-sm float-right btnDeleteMaterialtrash"><i class="fa fa-trash"></i></button></td></tr>'
				);

				$('#paperboard').val('');
				$('#printingformat').val('');
				$('#cutsize').val('');
				$('#paperSheetsQty').val('');

			}

		})

		$('#btnVarnishSubmit').click(function () {
			if (!$("#varnishform")[0].checkValidity()) {
				$("#hiddenvarnishsubmit").click();
			} else {
				var coatingvarnish = $('#coatingvarnish').val();
				var coatingvarnishText = $("#coatingvarnish option:selected").text();
				var varnishmaterial = $('#varnishmaterial').val();
				var varnishmaterialText = $("#varnishmaterial option:selected").text();
				var jobqty = $('#jobqty').val();

				var varnishSheetsQty = $('#varnishSheetsQty').val();


				$('#tblCoatingDetails > tbody:last').append('<tr><td class="d-none">' +
					coatingvarnish +
					'</td><td class="d-none">' +
					varnishmaterial +
					'</td><td>' +
					coatingvarnishText +
					'</td><td>' +
					varnishmaterialText +
					'</td><td>' +
					varnishSheetsQty +
					'</td><td>' +
					varnishSheetsQty * jobqty +
					'</td><td class="text-center"></td><td><button type="button" id="' +
					coatingvarnish +
					'" class=" mr-1 btn btn-danger btn-sm float-right btnDeleteVarnish"><i class="fa fa-trash"></i></button></td></tr>'
				);

				$('#varnishSheetsQty').val('');
				$('#coatingvarnish').val('');
				$('#varnishmaterial').val('');
			}
		})
		$('#btnLaminationSubmit').click(function () {
			if (!$("#laminationform")[0].checkValidity()) {
				$("#hiddenlaminationsubmit").click();
			} else {
				var laminations = $('#laminations').val();
				var laminationsText = $("#laminations option:selected").text();
				var laminatingmaterial = $('#laminatingmaterial').val();
				var laminatingmaterialText = $("#laminatingmaterial option:selected").text();

				var jobqty = $('#jobqty').val();
				var filmsize = $('#filmsize').val();
				var micron = $('#micron').val();
				var laminationSheets = $('#laminationSheets').val();
				let laminationSide = $("input[name='laminationSide']:checked").val();

				$('#tblLaminationDetails > tbody:last').append('<tr><td class="d-none">' +
					laminations +
					'</td><td class="d-none">' +
					laminatingmaterial +
					'</td><td class="d-none">' +
					laminationSide +
					'</td><td>' +
					laminationsText +
					'</td><td>' +
					laminatingmaterialText +
					'</td><td>' +
					filmsize +
					'</td><td>' +
					micron +
					'</td><td>' +
					(laminationSide === '1' ? 'One Side' : 'Double Sided') +
					'</td><td>' +
					laminationSheets +
					'</td><td>' +
					laminationSheets * jobqty +
					'</td><td class="text-center"></td><td><button type="button" id="' +
					laminations +
					'" class="mr-1 btn btn-danger btn-sm float-right btnDeleteLamination"><i class="fa fa-trash"></i></button></td></tr>'
				);


				$('#laminations').val('');
				$('#filmsize').val('');
				$('#micron').val('');
				$('#laminatingmaterial').val('');
				$('#laminationSheets').val('');
				$("input[name='laminationSide'][value='1']").prop("checked", true);

			}
		})
		$('#btnRimmingSubmit').click(function () {
			if (!$("#rimmingForm")[0].checkValidity()) {
				$("#hiddenrimmingsubmit").click();
			} else {
				var rimming = $('#rimming').val();
				var rimmingtext = $("#rimming option:selected").text();
				var rimmingmaterial = $('#rimmingmaterial').val();
				var rimmingmaterialText = $("#rimmingmaterial option:selected").text();
				var jobqty = $('#jobqty').val();

				var rimminglength = $('#rimminglength').val();
				var rimmingsheets = $('#rimmingsheets').val();
				let rimmingcheckbox = $("input[name='rimmingcheckbox']:checked").val();

				$('#tblRimmingDetails > tbody:last').append('<tr><td class="d-none">' +
					rimming +
					'</td><td class="d-none">' +
					rimmingmaterial +
					'</td><td class="d-none">' +
					rimmingcheckbox +
					'</td><td>' +
					rimmingtext +
					'</td><td>' +
					rimmingmaterialText +
					'</td><td>' +
					rimminglength +
					'</td><td>' +
					(rimmingcheckbox === '1' ? 'One Side' : 'Double Sided') +
					'</td><td>' +
					rimmingsheets +
					'</td><td>' +
					rimmingsheets * jobqty +
					'</td><td class="text-center"></td><td><button type="button" id="' +
					rimming +
					'" class="mr-1 btn btn-danger btn-sm float-right btnDeleteRimming"><i class="fa fa-trash"></i></button></td></tr>'
				);
				$('#perforation').prop('checked', false);
				$('#halfcutting').prop('checked', false);
				$('#fullcutting').prop('checked', false);
				$('#dieCuttingQty').val('');
				$('#rimming').val('');
				$('#rimmingmaterial').val('');

			}
		})
		$('#btnDieCuttingSubmit').click(function () {
			if (!$("#dieCuttingForm")[0].checkValidity()) {
				$("#hiddendiecuttingsubmit").click();
			} else {
				var dieCuttingQty = $('#dieCuttingQty').val();
				var perforation = 0;
				var halfCutting = 0;
				var fullCutting = 0;
				var jobqty = $('#jobqty').val();

				if ($('#perforation').is(':checked')) {
					perforation = 1;
				}
				if ($('#halfcutting').is(':checked')) {
					halfCutting = 1;
				}
				if ($('#fullcutting').is(':checked')) {
					fullCutting = 1;
				}

				$('#tblDieCuttingDetails > tbody:last').append('<tr><td class="d-none">' +
					perforation +
					'</td><td class="d-none">' +
					halfCutting +
					'</td><td class="d-none">' +
					fullCutting +
					'</td><td>' +
					dieCuttingQty +
					'</td><td>' +
					dieCuttingQty * jobqty+
					'</td><td>' +
					(perforation == '1' ? 'Yes' : 'No') +
					'</td><td>' +
					(halfCutting == '1' ? 'Yes' : 'No') +
					'</td><td>' +
					(fullCutting == '1' ? 'Yes' : 'No') +
					'</td><td><button type="button" id="' +
					perforation +
					'" class="mr-1 btn btn-danger btn-sm float-right btnDeleteCutting"><i class="fa fa-trash"></i></button></td></tr>'
				);

				$('#perforation').prop('checked', false);
				$('#halfcutting').prop('checked', false);
				$('#fullcutting').prop('checked', false);
				$('#dieCuttingQty').val('');
				perforation = 0;
				halfCutting = 0;
				fullCutting = 0;

			}
		})
		$('#btnCreateJobCard').click(function () {
			var materialBody = $("#tblMaterialDetails tbody");
			var varnishBody = $("#tblCoatingDetails tbody");
			var laminationBody = $("#tblLaminationDetails tbody");
			var rimmingBody = $("#tblRimmingDetails tbody");
			var diecuttingBody = $("#tblDieCuttingDetails tbody");
			materialObj = [];
			varnishObj = [];
			laminationObj = [];
			rimmingObj = [];
			diecuttingObj = [];

			var customer = $('#customer').val();
			var job = $('#job').val();
			var jobdescription = $('#jobdescription').val();


			if (materialBody.children().length > 0) {
				$("#tblMaterialDetails tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					materialObj.push(item);
				});
			}
			if (varnishBody.children().length > 0) {
				$("#tblCoatingDetails tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					varnishObj.push(item);
				});
			}
			if (rimmingBody.children().length > 0) {
				$("#tblLaminationDetails tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					laminationObj.push(item);
				});
			}
			if (rimmingBody.children().length > 0) {
				$("#tblRimmingDetails tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					rimmingObj.push(item);
				});
			}
			if (diecuttingBody.children().length > 0) {
				$("#tblDieCuttingDetails tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					diecuttingObj.push(item);
				});
			}

			$.ajax({
				type: "POST",
				data: {
					materialTable: materialObj,
					varnishTable: varnishObj,
					rimmingTable: rimmingObj,
					diecuttingTable: diecuttingObj,
					laminationTable: laminationObj,
					customer: customer,
					job: job,
					jobdescription: jobdescription
				},
				url: '<?php echo base_url(); ?>JobCardAllocation/InsertJobCardAllocation',
				success: function (result) {
					console.log(result)
					setTimeout(window.location.reload(), 3000);
					action(result)
					$('#tblRimmingDetails> tbody').empty();
					$('#tblCoatingDetails> tbody').empty();
					$('#tblDieCuttingDetails> tbody').empty();
					$('#tblMaterialDetails> tbody').empty();
					// calculateMaterialTableTotal()
					$('#customer').val('')
					$('#job').val('')
				}
			});
		})

		$('#tblMaterialDetails tbody').on('click', '.btnDeleteMaterialtrash', function () {
			$(this).closest('tr').remove();
		});
		$('#tblLaminationDetails tbody').on('click', '.btnDeleteLamination', function () {

			$(this).closest('tr').remove();
		});
		$('#tblCoatingDetails tbody').on('click', '.btnDeleteVarnish', function () {

			$(this).closest('tr').remove();
		});
		$('#tblDieCuttingDetails tbody').on('click', '.btnDeleteCutting', function () {
			$(this).closest('tr').remove();
		});
		$('#tblRimmingDetails tbody').on('click', '.btnDeleteRimming', function () {
			$(this).closest('tr').remove();
		});

		$('#dataTable tbody').on('click', '.btnview', function () {
			var id = $(this).attr('id');

			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>JobCardAllocation/GetJobCardPrint',
				success: function (result) { //alert(result);
					$(".modal-body").empty();
					$('#printviewModal').modal('show');
					$(".modal-body").append(result);
				}
			});
		});
		$('#tblMaterialDetails tbody').on('click', 'tr', function (e) {
			var index = $(e.target).closest('td').index();
			if (index === 8) {
				return;
			}

			var row = $(this);

			var materialID = row.closest("tr").find('td:eq(1)').text();
			var qty = row.closest("tr").find('td:eq(6)').text();
			$('#issuemateqty').val(qty);
			$('#issueType').val(1);
			rowID = row.closest("tr")[0].rowIndex;
			
			$.ajax({
				type: "POST",
				data: {
					materialID: materialID
				},
				url: '<?php echo base_url() ?>JobCardAllocation/Getbatchnolistaccomaterial',
				success: function(result) { //alert(result);
					var objfirst = JSON.parse(result);

					var html = '';
					$.each(objfirst, function(i, item) {
						//alert(objfirst[i].id);
						html += '<option value="' + objfirst[i].batchno + '" data-qty="'+objfirst[i].qty+'">';
						html += objfirst[i].batchno+' - '+objfirst[i].qty;
						html += '</option>';
					});

					$('#batchnolist').empty().append(html);
					$('#batchnolist').trigger('change');
					$('#modalbatchno').modal('show');
				}
			}); 
		});
		$('#tblCoatingDetails tbody').on('click', 'tr', function (e) {
			var index = $(e.target).closest('td').index();
			if (index === 7) {
				return;
			}

			var row = $(this);

			var materialID = row.closest("tr").find('td:eq(1)').text();
			var qty = row.closest("tr").find('td:eq(5)').text();
			$('#issuemateqty').val(qty);
			$('#issueType').val(2);
			rowID = row.closest("tr")[0].rowIndex;
			
			$.ajax({
				type: "POST",
				data: {
					materialID: materialID
				},
				url: '<?php echo base_url() ?>JobCardAllocation/Getbatchnolistaccomaterial',
				success: function(result) { //alert(result);
					var objfirst = JSON.parse(result);

					var html = '';
					$.each(objfirst, function(i, item) {
						//alert(objfirst[i].id);
						html += '<option value="' + objfirst[i].batchno + '" data-qty="'+objfirst[i].qty+'">';
						html += objfirst[i].batchno+' - '+objfirst[i].qty;
						html += '</option>';
					});

					$('#batchnolist').empty().append(html);
					$('#batchnolist').trigger('change');
					$('#modalbatchno').modal('show');
				}
			}); 
		});
		$('#tblLaminationDetails tbody').on('click', 'tr', function (e) {
			var index = $(e.target).closest('td').index();
			if (index === 11) {
				return;
			}

			var row = $(this);

			var materialID = row.closest("tr").find('td:eq(1)').text();
			var qty = row.closest("tr").find('td:eq(5)').text();
			$('#issuemateqty').val(qty);
			$('#issueType').val(3);
			rowID = row.closest("tr")[0].rowIndex;
			
			$.ajax({
				type: "POST",
				data: {
					materialID: materialID
				},
				url: '<?php echo base_url() ?>JobCardAllocation/Getbatchnolistaccomaterial',
				success: function(result) { //alert(result);
					var objfirst = JSON.parse(result);

					var html = '';
					$.each(objfirst, function(i, item) {
						//alert(objfirst[i].id);
						html += '<option value="' + objfirst[i].batchno + '" data-qty="'+objfirst[i].qty+'">';
						html += objfirst[i].batchno+' - '+objfirst[i].qty;
						html += '</option>';
					});

					$('#batchnolist').empty().append(html);
					$('#batchnolist').trigger('change');
					$('#modalbatchno').modal('show');
				}
			}); 
		});
		$('#tblRimmingDetails tbody').on('click', 'tr', function (e) {
			var index = $(e.target).closest('td').index();
			if (index === 10) {
				return;
			}

			var row = $(this);

			var materialID = row.closest("tr").find('td:eq(1)').text();
			var qty = row.closest("tr").find('td:eq(5)').text();
			$('#issuemateqty').val(qty);
			$('#issueType').val(4);
			rowID = row.closest("tr")[0].rowIndex;
			
			$.ajax({
				type: "POST",
				data: {
					materialID: materialID
				},
				url: '<?php echo base_url() ?>JobCardAllocation/Getbatchnolistaccomaterial',
				success: function(result) { //alert(result);
					var objfirst = JSON.parse(result);

					var html = '';
					$.each(objfirst, function(i, item) {
						//alert(objfirst[i].id);
						html += '<option value="' + objfirst[i].batchno + '" data-qty="'+objfirst[i].qty+'">';
						html += objfirst[i].batchno+' - '+objfirst[i].qty;
						html += '</option>';
					});

					$('#batchnolist').empty().append(html);
					$('#batchnolist').trigger('change');
					$('#modalbatchno').modal('show');
				}
			}); 
		});

		$('#dataTable tbody').on('click', '.btnInsertAccount', function () {
			var id = $(this).attr('id');
			$('#hiddencardid').val(id);
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>JobCardAllocation/GetNonValidatedAccounts',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					var issuestatus = 0;
					var issueflag = 0;
					$.each(obj, function (i, item) {
						if (obj[i].voucherissue == 1) {
							issuestatus = "Voucher Issued";
						} else {
							issuestatus = "Voucher Not Issued";
							issueflag = 1;
						}
						$('#BatchNoTbl > tbody:last').append(
							'<tr><td class="text-center">' + obj[i].batchno +
							'</td><td class="text-center ' + (obj[i]
								.voucherissue == 0 ?
								'text-danger' : 'text-success') + '">' +
							issuestatus +
							'</td></tr>'
						);
					});

					if (issueflag == 1) {
						$('#btnAddToAccounts').prop('disabled', true);
					} else {
						$('#btnAddToAccounts').prop('disabled', false);
					}
					$('#grnviewModal').modal('show');
				}
			});
		});

		$('#btnAddToAccounts').click(function () {
			var jobCardId = $('#hiddencardid').val();

			$.ajax({
				type: "POST",
				data: {
					recordID: jobCardId
				},
				url: '<?php echo base_url() ?>JobCardAllocation/TransferToAccounts',
				success: function (result) { //alert(result);
					$(".modal-body").empty();
					$('#printviewModal').modal('show');
					$(".modal-body").append(result);
				}
			});

		})

		$('#btnsubmitbatch').click(function(){
			if (!$("#formbatchno")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidesubmitbatch").click();
			} else {
				var selectedmatetotalqty = 0;
				$('#batchnolist option:selected').each(function () {
					selectedmatetotalqty += parseFloat($(this).data('qty'));
				});

				var issuemateqty = parseFloat($('#issuemateqty').val());
				var issueType = $('#issueType').val();
				if(issuemateqty<=selectedmatetotalqty){
					if(issueType==1){
						$('#tblMaterialDetails').find('tr').eq(rowID).find('td:eq(7)').text($('#batchnolist').val());
					} else if(issueType==2){
						$('#tblCoatingDetails').find('tr').eq(rowID).find('td:eq(6)').text($('#batchnolist').val());
					} else if(issueType==3){
						$('#tblLaminationDetails').find('tr').eq(rowID).find('td:eq(10)').text($('#batchnolist').val());
					} else if(issueType==4){
						$('#tblRimmingDetails').find('tr').eq(rowID).find('td:eq(9)').text($('#batchnolist').val());
					}
					
					$('#batchnolist').empty().trigger('change');
					$('#modalbatchno').modal('hide');
				}
				else{
					Swal.fire({text: "You can't issue this quantity. because you selected material quantity is not enough to start production. Thank you."});
				}
			}
		});
	});

	document.getElementById('btnJobCardPrint').addEventListener("click", print);

	function action(data) { //alert(data);
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
			element: 'body',
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
			delay: 5000,
			timer: 1000,
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

	function print() {
		printJS({
			printable: 'modalPrintBody',
			type: 'html',
			style: '@page { size: A4 portrait; margin:0.25cm; }',
			targetStyles: ['*']
		})
	}

	function approve_confirm() {
		return confirm("Are you sure you want to Approve this?");
	}

	function issue_stock_confirm() {
		return confirm("Are you sure you want to Issue stock?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}
</script>
<?php include "include/footer.php"; ?>
