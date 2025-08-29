<?php 
$controllermenu=$this->router->fetch_class();
$functionmenu=uri_string();
$functionmenu2=$this->router->fetch_method();

$menuprivilegearray=$menuaccess;
;
if($functionmenu2=='Useraccount'){
    $addcheck=checkprivilege($menuprivilegearray, 1, 1);
    $editcheck=checkprivilege($menuprivilegearray, 1, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 1, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 1, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 1, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 1, 6);
}
else if($functionmenu2=='Usertype'){
    $addcheck=checkprivilege($menuprivilegearray, 2, 1);
    $editcheck=checkprivilege($menuprivilegearray, 2, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 2, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 2, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 2, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 2, 6);
}
else if($functionmenu2=='Userprivilege'){
    $addcheck=checkprivilege($menuprivilegearray, 3, 1);
    $editcheck=checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 3, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 3, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 3, 6);
}
else if($functionmenu=='Customer'){
    $addcheck=checkprivilege($menuprivilegearray, 4, 1);
    $editcheck=checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 4, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 4, 5);
}
else if($functionmenu=='Supplier'){
    $addcheck=checkprivilege($menuprivilegearray, 5, 1);
    $editcheck=checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 5, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 5, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 5, 6);
}
else if($functionmenu=='Suppliertype'){
    $addcheck=checkprivilege($menuprivilegearray, 6, 1);
    $editcheck=checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 6, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 6, 5);
}
else if($functionmenu=='Machine'){
    $addcheck=checkprivilege($menuprivilegearray, 7, 1);
    $editcheck=checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 7, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 7, 5);
}
else if($functionmenu=='Machinetype'){
    $addcheck=checkprivilege($menuprivilegearray, 8, 1);
    $editcheck=checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 8, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 8, 5);
}
else if($functionmenu=='Foiling'){
    $addcheck=checkprivilege($menuprivilegearray, 9, 1);
    $editcheck=checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 9, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 9, 5);
}
else if($functionmenu=='Lamination'){
    $addcheck=checkprivilege($menuprivilegearray, 10, 1);
    $editcheck=checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 10, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 10, 5);
}
else if($functionmenu=='Rimming'){
    $addcheck=checkprivilege($menuprivilegearray, 11, 1);
    $editcheck=checkprivilege($menuprivilegearray, 11, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 11, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 11, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 11, 5);
}
else if($functionmenu=='Varnish'){
    $addcheck=checkprivilege($menuprivilegearray, 12, 1);
    $editcheck=checkprivilege($menuprivilegearray, 12, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 12, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 12, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 12, 5);
}
else if($functionmenu=='Materialtype'){
    $addcheck=checkprivilege($menuprivilegearray, 13, 1);
    $editcheck=checkprivilege($menuprivilegearray, 13, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 13, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 13, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 13, 5);
}
else if($functionmenu=='Plates'){
    $addcheck=checkprivilege($menuprivilegearray, 14, 1);
    $editcheck=checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 14, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 14, 5);
}
else if($functionmenu=='Vehicle'){
    $addcheck=checkprivilege($menuprivilegearray, 15, 1);
    $editcheck=checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 15, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 15, 5);
}
else if($functionmenu=='Vehicletype'){
    $addcheck=checkprivilege($menuprivilegearray, 16, 1);
    $editcheck=checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 16, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 16, 5);
}
else if($functionmenu=='Vehiclebrand'){
    $addcheck=checkprivilege($menuprivilegearray, 17, 1);
    $editcheck=checkprivilege($menuprivilegearray, 17, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 17, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 17, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 17, 5);
}
else if($functionmenu=='Vehiclemodel'){
    $addcheck=checkprivilege($menuprivilegearray, 18, 1);
    $editcheck=checkprivilege($menuprivilegearray, 18, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 18, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 18, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 18, 5);
}
else if($functionmenu=='Renew'){
    $addcheck=checkprivilege($menuprivilegearray, 19, 1);
    $editcheck=checkprivilege($menuprivilegearray, 19, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 19, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 19, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 19, 5);
}
else if($functionmenu=='Renewtype'){
    $addcheck=checkprivilege($menuprivilegearray, 20, 1);
    $editcheck=checkprivilege($menuprivilegearray, 20, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 20, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 20, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 20, 5);
}
else if($functionmenu=='Service'){
    $addcheck=checkprivilege($menuprivilegearray, 21, 1);
    $editcheck=checkprivilege($menuprivilegearray, 21, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 21, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 21, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 21, 5);
}
else if($functionmenu=='Serviceitemlist'){
    $addcheck=checkprivilege($menuprivilegearray, 22, 1);
    $editcheck=checkprivilege($menuprivilegearray, 22, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 22, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 22, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 22, 5);
}
else if($functionmenu=='Board'){
    $addcheck=checkprivilege($menuprivilegearray, 24, 1);
    $editcheck=checkprivilege($menuprivilegearray, 24, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 24, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 24, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 24, 5);
}
else if($functionmenu=='Color'){
    $addcheck=checkprivilege($menuprivilegearray, 25, 1);
    $editcheck=checkprivilege($menuprivilegearray, 25, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 25, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 25, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 25, 5);
}
else if($functionmenu=='Customerinquiry'){
    $addcheck=checkprivilege($menuprivilegearray, 26, 1);
    $editcheck=checkprivilege($menuprivilegearray, 26, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 26, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 26, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 26, 5);
}
else if($functionmenu=='Customerinquiryforapprove'){
    $addcheck=checkprivilege($menuprivilegearray, 27, 1);
    $editcheck=checkprivilege($menuprivilegearray, 27, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 27, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 27, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 27, 5);
}
else if($functionmenu=='Approvedcustomerinquiry'){
    $addcheck=checkprivilege($menuprivilegearray, 28, 1);
    $editcheck=checkprivilege($menuprivilegearray, 28, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 28, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 28, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 28, 5);
}
else if($functionmenu=='Factory'){
    $addcheck=checkprivilege($menuprivilegearray, 29, 1);
    $editcheck=checkprivilege($menuprivilegearray, 29, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 29, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 29, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 29, 5);
}
else if($functionmenu=='Boardtype'){
    $addcheck=checkprivilege($menuprivilegearray, 30, 1);
    $editcheck=checkprivilege($menuprivilegearray, 30, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 30, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 30, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 30, 5);
}
else if($functionmenu=='Boardsize'){
    $addcheck=checkprivilege($menuprivilegearray, 31, 1);
    $editcheck=checkprivilege($menuprivilegearray, 31, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 31, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 31, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 31, 5);
}
else if($functionmenu=='Rptservicesummery'){
    $addcheck=checkprivilege($menuprivilegearray, 32, 1);
    $editcheck=checkprivilege($menuprivilegearray, 32, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 32, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 32, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 32, 5);
}
else if($functionmenu=='Rptserviceitem'){
    $addcheck=checkprivilege($menuprivilegearray, 33, 1);
    $editcheck=checkprivilege($menuprivilegearray, 33, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 33, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 33, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 33, 5);
}
else if($functionmenu=='Goodreceive'){
    $addcheck=checkprivilege($menuprivilegearray, 34, 1);
    $editcheck=checkprivilege($menuprivilegearray, 34, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 34, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 34, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 34, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 34, 6);
}
else if($functionmenu=='Productionorderview'){
    $addcheck=checkprivilege($menuprivilegearray, 35, 1);
    $editcheck=checkprivilege($menuprivilegearray, 35, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 35, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 35, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 35, 5);
}
else if($functionmenu=='Machinealloction'){
    $addcheck=checkprivilege($menuprivilegearray, 36, 1);
    $editcheck=checkprivilege($menuprivilegearray, 36, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 36, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 36, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 36, 5);
}
else if($functionmenu=='AllocatedMachines'){
    $addcheck=checkprivilege($menuprivilegearray, 37, 1);
    $editcheck=checkprivilege($menuprivilegearray, 37, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 37, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 37, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 37, 5);
}
else if($functionmenu=='BreakDownDashboard'){
    $addcheck=checkprivilege($menuprivilegearray, 38, 1);
    $editcheck=checkprivilege($menuprivilegearray, 38, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 38, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 38, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 38, 5);
}
else if($functionmenu=='MachineIssueCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 39, 1);
    $editcheck=checkprivilege($menuprivilegearray, 39, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 39, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 39, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 39, 5);
}
else if($functionmenu=='JobTaskList'){
    $addcheck=checkprivilege($menuprivilegearray, 40, 1);
    $editcheck=checkprivilege($menuprivilegearray, 40, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 40, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 40, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 40, 5);
}
else if($functionmenu=='ProcessPlan'){
    $addcheck=checkprivilege($menuprivilegearray, 41, 1);
    $editcheck=checkprivilege($menuprivilegearray, 41, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 41, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 41, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 41, 5);
}
else if($functionmenu=='NewDeliveryPlan'){
    $addcheck=checkprivilege($menuprivilegearray, 42, 1);
    $editcheck=checkprivilege($menuprivilegearray, 42, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 42, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 42, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 42, 5);
}
else if($functionmenu=='OrderReconsilation'){
    $addcheck=checkprivilege($menuprivilegearray, 43, 1);
    $editcheck=checkprivilege($menuprivilegearray, 43, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 43, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 43, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 43, 5);
}
else if($functionmenu=='PlanDetails'){
    $addcheck=checkprivilege($menuprivilegearray, 44, 1);
    $editcheck=checkprivilege($menuprivilegearray, 44, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 44, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 44, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 44, 5);
}
else if($functionmenu=='Serviceorder'){
    $addcheck=checkprivilege($menuprivilegearray, 47, 1);
    $editcheck=checkprivilege($menuprivilegearray, 47, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 47, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 47, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 47, 5);
}
else if($functionmenu=='Approveserviceorder'){
    $addcheck=checkprivilege($menuprivilegearray, 48, 1);
    $editcheck=checkprivilege($menuprivilegearray, 48, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 48, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 48, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 48, 5);
}
else if($functionmenu=='Vehiclerenewforapprove'){
    $addcheck=checkprivilege($menuprivilegearray, 49, 1);
    $editcheck=checkprivilege($menuprivilegearray, 49, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 49, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 49, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 49, 5);
}
else if($functionmenu=='Approvevehiclerenew'){
    $addcheck=checkprivilege($menuprivilegearray, 50, 1);
    $editcheck=checkprivilege($menuprivilegearray, 50, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 50, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 50, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 50, 5);
}
else if($functionmenu=='Assetmain'){
    $addcheck=checkprivilege($menuprivilegearray, 51, 1);
    $editcheck=checkprivilege($menuprivilegearray, 51, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 51, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 51, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 51, 5);
}
else if($functionmenu=='Assetsub'){
    $addcheck=checkprivilege($menuprivilegearray, 52, 1);
    $editcheck=checkprivilege($menuprivilegearray, 52, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 52, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 52, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 52, 5);
}
else if($functionmenu=='Asset'){
    $addcheck=checkprivilege($menuprivilegearray, 53, 1);
    $editcheck=checkprivilege($menuprivilegearray, 53, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 53, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 53, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 53, 5);
}
else if($functionmenu=='Assetdepreciation'){
    $addcheck=checkprivilege($menuprivilegearray, 54, 1);
    $editcheck=checkprivilege($menuprivilegearray, 54, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 54, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 54, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 54, 5);
}
else if($functionmenu=='Assetremove'){
    $addcheck=checkprivilege($menuprivilegearray, 55, 1);
    $editcheck=checkprivilege($menuprivilegearray, 55, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 55, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 55, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 55, 5);
}
else if($functionmenu=='Assetremoveapprove'){
    $addcheck=checkprivilege($menuprivilegearray, 56, 1);
    $editcheck=checkprivilege($menuprivilegearray, 56, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 56, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 56, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 56, 5);
}
else if($functionmenu=='Approvedassetremove'){
    $addcheck=checkprivilege($menuprivilegearray, 57, 1);
    $editcheck=checkprivilege($menuprivilegearray, 57, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 57, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 57, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 57, 5);
}
else if($functionmenu=='Materialcode'){
    $addcheck=checkprivilege($menuprivilegearray, 58, 1);
    $editcheck=checkprivilege($menuprivilegearray, 58, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 58, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 58, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 58, 5);
}
else if($functionmenu=='Materialdetail'){
    $addcheck=checkprivilege($menuprivilegearray, 59, 1);
    $editcheck=checkprivilege($menuprivilegearray, 59, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 59, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 59, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 59, 5);
}
else if($functionmenu=='Materialcategory'){
    $addcheck=checkprivilege($menuprivilegearray, 60, 1);
    $editcheck=checkprivilege($menuprivilegearray, 60, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 60, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 60, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 60, 5);
}
else if($functionmenu=='Purchaseorder'){
    $addcheck=checkprivilege($menuprivilegearray, 61, 1);
    $editcheck=checkprivilege($menuprivilegearray, 61, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 61, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 61, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 61, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 61, 6);
}
else if($functionmenu=='Qualitycheck'){
    $addcheck=checkprivilege($menuprivilegearray, 62, 1);
    $editcheck=checkprivilege($menuprivilegearray, 62, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 62, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 62, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 62, 5);
}
else if($functionmenu=='Location'){
    $addcheck=checkprivilege($menuprivilegearray, 63, 1);
    $editcheck=checkprivilege($menuprivilegearray, 63, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 63, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 63, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 63, 5);
}
else if($functionmenu=='Employee'){
    $addcheck=checkprivilege($menuprivilegearray, 64, 1);
    $editcheck=checkprivilege($menuprivilegearray, 64, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 64, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 64, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 64, 5);
}
else if($functionmenu=='InternalUse'){
    $addcheck=checkprivilege($menuprivilegearray, 65, 1);
    $editcheck=checkprivilege($menuprivilegearray, 65, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 65, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 65, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 65, 5);
}
else if($functionmenu=='MachineAllocationReport'){
    $addcheck=checkprivilege($menuprivilegearray, 66, 1);
    $editcheck=checkprivilege($menuprivilegearray, 66, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 66, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 66, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 66, 5);
}
else if($functionmenu=='JobSummaryReport'){
    $addcheck=checkprivilege($menuprivilegearray, 85, 1);
    $editcheck=checkprivilege($menuprivilegearray, 85, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 85, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 85, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 85, 5);
}
else if($functionmenu=='StockReport'){
    $addcheck=checkprivilege($menuprivilegearray, 86, 1);
    $editcheck=checkprivilege($menuprivilegearray, 86, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 86, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 86, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 86, 5);
}
else if($functionmenu=='MachineAvailableSlots'){
    $addcheck=checkprivilege($menuprivilegearray, 56, 1);
    $editcheck=checkprivilege($menuprivilegearray, 56, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 56, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 56, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 56, 5);
}
else if($functionmenu=='Newpurchaserequest'){
    $addcheck=checkprivilege($menuprivilegearray, 87, 1);
    $editcheck=checkprivilege($menuprivilegearray, 87, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 87, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 87, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 87, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 87, 6);
}
else if($functionmenu=='Goodreceiverequest'){
    $addcheck=checkprivilege($menuprivilegearray, 88, 1);
    $editcheck=checkprivilege($menuprivilegearray, 88, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 88, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 88, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 88, 5);
}
else if($functionmenu=='Approvedgoodreceiverequest'){
    $addcheck=checkprivilege($menuprivilegearray, 89, 1);
    $editcheck=checkprivilege($menuprivilegearray, 89, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 89, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 89, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 89, 5);
}
else if($functionmenu=='Issuegoodreceive'){
    $addcheck=checkprivilege($menuprivilegearray, 90, 1);
    $editcheck=checkprivilege($menuprivilegearray, 90, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 90, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 90, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 90, 5);
}
else if($functionmenu=='Stocktransfer'){
    $addcheck=checkprivilege($menuprivilegearray, 91, 1);
    $editcheck=checkprivilege($menuprivilegearray, 91, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 91, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 91, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 91, 5);
}
else if($functionmenu=='Report'){
    $addcheck=checkprivilege($menuprivilegearray, 92, 1);
    $editcheck=checkprivilege($menuprivilegearray, 92, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 92, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 92, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 92, 5);
}
else if($functionmenu=='Measurements'){
    $addcheck=checkprivilege($menuprivilegearray, 93, 1);
    $editcheck=checkprivilege($menuprivilegearray, 93, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 93, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 93, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 93, 5);
}
else if($functionmenu=='Servicetype'){
    $addcheck=checkprivilege($menuprivilegearray, 94, 1);
    $editcheck=checkprivilege($menuprivilegearray, 94, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 94, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 94, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 94, 5);
}
else if($functionmenu=='ApprovedPurchaseOrder'){
    $addcheck=checkprivilege($menuprivilegearray, 95, 1);
    $editcheck=checkprivilege($menuprivilegearray, 95, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 95, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 95, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 95, 5);
}
else if($functionmenu=='ApprovedGrn'){
    $addcheck=checkprivilege($menuprivilegearray, 96, 1);
    $editcheck=checkprivilege($menuprivilegearray, 96, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 96, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 96, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 96, 5);
}
else if($functionmenu=='Allstockview'){
    $addcheck=checkprivilege($menuprivilegearray, 97, 1);
    $editcheck=checkprivilege($menuprivilegearray, 97, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 97, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 97, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 97, 5);
}
else if($functionmenu=='AdvancedStockTransfer'){
    $addcheck=checkprivilege($menuprivilegearray, 98, 1);
    $editcheck=checkprivilege($menuprivilegearray, 98, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 98, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 98, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 98, 5);
}
else if($functionmenu=='ApproveServicePorder'){
    $addcheck=checkprivilege($menuprivilegearray, 99, 1);
    $editcheck=checkprivilege($menuprivilegearray, 99, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 99, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 99, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 99, 5);
}
else if($functionmenu=='Taxcontrol'){
    $addcheck=checkprivilege($menuprivilegearray, 100, 1);
    $editcheck=checkprivilege($menuprivilegearray, 100, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 100, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 100, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 100, 5);
}
else if($functionmenu=='CategoryGauge'){
    $addcheck=checkprivilege($menuprivilegearray, 101, 1);
    $editcheck=checkprivilege($menuprivilegearray, 101, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 101, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 101, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 101, 5);
}
else if($functionmenu=='Dispatchnote'){
    $addcheck=checkprivilege($menuprivilegearray, 102, 1);
    $editcheck=checkprivilege($menuprivilegearray, 102, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 102, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 102, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 102, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 102, 6);
}
else if($functionmenu=='Invoice'){
    $addcheck=checkprivilege($menuprivilegearray, 103, 1);
    $editcheck=checkprivilege($menuprivilegearray, 103, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 103, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 103, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 103, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 103, 6);
}
else if($functionmenu=='Deleteitems'){
    $addcheck=checkprivilege($menuprivilegearray, 104, 1);
    $editcheck=checkprivilege($menuprivilegearray, 104, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 104, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 104, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 104, 5);
}
else if($functionmenu=='Charges'){
    $addcheck=checkprivilege($menuprivilegearray, 105, 1);
    $editcheck=checkprivilege($menuprivilegearray, 105, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 105, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 105, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 105, 5);
}
else if($functionmenu=='Chargesdetail'){
    $addcheck=checkprivilege($menuprivilegearray, 106, 1);
    $editcheck=checkprivilege($menuprivilegearray, 106, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 106, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 106, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 106, 5);
}
else if($functionmenu=='InvoiceReport'){
    $addcheck=checkprivilege($menuprivilegearray, 107, 1);
    $editcheck=checkprivilege($menuprivilegearray, 107, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 107, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 107, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 107, 5);
}
else if($functionmenu=='VatReport'){
    $addcheck=checkprivilege($menuprivilegearray, 127, 1);
    $editcheck=checkprivilege($menuprivilegearray, 127, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 127, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 127, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 127, 5);
}
else if($functionmenu=='SalesReport'){
    $addcheck=checkprivilege($menuprivilegearray, 128, 1);
    $editcheck=checkprivilege($menuprivilegearray, 128, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 128, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 128, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 128, 5);
}
else if($functionmenu=='Machinemodels'){
    $addcheck=checkprivilege($menuprivilegearray, 129, 1);
    $editcheck=checkprivilege($menuprivilegearray, 129, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 129, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 129, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 129, 5);
}
else if($functionmenu=='Spareparts'){
    $addcheck=checkprivilege($menuprivilegearray, 130, 1);
    $editcheck=checkprivilege($menuprivilegearray, 130, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 130, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 130, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 130, 5);
}
else if($functionmenu=='Machineservice'){
    $addcheck=checkprivilege($menuprivilegearray, 131, 1);
    $editcheck=checkprivilege($menuprivilegearray, 131, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 131, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 131, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 131, 5);
}
else if($functionmenu=='AdvancedGrnSearch'){
    $addcheck=checkprivilege($menuprivilegearray, 132, 1);
    $editcheck=checkprivilege($menuprivilegearray, 132, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 132, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 132, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 132, 5);
}
else if($functionmenu=='ServiceItemAllocate'){
    $addcheck=checkprivilege($menuprivilegearray, 136, 1);
    $editcheck=checkprivilege($menuprivilegearray, 136, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 136, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 136, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 136, 5);
}
else if($functionmenu=='Deletedinvoice'){
    $addcheck=checkprivilege($menuprivilegearray, 134, 1);
    $editcheck=checkprivilege($menuprivilegearray, 134, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 134, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 134, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 134, 5);
}
else if($functionmenu=='Canceledinvoice'){
    $addcheck=checkprivilege($menuprivilegearray, 135, 1);
    $editcheck=checkprivilege($menuprivilegearray, 135, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 135, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 135, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 135, 5);
}
else if($functionmenu=='ServiceItemReceive'){
    $addcheck=checkprivilege($menuprivilegearray, 137, 1);
    $editcheck=checkprivilege($menuprivilegearray, 137, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 137, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 137, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 137, 5);
}
else if($functionmenu=='ServiceItemIssues'){
    $addcheck=checkprivilege($menuprivilegearray, 138, 1);
    $editcheck=checkprivilege($menuprivilegearray, 138, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 138, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 138, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 138, 5);
}
else if($functionmenu=='Customerstatement'){
    $addcheck=checkprivilege($menuprivilegearray, 139, 1);
    $editcheck=checkprivilege($menuprivilegearray, 139, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 139, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 139, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 139, 5);
}
else if($functionmenu=='Usedserviceitems'){
    $addcheck=checkprivilege($menuprivilegearray, 140, 1);
    $editcheck=checkprivilege($menuprivilegearray, 140, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 140, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 140, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 140, 5);
}
else if($functionmenu=='Goodreceivereturn'){
    $addcheck=checkprivilege($menuprivilegearray, 141, 1);
    $editcheck=checkprivilege($menuprivilegearray, 141, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 141, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 141, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 141, 5);
}
else if($functionmenu=='Bincard'){
    $addcheck=checkprivilege($menuprivilegearray, 142, 1);
    $editcheck=checkprivilege($menuprivilegearray, 142, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 142, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 142, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 142, 5);
}
else if($functionmenu=='DAReport'){
    $addcheck=checkprivilege($menuprivilegearray, 143, 1);
    $editcheck=checkprivilege($menuprivilegearray, 143, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 143, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 143, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 143, 5);
}
else if($functionmenu=='Expences'){
    $addcheck=checkprivilege($menuprivilegearray, 144, 1);
    $editcheck=checkprivilege($menuprivilegearray, 144, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 144, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 144, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 144, 5);
}
else if($functionmenu=='GRNVoucher'){
    $addcheck=checkprivilege($menuprivilegearray, 145, 1);
    $editcheck=checkprivilege($menuprivilegearray, 145, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 145, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 145, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 145, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 145, 6);
}
else if($functionmenu=='UninvoiceDAReport'){
    $addcheck=checkprivilege($menuprivilegearray, 146, 1);
    $editcheck=checkprivilege($menuprivilegearray, 146, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 146, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 146, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 146, 5);
}
else if($functionmenu=='UncompletedjobReport'){
    $addcheck=checkprivilege($menuprivilegearray, 147, 1);
    $editcheck=checkprivilege($menuprivilegearray, 147, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 147, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 147, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 147, 5);
}
else if($functionmenu=='Rptgrn'){
    $addcheck=checkprivilege($menuprivilegearray, 148, 1);
    $editcheck=checkprivilege($menuprivilegearray, 148, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 148, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 148, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 148, 5);
}
else if($functionmenu=='IssueMaterials'){
    $addcheck=checkprivilege($menuprivilegearray, 149, 1);
    $editcheck=checkprivilege($menuprivilegearray, 149, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 149, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 149, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 149, 5);
}
else if($functionmenu=='Quatation'){
    $addcheck=checkprivilege($menuprivilegearray, 150, 1);
    $editcheck=checkprivilege($menuprivilegearray, 150, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 150, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 150, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 150, 5);
}
else if($functionmenu=='MaterialAllocation'){
    $addcheck=checkprivilege($menuprivilegearray, 151, 1);
    $editcheck=checkprivilege($menuprivilegearray, 151, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 151, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 151, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 151, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 151, 6);
}
else if($functionmenu=='JobCardAllocation'){
    $addcheck=checkprivilege($menuprivilegearray, 152, 1);
    $editcheck=checkprivilege($menuprivilegearray, 152, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 152, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 152, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 152, 5);
}
else if($functionmenu=='Rptoutstanding'){
    $addcheck=checkprivilege($menuprivilegearray, 153, 1);
    $editcheck=checkprivilege($menuprivilegearray, 153, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 153, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 153, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 153, 5);
}
else if($functionmenu=='Uomconversions'){
    $addcheck=checkprivilege($menuprivilegearray, 154, 1);
    $editcheck=checkprivilege($menuprivilegearray, 154, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 154, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 154, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 154, 5);
}
else if($functionmenu=='Creditnote'){
    $addcheck=checkprivilege($menuprivilegearray, 155, 1);
    $editcheck=checkprivilege($menuprivilegearray, 155, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 155, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 155, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 155, 5);
}
else if($functionmenu=='Newcustomerjobs'){
    $addcheck=checkprivilege($menuprivilegearray, 156, 1);
    $editcheck=checkprivilege($menuprivilegearray, 156, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 156, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 156, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 156, 5);
}
else if($functionmenu=='Unmoveditems'){
    $addcheck=checkprivilege($menuprivilegearray, 167, 1);
    $editcheck=checkprivilege($menuprivilegearray, 167, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 167, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 167, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 167, 5);
}
else if($functionmenu=='Jobcardissuematerial'){
    $addcheck=checkprivilege($menuprivilegearray, 168, 1);
    $editcheck=checkprivilege($menuprivilegearray, 168, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 168, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 168, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 168, 5);
}
else if($functionmenu=='DirectDispatchnote'){
    $addcheck=checkprivilege($menuprivilegearray, 172, 1);
    $editcheck=checkprivilege($menuprivilegearray, 172, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 172, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 172, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 172, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 172, 6);
}
else if($functionmenu=='DirectInvoice'){
    $addcheck=checkprivilege($menuprivilegearray, 173, 1);
    $editcheck=checkprivilege($menuprivilegearray, 173, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 173, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 173, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 173, 5);
    $checkstatus=checkprivilege($menuprivilegearray, 173, 6);
}
else if($functionmenu=='Materialgroup'){
    $addcheck=checkprivilege($menuprivilegearray, 176, 1);
    $editcheck=checkprivilege($menuprivilegearray, 176, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 176, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 176, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 176, 5);
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
            else if($type==5){
                return $array->approvestatus;
            }
            else if($type==6){
                return $array->checkstatus;
            }
        }
    }
}
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
            <?php  if(menucheck($menuprivilegearray, 15)==1 | menucheck($menuprivilegearray, 63)==1 | menucheck($menuprivilegearray, 93)==1 | menucheck($menuprivilegearray, 94)==1 | menucheck($menuprivilegearray, 100)==1 | menucheck($menuprivilegearray, 105)==1 | menucheck($menuprivilegearray, 106)==1 | menucheck($menuprivilegearray, 144)==1 | menucheck($menuprivilegearray, 154)==1) { ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsMasterfile" aria-expanded="false" aria-controls="collapsMasterfile">
                <div class="nav-link-icon"><i class="fa fa-print"></i></div>
                Master Information
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Location" | $functionmenu=="Measurements" | $functionmenu=="Servicetype"| $functionmenu=="Taxcontrol" |$functionmenu=="Serviceitemlist" | $functionmenu=="Charges" |$functionmenu=="Chargesdetail" | $functionmenu=="Expences" | $functionmenu=="Uomconversions"){echo 'show';} ?>" id="collapsMasterfile" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 63)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Location'; ?>">Location</a>
                    <?php } if(menucheck($menuprivilegearray, 93)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Measurements'; ?>">Measurements</a>
                    <?php } if(menucheck($menuprivilegearray, 94)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Servicetype'; ?>">Service Type</a>
                    <?php } if(menucheck($menuprivilegearray, 100)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Taxcontrol'; ?>">Tax Control</a>
                    <?php } if(menucheck($menuprivilegearray, 105)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Charges'; ?>">Charges Type</a>
                    <?php } if(menucheck($menuprivilegearray, 106)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Chargesdetail'; ?>">Charges Details</a>
                    <?php } if(menucheck($menuprivilegearray, 22)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Serviceitemlist'; ?>">Service Item List</a>
                    <?php } if(menucheck($menuprivilegearray, 144)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Expences'; ?>">Costing Types</a>
                    <?php } if(menucheck($menuprivilegearray, 154)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Uomconversions'; ?>">UOM Conversions</a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Material Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 59)==1 | menucheck($menuprivilegearray, 13)==1 | menucheck($menuprivilegearray, 101)==1 | menucheck($menuprivilegearray, 25)==1 | menucheck($menuprivilegearray, 9)==1 | menucheck($menuprivilegearray, 10)==1 | menucheck($menuprivilegearray, 11)==1 | menucheck($menuprivilegearray, 12)==1 | menucheck($menuprivilegearray, 14)==1 | menucheck($menuprivilegearray, 176)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapsematerials" aria-expanded="false" aria-controls="collapsematerials">
                <div class="nav-link-icon"><i class="fas fa-users"></i></div>
                Material Info
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Foiling" | $functionmenu=="Lamination" | $functionmenu=="Rimming" | $functionmenu=="Varnish" | $functionmenu=="Materialtype" | $functionmenu=="Plates" | $functionmenu=="Color" | $functionmenu=="Materialdetail" | $functionmenu=="CategoryGauge"){echo 'show';} ?>" id="collapsematerials" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion">
                    <?php  if(menucheck($menuprivilegearray, 59)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialdetail'; ?>">Material Details</a>
                    <?php } if(menucheck($menuprivilegearray, 59)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialdetail'; ?>">Material Details</a>
                    <?php } if(menucheck($menuprivilegearray, 13)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialtype'; ?>">Material Type</a>
                    <?php } if(menucheck($menuprivilegearray, 101)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'CategoryGauge'; ?>">Category Gauge</a>
                    <?php } if(menucheck($menuprivilegearray, 25)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Color'; ?>">Material Color</a>
                    <?php }if(menucheck($menuprivilegearray, 9)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Foiling'; ?>">Foiling</a>
                    <?php } if(menucheck($menuprivilegearray, 10)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Lamination'; ?>">Lamination</a>
                    <?php } if(menucheck($menuprivilegearray, 11)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rimming'; ?>">Rimming</a>
                    <?php } if(menucheck($menuprivilegearray, 12)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Varnish'; ?>">Varnish</a>
                    <?php } if(menucheck($menuprivilegearray, 14)==1){ ?> 
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Plates'; ?>">Plates</a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Job Management Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 4)==1 | menucheck($menuprivilegearray, 26)==1 | menucheck($menuprivilegearray, 27)==1 | menucheck($menuprivilegearray, 28)==1 | menucheck($menuprivilegearray, 42)==1 | menucheck($menuprivilegearray, 43)==1 | menucheck($menuprivilegearray, 44)==1 | menucheck($menuprivilegearray, 150)==1 | menucheck($menuprivilegearray, 156)==1 | menucheck($menuprivilegearray, 168)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#jobmanagement" aria-expanded="false" aria-controls="jobmanagement">
                <div class="nav-link-icon"><i class="fa fa-archive"></i></div>
                Job Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Customer"| $functionmenu=="Customerinquiry" | $functionmenu=="Customerinquiryforapprove" | $functionmenu=="Approvedcustomerinquiry" | $functionmenu=="Quatation" | $functionmenu=="NewDeliveryPlan" | $functionmenu=="OrderReconsilation" | $functionmenu=="PlanDetails" | $functionmenu=="MaterialAllocation" | $functionmenu=="Newcustomerjobs" | $functionmenu=="Jobcardissuematerial"){echo 'show';} ?>" id="jobmanagement" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion">
                    <?php if(menucheck($menuprivilegearray, 4)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'Customer'; ?>">Customer</a>
                    <?php } if(menucheck($menuprivilegearray, 156)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'Newcustomerjobs'; ?>">Customer Jobs</a>
                    <?php } if(menucheck($menuprivilegearray, 26)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'Customerinquiry'; ?>">Customer Inquiry</a>
                    <?php } if(menucheck($menuprivilegearray, 151)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'MaterialAllocation'; ?>">Job Card Create</a>
                    <?php } if(menucheck($menuprivilegearray, 168)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'Jobcardissuematerial'; ?>">Job Card Issue Material</a>
                    <?php }?>
                </nav>
            </div>

            <!-- Supplier Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 5)==1 | menucheck($menuprivilegearray, 6)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapsesupplier" aria-expanded="false" aria-controls="collapsesupplier">
                <div class="nav-link-icon"><i class="fas fa-users"></i></div>
                Supplier
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Supplier"| $functionmenu=="Suppliertype"){echo 'show';} ?>" id="collapsesupplier" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion">
                <?php } if(menucheck($menuprivilegearray, 6)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Suppliertype'; ?>">Supplier Type</a>
                    <?php if(menucheck($menuprivilegearray, 5)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Supplier'; ?>">New Supplier</a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Purchase Order Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 87)==1 | menucheck($menuprivilegearray, 61)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseporder" aria-expanded="false" aria-controls="collapseporder">
                <div class="nav-link-icon"><i class="fas fa-truck"></i></div>
                Purchase Order
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Newpurchaserequest"| $functionmenu=="Purchaseorder"){echo 'show';} ?>" id="collapseporder" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion">
                    <?php if(menucheck($menuprivilegearray, 87)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'Newpurchaserequest'; ?>">New Purchase Request</a>
                    <?php } if(menucheck($menuprivilegearray, 61)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark"  href="<?php echo base_url().'Purchaseorder'; ?>">Purchase Order</a>
                    <?php } ?>
                </nav>
            </div>

            <!-- GRN Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 34)==1 | menucheck($menuprivilegearray, 145)==1 | menucheck($menuprivilegearray, 141)==1){?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsestores" aria-expanded="false" aria-controls="collapsestores">
                <div class="nav-link-icon"><i class="fa fa-cart-arrow-down"></i></div>
                GRN Section
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Goodreceive" | $functionmenu=="GRNVoucher" | $functionmenu=="Goodreceivereturn"){echo 'show';} ?>" id="collapsestores" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 34)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Goodreceive'; ?>">Good Receive Note</a>
                    <?php } if(menucheck($menuprivilegearray, 145)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'GRNVoucher'; ?>">Good Receive Note Voucher</a>
                    <?php } if(menucheck($menuprivilegearray, 141)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Goodreceivereturn'; ?>">Good Receive Note Return</a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Stock Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 92)==1 | menucheck($menuprivilegearray, 97)==1  | menucheck($menuprivilegearray, 149)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsStock" aria-expanded="false" aria-controls="collapsStock">
                <div class="nav-link-icon"><i class="fa fa-warehouse"></i></div>Stock Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if( $functionmenu=="Report" | $functionmenu=="Allstockview" | $functionmenu=="IssueMaterials" ){echo 'show';} ?>" id="collapsStock" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php  if(menucheck($menuprivilegearray, 92)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Report'; ?>">Material Stock Category Wise Report</a>
                    <?php } if(menucheck($menuprivilegearray, 97)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Allstockview'; ?>">All Stock View</a>
                    <?php }if(menucheck($menuprivilegearray, 149)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'IssueMaterials'; ?>">Issue Materials</a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Stock Transfer Menu New Added -->
            <?php } if(menucheck($menuprivilegearray,91)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Stocktransfer'; ?>">
                <div class="nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                Stock Transfer
            </a>

            <!-- Internal Item (Issue)Request Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 88)==1 | menucheck($menuprivilegearray, 89)==1 | menucheck($menuprivilegearray, 90)==1 ){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsGrnrequest" aria-expanded="false" aria-controls="collapsGrnrequest">
                <div class="nav-link-icon"><i class="fa fa-folder-open"></i></div> Internal Item Request
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Goodreceiverequest" | $functionmenu=="Approvedgoodreceiverequest"  | $functionmenu=="Issuegoodreceive"){echo 'show';} ?>"
                id="collapsGrnrequest" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php  if(menucheck($menuprivilegearray, 88)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Goodreceiverequest'; ?>">Item Request</a>
                    <?php //} if(menucheck($menuprivilegearray, 89)==1){ ?>
                    <!-- <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php // echo base_url().'Approvedgoodreceiverequest'; ?>">Approved Item Request</a> -->
                    <?php } if(menucheck($menuprivilegearray, 90)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Issuegoodreceive'; ?>">Issue Item Request </a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Invoice Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 102)==1 | menucheck($menuprivilegearray, 103)==1 | menucheck($menuprivilegearray, 134)==1 | menucheck($menuprivilegearray, 135)==1 | menucheck($menuprivilegearray, 154)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsInvoice" aria-expanded="false" aria-controls="collapsInvoice">
                <div class="nav-link-icon"><i class="fa fa-file-invoice"></i></div>&nbsp;Invoice
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Dispatchnote" | $functionmenu=="Invoice" | $functionmenu=="Deletedinvoice" | $functionmenu=="Canceledinvoice" | $functionmenu=="Creditnote"){echo 'show';} ?>"
                id="collapsInvoice" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php  if(menucheck($menuprivilegearray, 102)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Dispatchnote'; ?>">Dispatch Note</a>
                    <?php } if(menucheck($menuprivilegearray, 103)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Invoice'; ?>">Invoice </a>
                    <?php } if(menucheck($menuprivilegearray, 154)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Creditnote'; ?>">Credit Note</a>
                    <?php } ?>
                </nav>
            </div>

                        <!-- Invoice Menu Fair Trading Added -->
            <?php } if(menucheck($menuprivilegearray, 172)==1 | menucheck($menuprivilegearray, 173)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsDirectInvoice" aria-expanded="false" aria-controls="collapsDirectInvoice">
                <div class="nav-link-icon"><i class="fa fa-file-invoice"></i></div>&nbsp;Direct Sale
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="DirectDispatchnote" | $functionmenu=="DirectInvoice"){echo 'show';} ?>"
                id="collapsDirectInvoice" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php  if(menucheck($menuprivilegearray, 172)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'DirectDispatchnote'; ?>">Direct Dispatch Note</a>
                    <?php } if(menucheck($menuprivilegearray, 173)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'DirectInvoice'; ?>">Direct Invoice </a>
                    <?php } ?>
                </nav>
            </div>

            <!-- Vehicle Management Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 15)==1 | menucheck($menuprivilegearray, 16)==1 | menucheck($menuprivilegearray, 17)==1 | menucheck($menuprivilegearray, 18)==1 | menucheck($menuprivilegearray, 20)==1 | menucheck($menuprivilegearray, 21)==1 | menucheck($menuprivilegearray, 47)==1 | menucheck($menuprivilegearray, 48)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseVehicle" aria-expanded="false" aria-controls="collapseVehicle">
                <div class="nav-link-icon"><i class="fas fa-car"></i></div>
                Vehicle Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Vehicle" | $functionmenu=="Vehicletype" | $functionmenu=="Vehiclebrand"| $functionmenu=="Vehiclemodel" |$functionmenu=="Renewtype" | $functionmenu=="Service" | $functionmenu=="Serviceorder" | $functionmenu=="Approveserviceorder"){echo 'show';} ?>"
                id="collapseVehicle" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 16)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehicletype'; ?>">Vehicle Type</a>
                    <?php } if(menucheck($menuprivilegearray, 17)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehiclebrand'; ?>">Vehicle Brand</a>
                    <?php } if(menucheck($menuprivilegearray, 18)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehiclemodel'; ?>">Vehicle Model</a>
                    <?php } if(menucheck($menuprivilegearray, 15)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Vehicle'; ?>">Vehicle</a>
                    <?php } if(menucheck($menuprivilegearray, 20)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Renewtype'; ?>">Renew Type</a>
                    <?php } ?>
                    
                    <!-- Service Info Section -->
                    <?php if(menucheck($menuprivilegearray, 21)==1 | menucheck($menuprivilegearray, 47)==1 | menucheck($menuprivilegearray, 48)==1){ ?>   
                    <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
                        data-toggle="collapse" data-target="#serviceinfo" aria-expanded="false"
                        aria-controls="serviceinfo">
                        Service Info
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?php if($functionmenu=="Service" | $functionmenu=="Serviceorder" | $functionmenu=="Approveserviceorder"){echo 'show';} ?>" id="serviceinfo">
                        <nav class="sidenav-menu-nested nav accordion">
                            <?php if(menucheck($menuprivilegearray, 21)==1){ ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Service'; ?>">Service Details</a>
                            <?php } if(menucheck($menuprivilegearray, 47)==1 | menucheck($menuprivilegearray, 48)==1){ ?>   
                            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);"
                                data-toggle="collapse" data-target="#serviceinquary" aria-expanded="false"
                                aria-controls="serviceinquary">
                                Service Order Inquiry
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?php if($functionmenu=="Serviceorder" | $functionmenu=="Approveserviceorder"){echo 'show';} ?>" id="serviceinquary">
                                <nav class="sidenav-menu-nested nav accordion">
                                    <?php if(menucheck($menuprivilegearray, 47)==1){ ?>
                                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Serviceorder'; ?>">Inquiry for Approve</a>
                                    <?php } if(menucheck($menuprivilegearray, 48)==1){ ?>
                                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Approveserviceorder'; ?>">Approved Inquiry</a>
                                    <?php } ?>
                                </nav>
                            </div>
                            <?php } ?>
                        </nav>
                    </div>
                    <?php } ?>
                </nav>
            </div>        

            <!-- Report Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 153)==1 | menucheck($menuprivilegearray, 32)==1 | menucheck($menuprivilegearray, 33)==1 | menucheck($menuprivilegearray, 66)==1  | menucheck($menuprivilegearray, 85)==1  | menucheck($menuprivilegearray, 107)==1 | menucheck($menuprivilegearray, 127)==1 | menucheck($menuprivilegearray, 128)==1 | menucheck($menuprivilegearray, 132)==1 | menucheck($menuprivilegearray, 143)==1 | menucheck($menuprivilegearray, 146)==1 | menucheck($menuprivilegearray, 147)==1 | menucheck($menuprivilegearray, 148)==1 | menucheck($menuprivilegearray, 167)==1) {?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapsereport" aria-expanded="false" aria-controls="collapsereport">
                <div class="nav-link-icon"><i data-feather="file"></i></div>
                Reports
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Rptoutstanding" | $functionmenu=="Rptservicesummery" | $functionmenu=="Rptsalereport" |  $functionmenu=="Rptroute" |  $functionmenu=="Rptserviceitem" |  $functionmenu=="Rptrefitemreport" | $functionmenu=="Rptrefsalesreport" | $functionmenu=="MachineAllocationReport" | $functionmenu=="JobSummaryReport" | $functionmenu=="StockReport" | $functionmenu=="VatReport" | $functionmenu=="SalesReport" | $functionmenu=="AdvancedGrnSearch" | $functionmenu=="DAReport" | $functionmenu=="UninvoiceDAReport" | $functionmenu=="UncompletedjobReport" | $functionmenu=="Rptgrn" | $functionmenu=="Unmoveditems"){echo 'show';} ?>" id="collapsereport" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 153)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptoutstanding'; ?>">Outstanding Report</a>
                    <?php } if(menucheck($menuprivilegearray, 167)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Unmoveditems'; ?>">Unmoved Items Report</a>
                    <?php } if(menucheck($menuprivilegearray, 32)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptservicesummery'; ?>">Service Summary Report</a>
                    <?php } if(menucheck($menuprivilegearray, 33)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptserviceitem'; ?>">Service Item Report</a>
                    <?php } if(menucheck($menuprivilegearray, 66)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineAllocationReport'; ?>">Machine Allocation Report</a>
                    <?php } if(menucheck($menuprivilegearray, 85)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'JobSummaryReport'; ?>">Job Summary Report</a>
                    <?php } if(menucheck($menuprivilegearray, 127)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'VatReport'; ?>">Vat Report</a>
                    <?php } if(menucheck($menuprivilegearray, 132)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'AdvancedGrnSearch'; ?>">Stock Report</a>
                    <?php } if(menucheck($menuprivilegearray, 128)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'SalesReport'; ?>">Sales Report</a>
                    <?php } if(menucheck($menuprivilegearray, 143)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'DAReport'; ?>">Dispatch Report</a>
                    <?php } if(menucheck($menuprivilegearray, 146)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'UninvoiceDAReport'; ?>"> Uninvoice Dispatch Report</a>
                    <?php } if(menucheck($menuprivilegearray, 147)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'UncompletedjobReport'; ?>"> Uncompleted Jobs Report</a>
                    <?php } if(menucheck($menuprivilegearray, 148)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptgrn'; ?>"> GRN Report</a>
                    <?php }?>
                </nav>
            </div>         

            <!-- User Account Menu New Added -->
            <?php } if(menucheck($menuprivilegearray, 1)==1 | menucheck($menuprivilegearray, 2)==1 | menucheck($menuprivilegearray, 3)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                <div class="nav-link-icon"><i class="fas fa-user"></i></div>
                User Account
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu2=="Useraccount" | $functionmenu2=="Usertype" | $functionmenu2=="Userprivilege"){echo 'show';} ?>"
                id="collapseUser" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 1)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Useraccount'; ?>">User Account</a>
                    <?php } if(menucheck($menuprivilegearray, 2)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Usertype'; ?>">Type</a>
                    <?php } if(menucheck($menuprivilegearray, 3)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Userprivilege'; ?>">Privilege</a>
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