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
        					<div class="page-header-icon"><i class="fa fa-file-alt"></i></div>
        					<span><b> Edit Customer Job Quatation</b></span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                    <form action="<?php echo base_url()?>Quatation/Quotationinsertupdate" method="post" autocomplete="off">
                        <div class="12">
                            <div class="form-row">
                                <div class="col-3">
                                    <label class="small font-weight-bold">Customer*</label>
                                    <select class="form-control form-control-sm" name="customer" id="customer" readonly>
                                        <option value="">Select</option>
                                        <?php foreach ($customerlist->result() as $rowcustomer) { ?>
                                     <option value="<?php echo $rowcustomer->idtbl_customer; ?>" <?php echo ($rowcustomer->idtbl_customer == $quotationDetails['quotation']['customer_id']) ? 'selected' : ''; ?>>
                                            <?php echo $rowcustomer->name ?></option> <?php } ?>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="small font-weight-bold">Jobs*</label>
                                    <select class="form-control form-control-sm" name="customerjob" id="customerjob" readonly>
										<option value="">Select</option>
											<?php foreach ($jobslist->result() as $rowjobs) { ?>
										<option value="<?php echo $rowjobs->idtbl_customer_job_details; ?>" <?php echo ($rowjobs->idtbl_customer_job_details == $quotationDetails['quotation']['customerjob_id']) ? 'selected' : ''; ?>>
												<?php echo $rowjobs->job_name ?></option> <?php } ?>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="small font-weight-bold">Job No*</label>
                                    <select class="form-control form-control-sm" name="jobno" id="jobno" readonly>
                                        <option value="">Select</option>
                                        <?php foreach ($jobidlist->result() as $rowjobid) { ?>
                                     <option value="<?php echo $rowjobid->job_id; ?>" <?php echo ($rowjobid->job_id == $quotationDetails['quotation']['customer_jobno']) ? 'selected' : ''; ?>>
                                            <?php echo $rowjobid->job_no ?></option> <?php } ?>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <lable class="font-weight-bold small">Quantity*</lable>
                                    <input type="number" name="quantity" id="quantity" class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['quantity']); ?>">
                                </div>
                            </div>

                            <div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Board/Paper*</label>
                        				<select class="form-control form-control-sm" name="boardpaper" id="boardpaper"
                        					required>
                        					<option value="">Select</option>
                        					<?php foreach ($materiallist->result() as $rowmaterial) { ?>
                        					<option value="<?php echo $rowmaterial->idtbl_print_material_info ;?>" <?php echo ($rowmaterial->idtbl_print_material_info == $quotationDetails['quotation']['tbl_print_material_info_idtbl_print_material_info']) ? 'selected' : ''; ?>>
                        						<?php echo $rowmaterial->materialname ?></option> <?php } ?>
                        				</select>
                        			</div>

                                    <div class="col-3">
                        				<label class="small font-weight-bold">Printing Format*</label>
                        				<select class="form-control form-control-sm" name="printformat" id="printformat"
                        					required>
                        					<option value="">Select</option>
                        					<?php foreach ($printingformatlist->result() as $rowprintingformatlist) { ?>
                        					<option value="<?php echo $rowprintingformatlist->idtbl_printing_format ?>" <?php echo ($rowprintingformatlist->idtbl_printing_format == $quotationDetails['quotation']['tbl_printing_format_idtbl_printing_format']) ? 'selected' : ''; ?>>
                        						<?php echo $rowprintingformatlist->format_name ?> -
                        						<?php echo $rowprintingformatlist->printing_width ?>mm X
                        						<?php echo $rowprintingformatlist->printing_height ?>mm</option>
                        					<?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-6">
                        				<lable class="font-weight-bold small">Cutting Size*</lable>
                        				<div class="row">
                        					<div class="col-6">
                        						<input type="number" step="any" name="cutsize1" id="cutsize1"
                        							class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['cutsize_width']); ?>">
                        					</div>
                        					<div class="col-1">
                        						<lable style="margin-top:20px;">X</lable>
                        					</div>
                        					<div class="col-5">
                        						<input type="number" step="any" name="cutsize2" id="cutsize2"
                        							class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['cutsize_height']); ?>">
                        					</div>
                        				</div>
                        			</div>
                        	</div>
                            <div class="form-row">
                        			<div class="col-2">
                        				<lable class="font-weight-bold small">No of Pcts*</lable>
                        				<input type="number" name="noofpacts" id="noofpacts" step="any"
                        					class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['no_of_pcts']); ?>">
                        			</div>
                        			<div class="col-2">
                        				<lable class="font-weight-bold small">No Sheets*</lable>
                        				<input type="number" name="nosheet" id="nosheet" step="any"
                        					class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['no_sheet']); ?>" >
                        			</div>
                        			<div class="col-2">
                        				<lable class="font-weight-bold small">Wastage*</lable>
                        				<input type="number" name="wastage" id="wastage" step="any"
                        					class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['wastage']); ?>">
                        			</div>
                                    <div class="col-4">
                        				<lable class="font-weight-bold small">Board*</lable>
                        				<div class="row">
                        					<div class="col">
                        						<input type="number" name="boardsize1" id="boardsize1" step="any"
                        							class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['board_width']); ?>">
                        					</div>
                        					<div class="col">
                        						<input type="number" name="boardsize12" id="boardsize12" step="any"
                        							class="form-control form-control-sm mt-2" value="<?php echo ($quotationDetails['quotation']['board_height']); ?>">
                        					</div>
                        				</div>
                        			</div>
                                    <div class="col-2">
                        				<lable class="font-weight-bold small">Wastage Board*</lable>
                        				<input type="number" name="wastageboard" id="wastageboard"
                        					class="form-control form-control-sm mt-2" step="any" value="<?php echo ($quotationDetails['quotation']['wastage_board']); ?>">
                        			</div>
                        		</div>
                        		<div class="form-row">
                        			<div class="col-6">
                        				<lable class="font-weight-bold small">Cut Size*</lable>
                        				<div class="row">
                        					<div class="col-6">
                        						<input type="number" name="cutsize3" id="cutsize3" step="any" value="<?php echo ($quotationDetails['quotation']['board_cut1']); ?>"
                        							class="form-control form-control-sm mt-2">
                        					</div>
                        					<div class="col-6">
                        						<input type="number" name="cutsize4" id="cutsize4" step="any" value="<?php echo ($quotationDetails['quotation']['board_cut2']); ?>"
                        							class="form-control form-control-sm mt-2">
                        					</div>
                        				</div>
                        			</div>
                        			<div class="col-3">
                        				<lable class="font-weight-bold small">No Of Cut Sheets Per Pct*</lable>
                        				<input type="number" name="cutssheetsper" id="cutssheetsper" step="any" value="<?php echo ($quotationDetails['quotation']['no_ofcutsheet_perpct']); ?>"
                        					class="form-control form-control-sm mt-2">
                        			</div>
                        			<div class="col-3">
                        				<lable class="font-weight-bold small">No Of Ups*</lable>
                        				<input type="number" name="noofups" id="noofups" step="any" value="<?php echo ($quotationDetails['quotation']['no_of_ups']); ?>"
                        					class="form-control form-control-sm mt-2">
                        			</div>
                        		</div>
                        </div>

                        <hr style=" border: 2; height: 1px; background: #333; width: 100%;">

                        	<div class="col-12">
                        		<div class="form-row">
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Board/Paper*</label>
                        				<select class="form-control form-control-sm" name="boardpaperselect"
                        					id="boardpaperselect" required>
                        					<option value="">Select</option>
                        					<?php foreach ($materiallist->result() as $rowmaterial) { ?>
                        					<option value="<?php echo $rowmaterial->idtbl_print_material_info ?>" <?php echo ($rowmaterial->idtbl_print_material_info == $quotationDetails['materialDetail']['tbl_print_material_info_idtbl_print_material_info']) ? 'selected' : ''; ?>>
                        						<?php echo $rowmaterial->materialname ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="boardpaperbatch" id="boardpaperbatch">
                        					<option  >Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="board_unitprice" id="board_unitprice" step="any"
                        					class="form-control form-control-sm" oninput="calmaterialtotal()" value="<?php echo ($quotationDetails['materialDetail']['unit_price']); ?>">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Width*</label>
                        				<input type="number" name="board_quantity" id="board_quantity" step="any"
                        					class="form-control form-control-sm" oninput="calmaterialtotal()" value="<?php echo ($quotationDetails['materialDetail']['board_width']); ?>">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Height *</label>
                        				<input type="number" name="board_quantity2" id="board_quantity2" step="any" value="<?php echo ($quotationDetails['materialDetail']['board_height']); ?>"
                        					class="form-control form-control-sm" oninput="calmaterialtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="board_total" id="board_total" step="any" value="<?php echo ($quotationDetails['materialDetail']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="materialrow_id" value="<?php echo ($quotationDetails['materialDetail']['idtbl_jobquatation_material_detail']); ?>">
                        		</div>

                        		<div class="form-row">
                        			<div class="col-4">
                        				<label class="small font-weight-bold">Wastage %*</label>
                        				<input type="number" name="wastagelist" id="wastagelist" step="any"
                        					class="form-control form-control-sm" oninput="calwastagetotal()" value="<?php echo ($quotationDetails['wastageDetails']['wastage']); ?>">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Cal 1*</label>
                        				<input type="number" name="wastage_cal1" id="wastage_cal1" step="any" value="<?php echo ($quotationDetails['wastageDetails']['wastage_cal1']); ?>"
                        					class="form-control form-control-sm">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Cal 2 *</label>
                        				<input type="number" name="wastage_cal2" id="wastage_cal2" step="any" value="<?php echo ($quotationDetails['wastageDetails']['wastage_cal2']); ?>"
                        					class="form-control form-control-sm">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="wastage_total" id="wastage_total" step="any" value="<?php echo ($quotationDetails['wastageDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="wastagerow_id" value="<?php echo ($quotationDetails['wastageDetails']['idtbl_jobquotation_wastage_details']); ?>">
                        		</div>

                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Colors*</label>
                        				<select class="form-control form-control-sm" name="colors" id="colors">
                        					<option value="">Select</option>
                        					<?php foreach ($colorlist->result() as $rowcolorlist) { ?>
                        					<option value="<?php echo $rowcolorlist->idtbl_print_color ?>" <?php echo ($rowcolorlist->idtbl_print_color == $quotationDetails['colorDetails']['tbl_print_color_idtbl_print_color']) ? 'selected' : ''; ?>>
                        						<?php echo $rowcolorlist->color_name ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="colorsbatch" id="colorsbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="colors_unitprice" id="colors_unitprice" step="any" value="<?php echo ($quotationDetails['colorDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calcolortotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">QTY*</label>
                        				<input type="number" name="colors_quantity" id="colors_quantity" step="any" value="<?php echo ($quotationDetails['colorDetails']['qty']); ?>"
                        					class="form-control form-control-sm" oninput="calcolortotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="colors_total" id="colors_total" step="any" value="<?php echo ($quotationDetails['colorDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="colorrow_id" value="<?php echo ($quotationDetails['colorDetails']['idtbl_jobquotation_color_details']); ?>">
                        		</div>

                        		<div class="form-row">
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Varnish*</label>
                        				<select class="form-control form-control-sm" name="varnish" id="varnish" >
                        					<option value="">Select</option>
                        					<?php foreach ($varnishlist->result() as $rowvarnishlist) { ?>
                        					<option value="<?php echo $rowvarnishlist->idtbl_print_material_info ?>" <?php echo ($rowvarnishlist->idtbl_print_material_info == $quotationDetails['varnishDetails']['tbl_print_material_info_idtbl_print_material_info']) ? 'selected' : ''; ?>>
                        						<?php echo $rowvarnishlist->materialname ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="varnishbatch"
                        					id="varnishbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="varnish_unitprice" id="varnish_unitprice" step="any" value="<?php echo ($quotationDetails['varnishDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calvarnishtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Width*</label>
                        				<input type="number" name="varnish_quantity" id="varnish_quantity" step="any" value="<?php echo ($quotationDetails['varnishDetails']['qty1']); ?>"
                        					class="form-control form-control-sm" oninput="calvarnishtotal()"> 
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Height*</label>
                        				<input type="number" name="varnish_quantity2" id="varnish_quantity2" step="any" value="<?php echo ($quotationDetails['varnishDetails']['qty2']); ?>"
                        					class="form-control form-control-sm" oninput="calvarnishtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label> 
                        				<input type="number" name="varnish_total" id="varnish_total" step="any" value="<?php echo ($quotationDetails['varnishDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="varnishrow_id" value="<?php echo ($quotationDetails['varnishDetails']['idtbl_jobquotation_varnish_details']); ?>">
                        		</div>

                        		<div class="form-row">
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Lamination*</label>
                        				<select class="form-control form-control-sm" name="lamination" id="lamination" >
                        					<option value="">Select</option>
                        					<?php foreach ($laminationlist->result() as $rowlaminationlist) { ?>
                        					<option value="<?php echo $rowlaminationlist->idtbl_print_material_info ?>" <?php echo ($rowlaminationlist->idtbl_print_material_info == $quotationDetails['laminationDetails']['tbl_print_material_info_idtbl_print_material_info']) ? 'selected' : ''; ?>>
                        						<?php echo $rowlaminationlist->materialname ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="laminationbatch"
                        					id="laminationbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="lamination_unitprice" id="lamination_unitprice" step="any" value="<?php echo ($quotationDetails['laminationDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="callaminationtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Width*</label>
                        				<input type="number" name="lamination_quantity" id="lamination_quantity" step="any" value="<?php echo ($quotationDetails['laminationDetails']['qty1']); ?>"
                        					class="form-control form-control-sm" oninput="callaminationtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Height*</label>
                        				<input type="number" name="lamination_quantity2" id="lamination_quantity2" step="any" value="<?php echo ($quotationDetails['laminationDetails']['qty2']); ?>"
                        					class="form-control form-control-sm" oninput="callaminationtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="lamination_total" id="lamination_total" step="any" value="<?php echo ($quotationDetails['laminationDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="laminationrow_id" value="<?php echo ($quotationDetails['laminationDetails']['idtbl_jobquotation_lamination_details']); ?>">
                        		</div>

                        		<div class="form-row">
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Foiling*</label>
                        				<select class="form-control form-control-sm" name="foiling" id="foiling">
                        					<option value="">Select</option>
                        					<?php foreach ($foilinglist->result() as $rowfoilinglist) { ?>
                        					<option value="<?php echo $rowfoilinglist->idtbl_foiling ?>" <?php echo ($rowfoilinglist->idtbl_foiling == $quotationDetails['foilingDetails']['tbl_foiling_idtbl_foiling']) ? 'selected' : ''; ?>>
                        						<?php echo $rowfoilinglist->foiling ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="foilingbatch"
                        					id="foilingbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label> 
                        				<input type="number" name="foiling_unitprice" id="foiling_unitprice" step="any" value="<?php echo ($quotationDetails['foilingDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calfoldingtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Width*</label>
                        				<input type="number" name="foiling_quantity" id="foiling_quantity" step="any" value="<?php echo ($quotationDetails['foilingDetails']['qty1']); ?>"
                        					class="form-control form-control-sm" oninput="calfoldingtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Height*</label>
                        				<input type="number" name="foiling_quantity2" id="foiling_quantity2" step="any" value="<?php echo ($quotationDetails['foilingDetails']['qty2']); ?>"
                        					class="form-control form-control-sm" oninput="calfoldingtotal()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label> 
                        				<input type="number" name="foiling_total" id="foiling_total" step="any" value="<?php echo ($quotationDetails['foilingDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="foliingrow_id" value="<?php echo ($quotationDetails['foilingDetails']['idtbl_jobquotation_foiling_details']); ?>">
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Rimmimg*</label>
                        				<select class="form-control form-control-sm" name="rimming" id="rimming" >
                        					<option value="">Select</option>
                        					<?php foreach ($rimminglist->result() as $rowrimminglist) { ?>
                        					<option value="<?php echo $rowrimminglist->idtbl_rimming ?>" <?php echo ($rowrimminglist->idtbl_rimming == $quotationDetails['rimmingDetails']['tbl_rimming_idtbl_rimming']) ? 'selected' : ''; ?>>
                        						<?php echo $rowrimminglist->rimming ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="rimmingbatch"
                        					id="rimmingbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="rimming_unitprice" id="rimming_unitprice" step="any" value="<?php echo ($quotationDetails['rimmingDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calrimming()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">QTY*</label>
                        				<input type="number" name="rimming_quantity" id="rimming_quantity" step="any" value="<?php echo ($quotationDetails['rimmingDetails']['qty']); ?>"
                        					class="form-control form-control-sm" oninput="calrimming()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="rimming_total" id="rimming_total" step="any" value="<?php echo ($quotationDetails['rimmingDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="rimmingrow_id" value="<?php echo ($quotationDetails['rimmingDetails']['idtbl_jobquotation_rimming_details']); ?>">
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Cutting*</label>
                        				<select class="form-control form-control-sm" name="cutting" id="cutting" >
                        					<option value="">Select</option>
                        					<?php foreach ($diecuttinglist->result() as $rowdiecuttinglist) { ?>
                        					<option value="<?php echo $rowdiecuttinglist->idtbl_diecutting ?>" <?php echo ($rowdiecuttinglist->idtbl_diecutting == $quotationDetails['cuttingDetails']['tbl_diecutting_idtbl_diecutting']) ? 'selected' : ''; ?>>
                        						<?php echo $rowdiecuttinglist->diecutting_name ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="cuttingbatch"
                        					id="cuttingbatch" >
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="cutting_unitprice" id="cutting_unitprice" step="any" value="<?php echo ($quotationDetails['cuttingDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calcutting()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">QTY*</label>
                        				<input type="number" name="cutting_quantity" id="cutting_quantity" step="any" value="<?php echo ($quotationDetails['cuttingDetails']['qty']); ?>"
                        					class="form-control form-control-sm" oninput="calcutting()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="cutting_total" id="cutting_total" step="any" value="<?php echo ($quotationDetails['cuttingDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="cuttingrow_id" value="<?php echo ($quotationDetails['cuttingDetails']['idtbl_jobquotation_diecutting_details']); ?>">
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Pasting*</label>
                        				<select class="form-control form-control-sm" name="pasting" id="pasting">
                        					<option value="">Select</option>
                        					<?php foreach ($pastinglist->result() as $rowpastinglist) { ?>
                        					<option value="<?php echo $rowpastinglist->idtbl_pasting ?>" <?php echo ($rowpastinglist->idtbl_pasting == $quotationDetails['pastingDetails']['tbl_pasting_idtbl_pasting']) ? 'selected' : ''; ?>>
                        						<?php echo $rowpastinglist->pasting_name ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="pastingbatch"
                        					id="pastingbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="pasting_unitprice" id="pasting_unitprice" step="any"  value="<?php echo ($quotationDetails['pastingDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calpasting()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">QTY*</label>
                        				<input type="number" name="pasting_quantity" id="pasting_quantity" step="any"  value="<?php echo ($quotationDetails['pastingDetails']['qty']); ?>"
                        					class="form-control form-control-sm" oninput="calpasting()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="pasting_total" id="pasting_total" step="any"  value="<?php echo ($quotationDetails['pastingDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="pastingrow_id" value="<?php echo ($quotationDetails['pastingDetails']['idtbl_jobquotation_pasting_details']); ?>">
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Film Charges Price*</label>
                        				<input type="number" name="filmchage_unitprice" id="filmchage_unitprice" step="any" value="<?php echo ($quotationDetails['filmchargeDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calfilmcharge()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Width*</label>
                        				<input type="number" name="filmchage_quantity" id="filmchage_quantity" step="any" value="<?php echo ($quotationDetails['filmchargeDetails']['qty']); ?>"
                        					class="form-control form-control-sm" oninput="calfilmcharge()">
                        			</div>
                        			<div class="col-4">
                        				<label class="small font-weight-bold">Height*</label>
                        				<input type="number" name="filmchage_quantity2" id="filmchage_quantity2" step="any" value="<?php echo ($quotationDetails['filmchargeDetails']['qty2']); ?>"
                        					class="form-control form-control-sm" oninput="calfilmcharge()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label> 
                        				<input type="number" name="filmchage_total" id="filmchage_total" step="any" value="<?php echo ($quotationDetails['filmchargeDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="filmchrgerow_id" value="<?php echo ($quotationDetails['filmchargeDetails']['idtbl_jobquotation_filmcharge_details']); ?>">
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Plates*</label>
                        				<select class="form-control form-control-sm" name="plates" id="plates">
                        					<option value="">Select</option>
											<?php foreach ($platelist->result() as $rowplatelist) { ?>
                        					<option value="<?php echo $rowplatelist->idtbl_plates ?>" <?php echo ($rowplatelist->idtbl_plates == $quotationDetails['platesDetails']['tbl_plates_idtbl_plates']) ? 'selected' : ''; ?>>
                        						<?php echo $rowplatelist->plate ?> - <?php echo $rowplatelist->size ?></option> <?php } ?>
                        				</select>
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Batch*</label>
                        				<select class="form-control form-control-sm" name="platesbatch" id="platesbatch">
                        					<option value="">Select</option>
                        				</select>
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Unit Price*</label>
                        				<input type="number" name="plates_unitprice" id="plates_unitprice" step="any" value="<?php echo ($quotationDetails['platesDetails']['unit_price']); ?>"
                        					class="form-control form-control-sm" oninput="calplate()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">QTY*</label>
                        				<input type="number" name="plates_quantity" id="plates_quantity" step="any" value="<?php echo ($quotationDetails['platesDetails']['qty']); ?>"
                        					class="form-control form-control-sm" oninput="calplate()">
                        			</div>
                        			<div class="col-2">
                        				<label class="small font-weight-bold">Total *</label> 
                        				<input type="number" name="plates_total" id="plates_total" step="any" value="<?php echo ($quotationDetails['platesDetails']['total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="platesrow_id" value="<?php echo ($quotationDetails['platesDetails']['idtbl_jobquotation_plates_details']); ?>">
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Embosing Blocks*</label>
                        				<input type="number" name="embosing_price" id="embosing_price" step="any" value="<?php echo ($quotationDetails['otherDetails']['embosing_block_amount']); ?>"
                        					class="form-control form-control-sm" oninput="calembosingblock()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="embosing_total" id="embosing_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['embosing_block_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                                    <div class="col-3">
                        				<label class="small font-weight-bold">Foiling Blocks*</label>
                        				<input type="number" name="foilingblock_price" id="foilingblock_price" step="any" value="<?php echo ($quotationDetails['otherDetails']['foiling_block_amount']); ?>"
                        					class="form-control form-control-sm" oninput="calfoilingblock()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="foilingblock_total" id="foilingblock_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['foiling_block_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Cutter*</label>
                        				<input type="number" name="cutter_price" id="cutter_price" step="any" value="<?php echo ($quotationDetails['otherDetails']['cutter_amount']); ?>"
                        					class="form-control form-control-sm" oninput="calcutter()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="cutter_total" id="cutter_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['cutter_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                                    <div class="col-3">
                        				<label class="small font-weight-bold">Window Pasting*</label>
                        				<input type="number" name="windowpasting_price" id="windowpasting_price" step="any" value="<?php echo ($quotationDetails['otherDetails']['window_pasting_amount']); ?>"
                        					class="form-control form-control-sm" oninput="windowpasting()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="windowpasting_total" id="windowpasting_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['window_pasting_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Window patch Film*</label>
                        				<input type="number" name="WindowpatchFilm_price" id="WindowpatchFilm_price" step="any" value="<?php echo ($quotationDetails['otherDetails']['window_patch_film_amount']); ?>"
                        					class="form-control form-control-sm" oninput="windowpatchfilm()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">width*</label>
                        				<input type="number" name="Windowpatch_width" id="Windowpatch_width" step="any" value="<?php echo ($quotationDetails['otherDetails']['window_patch_film_width']); ?>"
                        					class="form-control form-control-sm" oninput="windowpatchfilm()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">height*</label>
                        				<input type="number" name="Windowpatch_height" id="Windowpatch_height" step="any" value="<?php echo ($quotationDetails['otherDetails']['window_patch_film_height']); ?>"
                        					class="form-control form-control-sm" oninput="windowpatchfilm()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="Windowpatch_total" id="Windowpatch_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['window_patch_film_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Board Lamination*</label>
                        				<input type="number" name="boardlamination_price" id="boardlamination_price" step="any" value="<?php echo ($quotationDetails['otherDetails']['board_lamination_amount']); ?>"
                        					class="form-control form-control-sm" oninput="boardlamination()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">width*</label>
                        				<input type="number" name="boardlamination_width" id="boardlamination_width" step="any" value="<?php echo ($quotationDetails['otherDetails']['board_lamination_width']); ?>"
                        					class="form-control form-control-sm" oninput="boardlamination()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">height*</label>
                        				<input type="number" name="boardlamination_height" id="boardlamination_height" step="any" value="<?php echo ($quotationDetails['otherDetails']['board_lamination_height']); ?>"
                        					class="form-control form-control-sm" oninput="boardlamination()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label>
                        				<input type="number" name="boardlamination_total" id="boardlamination_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['board_lamination_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                        		</div>
                        		<div class="form-row">
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Transport*</label>
                        				<input type="number" name="transport" id="transport" step="any" value="<?php echo ($quotationDetails['otherDetails']['transport_amount']); ?>"
                        					class="form-control form-control-sm" oninput="caltransport()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label> 
                        				<input type="number" name="transport_total" id="transport_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['transport_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Commision*</label>
                        				<input type="number" name="commision" id="commision" step="any" value="<?php echo ($quotationDetails['otherDetails']['commision_amount']); ?>"
                        					class="form-control form-control-sm" oninput="calcommision()">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Total *</label> 
                        				<input type="number" name="commision_total" id="commision_total" step="any" value="<?php echo ($quotationDetails['otherDetails']['commision_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
									<input type="hidden" name="otherchargerow_id" value="<?php echo ($quotationDetails['otherDetails']['idtbl_jobquotation_other_details']); ?>">
                        		</div>
                                <hr style=" border: 2; height: 1px; background: #333; width: 100%;">
                        		<div class="form-row">
                        			<div class="col-9">
                        			</div>
                        			<div class="col-3">
                        				<label class="small font-weight-bold">Net Total *</label>
                        				<input type="number" name="net_total" id="net_total" step="any" value="<?php echo ($quotationDetails['quotation']['net_total']); ?>"
                        					class="form-control form-control-sm" readonly>
                        			</div>
                        		</div>
                        	</div>
                           <div class="form-row">
                                <div class="col-4">
                                    <label class="small font-weight-bold">Margin *</label>
                                    <input type="number" name="margin" id="margin" class="form-control form-control-sm" step="any" oninput="margincal()" value="<?php echo ($quotationDetails['quotation']['margin']); ?>"> 
                                </div>
                                <div class="col-4">
                                    <label class="small font-weight-bold">Margin Calculation*</label>
                                    <input type="number" step="any" name="margincalculation" id="margincalculation" step="any" value="<?php echo ($quotationDetails['quotation']['margin_cal']); ?>"
                                        class="form-control form-control-sm"  readonly>
                                </div>
                                <div class="col-4">
                                    <label class="small font-weight-bold">Total with Margin*</label>
                                    <input type="number" step="any" name="totalmargin" id="totalmargin" step="any" value="<?php echo ($quotationDetails['quotation']['totalwith_margin']); ?>"
                                        class="form-control form-control-sm" readonly>
                                </div>
                           </div>
                           <div class="form-row">
                                <div class="col-3">
                                    <label class="small font-weight-bold">Value</label>
                                    <input type="number" name="calvalue" id="calvalue" class="form-control form-control-sm" step="any" value="<?php echo ($quotationDetails['quotation']['valuennew']); ?>" readonly>
                                </div>
                                <div class="col-3">
                                    <label class="small font-weight-bold">Credit*</label>
                                    <input type="number" step="any" name="credit" id="credit" step="any" value="<?php echo ($quotationDetails['quotation']['credit']); ?>"
                                        class="form-control form-control-sm" oninput="creditcal()">
                                </div>
                                <div class="col-3">
                                    <label class="small font-weight-bold">Credit Total*</label>
                                    <input type="number" step="any" name="credittotal" id="credittotal" step="any" value="<?php echo ($quotationDetails['quotation']['credittotal']); ?>"
                                        class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-3">
                                    <label class="small font-weight-bold">Total*</label>
                                    <input type="number" step="any" name="creditwithtotal" id="creditwithtotal" step="any" value="<?php echo ($quotationDetails['quotation']['creditwithtotal']); ?>"
                                        class="form-control form-control-sm" readonly>
                                </div>
                           </div>
                           <div class="form-row">
                                <!-- <div class="col-3">
                                    <label class="small font-weight-bold">%</label>
									<input type="number" name="vat2" id="vat2" class="form-control form-control-sm" step="any" value="<?php echo ($quotationDetails['quotation']['vat2']); ?>">
                                   
                                </div> -->
                                <div class="col-4">
                                    <label class="small font-weight-bold">VAT %</label>
									<input type="number" name="vat" id="vat" class="form-control form-control-sm" step="any" oninput="creditvat()" value="<?php echo ($quotationDetails['quotation']['vat']); ?>">
                                </div>
                                <div class="col-5">
                                    <label class="small font-weight-bold">VAT Count*</label>
                                    <input type="number" step="any" name="vatcount" id="vatcount" class="form-control form-control-sm" step="any" value="<?php echo ($quotationDetails['quotation']['vat_count']); ?>" readonly>
                                </div>
                                <div class="col-3">
                                    <label class="small font-weight-bold">Total with VAT*</label>
                                    <input type="number" step="any" name="tptalwithvat" id="tptalwithvat" class="form-control form-control-sm" step="any" value="<?php echo ($quotationDetails['quotation']['total_with_vat']); ?>" readonly>
                                </div>
                           </div>
                                <hr style=" border: 2; height: 1px; background: #333; width: 100%;">

                                <div class="form-group mt-4 text-center">
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-5"><i class="far fa-save"></i>&nbsp;Update</button>
                                </div>
                        		<input type="hidden" name="recordOption" id="recordOption" value="2">
                        		<input type="hidden" name="recordID" id="recordID" value="<?php echo ($quotationDetails['quotation']['idtbl_jobquatation']); ?>">
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
    $(document).ready(function() {

       
     //  select customer jobs according to selcted customer
     $('#customer').change(function () {
     	var customer_id = $(this).val();
     	if (customer_id != '') {
     		$.ajax({
     			url: "<?php echo base_url('Quatation/get_jobs_by_customer'); ?>",
     			method: "POST",
     			data: {
     				customer_id: customer_id
     			},
     			dataType: "json",
     			success: function (data) {
     				var options = '<option value="">Select</option>';
     				$.each(data, function (index, job) {
     					options += '<option value="' + job.idtbl_customer_job_details + '">' + job.job_name + '</option>';
     				});
     				$('#customerjob').html(options);
     			}
     		});
     	} else {
     		$('#customerjob').html('<option value="">Select</option>');
     	}
     });


     //  select customer job no according to selcted customer job
     $('#customerjob').change(function () {
     	var job_id = $(this).val();
     	if (job_id != '') {
     		$.ajax({
     			url: "<?php echo base_url('Quatation/get_job_details_by_job_id'); ?>",
     			method: "POST",
     			data: {
     				job_id: job_id
     			},
     			dataType: "json",
     			success: function (data) {
     				var options = '<option value="">Select</option>';
     				$.each(data, function (index, job) {
     					options += '<option value="' + job.job_id + '">' + job.job_no + '</option>';
     				});
     				$('#jobno').html(options);
     			}
     		});
     	} else {
     		$('#jobno').html('<option value="">Select</option>');
     	}
     });

     //  select board batch no according to seleted board and paper
     $('#boardpaperselect').change(function () {
     	var boardpaperID = $(this).val();
     	if (boardpaperID != '') {
     		$.ajax({
     			url: "<?php echo base_url('Quatation/get_boardpaper_batch'); ?>",
     			method: "POST",
     			data: {
     				boardpaperID: boardpaperID
     			},
     			dataType: "json",
     			success: function (data) {
     				var options = '<option value="">Select</option>';
     				$.each(data, function (index, job) {
     					options += '<option value="' + job.idtbl_print_stock + '" data-unitprice="' + job.unitprice + '">' + job.batchno + '</option>';
     				});
     				$('#boardpaperbatch').html(options);
     			}
     		});
     	} else {
     		$('#boardpaperbatch').html('<option value="">Select Batch</option>');
     		$('#board_unitprice').val('');
     	}
     });

  // get unit price for that board
        $('#boardpaperbatch').change(function() {
            var unitprice = $('#boardpaperbatch option:selected').data('unitprice');
            $('#board_unitprice').val(unitprice);
        });

    
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const noofpacts = document.getElementById('noofpacts');
        const nosheet = document.getElementById('nosheet');
        const boardQuantity = document.getElementById('board_quantity');
        const boardQuantity2 = document.getElementById('board_quantity2');

        const Quantity = document.getElementById('quantity');
        const noofups = document.getElementById('noofups');
        const wastage = document.getElementById('wastage');

        const boardsize1 = document.getElementById('boardsize1');
        const boardsize12 = document.getElementById('boardsize12');
        const cutsize3 = document.getElementById('cutsize3');
        const cutsize4 = document.getElementById('cutsize4');
        const cutssheetsper = document.getElementById('cutssheetsper');

        const wastagelist = document.getElementById('wastagelist');


        function updateNoofpacts() {
            const nosheetValue = parseFloat(nosheet.value) || 0;
            const boardQuantityValue = parseFloat(boardQuantity.value) || 1;
            const boardQuantity2Value = parseFloat(boardQuantity2.value) || 1; 

            const result = (nosheetValue / boardQuantity2Value) / boardQuantityValue;

            noofpacts.value = result.toFixed(2);
        }

        function updatenosheet() {
            const QuantityValue = parseFloat(Quantity.value) || 0;
            const noofupsValue = parseFloat(noofups.value) || 1;
            const wastageValue = parseFloat(wastage.value) || 0;

            if (noofupsValue === 0) {
                alert("No of Ups cannot be zero.");
                return;
            }
            const wastageDecimal = wastageValue / 100;

            const division = QuantityValue / noofupsValue;
            const resultsheet = division + (division * wastageDecimal);
            nosheet.value = Math.ceil(resultsheet);
        }

    function updateCutSheetsPerPct() {
        const boardsize1Value = parseFloat(boardsize1.value) || 0;
        const boardsize12Value = parseFloat(boardsize12.value) || 0;
        const cutsize3Value = parseFloat(cutsize3.value) || 0;
        const cutsize4Value = parseFloat(cutsize4.value) || 0;

        if (cutsize3Value === 0 || cutsize4Value === 0) {
            cutssheetsper.value = '0';
            return;
        }

        const result = (boardsize1Value * boardsize12Value) / (cutsize3Value * cutsize4Value);

        cutssheetsper.value = result.toFixed(2);
    }

        nosheet.addEventListener('keyup', updateNoofpacts);
        boardQuantity.addEventListener('keyup', updateNoofpacts);
        boardQuantity2.addEventListener('keyup', updateNoofpacts);

        Quantity.addEventListener('keyup', updatenosheet);
        noofups.addEventListener('keyup', updatenosheet);
        wastage.addEventListener('keyup', updatenosheet); 

        boardsize1.addEventListener('keyup', updateCutSheetsPerPct);
        boardsize12.addEventListener('keyup', updateCutSheetsPerPct);
        cutsize3.addEventListener('keyup', updateCutSheetsPerPct);
        cutsize4.addEventListener('keyup', updateCutSheetsPerPct);
    });

		function calmaterialtotal() 
			{
			const unitPrice = parseFloat(document.getElementById('board_unitprice').value) || 0;
			const quantity = parseFloat(document.getElementById('board_quantity').value) || 0;
			const quantity2 = parseFloat(document.getElementById('board_quantity2').value) || 0;

			const total = (unitPrice / (quantity * quantity2)) * 1000;
			document.getElementById('board_total').value = total.toFixed(2);
			updateNetTotal();
			}

    function calwastagetotal() {

        const wastagelist = parseFloat(document.getElementById('wastagelist').value) || 0;
        const noofpacts = parseFloat(document.getElementById('noofpacts').value) || 0;
        const unitprice = parseFloat(document.getElementById('board_unitprice').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;

        const wastageDecimal = wastagelist / 100;

        const e20 = noofpacts * wastageDecimal;
        const d20 = Math.ceil(e20);

        const stp1 = unitprice * d20;
        const stp2 = stp1 / nosheet;
        const c20 = stp2 * 1000;

        document.getElementById('wastage_cal1').value = e20.toFixed(5);
        document.getElementById('wastage_cal2').value = d20.toFixed(2);
        document.getElementById('wastage_total').value = c20.toFixed(2);
        updateNetTotal();
    }


    function calcolortotal(){
        const unitPrice = parseFloat(document.getElementById('colors_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('colors_quantity').value) || 0;

        const total = unitPrice * quantity;
        document.getElementById('colors_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calvarnishtotal(){
        const unitPrice = parseFloat(document.getElementById('varnish_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('varnish_quantity').value) || 0;
        const quantity2 = parseFloat(document.getElementById('varnish_quantity2').value) || 0;

        const stp1 = quantity* quantity2;
        const stp2 = stp1 * unitPrice;
        const total = stp2 * 1000;
        document.getElementById('varnish_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function callaminationtotal(){
        const unitPrice = parseFloat(document.getElementById('lamination_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('lamination_quantity').value) || 0;
        const quantity2 = parseFloat(document.getElementById('lamination_quantity2').value) || 0;

        const stp1 = quantity* quantity2;
        const stp2 = stp1 * unitPrice;
        const total = stp2 * 1000;
        document.getElementById('lamination_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calfoldingtotal(){
        const unitPrice = parseFloat(document.getElementById('foiling_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('foiling_quantity').value) || 0;
        const quantity2 = parseFloat(document.getElementById('foiling_quantity2').value) || 0;
        const ups = parseFloat(document.getElementById('noofups').value) || 0;

        const stp1 = unitPrice * quantity * quantity2;
        const stp2 = stp1 * ups;
        const total = stp2 * 1000;
        document.getElementById('foiling_total').value = total.toFixed(2);
        updateNetTotal();
    }


    function calrimming(){
        const unitPrice = parseFloat(document.getElementById('rimming_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('rimming_quantity').value) || 0;

        const step1 = unitPrice * quantity;
        const total = step1 * 1000;
        document.getElementById('rimming_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calcutting(){
        const unitPrice = parseFloat(document.getElementById('cutting_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('cutting_quantity').value) || 0;

        const total = unitPrice * quantity;
        document.getElementById('cutting_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calpasting(){
        const unitPrice = parseFloat(document.getElementById('pasting_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('pasting_quantity').value) || 0;
        const upsno = parseFloat(document.getElementById('noofups').value) || 0;

        const step1 = unitPrice * quantity;
        const step2 = step1 * upsno
        const total = step2 * 1000;
        document.getElementById('pasting_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calfilmcharge(){
        const unitPrice = parseFloat(document.getElementById('filmchage_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('filmchage_quantity').value) || 0;
        const quantity2 = parseFloat(document.getElementById('filmchage_quantity2').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;

        const step1 = quantity * quantity2;
        const step2 = step1 * unitPrice
        const step3 = step2 / nosheet
        const total = step3 * 1000;
        document.getElementById('filmchage_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calplate(){
        const unitPrice = parseFloat(document.getElementById('plates_unitprice').value) || 0;
        const quantity = parseFloat(document.getElementById('plates_quantity').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;

        const step1 = quantity * unitPrice;
        const step2 = step1 / nosheet
        const total = step2 * 1000;
        document.getElementById('plates_total').value = total.toFixed(2);
        updateNetTotal();
    }
    function calembosingblock(){
        const embosingprice = parseFloat(document.getElementById('embosing_price').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;
        const step1 = embosingprice / nosheet
        const total = step1 * 1000;
        document.getElementById('embosing_total').value = total.toFixed(2);
        updateNetTotal();

    }
    function calfoilingblock(){
        const foilingblockprice = parseFloat(document.getElementById('foilingblock_price').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;
        const step1 = foilingblockprice / nosheet
        const total = step1 * 1000;
        document.getElementById('foilingblock_total').value = total.toFixed(2);
        updateNetTotal();
    }
    function calcutter(){
        const cutterprice = parseFloat(document.getElementById('cutter_price').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;
        const step1 = cutterprice / nosheet
        const total = step1 * 1000;
        document.getElementById('cutter_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function windowpatchfilm(){
        const Windowpatchprice = parseFloat(document.getElementById('WindowpatchFilm_price').value) || 0;
        const width = parseFloat(document.getElementById('Windowpatch_width').value) || 0;
        const height = parseFloat(document.getElementById('Windowpatch_height').value) || 0;
        const noofups = parseFloat(document.getElementById('noofups').value) || 0;

        const total = Windowpatchprice * width * height* noofups * 1000;
        document.getElementById('Windowpatch_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function windowpasting(){
        const windowpasting = parseFloat(document.getElementById('windowpasting_price').value) || 0;
        const noofups = parseFloat(document.getElementById('noofups').value) || 0;

        const total = windowpasting * noofups * 1000;
        document.getElementById('windowpasting_total').value = total.toFixed(2);
        updateNetTotal();
    }
    function boardlamination(){
       const boardlaminationprice = parseFloat(document.getElementById('boardlamination_price').value) || 0;
        const width = parseFloat(document.getElementById('boardlamination_width').value) || 0;
        const height = parseFloat(document.getElementById('boardlamination_height').value) || 0;

        const step1 = boardlaminationprice * width * height;
        const total = step1 * 1000;
        document.getElementById('boardlamination_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function caltransport(){
        const transport = parseFloat(document.getElementById('transport').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;
    
        const step1 = transport / nosheet;
        const total = step1 * 1000;
        document.getElementById('transport_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function calcommision()
	{
        const transport = parseFloat(document.getElementById('commision').value) || 0;
        const nosheet = parseFloat(document.getElementById('nosheet').value) || 0;
    
        const step1 = transport / nosheet;
        const total = step1 * 1000;
        document.getElementById('commision_total').value = total.toFixed(2);
        updateNetTotal();
    }

    function updateNetTotal()
	{
		// Get all totals
		const materialTotal = parseFloat(document.getElementById('board_total').value) || 0;
		const wastageTotal = parseFloat(document.getElementById('wastage_total').value) || 0;
		const colorTotal = parseFloat(document.getElementById('colors_total').value) || 0;
		const varnishTotal = parseFloat(document.getElementById('varnish_total').value) || 0;
		const laminationTotal = parseFloat(document.getElementById('lamination_total').value) || 0;
		const foldingTotal = parseFloat(document.getElementById('foiling_total').value) || 0;
		const rimmingTotal = parseFloat(document.getElementById('rimming_total').value) || 0;
		const cuttingTotal = parseFloat(document.getElementById('cutting_total').value) || 0;
		const pastingTotal = parseFloat(document.getElementById('pasting_total').value) || 0;
		const filmchargeTotal = parseFloat(document.getElementById('filmchage_total').value) || 0;
		const plateTotal = parseFloat(document.getElementById('plates_total').value) || 0;
		const embosingblockTotal = parseFloat(document.getElementById('embosing_total').value) || 0;
		const foilingblockTotal = parseFloat(document.getElementById('foilingblock_total').value) || 0;
		const cutterTotal = parseFloat(document.getElementById('cutter_total').value) || 0;
		const windowpatchTotal = parseFloat(document.getElementById('Windowpatch_total').value) || 0;
		const windowpastingTotal = parseFloat(document.getElementById('windowpasting_total').value) || 0;
		const boardlaminationTotal = parseFloat(document.getElementById('boardlamination_total').value) || 0;
		const transportTotal = parseFloat(document.getElementById('transport_total').value) || 0;
		const commisionTotal = parseFloat(document.getElementById('commision_total').value) || 0;

		const netTotal = materialTotal + wastageTotal + colorTotal + varnishTotal +
						laminationTotal + foldingTotal + rimmingTotal + cuttingTotal +
						pastingTotal + filmchargeTotal + plateTotal + embosingblockTotal +
						foilingblockTotal + cutterTotal + windowpatchTotal + windowpastingTotal +
						boardlaminationTotal + transportTotal + commisionTotal;

		document.getElementById('net_total').value = netTotal.toFixed(2);
    }

	function margincal(){
		const margin = parseFloat(document.getElementById('margin').value) || 0;
        const nettotal = parseFloat(document.getElementById('net_total').value) || 0;
		const noofups = parseFloat(document.getElementById('noofups').value) || 0;
    
        const step1 = nettotal / 100;
        const total = step1 * margin;
		const totalwithmargin = total + nettotal;
        document.getElementById('margincalculation').value = total.toFixed(2);
		document.getElementById('totalmargin').value = totalwithmargin.toFixed(2);

		const calval_step1 = totalwithmargin / noofups;
		const cal_total = calval_step1 /1000;
		document.getElementById('calvalue').value = cal_total.toFixed(3);
	}

	function creditcal(){

		const credit = parseFloat(document.getElementById('credit').value) || 0;
        const calvalue = parseFloat(document.getElementById('calvalue').value) || 0;

		const step1 = calvalue * 0.015;
		const totalstep = step1 * credit
		document.getElementById('credittotal').value = totalstep.toFixed(3);

		const step2 = totalstep + calvalue;
		document.getElementById('creditwithtotal').value = step2.toFixed(3);

	}

	function creditvat(){
		const vat = parseFloat(document.getElementById('vat').value) || 0;
        const creditwithtotal = parseFloat(document.getElementById('creditwithtotal').value) || 0;
		 
		const step1 = creditwithtotal /100;
		const step2 = step1 * vat;

		document.getElementById('vatcount').value = step2.toFixed(3);

		const totalvat = creditwithtotal + step2;
		document.getElementById('tptalwithvat').value = totalvat.toFixed(3);
	}
</script>

<?php include "include/footer.php"; ?>
