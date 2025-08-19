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
							<span>Plan Details</span>
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
												<?php echo $rowinquirylist->po_number . ' - ' . $rowinquirylist->customer ?>
											</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<!-- <div class="col-3">
									<label class="small font-weight-bold text-dark">Inquiry Details *</label>
									<div class="input-group input-group-sm mb-3">
										<select class="form-control form-control-sm" name="inquirydetailsid"
											id="inquirydetailsid" required>
											<option value="">Select</option>
										</select>
									</div>
								</div> -->
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
												<th>Po Number</th>
												<th>Delivery Id</th>
												<th>Actions</th>
												<!-- <th>Balance Qty</th> -->
											</tr>
										</thead>
										<tbody></tbody>

									</table>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-12">
								<h3 class="page-header-title font-weight-light mt-3">
									<span>Plan View</span>
								</h3>
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblplandetails">
										<thead>
											<tr>
												<th>Plan Id</th>
												<th>Item</th>
												<th>Delivery Date</th>
												<th>Qty</th>
												<th>Actions</th>
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

	<!-- finishing details model -->
	<div class="modal fade" id="finishqtyModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h4>Finishing details</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<form action="">
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Required qty :</label>
								<input type="number" step="any" name="finishingqty" class="form-control form-control-sm" id="finishingqty"
									required>
							</div>
							<div class="form-group mt-2">
								&nbsp; <button type="button" name="BtnAdd" id="BtnAdd" class="btn btn-primary btn-sm"><i
										class="fas fa-plus"></i>&nbsp;Add</button>
								<input type="submit" class="d-none" id="hidebtnaddlist">
							</div>
							</form>
						</div>
						<div class="col-md-8 scrollbar pb-3" id="style-2">
							<table class="table table-bordered table-striped table-sm nowrap" id="tblquantitylist">
								<thead>
									<tr>
										<th>Item</th>
										<th>Delivery Qty</th>
										<th>Required Qty Per Item</th>
										<th>Finished Qty</th>
										<th>Wastage</th>
									</tr>
								</thead>
								<tbody id="tblbodyshowdetails">
								</tbody>
							</table>
							<input type="hidden" id = "possibleqty" name = "possibleqty">
							<input type="hidden" id = "deliveryqty" name = "deliveryqty">
							<input type="hidden" id = "hiddendeliverydetailid" name = "hiddendeliverydetailid">
							<p class = "text-info" id = "possibletext"></p>
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
	$('#customerinquiry').change(function () {
		let recordId = $('#customerinquiry :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('PlanDetails/GetDeliveryist'); ?>",
			data: {
				recordId: recordId
			},
			success: function (result) { //alert(result)
				$('#tblorderreconsilation> tbody:last').empty().append(result);
			}
		});
	})
	$('#BtnAdd').click(function () {
		let qty = $('#finishingqty').val();
		let deliveryqty = $('#deliveryqty').val();
		let possibleqty = $('#possibleqty').val();
		let deliverydetailsid = $('#hiddendeliverydetailid').val();

		// if(qty != deliveryqty || qty < possibleqty){
		// 	return
		// }

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('PlanDetails/FinishDelivery'); ?>",
			data: {
				finishqty: qty,
				deliverydetailsid: deliverydetailsid
			},
			success: function (result) { 
				location.reload()
				// var objfirst = JSON.parse(result);
				// 	if (objfirst.status == 1) {
				// 		setTimeout(function () {
				// 			location.reload();
				// 		}, 1000);
				// 	}
				// action(objfirst.action)			
			}
		});
	})

	$('#inquirydetailsid').change(function () {
		let recordId = $('#inquirydetailsid :selected').val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('PlanDetails/GetJobList'); ?>",
			data: {
				recordId: recordId
			},
			success: function (result) { //alert(result)
				$('#tblorderreconsilation> tbody:last').empty().append(result);
				$('#tblplandetails> tbody').empty()
			}
		});
	})

	$('#tblorderreconsilation tbody').on('click', '.btnViewDelivery', function () {
		var deliveryId = $(this).attr('id');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('PlanDetails/GetDeliveryPlanDetails'); ?>",
			data: {
				deliveryId: deliveryId
			},
			success: function (result) {
				// console.log(result)
				$('#tblplandetails> tbody:last').empty().append(result);

			}
		});
	})
	$('#tblplandetails tbody').on('click', '.btnViewDeliveryQuantities', function () {
		$('#deliveryqty').val('');
		$('#possibletext').html('')

		var deliveryId = $(this).attr('id');
		$('#hiddendeliverydetailid').val(deliveryId);

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('PlanDetails/GetFinishQtyList'); ?>",
			data: {
				deliveryId: deliveryId
			},
			success: function (result) {
				$('#finishqtyModel').modal('show')
				$('#tblquantitylist> tbody:last').empty().append(result);

			}
		});
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('PlanDetails/GetAvailabilityOfItems'); ?>",
			data: {
				deliveryId: deliveryId
			},
			success: function (result) {
				// alert(result)
				var obj = JSON.parse(result);
				$('#possibleqty').val(obj.possibleqty);
				$('#deliveryqty').val(obj.deliveryqty);
				$('#possibletext').html('You can finish upto ' + obj.possibleqty + ' quantities for this item');
				// $('#finishqtyModel').modal('show')
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
</script>
<?php include "include/footer.php"; ?>
