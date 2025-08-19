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
							<div class="page-header-icon"><i class="fas fa-users"></i></div>
							<span>Material Allocation</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-3">
								<form id="updatequotationform" method="post" autocomplete="off">
									<div class="col-12">
										<label class="small font-weight-bold text-dark"> Customer *</label>
										<select class="form-control form-control-sm selecter2 px-0" name="customer"
											id="customer" required>
											<option value="">Select</option>
											<?php foreach($customerlist->result() as $rowcustomerlist){ ?>
											<option value="<?php echo $rowcustomerlist->idtbl_customer ?>">
												<?php echo $rowcustomerlist->name?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Job *</label>
											<select class="form-control form-control-sm  selecter2 px-0" name="job"
												id="job" required>
												<option value="">Select</option>

											</select>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Quotations *</label>
											<select class="form-control form-control-sm  selecter2 px-0"
												name="quotation" id="quotation" required>
												<option value="">Select</option>

											</select>
										</div>
									</div>
									<hr>
									<div class="col-12">
										<label class="small font-weight-bold text-dark">Material *</label>
										<select class="form-control form-control-sm selecter2 px-0"
											name="updatematerial" id="updatematerial" required>
											<option value="">Select</option>
											<?php foreach($materiallist->result() as $rowmaterial){ ?>
											<option value="<?php echo $rowmaterial->idtbl_print_material_info ?>">
												<?php echo $rowmaterial->materialname?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-12">
										<label class="small font-weight-bold text-dark">Qty</label>
										<input type="text" id="updateqty" name="updateqty"
											class="form-control form-control-sm">
									</div>
									<div class="col-12">
										<label class="small font-weight-bold text-dark">Unit Price</label>
										<input type="text" id="updateunitprice" name="updateunitprice"
											class="form-control form-control-sm" readonly>
									</div>
									<input type="submit" class="d-none" id="hideupdatequotation">
									<input type="hidden" name="hiddenmaterialtype" id="hiddenmaterialtype">
									<input type="hidden" name="hiddengaugetype" id="hiddengaugetype">

									<div class="form-group mt-2 text-right">
										<button type="button" id="submitBtn" class="btn btn-primary btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>><i
												class="far fa-save"></i>&nbsp;Update</button>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</form>
							</div>
							<div class="col-9">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="tblallocationdetails">
										<thead>
											<tr>
												<th>Material</th>
												<th class="text-right">Qty</th>
												<th class="text-right">Unit Price</th>
												<th class="text-right">Total</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="form-group mt-2 float-right">
											<input type="hidden" name="materialrecordOption" id="materialrecordOption"
												value='0'>
											<input type="hidden" name="materialrecordID" id="materialrecordID"
												value='0'>
											<input type="hidden" name="hiddenquotationid" id="hiddenquotationid"
												value='0'>
											<button type="button" name="btnSaveAllocation" id="btnSaveAllocation"
												class="btn btn-primary btn-m "><i
													class="far fa-save"></i>&nbsp;Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="tblallallocations">
                                        <thead>
                                            <tr>
                                                <th>Quotation Id</th>
                                                <th>Job</th>
                                                <th>Job Id</th>
                                                <th>Job No</th>
                                                <th>Quantity</th>
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
     <!--  view model -->
     <div class="modal fade" id="editmodelview" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">View Customer Inquary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <hr>
                        <div class="col-12">
                            <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap" id="tblquotationlist">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblquotationlistbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
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

        $('#tblallallocations').DataTable({
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
					title: 'Approved Customer Inquiry  Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Approved Customer Inquiry  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Approved Customer Inquiry  Information',
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
				url: "<?php echo base_url() ?>scripts/allcustomerquotationlist.php",
				type: "POST", // you can use GET
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
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.settings._iRecordsDisplay - meta.row;
                    }
                },
				{
					"data": "job"
				},
				{
					"data": "job_id"
				},
				{
					"data": "job_no"
				},
				{
					"data": "qty"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';

						button += '<button class="btn btn-dark btn-sm btnView mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
                        if (full['approvedstatus'] == 0) {
							button += '" id="' + full['idtbl_jobquatation'] +
							'"><i class="fas fa-eye"></i></button>';
                            button +=
                                '<a href="<?php echo base_url() ?>MaterialAllocation/ApproveAllocatedQuotation/'+full['idtbl_jobquatation']+'" onclick="return approve_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                            if (editcheck != 1) {
                                button += 'd-none';
                            }
                            button += '"><i class="fas fa-check mr-1"></i></a>';
						}else{
                            button += '" id="' + full['idtbl_jobquatation'] +
							'"><i class="fas fa-eye"></i></button>';
                            button +=
                                '<button class="btn btn-success btn-sm mr-1 ';
                            if (editcheck != 1) {
                                button += 'd-none';
                            }
                            button += '"><i class="fas fa-check mr-1"></i></button>';
                        }
						
						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#customer').select2({
			width: '100%',
		});

		$('#job').select2({
			width: '100%',
		});

		
        $(document).on('click', '.btnView', function() {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>MaterialAllocation/GetAllocationdetailsformodal',
                success: function(result) { //alert(result);
                    $('#editmodelview').modal('show');
                    $('#tblquotationlistbody').html(result);


                }
            });
            //}
    });

		$('#customer').change(function () {
			var customerID = $(this).val();
			$('#job').empty();
			$('#job').prepend('<option value="" selected="selected">Select job</option>');
			$('#job').val(null).trigger('change');
			// get jobs
			//alert(customerID);
			$.ajax({
				type: "POST",
				data: {
					recordID: customerID
				},
				url: 'MaterialAllocation/Getcustomerjobs',
				success: function (result) {
					//alert(result);
					// console.log(result);
					var obj = JSON.parse(result);
					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						html1 += '<option value="' + obj[i]
							.job_id + '">';
						html1 += obj[i].job + ' / ' + obj[i].job_id;
						html1 += '</option>';
					});
					$('#job').empty().append(html1);
					// $('#uom').empty().append(html1);
				}
			});
		});
		$('#job').change(function () {
			var jobId = $(this).val();
			$('#quotation').empty();
			$('#quotation').prepend('<option value="" selected="selected">Select quotation</option>');
			$('#quotation').val(null).trigger('change');

			$.ajax({
				type: "POST",
				data: {
					recordID: jobId
				},
				url: 'MaterialAllocation/Getjobvisequotations',
				success: function (result) {
					// alert(jobId);
					// console.log(result);
					var obj = JSON.parse(result);
					var html1 = '';
					html1 += '<option value="">Select</option>';
					$.each(obj, function (i, item) {
						html1 += '<option value="' + obj[i]
							.idtbl_jobquatation + '">';
						html1 += 'ID: ' + obj[i].idtbl_jobquatation + ' QTY: ' + obj[i]
							.quantity;
						html1 += '</option>';
					});
					$('#quotation').empty().append(html1);
				}
			});
		});

		$('#quotation').change(function () {
			var quotationId = $(this).val();
			$('#hiddenquotationid').val(quotationId)
			var c = 0;
			$.ajax({
				type: "POST",
				data: {
					recordID: quotationId
				},
				url: 'MaterialAllocation/Getquotationdetailsfortable',
				success: function (result) {
					var objfirst = JSON.parse(result); console.log(result)
					$('#tblallocationdetails > tbody').empty();

					$.each(objfirst, function (i, item) {
						c += 1;
						// alert(objfirst[i].materialname)
						//$('#hiddenquotationid').val(objfirst[i].idtbl_jobquatation)
						
						$('#tblallocationdetails > tbody:last').append('<tr><td>' +
							objfirst[i].materialname +
							'</td><td class="text-center editnewqty">' +
							objfirst[i].qty + '</td><td class="text-right">' +
							objfirst[i].unit_price +
							'<td class="text-right total">' + objfirst[i]
							.total + '</td><td><button type="button" id="' +
							objfirst[i]
							.idtbl_print_material_info +
							'" class=" mr-1 btn btn-primary btn-sm float-right btnEditMaterials"><i class="fa fa-pen"></i></button><button type="button" id="' +
							objfirst[i]
							.idtbl_print_material_info +
							'" class=" mr-1 btn btn-danger btn-sm float-right btnDeleteMaterials"><i class="fa fa-trash"></i></button></td><td class="d-none">' +
							objfirst[i]
							.idtbl_print_material_info +
							'</td><td class="d-none">' + objfirst[i]
							.tbl_material_type_idtbl_material_type +
							'</td><td class="d-none">' + objfirst[i]
							.tbl_categorygauge_idtbl_categorygauge + '</td></tr>');
					});
				}
			});
		});

		$('#tblallocationdetails tbody').on('click', '.btnEditMaterials', function () {
			var detailsId = $(this).attr('id');

			var materialtext = $(this).closest("tr").find('td:eq(0)').html();
			var quantity = $(this).closest("tr").find('td:eq(1)').html();
			var unitprice = $(this).closest("tr").find('td:eq(2)').html();
			var total = $(this).closest("tr").find('td:eq(3)').html();
			var materialid = $(this).closest("tr").find('td:eq(4)').html();
			var materialid = $(this).closest("tr").find('td:eq(5)').html();
			var materialtype = $(this).closest("tr").find('td:eq(6)').html();
			var catagorygaugetype = $(this).closest("tr").find('td:eq(7)').html();

			$('#updatematerial').val(materialid)
			$('#updateqty').val(quantity)
			$('#updateunitprice').val(unitprice)
			$('#hiddenmaterialtype').val(materialtype)
			$('#hiddengaugetype').val(catagorygaugetype)



			$(this).closest('tr').remove();
			// calculateMaterialTableTotal();
		});
		$('#tblallocationdetails tbody').on('click', '.btnDeleteMaterials', function () {
			var detailsId = $(this).attr('id');

			$(this).closest('tr').remove();
		});

		$('#updatematerial').change(function () {
			var materialId = $(this).val();

			$.ajax({
				type: "POST",
				data: {
					recordID: materialId
				},
				url: 'MaterialAllocation/Getmaterialdetailsforqutation',
				success: function (result) { // alert(result)
					var obj = JSON.parse(result);
					$('#updateunitprice').val(obj.unitprice)
					$('#hiddenmaterialtype').val(obj.materialtype)
					$('#hiddengaugetype').val(obj.categorygaugetype)
				}
			});
		})

		$('#submitBtn').click(function () {
			if (!$("#updatequotationform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hideupdatequotation").click();
			} else {
				var material = $('#updatematerial').val()
				var materialtext = $("#updatematerial option:selected").text();

				var quantity = $('#updateqty').val()
				var unitprice = $('#updateunitprice').val()
				var materialtype = $('#hiddenmaterialtype').val()
				var gaugetype = $('#hiddengaugetype').val()

				var total = unitprice * quantity;

				$('#tblallocationdetails > tbody:last').append('<tr><td>' +
					materialtext +
					'</td><td class="text-center editnewqty">' +
					quantity + '</td><td class="text-right">' +
					unitprice +
					'<td class="text-right total">' + total + '</td><td><button type="button" id="' +
					material +
					'" class=" mr-1 btn btn-primary btn-sm float-right btnEditMaterials"><i class="fa fa-pen"></i></button><button type="button" id="' +
					material +
					'" class=" mr-1 btn btn-danger btn-sm float-right btnDeleteMaterials"><i class="fa fa-trash"></i></button></td><td class="d-none">' +
					material +
					'</td><td class="d-none">' + materialtype +
					'</td><td class="d-none">' + gaugetype + '</td></tr>');

				$('#updateunitprice').val('')
				$('#hiddenmaterialtype').val('')
				$('#hiddengaugetype').val('')
				$('#updatematerial').val('')
				$('#updateqty').val('')
			}

		})
		$('#btnSaveAllocation').click(function () {
			var tbody = $("#tblallocationdetails tbody");

			if (tbody.children().length > 0) {
				jsonObj = [];
				$("#tblallocationdetails tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});
				console.log(jsonObj);

				var materialrecordOption = $('#materialrecordOption').val();
				var materialrecordID = $('#materialrecordID').val();
				var quotationid = $('#hiddenquotationid').val();

				$.ajax({
					type: "POST",
					data: {
						tableData: jsonObj,
						materialrecordID: materialrecordID,
						quotationid: quotationid,
						materialrecordOption: materialrecordOption
					},
					url: '<?php echo base_url(); ?>MaterialAllocation/Insertupdateallocatedmaterials',
					success: function (result) {
						console.log(result)
						setTimeout(window.location.reload(), 3000);
						action(result)
						$('#tblallocationdetails> tbody').empty();
						// calculateMaterialTableTotal()
						$('#updateunitprice').val('')
						$('#hiddenmaterialtype').val('')
						$('#hiddengaugetype').val('')
						$('#updatematerial').val('')
						$('#updateqty').val('')
						$('#customer').val();
						$('#job').val('')
						$('#quotation').val('')
					}
				});
			}

		})
	});


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

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	function approve_confirm() {
		return confirm("Are you sure you want to Approve this?");
	}

	function active_confirm() {
		return confirm("Are you sure you want to active this?");
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}
</script>
<?php include "include/footer.php"; ?>
