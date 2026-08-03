<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$table='tbl_print_porder';

$primaryKey='idtbl_print_porder';


$columns=array(

array('db'=>'po.porder_no','dt'=>'po_no','field'=>'po_no','as'=>'po_no'),
array('db'=>'po.orderdate','dt'=>'po_date','field'=>'po_date','as'=>'po_date'),
array('db'=>'sup.suppliername','dt'=>'supplier','field'=>'supplier','as'=>'supplier'),
array('db'=>'g.grn_no','dt'=>'grn_no','field'=>'grn_no','as'=>'grn_no'),
array('db'=>'g.grndate','dt'=>'grn_date','field'=>'grn_date','as'=>'grn_date'),
array('db'=>'g.invoicenum','dt'=>'inv_no','field'=>'inv_no','as'=>'inv_no'),
array('db'=>'g.batchno','dt'=>'batch_no','field'=>'batch_no','as'=>'batch_no')

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

$where[]="po.status=1";

// company filter
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;
$where[]="po.tbl_company_idtbl_company='".$companyID."'";



if(!empty($_POST['supplier']) && $_POST['supplier'] !== 'all'){

$supplier=$conn->real_escape_string($_POST['supplier']);

$where[]="po.tbl_supplier_idtbl_supplier='".$supplier."'";

}



if(!empty($_POST['postatus']) && $_POST['postatus'] !== 'all'){

$postatus=$_POST['postatus'];

if($postatus=='unapproved'){

$where[]="po.confirmstatus=0";

}elseif($postatus=='approved'){

$where[]="po.confirmstatus=1";

}elseif($postatus=='grncreated'){

$where[]="g.idtbl_print_grn IS NOT NULL";

}elseif($postatus=='grnapproved'){

$where[]="g.approvestatus=1";

}

}



$dateType=(!empty($_POST['date_type']) && $_POST['date_type']=='grn') ? 'g.grndate' : 'po.orderdate';



if(!empty($_POST['date_from'])){

$dateFrom=$conn->real_escape_string($_POST['date_from']);

$where[]=$dateType." >= '".$dateFrom."'";

}



if(!empty($_POST['date_to'])){

$dateTo=$conn->real_escape_string($_POST['date_to']);

$where[]=$dateType." <= '".$dateTo."'";

}



if(!empty($_POST['search'])){

$search=$conn->real_escape_string($_POST['search']);

$where[]="(
po.porder_no LIKE '%$search%'
OR
g.grn_no LIKE '%$search%'
OR
g.invoicenum LIKE '%$search%'
OR
g.batchno LIKE '%$search%'
)";

}


$conn->close();


$whereClause=implode(" AND ",$where);



$joinQuery="
FROM tbl_print_porder po

LEFT JOIN tbl_supplier sup
ON sup.idtbl_supplier=po.tbl_supplier_idtbl_supplier


LEFT JOIN tbl_print_grn g
ON g.tbl_print_porder_idtbl_print_porder=po.idtbl_print_porder
AND g.status=1


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