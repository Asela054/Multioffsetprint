<?php

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
$table = 'tbl_delivery_plan';

// Table's primary key
$primaryKey = 'idtbl_delivery_plan';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_delivery_plan`', 'dt' => 'idtbl_delivery_plan', 'field' => 'idtbl_delivery_plan' ),
	array( 'db' => '`u`.`specialdeliveryid`', 'dt' => 'specialdeliveryid', 'field' => 'specialdeliveryid' ),
	array( 'db' => '`u`.`deliverycompletestatus`', 'dt' => 'deliverycompletestatus', 'field' => 'deliverycompletestatus' ),
	// array( 'db' => '`ud`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`uc`.`po_number`', 'dt' => 'po_number', 'field' => 'po_number' ),
	array( 'db' => '`c`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
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

$joinQuery = "FROM `tbl_delivery_plan` AS `u` JOIN `tbl_delivery_plan_details` AS `ua` ON (`ua`.`tbl_delivery_plan_idtbl_delivery_plan` = `u`.`idtbl_delivery_plan`) JOIN `tbl_customerinquiry` AS `uc` ON (`uc`.`idtbl_customerinquiry` = `u`.`idtbl_customerinquiry`) JOIN `tbl_customer` AS `c` ON (`c`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer`)";

$extraWhere = "`u`.`status` IN (1, 2)";
$groupBy ="`u`.`idtbl_delivery_plan`";
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere,$groupBy)
);
