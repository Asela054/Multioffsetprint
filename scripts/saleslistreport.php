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



$where=array();


$where[]="i.status=1";



if(!empty($_POST['customer']) && $_POST['customer']!='all'){

$where[]="i.tbl_customer_idtbl_customer='".$_POST['customer']."'";

}



if(!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])){


$where[]="
i.date BETWEEN 
'".$_POST['search_from_date']."' 
AND 
'".$_POST['search_to_date']."'";

}



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

?>