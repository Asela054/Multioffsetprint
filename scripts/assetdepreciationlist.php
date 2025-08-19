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
$table = 'tbl_asset_depreciation';

// Table's primary key
$primaryKey = 'idtbl_asset_depreciation';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_asset_depreciation`', 'dt' => 'idtbl_asset_depreciation', 'field' => 'idtbl_asset_depreciation' ),
	array( 'db' => '`u`.`purchest_price`', 'dt' => 'purchest_price', 'field' => 'purchest_price' ),
	array( 'db' => '`u`.`depreciation_affective_date`', 'dt' => 'depreciation_affective_date', 'field' => 'depreciation_affective_date' ),
	array( 'db' => '`u`.`depreciation_months`', 'dt' => 'depreciation_months', 'field' => 'depreciation_months' ),
	array( 'db' => '`ub`.`sub_category`', 'dt' => 'sub_category', 'field' => 'sub_category' ),
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

$joinQuery = "FROM `tbl_asset_depreciation` AS `u` JOIN `tbl_asset` AS `ua` ON (`ua`.`idtbl_asset` = `u`.`tbl_asset_idtbl_asset`)
                                                   JOIN `tbl_assetsub_category` AS `ub` ON (`ub`.`idtbl_assetsub_category` = `ua`.`tbl_assetsub_category_idtbl_assetsub_category`)  ";
$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
