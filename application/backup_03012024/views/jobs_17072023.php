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
							<span>Jobs - [<?php echo $jobId ?>]</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<form id='createJobForm' autocomplete="off">
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Job*</label>
										<input type="text" class="form-control form-control-sm" value = "<?php echo $jobId ?>" name="job_id"
											id="job_id" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Qty *</label>
										<input type="text" class="form-control form-control-sm" name="qty" id="qty"
											required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Material type*</label>
										<select class="form-control form-control-sm" name="board_type" id="board_type"
											required>
											<option value="">Select</option>
											<?php foreach ($boardList->result() as $rowBoard) { ?>
											<option value="<?php echo $rowBoard->idtbl_board ?>">
												<?php echo $rowBoard->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Print type*</label>
										<div></div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="print_type"
												id="inlineRadio1" value="0">
											<label class="form-check-label" for="inlineRadio1">New</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="print_type"
												id="inlineRadio2" value="1">
											<label class="form-check-label" for="inlineRadio2">Existing</label>
										</div>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Cut Size*</label>
										<input type="text" class="form-control form-control-sm" name="cut_size"
											id="cut_size" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Number of ups*</label>
										<input type="text" class="form-control form-control-sm" name="number_ofups"
											id="number_ofups" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Wastage%*</label>
										<input type="text" class="form-control form-control-sm" name="wastage"
											id="wastage" required>
										<input type="hidden" class="form-control form-control-sm" name="wastage_sheets"
											id="wastage_sheets" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">No of sheets*</label>
										<input type="text" class="form-control form-control-sm" name="number_ofsheets"
											id="number_ofsheets" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">No of packates*</label>
										<input type="text" class="form-control form-control-sm" name="number_ofpackets"
											id="number_ofpackets" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Machine*</label>
										<select class="form-control form-control-sm" name="machine" id="machine"
											required>
											<option value="">Select</option>
											<?php foreach ($machineList->result() as $rowMachine) { ?>
											<option value="<?php echo $rowMachine->idtbl_machine ?>">
												<?php echo $rowMachine->machine ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Per hour cost*</label>
										<input type="text" class="form-control form-control-sm" name="per_hour_cost"
											id="per_hour_cost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Speed* <span class = 'text-muted' id = 'maxspeedspan'>(Max speed = 0)</span></label>
										<input type="text" class="form-control form-control-sm" name="speed" id="speed"
											required>
										<input type="hidden" class="form-control form-control-sm" name="defaultspeed" id="defaultspeed"
											required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Total hour*</label>
										<input type="text" class="form-control form-control-sm" name="total_hour"
											id="total_hour" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Cost*</label>
										<input type="text" class="form-control form-control-sm" name="cost" id="cost"
											required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Board cost*</label>
										<input type="text" class="form-control form-control-sm" name="board_cost"
											id="board_cost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Wastage cost*</label>
										<input type="text" class="form-control form-control-sm" name="wastage_cost"
											id="wastage_cost" required>
									</div>
								</div>
								<div class='col-md-12 mt-3'>
									<div class="text-right">
										<h4>Top Summary Total : <span class="text-dark" id="showTopSummary">0.00</span></h4>
										<button type = "button" class = "btn btn-outline-secondary mr-4 topCalculate ">Calculate</button>
										<input type="hidden" id = 'topsummary'>
									</div>
								</div>
								<div class="col-12 mt-4">
									<div class="form-group mb-1">
										<h4>Color Details</h4>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">No of Colors</label>
										<input type="text" class="form-control form-control-sm" name="noofcolors"
											id="noofcolors" required>
									</div>
								</div>
								<div class = "col-md-9"></div>
								<div class="col-6 mt-2">
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap"
											id="tblfrontcolor">
											<thead>
												<tr>
													<th>Front Colors</th>
													<th>Unit Price</th>
													<th>Measurement</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($colorList->result() as $rowColor) { ?>
												<tr>
													<td class='d-none'><?php echo $rowColor->idtbl_color?></td>
													<td><?php echo $rowColor->color?></td>
													<td><?php echo $rowColor->unitprice?></td>
													<td class='text-right measurement'>0</td>
													<td class='d-none fontcolortotal'>0</td>
													<td class='text-right'>Rs.0.00</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-6 mt-2">
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap"
											id="tblbackcolor">
											<thead>
												<tr>
													<th>Back Colors</th>
													<th>Unit Price</th>
													<th>Measurement</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($colorList->result() as $rowColor) { ?>
												<tr>
													<td class='d-none'><?php echo $rowColor->idtbl_color?></td>
													<td><?php echo $rowColor->color?></td>
													<td><?php echo $rowColor->unitprice?></td>
													<td class='text-right measurement'>0</td>
													<td class='d-none backcolortotal'>0</td>
													<td class='text-right'>Rs.0.00</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class='col-md-12 mt-3'>
									<div class="text-right">
										<h4>Color Total : <span class="text-dark" id="showPrice">0.00</span></h4>
									</div>
								</div>
								<div class="col-12 mt-4">
									<div class="form-group mb-1">
										<h4>Other Details</h4>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Front Varnish*</label>
										<select class="form-control form-control-sm" name="frontvarnish" id="frontvarnish"
											required>
											<option value="">Select</option>
											<?php foreach ($varnishList->result() as $rowvarnish) { ?>
											<option value="<?php echo $rowvarnish->idtbl_varnish ?>">
												<?php echo $rowvarnish->varnish ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Per square cost</label>
										<input type="text" class="form-control form-control-sm" name="frontpersquarecost"
											id="frontpersquarecost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Front Varnish Inches</label>
										<input type="text" class="form-control form-control-sm" name="frontvarnishinches"
											id="frontvarnishinches" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Front Varnish Cost</label>
										<input type="text" class="form-control form-control-sm" name="frontvarnishcost"
											id="frontvarnishcost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Back Varnish*</label>
										<select class="form-control form-control-sm" name="backvarnish" id="backvarnish"
											required>
											<option value="">Select</option>
											<?php foreach ($varnishList->result() as $rowvarnish) { ?>
											<option value="<?php echo $rowvarnish->idtbl_varnish ?>">
												<?php echo $rowvarnish->varnish ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Per square cost</label>
										<input type="text" class="form-control form-control-sm" name="backpersquarecost"
											id="backpersquarecost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Back Varnish Inches</label>
										<input type="text" class="form-control form-control-sm" name="backvarnishinches"
											id="backvarnishinches" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Back Varnish Cost</label>
										<input type="text" class="form-control form-control-sm" name="backvarnishcost"
											id="backvarnishcost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Lamination*</label>
										<select class="form-control form-control-sm" name="laminationtype"
											id="laminationtype" required>
											<option value="">Select</option>
											<?php foreach ($laminationList->result() as $rowlamination) { ?>
											<option value="<?php echo $rowlamination->idtbl_lamination ?>">
												<?php echo $rowlamination->lamination ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Per square cost</label>
										<input type="text" class="form-control form-control-sm" name="laminationpersquarecost"
											id="laminationpersquarecost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Laminating Inches</label>
										<input type="text" class="form-control form-control-sm" name="laminateinches"
											id="laminateinches" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Laminating Cost</label>
										<input type="text" class="form-control form-control-sm" name="laminationcost"
											id="laminationcost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Foiling*</label>
										<select class="form-control form-control-sm" name="foiling"
											id="foiling" required>
											<option value="">Select</option>
											<?php foreach ($foilingList->result() as $rowfoiling) { ?>
											<option value="<?php echo $rowfoiling->idtbl_foiling ?>">
												<?php echo $rowfoiling->foiling ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Per square cost</label>
										<input type="text" class="form-control form-control-sm" name="foilingpersquarecost"
											id="foilingpersquarecost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Foiling Inches</label>
										<input type="text" class="form-control form-control-sm" name="foilinginches"
											id="foilinginches" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Foiling Cost</label>
										<input type="text" class="form-control form-control-sm" name="foilingcost"
											id="foilingcost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Cutting & Embossing*</label>
										<input type="text" class="form-control form-control-sm" name="cuttingembossing"
											id="cuttingembossing" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Pasting</label>
										<input type="text" class="form-control form-control-sm" name="pasting"
											id="pasting" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Pasting Cost</label>
										<input type="text" class="form-control form-control-sm" name="pastingcost"
											id="pastingcost" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Rimming*</label>
										<select class="form-control form-control-sm" name="rimmingtype" id="rimmingtype"
											required>
											<option value="">Select</option>
											<?php foreach ($rimmingList->result() as $rowrimming) { ?>
											<option value="<?php echo $rowrimming->idtbl_rimming ?>">
												<?php echo $rowrimming->rimming ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Rimming Inches</label>
										<input type="text" class="form-control form-control-sm" name="rimminginches"
											id="rimminginches" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Film Charges</label>
										<input type="text" class="form-control form-control-sm" name="filmcharges"
											id="filmcharges" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Plates*</label>
										<select class="form-control form-control-sm" name="platetype" id="platetype"
											required>
											<option value="">Select</option>
											<?php foreach ($platesList->result() as $rowPlates) { ?>
											<option value="<?php echo $rowPlates->idtbl_plates ?>">
												<?php echo $rowPlates->plate ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">No of Plates</label>
										<input type="text" class="form-control form-control-sm" name="noofplates"
											id="noofplates" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Embosing Block Qty</label>
										<input type="text" class="form-control form-control-sm" name="embosingqty"
											id="embosingqty" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Embosing Block Price</label>
										<input type="text" class="form-control form-control-sm" name="embosing"
											id="embosing" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Foiling Blocks Qty</label>
										<input type="text" class="form-control form-control-sm" name="foilingqty"
											id="foilingqty" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Foiling Blocks Price</label>
										<input type="text" class="form-control form-control-sm" name="foilingblockprice"
											id="foilingblockprice" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Cutter</label>
										<input type="text" class="form-control form-control-sm" name="cutter"
											id="cutter" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Window patch film</label>
										<input type="text" class="form-control form-control-sm" name="windowpatch"
											id="windowpatch" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Window pasting</label>
										<input type="text" class="form-control form-control-sm" name="windowpasting"
											id="windowpasting" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Board lamination</label>
										<input type="text" class="form-control form-control-sm" name="boardlamination"
											id="boardlamination" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Transport</label>
										<input type="text" class="form-control form-control-sm" name="transport"
											id="transport" required>
									</div>
								</div>
								<div class='col-md-12 mt-3'>
									<div class="text-right">
										<h4>Bottom Summary Total : <span class="text-dark" id="showBottomSummary">0.00</span></h4>
										<h4>Summary Total : <span class="text-dark" id="showTotalSummary">0.00</span></h4>

										<button type = "button" class = "btn btn-outline-secondary mr-4 bottomCalculate mt-1">Calculate</button>
										<input type="hidden" id = 'bottomsummary'>
										<input type="hidden" id = 'totalsummary'>
									</div>
								</div>
								<div class="col">
									<div class="form-group mt-2 text-right" style="padding-top: 25px;">
										<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
											><i
												class="far fa-save"></i>&nbsp;Add</button>
										<button type="submit" id='submitBtn' class='d-none'>Add</button>
									</div>
								</div>
							</div>

							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
						</form>
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

		$(window).keydown(function (e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				return false;
			}
		});

		$('#tblfrontcolor tbody').on('click', '.measurement', function (e) {
			var row = $(this);
	
			e.preventDefault();
			e.stopImmediatePropagation();

			$this = $(this);
			if ($this.data('editing')) return;

			var val = $this.text();

			$this.empty();
			$this.data('editing', true);

			$('<input type="Text" class="form-control form-control-sm frontmeasurement">').val(val)
				.appendTo($this);

			textremove('.frontmeasurement', row, 'tblfrontcolor');
		});

		$('#tblbackcolor tbody').on('click', '.measurement', function (e) {
			var row = $(this);

			e.preventDefault();
			e.stopImmediatePropagation();

			$this = $(this);
			if ($this.data('editing')) return;

			var val = $this.text();

			$this.empty();
			$this.data('editing', true);

			$('<input type="Text" class="form-control form-control-sm backmeasurement">').val(val)
				.appendTo($this);
			textremove('.backmeasurement', row, 'tblbackcolor');
		});
	});

	$('#wastage').keyup(function () {
		calculateSheets();
	})

	$('#qty').keyup(function () {
		calculateSheets();
		calculateTotalHours()
	})

	$('#number_ofups').keyup(function () {
		calculateSheets();
		calculatePasting();

	})
	$('#speed').keyup(function () {
		calculateTotalHours();
	})
	$('#frontpersquarecost').change(function () {
		calculateVarnish(true);
	})
	$('#frontvarnishinches').keyup(function () {
		calculateVarnish(true);
	})
	$('#frontpersquarecost').change(function () {
		calculateVarnish(false);
	})
	$('#backvarnishinches').keyup(function () {
		calculateVarnish(false);
	})
	$('#laminateinches').keyup(function () {
		calculateLaminationTotal();
	})
	$('#laminationpersquarecost').change(function () {
		calculateLaminationTotal();
	})
	$('#foilinginches').keyup(function () {
		calculateFoilingTotal();
	})
	$('#foilingpersquarecost').change(function () {
		calculateFoilingTotal();
	})
	$('#pasting').keyup(function () {
		calculatePasting();
	})
	$('#noofcolors').keyup(function () {
		var colors = $(this).val();
		$('#noofplates').val(colors);
	})

	$('#machine').change(function () {
		var machineId = $(this).val();

		$.ajax({
			type: "POST",
			data: {
				recordID: machineId,
			},
			url: '<?php echo base_url() ?>Machine/Machineedit',
			success: function (result) {
				var obj = JSON.parse(result);
                $('#per_hour_cost').val(obj.perhour_cost);
                $('#defaultspeed').val(obj.perhour_maxoutput);
                $('#maxspeedspan').html(`(Max speed = ${obj.perhour_maxoutput})`);
			}
		});
	})

	$('#frontvarnish').change(function () {
		var varnishId = $(this).val();

		$.ajax({
			type: "POST",
			data: {
				recordID: varnishId,
			},
			url: '<?php echo base_url() ?>Varnish/Varnishedit',
			success: function (result) {
				var obj = JSON.parse(result);
                $('#frontpersquarecost').val(obj.perinch_cost);
                
			}
		});
	})
	$('#backvarnish').change(function () {
		var varnishId = $(this).val();

		$.ajax({
			type: "POST",
			data: {
				recordID: varnishId,
			},
			url: '<?php echo base_url() ?>Varnish/Varnishedit',
			success: function (result) {
				var obj = JSON.parse(result);
                $('#backpersquarecost').val(obj.perinch_cost);
                
			}
		});
	})
	$('#laminationtype').change(function () {
		var laminatingId = $(this).val();

		$.ajax({
			type: "POST",
			data: {
				recordID: laminatingId,
			},
			url: '<?php echo base_url() ?>Lamination/Laminationedit',
			success: function (result) {
				var obj = JSON.parse(result);
                $('#laminationpersquarecost').val(obj.squareinchcost);
                
			}
		});
	})
	$('#foiling').change(function () {
		var foilingId = $(this).val();

		$.ajax({
			type: "POST",
			data: {
				recordID: foilingId,
			},
			url: '<?php echo base_url() ?>Foiling/Foilingedit',
			success: function (result) {
				var obj = JSON.parse(result);
                $('#foilingpersquarecost').val(obj.perinch_cost);
                
			}
		});
	})

	$("#formsubmit").click(function () {
		// !$("#createJobForm")[0].checkValidity()
		if (false) {
			$("#submitBtn").click();
		} else {
			alert('sss')
			let form = $('#createJobForm').serialize();
			let formData = 'test';
			let formData2 = 'tes2';

			$.ajax({
				type: "POST",
				data: form + 'formData='+formData+'&formData2='+formData2,
				url: '<?php echo base_url() ?>Jobs/JobInsertUpdate',
				success: function (result) {
					location.reload()
				}
			});
		}
	});

	$('.topCalculate').click(function(){
		calculateTopSummary()
	})
	$('.bottomCalculate').click(function(){
		calculateBottomSummary()
	})

	function calculateTopSummary(){
		var cost = parseFloat($('#cost').val());
		var boardcost = parseFloat($('#board_cost').val());
		var wastagecost = parseFloat($('#wastage_cost').val());

		if(cost && boardcost && wastagecost){
			var topCost = cost + boardcost + wastagecost;
			var showsum = addCommas(parseFloat(topCost).toFixed(2));
			$('#showTopSummary').html(showsum);
			$('#topsummary').val(topCost);
		}
	}
	function calculateBottomSummary(){
		var frontvarnishcost = parseFloat($('#frontvarnishcost').val());
		var backvarnishcost = parseFloat($('#backvarnishcost').val());
		var laminationcost = parseFloat($('#laminationcost').val());
		var foilingcost = parseFloat($('#foilingcost').val());
		var cuttingembossing = parseFloat($('#cuttingembossing').val());
		var pastingcost = parseFloat($('#pastingcost').val());
		//Did not add rimming price
		var filmcharges = parseFloat($('#filmcharges').val());
		var embosing = parseFloat($('#embosing').val());
		var foilingblockprice = parseFloat($('#foilingblockprice').val());
		var boardlamination = parseFloat($('#boardlamination').val());
		var transport = parseFloat($('#transport').val());

		var bottomCost = frontvarnishcost + backvarnishcost + laminationcost + foilingcost + cuttingembossing + pastingcost + filmcharges + embosing + foilingblockprice + boardlamination + transport;
		var showsum = addCommas(parseFloat(bottomCost).toFixed(2));
		$('#showBottomSummary').html(showsum);
		$('#bottomsummary').val(bottomCost);

		calculateFullTotal()
	}

	function calculateFullTotal(){
		var bottomsummary = parseFloat($('#bottomsummary').val())
		var topsummary = parseFloat($('#topsummary').val())

		var totsummary = bottomsummary + topsummary;

		var showsum = addCommas(parseFloat(totsummary).toFixed(2));
		$('#showTotalSummary').html(showsum);
		$('#totalsummary').val(totsummary);
	}
	function calculateVarnish(front) {
		var frontInches = $('#frontvarnishinches').val();
		var frontsquareCost = $('#frontpersquarecost').val();
		var backsquareCost = $('#backpersquarecost').val();
		var backInches = $('#backvarnishinches').val();

		
		if(front && frontInches && frontsquareCost){
			var frontCost = frontsquareCost * frontInches;

			$('#frontvarnishcost').val(frontCost);
		}
		if(!front && backInches && backsquareCost){
			var backCost = backsquareCost * backInches;
			$('#backvarnishcost').val(backCost);
		}
	}

	function calculateSummaryTotal() {
		var wastage = $('#wastage').val();
		var qty = $('#qty').val();
		var nou = $('#number_ofups').val();

		if (wastage && qty && nou) {
			var sheets = Math.ceil(qty / nou);
			var wastageSheets = Math.ceil(sheets * wastage / 100);
			var totalSheets = sheets + wastageSheets;

			$('#number_ofsheets').val(totalSheets);
			$('#wastage_sheets').val(wastageSheets);
		}

	}
	function calculateSheets() {
		var wastage = $('#wastage').val();
		var qty = $('#qty').val();
		var nou = $('#number_ofups').val();

		if (wastage && qty && nou) {
			var sheets = Math.ceil(qty / nou);
			var wastageSheets = Math.ceil(sheets * wastage / 100);
			var totalSheets = sheets + wastageSheets;

			$('#number_ofsheets').val(totalSheets);
			$('#wastage_sheets').val(wastageSheets);
		}

	}

	function calculateLaminationTotal() {
		var inches = $('#laminateinches').val();
		var squarecost = $('#laminationpersquarecost').val();

		if (squarecost && inches) {
			var total = squarecost * inches;

			$('#laminationcost').val(total);
		}

	}
	function calculateFoilingTotal() {
		var inches = $('#foilinginches').val();
		var squarecost = $('#foilingpersquarecost').val();

		if (squarecost && inches) {
			var total = squarecost * inches;

			$('#foilingcost').val(total);
		}

	}
	function calculatePasting() {
		var nou = $('#number_ofups').val();
		var pasting = $('#pasting').val();

		if (pasting && nou) {
			var total = nou * pasting;

			$('#pastingcost').val(total);
		}

	}

	function calculateTotalHours() {
		var speed = $('#speed').val();
		var qty = $('#qty').val();
		var perhourcost = $('#per_hour_cost').val();

		if (speed && qty && perhourcost) {
			var totalHours = Math.ceil(qty / speed);
			var totalcost = perhourcost * totalHours;

			$('#total_hour').val(totalHours);
			$('#cost').val(totalcost);
		}

	}

	function textremove(classname, row, tableName) {
		$(`#${tableName} tbody`).on('keyup', classname, function (e) {
			if (e.keyCode === 13) {
				$this = $(this);
				var val = $this.val();
				var td = $this.closest('td');
				td.empty().html(val).data('editing', false);

                var rowID = row.closest("td").parent()[0].rowIndex;
				var unitprice = parseFloat(row.closest("tr").find('td:eq(2)').text());
				var totnew = val * unitprice;

				var total = parseFloat(totnew).toFixed(2);
				var showtotal = addCommas(total);

				row.closest("tr").find('td:eq(4)').text(total);
				row.closest("tr").find('td:eq(5)').text(showtotal);

				// $(`#${tableName}`).find('tr').eq(rowID).find('td:eq(4)').text(total);
                // $(`#${tableName}`).find('tr').eq(rowID).find('td:eq(5)').text(showtotal);

				calculatetotal()
			}
		});
	}

	function calculatetotal() {
		var sum = 0;
		$(".fontcolortotal").each(function () {
			sum += parseFloat($(this).text());
		});

		$(".backcolortotal").each(function () {
			sum += parseFloat($(this).text());
		});

		var showsum = addCommas(parseFloat(sum).toFixed(2));

		$('#showPrice').html('Rs. ' + showsum);
		$('#txtShowPrice').val(sum);
	}

	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
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