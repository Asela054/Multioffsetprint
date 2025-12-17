<?php 
$controllermenu=$this->router->fetch_class();
$functionmenu=uri_string();
$functionmenu2=$this->router->fetch_method();

$menuprivilegearray=$menuaccess;

if($functionmenu2=='Useraccount'){
    $addcheck=checkprivilege($menuprivilegearray, 1, 1);
    $editcheck=checkprivilege($menuprivilegearray, 1, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 1, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 1, 4);
}
else if($functionmenu2=='Usertype'){
    $addcheck=checkprivilege($menuprivilegearray, 2, 1);
    $editcheck=checkprivilege($menuprivilegearray, 2, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 2, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 2, 4);
}
else if($functionmenu2=='Userprivilege'){
    $addcheck=checkprivilege($menuprivilegearray, 3, 1);
    $editcheck=checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 3, 4);
}
else if($functionmenu=='Customer'){
    $addcheck=checkprivilege($menuprivilegearray, 4, 1);
    $editcheck=checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 4, 4);
}
else if($functionmenu=='Supplier'){
    $addcheck=checkprivilege($menuprivilegearray, 5, 1);
    $editcheck=checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 5, 4);
}
else if($functionmenu=='Suppliertype'){
    $addcheck=checkprivilege($menuprivilegearray, 6, 1);
    $editcheck=checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 6, 4);
}
else if($functionmenu=='Machine'){
    $addcheck=checkprivilege($menuprivilegearray, 7, 1);
    $editcheck=checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 7, 4);
}
else if($functionmenu=='Machinetype'){
    $addcheck=checkprivilege($menuprivilegearray, 8, 1);
    $editcheck=checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 8, 4);
}
else if($functionmenu=='Foiling'){
    $addcheck=checkprivilege($menuprivilegearray, 9, 1);
    $editcheck=checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 9, 4);
}
else if($functionmenu=='Lamination'){
    $addcheck=checkprivilege($menuprivilegearray, 10, 1);
    $editcheck=checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 10, 4);
}
else if($functionmenu=='Rimming'){
    $addcheck=checkprivilege($menuprivilegearray, 11, 1);
    $editcheck=checkprivilege($menuprivilegearray, 11, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 11, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 11, 4);
}
else if($functionmenu=='Varnish'){
    $addcheck=checkprivilege($menuprivilegearray, 12, 1);
    $editcheck=checkprivilege($menuprivilegearray, 12, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 12, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 12, 4);
}
else if($functionmenu=='Materialtype'){
    $addcheck=checkprivilege($menuprivilegearray, 13, 1);
    $editcheck=checkprivilege($menuprivilegearray, 13, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 13, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 13, 4);
}
else if($functionmenu=='Plates'){
    $addcheck=checkprivilege($menuprivilegearray, 14, 1);
    $editcheck=checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 14, 4);
}
else if($functionmenu=='Vehicle'){
    $addcheck=checkprivilege($menuprivilegearray, 15, 1);
    $editcheck=checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 15, 4);
}
else if($functionmenu=='Vehicletype'){
    $addcheck=checkprivilege($menuprivilegearray, 16, 1);
    $editcheck=checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 16, 4);
}
else if($functionmenu=='Vehiclebrand'){
    $addcheck=checkprivilege($menuprivilegearray, 17, 1);
    $editcheck=checkprivilege($menuprivilegearray, 17, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 17, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 17, 4);
}
else if($functionmenu=='Vehiclemodel'){
    $addcheck=checkprivilege($menuprivilegearray, 18, 1);
    $editcheck=checkprivilege($menuprivilegearray, 18, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 18, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 18, 4);
}
else if($functionmenu=='Renew'){
    $addcheck=checkprivilege($menuprivilegearray, 19, 1);
    $editcheck=checkprivilege($menuprivilegearray, 19, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 19, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 19, 4);
}
else if($functionmenu=='Renewtype'){
    $addcheck=checkprivilege($menuprivilegearray, 20, 1);
    $editcheck=checkprivilege($menuprivilegearray, 20, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 20, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 20, 4);
}
else if($functionmenu=='Service'){
    $addcheck=checkprivilege($menuprivilegearray, 21, 1);
    $editcheck=checkprivilege($menuprivilegearray, 21, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 21, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 21, 4);
}
else if($functionmenu=='Serviceitemlist'){
    $addcheck=checkprivilege($menuprivilegearray, 22, 1);
    $editcheck=checkprivilege($menuprivilegearray, 22, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 22, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 22, 4);
}
// else if($functionmenu=='Maintenace'){
//     $addcheck=checkprivilege($menuprivilegearray, 23, 1);
//     $editcheck=checkprivilege($menuprivilegearray, 23, 2);
//     $statuscheck=checkprivilege($menuprivilegearray, 23, 3);
//     $deletecheck=checkprivilege($menuprivilegearray, 23, 4);
// }
else if($functionmenu=='Board'){
    $addcheck=checkprivilege($menuprivilegearray, 24, 1);
    $editcheck=checkprivilege($menuprivilegearray, 24, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 24, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 24, 4);
}
else if($functionmenu=='Color'){
    $addcheck=checkprivilege($menuprivilegearray, 25, 1);
    $editcheck=checkprivilege($menuprivilegearray, 25, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 25, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 25, 4);
}
else if($functionmenu=='Customerinquiry'){
    $addcheck=checkprivilege($menuprivilegearray, 26, 1);
    $editcheck=checkprivilege($menuprivilegearray, 26, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 26, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 26, 4);
}
else if($functionmenu=='Customerinquiryforapprove'){
    $addcheck=checkprivilege($menuprivilegearray, 27, 1);
    $editcheck=checkprivilege($menuprivilegearray, 27, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 27, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 27, 4);
}
else if($functionmenu=='Approvedcustomerinquiry'){
    $addcheck=checkprivilege($menuprivilegearray, 28, 1);
    $editcheck=checkprivilege($menuprivilegearray, 28, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 28, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 28, 4);
}
else if($functionmenu=='Factory'){
    $addcheck=checkprivilege($menuprivilegearray, 29, 1);
    $editcheck=checkprivilege($menuprivilegearray, 29, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 29, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 29, 4);
}
else if($functionmenu=='Boardtype'){
    $addcheck=checkprivilege($menuprivilegearray, 30, 1);
    $editcheck=checkprivilege($menuprivilegearray, 30, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 30, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 30, 4);
}
else if($functionmenu=='Boardsize'){
    $addcheck=checkprivilege($menuprivilegearray, 31, 1);
    $editcheck=checkprivilege($menuprivilegearray, 31, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 31, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 31, 4);
}

