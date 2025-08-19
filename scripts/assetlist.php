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
$table = 'tbl_asset';

// Table's primary key
$primaryKey = 'idtbl_asset';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_asset`', 'dt' => 'idtbl_asset', 'field' => 'idtbl_asset' ),
	array( 'db' => '`u`.`Purchase_date`', 'dt' => 'Purchase_date', 'field' => 'Purchase_date' ),
	array( 'db' => '`u`.`purchase_price`', 'dt' => 'purchase_price', 'field' => 'purchase_price' ),
	array( 'db' => '`u`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`u`.`code`', 'dt' => 'code', 'field' => 'code' ),
	array( 'db' => '`ua`.`sub_category`', 'dt' => 'sub_category', 'field' => 'sub_category' ),
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

$joinQuery = "FROM `tbl_asset` AS `u` JOIN `tbl_assetsub_category` AS `ua` ON (`ua`.`idtbl_assetsub_category` = `u`.`tbl_assetsub_category_idtbl_assetsub_category`)";
$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`depreciation_ststus` = 0 ";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
