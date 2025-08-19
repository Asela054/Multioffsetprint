<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<?php


$company = $_SESSION['company_id'];

$sql = "SELECT COUNT(`idtbl_print_stock`) AS stockcount 
        FROM `tbl_print_stock` 
        LEFT JOIN `tbl_print_material_info` 
        ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
        WHERE `tbl_print_stock`.`status` = 1 
        AND `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
        AND `tbl_print_stock`.`company_id` = ?";
        
$materialinfo = $this->db->query($sql, array($company));


//Matchine
$sql = "SELECT COUNT(`idtbl_print_stock`) AS stockcount 
		FROM `tbl_print_stock`
		LEFT JOIN `tbl_machine` 
		ON `tbl_machine`.`idtbl_machine`= `tbl_print_stock`.`tbl_machine_id` 
		WHERE `tbl_print_stock`.`status` = 1 
		AND `tbl_print_stock`.`tbl_machine_id`
		AND `tbl_print_stock`.`company_id` = ?";

$machineinfo=$this->db->query($sql, array($company));

//Spare Parts
$sql = "SELECT COUNT(`idtbl_print_stock`) AS stockcount
	    FROM `tbl_print_stock` 
		LEFT JOIN `tbl_spareparts` 
		ON `tbl_spareparts`.`idtbl_spareparts`= `tbl_print_stock`.`tbl_sparepart_id` 
		WHERE `tbl_print_stock`.`status` = 1 
		AND `tbl_print_stock`.`tbl_sparepart_id`
		AND `tbl_print_stock`.`company_id` = ?";
$sparepartinfo=$this->db->query($sql, array($company));

//Zero Stock
$sql = "SELECT COUNT(`idtbl_print_stock`) AS stockcount 
		FROM `tbl_print_stock` 
		LEFT JOIN `tbl_print_material_info`
		ON `tbl_print_material_info`.`idtbl_print_material_info`= `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
		WHERE `tbl_print_stock`.`status` = 1
		AND `tbl_print_stock`.`qty` = 0 
		AND `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info` 
		AND `tbl_print_stock`.`company_id` = ?";
$zerostockinfo=$this->db->query($sql, array($company));


// Last 5 Purchase
$sql="SELECT m.materialname, g.date, g.qty, g.unitprice, g.total 
	  FROM tbl_print_grndetail g LEFT JOIN tbl_print_grn gd ON gd.idtbl_print_grn=g.tbl_print_grn_idtbl_print_grn INNER JOIN tbl_print_material_info m 
	  ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info 
	  WHERE g.status = 1 AND gd.company_id=$company AND g.tbl_print_material_info_idtbl_print_material_info <> 0 ORDER BY g.date DESC LIMIT 5";
$resultdate = $this->db->query($sql);

// Top Five Purchase Report
$sql="SELECT m.materialname, g.date, g.qty, g.unitprice, g.total FROM tbl_print_grndetail g LEFT JOIN tbl_print_grn gd ON gd.idtbl_print_grn=g.tbl_print_grn_idtbl_print_grn INNER JOIN tbl_print_material_info m ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info WHERE g.status = 1 AND gd.company_id=$company AND g.tbl_print_material_info_idtbl_print_material_info <> 0 ORDER BY g.qty DESC LIMIT 5 ";
$resultqty = $this->db->query($sql);