else if($functionmenu=='Rptservicesummery'){
    $addcheck=checkprivilege($menuprivilegearray, 32, 1);
    $editcheck=checkprivilege($menuprivilegearray, 32, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 32, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 32, 4);
}
else if($functionmenu=='Rptserviceitem'){
    $addcheck=checkprivilege($menuprivilegearray, 33, 1);
    $editcheck=checkprivilege($menuprivilegearray, 33, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 33, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 33, 4);
}
else if($functionmenu=='Goodreceive'){
    $addcheck=checkprivilege($menuprivilegearray, 34, 1);
    $editcheck=checkprivilege($menuprivilegearray, 34, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 34, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 34, 4);
}
else if($functionmenu=='Productionorderview'){
    $addcheck=checkprivilege($menuprivilegearray, 35, 1);
    $editcheck=checkprivilege($menuprivilegearray, 35, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 35, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 35, 4);
}
else if($functionmenu=='Machinealloction'){
    $addcheck=checkprivilege($menuprivilegearray, 36, 1);
    $editcheck=checkprivilege($menuprivilegearray, 36, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 36, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 36, 4);
}
else if($functionmenu=='AllocatedMachines'){
    $addcheck=checkprivilege($menuprivilegearray, 37, 1);
    $editcheck=checkprivilege($menuprivilegearray, 37, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 37, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 37, 4);
}
else if($functionmenu=='BreakDownDashboard'){
    $addcheck=checkprivilege($menuprivilegearray, 38, 1);
    $editcheck=checkprivilege($menuprivilegearray, 38, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 38, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 38, 4);
}
else if($functionmenu=='MachineIssueCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 39, 1);
    $editcheck=checkprivilege($menuprivilegearray, 39, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 39, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 39, 4);
}
else if($functionmenu=='JobTaskList'){
    $addcheck=checkprivilege($menuprivilegearray, 40, 1);
    $editcheck=checkprivilege($menuprivilegearray, 40, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 40, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 40, 4);
}
else if($functionmenu=='ProcessPlan'){
    $addcheck=checkprivilege($menuprivilegearray, 41, 1);
    $editcheck=checkprivilege($menuprivilegearray, 41, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 41, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 41, 4);
}
else if($functionmenu=='NewDeliveryPlan'){
    $addcheck=checkprivilege($menuprivilegearray, 42, 1);
    $editcheck=checkprivilege($menuprivilegearray, 42, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 42, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 42, 4);
}
else if($functionmenu=='OrderReconsilation'){
    $addcheck=checkprivilege($menuprivilegearray, 43, 1);
    $editcheck=checkprivilege($menuprivilegearray, 43, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 43, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 43, 4);
}
else if($functionmenu=='PlanDetails'){
    $addcheck=checkprivilege($menuprivilegearray, 44, 1);
    $editcheck=checkprivilege($menuprivilegearray, 44, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 44, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 44, 4);
}
else if($functionmenu=='Serviceorder'){
    $addcheck=checkprivilege($menuprivilegearray, 47, 1);
    $editcheck=checkprivilege($menuprivilegearray, 47, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 47, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 47, 4);
}
else if($functionmenu=='Approveserviceorder'){
    $addcheck=checkprivilege($menuprivilegearray, 48, 1);
    $editcheck=checkprivilege($menuprivilegearray, 48, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 48, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 48, 4);
}
else if($functionmenu=='Vehiclerenewforapprove'){
    $addcheck=checkprivilege($menuprivilegearray, 49, 1);
    $editcheck=checkprivilege($menuprivilegearray, 49, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 49, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 49, 4);
}
else if($functionmenu=='Approvevehiclerenew'){
    $addcheck=checkprivilege($menuprivilegearray, 50, 1);
    $editcheck=checkprivilege($menuprivilegearray, 50, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 50, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 50, 4);
}

