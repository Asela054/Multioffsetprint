<?php


$table='tbl_print_invoice';

$primaryKey='idtbl_print_invoice';



$columns=array(

array(
'db'=>'CASE 
        WHEN DATE(i.date) < "2026-07-01" THEN i.inv_no
        ELSE i.tax_invoice_num
        END',
'dt'=>'inv_no',
'field'=>'inv_no',
'as'=>'inv_no'
),


array(
'db'=>'i.date',
'dt'=>'date',
'field'=>'date'
),


array(
'db'=>'c.customer',
'dt'=>'customer',
'field'=>'customer'
),


// Description
array(
'db'=>'GROUP_CONCAT(DISTINCT cid.job SEPARATOR ", ")',
'dt'=>'description',
'field'=>'description',
'as'=>'description'
),


// Amount without tax
array(
'db'=>'i.subtotal',
'dt'=>'amount',
'field'=>'amount',
'as'=>'amount'
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


$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die(json_encode(array('error' => 'Database connection failed')));
}


// Get company_id passed from the view (which reads it from the CI session)
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;


$where=array();


$where[]="i.status=1";

$where[]="i.tbl_company_idtbl_company='".$companyID."'";



if(!empty($_POST['customer']) && $_POST['customer']!='all'){

$customer = $conn->real_escape_string($_POST['customer']);

$where[]="i.tbl_customer_idtbl_customer='".$customer."'";

}



if(!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])){

$fromDate = $conn->real_escape_string($_POST['search_from_date']);
$toDate = $conn->real_escape_string($_POST['search_to_date']);

$where[]="
i.date BETWEEN 
'".$fromDate."' 
AND 
'".$toDate."'";

}


$conn->close();


$whereClause=implode(" AND ",$where);



$joinQuery="
FROM tbl_print_invoice i


LEFT JOIN tbl_customer c
ON c.idtbl_customer=i.tbl_customer_idtbl_customer


LEFT JOIN tbl_print_invoicedetail d
ON d.tbl_print_invoice_idtbl_print_invoice=i.idtbl_print_invoice


LEFT JOIN tbl_customerinquiry_detail cid
ON cid.job_no=d.job_no


WHERE $whereClause

GROUP BY 
i.idtbl_print_invoice,
i.inv_no,
i.date,
c.customer,
i.subtotal

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