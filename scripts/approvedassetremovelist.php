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
$table = 'tbl_asset_remove';

// Table's primary key
$primaryKey = 'idtbl_asset_remove';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_asset_remove`', 'dt' => 'idtbl_asset_remove', 'field' => 'idtbl_asset_remove' ),
	array( 'db' => '`u`.`removetype`', 'dt' => 'removetype', 'field' => 'removetype' ),
	array( 'db' => '`u`.`remove_date`', 'dt' => 'remove_date', 'field' => 'remove_date' ),
	array( 'db' => '`u`.`asset_valuability`', 'dt' => 'asset_valuability', 'field' => 'asset_valuability' ),
	array( 'db' => '`ub`.`sub_category`', 'dt' => 'sub_category', 'field' => 'sub_category' ),
	array( 'db' => '`u`.`approve_status`', 'dt' => 'approve_status', 'field' => 'approve_status' ),
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

$joinQuery = "FROM `tbl_asset_remove` AS `u` JOIN `tbl_asset_depreciation` AS `uc` ON (`uc`.`idtbl_asset_depreciation` = `u`.`tbl_asset_depreciation_idtbl_asset_depreciation`)
								JOIN `tbl_asset` AS `ua` ON (`ua`.`idtbl_asset` = `uc`.`tbl_asset_idtbl_asset`)
								JOIN `tbl_assetsub_category` AS `ub` ON (`ub`.`idtbl_assetsub_category` = `ua`.`tbl_assetsub_category_idtbl_assetsub_category`)  ";
$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`approve_status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
