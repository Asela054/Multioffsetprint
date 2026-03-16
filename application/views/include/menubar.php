<?php 
$controllermenu=$this->router->fetch_class();
$functionmenu=uri_string();
$functionmenu2=$this->router->fetch_method();

$menuprivilegearray = $menuaccess;
$permissionallowed = array();
$addcheck = 0;
$editcheck = 0;
$statuscheck = 0;
$deletecheck = 0;
$approvecheck = 0;
$checkstatus = 0;

foreach($menuprivilegearray as $row){
    if($row->module==$functionmenu2){
        if($row->permission_type==1){$addcheck=1;}
        if($row->permission_type==2){$editcheck=1;}
        if($row->permission_type==3){$statuscheck=1;}
        if($row->permission_type==4){$deletecheck=1;}
        if($row->permission_type==5){$approvecheck=1;}
        if($row->permission_type==6){$checkstatus=1;}
    }

    if($row->module==$functionmenu){
        if($row->permission_type==1){$addcheck=1;}
        if($row->permission_type==2){$editcheck=1;}
        if($row->permission_type==3){$statuscheck=1;}
        if($row->permission_type==4){$deletecheck=1;}
        if($row->permission_type==5){$approvecheck=1;}
        if($row->permission_type==6){$checkstatus=1;}
    }
    
    array_push($permissionallowed, $row->module);
}

$permissionallowed = array_unique($permissionallowed);
?>
<textarea class="d-none" id="actiontext"><?php if($this->session->flashdata('msg')) {echo $this->session->flashdata('msg');} ?></textarea>

