<?php
include "include/header.php";
include "include/topnavbar.php";
?>
<style>
	:root{
		--ds-blue:#4361ee;
		--ds-blue-dark:#3a0ca3;
		--ds-green:#2ec4b6;
		--ds-green-dark:#159b8f;
		--ds-orange:#ff9f1c;
		--ds-orange-dark:#e8850a;
		--ds-red:#ef476f;
		--ds-red-dark:#d1355a;
		--ds-purple:#7209b7;
		--ds-purple-dark:#560692;
		--ds-ink:#1e2233;
		--ds-muted:#8a8fa3;
		--ds-bg:#f4f6fb;
		--ds-radius:16px;
	}
	body{ background:var(--ds-bg); }
	.ds-page-header{
		background:linear-gradient(120deg,var(--ds-blue) 0%,var(--ds-purple) 100%);
		border-radius:var(--ds-radius);
		box-shadow:0 8px 24px rgba(67,97,238,.18);
		padding:1.35rem 1.5rem;
	}
	.ds-page-header .page-header-title{ color:#fff; margin:0; font-weight:700; letter-spacing:.3px; font-size:1.5rem; }
	.ds-page-header .page-header-icon{
		background:rgba(255,255,255,.18);
		color:#fff; border-radius:12px; width:42px; height:42px;
		display:inline-flex; align-items:center; justify-content:center; margin-right:.7rem;
	}
	.ds-page-header .ds-page-header-sub{ color:rgba(255,255,255,.85); font-size:.85rem; margin-top:.25rem; }

	.ds-stat-card{
		border:none; border-radius:var(--ds-radius);
		padding:1.1rem 1.25rem;
		color:#fff; position:relative; overflow:hidden;
		box-shadow:0 10px 22px rgba(30,34,51,.10);
		transition:transform .18s ease, box-shadow .18s ease;
		cursor:pointer; min-height:118px;
	}
	.ds-stat-card:hover{ transform:translateY(-4px); box-shadow:0 16px 28px rgba(30,34,51,.16); }
	.ds-stat-card .ds-icon{
		width:44px; height:44px; border-radius:12px;
		background:rgba(255,255,255,.22);
		display:flex; align-items:center; justify-content:center;
		font-size:1.15rem; margin-bottom:.6rem;
	}
	.ds-stat-card .ds-value{ font-size:1.6rem; font-weight:700; line-height:1; }
	.ds-stat-card .ds-label{ font-size:.78rem; opacity:.92; margin-top:.2rem; font-weight:500; letter-spacing:.2px; }
	.ds-stat-card .ds-blob{
		position:absolute; right:-18px; bottom:-18px; width:90px; height:90px;
		border-radius:50%; background:rgba(255,255,255,.10);
	}
	.card-materials{ background:linear-gradient(135deg,var(--ds-green) 0%,var(--ds-green-dark) 100%); }
	.card-machine{ background:linear-gradient(135deg,var(--ds-red) 0%,var(--ds-red-dark) 100%); }
	.card-spares{ background:linear-gradient(135deg,var(--ds-orange) 0%,var(--ds-orange-dark) 100%); }
	.card-zero{ background:linear-gradient(135deg,var(--ds-blue) 0%,var(--ds-blue-dark) 100%); }
	.card-low{ background:linear-gradient(135deg,var(--ds-purple) 0%,var(--ds-purple-dark) 100%); }

	.ds-panel{
		background:#fff; border-radius:var(--ds-radius); border:none;
		box-shadow:0 6px 18px rgba(30,34,51,.06);
	}
	.ds-panel .ds-panel-header{
		display:flex; align-items:center; justify-content:space-between;
		padding:1rem 1.25rem .5rem 1.25rem;
	}
	.ds-panel .ds-panel-title{ font-weight:700; color:var(--ds-ink); font-size:.95rem; margin:0; }
	.ds-panel .ds-panel-title small{ display:block; color:var(--ds-muted); font-weight:400; font-size:.72rem; margin-top:2px; }
	.ds-panel .ds-panel-body{ padding:.5rem 1.15rem 1.15rem 1.15rem; }
	.ds-badge-pill{
		font-size:.68rem; font-weight:600; padding:.3rem .6rem; border-radius:20px;
	}
	.ds-badge-sales{ background:rgba(67,97,238,.12); color:var(--ds-blue); }

	.ds-table-panel .table thead th{
		border-top:none; border-bottom:1px solid #eef0f6; color:var(--ds-muted);
		font-size:.72rem; text-transform:uppercase; letter-spacing:.4px; font-weight:700;
	}
	.ds-table-panel .table td{ vertical-align:middle; font-size:.85rem; border-color:#f1f2f7; }
	.ds-table-panel .table-striped tbody tr:nth-of-type(odd){ background-color:#fafbfe; }

	.ds-chart-wrap{ position:relative; height:230px; }
	@media (max-width:767px){ .ds-chart-wrap{ height:200px; } }

	.ds-filter-bar{
		background:#fff; border-radius:var(--ds-radius);
		box-shadow:0 6px 18px rgba(30,34,51,.06);
		padding:.85rem 1.1rem; margin-top:1.5rem; margin-bottom:.25rem;
		display:flex; flex-wrap:wrap; align-items:center; gap:1.1rem;
	}
	.ds-filter-group{ display:flex; align-items:center; gap:.5rem; }
	.ds-filter-group label{
		margin:0; font-size:.75rem; font-weight:700; color:var(--ds-muted);
		text-transform:uppercase; letter-spacing:.4px; display:flex; align-items:center; gap:.35rem;
	}
	.ds-filter-group input[type="date"],
	.ds-filter-group input[type="month"]{
		border:1px solid #e4e6ef; border-radius:10px; padding:.35rem .6rem;
		font-size:.85rem; color:var(--ds-ink); background:#fafbfe;
	}
	.ds-filter-group .btn{
		border-radius:10px; font-size:.8rem; padding:.35rem .9rem; font-weight:600;
	}
	.ds-filter-reset{ font-size:.78rem; color:var(--ds-muted); text-decoration:underline; cursor:pointer; }
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid p-3">

				<!-- Page header -->
				<div class="ds-page-header mb-4">
					<h1 class="page-header-title d-flex align-items-center">
						<span class="page-header-icon"><i class="fas fa-desktop"></i></span>
						<span>Dashboard</span>
					</h1>
				</div>

				<!-- Stat cards -->
				<div class="row">
					<div class="col-6 col-md-4 col-lg">
						<div class="ds-stat-card card-machine">
							<div class="ds-blob"></div>
							<div class="ds-icon"><i class="fas fa-coins"></i></div>
							<div class="ds-value">Rs. <?php if($todaysales->num_rows() > 0){ foreach($todaysales->result() as $rowlist){ echo number_format($rowlist->salestotal, 2); }} else { echo '0.00'; } ?></div>
							<div class="ds-label">Daily Sales Total</div>
						</div>
					</div>
					<div class="col-6 col-md-4 col-lg">
						<div class="ds-stat-card card-spares">
							<div class="ds-blob"></div>
							<div class="ds-icon"><i class="fas fa-chart-line"></i></div>
							<div class="ds-value">Rs. <?php if($monthsales->num_rows() > 0){ foreach($monthsales->result() as $rowlist){ echo number_format($rowlist->salestotal, 2); }} else { echo '0.00'; } ?></div>
							<div class="ds-label">Monthly Sales Total</div>
						</div>
					</div>
					<div class="col-6 col-md-4 col-lg">
						<div class="ds-stat-card card-materials" id="materialCard">
							<div class="ds-blob"></div>
							<div class="ds-icon"><i class="fas fa-file-alt"></i></div>
							<div class="ds-value"><?php if($materialinfo->num_rows() > 0){ foreach($materialinfo->result() as $rowlist){ echo $rowlist->stockcount; }} else { echo 0; } ?></div>
							<div class="ds-label">Print Materials</div>
						</div>
					</div>
					<div class="col-6 col-md-4 col-lg">
						<div class="ds-stat-card card-zero" id="zrostockCard">
							<div class="ds-blob"></div>
							<div class="ds-icon"><i class="fas fa-file-invoice-dollar"></i></div>
							<div class="ds-value"><?php if($zerostockinfo->num_rows() > 0){ foreach($zerostockinfo->result() as $rowlist){ echo $rowlist->stockcount; }} else { echo 0; } ?></div>
							<div class="ds-label">Zero Stock Products</div>
						</div>
					</div>
					<div class="col-6 col-md-4 col-lg">
						<div class="ds-stat-card card-low" id="lowstockCard">
							<div class="ds-blob"></div>
							<div class="ds-icon"><i class="fas fa-exclamation-triangle"></i></div>
							<div class="ds-value"><?php if($lowstockinfo->num_rows() > 0){ foreach($lowstockinfo->result() as $rowlist){ echo $rowlist->stockcount; }} else { echo 0; } ?></div>
							<div class="ds-label">Low Stock</div>
						</div>
					</div>
				</div>

				<!-- Date filters -->
				<div class="ds-filter-bar">
					<div class="ds-filter-group">
						<label><i class="far fa-calendar-alt"></i> Daily sales — week ending</label>
						<input type="date" id="dsDailyDate">
						<button type="button" class="btn btn-primary btn-sm" id="dsDailyApply">Apply</button>
					</div>
					<div class="ds-filter-group">
						<label><i class="far fa-calendar-alt"></i> Monthly sales — 12 months ending</label>
						<input type="month" id="dsMonthlyMonth">
						<button type="button" class="btn btn-primary btn-sm" id="dsMonthlyApply">Apply</button>
					</div>
					<span class="ds-filter-reset ml-auto" id="dsResetFilters">Reset to today</span>
				</div>

				<!-- Charts: Sales -->
				<div class="row mt-2">
					<div class="col-lg-6 mb-4">
						<div class="ds-panel">
							<div class="ds-panel-header">
								<h6 class="ds-panel-title">Daily Sales <small>Last 7 days</small></h6>
								<span class="ds-badge-pill ds-badge-sales">Sales</span>
							</div>
							<div class="ds-panel-body">
								<div class="ds-chart-wrap"><canvas id="dailySalesChart"></canvas></div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 mb-4">
						<div class="ds-panel">
							<div class="ds-panel-header">
								<h6 class="ds-panel-title">Monthly Sales <small>Last 12 months</small></h6>
								<span class="ds-badge-pill ds-badge-sales">Sales</span>
							</div>
							<div class="ds-panel-body">
								<div class="ds-chart-wrap"><canvas id="monthlySalesChart"></canvas></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Tables -->
				<div class="row">
					<div class="col-lg-6 mb-4">
						<div class="ds-panel ds-table-panel">
							<div class="ds-panel-header"><h6 class="ds-panel-title">Last Five Purchases</h6></div>
							<div class="ds-panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-sm">
										<thead>
											<tr>
												<th>Material</th>
												<th>Date</th>
												<th class="text-right">Qty</th>
												<th class="text-right">Unit</th>
												<th class="text-right">Total</th>
											</tr>
										</thead>
										<tbody>
											<?php if ($resultdate->num_rows() > 0) { foreach ($resultdate->result() as $item) { ?>
											<tr>
												<td><?php echo $item->materialname; ?></td>
												<td><?php echo $item->date; ?></td>
												<td class="text-right"><?php echo $item->qty; ?></td>
												<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
												<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
											</tr>
											<?php } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 mb-4">
						<div class="ds-panel ds-table-panel">
							<div class="ds-panel-header"><h6 class="ds-panel-title">Top Five Purchases</h6></div>
							<div class="ds-panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-sm">
										<thead>
											<tr>
												<th>Material</th>
												<th>Date</th>
												<th class="text-right">Qty</th>
												<th class="text-right">Unit</th>
												<th class="text-right">Total</th>
											</tr>
										</thead>
										<tbody>
											<?php if ($resultqty->num_rows() > 0) { foreach ($resultqty->result() as $item) { ?>
											<tr>
												<td><?php echo $item->materialname; ?></td>
												<td><?php echo $item->date; ?></td>
												<td class="text-right"><?php echo $item->qty; ?></td>
												<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
												<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
											</tr>
											<?php } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 mb-4">
						<div class="ds-panel ds-table-panel">
							<div class="ds-panel-header"><h6 class="ds-panel-title">Non Moving Materials</h6></div>
							<div class="ds-panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-sm">
										<thead>
											<tr>
												<th>Material</th>
												<th>Date</th>
												<th class="text-right">Qty</th>
												<th class="text-right">Unit Price</th>
												<th class="text-right">Total</th>
											</tr>
										</thead>
										<tbody>
											<?php if ($resultnonmove->num_rows() > 0) { foreach ($resultnonmove->result() as $item) { ?>
											<tr>
												<td><?php echo $item->materialname; ?></td>
												<td><?php echo $item->grndate; ?></td>
												<td class="text-right"><?php echo $item->qty; ?></td>
												<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
												<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
											</tr>
											<?php } } ?>
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

<!-- Modal of View Material -->
<div class="modal fade" id="tableModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Print Material Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable">
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

<!-- Modal Zero stock Product -->
<div class="modal fade" id="tableModal4" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Zero Product stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable4">
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

<!-- Modal low stock Product -->
<div class="modal fade" id="tableModal5" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Low stock Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable5">
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

<?php include "include/footerscripts.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
	// Data passed from the controller (json_encode'd arrays: {labels:[...], data:[...]})
	var dailySalesData   = <?php echo $dailysales; ?>;
	var monthlySalesData = <?php echo $monthlysales; ?>;

	function dsGradient(ctx, colorFrom, colorTo){
		var g = ctx.createLinearGradient(0, 0, 0, 220);
		g.addColorStop(0, colorFrom);
		g.addColorStop(1, colorTo);
		return g;
	}

	// Formats a number safely — never lets an undefined/null value leak into the tooltip
	function dsMoney(v){
		var n = Number(v);
		if (isNaN(n)) { n = 0; }
		return 'Rs. ' + n.toLocaleString();
	}

	// Shared tooltip config used by every chart below. Explicit title + label
	// callbacks (rather than relying on Chart.js defaults) is what stops the
	// tooltip from ever rendering the word "undefined".
	function dsTooltipOptions(seriesName){
		return {
			mode: 'index',
			intersect: false,
			displayColors: true,
			callbacks: {
				title: function(items){
					return (items && items.length) ? items[0].label : '';
				},
				label: function(ctx){
					var y = (ctx.parsed && typeof ctx.parsed.y === 'number') ? ctx.parsed.y : 0;
					return ' ' + seriesName + ': ' + dsMoney(y);
				}
			}
		};
	}

	function buildLineChart(canvasId, labels, data, lineColor, fillFrom, fillTo, seriesName){
		var ctx = document.getElementById(canvasId).getContext('2d');
		return new Chart(ctx, {
			type: 'line',
			data: {
				labels: labels,
				datasets: [{
					label: seriesName,
					data: data,
					borderColor: lineColor,
					backgroundColor: dsGradient(ctx, fillFrom, fillTo),
					borderWidth: 2.5,
					fill: true,
					tension: 0.35,
					pointRadius: 3,
					pointBackgroundColor: lineColor,
					pointBorderColor: '#fff',
					pointBorderWidth: 1.5
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: { display: false },
					tooltip: dsTooltipOptions(seriesName)
				},
				scales: {
					x: { grid: { display: false } },
					y: { grid: { color: '#f1f2f7' }, ticks: { callback: function(v){ return 'Rs. ' + v; } } }
				}
			}
		});
	}

	function buildBarChart(canvasId, labels, data, barColor, seriesName){
		var ctx = document.getElementById(canvasId).getContext('2d');
		return new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: seriesName,
					data: data,
					backgroundColor: barColor,
					borderRadius: 6,
					maxBarThickness: 28
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: { display: false },
					tooltip: dsTooltipOptions(seriesName)
				},
				scales: {
					x: { grid: { display: false } },
					y: { grid: { color: '#f1f2f7' }, ticks: { callback: function(v){ return 'Rs. ' + v; } } }
				}
			}
		});
	}

	// Chart instances kept in scope so the date filters below can update them in place
	var dsDailySalesChart, dsMonthlySalesChart;

	function dsUpdateChart(chart, payload){
		chart.data.labels = payload.labels;
		chart.data.datasets[0].data = payload.data;
		chart.update();
	}

	$(document).ready(function() {

		dsDailySalesChart   = buildLineChart('dailySalesChart', dailySalesData.labels, dailySalesData.data, '#4361ee', 'rgba(67,97,238,.35)', 'rgba(67,97,238,0)', 'Sales');
		dsMonthlySalesChart = buildBarChart('monthlySalesChart', monthlySalesData.labels, monthlySalesData.data, '#4361ee', 'Sales');

		// Default the pickers to today / current month
		var dsToday = new Date();
		var dsPad = function(n){ return n < 10 ? '0' + n : '' + n; };
		var dsTodayStr = dsToday.getFullYear() + '-' + dsPad(dsToday.getMonth() + 1) + '-' + dsPad(dsToday.getDate());
		var dsMonthStr = dsToday.getFullYear() + '-' + dsPad(dsToday.getMonth() + 1);
		$('#dsDailyDate').val(dsTodayStr);
		$('#dsMonthlyMonth').val(dsMonthStr);

		function dsLoadDaily(dateVal){
			$.post('<?php echo base_url() ?>Welcome/DailyChartData', { enddate: dateVal }, function(resp){
				dsUpdateChart(dsDailySalesChart, resp.sales);
			}, 'json');
		}

		function dsLoadMonthly(monthVal){
			$.post('<?php echo base_url() ?>Welcome/MonthlyChartData', { endmonth: monthVal }, function(resp){
				dsUpdateChart(dsMonthlySalesChart, resp.sales);
			}, 'json');
		}

		$('#dsDailyApply').on('click', function(){
			var v = $('#dsDailyDate').val();
			if (v) { dsLoadDaily(v); }
		});

		$('#dsMonthlyApply').on('click', function(){
			var v = $('#dsMonthlyMonth').val();
			if (v) { dsLoadMonthly(v); }
		});

		// Let the pickers apply on change too, not just on button click
		$('#dsDailyDate').on('change', function(){ dsLoadDaily($(this).val()); });
		$('#dsMonthlyMonth').on('change', function(){ dsLoadMonthly($(this).val()); });

		$('#dsResetFilters').on('click', function(){
			$('#dsDailyDate').val(dsTodayStr);
			$('#dsMonthlyMonth').val(dsMonthStr);
			dsLoadDaily(dsTodayStr);
			dsLoadMonthly(dsMonthStr);
		});

		$('#dataTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalmateriallist.php",
				type: "POST",
			},
			"order": [[0, "desc"]],
			"columns": [
				{ "data": "idtbl_print_stock" },
				{ "data": "grndate" },
				{ "data": "suppliername" },
				{ "data": "qty" },
				{ "data": "unitprice" },
				{ "data": "materialname" },
				{ "data": "total" },
			],
		});

		$('#dataTable4').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalZeroProductlist.php",
				type: "POST",
			},
			"order": [[0, "desc"]],
			"columns": [
				{ "data": "idtbl_print_stock" },
				{ "data": "grndate" },
				{ "data": "suppliername" },
				{ "data": "materialname" },
				{ "data": "qty" },
				{ "data": "unitprice" },
			],
		});

		$('#dataTable5').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totallowProductlist.php",
				type: "POST",
			},
			"order": [[0, "desc"]],
			"columns": [
				{ "data": "idtbl_print_stock" },
				{ "data": "grndate" },
				{ "data": "suppliername" },
				{ "data": "materialname" },
				{ "data": "qty" },
				{ "data": "unitprice" },
				{ "data": "total" },
			],
		});

		$('#materialCard').on('click', function() { $('#tableModal').modal('show'); });
		$('#zrostockCard').on('click', function() { $('#tableModal4').modal('show'); });
		$('#lowstockCard').on('click', function() { $('#tableModal5').modal('show'); });
	});
</script>
<?php include "include/footer.php"; ?>