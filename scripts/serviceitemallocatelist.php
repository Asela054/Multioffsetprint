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
$table = 'tbl_machine_service_allocated_items';

// Table's primary key
$primaryKey = 'idtbl_machine_service_allocated_items';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`ub`.`machine`', 'dt' => 'machine', 'field' => 'machine' ),
	array( 'db' => '`uc`.`type`', 'dt' => 'type', 'field' => 'type' ),
	array( 'db' => '`ua`.`idtbl_machine_service`', 'dt' => 'idtbl_machine_service', 'field' => 'idtbl_machine_service' ),
	array( 'db' => '`ua`.`job_type`', 'dt' => 'job_type', 'field' => 'job_type' ),
	array( 'db' => '`ua`.`sevice_date_to`', 'dt' => 'sevice_date_to', 'field' => 'sevice_date_to' ),
	array( 'db' => '`ua`.`service_date_from`', 'dt' => 'service_date_from', 'field' => 'service_date_from' ),
	array( 'db' => '`ua`.`factory_code`', 'dt' => 'factory_code', 'field' => 'factory_code' ),
	array( 'db' => '`ua`.`estimated_sevice_hours`', 'dt' => 'estimated_sevice_hours', 'field' => 'estimated_sevice_hours' ),
	array( 'db' => '`ua`.`tbl_machine_idtbl_machine`', 'dt' => 'tbl_machine_idtbl_machine', 'field' => 'tbl_machine_idtbl_machine' ),
	array( 'db' => '`ua`.`tbl_machine_type_idtbl_machine_type`', 'dt' => 'tbl_machine_type_idtbl_machine_type', 'field' => 'tbl_machine_type_idtbl_machine_type' ),
	array( 'db' => '`ua`.`status`', 'dt' => 'status', 'field' => 'status' ),
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

$joinQuery = "FROM `tbl_machine_service_allocated_items` AS `u` LEFT JOIN `tbl_machine_service` AS `ua` ON (`ua`.`idtbl_machine_service` = `u`.`tbl_machine_service_idtbl_machine_service`) LEFT JOIN `tbl_machine` AS `ub` ON (`ub`.`idtbl_machine` = `ua`.`tbl_machine_idtbl_machine`) LEFT JOIN `tbl_machine_type` AS `uc` ON (`uc`.`idtbl_machine_type` = `ua`.`tbl_machine_type_idtbl_machine_type`)";

$extraWhere = "`u`.`status` IN (1, 2) GROUP BY `u`.`tbl_machine_service_idtbl_machine_service`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
