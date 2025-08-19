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
$table = 'tbl_renew_details';

// Table's primary key
$primaryKey = 'idtbl_renew_details';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_renew_details`', 'dt' => 'idtbl_renew_details', 'field' => 'idtbl_renew_details' ),
	array( 'db' => '`rt`.`renew_type`', 'dt' => 'renew_type', 'field' => 'renew_type' ),
	array( 'db' => '`supplier`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`u`.`amount`', 'dt' => 'amount', 'field' => 'amount' ),
	array( 'db' => '`u`.`next_renew_date`', 'dt' => 'next_renew_date', 'field' => 'next_renew_date' ),
	array( 'db' => '`u`.`renew_date`', 'dt' => 'renew_date', 'field' => 'renew_date' ),
	array( 'db' => '`u`.`comments`', 'dt' => 'comments', 'field' => 'comments' ),
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

if(!empty($_POST['vehicleid'] )){

	$vehicleid = $_POST['vehicleid'];
}

$joinQuery = "FROM `tbl_renew_details` AS `u` 
JOIN `tbl_renew_type` AS rt ON (`u`.`tbl_renew_type_idtbl_renew_type`=`rt`.`idtbl_renew_type`)
JOIN `tbl_supplier` AS supplier ON (`u`.`tbl_supplier_idtbl_supplier`=`supplier`.`idtbl_supplier`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_vehicle_idtbl_vehicle`=$vehicleid";
// print_r($serviceid);
// var_dump($serviceid);die();
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
