<?php
session_start();

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'tbl_print_invoice';

// Table's primary key
$primaryKey = 'idtbl_print_invoice';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_invoice`', 'dt' => 'idtbl_print_invoice', 'field' => 'idtbl_print_invoice' ),
	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
    array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
	array( 'db' => '`u`.`inv_no`', 'dt' => 'inv_no', 'field' => 'inv_no' ),
	array( 'db' => '`ua`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
	array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );
$joinQuery = "FROM `tbl_print_invoice` AS `u`
              LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)";
 
if(!empty($_POST['customer']) && !empty($_POST['company_id'])){ 
    $customer = $_POST['customer'];
	$companyID=$_POST['company_id'];
    $extraWhere = "`u`.`status` IN (1,2) AND `ua`.`idtbl_customer` = '$customer' AND `u`.`tbl_company_idtbl_company` = $companyID";

    if($customer=="all"){
        $extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company` = $companyID";
     }
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
