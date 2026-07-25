<?php

// Keep warnings/notices out of the JSON response (fix the real cause too — see note below)
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$table='tbl_vehicle';

$primaryKey='idtbl_vehicle';


$columns=array(

array(
'db'=>'v.vehicle_reg_no',
'dt'=>'vehicle_reg_no',
'field'=>'vehicle_reg_no',
'as'=>'vehicle_reg_no'
),


array(
'db'=>'vm.vehicle_model',
'dt'=>'vehicle_model',
'field'=>'vehicle_model',
'as'=>'vehicle_model'
),


array(
'db'=>'vb.vehicle_brand',
'dt'=>'vehicle_brand',
'field'=>'vehicle_brand',
'as'=>'vehicle_brand'
),


array(
'db'=>'vt.vehicle_type',
'dt'=>'vehicle_type',
'field'=>'vehicle_type',
'as'=>'vehicle_type'
),


array(
'db'=>'v.engine_no',
'dt'=>'engine_no',
'field'=>'engine_no',
'as'=>'engine_no'
),


array(
'db'=>'v.chassis_no',
'dt'=>'chassis_no',
'field'=>'chassis_no',
'as'=>'chassis_no'
),


array(
'db'=>'v.mileage',
'dt'=>'mileage',
'field'=>'mileage',
'as'=>'mileage'
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


// open a connection here so we can safely escape user input below
$conn=new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->connect_error){
	die(json_encode(array('error'=>'Database connection failed')));
}


$where=array();

$where[]="v.status=1";



if(!empty($_POST['model']) && $_POST['model'] !== 'all'){

$model=$conn->real_escape_string($_POST['model']);

$where[]="v.tbl_vehicle_model_idtbl_vehicle_model='".$model."'";

}



if(!empty($_POST['brand']) && $_POST['brand'] !== 'all'){

$brand=$conn->real_escape_string($_POST['brand']);

$where[]="v.tbl_vehicle_brand_idtbl_vehicle_brand='".$brand."'";

}



if(!empty($_POST['type']) && $_POST['type'] !== 'all'){

$type=$conn->real_escape_string($_POST['type']);

$where[]="v.tbl_vehicle_type_idtbl_vehicle_type='".$type."'";

}



if(!empty($_POST['search'])){

$search=$conn->real_escape_string($_POST['search']);

$where[]="(
v.vehicle_reg_no LIKE '%$search%'
OR
v.engine_no LIKE '%$search%'
OR
v.chassis_no LIKE '%$search%'
)";

}


$conn->close();


$whereClause=implode(" AND ",$where);



$joinQuery="
FROM tbl_vehicle v

LEFT JOIN tbl_vehicle_model vm
ON vm.idtbl_vehicle_model=v.tbl_vehicle_model_idtbl_vehicle_model


LEFT JOIN tbl_vehicle_brand vb
ON vb.idtbl_vehicle_brand=v.tbl_vehicle_brand_idtbl_vehicle_brand


LEFT JOIN tbl_vehicle_type vt
ON vt.idtbl_vehicle_type=v.tbl_vehicle_type_idtbl_vehicle_type


WHERE $whereClause
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