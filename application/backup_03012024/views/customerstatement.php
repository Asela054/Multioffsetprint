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
							<span>Customer Statement</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searstatement">
								<div class="col-12">
									<div class="form-row mt-2">
										<!-- <div class="col-2">
											<label class="small font-weight-bold">Type*</label>
											<select class="form-control form-control-sm" name="type" id="type" required
												onchange="showCategoryField()">
												<option value="">Select</option>
												<option value="1">Material</option>
												<option value="2">Machine</option>
												<option value="3">Spare Parts</option>
											</select>
										</div> -->
										<div class="col-3">
											<label class="small font-weight-bold">Customer*</label>
											<select class="form-control form-control-sm selecter2 px-0" name="customer"
												id="customer" required>
												<option value="">Select</option>
												<!-- <option value="all">All</option> -->
												<?php foreach ($getcustomer->result() as $rowgetcustomer) { ?>
												<option value="<?php echo $rowgetcustomer->idtbl_customer ?>">
													<?php echo $rowgetcustomer->name ?></option>
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
				border-radius: 25px;
				/* Rounded corners */
				padding: 10px 20px;
				/* Optional: Add padding */
				font-size: 14px;
				/* Optional: Adjust font size */
			}

		</style>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>


<script>
	$(document).ready(function () {
		$('.selecter2').select2();
		$("#searstatement").submit(function (event) {
			event.preventDefault();


			var customer = $("#customer").val();

			$('#mainTable').empty();
			$.ajax({
				type: "POST",
				data: {
					customer: customer

				},
				url: '<?php echo base_url() ?>Customerstatement/customerstatementReport',
				success: function (result) {
					//alert(result);
					var dataArray = JSON.parse(result);

					var typewiselist = {};
					dataArray.forEach(function (list) {
						var materialtype = list['name'];
						if (typewiselist.hasOwnProperty(materialtype)) {
							typewiselist[materialtype].push(list);
						} else {
							typewiselist[materialtype] = [list];
						}
					});

					$.each(typewiselist, function (type, items) {
						$('#mainTable').append(generateTable(type, items));
					});




				}
			});

		});
	});

	//material type table load

	function generateTable(type, items) {
		let tableHtml = `
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap w-100">
										
										<caption>${type}</caption>
											<thead class="thead-light">
												<tr>
													<th style="width: 10%;">Date</th>
													<th style="width: 10%;">Reference</th>
													<th style="width: 30%;">Customer</th>
													<th style="width: 16%; text-align: right;">Debit</th>
													<th style="width: 16%; text-align: right;">Credit</th>
													<th style="width: 18%; text-align: right;">Balance</th>
												</tr>
											</thead>
											<tbody>
								`;

								let rowIndex = 1;
								let typeTotal = 0;
								let subtotal=0;

								items.forEach(function (item) {
									
								let total = parseFloat(item.amount);
								
								typeTotal += total;

								let credit=0;

								if(total!=='' || total!==null || total>0){
									subtotal=subtotal+total;
								}

								if(credit!=='' || credit!==null || credit>0){
									subtotal=subtotal-credit;
								}

								tableHtml += `
										<tr>
											<td>${item.invdate}</td>
											<td>INV000${item.invno}</td>
											<td>${item.job}</td>
											<td style="text-align: right;">${parseFloat(item.amount).toFixed(2)}</td>
											<td style="text-align: right;">${parseFloat(credit).toFixed(2)}</td>
											<td style="text-align: right;">${parseFloat(subtotal).toFixed(2)}</td>
										</tr>

									`;
								});

								tableHtml += `
											</tbody>
											<tfoot class="thead-light">
												<tr>
												
												
												</tr>
											</tfoot>
										</table>
									</div>
								`;

								return tableHtml;
	}
												// <tr>
												// 	<th colspan="4" class="text-right"></th>
												// 	<th class="text-right">Total:</th>
												// 	<th>${parseFloat(typeTotal).toFixed(3)}</th>
												// </tr>

	function exportToPDF() {
		const {
			jsPDF
		} = window.jspdf;

		// Create a new instance of jsPDF
		const doc = new jsPDF();

		// Add the title at the top of the document and center it
		doc.setFontSize(16); // Set font size for the title
		const title = 'Customer Statement Information';
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
		doc.save('Customer Statement-MultiOffset.pdf');
	}

	

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>


<?php include "include/footer.php"; ?>