//Low stock Product
$sql="SELECT COUNT(`idtbl_print_stock`) AS stockcount 
	  FROM `tbl_print_stock` LEFT JOIN `tbl_print_material_info` 
	  ON `tbl_print_material_info`.`idtbl_print_material_info`= `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
	  WHERE `tbl_print_stock`.`status` = 1 
	  AND `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info` <> 0 
	  AND `tbl_print_stock`.`qty` < `tbl_print_material_info`.`reorderlevel`
	  AND `tbl_print_stock`.`company_id` = ?";
$lowstockinfo = $this->db->query($sql, array($company));

//Fast moving Materials
$sql="SELECT m.materialname, g.qty, g.unitprice FROM tbl_inquiry_allocated_materials g INNER JOIN tbl_print_material_info m ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info WHERE g.status = 1 AND g.tbl_print_material_info_idtbl_print_material_info <> 0 ORDER BY g.qty DESC LIMIT 5 ";
$resultfast = $this->db->query($sql);

//non moving Materials
$sql="SELECT m.materialname, g.grndate, g.qty, g.unitprice, g.total FROM tbl_print_stock g INNER JOIN tbl_print_material_info m ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info WHERE g.status = 1 AND g.company_id=$company AND g.tbl_print_material_info_idtbl_print_material_info <> 0 AND (g.updatedatetime IS NULL OR g.updatedatetime > g.grndate) <> 0 ORDER BY g.qty DESC LIMIT 5";
$resultnonmove = $this->db->query($sql);

?>


<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php 
        include "include/menubar.php";
         ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<h1 class="page-header-title ">
									<div class="page-header-icon"><i class="fas fa-desktop"></i></div>
									<span>Dashboard</span>
								</h1>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body watermarked-card">
						<div class="row">
							<div class="col-mb-3 col-lg-3 col-xl-3">
								<div class="card border-success mb-3" id="materialCard">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-success">
											<i class="fas fa-file-alt fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-success m-0 font-weight-bold"><a
														class="text-success"
														href="#"> Print Materials
														(<?php if($materialinfo->num_rows() > 0){ foreach($materialinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-3 col-lg-3 col-xl-3">
								<div class="card border-success mb-3"  id="matchineCard">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-danger">
											<i class="fas fa-cogs fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-danger m-0 font-weight-bold"><a
														class="text-danger"
														href="#"> Machine
														(<?php if($machineinfo->num_rows() > 0){ foreach($machineinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-danger" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-3 col-lg-3 col-xl-3">
								<div class="card border-success mb-3" id="sparepartsCard">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-warning">
											<i class="fas fa-tools fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-warning m-0 font-weight-bold"><a
														class="text-warning"
														href="#"> Spare Parts
														(<?php if($sparepartinfo->num_rows() > 0){ foreach($sparepartinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-warning" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-mb-3 col-lg-3 col-xl-3">
								<div class="card border-success mb-3" id="zrostockCard">
									<div class="row no-gutters h-100">
									<div class="col-auto p-2 text-primary">
											<i class="fas fa-file-invoice-dollar fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-primary m-0 font-weight-bold"><a
														class="text-primary"
														href="#"> Zero Stock Procucts
														(<?php if($zerostockinfo->num_rows() > 0){ foreach($zerostockinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-primary" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

                            <div class="col-mb-3 col-lg-3 col-xl-3">
								<div class="card border-success mb-3" id="lowstockCard">
									<div class="row no-gutters h-100">
									<div class="col-auto p-2 text-info">
											<i class="fas fa-exclamation-triangle fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-info m-0 font-weight-bold"><a
														class="text-info"
														href="#"> Low Stock Procucts
														(<?php if($lowstockinfo->num_rows() > 0){ foreach($lowstockinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-info" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body p-0 p-2">
								<div class="row">
									<div class="col-6">
										<h6 class="small title-style"><span>Last Five Purchase</span></h6>
										<table class="table table-striped table-bordered table-sm small">
											<thead  class="bg-danger-soft">
												<tr>
													<th>Material</th>
													<th>Date</th>
													<th>Qty</th>
													<th>Unit Price</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($resultdate->num_rows() > 0) {
													foreach ($resultdate->result() as $item) {
												?>
													<tr>
														<td><?php echo $item->materialname; ?></td>
														<td><?php echo $item->date; ?></td>
														<td class="text-right"><?php echo $item->qty; ?></td>
														<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
														<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
													</tr>
												<?php
													}
												} 
												?>
											</tbody>
										</table>
									</div>

									<div class="col-6">
										<h6 class="small title-style"><span>Top Five Purchase</span></h6>
										<table class="table table-striped table-bordered table-sm small">
											<thead  class="bg-warning-soft">
												<tr>
													<th>Material</th>
													<th>Date</th>
													<th>Qty</th>
													<th>Unit Price</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($resultqty->num_rows() > 0) {
													foreach ($resultqty->result() as $item) {
												?>
													<tr>
														<td><?php echo $item->materialname; ?></td>
														<td><?php echo $item->date; ?></td>
														<td class="text-right"><?php echo $item->qty; ?></td>
														<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
														<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
													</tr>
												<?php
													}
												} 
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="card-body p-0 p-2">
								<div class="row">
									<div class="col-6">
										<h6 class="small title-style"><span>Fast Moving Materials</span></h6>
										<table class="table table-striped table-bordered table-sm small">
											<thead  class="bg-success-soft">
												<tr>
													<th>Material</th>
													<th class="text-right">Qty</th>
													<th class="text-right">Unit Price</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($resultfast->num_rows() > 0) {
													foreach ($resultfast->result() as $item) {
												?>
													<tr>
														<td><?php echo $item->materialname; ?></td>
														<td class="text-right"><?php echo $item->qty; ?></td>
														<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
													</tr>
												<?php
													}
												} 
												?>
											</tbody>
										</table>
									</div> 
									<div class="col-6">
										<h6 class="small title-style"><span>Non Moving Materials</span></h6>
										<table class="table table-striped table-bordered table-sm small">
											<thead  class="bg-secondary-soft">
												<tr>
													<th>Material</th>
													<th>Date</th>
													<th>Qty</th>
													<th>Unit Price</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($resultnonmove->num_rows() > 0) {
													foreach ($resultnonmove->result() as $item) {
												?>
													<tr>
														<td><?php echo $item->materialname; ?></td>
														<td><?php echo $item->grndate; ?></td>
														<td class="text-right"><?php echo $item->qty; ?></td>
														<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
														<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
													</tr>
												<?php
													}
												} 
												?>
											</tbody>
										</table>
									</div> 
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
<!-- Model of View Material  -->
<div class="modal fade" id="tableModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tableModalLabel">Print Material Stock</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="container-fluid mt-2 p-0 p-3">
				<div class="card">
					<div class="card-body p-0 p-3">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped  nowrap" id="dataTable">
										<thead>
											<tr>
											<th>#ID</th>
											<th>GRN Date</th>
											<th>Suplier Name</th>
											<th>Qty</th>
											<th>Unit Price</th>
											<th>Material Name</th>
											<th>Total</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>    
    </div>
</div>

<!-- Model of View Machine stock  -->
<div class="modal fade" id="tableModal2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tableModalLabel">Machine Stock</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid mt-2 p-0 p-2">
                    <div class="card">
                        <div class="card-body p-0 p-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="scrollbar pb-3" id="style-2">
                                        <table class="table table-bordered table-striped " id="dataTable2">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>GRN Date</th>
                                                    <th>Supplier Name</th>
                                                    <th>Qty</th>
                                                    <th>Unit Price</th>
                                                    <th>Machine</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Model of Spare Parts stock  -->
<div class="modal fade" id="tableModal3" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tableModalLabel">Spare Parts</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-lg nowrap" id="dataTable3">
										<thead>
											<tr>
											<th>#ID</th>
											<th>GRN Date</th>
											<th>Qty</th>
											<th>Unit Price</th>
											<th>Spare Parts Name</th>
											<th>Total</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>    
    </div>
</div>



<!-- Model Zero stock Product -->
<div class="modal fade" id="tableModal4" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tableModalLabel">Zero Product stock</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-lg nowrap" id="dataTable4">
										<thead>
											<tr>
											<th>#ID</th>
											<th>GRN Date</th>
											<th>Suplier Name</th>
											<th>Material Name</th>
											<th>Qty</th>
											<th>Unit Price</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>    
    </div>
</div>

<!-- Model low stock Product  -->
<div class="modal fade" id="tableModal5" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tableModalLabel">Low stock Product</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-lg nowrap" id="dataTable5">
										<thead>
											<tr>
											<th>#ID</th>
											<th>GRN Date</th>
											<th>Suplier Name</th>
                                            <th>Material Name</th>
											<th>Qty</th>
											<th>Unit Price</th>
											<th>Total</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>    
    </div>
</div>


<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {

		$('#dataTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalmateriallist.php",
				type: "POST",
				"data": function (d) {
						return $.extend({}, d, {
							"company_id": '<?php echo ($_SESSION['company_id']); ?>',
						});
					}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "name"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
				{
					"data": "materialname"
				},
				{
					"data": "total"
				},
				

			],
		});

		$('#dataTable2').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalMachinelist.php",
				type: "POST",
				"data": function (d) {
						return $.extend({}, d, {
							"company_id": '<?php echo ($_SESSION['company_id']); ?>',
						});
					}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "name"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
				{
					"data": "machine"
				},
				{
					"data": "total"
				},
				

			],
		});

		$('#dataTable3').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalsparepartslist.php",
				type: "POST",
				"data": function (d) {
						return $.extend({}, d, {
							"company_id": '<?php echo ($_SESSION['company_id']); ?>',
						});
					}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
				{
					"data": "spare_part_name"
				},
				{
					"data": "total"
				},
				

			],
		});


		
		$('#dataTable4').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalZeroProductlist.php",
				type: "POST",
				"data": function (d) {
						return $.extend({}, d, {
							"company_id": '<?php echo ($_SESSION['company_id']); ?>',
						});
					}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "name"
				},
				{
					"data": "materialname"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
				

			],
		});

        $('#dataTable5').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totallowProductlist.php",
				type: "POST",
				"data": function (d) {
						return $.extend({}, d, {
							"company_id": '<?php echo ($_SESSION['company_id']); ?>',
						});
					}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "name"
				},
				{
					"data": "materialname"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
                {
					"data": "total"
				},
				

			],
		});
   
   
	
	
	$('#materialCard').on('click', function() {
		$('#tableModal').modal('show');
	});
	$('#matchineCard').on('click', function() {
		$('#tableModal2').modal('show');
	});
	$('#sparepartsCard').on('click', function() {
		$('#tableModal3').modal('show');
	});
	$('#zrostockCard').on('click', function() {
		$('#tableModal4').modal('show');
	});
    $('#lowstockCard').on('click', function() {
		$('#tableModal5').modal('show');
	});

});

</script>
<?php include "include/footer.php"; ?>
