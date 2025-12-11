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
							<div class="page-header-icon"><i class="fas fa-archive"></i></div>
							<span>Customer Jobs</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<form id="mainjobform" autocomplete="off">
									<div class="form-row mb-1">
										<div class="col-3">
											<label class="small font-weight-bold">Customer*</label>
											<select class="form-control form-control-sm" name="customer" id="customer">
												<option value="">Select</option>
											</select>
										</div>
										<div class="col-4">
											<label class="small font-weight-bold">Job Name*</label>
											<input type="text" class="form-control form-control-sm" name="jobname" id="jobname" required>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Job Code*</label>
											<input type="text" class="form-control form-control-sm" name="jobcode" id="jobcode" required>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Unit Price*</label>
											<input type="number" class="form-control form-control-sm" name="unitprice" id="unitprice" value="0" step="any" required>
										</div>
										<div class="col">
											<label class="small font-weight-bold">UOM*</label>
											<select class="form-control form-control-sm" name="uom" id="uom">
												<option value="">Select</option>
												<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
												<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
													<?php echo $rowmeasurelist->measure_type ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<label class="font-weight-bold small">Size Carton</label>
											<div class="form-row">
												<div class="col">
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroup-sizing-sm">L</span>
														</div>
														<input type="number" name="sizeL" id="sizeL" class="form-control">
													</div>
												</div>
												<div class="col">
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroup-sizing-sm">W</span>
														</div>
														<input type="number" name="sizeW" id="sizeW" class="form-control">
													</div>
												</div>
												<div class="col">
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroup-sizing-sm">H</span>
														</div>
														<input type="number" name="sizeH" id="sizeH" class="form-control">
													</div>
												</div>
											</div>
											<label class="font-weight-bold small">Size Label</label>
											<div class="form-row">
												<div class="col">
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroup-sizing-sm">L</span>
														</div>
														<input type="number" name="sizelabelL" id="sizelabelL" class="form-control">
													</div>
												</div>
												<div class="col">
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroup-sizing-sm">W</span>
														</div>
														<input type="number" name="sizelabelW" id="sizelabelW" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="form-group mb-1">
												<label class="small font-weight-bold">Job Discription*</label>
												<textarea class="form-control" name="jobdiscription" id="jobdiscription" rows="3"></textarea>
											</div>
										</div>
									</div>

									
									<!-- <div class="form-group mb-1">
										<label class="small font-weight-bold">Any other Instruction*</label>
										<textarea class="form-control" name="otherinstruction" id="otherinstruction"></textarea>
									</div> -->
									<input type="submit" class="d-none" cid="hiddenmainformsubmit">
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<hr>
								<div class="form-group mt-2 text-right">
									<button type="button" id="submitBtn" class="btn btn-primary btn-sm px-4"><i class="far fa-save"></i>&nbsp;Add</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<hr class="border-dark">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="tblcustomerjobs">
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
			</div>
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<!-- Modal BOM Info -->
<div class="modal fade" id="modalBomInfo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-2">
				<h6 class="modal-title">Job BOM Information</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
					<div class="col-12">
						<form id="formbominfo" method="post">
							<div class="form-group mb-3">
								<label class="small font-weight-bold">BOM Title*</label>
								<input type="text" class="form-control form-control-sm" name="bomtitle" id="bomtitle" required>
							</div>
							<input type="hidden" name="hidejobID" id="hidejobID">
							<input type="hidden" name="recordbomID" id="recordbomID">
							<input type="hidden" name="recordbomOption" id="recordbomOption" value="1">
							<input type="submit" class="d-none" id="hidebomsubmit">
							<input type="reset" class="d-none" id="hidebomreset">
						</form>
						<div class="accordion" id="accordionExample">
							<!-- Pre Press Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingPrePress">
									<h5 class="mb-0">
										<button class="btn btn-link btn-block text-left p-0 btn-sm text-decoration-none text-dark"
											type="button" data-toggle="collapse" data-target="#collapsePrePress"
											aria-expanded="true" aria-controls="collapsePrePress">
											Pre Press Section
										</button>
									</h5>
								</div>
								<div id="collapsePrePress" class="collapse show" aria-labelledby="headingPrePress" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="formprepress">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Art Work*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="prepressArt1" name="prepressArt" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="prepressArt1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="prepressArt2" name="prepressArt" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="prepressArt2">By Us</label>
													</div>
													<hr class="my-2">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Format*</lable><br>
													<?php $i=1; foreach ($printingformatlist->result() as $rowprintingformatlist) { ?>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="prepressFormat<?php echo $i; ?>" name="prepressFormat" value="<?php echo $rowprintingformatlist->format_name ?> - <?php echo $rowprintingformatlist->printing_width ?>mm X <?php echo $rowprintingformatlist->printing_height ?>mm" class="custom-control-input">
														<label class="custom-control-label small" for="prepressFormat<?php echo $i; ?>"><?php echo $rowprintingformatlist->format_name ?> - <?php echo $rowprintingformatlist->printing_width ?>mm X <?php echo $rowprintingformatlist->printing_height ?>mm</label>
													</div>
													<?php $i++;} ?>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Plate*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="prepressPlate1" name="prepressPlate" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="prepressPlate1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="prepressPlate2" name="prepressPlate" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="prepressPlate2">By Us</label>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- Material Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingOne">
									<h5 class="mb-0">
										<button class="btn btn-link btn-block text-left p-0 btn-sm text-decoration-none text-dark"
											type="button" data-toggle="collapse" data-target="#collapseOne"
											aria-expanded="true" aria-controls="collapseOne">
											Material Section
										</button>
									</h5>
								</div>
								<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="materialform">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="materialMaterialby1" name="materialMaterialby" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="materialMaterialby1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="materialMaterialby2" name="materialMaterialby" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="materialMaterialby2">By Us</label>
													</div>
													<hr class="my-2">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-6">
													<lable class="font-weight-bold small">Paper / Board* </lable><br>
													<select name="materialpaperboard" id="materialpaperboard" class="form-control form-control-sm" style="width: 100%;" required>
														<option value="">Select</option>
													</select>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Cutting Size (Inch)*</lable>
													<input type="text" name="materialcutsize" id="materialcutsize" class="form-control form-control-sm" required>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material Cut UPs*</lable>
													<input type="number" step="any" name="materialcutups" id="materialcutups" class="form-control form-control-sm" required>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">UPs per Sheet*</lable>
													<input type="number" step="any" name="materialuppersheet" id="materialuppersheet" class="form-control form-control-sm" required>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Wastage (%)*</lable>
													<input type="number" step="any" name="materialwastage" id="materialwastage" class="form-control form-control-sm" required>
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btnMaterialSubmit"
													class="btn btn-primary btn-sm px-4 ml-auto mr-1">
													<i class="fas fa-list"></i>&nbsp;Add to list
												</button>
												<input type="submit" class="d-none" id="hiddenmaterialsubmit">
												<input type="reset" class="d-none" id="hiddenmaterialreset">
											</div>
										</form>
										<table class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblMaterialDetails">
											<thead>
												<tr>
													<th>By</th>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th class="text-center">Cut Size (Inch)</th>
													<th class="text-center">Material Cut UPs</th>
													<th class="text-center">UPs per Sheet</th>
													<th class="text-center">Wastage (%)</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Printing Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingTwo">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											Printing Section
										</button>
									</h2>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="colorform">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="printingMaterialby1" name="printingMaterialby" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="printingMaterialby1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="printingMaterialby2" name="printingMaterialby" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="printingMaterialby2">By Us</label>
													</div>
													<hr class="my-2">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<div class="custom-control custom-radio custom-control-inline mb-0">
														<input type="radio" class="custom-control-input" id="printingcolortype1" value="CMYK" name="printingcolortype" required>
														<label class="custom-control-label small" for="printingcolortype1">CMYK</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline mb-0">
														<input type="radio" class="custom-control-input" id="printingcolortype2" value="Metlic Color" name="printingcolortype">
														<label class="custom-control-label small" for="printingcolortype2">Metlic Color</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline mb-0">
														<input type="radio" class="custom-control-input" id="printingcolortype3" value="Other" name="printingcolortype">
														<label class="custom-control-label small" for="printingcolortype3">Other</label>
													</div>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material*</lable>
													<select name="printingmaterial" id="printingmaterial" class="form-control form-control-sm" style="width: 100%" required>
														<option value="">Select</option>
													</select>
												</div>
												<div class="col-3">
													<lable class="font-weight-bold small">Qty(KG)*</lable>
													<input type="text" name="printingqty" id="printingqty" class="form-control form-control-sm" required>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Remark* </lable>
													<textarea name="printingremark" id="printingremark" class="form-control form-control-sm"></textarea>
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btnprintingSubmit" class="btn btn-primary btn-sm px-4 ml-auto mr-1"><i class="fas fa-list"></i>&nbsp;Add to list</button>
												<input type="submit" class="d-none" id="hiddenprintingsubmit">
												<input type="reset" class="d-none" id="hiddenprintingreset">
											</div>
										</form>
										<table class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblColorDetails">
											<thead>
												<tr>
													<th>By</th>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th>Color Type</th>
													<th>Qty(KG)</th>
													<th>Remark</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Coating Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingThree">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
											Coating Section
										</button>
									</h2>
								</div>
								<div id="collapseFive" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="varnishform">
											<div class="form-row mb-1">
												<div class="col-6">
													<lable class="font-weight-bold small">Varnish Type*</lable>
													<select name="coatingvarnish" id="coatingvarnish" class="form-control form-control-sm" required>
														<option value="">Select Varnish</option>
														<?php foreach ($varnishlist->result() as $rowvarnishlist) { ?>
														<option value="<?php echo $rowvarnishlist->idtbl_varnish ?>"><?php echo $rowvarnishlist->varnish ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col">
													<div class="custom-control custom-radio">
														<input type="radio" id="glossmatt1" name="glossmatt" class="custom-control-input" value="Gloss">
														<label class="custom-control-label small" for="glossmatt1">Gloss</label>
													</div>
													<div class="custom-control custom-radio">
														<input type="radio" id="glossmatt2" name="glossmatt" class="custom-control-input" value="Matt">
														<label class="custom-control-label small" for="glossmatt2">Matt</label>
													</div>
												</div>
												<div class="col">
													<div class="custom-control custom-radio">
														<input type="radio" id="fullspot3" name="fullspot" class="custom-control-input" value="Full">
														<label class="custom-control-label small" for="fullspot3">Full</label>
													</div>
													<div class="custom-control custom-radio">
														<input type="radio" id="fullspot4" name="fullspot" class="custom-control-input" value="Spot">
														<label class="custom-control-label small" for="fullspot4">Spot</label>
													</div>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-8">
													<lable class="font-weight-bold small">Material* </lable>
													<select name="coatingmaterial" id="coatingmaterial" class="form-control form-control-sm" style="width: 100%;" required>
														<option value="">Select</option>
													</select>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Qty(KG)*</lable>
													<input type="number" step="any" name="coatingQty" id="coatingQty" class="form-control form-control-sm" required>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Remark* </lable>
													<textarea name="coatingmark" id="coatingmark" class="form-control form-control-sm"></textarea>
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btncoatingSubmit" class="btn btn-primary btn-sm px-4 ml-auto mr-1"><i class="fas fa-list"></i>&nbsp;Add to list</button>
												<input type="submit" class="d-none" id="hiddencoatingsubmit">
												<input type="reset" class="d-none" id="hiddencoatingreset">
											</div>
										</form>
										<table
											class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblCoatingDetails">
											<thead>
												<tr>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th class="d-none">VarnishTypeID</th>
													<th>Varnish Type</th>
													<th class="d-none">Glossmatt</th>
													<th class="d-none">Fullspot</th>
													<th>Qty(KG)</th>
													<th>Remark</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Foiling Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingFoil">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseFoil" aria-expanded="false" aria-controls="collapseFoil">
											Foiling Section
										</button>
									</h2>
								</div>
								<div id="collapseFoil" class="collapse" aria-labelledby="headingFoil"
									data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="foilform">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="foilMaterialby1" name="foilMaterialby" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="foilMaterialby1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="foilMaterialby2" name="foilMaterialby" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="foilMaterialby2">By Us</label>
													</div>
													<hr class="my-2">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-8">
													<lable class="font-weight-bold small">Foiling Type*</lable>
													<select name="foiltype" id="foiltype" class="form-control form-control-sm">
														<option value="">Select</option>
														<?php foreach($foilinglist->result() as $rowfoilinglist): ?>
														<option value="<?php echo $rowfoilinglist->idtbl_foiling ?>"><?php echo $rowfoilinglist->foiling ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-8">
													<lable class="font-weight-bold small">Material*</lable>
													<select name="foilmaterial" id="foilmaterial" class="form-control form-control-sm" style="width: 100%" required>
														<option value="">Select</option>
													</select>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Qty(Inch)*</lable>
													<input type="text" name="foilqty" id="foilqty" class="form-control form-control-sm">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Remark* </lable>
													<textarea name="foilremark" id="foilremark" class="form-control form-control-sm"></textarea>
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btnfoilSubmit" class="btn btn-primary btn-sm px-4 ml-auto mr-1"><i class="fas fa-list"></i>&nbsp;Add to list</button>
												<input type="submit" class="d-none" id="hiddenfoilsubmit">
												<input type="reset" class="d-none" id="hiddenfoilreset">
											</div>
										</form>
										<table class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblfoilDetails">
											<thead>
												<tr>
													<th>By</th>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th class="d-none">FoilTypeID</th>
													<th>Foil Type</th>
													<th>Qty(Inch)</th>
													<th>Remark</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Lamination Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingFour">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											Lamination Section
										</button>
									</h2>
								</div>
								<div id="collapseThree" class="collapse" aria-labelledby="headingFour"
									data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="laminationform">
											<div class="form-row mb-1">
												<div class="col-6">
													<lable class="font-weight-bold small">Lamination*</lable>
													<select name="laminations" id="laminations" class="form-control form-control-sm">
														<option value="">Select Lamination</option>
														<?php foreach ($laminationlist->result() as $rowlaminationlist) { ?>
														<option value="<?php echo $rowlaminationlist->idtbl_lamination ?>"><?php echo $rowlaminationlist->lamination ?></option> 
														<?php } ?>
													</select>
												</div>
												<div class="col-6">
													<lable class="font-weight-bold small">Lamination Sides*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="laminationSide1" name="laminationSide" class="custom-control-input" value="One Side" required>
														<label class="custom-control-label small" for="laminationSide1">One Side</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="laminationSide2" name="laminationSide" class="custom-control-input" value="Both Side">
														<label class="custom-control-label small" for="laminationSide2">Both Side</label>
													</div>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material*</lable>
													<select name="laminatingmaterial" id="laminatingmaterial" class="form-control form-control-sm" style="width: 100%" required>
														<option value="">Select</option>
													</select>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Film Size(Inch)*</lable>
													<input type="text" name="laminatingfilmsize" id="laminatingfilmsize" class="form-control form-control-sm">
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Qty(KG)*</lable>
													<input type="text" name="laminatingqty" id="laminatingqty" class="form-control form-control-sm">
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Wastage(%)*</lable>
													<input type="text" name="laminatingwastage" id="laminatingwastage" class="form-control form-control-sm">
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btnLaminationSubmit" class="btn btn-primary btn-sm px-4 ml-auto mr-1"><i class="fas fa-list"></i>&nbsp;Add to list</button>
												<input type="submit" class="d-none" id="hiddenlaminationsubmit">
												<input type="reset" class="d-none" id="hiddenlaminationreset">
											</div>
										</form>
										<table class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblLaminationDetails">
											<thead>
												<tr>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th class="d-none">LaminationType</th>
													<th>Lamination</th>
													<th>Film Size(Inch)</th>
													<th>Sides</th>
													<th>Qty(KG)</th>
													<th>Wastage(%)</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Pasting Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingPaste">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapsePaste" aria-expanded="false" aria-controls="collapsePaste">
											Pasting Section
										</button>
									</h2>
								</div>
								<div id="collapsePaste" class="collapse" aria-labelledby="headingPaste"
									data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="pastingform">
											<div class="form-row mb-1">
												<div class="col-8">
													<lable class="font-weight-bold small">Machine*</lable>
													<select name="pasteMachine" id="pasteMachine" class="form-control form-control-sm" style="width: 100%" required>
														<option value="">Select</option>
														<?php foreach($machielist->result() as $rowmachielist): ?>
														<option value="<?php echo $rowmachielist->idtbl_machine ?>"><?php echo $rowmachielist->machine ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="pasteType1" name="pasteType" value="Straight Line" required>
														<label class="custom-control-label small" for="pasteType1">Straight Line</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="pasteType2" name="pasteType" value="Crash Box">
														<label class="custom-control-label small" for="pasteType2">Crash Box</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="pasteType3" name="pasteType" value="Manual">
														<label class="custom-control-label small" for="pasteType3">Manual</label>
													</div>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-8">
													<lable class="font-weight-bold small">Material*</lable>
													<select name="pasteMaterial" id="pasteMaterial" class="form-control form-control-sm" style="width: 100%" required>
														<option value="">Select</option>
													</select>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Qty(KG)*</lable>
													<input type="text" name="pasteQty" id="pasteQty" class="form-control form-control-sm">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Remark* </lable>
													<textarea name="pasteRemark" id="pasteRemark" class="form-control form-control-sm"></textarea>
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btnpasteSubmit" class="btn btn-primary btn-sm px-4 ml-auto mr-1"><i class="fas fa-list"></i>&nbsp;Add to list</button>
												<input type="submit" class="d-none" id="hiddenpastesubmit">
												<input type="reset" class="d-none" id="hiddenpastereset">
											</div>
										</form>
										<table class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblpasteDetails">
											<thead>
												<tr>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th class="d-none">MachineID</th>
													<th>Machine</th>
													<th>Paste Type</th>
													<th>Qty(KG)</th>
													<th>Remark</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Die Cutting Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingSix">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
											Die Cutting Section
										</button>
									</h2>
								</div>
								<div id="collapseFour" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="dieCuttingForm">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Die Cutting*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="diecutby1" name="diecutby" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="diecutby1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="diecutby2" name="diecutby" value="By Us" class="custom-control-input">
														<label class="custom-control-label small" for="diecutby2">By Us</label>
													</div>
												</div>
												<div class="col">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="diechannel" value="Channel">
														<label class="custom-control-label small" for="diechannel">Channel</label>
													</div>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="dieboard" value="Board">
														<label class="custom-control-label small" for="dieboard">Board</label>
													</div>
												</div>
												<div class="col">
													<label class="font-weight-bold small">Size*</label>
													<input type="text" name="diesize" id="diesize" class="form-control form-control-sm" required>
												</div>
												<div class="col">
													<label class="font-weight-bold small">Qty(m)*</label>
													<input type="text" name="dieqty" id="dieqty" class="form-control form-control-sm" required>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<hr class="my-2">
													<lable class="font-weight-bold small">Embossing*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="diecutembrossby1" name="diecutembrossby" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="diecutembrossby1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="diecutembrossby2" name="diecutembrossby" value="By Us" class="custom-control-input">
														<label class="custom-control-label small" for="diecutembrossby2">By Us</label>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- Rimming Section -->
							<div class="card shadow-none border border-bottom-0 m-0">
								<div class="card-header p-1" id="headingFive">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
											Rimming Section
										</button>
									</h2>
								</div>
								<div id="collapseSix" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="rimmingForm">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Material*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="rimmingMaterialby1" name="rimmingMaterialby" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="rimmingMaterialby1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="rimmingMaterialby2" name="rimmingMaterialby" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="rimmingMaterialby2">By Us</label>
													</div>
													<hr class="my-2">
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-6">
													<lable class="font-weight-bold small">Rimming*</lable>
													<select name="rimming" id="rimming" class="form-control form-control-sm" required>
														<option value="">Select Rimming</option>
														<?php foreach ($rimminglist->result() as $rowrimminglist) { ?>
														<option
															value="<?php echo $rowrimminglist->idtbl_rimming ?>">
															<?php echo $rowrimminglist->rimming ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-6">
													<lable class="font-weight-bold small">Rimming Sides*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="rimmingside1" name="rimmingside" class="custom-control-input" value="One Side" required>
														<label class="custom-control-label small" for="rimmingside1">One Side</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="rimmingside2" name="rimmingside" class="custom-control-input" value="Both Side">
														<label class="custom-control-label small" for="rimmingside2">Both Side</label>
													</div>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col-8">
													<lable class="font-weight-bold small">Material*</lable>
													<select name="rimmingmaterial" id="rimmingmaterial" class="form-control form-control-sm" style="width: 100%" required>
														<option value="">Select</option>
													</select>
												</div>
												<div class="col">
													<lable class="font-weight-bold small">Qty*</lable>
													<input type="text" name="rimmingqty" id="rimmingqty" class="form-control form-control-sm" required>
												</div>
											</div>
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Remark* </lable>
													<textarea name="rimmingRemark" id="rimmingRemark" class="form-control form-control-sm"></textarea>
												</div>
											</div>
											<div class="form-row mt-3">
												<button type="button" id="btnRimmingSubmit" class="btn btn-primary btn-sm px-4 ml-auto mr-1"><i class="fas fa-list"></i>&nbsp;Add to list</button>
												<input type="submit" class="d-none" id="hiddenrimmingsubmit">
												<input type="reset" class="d-none" id="hiddenrimmingreset">
											</div>
										</form>
										<table class="table table-bordered table-striped table-sm nowrap w-100 mt-3 small" id="tblRimmingDetails">
											<thead>
												<tr>
													<th>By</th>
													<th class="d-none">MaterialID</th>
													<th>Code</th>
													<th>Material</th>
													<th class="d-none">RimmingTypeID</th>
													<th>Rimming Type</th>
													<th>Side</th>
													<th>Qty</th>
													<th>Remark</th>
													<th class="d-none"></th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Other Section -->
							<div class="card shadow-none border m-0">
								<div class="card-header p-1" id="headingSeven">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
											Other Section
										</button>
									</h2>
								</div>
								<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="OtherForm">
											<div class="form-row mb-1">
												<div class="col">
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherPerforating" value="Perforating">
														<label class="custom-control-label small" for="otherPerforating">Perforating</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherGattering" value="Gattering">
														<label class="custom-control-label small" for="otherGattering">Gattering</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherRimming" value="Rimming">
														<label class="custom-control-label small" for="otherRimming">Rimming</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherBinding" value="Binding">
														<label class="custom-control-label small" for="otherBinding">Binding</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherStapling" value="Stapling">
														<label class="custom-control-label small" for="otherStapling">Stapling</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherPadding" value="Padding">
														<label class="custom-control-label small" for="otherPadding">Padding</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherCreasing" value="Creasing">
														<label class="custom-control-label small" for="otherCreasing">Creasing</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="otherThreading" value="Threading">
														<label class="custom-control-label small" for="otherThreading">Threading</label>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- Other Info Section -->
							<!-- <div class="card shadow-none border m-0">
								<div class="card-header p-1" id="headingOtherinfo">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed p-0 btn-sm text-decoration-none text-dark" type="button" data-toggle="collapse" data-target="#collapseOtherinfo" aria-expanded="false" aria-controls="collapseOtherinfo">
											Other Information
										</button>
									</h2>
								</div>
								<div id="collapseOtherinfo" class="collapse" aria-labelledby="headingOtherinfo" data-parent="#accordionExample">
									<div class="card-body p-2">
										<form method="post" autocomplete="off" id="OtherForm">
											<div class="form-row mb-1">
												<div class="col">
													<lable class="font-weight-bold small">Delivery*</lable><br>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="delivery1" name="delivery" value="By Customer" class="custom-control-input">
														<label class="custom-control-label small" for="delivery1">By Customer</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="delivery2" name="delivery" value="By Us" class="custom-control-input" checked>
														<label class="custom-control-label small" for="delivery2">By Us</label>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div> -->
						</div>
						<div class="form-row">
							<div class="col text-right">
								<hr>
								<button type="button" class="btn btn-primary btn-sm px-3" id="btnsubmitbom"><i class="far fa-save mr-2"></i>Create BOM</button>
							</div>
						</div>
						<div class="alert alert-danger mt-2" role="alert">
							If you want to remove any material information in job material information in subtables. Please click the table row and give <b>"Yes"</b> or <b>"No."</b>
						</div>
					</div>
					<div class="col-12">
						<table class="table table-striped table-bordered table-sm small w-100 nowrap" id="bomdatatable">
							<thead>
								<tr>
									<th>#</th>
									<th>BOM Title</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal View BOM -->
<div class="modal fade" id="viewBOM" tabindex="-1" aria-labelledby="viewBOMLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewBOMLabel">BOM Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="showdata"></div>
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

		//Select2 Searches
		$("#customer").select2({
            // dropdownParent: $('#modalreceivable'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/Getcustomerlist",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
		$("#customer").change(function(){
			$('#tblcustomerjobs').DataTable().ajax.reload( null, false );
		});
		$("#CFV").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/\p4",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify(["1", "2"])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#printingmaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify(["3"])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#coatingmaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify(["8"])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#foilmaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify(["5"])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#laminatingmaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify(["6"])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#pasteMaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify(["7"])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#rimmingmaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify([])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    code: item.code
                                }
                            };
                        })
                    }
                },
                cache: true
            }
        });
		$("#othermaterial").select2({
            dropdownParent: $('#modalBomInfo'),
            ajax: {
                url: "<?php echo base_url() ?>Newcustomerjobs/GetMaterialList",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
						searchCategory: JSON.stringify([])
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

		//Main Datatable
		$('#tblcustomerjobs').DataTable({
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
						"customer": $('#customer').val()
					});
				}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [
				// {
				// 	"data": "idtbl_customer_job_details"
				// },
				{
					"data": null,
					"render": function(data, type, full, meta) {
						return meta.row + 1 + meta.settings._iDisplayStart;
					}
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

						if(addcheck==1){
							button+='<button type="button" class="btn btn-secondary btn-sm btnBOM mr-1" id="'+full['idtbl_customer_job_details']+'" data-toggle="tooltip" title="BOM List"><i class="fas fa-list"></i></button>';
						}
						if(editcheck==1){
							button+='<button type="button" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_customer_job_details']+'" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></button>';
						}
						if(full['status']==1 && statuscheck==1){
							button+='<button type="button" data-url="Newcustomerjobs/Newcustomerjobsstatus/'+full['idtbl_customer_job_details']+'/2" data-toggle="tooltip" title="Active" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
						}else if(full['status']==2 && statuscheck==1){
							button+='<button type="button" data-url="Newcustomerjobs/Newcustomerjobsstatus/'+full['idtbl_customer_job_details']+'/1" data-toggle="tooltip" title="Deactive" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
						}
						if(deletecheck==1){
							button+='<button type="button" data-url="Newcustomerjobs/Newcustomerjobsstatus/'+full['idtbl_customer_job_details']+'/3" data-toggle="tooltip" title="Delete" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#tblcustomerjobs tbody').on('click', '.btnEdit', async function() {
			var r = await Otherconfirmation("You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Newcustomerjobs/Newcustomerjobsedit',
					success: function(result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						var newOptioncr = new Option(obj.customer, obj.customerid, true, true);
                        $('#customer').append(newOptioncr);
						$('#jobname').val(obj.job_name);
						$('#jobcode').val(obj.job_code);
						$('#uom').val(obj.mesureid);
						$('#unitprice').val(obj.unitprice);
						$('#jobdiscription').val(obj.job_discription);
						$('#sizeL').val(obj.carton_L);
						$('#sizeW').val(obj.carton_W);
						$('#sizeH').val(obj.carton_H);
						$('#sizelabelL').val(obj.Label_L);
						$('#sizelabelW').val(obj.label_W);

						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});
		$('#tblcustomerjobs tbody').on('click', '.btnBOM', async function() {
			var id = $(this).attr('id');
			$('#hidejobID').val(id);
			bomtableinfo();
			$('#modalBomInfo').modal('show');
		});		
		
		//Full Submit
		$('#submitBtn').click(function () {
			if (!$("#mainjobform")[0].checkValidity()) {
				$("#hiddenmainformsubmit").click();
			} else {
				var jobname = $('#jobname').val();
				var jobcode = $('#jobcode').val();
				var unitprice = $('#unitprice').val();
				var uom = $('#uom').val();
				var sizeL = $('#sizeL').val();
				var sizeW = $('#sizeW').val();
				var sizeH = $('#sizeH').val();
				var sizelabelL = $('#sizelabelL').val();
				var sizelabelW = $('#sizelabelW').val();
				var jobdiscription = $('#jobdiscription').val();
				var recordOption = $('#recordOption').val();
				var recordID = $('#recordID').val();
				var customerid = $('#customer').val();
				
				Swal.fire({
					title: '',
					html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
					allowOutsideClick: false,
					showConfirmButton: false, // Hide the OK button
					backdrop: `
						rgba(255, 255, 255, 0.5) 
					`,
					customClass: {
						popup: 'fullscreen-swal'
					},
					didOpen: () => {
						document.body.style.overflow = 'hidden';
						$.ajax({
							type: "POST",
							data: {
								jobname: jobname,
								jobcode: jobcode,
								unitprice: unitprice,
								uom: uom,
								sizeL: sizeL,
								sizeW: sizeW,
								sizeH: sizeH,
								sizelabelL: sizelabelL,
								sizelabelW: sizelabelW,
								jobdiscription: jobdiscription,
								recordOption: recordOption,
								recordID: recordID,
								customerid: customerid
							},
							url: '<?php echo base_url(); ?>Newcustomerjobs/Newcustomerjobsinsertupdate',
							success: function (result) {
								Swal.close();
								document.body.style.overflow = 'auto';
								var obj = JSON.parse(result);
								if(obj.status==1){
									actionreload(obj.action);
								}
								else{
									action(obj.action);
								}
							},
							error: function(error) {
								// Close the SweetAlert on error
								Swal.close();
								document.body.style.overflow = 'auto';
								
								// Show an error alert
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Something went wrong. Please try again later.'
								});
							}
						});
					}
				}); 
			}
		});

		//BOM Information
		$('#btnsubmitbom').click(function(){
			if (!$("#formbominfo")[0].checkValidity()) {
				$("#hidebomsubmit").click();
			} else {
				var jobid = $('#hidejobID').val();
				var bomtitle = $('#bomtitle').val();
				var recordbomID = $('#recordbomID').val();
				var recordbomOption = $('#recordbomOption').val();

				var prepressArtworkby = $('input[name="prepressArt"]:checked').val();
				var prepressFormat = $('input[name="prepressFormat"]:checked').val();
				var prepressPlateby = $('input[name="prepressPlate"]:checked').val();

				var materialBody = $("#tblMaterialDetails tbody");
				var colorBody = $("#tblColorDetails tbody");
				var varnishBody = $("#tblCoatingDetails tbody");
				var foilBody = $("#tblfoilDetails tbody");
				var laminationBody = $("#tblLaminationDetails tbody");
				var pastingBody = $("#tblpasteDetails tbody");
				var rimmingBody = $("#tblRimmingDetails tbody");

				materialObj = [];
				colorgObj = [];
				varnishObj = [];
				foilObj = [];
				laminationObj = [];
				pastingObj = [];
				rimmingObj = [];

				if (materialBody.children().length > 0) {
					$("#tblMaterialDetails tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});
						materialObj.push(item);
					});
				}
				if (colorBody.children().length > 0) {
					$("#tblColorDetails tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});
						colorgObj.push(item);
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
				if (foilBody.children().length > 0) {
					$("#tblfoilDetails tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});
						foilObj.push(item);
					});
				}
				if (laminationBody.children().length > 0) {
					$("#tblLaminationDetails tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});
						laminationObj.push(item);
					});
				}
				if (pastingBody.children().length > 0) {
					$("#tblpasteDetails tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});
						pastingObj.push(item);
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
				// console.log(materialObj);

				var diechannel = '';
				var dieboard = '';
				var diecutby = $('input[name="diecutby"]:checked').val();
				if ($('#diechannel').is(':checked')) {diechannel=$('#diechannel').val();}
				if ($('#dieboard').is(':checked')) {dieboard=$('#dieboard').val();}
				var diesize = $('#diesize').val();
				var dieqty = $('#dieqty').val();
				var diecutembrossby = $('input[name="diecutembrossby"]:checked').val();

				var otherPerforating = '';
				var otherGattering = '';
				var otherRimming = '';
				var otherBinding = '';
				var otherStapling = '';
				var otherPadding = '';
				var otherCreasing = '';
				var otherThreading = '';
				if ($('#otherPerforating').is(':checked')) {otherPerforating=$('#otherPerforating').val();}
				if ($('#otherGattering').is(':checked')) {otherGattering=$('#otherGattering').val();}
				if ($('#otherRimming').is(':checked')) {otherRimming=$('#otherRimming').val();}
				if ($('#otherBinding').is(':checked')) {otherBinding=$('#otherBinding').val();}
				if ($('#otherStapling').is(':checked')) {otherStapling=$('#otherStapling').val();}
				if ($('#otherPadding').is(':checked')) {otherPadding=$('#otherPadding').val();}
				if ($('#otherCreasing').is(':checked')) {otherCreasing=$('#otherCreasing').val();}
				if ($('#otherThreading').is(':checked')) {otherThreading=$('#otherThreading').val();}

				// var delivery = $('input[name="delivery"]:checked').val();

				Swal.fire({
					title: '',
					html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
					allowOutsideClick: false,
					showConfirmButton: false, // Hide the OK button
					backdrop: `
						rgba(255, 255, 255, 0.5) 
					`,
					customClass: {
						popup: 'fullscreen-swal'
					},
					didOpen: () => {
						document.body.style.overflow = 'hidden';
						$.ajax({
							type: "POST",
							data: {
								jobid: jobid,
								bomtitle: bomtitle,
								recordOption: recordbomOption,
								recordID: recordbomID,
								prepressArtworkby: prepressArtworkby,
								prepressFormat: prepressFormat,
								prepressPlateby: prepressPlateby,
								
								materialTable: materialObj,
								colorTable: colorgObj,
								varnishTable: varnishObj,
								foilTable: foilObj,
								laminationTable: laminationObj,
								pastingTable: pastingObj,
								rimmingTable: rimmingObj,

								diecutby: diecutby,
								diechannel: diechannel,
								dieboard: dieboard,
								diesize: diesize,
								dieqty: dieqty,
								diecutembrossby: diecutembrossby,
								otherPerforating: otherPerforating,
								otherGattering: otherGattering,
								otherRimming: otherRimming,
								otherBinding: otherBinding,
								otherStapling: otherStapling,
								otherPadding: otherPadding,
								otherCreasing: otherCreasing,
								otherThreading: otherThreading
							},
							url: '<?php echo base_url(); ?>Newcustomerjobs/Newcustomerjobbominsertupdate',
							success: function (result) {
								Swal.close();
								document.body.style.overflow = 'auto';
								var obj = JSON.parse(result);
								$('#bomdatatable').DataTable().ajax.reload( null, false );
								action(obj.action);
								$('#hidebomreset').click();
								$('#hiddenmaterialreset').click();
								$('#hiddenprintingreset').click();
								$('#hiddencoatingreset').click();
								$('#hiddenfoilreset').click();
								$('#hiddenlaminationreset').click();
								$('#hiddenpastereset').click();
								$('#hiddenrimmingreset').click();

								$('#tblMaterialDetails tbody').empty();
								$('#tblColorDetails tbody').empty();
								$('#tblCoatingDetails tbody').empty();
								$('#tblfoilDetails tbody').empty();
								$('#tblLaminationDetails tbody').empty();
								$('#tblpasteDetails tbody').empty();
								$('#tblRimmingDetails tbody').empty();
								$("#collapseOne").collapse("show");
							},
							error: function(error) {
								// Close the SweetAlert on error
								Swal.close();
								document.body.style.overflow = 'auto';
								
								// Show an error alert
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Something went wrong. Please try again later.'
								});
							}
						});
					}
				}); 
			}
		});

		//BOM Other Submit Options
		$('#btnMaterialSubmit').click(function () {
			if (!$("#materialform")[0].checkValidity()) {
				$("#hiddenmaterialsubmit").click();
			} else {
				var materialId = $('#materialpaperboard').val();
				var materialtext = $("#materialpaperboard option:selected").text();
				var selectedData = $('#materialpaperboard').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;
				var materialcutsize = $('#materialcutsize').val();
				var materialcutups = $('#materialcutups').val();
				var materialuppersheet = $('#materialuppersheet').val();
				var materialwastage = $('#materialwastage').val();
				var materialMaterialby = $('input[name="materialMaterialby"]:checked').val();

				$('#tblMaterialDetails > tbody:last').append('<tr class="btnDeleteMaterialtrash"><td>' + materialMaterialby + '</td><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td class="text-center">' + materialcutsize + '</td><td class="text-center">' + materialcutups + '</td><td class="text-center">' + materialuppersheet + '</td><td class="text-center">' + materialwastage + '</td></tr>'
				);
				$('#hiddenmaterialreset').click();
				$('#materialpaperboard').val('').trigger('change');
			}
		});
		$('#btnprintingSubmit').click(function () {
			if (!$("#colorform")[0].checkValidity()) {
				$("#hiddenprintingsubmit").click();
			} else {
				var colortype = '';
				var printingMaterialby = $('input[name="printingMaterialby"]:checked').val();
				var colortype = $('input[name="printingcolortype"]:checked').val();
				// if ($('#printingcmyk').is(':checked')) {colortype=$('#printingcmyk').val();}
				// if ($('#printingmetlic').is(':checked')) {colortype=$('#printingmetlic').val();}
				// if ($('#printinganyother').is(':checked')) {colortype=$('#printinganyother').val();}
				var materialId = $('#printingmaterial').val();
				var materialtext = $("#printingmaterial option:selected").text();
				var selectedData = $('#printingmaterial').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;
				var printingqty = $('#printingqty').val();
				var printingremark = $('#printingremark').val();				

				$('#tblColorDetails > tbody:last').append('<tr class="btnDeleteColor"><td>' + printingMaterialby + '</td><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td>' + colortype + '</td><td>' + printingqty + '</td><td>' + printingremark + '</td></tr>'
				);

				$('#printingcmyk').prop('checked', false);
				$('#printingmetlic').prop('checked', false);
				$('#printinganyother').prop('checked', false);
				$('#printingremark').val('');
				$('#printingmaterial').val('').trigger('change');
				$('#hiddenprintingreset').click();
				cmyk = 0;
				metlic = 0;
				anyother = 0;

			}
		});
		$('#btncoatingSubmit').click(function () {
			if (!$("#varnishform")[0].checkValidity()) {
				$("#hiddencoatingsubmit").click();
			} else {
				var coatingvarnish = $('#coatingvarnish').val();
				var coatingvarnishText = $("#coatingvarnish option:selected").text();
				var glossmatt = $('input[name="glossmatt"]:checked').val();
				var fullspot = $('input[name="fullspot"]:checked').val();

				var materialId = $('#coatingmaterial').val();
				var materialtext = $("#coatingmaterial option:selected").text();
				var selectedData = $('#coatingmaterial').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;

				var coatingQty = $('#coatingQty').val();
				var coatingmark = $('#coatingmark').val();

				$('#tblCoatingDetails > tbody:last').append('<tr class="btnDeleteVarnish"><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td class="d-none">' + coatingvarnish + '</td><td>' + coatingvarnishText + ' - ' + glossmatt + ' - ' + fullspot + '</td><td class="d-none">' + glossmatt + '</td><td class="d-none">' + fullspot + '</td><td>' + coatingQty + '</td><td>' + coatingmark + '</td></tr>'
				);

				$('#varnishmaterial').val('').trigger('change');
				$('#hiddencoatingreset').click();
			}
		});
		$('#btnfoilSubmit').click(function () {
			if (!$("#foilform")[0].checkValidity()) {
				$("#hiddenfoilsubmit").click();
			} else {
				var foilMaterialby = $('input[name="foilMaterialby"]:checked').val();
				var foiltype = $('#foiltype').val();
				var foiltypeText = $("#foiltype option:selected").text();

				var materialId = $('#foilmaterial').val();
				var materialtext = $("#foilmaterial option:selected").text();
				var selectedData = $('#foilmaterial').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;

				var foilqty = $('#foilqty').val();
				var foilremark = $('#foilremark').val();

				$('#tblfoilDetails > tbody:last').append('<tr class="btnDeleteFoil"><td>' + foilMaterialby + '</td><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td class="d-none">' + foiltype + '</td><td>' + foiltypeText + '</td><td>' + foilqty + '</td><td>' + foilremark + '</td></tr>'
				);

				$('#foilmaterial').val('').trigger('change');
				$('#hiddenfoilreset').click();
			}
		});
		$('#btnLaminationSubmit').click(function () {
			if (!$("#laminationform")[0].checkValidity()) {
				$("#hiddenlaminationsubmit").click();
			} else {
				var laminations = $('#laminations').val();
				var laminationsText = $("#laminations option:selected").text();
				var laminationSide = $('input[name="laminationSide"]:checked').val();
				
				var materialId = $('#laminatingmaterial').val();
				var materialtext = $("#laminatingmaterial option:selected").text();
				var selectedData = $('#laminatingmaterial').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;

				var filmsize = $('#laminatingfilmsize').val();
				var laminatingqty = $('#laminatingqty').val();
				var laminatingwastage = $('#laminatingwastage').val();

				$('#tblLaminationDetails > tbody:last').append('<tr class="btnDeleteLamination"><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td class="d-none">' + laminations + '</td><td>' + laminationsText + '</td><td>' + filmsize + '</td><td>' + laminationSide + '</td><td>' + laminatingqty + '</td><td>' + laminatingwastage + '</td></tr>'
				);

				$('#laminatingmaterial').val('').trigger('change');
				$('#hiddenlaminationreset').click();
			}
		});
		$('#btnpasteSubmit').click(function () {
			if (!$("#pastingform")[0].checkValidity()) {
				$("#hiddenpastesubmit").click();
			} else {
				var pastetype = '';
				var pasteMachine = $('#pasteMachine').val();
				var pasteMachineText = $("#pasteMachine option:selected").text();
				var pastetype = $('input[name="pasteType"]:checked').val();

				// if ($('#pasteStraight').is(':checked')) {pastetype=$('#pasteStraight').val();}
				// if ($('#pasteCrash').is(':checked')) {pastetype=$('#pasteCrash').val();}
				// if ($('#pasteManual').is(':checked')) {pastetype=$('#pasteManual').val();}
				
				var materialId = $('#pasteMaterial').val();
				var materialtext = $("#pasteMaterial option:selected").text();
				var selectedData = $('#pasteMaterial').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;

				var pasteQty = $('#pasteQty').val();
				var pasteRemark = $('#pasteRemark').val();

				$('#tblpasteDetails > tbody:last').append('<tr class="btnDeletePasting"><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td class="d-none">' + pasteMachine + '</td><td>' + pasteMachineText + '</td><td>' + pastetype + '</td><td>' + pasteQty + '</td><td>' + pasteRemark + '</td></tr>'
				);

				$('#pasteMaterial').val('').trigger('change');
				$('#hiddenpastereset').click();
			}
		});
		$('#btnRimmingSubmit').click(function () {
			if (!$("#rimmingForm")[0].checkValidity()) {
				$("#hiddenrimmingsubmit").click();
			} else {
				var rimmingMaterialby = $('input[name="rimmingMaterialby"]:checked').val();
				var rimming = $('#rimming').val();
				var rimmingtext = $("#rimming option:selected").text();
				var rimmingside = $('input[name="rimmingside"]:checked').val();

				var materialId = $('#rimmingmaterial').val();
				var materialtext = $("#rimmingmaterial option:selected").text();
				var selectedData = $('#rimmingmaterial').select2('data')[0];
                var materialcode = selectedData ? selectedData.data.code : null;

				var rimmingqty = $('#rimmingqty').val();
				var rimmingRemark = $('#rimmingRemark').val();

				$('#tblRimmingDetails > tbody:last').append('<tr class="btnDeleteRimming"><td>' + rimmingMaterialby + '</td><td class="d-none">' + materialId + '</td><td>' + materialcode + '</td><td>' + materialtext + '</td><td class="d-none">' + rimming + '</td><td>' + rimmingtext + '</td><td>' + rimmingside + '</td><td>' + rimmingqty + '</td><td>' + rimmingRemark + '</td></tr>'
				);

				$('#rimmingmaterial').val('').trigger('change');
				$('#hiddenrimmingreset').click();
			}
		});

		//BOM Other Table Row Removes
		$('#tblMaterialDetails tbody').on('click', '.btnDeleteMaterialtrash', async function() {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
		$('#tblCoatingDetails tbody').on('click', '.btnDeleteVarnish', async function() {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
		$('#tblfoilDetails tbody').on('click', '.btnDeleteFoil', async function() {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
		$('#tblLaminationDetails tbody').on('click', '.btnDeleteLamination', async function () {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
		$('#tblRimmingDetails tbody').on('click', '.btnDeleteRimming', async function () {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
		$('#tblColorDetails tbody').on('click', '.btnDeleteColor', async function () {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
		$('#tblpasteDetails tbody').on('click', '.btnDeletePasting', async function () {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
			}
		});
	});

	function bomtableinfo(){
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';
		
		$('#bomdatatable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/customerjobbomlist.php",
				type: "POST", // you can use GET
				data: function (d) {
					return $.extend({}, d, {
						"customerjobID": $('#hidejobID').val()
					});
				}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [
				// {
				// 	"data": "idtbl_customer_job_details"
				// },
				{
					"data": null,
					"render": function(data, type, full, meta) {
						return meta.row + 1 + meta.settings._iDisplayStart;
					}
				},
				{
					"data": "jobbomname"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';

						button+='<button type="button" class="btn btn-dark btn-sm btnView mr-1" id="'+full['idtbl_jobcard_bom']+'" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></button>';
						if(editcheck==1){
							button+='<button type="button" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_jobcard_bom']+'" data-toggle="tooltip" title="Edit"><i class="fas fa-pen"></i></button>';
						}
						if(full['status']==1 && statuscheck==1){
							button+='<button type="button" data-url="Newcustomerjobs/CustomerJobBomstatus/'+full['idtbl_jobcard_bom']+'/2" data-toggle="tooltip" title="Active" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableactionnoreload"><i class="fas fa-check"></i></button>';
						}else if(full['status']==2 && statuscheck==1){
							button+='<button type="button" data-url="Newcustomerjobs/CustomerJobBomstatus/'+full['idtbl_jobcard_bom']+'/1" data-toggle="tooltip" title="Deactive" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableactionnoreload"><i class="fas fa-times"></i></button>';
						}
						if(deletecheck==1){
							button+='<button type="button" data-url="Newcustomerjobs/CustomerJobBomstatus/'+full['idtbl_jobcard_bom']+'/3" data-toggle="tooltip" title="Delete" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableactionnoreload"><i class="fas fa-trash-alt"></i></button>';
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#bomdatatable tbody').on('click', '.btnEdit', async function() {
			var r = await Otherconfirmation("You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Newcustomerjobs/Newcustomerjobbomedit',
					success: function(result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordbomID').val(obj.id);
						$('#bomtitle').val(obj.jobbomname);

						$('#recordbomOption').val('2');
						$('#btnsubmitbom').html('<i class="far fa-save"></i>&nbsp;Update BOM');
					}
				});
			}
		});
		$('#bomdatatable tbody').on('click', '.btnView', async function() {
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Newcustomerjobs/viewBomInfo',
				success: function(result) { //alert(result);
					$('#showdata').html(result);
					$('#viewBOM').modal('show');
				}
			});
		});
	}

	$(document).on("click", ".btntableactionnoreload", async function () {
		var url = '<?php echo base_url() ?>'+$(this).attr("data-url");
		var actiontype = $(this).attr("data-actiontype");
		var datareturn = await noReloadAjaxControl(url, actiontype);
		var tableId = $(this).closest("table").attr("id");

		var obj = JSON.parse(datareturn);
		if(obj.status==1){
			$('#hidebankreset').click();
			$('#'+tableId).DataTable().ajax.reload( null, false );
		}

		action(obj.action);
	});
</script>
<?php include "include/footer.php"; ?>



