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
        					<div class="page-header-icon"><i class="fa fa-file-alt"></i></div>
        					<span>Job Card</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                        <div class="col-5">
                            <form action="<?php echo base_url() ?>Charges/Chargesinsertupdate" method="post" autocomplete="off">	
                            <div class="form-row">
                            	<div class="col-12">
                            		<label class="small font-weight-bold">Customer*</label>
                            		<select class="form-control form-control-sm" name="customer" id="customer" required>
                            			<option value="">Select</option>
                                        <?php foreach ($customerlist->result() as $rowcustomer) { ?>
												<option value="<?php echo $rowcustomer->idtbl_customer ?>">
													<?php echo $rowcustomer->customer ?></option> <?php } ?>
                            		</select>
                            	</div>
                            </div>
                            <div class="form-row">
                            <div class="col-6">
                            		<label class="small font-weight-bold">Jobs*</label>
                            		<select class="form-control form-control-sm" name="customerjob" id="customerjob"
                            			required>
                            			<option value="">Select</option>
                            		</select>
                            	</div>
                                <div class="col-6">
                            		<label class="small font-weight-bold">Job No*</label>
                                    <select class="form-control form-control-sm" name="jobno" id="jobno"
                            			required>
                            			<option value="">Select</option>
                            		</select>
                            	</div>
                            	<!-- <div class="col-6">
                            		<label class="small font-weight-bold">Job Card No*</label>
                            		<input type="text" class="form-control form-control-sm" name="jobcardno" id="jobcardno" readonly>
                            	</div> -->
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Job Discription*</label>
                                <textarea class="form-control" name="jobdiscription" id="jobdiscription"></textarea>
                            </div>

                            <br><lable class="font-weight-bold small">Other Description</lable>
                            <br><br>

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
                            					<div class="col">
                            						<lable class="font-weight-bold small">Paper / Board*</lable>
                            						<select name="cutmaterial" id="cutmaterial"
                            							class="form-control form-control-sm mt-2">
                            							<option value="">Select</option>
                                                        <?php foreach ($materiallist->result() as $rowmaterial) { ?>
                                                            <option value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
                                                                <?php echo $rowmaterial->materialname ?></option> <?php } ?>

                            						</select>
                            					</div>
                            					<div class="col">
                            						<lable class="font-weight-bold small">Grain*</lable>
                            						<input type="number" name="grain" id="grain"
                            							class="form-control form-control-sm mt-2">
                            					</div>
                            					<div class="col">
                            						<lable class="font-weight-bold small">Cutting Size*</lable>
                            						<input name="cutsize" id="cutsize"
                            							class="form-control form-control-sm mt-2">
                            					</div>
                            				</div>
                                            <div class="form-row">
                            					<div class="col">
                            						<lable class="font-weight-bold small">Grain*</lable>
                            						<input type="number" name="grain2" id="grain2"
                            							class="form-control form-control-sm mt-2">
                            					</div>
                            					<div class="col">
                            						<lable class="font-weight-bold small">No of Cuts*</lable>
                            						<input type="number" name="nocuts" id="nocuts"
                            							class="form-control form-control-sm mt-2">
                            					</div>
                            					<div class="col">
                            						<lable class="font-weight-bold small">No of Ups*</lable>
                            						<input type="number" name="noups" id="noups"
                            							class="form-control form-control-sm mt-2">
                            					</div>
                            				</div>
                            				<div class="form-group mt-3 mb-0" align ="right">
                            					<button type="button" class="btn btn-primary btn-sm" id="btncutadd"><i
                            							class="fas fa-plus"></i>&nbsp;Add To List</button>
                            				</div>
                            				<hr>
                            				<table class="table table-striped table-bordered table-sm small mt-2"
                            					id="tablecutting">
                            					<thead>
                            						<tr>
                            							<th class="d-none">MaterialsID</th>
                            							<th class="d-none">Batchno</th>
                            							<th>Paper / Board</th>
                            							<th>Grain</th>
                            							<th>Cut Size</th>
                                                        <th>Grain</th>
                                                        <th>No of Cuts</th>
                                                        <th>No of Ups</th>
                            						</tr>
                            					</thead>
                            					<tbody></tbody>
                            				</table>
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
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>No of Colors</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <label for="nocolorfront" class="font-weight-bold small">Front:</label>
                                                            <input type="number" name="nocolorfront" id="nocolorfront" class="form-control form-control-sm mt-2">
                                                        </div>
                                                        <div class="col">
                                                            <label for="nocolorback" class="font-weight-bold small ">Back:</label>
                                                            <input type="number" name="nocolorback" id="nocolorback" class="form-control form-control-sm mt-2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>Size</b>:</label>
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
                                            </div>
                                            <br>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>Ink Specification</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="inknormal" id="inknormal">
                                                            <label class="form-check-label" for="inknormal">Normal</label>
                                                        </div>
                                                        <div class="col form-check" style="margin-right: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="inkar" id="inkar">
                                                            <label class="form-check-label" for="inkar">Alkaline Resistance(A/R)</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="inklightfast" id="inklightfast">
                                                            <label class="form-check-label" for="inklightfast">Light Fast</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="inkblack" id="inkblack">
                                                            <label class="form-check-label" for="inkblack">Black</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                            <div class="form-row">
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>Process Colors</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="colorcyan" id="colorcyan">
                                                            <label class="form-check-label" for="colorcyan">Cyan</label>
                                                        </div>
                                                        <div class="col form-check" style="margin-right: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="colormagenta" id="colormagenta">
                                                            <label class="form-check-label" for="colormagenta">Magenta</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="coloryellow" id="coloryellow">
                                                            <label class="form-check-label" for="coloryellow">Yellow</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="colorbalck" id="colorbalck">
                                                            <label class="form-check-label" for="colorbalck">Black</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>Special Colors</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <input type="text"class="form-control form-control-sm mt-2" name="speccolr1" id="speccolr1">
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control form-control-sm mt-2" name="speccolr2" id="speccolr2">
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control form-control-sm mt-2" name="speccolr3" id="speccolr3">
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control form-control-sm mt-2" name="speccolr4" id="speccolr4">
                                                        </div>
                                                    </div>
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
                            					O/P and UV Varnish Section
                            				</button>
                            			</h2>
                            		</div>
                            		<div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                            			data-parent="#accordionExample">
                            			<div class="card-body p-2">
                                             <div class="form-row">
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>O/P Varnish</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="var_gloss" id="var_gloss">
                                                            <label class="form-check-label" for="var_gloss">Gloss</label>
                                                        </div>
                                                        <div class="col form-check" >
                                                            <input type="checkbox" class="form-check-input" name="var_matt" id="var_matt">
                                                            <label class="form-check-label" for="var_matt">Matt</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="var_spott" id="var_spott">
                                                            <label class="form-check-label" for="var_spott">Spot</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="var_full" id="var_full">
                                                            <label class="form-check-label" for="var_full">Full</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>UV Varnish</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="uv_spot" id="uv_spot">
                                                            <label class="form-check-label" for="uv_spot">Spot</label>
                                                        </div>
                                                        <div class="col form-check" >
                                                            <input type="checkbox" class="form-check-input" name="uv_full" id="uv_full">
                                                            <label class="form-check-label" for="uv_full">Full</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="uv_one" id="uv_one">
                                                            <label class="form-check-label" for="uv_one">One Side</label>
                                                        </div>
                                                        <div class="col form-check">
                                                            <input type="checkbox" class="form-check-input" name="uv_both" id="uv_both">
                                                            <label class="form-check-label" for="uv_both">Both Side</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>Plate</b>:</label>
                                                    <div class="form-row">
                                                        <div class="col form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="plate_blanket" id="plate_blanket">
                                                            <label class="form-check-label" for="plate_blanket">Blanket</label>
                                                        </div>
                                                        <div class="col form-check" >
                                                            <input type="checkbox" class="form-check-input" name="plate_polymer" id="plate_polymer">
                                                            <label class="form-check-label" for="plate_polymer">Polymer</label>
                                                        </div>
                                                        <div class="col">
                                                            <label for="uvbarnd" class="font-weight-bold small">UV Brand</label>
                                                            <input type="text" name="uvbarnd" id="uvbarnd" class="form-control form-control-sm mt-2" >
                                                        </div>
                                                    </div>
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
                            					Other Section
                            				</button>
                            			</h2>
                            		</div>
                            		<div id="collapseSix" class="collapse" aria-labelledby="headingFive"
                            			data-parent="#accordionExample">
                            			<div class="card-body p-2">
                                                <div class="form-row">
                                                    <div class="col form-check" style="margin-left: 30px;">
                                                        <input type="checkbox" class="form-check-input" name="gathering" id="gathering">
                                                        <label class="form-check-label" for="gathering">Gathering</label>
                                                    </div>
                                                    <div class="col form-check" >
                                                        <input type="checkbox" class="form-check-input" name="folling" id="folling">
                                                        <label class="form-check-label" for="folling">Folling</label>
                                                    </div>
                                                    <div class="col form-check">
                                                        <input type="checkbox" class="form-check-input" name="embossing" id="embossing">
                                                        <label class="form-check-label" for="embossing">Embossing</label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col form-check" style="margin-left: 30px;">
                                                        <input type="checkbox" class="form-check-input" name="folding" id="folding">
                                                        <label class="form-check-label" for="folding">Folding</label>
                                                    </div>
                                                    <div class="col form-check" >
                                                        <input type="checkbox" class="form-check-input" name="binding" id="binding">
                                                        <label class="form-check-label" for="binding">Binding</label>
                                                    </div>
                                                    <div class="col form-check">
                                                        <input type="checkbox" class="form-check-input" name="waxing" id="waxing">
                                                        <label class="form-check-label" for="waxing">Waxing</label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col form-check" style="margin-left: 30px;">
                                                        <input type="checkbox" class="form-check-input" name="perforating" id="perforating">
                                                        <label class="form-check-label" for="perforating">Perforating</label>
                                                    </div>
                                                    <div class="col form-check" >
                                                        <input type="checkbox" class="form-check-input" name="manualpasting" id="manualpasting">
                                                        <label class="form-check-label" for="manualpasting">Mannual Pasting</label>
                                                    </div>
                                                    <div class="col form-check">
                                                        <input type="checkbox" class="form-check-input" name="machinepasting" id="machinepasting">
                                                        <label class="form-check-label" for="machinepasting">Machine Pasting</label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <lable class="font-weight-bold small">Gum Brand*</lable>
                                                        <input type="text" name="gumbrand" id="gumbrand"
                                                            class="form-control form-control-sm mt-2">
                                                    </div>
                                                    <div class="col">
                                                        <lable class="font-weight-bold small">Gum Brand*</lable>
                                                        <input type="text" name="gumbrand2" id="gumbrand2"
                                                            class="form-control form-control-sm mt-2">
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
                                                    <div class="col form-check" style="margin-left: 30px;">
                                                        <input type="checkbox" class="form-check-input" name="lam_gloss" id="lam_gloss">
                                                        <label class="form-check-label" for="lam_gloss">Gloss</label>
                                                    </div>
                                                    <div class="col form-check" >
                                                        <input type="checkbox" class="form-check-input" name="lam_normal" id="lam_normal">
                                                        <label class="form-check-label" for="lam_normal">Normal</label>
                                                    </div>
                                                    <div class="col form-check">
                                                        <input type="checkbox" class="form-check-input" name="lam_oneside" id="lam_oneside">
                                                        <label class="form-check-label" for="lam_oneside">One Side</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-row">
                                                    <div class="col form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="lam_mat" id="lam_mat">
                                                            <label class="form-check-label" for="lam_mat">Matt</label>
                                                        </div>
                                                        <div class="col form-check" >
                                                            <input type="checkbox" class="form-check-input" name="lam_window" id="lam_window">
                                                            <label class="form-check-label" for="lam_window">Window</label>
                                                        </div>
                                                        <div class="col form-check" >
                                                            <input type="checkbox" class="form-check-input" name="lam_bothside" id="lam_bothside">
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
                            					Ramming Section
                            				</button>
                            			</h2>
                            		</div>
                            		<div id="collapseseven" class="collapse" aria-labelledby="headingseven"
                            			data-parent="#accordionExample">
                            			<div class="card-body p-2">
                                                 <div class="form-row">
                                                    <div class="col-4">
                                                        <lable class="font-weight-bold small">Color*</lable>
                                                        <input type="text" name="rimm_color" id="rimm_color"
                                                            class="form-control form-control-sm mt-2">
                                                    </div>
                                                    <div class="col-4">
                                                        <lable class="font-weight-bold small">Size*</lable>
                                                        <input type="text" name="rimm_size" id="rimm_size"
                                                            class="form-control form-control-sm mt-2">
                                                    </div>
                                                    <div class="col-4">
                                                    	<div class="col-12 form-check"
                                                    		style="margin-top:25px; margin-left:10px;">
                                                    		<input type="checkbox" class="form-check-input"
                                                    			name="rimm_oneside" id="rimm_oneside">
                                                    		<label class="form-check-label" for="rimm_oneside">One
                                                    			Side</label>
                                                    	</div>
                                                    	<div class="col-12 form-check" style="margin-left:10px;">
                                                    		<input type="checkbox" class="form-check-input"
                                                    			name="rimm_bothside" id="rimm_bothside">
                                                    		<label class="form-check-label" for="rimm_bothside">Both
                                                    			Side</label>
                                                    	</div>
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
                            					Die Cutting
                            				</button>
                            			</h2>
                            		</div>
                            		<div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                            			data-parent="#accordionExample">
                            			<div class="card-body p-2">
                            				
                                        <div class="form-row">
                                                <div class="col">
                                                        <div class="col-12 form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="die_board" id="die_board">
                                                            <label class="form-check-label" for="die_board">Board</label>
                                                        </div>
                                                        <div class="col-12 form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="die_chanell" id="die_chanell">
                                                            <label class="form-check-label" for="die_chanell">Channel</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="chanelbrand" class="font-weight-bold small ">Channel Brand:</label>
                                                            <input type="text" name="chanelbrand" id="chanelbrand" class="form-control form-control-sm mt-2">
                                                        </div>
                                                </div>
                                                <div class="col">
                                                       <label class="font-weight-bold small"><b>Die</b>:</label>

                                                        <div class="col-12 form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="die_normal" id="die_normal">
                                                            <label class="form-check-label" for="die_normal">Normal</label>
                                                        </div>
                                                        <div class="col-12 form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="die_lazer" id="die_lazer">
                                                            <label class="form-check-label" for="die_lazer">Lazer</label>
                                                        </div>
                                                </div>
                                                <div class="col">
                                                    <label class="font-weight-bold small"><b>Supplied</b>:</label>
                                                     
                                                        <div class="col-12 form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="supplied_us" id="supplied_us">
                                                            <label class="form-check-label" for="supplied_us">By us</label>
                                                        </div>
                                                        <div class="col-12 form-check" style="margin-left: 30px;">
                                                            <input type="checkbox" class="form-check-input" name="supplied_customer" id="supplied_customer">
                                                            <label class="form-check-label" for="supplied_customer">Customer</label>
                                                        </div>
                                                </div>
                                                <div class="col">
                                                        <div class="col">
                                                            <label for="die_noups" class="font-weight-bold small">No of ups:</label>
                                                            <input type="text" name="die_noups" id="die_noups" class="form-control form-control-sm mt-2">
                                                        </div>
                                                        <div class="col">
                                                            <label for="die_code" class="font-weight-bold small ">Code:</label>
                                                            <input type="text" name="die_code" id="die_code" class="form-control form-control-sm mt-2">
                                                        </div>
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
                            					Bar Code Section
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
                                                    			name="barcode_yes" id="barcode_yes">
                                                    		<label class="form-check-label" for="barcode_yes">Yes</label>
                                                    	</div>
                                                    	<div class="col-12 form-check" style="margin-left:70px;">
                                                    		<input type="checkbox" class="form-check-input"
                                                    			name="barcode_no" id="barcode_no">
                                                    		<label class="form-check-label" for="barcode_no">No</label>
                                                    	</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <lable class="font-weight-bold small">Code*</lable>
                                                        <input type="text" name="barcode_code" id="barcode_code"
                                                            class="form-control form-control-sm mt-2">
                                                    </div>
                                                    <div class="col-4">
                                                        <lable class="font-weight-bold small">Code No*</lable>
                                                        <input type="text" name="barcode_codeno" id="barcode_codeno"
                                                            class="form-control form-control-sm mt-2">
                                                    </div>
                                                   
                                                </div>
                            			</div>
                            		</div>
                            	</div>

                            </div>
                            <br>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Any other Instruction*</label>
                                <textarea class="form-control" name="otherinstruction" id="otherinstruction"></textarea>
                            </div>

                        <div class="form-group mt-2 text-right">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i
                                        class="far fa-save"></i>&nbsp;Add</button>
                        </div>
                                <input type="hidden" name="recordOption" id="recordOption" value="1">
                                <input type="hidden" name="recordID" id="recordID" value="">
                            </form>
                            </div>
                            <div class="col-7">
                                <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
        										<th>#</th>
        										<th>Job No</th>
                                                <th>Customer</th>
                                                <th>Job</th>
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
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#customer').select2();
 
        $('#dataTable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Charges Types', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Charges Types', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Charges Types',
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
                url: "<?php echo base_url() ?>scripts/chargeslist.php",
                type: "POST",
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_charges"
                },
                {
                    "data": "charges_type"
                },
                {
                    "data": "charges_type"
                },
                {
                    "data": "charges_type"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_charges']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Charges/Chargesstatus/'+full['idtbl_charges']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Charges/Chargesstatus/'+full['idtbl_charges']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Charges/Chargesstatus/'+full['idtbl_charges']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


        //  select customer jobs according to selcted customer
        $('#customer').change(function() {
        var customer_id = $(this).val();
            if(customer_id != '') {
                $.ajax({
                    url: "<?php echo base_url('jobcard/get_jobs_by_customer'); ?>",
                    method: "POST",
                    data: {customer_id: customer_id},
                    dataType: "json",
                    success: function(data) {
                        var options = '<option value="">Select</option>';
                        $.each(data, function(index, job) {
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
       $('#customerjob').change(function() {
        var job_id = $(this).val();
        if(job_id != '') {
            $.ajax({
                url: "<?php echo base_url('jobcard/get_job_details_by_job_id'); ?>",
                method: "POST",
                data: {job_id: job_id},
                dataType: "json",
                success: function(data) {
                    var options = '<option value="">Select</option>';
                    $.each(data, function(index, job) {
                            options += '<option value="' + job.idtbl_customerinquiry_detail + '">' + job.job_no + '</option>';
                        });
                    $('#jobno').html(options);
                }
            });
        } else {
            $('#jobno').html('<option value="">Select</option>');
        }
    });

    $('#btncutadd').click(function() {
        var cutmaterial = $('#cutmaterial').val();
        var grain = $('#grain').val();
        var cutsize = $('#cutsize').val();
        var grain2 = $('#grain2').val();
        var nocuts = $('#nocuts').val();
        var noups = $('#noups').val();
        
        // Create new table row
        var newRow = `
            <tr>
                <td class="d-none">${cutmaterial}</td>
                <td class="d-none"></td>
                <td>${$("#cutmaterial option:selected").text()}</td>
                <td>${grain}</td>
                <td>${cutsize}</td>
                <td>${grain2}</td>
                <td>${nocuts}</td>
                <td>${noups}</td>
            </tr>
        `;
        
        // Append new row to table body
        $('#tablecutting tbody').append(newRow);
        
        // Clear input fields
        $('#cutmaterial').val('');
        $('#grain').val('');
        $('#cutsize').val('');
        $('#grain2').val('');
        $('#nocuts').val('');
        $('#noups').val('');
    });
    $('#tablecutting tbody').on('click', 'tr', function() {
        $(this).remove();
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
