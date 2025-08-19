<?php
require_once '../external.php';

$CI =& get_instance();
$CI->load->library('session');
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
$table = 'tbl_customer_job_details';

// Table's primary key
$primaryKey = 'idtbl_customer_job_details';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer_job_details`', 'dt' => 'idtbl_customer_job_details', 'field' => 'idtbl_customer_job_details' ),
	array( 'db' => '`u`.`job_name`', 'dt' => 'job_name', 'field' => 'job_name' ),
	array( 'db' => '`u`.`job_code`', 'dt' => 'job_code', 'field' => 'job_code' ),
	array( 'db' => '`ua`.`measure_type`', 'dt' => 'measure_type', 'field' => 'measure_type' ),
	array( 'db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
	// array( 'db' => '`u`.`account_name`', 'dt' => 'account_name', 'field' => 'account_name' ),
	array( 'db' => '`u`.`tbl_customer_idtbl_customer`', 'dt' => 'tbl_customer_idtbl_customer', 'field' => 'tbl_customer_idtbl_customer' ),
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

if(!empty($_POST['customer'])){$customerid = $_POST['customer'];}
$companyid=$_SESSION['company_id'];
$branchid=$_SESSION['branch_id'];

$joinQuery = "FROM `tbl_customer_job_details` AS `u` LEFT JOIN `tbl_measurements` As `ua` ON (`ua`.`idtbl_mesurements` = `u`.`tbl_measurements_idtbl_measurements`) LEFT JOIN `tbl_customer` As `ub` ON (`ub`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `ub`.`tbl_company_idtbl_company`='$companyid' AND `ub`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
if(!empty($_POST['customer'])){$extraWhere.=" AND  `u`.tbl_customer_idtbl_customer = '$customerid'";}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
