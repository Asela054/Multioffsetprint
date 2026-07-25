<?php

// Keep warnings/notices out of the JSON response (see note below)
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$table='tbl_service';

$primaryKey='idtbl_service';


$columns=array(

array(
'db'=>'st.service_name',
'dt'=>'service_type',
'field'=>'service_type'
),


array(
'db'=>'s.service_date',
'dt'=>'service_date',
'field'=>'service_date'
),


array(
'db'=>'s.service_location',
'dt'=>'service_location',
'field'=>'service_location'
),


array(
'db'=>'v.vehicle_reg_no',
'dt'=>'vehicle_reg_no',
'field'=>'vehicle_reg_no'
),


array(
'db'=>'vm.vehicle_model',
'dt'=>'vehicle_model',
'field'=>'vehicle_model'
),


array(
'db'=>'vb.vehicle_brand',
'dt'=>'vehicle_brand',
'field'=>'vehicle_brand'
),


array(
'db'=>'vt.vehicle_type',
'dt'=>'vehicle_type',
'field'=>'vehicle_type'
),


array(
'db'=>'s.amount',
'dt'=>'amount',
'field'=>'amount'
),


array(
'db'=>'s.discription',
'dt'=>'description',
'field'=>'description'
),


array(
'db'=>'s.current_mileage',
'dt'=>'current_mileage',
'field'=>'current_mileage'
),


array(
'db'=>'s.next_service_mileage',
'dt'=>'next_service_mileage',
'field'=>'next_service_mileage'
),


array(
'db'=>'s.next_service_date',
'dt'=>'next_service_date',
'field'=>'next_service_date'
),


array(
'db'=>'v.renew_date',
'dt'=>'next_renew_date',
'field'=>'next_renew_date'
)


);


require('config.php');


$sql_details=array(
'user'=>$db_username,
'pass'=>$db_password,
'db'=>$db_name,
'host'=>$db_host
);


require('ssp.customized.class.php');


$joinQuery="

FROM tbl_service s


LEFT JOIN tbl_service_type st
ON st.idtbl_service_type=s.tbl_service_type_idtbl_service_type


LEFT JOIN tbl_vehicle v
ON v.idtbl_vehicle=s.tbl_vehicle_idtbl_vehicle


LEFT JOIN tbl_vehicle_model vm
ON vm.idtbl_vehicle_model=v.tbl_vehicle_model_idtbl_vehicle_model


LEFT JOIN tbl_vehicle_brand vb
ON vb.idtbl_vehicle_brand=v.tbl_vehicle_brand_idtbl_vehicle_brand


LEFT JOIN tbl_vehicle_type vt
ON vt.idtbl_vehicle_type=v.tbl_vehicle_type_idtbl_vehicle_type


WHERE s.status=1

";


echo json_encode(
SSP::simple(
$_POST,
$sql_details,
$table,
$primaryKey,
$columns,
$joinQuery
)
);

?>