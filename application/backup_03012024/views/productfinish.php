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
							<div class="page-header-icon"><i class="fas fa-list"></i></div>
							<span>Product Finish</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<form id="searchform">
							<div class="form-row">
								<div class="col-3">
									<label class="small font-weight-bold text-dark">Customer Inquiries*</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="customerinquiry"
											id="customerinquiry" required>
											<option value="">Select</option>
											<?php foreach ($inquirylist->result() as $rowinquirylist) { ?>
											<option value="<?php echo $rowinquirylist->idtbl_customerinquiry ?>">
												<?php echo $rowinquirylist->po_number . ' - ' . $rowinquirylist->name ?>
											</option>
											<?php } ?>
										</select>
									</div>
									<input type="hidden" id="hiddenmachinevalue">
								</div>
								<div class="col-3">
									<label class="small font-weight-bold text-dark">Inquiry Details *</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="inquirydetailsid"
											id="inquirydetailsid" required>
											<option value="">Select</option>
										</select>
									</div>
									<input type="hidden" id="hiddenmachinevalue">
								</div>
							</div>
							<input type="submit" class="d-none" id="hidesubmit">
						</form>
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblorderreconsilation">
										<thead>
											<tr>
												<th>#</th>
												<th>Cost Item</th>
												<th>Comment</th>
												<th>Total Qty</th>
												<th>Finished Qty</th>
												<th>Wasted Qty</th>
												<!-- <th>Balance Qty</th> -->
											</tr>
										</thead>
										<tbody></tbody>
									
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
	$('#customerinquiry').change(function () {
		let recordId = $('#customerinquiry :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('NewDeliveryPlan/GetInquiryDetails'); ?>",
			data: {
				recordId: recordId
			},
			success: function (result) {
				var obj = JSON.parse(result);

				var html1 = '';
				html1 += '<option value="">Select</option>';
				$.each(obj, function (i, item) {
					// alert(result[i].id);
					html1 += '<option value="' + obj[i].idtbl_customerinquiry_detail + '">';
					html1 += obj[i].job;
					html1 += '</option>';
				});
				$('#inquirydetailsid').empty().append(html1);
			}
		});
	})

	$('#inquirydetailsid').change(function () {
        let recordId = $('#inquirydetailsid :selected').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('OrderReconsilation/Getdeliveryplanlist'); ?>",
            data: {
                recordId: recordId
            },
            success: function (result) {
				$('#tblorderreconsilation> tbody:last').empty().append(result);
            }
        });
	})

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}

	function productDelete(ctl) {
		$(ctl).parents("tr").remove();
	}
</script>
<?php include "include/footer.php"; ?>