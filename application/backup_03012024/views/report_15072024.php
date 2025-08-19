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
							<div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
							<span>Stock Report</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searchStock">
								<div class="col-12">
									<div class="form-row mt-2">
										<div class="col-2">
											<label class="small font-weight-bold">Type*</label>
											<select class="form-control form-control-sm" name="type" id="type" required
												onchange="showCategoryField()">
												<option value="">Select</option>
												<option value="1">Material</option>
												<option value="2">Machine</option>
												<option value="3">Spare Parts</option>
											</select>
										</div>
										<div class="col-2" id="categoryField" style="display: none;">
											<label class="small font-weight-bold">Category*</label>
											<select class="form-control form-control-sm selecter2 px-0" name="category"
												id="category" required>
												<option value="">Select</option>
												<option value="0">All</option>
												<?php foreach ($getcategory->result() as $rowgetcategory) { ?>
												<option value="<?php echo $rowgetcategory->idtbl_material_type ?>">
													<?php echo $rowgetcategory->paper ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-auto align-self-end">
											<button type="submit" id="submitBtnStock" name="submitBtnStock"
												class="btn btn-info btn-sm px-4"
												<?php if($addcheck==0){echo 'disabled';} ?>>
												<i class="fas fa-search"></i>&nbsp;Search
											</button>
										</div>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</div>

								<div class="col-12">
									<div class="form-group mb-1">
										<hr style="border: 1px solid #ddd;">
									</div>
								</div>
							</form>
							<button onclick="exportToPDF()" class="btn-light-green">Export to PDF</button>

							<div class="col-12 mt-4" id="mainTable">

							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<style>
    .btn-light-green {
        background-color: lightgreen;
        border: none;
        color: black;
        border-radius: 25px; /* Rounded corners */
        padding: 10px 20px; /* Optional: Add padding */
        font-size: 14px; /* Optional: Adjust font size */
    }
</style>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
	function showCategoryField() {
		var typeValue = document.getElementById('type').value;
		var categoryField = document.getElementById('categoryField');

		if (typeValue === '1') { // Material
			categoryField.style.display = 'block';
		} else {
			categoryField.style.display = 'none';
		}
	}

</script>



<script>
	$(document).ready(function () {
		$("#searchStock").submit(function (event) {
			event.preventDefault();

			var selectedType = $("#type").val();
			var typeName;

			if (selectedType == 1) {
				typeName = 'Material';
			} else if (selectedType == 2) {
				typeName = 'Machine';
			} else {
				typeName = 'spare_part_name';
			}

			// var table = $('#dataTable').DataTable({
			// 	"destroy": true,
			// 	"processing": true,
			// 	"serverSide": true,
			// 	scrollY: 350,
			// 	ajax: {
			// 		url: "<?php echo base_url() ?>scripts/reportlist.php",
			// 		type: "POST", // you can use GET
			// 		"data": function (d) {
			// 			return $.extend({}, d, {
			// 				"search_type": $("#type").val(),
			// 				"category": $("#category").val(),

			// 			});
			// 		}
			// 	},
			// 	"order": [
			// 		[0, "desc"]
			// 	],
			// 	"columns": [{
			// 			"data": "idtbl_print_stock"
			// 		},
			// 		{
			// 			"data": function (row) {
			// 				if (selectedType == 2) {
			// 					return row.machine;
			// 				} else if (selectedType == 1) {
			// 					return row.materialname;
			// 				} else {
			// 					return row.spare_part_name;
			// 				}
			// 			}
			// 		},
			// 		{
			// 			"data": "batchno"
			// 		},
			// 		{
			// 			"data": "location"
			// 		},
			// 		{
			// 			"data": "qty"
			// 		},
			// 		{
			// 			"data": "unitprice"
			// 		},
			// 		{
			// 			"data": "paper"
			// 		},
			// 		{
			// 			"data": "total",
			// 			"className": "text-right"
			// 		}
			// 	],
			// 	dom: 'Bfrtip',
			// 	dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
			// 		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			// 	responsive: true,
			// 	lengthMenu: [
			// 		[-1],
			// 		['All'],
			// 	],
			// 	buttons: [{
			// 			extend: 'pdf',
			// 			className: 'btn btn-primary btn-sm',
			// 			text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			// 			title: 'Stock Report',
			// 			filename: 'Stock Report ' + typeName,
			// 			footer: true,
			// 			messageTop: {
			// 				text: 'Stock Report',
			// 				fontSize: 15,
			// 				bold: true,
			// 				alignment: 'center'
			// 			},
			// 			customize: function (doc) {
			// 				doc.styles.title = {
			// 					color: 'black',
			// 					fontSize: '30',
			// 					alignment: 'center',
			// 				}
			// 			}
			// 		},
			// 		{
			// 			extend: 'excel',
			// 			className: 'btn btn-success btn-sm',
			// 			filename: 'Stock Report ' + typeName,
			// 			text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
			// 			footer: true,
			// 			title: 'MULTI OFFSET PRINTERS Stock Report - By Erav Technology'
			// 		},
			// 		{
			// 			extend: 'csv',
			// 			className: 'btn btn-info btn-sm',
			// 			filename: 'Stock Report ' + typeName,
			// 			text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			// 			footer: true
			// 		},
			// 		{
			// 			extend: 'print',
			// 			className: 'btn btn-warning btn-sm',
			// 			text: '<i class="fas fa-print mr-2"></i> PRINT',
			// 			title: 'Stock Report',
			// 			filename: 'Stock Report ' + typeName,
			// 			footer: true,
			// 			messageTop: 'Stock Report ' + typeName,
			// 			customize: function (doc) {
			// 				doc.styles.title = {
			// 					color: 'black',
			// 					fontSize: '30',
			// 					alignment: 'center',
			// 				}
			// 			}
			// 		}
			// 	],
			// 	footerCallback: function (row, data, start, end, display) {
			// 		var api = this.api();

			// 		// Remove the formatting to get integer data for summation
			// 		var intVal = function (i) {
			// 			return typeof i === 'string' ?
			// 				i.replace(/[\$,]/g, '') * 1 :
			// 				typeof i === 'number' ?
			// 				i : 0;
			// 		};

			// 		// Total over all pages for column 3 (index 2)
			// 		var totalColumn3 = api
			// 			.column(7)
			// 			.data()
			// 			.reduce(function (a, b) {
			// 				return intVal(a) + intVal(b);
			// 			}, 0);

			// 		// Total over this page for column 3 (index 2)
			// 		var pageTotalColumn3 = api
			// 			.column(7, {
			// 				page: 'current'
			// 			})
			// 			.data()
			// 			.reduce(function (a, b) {
			// 				return parseFloat(intVal(a) + intVal(b)).toFixed(2);
			// 			}, 0);

			// 		// Update footer of column 3 with the page total
			// 		$(api.column(7).footer()).html('Rs. ' + pageTotalColumn3);
			// 	},
			// });

			var type = $("#type").val();
			var category = $("#category").val();
			$('#mainTable').empty();
			$.ajax({
				type: "POST",
				data: {
					type: type,
					category: category
				},
				url: '<?php echo base_url() ?>Report/stockReport',
				success: function (result) { //alert(result);
					var dataArray = JSON.parse(result);

					if (type == '1') {
						var typewiselist = {};
						dataArray.forEach(function (list) {
							var materialtype = list['paper'];
							if (typewiselist.hasOwnProperty(materialtype)) {
								typewiselist[materialtype].push(list);
							} else {
								typewiselist[materialtype] = [list];
							}
						});

						$.each(typewiselist, function (type, items) {
							$('#mainTable').append(generateTable(type, items));
						});

					} else if ($type == '2') {

					} else if ($type == '3') {

					}


				}
			});

		});
	});

	//material type table load
	function generateTable(type, items) {
		let tableHtml = `
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap w-100">
										<h3>${type}</h3>
										<caption>${type}</caption>
											<thead class="thead-light">
												<tr>
													<th>#</th>
													<th>Product Name</th>
													<th>Batch No</th>
													<th>Location</th>
													<th>Quantity</th>
													<th>Unit Price</th>
													<th>Category</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
								`;

		let rowIndex = 1;
		let typeTotal = 0;

		items.forEach(function (item) {
			let total = parseFloat(item.total);
			typeTotal += total;

			tableHtml += `
										<tr>
											<td>${rowIndex++}</td>
											<td>${item.materialname}</td>
											<td>${item.batchno}</td>
											<td>${item.location}</td>
											<td>${item.qty}</td>
											<td>${parseFloat(item.unitprice).toFixed(2)}</td>
											<td>${item.paper}</td>
											<td>${parseFloat(total).toFixed(2)}</td>
										</tr>
									`;
		});

		tableHtml += `
											</tbody>
											<tfoot class="thead-light">
												<tr>
													<th colspan="6" class="text-right"></th>
													<th class="text-right">Total:</th>
													<th>${parseFloat(typeTotal).toFixed(2)}</th>
												</tr>
											</tfoot>
										</table>
									</div>
								`;

		return tableHtml;
	}


	function exportToPDF() {
		const {
			jsPDF
		} = window.jspdf;

		// Create a new instance of jsPDF
		const doc = new jsPDF();

		// Add the title at the top of the document and center it
		doc.setFontSize(16); // Set font size for the title
		const title = 'Stock Information';
		const pageWidth = doc.internal.pageSize.getWidth();
		const textWidth = doc.getTextWidth(title);
		const xOffset = (pageWidth - textWidth) / 2;
		doc.text(title, xOffset, 10);

		let yOffset = 20; // Adjust the initial yOffset to make room for the title

		// Get the tables from the page
		const tables = document.querySelectorAll('#mainTable table');
		tables.forEach((table, index) => {
			const captionElement = table.querySelector('caption');
			const caption = captionElement ? captionElement.textContent : '';
			// Add the caption before the table
			if (caption) {
				doc.setFontSize(12);
				doc.text(caption, 15, yOffset);
				yOffset += 5; // Increment Y offset for the next caption
			}

			// Convert the table to an AutoTable
			doc.autoTable({
				html: table,
				startY: yOffset + 5,
				theme: 'grid',
				headStyles: {
					fillColor: [255, 255, 255],
					textColor: [0, 0, 0]
				},
			});

			yOffset = doc.autoTable.previous.finalY + 10; // Update Y offset after the table

			// Add some space between tables
			yOffset += 5;
		});

		// Save the PDF
		doc.save('StockReport-MultiOffset.pdf');
	}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>


<?php include "include/footer.php"; ?>
