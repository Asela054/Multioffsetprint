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
else if($functionmenu=='StockReport'){
    $addcheck=checkprivilege($menuprivilegearray, 86, 1);
    $editcheck=checkprivilege($menuprivilegearray, 86, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 86, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 86, 4);
}
else if($functionmenu=='MachineAvailableSlots'){
    $addcheck=checkprivilege($menuprivilegearray, 56, 1);
    $editcheck=checkprivilege($menuprivilegearray, 56, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 56, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 56, 4);
}
else if($functionmenu=='Newpurchaserequest'){
    $addcheck=checkprivilege($menuprivilegearray, 87, 1);
    $editcheck=checkprivilege($menuprivilegearray, 87, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 87, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 87, 4);
}
else if($functionmenu=='Goodreceiverequest'){
    $addcheck=checkprivilege($menuprivilegearray, 88, 1);
    $editcheck=checkprivilege($menuprivilegearray, 88, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 88, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 88, 4);
}
else if($functionmenu=='Approvedgoodreceiverequest'){
    $addcheck=checkprivilege($menuprivilegearray, 89, 1);
    $editcheck=checkprivilege($menuprivilegearray, 89, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 89, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 89, 4);
}
else if($functionmenu=='Issuegoodreceive'){
    $addcheck=checkprivilege($menuprivilegearray, 90, 1);
    $editcheck=checkprivilege($menuprivilegearray, 90, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 90, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 90, 4);
}
else if($functionmenu=='Stocktransfer'){
    $addcheck=checkprivilege($menuprivilegearray, 91, 1);
    $editcheck=checkprivilege($menuprivilegearray, 91, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 91, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 91, 4);
}
else if($functionmenu=='Report'){
    $addcheck=checkprivilege($menuprivilegearray, 92, 1);
    $editcheck=checkprivilege($menuprivilegearray, 92, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 92, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 92, 4);
}
else if($functionmenu=='Measurements'){
    $addcheck=checkprivilege($menuprivilegearray, 93, 1);
    $editcheck=checkprivilege($menuprivilegearray, 93, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 93, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 93, 4);
}
else if($functionmenu=='Servicetype'){
    $addcheck=checkprivilege($menuprivilegearray, 94, 1);
    $editcheck=checkprivilege($menuprivilegearray, 94, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 94, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 94, 4);
}
else if($functionmenu=='ApprovedPurchaseOrder'){
    $addcheck=checkprivilege($menuprivilegearray, 95, 1);
    $editcheck=checkprivilege($menuprivilegearray, 95, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 95, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 95, 4);
}
else if($functionmenu=='ApprovedGrn'){
    $addcheck=checkprivilege($menuprivilegearray, 96, 1);
    $editcheck=checkprivilege($menuprivilegearray, 96, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 96, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 96, 4);
}
else if($functionmenu=='AdvancedStockSearch'){
    $addcheck=checkprivilege($menuprivilegearray, 97, 1);
    $editcheck=checkprivilege($menuprivilegearray, 97, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 97, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 97, 4);
}
else if($functionmenu=='AdvancedStockTransfer'){
    $addcheck=checkprivilege($menuprivilegearray, 98, 1);
    $editcheck=checkprivilege($menuprivilegearray, 98, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 98, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 98, 4);
}
else if($functionmenu=='ApproveServicePorder'){
    $addcheck=checkprivilege($menuprivilegearray, 99, 1);
    $editcheck=checkprivilege($menuprivilegearray, 99, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 99, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 99, 4);
}
else if($functionmenu=='Taxcontrol'){
    $addcheck=checkprivilege($menuprivilegearray, 100, 1);
    $editcheck=checkprivilege($menuprivilegearray, 100, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 100, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 100, 4);
}
else if($functionmenu=='CategoryGauge'){
    $addcheck=checkprivilege($menuprivilegearray, 101, 1);
    $editcheck=checkprivilege($menuprivilegearray, 101, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 101, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 101, 4);
}
else if($functionmenu=='Dispatchnote'){
    $addcheck=checkprivilege($menuprivilegearray, 102, 1);
    $editcheck=checkprivilege($menuprivilegearray, 102, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 102, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 102, 4);
}
else if($functionmenu=='Invoice'){
    $addcheck=checkprivilege($menuprivilegearray, 103, 1);
    $editcheck=checkprivilege($menuprivilegearray, 103, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 103, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 103, 4);
}
else if($functionmenu=='Deleteitems'){
    $addcheck=checkprivilege($menuprivilegearray, 104, 1);
    $editcheck=checkprivilege($menuprivilegearray, 104, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 104, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 104, 4);
}
else if($functionmenu=='Charges'){
    $addcheck=checkprivilege($menuprivilegearray, 105, 1);
    $editcheck=checkprivilege($menuprivilegearray, 105, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 105, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 105, 4);
}
else if($functionmenu=='Chargesdetail'){
    $addcheck=checkprivilege($menuprivilegearray, 106, 1);
    $editcheck=checkprivilege($menuprivilegearray, 106, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 106, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 106, 4);
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
			

			<?php  if(menucheck($menuprivilegearray, 15)==1 | menucheck($menuprivilegearray, 63)==1 | menucheck($menuprivilegearray, 93)==1 | menucheck($menuprivilegearray, 94)==1 | menucheck($menuprivilegearray, 100)==1 | menucheck($menuprivilegearray, 105)==1 | menucheck($menuprivilegearray, 106)==1) ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsMasterfile" aria-expanded="false" aria-controls="collapsMasterfile">
				<div class="nav-link-icon"><i class="fa fa-print"></i></div>Master Information
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Location" | $functionmenu=="Measurements" | $functionmenu=="Servicetype"| $functionmenu=="Taxcontrol" |$functionmenu=="Serviceitemlist" | $functionmenu=="Charges" |$functionmenu=="Chargesdetail"){echo 'show';} ?>"
				id="collapsMasterfile" data-parent="#accordionSidenav">

				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 63)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Location'; ?>">Location</a>
					<?php } if(menucheck($menuprivilegearray, 93)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Measurements'; ?>">Measurements</a>
					<?php } if(menucheck($menuprivilegearray, 94)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Servicetype'; ?>">Service
						Type</a>
					<?php } if(menucheck($menuprivilegearray, 100)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Taxcontrol'; ?>">Tax
						Control</a>
					<?php } if(menucheck($menuprivilegearray, 105)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Charges'; ?>">Charges Type</a>
						<?php } if(menucheck($menuprivilegearray, 106)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Chargesdetail'; ?>">Charges Details</a>
						<?php } if(menucheck($menuprivilegearray, 15)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Serviceitemlist'; ?>">Service Item List</a>


					<?php } ?>
				</nav>
			</div>

			<?php  if(menucheck($menuprivilegearray, 4)==1 | menucheck($menuprivilegearray, 26)==1 | menucheck($menuprivilegearray, 27)==1 | menucheck($menuprivilegearray, 28)==1 | menucheck($menuprivilegearray, 42)==1 | menucheck($menuprivilegearray, 43)==1 | menucheck($menuprivilegearray, 44)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#jobmanagement" aria-expanded="false" aria-controls="jobmanagement">
				<div class="nav-link-icon"><i class="fa fa-archive"></i></div>
				Job Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>


			<nav class="sidenav-menu-nested nav accordion" id="jobmanagement">

				<div class="collapse <?php if($functionmenu=="Customer"| $functionmenu=="Customerinquiry" | $functionmenu=="Customerinquiryforapprove" | $functionmenu=="Approvedcustomerinquiry"|$functionmenu=="NewDeliveryPlan" | $functionmenu=="OrderReconsilation" | $functionmenu=="PlanDetails"){echo 'show';} ?>"
					id="jobmanagement" data-parent="#accordionSidenav">
					<!-- <nav class="sidenav-menu-nested nav accordion" id="accordionSidenav"> -->
					<?php } if(menucheck($menuprivilegearray, 4)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Customer'; ?>">
						<div class="nav-link-icon"><i class="fas fa-users"></i></div>
						Customer
					</a>
					<!-- </nav> -->
				</div>
				<div class="collapse <?php if( $functionmenu=="NewDeliveryPlan" | $functionmenu=="OrderReconsilation" | $functionmenu=="PlanDetails" | $functionmenu=="Customerinquiry" | $functionmenu=="Customerinquiryforapprove" | $functionmenu=="Approvedcustomerinquiry"| $functionmenu=="Customer"){echo 'show';} ?>"
					id="jobmanagement" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#collapsecusinquiry" aria-expanded="false"
						aria-controls="collapsecusinquiry">
						<div class="nav-link-icon"><i class="fas fa-user"></i></div>
						Customer Inquiry
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Customerinquiry" | $functionmenu=="Customerinquiryforapprove" | $functionmenu=="Approvedcustomerinquiry"){echo 'show';} ?>"
						id="collapsecusinquiry" data-parent="#jobmanagement">
						<nav class="sidenav-menu-nested nav accordion" id="collapsecusinquiry">
							<?php if(menucheck($menuprivilegearray, 26)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Customerinquiry'; ?>">New
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
				</div>
				<div class="collapse <?php if(  $functionmenu=="NewDeliveryPlan" | $functionmenu=="OrderReconsilation" | $functionmenu=="PlanDetails" | $functionmenu=="Customerinquiry" | $functionmenu=="Customerinquiryforapprove" | $functionmenu=="Approvedcustomerinquiry" | $functionmenu=="Customer"){echo 'show';} ?>"
					id="jobmanagement" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#collapsedeliveryplan" aria-expanded="false"
						aria-controls="collapsedeliveryplan">
						<div class="nav-link-icon"><i class="fas fa-user"></i></div>
						Delivery Plans
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="NewDeliveryPlan" | $functionmenu=="OrderReconsilation" | $functionmenu=="PlanDetails"){echo 'show';} ?>"
						id="collapsedeliveryplan" data-parent="#jobmanagement">
						<nav class="sidenav-menu-nested nav accordion" id="collapsedeliveryplan">
							<?php if(menucheck($menuprivilegearray, 42)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'NewDeliveryPlan'; ?>">New</a>
							<?php } if(menucheck($menuprivilegearray, 43)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'OrderReconsilation'; ?>">Order
								Reconsilation</a>
							<?php } if(menucheck($menuprivilegearray, 44)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'PlanDetails'; ?>">Plan
								Details</a>
							<?php } ?>
						</nav>
					</div>
				</div>
			</nav>


			<!-- Finance Menu New Added -->


			<?php } if(menucheck($menuprivilegearray, 5)==1 | menucheck($menuprivilegearray, 6)==1 | menucheck($menuprivilegearray, 87)==1 | menucheck($menuprivilegearray, 61)==1 | menucheck($menuprivilegearray, 95)==1 | menucheck($menuprivilegearray, 96)==1 | menucheck($menuprivilegearray, 99)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#finance" aria-expanded="false" aria-controls="finance">
				<div class="nav-link-icon"><i class="fa fa-credit-card"></i></div>
				Finance
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>

			<nav class="sidenav-menu-nested nav accordion" id="finance"><?php } ?>
				<div class="collapse <?php if(  $functionmenu=="Supplier" | $functionmenu=="Suppliertype" |  $functionmenu=="Purchaseorder" | $functionmenu=="Newpurchaserequest"  | $functionmenu=="ApprovedPurchaseOrder" | $functionmenu=="ApprovedGrn" | $functionmenu=="ApproveServicePorder"){echo 'show';} ?>"
					id="finance" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#collapsesupplier" aria-expanded="false"
						aria-controls="collapsesupplier">
						<div class="nav-link-icon"><i class="fas fa-user"></i></div>
						Supplier
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Supplier" | $functionmenu=="Suppliertype"){echo 'show';} ?>"
						id="collapsesupplier" data-parent="#finance">
						<nav class="sidenav-menu-nested nav accordion" id="collapsesupplier">
							<?php if(menucheck($menuprivilegearray, 5)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Supplier'; ?>">New
								Supplier</a>
							<?php } if(menucheck($menuprivilegearray, 6)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Suppliertype'; ?>">Supplier
								Type</a>
							<?php } ?>
						</nav>
					</div>
				</div>

				<div class="collapse <?php if($functionmenu=="Newpurchaserequest" |$functionmenu=="Purchaseorder" | $functionmenu=="Supplier" | $functionmenu=="Suppliertype" | $functionmenu=="ApprovedPurchaseOrder" | $functionmenu=="ApprovedGrn" | $functionmenu=="ApproveServicePorder"){echo 'show';} ?>"
					id="finance" data-parent="#accordionSidenav">
					<?php if(menucheck($menuprivilegearray, 87)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Newpurchaserequest'; ?>">
						<div class="nav-link-icon"><i class="fa fa-shopping-cart"></i></div>New Purchase Request
					</a>
				</div>

				<div class="collapse <?php if($functionmenu=="Purchaseorder" | $functionmenu=="Supplier" | $functionmenu=="Suppliertype" | $functionmenu=="Newpurchaserequest" | $functionmenu=="ApprovedPurchaseOrder" | $functionmenu=="ApprovedGrn" | $functionmenu=="ApproveServicePorder"){echo 'show';} ?>"
					id="finance" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 61)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Purchaseorder'; ?>">
						<div class="nav-link-icon"><i class="fa fa-suitcase"></i></div>Purchase Order
					</a>
				</div>

				<div class="collapse <?php if($functionmenu=="ApprovedPurchaseOrder" | $functionmenu=="Purchaseorder" | $functionmenu=="Supplier" | $functionmenu=="Suppliertype" | $functionmenu=="Newpurchaserequest" | $functionmenu=="ApprovedGrn" | $functionmenu=="ApproveServicePorder"){echo 'show';} ?>"
					id="finance" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 95)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark"
						href="<?php echo base_url().'ApprovedPurchaseOrder'; ?>">
						<div class="nav-link-icon"><i class="fa fa-check-circle"></i></div>Approved Purchase Orders
					</a>
				</div>
				<div class="collapse <?php if($functionmenu=="ApprovedPurchaseOrder" | $functionmenu=="Purchaseorder" | $functionmenu=="Supplier" | $functionmenu=="Suppliertype" | $functionmenu=="Newpurchaserequest" | $functionmenu=="ApprovedGrn" | $functionmenu=="ApproveServicePorder"){echo 'show';} ?>"
					id="finance" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 99)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'ApproveServicePorder'; ?>">
						<div class="nav-link-icon"><i class="fa fa-check-circle"></i></div>Approved Service P-order
					</a>
				</div>

				<div class="collapse <?php if($functionmenu=="ApprovedGrn" | $functionmenu=="ApprovedPurchaseOrder" | $functionmenu=="Purchaseorder" | $functionmenu=="Supplier" | $functionmenu=="Suppliertype" | $functionmenu=="Newpurchaserequest" | $functionmenu=="ApproveServicePorder"){echo 'show';} ?>"
					id="finance" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 96)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'ApprovedGrn'; ?>">
						<div class="nav-link-icon"><i class="fa fa-check-square"></i></div>Approved GRN
					</a>
					<?php } ?>
				</div>

			</nav>


			<!-- Stores Menu New Added -->

			<?php if(menucheck($menuprivilegearray, 62)==1){?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsestores" aria-expanded="false" aria-controls="collapsestores">
				<div class="nav-link-icon"><i class="fa fa-shopping-basket"></i></div>
				Stores
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>

			<nav class="sidenav-menu-nested nav accordion" id="collapsestores">

				<div class="collapse <?php if( $functionmenu=="Goodreceive" | $functionmenu=="Productionorderview"){echo 'show';} ?>"
					id="collapsestores" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#grnsection" aria-expanded="false"
						aria-controls="grnsection">
						<div class="nav-link-icon"><i class="fa fa-cart-arrow-down"></i></div>
						GRN Section
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Goodreceive" | $functionmenu=="Productionorderview"){echo 'show';} ?>"
						id="grnsection" data-parent="#collapsestores">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php if(menucheck($menuprivilegearray, 34)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Goodreceive'; ?>">Good Receive Note</a>
							<?php } ?>
						</nav>
					</div>
				</div>
			</nav>

			

			<!-- Stock Menu New Added -->

			<?php } if(menucheck($menuprivilegearray, 91)==1 | menucheck($menuprivilegearray, 92)==1 | menucheck($menuprivilegearray, 97)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsStock" aria-expanded="false" aria-controls="collapsStock">
				<div class="nav-link-icon"><i class="fa fa-truck"></i></div>Stock Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Stocktransfer" | $functionmenu=="Report" | $functionmenu=="AdvancedStockSearch" ){echo 'show';} ?>"
				id="collapsStock" data-parent="#accordionSidenav">

				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">

					<?php  if(menucheck($menuprivilegearray, 92)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Report'; ?>">Stock</a>
					<?php } if(menucheck($menuprivilegearray, 91)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Stocktransfer'; ?>">Stock
						Transfer</a>
					<?php } if(menucheck($menuprivilegearray, 97)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'AdvancedStockSearch'; ?>">Advanced Stock Search</a>
					<?php }if(menucheck($menuprivilegearray, 98)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'AdvancedStockTransfer'; ?>">Advanced Stock Transfer</a>
					<?php } ?>


				</nav>
			</div>

			<!-- Internal Item Request Menu New Added -->

			<?php } if(menucheck($menuprivilegearray, 88)==1 | menucheck($menuprivilegearray, 89)==1 | menucheck($menuprivilegearray, 90)==1 ){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsGrnrequest" aria-expanded="false" aria-controls="collapsGrnrequest">
				<div class="nav-link-icon"><i class="fa fa-folder-open"></i></div>Internal Item Request
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Goodreceiverequest" | $functionmenu=="Approvedgoodreceiverequest"  | $functionmenu=="Issuegoodreceive"){echo 'show';} ?>"
				id="collapsGrnrequest" data-parent="#accordionSidenav">

				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">

					<?php  if(menucheck($menuprivilegearray, 88)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Goodreceiverequest'; ?>">Item Request</a>
					<?php } if(menucheck($menuprivilegearray, 89)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Approvedgoodreceiverequest'; ?>">Approved Item Request</a>
					<?php } if(menucheck($menuprivilegearray, 90)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Issuegoodreceive'; ?>">Issue Item Request </a>

					<?php } ?>



				</nav>
			</div>

			<!-- Invoice Menu New Added -->
			<?php } if(menucheck($menuprivilegearray, 102)==1 | menucheck($menuprivilegearray, 103)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsInvoice" aria-expanded="false" aria-controls="collapsInvoice">
				<div class="nav-link-icon"><i class="fa fa-file-invoice"></i></div>Invoice
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Dispatchnote" | $functionmenu=="Invoice"){echo 'show';} ?>"
				id="collapsInvoice" data-parent="#accordionSidenav">

				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">

					<?php  if(menucheck($menuprivilegearray, 102)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Dispatchnote'; ?>">Dispatch Note</a>
					<?php } if(menucheck($menuprivilegearray, 103)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Invoice'; ?>">Invoice </a>
					<?php } ?>
				</nav>
			</div>
			
			<!-- Vehicle Management Menu New Added -->

			<?php if(menucheck($menuprivilegearray, 15)==1 | menucheck($menuprivilegearray, 16)==1 | menucheck($menuprivilegearray, 17)==1 | menucheck($menuprivilegearray, 18)==1 | menucheck($menuprivilegearray, 19)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseVehicle" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-car"></i></div>
				Vehicle Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Vehicle" | $functionmenu=="Vehicletype" | $functionmenu=="Vehiclebrand"| $functionmenu=="Vehiclemodel" |$functionmenu=="Renewtype"){echo 'show';} ?>"
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
					<?php } if(menucheck($menuprivilegearray, 20)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Renewtype'; ?>">Renew
						Type</a>

					<?php } ?>
				</nav>
			</div>
			<?php } ?>

			<!-- Machine Management Menu New Added -->

			<?php } if(menucheck($menuprivilegearray, 7)==1 | menucheck($menuprivilegearray, 37)==1 | menucheck($menuprivilegearray, 38)==1  | menucheck($menuprivilegearray, 39)==1 | menucheck($menuprivilegearray, 8 | menucheck($menuprivilegearray, 29 )==1)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsmachine" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-tools"></i></div>
				Machine Management
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Machine" | $functionmenu=="Machinetype"  | $functionmenu=="Factory" | $functionmenu=="MachineIssueCategory"){echo 'show';} ?>"
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
						href="<?php echo base_url().'MachineIssueCategory'; ?>">Machine
						Issues</a>
					<?php } ?>
				</nav>
			</div>

			<!-- Others Menu New Added -->

			<?php } if(menucheck($menuprivilegearray, 51)==1 | menucheck($menuprivilegearray, 52)==1 | menucheck($menuprivilegearray, 53)==1 | menucheck($menuprivilegearray, 54)==1 | menucheck($menuprivilegearray, 55)==1 | menucheck($menuprivilegearray, 56)==1 | menucheck($menuprivilegearray, 57)==1 | menucheck($menuprivilegearray, 21)==1 | menucheck($menuprivilegearray, 22)==1 | menucheck($menuprivilegearray, 47)==1 | menucheck($menuprivilegearray, 48)==1){?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseother" aria-expanded="false" aria-controls="collapseVehicle">
				<div class="nav-link-icon"><i class="fas fa-users"></i></div>
				Other
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<nav class="sidenav-menu-nested nav accordion" id="collapseother">
				<div class="collapse <?php if($functionmenu=="Service"  | $functionmenu=="Assetmain" | $functionmenu=="Assetsub" | $functionmenu=="Asset" | $functionmenu=="Assetdepreciation" | $functionmenu=="Assetremove" | $functionmenu=="Assetremoveapprove" | $functionmenu=="Approvedassetremove" | $functionmenu=="Serviceorder"  | $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
					id="collapseother" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#othersection" aria-expanded="false"
						aria-controls="othersection">
						<div class="nav-link-icon"><i class="fa fa-taxi"></i></div>
						Service
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Service" ){echo 'show';} ?>" id="othersection"
						data-parent="#collapseother">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php if(menucheck($menuprivilegearray, 21)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Service'; ?>">Service
								Details</a>
							<?php } ?>
						</nav>
					</div>
				</div>
				<div class="collapse <?php if($functionmenu=="Service"  | $functionmenu=="Assetmain" | $functionmenu=="Assetsub" | $functionmenu=="Asset" | $functionmenu=="Assetdepreciation" | $functionmenu=="Assetremove" | $functionmenu=="Assetremoveapprove" | $functionmenu=="Approvedassetremove" | $functionmenu=="Serviceorder"  | $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
					id="collapseother" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#collapsserviceinquary" aria-expanded="false"
						aria-controls="collapsserviceinquary">
						<div class="nav-link-icon"><i class="fa fa-folder-open"></i></div>
						Service Order Inquiry
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Serviceorder"  | $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
						id="collapsserviceinquary" data-parent="#collapseother">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php } if(menucheck($menuprivilegearray, 34)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Serviceorder'; ?>">Inquiry for
								Approve</a>
							<?php if(menucheck($menuprivilegearray, 36)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Approveserviceorder'; ?>">Approved Inquiry
							</a>
							<?php } ?>
						</nav>
					</div>
				</div>



				<div class="collapse <?php if($functionmenu=="Service" | $functionmenu=="Assetmain" | $functionmenu=="Assetsub" | $functionmenu=="Asset" | $functionmenu=="Assetdepreciation" | $functionmenu=="Assetremove" | $functionmenu=="Assetremoveapprove" | $functionmenu=="Approvedassetremove" | $functionmenu=="Serviceorder"  | $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
					id="collapseother" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#assetssection" aria-expanded="false"
						aria-controls="assetssection">
						<div class="nav-link-icon"><i class="fa fa-sticky-note"></i></div>
						Assets
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Assetmain" | $functionmenu=="Assetsub" | $functionmenu=="Asset" | $functionmenu=="Assetdepreciation" | $functionmenu=="Assetremove" | $functionmenu=="Assetremoveapprove" | $functionmenu=="Approvedassetremove"){echo 'show';} ?>"
						id="assetssection" data-parent="#collapseother">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php if(menucheck($menuprivilegearray, 34)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Assetmain'; ?>">Asset
								Main Category</a>
							<?php } if(menucheck($menuprivilegearray, 35)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Assetsub'; ?>">Asset
								Sub Category</a>
							<?php } if(menucheck($menuprivilegearray, 36)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Asset'; ?>">Assets</a>
							<?php } if(menucheck($menuprivilegearray, 37)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Assetdepreciation'; ?>">Asset
								Depreciation</a>
							<?php } if(menucheck($menuprivilegearray, 38)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Assetremove'; ?>">Asset
								Disposal</a>
							<?php } if(menucheck($menuprivilegearray, 39)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Assetremoveapprove'; ?>">Asset
								Disposal Approve</a>
							<?php } if(menucheck($menuprivilegearray, 40)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Approvedassetremove'; ?>">Approved Asset Disposal</a>
							<?php } ?>
						</nav>
					</div>
				</div>
			</nav>

			<!-- Production Menu New Added -->

			<?php } if(menucheck($menuprivilegearray, 9)==1 | menucheck($menuprivilegearray, 10)==1 | menucheck($menuprivilegearray, 11)==1 | menucheck($menuprivilegearray, 12)==1 | menucheck($menuprivilegearray, 13)==1 | menucheck($menuprivilegearray, 14)==1
			| menucheck($menuprivilegearray, 25)==1 | menucheck($menuprivilegearray, 36)==1 | menucheck($menuprivilegearray, 37)==1 | menucheck($menuprivilegearray, 38)==1 |menucheck($menuprivilegearray, 59)==1 | menucheck($menuprivilegearray, 24)==1 | menucheck($menuprivilegearray, 30)==1 | menucheck($menuprivilegearray, 31 )==1 | menucheck($menuprivilegearray, 26)==1 | menucheck($menuprivilegearray, 27)==1 | menucheck($menuprivilegearray, 28)==1 | menucheck($menuprivilegearray, 101)==1){?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapseproduction" aria-expanded="false" aria-controls="collapseproduction">
				<div class="nav-link-icon"><i class="fas fa-wrench"></i></div>
				Production
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<nav class="sidenav-menu-nested nav accordion" id="collapseproduction">
				<div class="collapse <?php if($functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates"
			| $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize" | $functionmenu=="JobTaskList" | $functionmenu=="Processplan" | $functionmenu=="Machinealloction" | $functionmenu=="AllocatedMachines" | $functionmenu=="BreakDownDashboard" |$functionmenu=="CategoryGauge"){echo 'show';} ?>"
					id="collapseproduction" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#materialsection" aria-expanded="false"
						aria-controls="materialsection">
						<div class="nav-link-icon"><i class="fa fa-list-alt"></i></div>
						Material Information
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates" | $functionmenu=="Color" | $functionmenu=="Materialdetail" |$functionmenu=="CategoryGauge"){echo 'show';} ?>" id="materialsection"
						data-parent="#collapseproduction">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php  if(menucheck($menuprivilegearray, 59)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialdetail'; ?>">Material Details</a>
							<?php } if(menucheck($menuprivilegearray, 13)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialtype'; ?>">Material Type</a>
							<?php } if(menucheck($menuprivilegearray, 101)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'CategoryGauge'; ?>">Category Gauge</a>
							<?php } if(menucheck($menuprivilegearray, 25)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Color'; ?>">Material Color</a>
							<?php }if(menucheck($menuprivilegearray, 9)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Foiling'; ?>">Foiling</a>
							<?php } if(menucheck($menuprivilegearray, 10)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Lamination'; ?>">Lamination</a>
							<?php } if(menucheck($menuprivilegearray, 11)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rimming'; ?>">Rimming</a>
							<?php } if(menucheck($menuprivilegearray, 12)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Varnish'; ?>">Varnish</a>
							<?php } if(menucheck($menuprivilegearray, 14)==1){ ?> <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Plates'; ?>">Plates</a>
							
							<?php } ?>
						</nav>
					</div>
				</div>
				<div class="collapse <?php if($functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates" |$functionmenu=="CategoryGauge"
			| $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize" | $functionmenu=="JobTaskList" | $functionmenu=="Processplan" | $functionmenu=="Machinealloction" | $functionmenu=="AllocatedMachines" | $functionmenu=="BreakDownDashboard"){echo 'show';} ?>"
					id="collapseproduction" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#boardsection" aria-expanded="false"
						aria-controls="boardsection">
						<div class="nav-link-icon"><i class="fas fa-archive"></i></div>
						Board Information
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize"){echo 'show';} ?>"
						id="boardsection" data-parent="#collapseproduction">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php if(menucheck($menuprivilegearray, 24)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Board'; ?>">Board</a>
							<?php }if(menucheck($menuprivilegearray, 30)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Boardtype'; ?>">Board
								Type</a>
							<?php } if(menucheck($menuprivilegearray, 31)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Boardsize'; ?>">Board
								Size</a>
							<?php } ?>
						</nav>
					</div>
				</div>
				<div class="collapse <?php if($functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" |$functionmenu=="CategoryGauge" | $functionmenu=="Plates"
			| $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize" | $functionmenu=="JobTaskList" | $functionmenu=="Processplan" | $functionmenu=="Machinealloction" | $functionmenu=="AllocatedMachines" | $functionmenu=="BreakDownDashboard"){echo 'show';} ?>"
					id="collapseproduction" data-parent="#accordionSidenav">
					<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
						data-toggle="collapse" data-target="#collapstjobplan" aria-expanded="false"
						aria-controls="collapstjobplan">
						<div class="nav-link-icon"><i class="fas fa-briefcase"></i></div>
						Job Plan
						<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse <?php if($functionmenu=="JobTaskList" | $functionmenu=="Processplan"){echo 'show';} ?>"
						id="collapstjobplan" data-parent="#collapseproduction">
						<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
							<?php if(menucheck($menuprivilegearray, 40)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'JobTaskList'; ?>">Job
								Task List</a>
							<?php } if(menucheck($menuprivilegearray, 41)==1){ ?>
							<a class="nav-link p-0 px-3 py-1 text-dark"
								href="<?php echo base_url().'Processplan'; ?>">Process
								Plan</a>
							<?php } ?>
						</nav>
					</div>
				</div>


				<div class="collapse <?php if($functionmenu=="Machinealloction" | $functionmenu=="Foiling" |$functionmenu=="CategoryGauge" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates"
			| $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize" | $functionmenu=="JobTaskList" | $functionmenu=="Processplan" | $functionmenu=="AllocatedMachines" | $functionmenu=="BreakDownDashboard"){echo 'show';} ?>"
					id="collapseproduction" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 36)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Machinealloction'; ?>">
						<div class="nav-link-icon"><i class="fa fa-sticky-note"></i></div>Machine
						Allocation
					</a>
				</div>

				<div class="collapse <?php if($functionmenu=="AllocatedMachines" | $functionmenu=="Machinealloction" |$functionmenu=="CategoryGauge" | $functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates"
			| $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize" | $functionmenu=="JobTaskList" | $functionmenu=="Processplan" | $functionmenu=="BreakDownDashboard"){echo 'show';} ?>"
					id="collapseproduction" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 37)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'AllocatedMachines'; ?>">
						<div class="nav-link-icon"><i class="fa fa-handshake"></i></div>Allocated
						Machines
					</a>
				</div>

				<div class="collapse <?php if($functionmenu=="BreakDownDashboard" | $functionmenu=="AllocatedMachines" |$functionmenu=="CategoryGauge" | $functionmenu=="Machinealloction" | $functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates"
			| $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="Board" | $functionmenu=="Boardtype"  | $functionmenu=="Boardsize" | $functionmenu=="JobTaskList" | $functionmenu=="Processplan"){echo 'show';} ?>"
					id="collapseproduction" data-parent="#accordionSidenav">
					<?php }if(menucheck($menuprivilegearray, 38)==1){ ?>
					<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'BreakDownDashboard'; ?>">
						<div class="nav-link-icon"><i class="fa fa-industry"></i></div>Breakdown
						Dashboard
					</a>
				</div>



			</nav>

			
			<?php  } if(menucheck($menuprivilegearray, 32)==1 | menucheck($menuprivilegearray, 33)==1 | menucheck($menuprivilegearray, 66)==1  | menucheck($menuprivilegearray, 85)==1  | menucheck($menuprivilegearray, 86)==1 ) ?>
			<a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
				data-target="#collapsereport" aria-expanded="false" aria-controls="collapsereport">
				<div class="nav-link-icon"><i data-feather="file"></i></div>
				Reports
				<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
			</a>
			<div class="collapse <?php if($functionmenu=="Rptservicesummery" | $functionmenu=="Rptsalereport" |  $functionmenu=="Rptroute" |  $functionmenu=="Rptserviceitem" |  $functionmenu=="Rptrefitemreport" | $functionmenu=="Rptrefsalesreport" | $functionmenu=="MachineAllocationReport" | $functionmenu=="JobSummaryReport" | $functionmenu=="StockReport"){echo 'show';} ?>"
				id="collapsereport" data-parent="#accordionSidenav">
				<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
					<?php if(menucheck($menuprivilegearray, 32)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptservicesummery'; ?>">Service Summary
						Report</a>
					<?php } if(menucheck($menuprivilegearray, 33)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'Rptserviceitem'; ?>">Service Item
						Report</a>
					<?php } if(menucheck($menuprivilegearray, 66)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark"
						href="<?php echo base_url().'MachineAllocationReport'; ?>">Machine
						Allocation Report</a>
					<?php } if(menucheck($menuprivilegearray, 85)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'JobSummaryReport'; ?>">Job
						Summary Report</a>
					<?php } if(menucheck($menuprivilegearray, 86)==1){ ?>
					<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'StockReport'; ?>">Stock
						Report</a>
					<?php } ?>
				</nav>
			</div>

			<?php if(menucheck($menuprivilegearray, 104)==1){ ?>
			<a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Deleteitems'; ?>">
				<div class="nav-link-icon"><i class="fas fa-search-dollar"></i></div>
				Delete Items
			</a>



			<!-- User Account Menu New Added -->

			<?php }if(menucheck($menuprivilegearray, 1)==1 | menucheck($menuprivilegearray, 2)==1 | menucheck($menuprivilegearray, 3)==1 | menucheck($menuprivilegearray, 4)==1){ ?>
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