else if($functionmenu=='Assetmain'){
    $addcheck=checkprivilege($menuprivilegearray, 51, 1);
    $editcheck=checkprivilege($menuprivilegearray, 51, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 51, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 51, 4);
}
else if($functionmenu=='Assetsub'){
    $addcheck=checkprivilege($menuprivilegearray, 52, 1);
    $editcheck=checkprivilege($menuprivilegearray, 52, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 52, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 52, 4);
}
else if($functionmenu=='Asset'){
    $addcheck=checkprivilege($menuprivilegearray, 53, 1);
    $editcheck=checkprivilege($menuprivilegearray, 53, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 53, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 53, 4);
}
else if($functionmenu=='Assetdepreciation'){
    $addcheck=checkprivilege($menuprivilegearray, 54, 1);
    $editcheck=checkprivilege($menuprivilegearray, 54, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 54, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 54, 4);
}
else if($functionmenu=='Assetremove'){
    $addcheck=checkprivilege($menuprivilegearray, 55, 1);
    $editcheck=checkprivilege($menuprivilegearray, 55, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 55, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 55, 4);
}
else if($functionmenu=='Assetremoveapprove'){
    $addcheck=checkprivilege($menuprivilegearray, 56, 1);
    $editcheck=checkprivilege($menuprivilegearray, 56, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 56, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 56, 4);
}
else if($functionmenu=='Approvedassetremove'){
    $addcheck=checkprivilege($menuprivilegearray, 57, 1);
    $editcheck=checkprivilege($menuprivilegearray, 57, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 57, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 57, 4);
}
else if($functionmenu=='Materialcode'){
    $addcheck=checkprivilege($menuprivilegearray, 58, 1);
    $editcheck=checkprivilege($menuprivilegearray, 58, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 58, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 58, 4);
}
else if($functionmenu=='Materialdetail'){
    $addcheck=checkprivilege($menuprivilegearray, 59, 1);
    $editcheck=checkprivilege($menuprivilegearray, 59, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 59, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 59, 4);
}
else if($functionmenu=='Materialcategory'){
    $addcheck=checkprivilege($menuprivilegearray, 60, 1);
    $editcheck=checkprivilege($menuprivilegearray, 60, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 60, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 60, 4);
}
else if($functionmenu=='Purchaseorder'){
    $addcheck=checkprivilege($menuprivilegearray, 61, 1);
    $editcheck=checkprivilege($menuprivilegearray, 61, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 61, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 61, 4);
}
else if($functionmenu=='Qualitycheck'){
    $addcheck=checkprivilege($menuprivilegearray, 62, 1);
    $editcheck=checkprivilege($menuprivilegearray, 62, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 62, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 62, 4);
}
else if($functionmenu=='Location'){
    $addcheck=checkprivilege($menuprivilegearray, 63, 1);
    $editcheck=checkprivilege($menuprivilegearray, 63, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 63, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 63, 4);
}
else if($functionmenu=='Employee'){
    $addcheck=checkprivilege($menuprivilegearray, 64, 1);
    $editcheck=checkprivilege($menuprivilegearray, 64, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 64, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 64, 4);
}
else if($functionmenu=='InternalUse'){
    $addcheck=checkprivilege($menuprivilegearray, 65, 1);
    $editcheck=checkprivilege($menuprivilegearray, 65, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 65, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 65, 4);
}
else if($functionmenu=='MachineAllocationReport'){
    $addcheck=checkprivilege($menuprivilegearray, 66, 1);
    $editcheck=checkprivilege($menuprivilegearray, 66, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 66, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 66, 4);
}
else if($functionmenu=='JobSummaryReport'){
    $addcheck=checkprivilege($menuprivilegearray, 85, 1);
    $editcheck=checkprivilege($menuprivilegearray, 85, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 85, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 85, 4);
}
else if($functionmenu=='MachineAvailableSlots'){
    $addcheck=checkprivilege($menuprivilegearray, 56, 1);
    $editcheck=checkprivilege($menuprivilegearray, 56, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 56, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 56, 4);
}
else if($functionmenu=='StockReport'){
    $addcheck=checkprivilege($menuprivilegearray, 86, 1);
    $editcheck=checkprivilege($menuprivilegearray, 86, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 86, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 86, 4);
}

