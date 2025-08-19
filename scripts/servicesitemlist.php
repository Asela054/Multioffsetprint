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
$table = 'tbl_service_details';

// Table's primary key
$primaryKey = 'idtbl_service_details';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_service_details`', 'dt' => 'idtbl_service_details', 'field' => 'idtbl_service_details' ),
	array( 'db' => '`service`.`service_type`', 'dt' => 'service_type', 'field' => 'service_type' ),
	array( 'db' => '`u`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity' ),
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

if(!empty($_POST['serviceid'] )){

	$serviceid = $_POST['serviceid'];
}

$joinQuery = "FROM `tbl_service_details` AS `u` 
JOIN `tbl_service_item_list` AS service ON (`u`.`tbl_service_item_list_idtbl_service_item_list`=`service`.`idtbl_service_item_list`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_service_idtbl_service`=$serviceid";
// print_r($serviceid);
// var_dump($serviceid);die();
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
