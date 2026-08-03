<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$table='tbl_print_material_info';

$primaryKey='idtbl_print_material_info';


$columns=array(

array('db'=>'mi.materialinfocode','dt'=>'code','field'=>'code','as'=>'code'),
array('db'=>'mi.materialname','dt'=>'product_name','field'=>'product_name','as'=>'product_name'),
array('db'=>'mg.group','dt'=>'category','field'=>'category','as'=>'category'),
array('db'=>'latest.batchno','dt'=>'batch','field'=>'batch','as'=>'batch'),
array('db'=>'latest.grndate','dt'=>'date','field'=>'date','as'=>'date'),
array('db'=>'stock_totals.total_qty','dt'=>'qty','field'=>'qty','as'=>'qty'),
array('db'=>'mt.measure_type','dt'=>'uom','field'=>'uom','as'=>'uom')

);


require('config.php');


$sql_details=array(
'user'=>$db_username,
'pass'=>$db_password,
'db'=>$db_name,
'host'=>$db_host
);


require('ssp.customized.class.php');


$conn=new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->connect_error){
	die(json_encode(array('error'=>'Database connection failed')));
}


$where=array();

$where[]="mi.status=1";

// company filter
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;
$where[]="mi.tbl_company_idtbl_company='".$companyID."'";



if(!empty($_POST['group']) && $_POST['group'] !== 'all'){

$group=$conn->real_escape_string($_POST['group']);

$where[]="mi.tbl_material_group_idtbl_material_group='".$group."'";

}



if(!empty($_POST['date_from'])){

$dateFrom=$conn->real_escape_string($_POST['date_from']);

$where[]="latest.grndate >= '".$dateFrom."'";

}



if(!empty($_POST['date_to'])){

$dateTo=$conn->real_escape_string($_POST['date_to']);

$where[]="latest.grndate <= '".$dateTo."'";

}



if(!empty($_POST['search'])){

$search=$conn->real_escape_string($_POST['search']);

$where[]="(
mi.materialname LIKE '%$search%'
OR
latest.batchno LIKE '%$search%'
)";

}


// core re-order condition: total stock across all batches <= reorder level
$where[]="stock_totals.total_qty <= mi.reorderlevel";


$conn->close();


$whereClause=implode(" AND ",$where);



$joinQuery="
FROM tbl_print_material_info mi

LEFT JOIN tbl_material_group mg
ON mg.idtbl_material_group=mi.tbl_material_group_idtbl_material_group


LEFT JOIN (
	SELECT tbl_print_material_info_idtbl_print_material_info AS material_id,
	       SUM(qty) AS total_qty
	FROM tbl_print_stock
	WHERE status=1
	GROUP BY tbl_print_material_info_idtbl_print_material_info
) stock_totals
ON stock_totals.material_id=mi.idtbl_print_material_info


LEFT JOIN (
	SELECT s1.tbl_print_material_info_idtbl_print_material_info AS material_id,
	       s1.batchno, s1.grndate, s1.measure_type_id
	FROM tbl_print_stock s1
	INNER JOIN (
		SELECT tbl_print_material_info_idtbl_print_material_info AS material_id,
		       MAX(grndate) AS max_date
		FROM tbl_print_stock
		WHERE status=1
		GROUP BY tbl_print_material_info_idtbl_print_material_info
	) s2
	ON s1.tbl_print_material_info_idtbl_print_material_info=s2.material_id
	AND s1.grndate=s2.max_date
) latest
ON latest.material_id=mi.idtbl_print_material_info


LEFT JOIN tbl_measurements mt
ON mt.idtbl_mesurements=latest.measure_type_id


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