function checkprivilege($arraymenu, $menuID, $type){
    foreach($arraymenu as $array){
        if($array->menuid==$menuID){
            if($type==1){
                return $array->add;
            }
            else if($type==2){
                return $array->edit;
            }
            else if($type==3){
                return $array->statuschange;
            }
            else if($type==4){
                return $array->remove;
            }
        }
    }
}
?>
<textarea class="d-none"
	id="actiontext"><?php if($this->session->flashdata('msg')) {echo $this->session->flashdata('msg');} ?></textarea>

<nav class="sidenav shadow-right sidenav-light">
	<div class="sidenav-menu">
		<div class="nav accordion" id="accordionSidenav">
			<div class="sidenav-menu-heading">Core</div>
			<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Welcome/Dashboard'; ?>">
				<div class="nav-link-icon"><i class="fas fa-desktop"></i></div>
				Dashboard
			</a>
            
			<?php if(menucheck($menuprivilegearray, 4)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Customer'; ?>">
				<div class="nav-link-icon"><i class="fas fa-users"></i></div>
				Customer
			</a>
			<?php }if(menucheck($menuprivilegearray, 5)==1 | menucheck($menuprivilegearray, 6)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapssupplier" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-users"></i></div>
				Supplier
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Supplier" | $functionmenu=="Suppliertype"){echo 'show';} ?>"
				id="collapssupplier" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 5)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Supplier'; ?>">Supplier</a>
					<?php } if(menucheck($menuprivilegearray, 6)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Suppliertype'; ?>">Supplier
						Type</a>
					<?php } ?>
				</nav>
			</div>
            <?php } if(menucheck($menuprivilegearray, 63)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Location'; ?>">
                <div class="nav-link-icon"><i class="fas fa-pin"></i></div>
                Location
            </a>
            <?php } if(menucheck($menuprivilegearray, 64)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Employee'; ?>">
                <div class="nav-link-icon"><i class="fas fa-user"></i></div>
                Employee
            </a>
			

			<?php }?>
			<?php if(menucheck($menuprivilegearray, 47)==1 | menucheck($menuprivilegearray, 48)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsserviceinquary" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fa fa-shopping-bag"></i></div>
				Service Order Inquiry
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Serviceorder"  | $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
				id="collapsserviceinquary" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php } if(menucheck($menuprivilegearray, 47)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Serviceorder'; ?>">Inquiry
						for Approve</a>
					<?php if(menucheck($menuprivilegearray, 48)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Approveserviceorder'; ?>">Approved Inquiry
					</a>
					<?php } ?>
				</nav>
			</div>


			<?php }?>
			<?php if(menucheck($menuprivilegearray, 49)==1 | menucheck($menuprivilegearray, 50)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsvehiclerenewinquary" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fa fa-address-card"></i></div>
				Vehicle Renew Inquiry
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Vehiclerenewforapprove" | $functionmenu=="Approvevehiclerenew"){echo 'show';} ?>"
				id="collapsvehiclerenewinquary" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">

					<?php if(menucheck($menuprivilegearray, 49)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Vehiclerenewforapprove'; ?>">Inquiry for Approve</a>
					<?php } if(menucheck($menuprivilegearray, 50)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Approvevehiclerenew'; ?>">Approved Inquiry
					</a>
					<?php } ?>
				</nav>
			</div>


			<?php }if(menucheck($menuprivilegearray, 42)==1 | menucheck($menuprivilegearray, 43)==1 | menucheck($menuprivilegearray, 44)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseService" aria-expanded="false" aria-controls="collapseService">
				<div class="nav-link-icon"><i class="fas fa-car"></i></div>
				Delivery Plan
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="NewDeliveryPlan" | $functionmenu=="OrderReconsilation" | $functionmenu=="PlanDetails"){echo 'show';} ?>"
				id="collapseService" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 42)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'NewDeliveryPlan'; ?>">New</a>
					<?php } if(menucheck($menuprivilegearray, 43)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'OrderReconsilation'; ?>">Order Reconsilation</a>
					<?php } if(menucheck($menuprivilegearray, 44)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'PlanDetails'; ?>">Plan
						Details</a>
					<?php } ?>
				</nav>
			</div>
			<?php }if(menucheck($menuprivilegearray, 34)==1 | menucheck($menuprivilegearray, 35)==1 | menucheck($menuprivilegearray, 61)==1 | menucheck($menuprivilegearray, 62)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseGrn" aria-expanded="false" aria-controls="collapseGrn">
				<div class="nav-link-icon"><i class="fas fa-users"></i></div>
				GRN
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Goodreceive" | $functionmenu=="Productionorderview" | $functionmenu=="Purchaseorder" | $functionmenu=="Qualitycheck"){echo 'show';} ?>"
				id="collapseGrn" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 61)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Purchaseorder'; ?>">Purchase Order</a>
					<?php } if(menucheck($menuprivilegearray, 62)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Qualitycheck'; ?>">Quality
						Check</a>
					<?php }if(menucheck($menuprivilegearray, 34)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Goodreceive'; ?>">Grn</a>
					<?php } if(menucheck($menuprivilegearray, 35)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Productionorderview'; ?>">Order view</a>
					<?php } ?>
				</nav>
			</div>
			<?php }if(menucheck($menuprivilegearray, 26)==1 | menucheck($menuprivilegearray, 27)==1 | menucheck($menuprivilegearray, 28)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsinquary" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i data-feather="shopping-cart"></i></div>
				Customer Inquiry
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Customerinquiry" | $functionmenu=="Customerinquiryforapprove" | $functionmenu=="Approvedcustomerinquiry" ){echo 'show';} ?>"
				id="collapsinquary" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 26)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Customerinquiry'; ?>">New
						Customer Inquiry</a>
					<?php } if(menucheck($menuprivilegearray, 27)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Customerinquiryforapprove'; ?>">Inquiry for Approve</a>
					<?php } if(menucheck($menuprivilegearray, 28)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Approvedcustomerinquiry'; ?>">Approved Inquiry</a>
					<?php } ?>
				</nav>
			</div>
			<?php }if(menucheck($menuprivilegearray, 40)==1 | menucheck($menuprivilegearray, 41)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#jobtasks" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i data-feather="shopping-cart"></i></div>
				Job Planning
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="JobTaskList"){echo 'show';} ?>" id="jobtasks"
				data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 40)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'JobTaskList'; ?>">Job Task
						List</a>
					<?php } if(menucheck($menuprivilegearray, 41)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Processplan'; ?>">Process
						Plan</a>
					<?php } ?>
				</nav>
			</div>
			<?php } if(menucheck($menuprivilegearray, 9)==1 | menucheck($menuprivilegearray, 10)==1 | menucheck($menuprivilegearray, 11)==1 | menucheck($menuprivilegearray, 12)==1 | menucheck($menuprivilegearray, 13)==1 | menucheck($menuprivilegearray, 14)==1
			| menucheck($menuprivilegearray, 25)==1 | menucheck($menuprivilegearray, 58)==1 | menucheck($menuprivilegearray, 59)==1 | menucheck($menuprivilegearray, 60)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseItem" aria-expanded="false" aria-controls="collapseItem">
				<div class="nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
				Material Information
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates"
			| $functionmenu=="Color" | $functionmenu=="Materialcode" | $functionmenu=="Materialdetail" | $functionmenu=="Materialcategory"){echo 'show';} ?>"
				id="collapseItem" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 9)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Foiling'; ?>">Foiling</a>
					<?php } if(menucheck($menuprivilegearray, 10)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Lamination'; ?>">Lamination</a>
					<?php } if(menucheck($menuprivilegearray, 11)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rimming'; ?>">Rimming</a>
					<?php } if(menucheck($menuprivilegearray, 12)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Varnish'; ?>">Varnish</a>
					<?php } if(menucheck($menuprivilegearray, 13)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialtype'; ?>">Material
						Type</a>
					<!-- <?php } if(menucheck($menuprivilegearray, 58)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialcode'; ?>">Material Code</a>  -->
					<?php } if(menucheck($menuprivilegearray, 59)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Materialdetail'; ?>">Material Details</a>
					<!-- <?php } if(menucheck($menuprivilegearray, 60)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialcategory'; ?>">Material Category</a>  -->
					<?php } if(menucheck($menuprivilegearray, 14)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Plates'; ?>">Plates</a>
					<?php } if(menucheck($menuprivilegearray, 25)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Color'; ?>">Color</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>
			<?php if(menucheck($menuprivilegearray, 24)==1 | menucheck($menuprivilegearray, 30)==1 | menucheck($menuprivilegearray, 31 )==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsboard" aria-expanded="false" aria-controls="collapsboard">
				<div class="nav-link-icon"><i class="fas fa-clipboard"></i></div>
				Board
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize"){echo 'show';} ?>"
				id="collapsboard" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 24)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Board'; ?>">Board</a>
					<?php }if(menucheck($menuprivilegearray, 30)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Boardtype'; ?>">Board
						Type</a>
					<?php } if(menucheck($menuprivilegearray, 31)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Boardsize'; ?>">Board
						Size</a>
					<?php } ?>
				</nav>
			</div>

			<?php } ?>
			<?php if(menucheck($menuprivilegearray, 7)==1 | menucheck($menuprivilegearray, 36)==1 | menucheck($menuprivilegearray, 37)==1 | menucheck($menuprivilegearray, 38)==1  | menucheck($menuprivilegearray, 39)==1 | menucheck($menuprivilegearray, 56)==1 | menucheck($menuprivilegearray, 8 | menucheck($menuprivilegearray, 29 )==1)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsmachine" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-tools"></i></div>
				Machine
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Machine" | $functionmenu=="Machinetype"  | $functionmenu=="Factory" | $functionmenu=="Machinealloction" | $functionmenu=="AllocatedMachines" | $functionmenu=="BreakDownDashboard" | $functionmenu=="MachineIssueCategory" | $functionmenu=="MachineAvailableSlots"){echo 'show';} ?>"
				id="collapsmachine" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 29)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Factory'; ?>">Factory</a>
					<?php }if(menucheck($menuprivilegearray, 7)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Machine'; ?>">Machine</a>
					<?php } if(menucheck($menuprivilegearray, 8)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Machinetype'; ?>">Machine
						Type</a>
					<?php } if(menucheck($menuprivilegearray, 39)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'MachineIssueCategory'; ?>">Machine Issues</a>
					<?php } if(menucheck($menuprivilegearray, 36)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Machinealloction'; ?>">Machine Allocation</a>
					<?php } if(menucheck($menuprivilegearray, 37)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'AllocatedMachines'; ?>">Allocated Machines</a>
					<?php } if(menucheck($menuprivilegearray, 38)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'BreakDownDashboard'; ?>">Breakdown Dashboard</a>
					<?php } if(menucheck($menuprivilegearray, 56)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'MachineAvailableSlots'; ?>">Machile Available Slots</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>
			<?php if(menucheck($menuprivilegearray, 15)==1 | menucheck($menuprivilegearray, 16)==1 | menucheck($menuprivilegearray, 17)==1 | menucheck($menuprivilegearray, 18)==1 | menucheck($menuprivilegearray, 65)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseVehicle" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-folder"></i></div>
				Vehicle
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Vehicle" | $functionmenu=="Vehicletype" | $functionmenu=="Vehiclebrand"| $functionmenu=="Vehiclemodel" | $functionmenu=="InternalUse"){echo 'show';} ?>"
				id="collapseVehicle" data-parent="#accordionSidenav">

				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 15)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehicle'; ?>">Vehicle</a>
					<?php } if(menucheck($menuprivilegearray, 16)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehicletype'; ?>">Vehicle
						Type</a>
					<?php } if(menucheck($menuprivilegearray, 17)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehiclebrand'; ?>">Vehicle
						Brand</a>
					<?php } if(menucheck($menuprivilegearray, 18)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehiclemodel'; ?>">Vehicle
						Model</a>
                    <?php } if(menucheck($menuprivilegearray, 65)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'InternalUse'; ?>">Internal Use</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>
			<?php if(menucheck($menuprivilegearray, 20)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Renewtype'; ?>">
				<div class="nav-link-icon"><i class="fas fa-users"></i></div>
				Renew Type
			</a>
			<?php } ?>
			<?php if(menucheck($menuprivilegearray, 21)==1 | menucheck($menuprivilegearray, 22)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseService" aria-expanded="false" aria-controls="collapseService">
				<div class="nav-link-icon"><i class="fas fa-car"></i></div>
				Service
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Service" | $functionmenu=="Serviceitemlist"){echo 'show';} ?>"
				id="collapseService" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 21)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Service'; ?>">Service
						Details</a>
					<?php } if(menucheck($menuprivilegearray, 22)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Serviceitemlist'; ?>">Service Item List</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>
			<?php if(menucheck($menuprivilegearray, 51)==1 | menucheck($menuprivilegearray, 52)==1 | menucheck($menuprivilegearray, 53)==1 | menucheck($menuprivilegearray, 54)==1 | menucheck($menuprivilegearray, 55)==1 | menucheck($menuprivilegearray, 56)==1 | menucheck($menuprivilegearray, 57)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseassets" aria-expanded="false" aria-controls="collapseassets">
				<div class="nav-link-icon"><i class="fas fa-couch"></i></div>
				Assets
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Assetmain" | $functionmenu=="Assetsub" | $functionmenu=="Asset" | $functionmenu=="Assetdepreciation" | $functionmenu=="Assetremove" | $functionmenu=="Assetremoveapprove" | $functionmenu=="Approvedassetremove"){echo 'show';} ?>"
				id="collapseassets" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 51)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Assetmain'; ?>">Asset Main
						Category</a>
					<?php } if(menucheck($menuprivilegearray, 52)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Assetsub'; ?>">Asset Sub
						Category</a>
					<?php } if(menucheck($menuprivilegearray, 53)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Asset'; ?>">Assets</a>
					<?php } if(menucheck($menuprivilegearray, 54)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Assetdepreciation'; ?>">Asset Depreciation</a>
					<?php } if(menucheck($menuprivilegearray, 55)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Assetremove'; ?>">Asset
						Disposal</a>
					<?php } if(menucheck($menuprivilegearray, 56)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Assetremoveapprove'; ?>">Asset Disposal Approve</a>
					<?php } if(menucheck($menuprivilegearray, 57)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Approvedassetremove'; ?>">Approved Asset Disposal</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<?php  if(menucheck($menuprivilegearray, 32)==1 | menucheck($menuprivilegearray, 33)==1 | menucheck($menuprivilegearray, 66)==1  | menucheck($menuprivilegearray, 85)==1  | menucheck($menuprivilegearray, 86)==1 ) ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsereport" aria-expanded="false" aria-controls="collapsereport">
				<div class="nav-link-icon"><i data-feather="file"></i></div>
				Reports
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Rptservicesummery" | $functionmenu=="Rptsalereport" |  $functionmenu=="Rptroute" |  $functionmenu=="Rptitemreport" |  $functionmenu=="Rptrefitemreport" | $functionmenu=="Rptrefsalesreport" | $functionmenu=="MachineAllocationReport" | $functionmenu=="JobSummaryReport" | $functionmenu=="StockReport"){echo 'show';} ?>"
				id="collapsereport" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 32)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptservicesummery'; ?>">Service Summary Report</a>
					<?php } if(menucheck($menuprivilegearray, 33)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptserviceitem'; ?>">Service Item Report</a>
                    <?php } if(menucheck($menuprivilegearray, 66)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineAllocationReport'; ?>">Machine Allocation Report</a>
                    <?php } if(menucheck($menuprivilegearray, 85)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'JobSummaryReport'; ?>">Job Summary Report</a>
                    <?php } if(menucheck($menuprivilegearray, 86)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'StockReport'; ?>">Stock Report</a>
					<?php } ?>
				</nav>
			</div>

			<?php if(menucheck($menuprivilegearray, 1)==1 | menucheck($menuprivilegearray, 2)==1 | menucheck($menuprivilegearray, 3)==1 | menucheck($menuprivilegearray, 4)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
				<div class="nav-link-icon"><i class="fas fa-user"></i></div>
				User Account
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Useraccount" | $functionmenu=="Usertype" | $functionmenu=="Userprivilege"){echo 'show';} ?>"
				id="collapseUser" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 1)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Useraccount'; ?>">User
						Account</a>
					<?php } if(menucheck($menuprivilegearray, 2)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'User/Usertype'; ?>">Type</a>
					<?php } if(menucheck($menuprivilegearray, 3)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'User/Userprivilege'; ?>">Privilege</a>
					<?php } ?>
				</nav>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="sidenav-footer">
		<div class="sidenav-footer-content">
			<div class="sidenav-footer-subtitle">Logged in as:</div>
			<div class="sidenav-footer-title"><?php echo ucfirst($_SESSION['name']); ?></div>
		</div>
	</div>
</nav>
