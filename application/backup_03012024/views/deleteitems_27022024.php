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
        					<div class="page-header-icon"><i class="fas fa-trash-alt"></i></div>
        					<span>Delete Items</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="col-12">
                            <form id="searchDeleteItems">
                                <div class="col-4">
                                    <div class="form-row mt-2">
                                        <div class="col">
                                            <label class="small font-weight-bold">Delete Item*</label>
                                            <select class="form-control form-control-sm" name="type" id="type" required>
                                                <option value="">Select</option>
                                                <option value="1">Customer</option>
                                                <option value="2">Supplier</option>
                                                <option value="3">Good Receive Note</option>
                                                <option value="4">Purchase Order</option>
                                            </select>
                                        </div>
                                        <div class="col-auto align-self-end">
											<button type="submit" id="submitBtnDelete" name="submitBtnDelete" class="btn btn-info btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>>
												<i class="fas fa-search"></i>&nbsp;Search
											</button>
										</div>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <hr style="border: 1px solid #ddd;">
                                    </div>
                                </div>
                            </form>
                            <div class="col-12">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <div class="embed-responsive-item" id="divFrame" src=""></div>
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

$(document).ready(function(){
       
    $('#searchDeleteItems').submit(function(event){
        event.preventDefault(); 

        var selectedValue = $('#type').val(); 
        var divView = $('#divFrame'); 

        if (selectedValue === "1") { // Customer
            loadView(divView, "<?php echo base_url() ?>Deleteitems/CustomerView");
        } else if (selectedValue === "2") { // Supplier
            loadView(divView, "<?php echo base_url() ?>Deleteitems/SupplierView");
        } else if (selectedValue === "3") { // GRN
            loadView(divView, "<?php echo base_url() ?>Deleteitems/GRNView");
        } else if (selectedValue === "4") { // POR
            loadView(divView, "<?php echo base_url() ?>Deleteitems/PORView");
        } else {
            divView.empty(); 
        }
    });

    function loadView(div, url) {
        $.ajax({
            url: url,
            success: function(response) {
                div.html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error loading content:", error);
            }
        });
    }
    

});
    
</script>

<?php include "include/footer.php"; ?>