<nav class="sidenav shadow-right sidenav-light">
	<div class="sidenav-menu">
		<div class="nav accordion" id="accordionSidenav">
			<div class="sidenav-menu-heading">Core</div>
			<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Welcome/Dashboard'; ?>">
				<div class="nav-link-icon"><i class="fas fa-desktop"></i></div>
				Dashboard
			</a>

			<!-- Master file Menu New Added -->
			<?php if(in_array("Location", $permissionallowed) || in_array("Measurements", $permissionallowed) || in_array("Servicetype", $permissionallowed) || in_array("Taxcontrol", $permissionallowed) || in_array("Charges", $permissionallowed) || in_array("Chargesdetail", $permissionallowed) || in_array("Serviceitemlist", $permissionallowed) || in_array("Expences", $permissionallowed) || in_array("Uomconversions", $permissionallowed)) { ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsMasterfile" aria-expanded="false" aria-controls="collapsMasterfile">
				<div class="nav-link-icon"><i class="fa fa-print"></i></div>
				Master Information
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Location" || $functionmenu=="Measurements" || $functionmenu=="Servicetype" || $functionmenu=="Taxcontrol" || $functionmenu=="Serviceitemlist" || $functionmenu=="Charges" || $functionmenu=="Chargesdetail" || $functionmenu=="Expences" || $functionmenu=="Uomconversions"){echo 'show';} ?>"
				id="collapsMasterfile" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Location", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Location'; ?>">Location</a>
					<?php } if(in_array("Measurements", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Measurements'; ?>">Measurements</a>
					<?php } if(in_array("Servicetype", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Servicetype'; ?>">Service
						Type</a>
					<?php } if(in_array("Taxcontrol", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Taxcontrol'; ?>">Tax
						Control</a>
					<?php } if(in_array("Charges", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Charges'; ?>">Charges
						Type</a>
					<?php } if(in_array("Chargesdetail", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Chargesdetail'; ?>">Charges
						Details</a>
					<?php } if(in_array("Serviceitemlist", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Serviceitemlist'; ?>">Service Item List</a>
					<?php } if(in_array("Expences", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Expences'; ?>">Costing
						Types</a>
					<?php } if(in_array("Uomconversions", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Uomconversions'; ?>">UOM
						Conversions</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Material Menu New Added -->
			<?php if(in_array("Materialdetail", $permissionallowed) || in_array("Materialtype", $permissionallowed) || in_array("CategoryGauge", $permissionallowed) || in_array("Color", $permissionallowed) || in_array("Foiling", $permissionallowed) || in_array("Lamination", $permissionallowed) || in_array("Rimming", $permissionallowed) || in_array("Varnish", $permissionallowed) || in_array("Plates", $permissionallowed) || in_array("Materialgroup", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsematerials" aria-expanded="false" aria-controls="collapsematerials">
				<div class="nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
				Material Info
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Foiling" || $functionmenu=="Lamination" || $functionmenu=="Rimming" || $functionmenu=="Varnish" || $functionmenu=="Materialtype" || $functionmenu=="Plates" || $functionmenu=="Color" || $functionmenu=="Materialdetail" || $functionmenu=="CategoryGauge" || $functionmenu=="Materialgroup"){echo 'show';} ?>"
				id="collapsematerials" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion">
					<?php if(in_array("Materialgroup", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Materialgroup'; ?>">Material Group</a>
					<?php } if(in_array("Materialdetail", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Materialdetail'; ?>">Material Details</a>
					<?php } if(in_array("Materialtype", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialtype'; ?>">Material
						Type</a>
					<?php } if(in_array("CategoryGauge", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'CategoryGauge'; ?>">Category Gauge</a>
					<?php } if(in_array("Color", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Color'; ?>">Material
						Color</a>
					<?php } if(in_array("Foiling", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Foiling'; ?>">Foiling</a>
					<?php } if(in_array("Lamination", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Lamination'; ?>">Lamination</a>
					<?php } if(in_array("Rimming", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rimming'; ?>">Rimming</a>
					<?php } if(in_array("Varnish", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Varnish'; ?>">Varnish</a>
					<?php } if(in_array("Plates", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Plates'; ?>">Plates</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Job Management Menu New Added -->
			<?php if(in_array("Customer", $permissionallowed) || in_array("Customerinquiry", $permissionallowed) || in_array("Customerinquiryforapprove", $permissionallowed) || in_array("Approvedcustomerinquiry", $permissionallowed) || in_array("NewDeliveryPlan", $permissionallowed) || in_array("OrderReconsilation", $permissionallowed) || in_array("PlanDetails", $permissionallowed) || in_array("Quatation", $permissionallowed) || in_array("Newcustomerjobs", $permissionallowed) || in_array("Jobcardissuematerial", $permissionallowed) || in_array("MaterialAllocation", $permissionallowed) || in_array("MaterialAllocationManual", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#jobmanagement" aria-expanded="false" aria-controls="jobmanagement">
				<div class="nav-link-icon"><i class="fa fa-archive"></i></div>
				Job Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Customer" || $functionmenu=="Customerinquiry" || $functionmenu=="Customerinquiryforapprove" || $functionmenu=="Approvedcustomerinquiry" || $functionmenu=="Quatation" || $functionmenu=="NewDeliveryPlan" || $functionmenu=="OrderReconsilation" || $functionmenu=="PlanDetails" || $functionmenu=="MaterialAllocation" || $functionmenu=="Newcustomerjobs" || $functionmenu=="Jobcardissuematerial" || $functionmenu=="MaterialAllocationManual"){echo 'show';} ?>"
				id="jobmanagement" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion">
					<?php if(in_array("Customer", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Customer'; ?>">Customer</a>
					<?php } if(in_array("Newcustomerjobs", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Newcustomerjobs'; ?>">Customer Jobs</a>
					<?php } if(in_array("Customerinquiry", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Customerinquiry'; ?>">Customer Inquiry</a>
					<?php } if(in_array("MaterialAllocation", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'MaterialAllocation'; ?>">Allocate Material</a>
					<?php } if(in_array("Jobcardissuematerial", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Jobcardissuematerial'; ?>">Issue Material</a>
					<?php } if(in_array("MaterialAllocationManual", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'MaterialAllocationManual'; ?>">Manual Issue Material</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Supplier Menu New Added -->
			<?php if(in_array("Supplier", $permissionallowed) || in_array("Suppliertype", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsesupplier" aria-expanded="false" aria-controls="collapsesupplier">
				<div class="nav-link-icon"><i class="fas fa-users"></i></div>
				Supplier
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Supplier" || $functionmenu=="Suppliertype"){echo 'show';} ?>"
				id="collapsesupplier" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion">
					<?php if(in_array("Suppliertype", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Suppliertype'; ?>">Supplier
						Type</a>
					<?php } if(in_array("Supplier", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Supplier'; ?>">New
						Supplier</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Purchase Order Menu New Added -->
			<?php if(in_array("Newpurchaserequest", $permissionallowed) || in_array("Purchaseorder", $permissionallowed) || in_array("ServicePurchaseOrder", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseporder" aria-expanded="false" aria-controls="collapseporder">
				<div class="nav-link-icon"><i class="fas fa-truck"></i></div>
				Purchase Order
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Newpurchaserequest" || $functionmenu=="Purchaseorder" || $functionmenu=="ServicePurchaseOrder"){echo 'show';} ?>"
				id="collapseporder" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion">
					<?php if(in_array("Newpurchaserequest", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Newpurchaserequest'; ?>">New Purchase Request</a>
					<?php } if(in_array("Purchaseorder", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Purchaseorder'; ?>">Purchase Order</a>
					<?php } if(in_array("ServicePurchaseOrder", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'ServicePurchaseOrder'; ?>">Service Purchase Order</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- GRN Menu New Added -->
			<?php if(in_array("Goodreceive", $permissionallowed) || in_array("GRNVoucher", $permissionallowed) || in_array("Goodreceivereturn", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsestores" aria-expanded="false" aria-controls="collapsestores">
				<div class="nav-link-icon"><i class="fa fa-cart-arrow-down"></i></div>
				GRN Section
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Goodreceive" || $functionmenu=="GRNVoucher" || $functionmenu=="Goodreceivereturn"){echo 'show';} ?>"
				id="collapsestores" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Goodreceive", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Goodreceive'; ?>">Good
						Receive Note</a>
					<?php } if(in_array("GRNVoucher", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'GRNVoucher'; ?>">Good
						Receive Note Voucher</a>
					<?php } if(in_array("Goodreceivereturn", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Goodreceivereturn'; ?>">Good Receive Note Return</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Stock Menu New Added -->
			<?php if(in_array("Report", $permissionallowed) || in_array("Allstockview", $permissionallowed) || in_array("IssueMaterials", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsStock" aria-expanded="false" aria-controls="collapsStock">
				<div class="nav-link-icon"><i class="fa fa-warehouse"></i></div>Stock Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Report" || $functionmenu=="Allstockview" || $functionmenu=="IssueMaterials"){echo 'show';} ?>"
				id="collapsStock" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Report", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Report'; ?>">Material Stock
						Category Wise Report</a>
					<?php } if(in_array("Allstockview", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Allstockview'; ?>">All
						Stock View</a>
					<?php } if(in_array("IssueMaterials", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'IssueMaterials'; ?>">Issue
						Materials</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Stock Transfer Menu New Added -->
			<?php if(in_array("Stocktransfer", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Stocktransfer'; ?>">
				<div class="nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
				Stock Transfer
			</a>
			<?php } ?>

			<!-- Internal Item (Issue)Request Menu New Added -->
			<?php if(in_array("Goodreceiverequest", $permissionallowed) || in_array("Approvedgoodreceiverequest", $permissionallowed) || in_array("Issuegoodreceive", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsGrnrequest" aria-expanded="false" aria-controls="collapsGrnrequest">
				<div class="nav-link-icon"><i class="fa fa-folder-open"></i></div> Internal Item Request
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Goodreceiverequest" || $functionmenu=="Approvedgoodreceiverequest" || $functionmenu=="Issuegoodreceive"){echo 'show';} ?>"
				id="collapsGrnrequest" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Goodreceiverequest", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Goodreceiverequest'; ?>">Item Request</a>
					<?php } if(in_array("Issuegoodreceive", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Issuegoodreceive'; ?>">Issue Item Request </a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Invoice Menu New Added -->
			<?php if(in_array("Dispatchnote", $permissionallowed) || in_array("Invoice", $permissionallowed) || in_array("Deletedinvoice", $permissionallowed) || in_array("Canceledinvoice", $permissionallowed) || in_array("Creditnote", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsInvoice" aria-expanded="false" aria-controls="collapsInvoice">
				<div class="nav-link-icon"><i class="fa fa-file-invoice"></i></div>&nbsp;Invoice
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Dispatchnote" || $functionmenu=="Invoice" || $functionmenu=="Deletedinvoice" || $functionmenu=="Canceledinvoice" || $functionmenu=="Creditnote"){echo 'show';} ?>"
				id="collapsInvoice" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Dispatchnote", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Dispatchnote'; ?>">Dispatch
						Note</a>
					<?php } if(in_array("Invoice", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Invoice'; ?>">Invoice </a>
					<?php } if(in_array("Creditnote", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Creditnote'; ?>">Credit
						Note</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Invoice Menu Fair Trading Added -->
			<?php if(in_array("DirectDispatchnote", $permissionallowed) || in_array("DirectInvoice", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsDirectInvoice" aria-expanded="false" aria-controls="collapsDirectInvoice">
				<div class="nav-link-icon"><i class="fa fa-file-invoice"></i></div>&nbsp;Direct Sale
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="DirectDispatchnote" || $functionmenu=="DirectInvoice"){echo 'show';} ?>"
				id="collapsDirectInvoice" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("DirectDispatchnote", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'DirectDispatchnote'; ?>">Direct Dispatch Note</a>
					<?php } if(in_array("DirectInvoice", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'DirectInvoice'; ?>">Direct
						Invoice </a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Vehicle Management Menu New Added -->
			<?php if(in_array("Vehicle", $permissionallowed) || in_array("Vehicletype", $permissionallowed) || in_array("Vehiclebrand", $permissionallowed) || in_array("Vehiclemodel", $permissionallowed) || in_array("Renewtype", $permissionallowed) || in_array("Service", $permissionallowed) || in_array("Serviceorder", $permissionallowed) || in_array("Approveserviceorder", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseVehicle" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-car"></i></div>
				Vehicle Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Vehicle" || $functionmenu=="Vehicletype" || $functionmenu=="Vehiclebrand" || $functionmenu=="Vehiclemodel" || $functionmenu=="Renewtype" || $functionmenu=="Service" || $functionmenu=="Serviceorder" || $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
				id="collapseVehicle" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Vehicletype", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehicletype'; ?>">Vehicle
						Type</a>
					<?php } if(in_array("Vehiclebrand", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehiclebrand'; ?>">Vehicle
						Brand</a>
					<?php } if(in_array("Vehiclemodel", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehiclemodel'; ?>">Vehicle
						Model</a>
					<?php } if(in_array("Vehicle", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehicle'; ?>">Vehicle</a>
					<?php } if(in_array("Renewtype", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Renewtype'; ?>">Renew
						Type</a>
					<?php } ?>

					<!-- Service Info Section -->
					<?php if(in_array("Service", $permissionallowed) || in_array("Serviceorder", $permissionallowed) || in_array("Approveserviceorder", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#serviceinfo" aria-expanded="false"
						aria-controls="serviceinfo">
						Service Info
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Service" || $functionmenu=="Serviceorder" || $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
						id="serviceinfo">
						<nav class="sidenav-menu-nested nav accordion">
							<?php if(in_array("Service", $permissionallowed)){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Service'; ?>">Service Details</a>
							<?php } if(in_array("Serviceorder", $permissionallowed) || in_array("Approveserviceorder", $permissionallowed)){ ?>
							<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
								data-toggle="collapse" data-target="#serviceinquary" aria-expanded="false"
								aria-controls="serviceinquary">
								Service Order Inquiry
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?php if($functionmenu=="Serviceorder" || $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
								id="serviceinquary">
								<nav class="sidenav-menu-nested nav accordion">
									<?php if(in_array("Serviceorder", $permissionallowed)){ ?>
									<a class="nav-link p-0 px-3 py-1 text-dark"
										href="<?php echo base_url().'Serviceorder'; ?>">Inquiry for Approve</a>
									<?php } if(in_array("Approveserviceorder", $permissionallowed)){ ?>
									<a class="nav-link p-0 px-3 py-1 text-dark"
										href="<?php echo base_url().'Approveserviceorder'; ?>">Approved Inquiry</a>
									<?php } ?>
								</nav>
							</div>
							<?php } ?>
						</nav>
					</div>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Report Menu New Added -->
			<?php if(in_array("Rptoutstanding", $permissionallowed) || in_array("Rptservicesummery", $permissionallowed) || in_array("Rptserviceitem", $permissionallowed) || in_array("MachineAllocationReport", $permissionallowed) || in_array("JobSummaryReport", $permissionallowed) || in_array("VatReport", $permissionallowed) || in_array("SalesReport", $permissionallowed) || in_array("AdvancedGrnSearch", $permissionallowed) || in_array("DAReport", $permissionallowed) || in_array("UninvoiceDAReport", $permissionallowed) || in_array("UncompletedjobReport", $permissionallowed) || in_array("Rptgrn", $permissionallowed) || in_array("Unmoveditems", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsereport" aria-expanded="false" aria-controls="collapsereport">
				<div class="nav-link-icon"><i data-feather="file"></i></div>
				Reports
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Rptoutstanding" || $functionmenu=="Rptservicesummery" || $functionmenu=="Rptserviceitem" || $functionmenu=="MachineAllocationReport" || $functionmenu=="JobSummaryReport" || $functionmenu=="VatReport" || $functionmenu=="SalesReport" || $functionmenu=="AdvancedGrnSearch" || $functionmenu=="DAReport" || $functionmenu=="UninvoiceDAReport" || $functionmenu=="UncompletedjobReport" || $functionmenu=="Rptgrn" || $functionmenu=="Unmoveditems"){echo 'show';} ?>"
				id="collapsereport" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Rptoutstanding", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptoutstanding'; ?>">Outstanding Report</a>
					<?php } if(in_array("Unmoveditems", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Unmoveditems'; ?>">Unmoved
						Items Report</a>
					<?php } if(in_array("Rptservicesummery", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptservicesummery'; ?>">Service Summary Report</a>
					<?php } if(in_array("Rptserviceitem", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptserviceitem'; ?>">Service Item Report</a>
					<?php } if(in_array("MachineAllocationReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'MachineAllocationReport'; ?>">Machine Allocation Report</a>
					<?php } if(in_array("JobSummaryReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'JobSummaryReport'; ?>">Job
						Summary Report</a>
					<?php } if(in_array("VatReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'VatReport'; ?>">Vat
						Report</a>
					<?php } if(in_array("AdvancedGrnSearch", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'AdvancedGrnSearch'; ?>">Stock Report</a>
					<?php } if(in_array("SalesReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'SalesReport'; ?>">Sales
						Report</a>
					<?php } if(in_array("DAReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'DAReport'; ?>">Dispatch
						Report</a>
					<?php } if(in_array("UninvoiceDAReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'UninvoiceDAReport'; ?>">Uninvoice Dispatch Report</a>
					<?php } if(in_array("UncompletedjobReport", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'UncompletedjobReport'; ?>">Uncompleted Jobs Report</a>
					<?php } if(in_array("Rptgrn", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptgrn'; ?>">GRN Report</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- User Account Menu New Added -->
			<?php if(in_array("Useraccount", $permissionallowed) || in_array("Usertype", $permissionallowed) || in_array("Userprivilege", $permissionallowed) || in_array("Userpermissions", $permissionallowed) || in_array("Userroles", $permissionallowed)){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
				<div class="nav-link-icon"><i class="fas fa-user"></i></div>
				User Account
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu2=="Useraccount" || $functionmenu2=="Usertype" || $functionmenu2=="Userprivilege" || $functionmenu2=="Userpermissions" || $functionmenu2=="Userroles"){echo 'show';} ?>"
				id="collapseUser" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(in_array("Useraccount", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Useraccount'; ?>">User
						Account</a>
					<?php } if(in_array("Usertype", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'User/Usertype'; ?>">Type</a>
					<?php } if(in_array("Userprivilege", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'User/Userprivilege'; ?>">Privilege</a>
					<?php } if(in_array("Userpermissions", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'User/Userpermissions'; ?>">User Permissions</a>
					<?php } if(in_array("Userroles", $permissionallowed)){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Userroles'; ?>">User
						Roles</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>
		</div>
	</div>

	<div class="sidenav-footer">
		<div class="sidenav-footer-content">
			<div class="sidenav-footer-subtitle">Logged in as:</div>
			<div class="sidenav-footer-title"><?php echo $_SESSION['typename']; ?></div>
		</div>
	</div>
</nav>