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
$table = 'tbl_machine';

// Table's primary key
$primaryKey = 'idtbl_machine';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`ub`.`idtbl_machine_allocation`', 'dt' => 'idtbl_machine_allocation', 'field' => 'idtbl_machine_allocation' ),
	array( 'db' => '`u`.`machine`', 'dt' => 'machine', 'field' => 'machine' ),
	array( 'db' => '`ub`.`startdatetime`', 'dt' => 'startdatetime', 'field' => 'startdatetime' ),
    array( 'db' => '`ub`.`enddatetime`', 'dt' => 'enddatetime', 'field' => 'enddatetime' ),
    array( 'db' => '`ub`.`completed_status`', 'dt' => 'completed_status', 'field' => 'completed_status' ),
    array( 'db' => 'SUM(`uc`.`completedqty`) AS completedqty_sum', 'dt' => 'completedqty_sum', 'field' => 'completedqty_sum' ),
    array( 'db' => 'SUM(`uc`.`wastageqty`) AS wastageqty_sum', 'dt' => 'wastageqty_sum', 'field' => 'wastageqty_sum' ),
	array( 'db' => '`ue`.`special_id`', 'dt' => 'special_id', 'field' => 'special_id' ),
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

$joinQuery = "FROM `tbl_machine` AS `u` JOIN `tbl_machine_allocation` AS `ub` ON (`u`.`idtbl_machine` = `ub`.`tbl_machine_idtbl_machine`) LEFT JOIN `tbl_machine_allocation_details` AS `uc` ON (`ub`.`idtbl_machine_allocation` = `uc`.`tbl_machine_allocation_idtbl_machine_allocation`) JOIN `tbl_cost_items` AS `ud` ON (`ud`.`idtbl_cost_items` = `ub`.`tbl_cost_items_idtbl_cost_items`) JOIN `tbl_delivery_plan_details` AS `ue` ON (`ue`.`idtbl_delivery_plan_details` = `ub`.`tbl_delivery_plan_details_idtbl_delivery_plan_details`)";

$extraWhere = "`ub`.`status` IN (1)";
$groupBy ="`ub`.`idtbl_machine_allocation`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
