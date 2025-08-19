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
$table = 'tbl_service_order';

// Table's primary key
$primaryKey = 'idtbl_service_order';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_service_order`', 'dt' => 'idtbl_service_order', 'field' => 'idtbl_service_order' ),
	array( 'db' => '`u`.`comment`', 'dt' => 'comment', 'field' => 'comment' ),
	array( 'db' => '`vehicle`.`vehicle_reg_no`', 'dt' => 'vehicle_reg_no', 'field' => 'vehicle_reg_no' ),
    array( 'db' => '`supplier`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
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

$joinQuery = "FROM `tbl_service_order` AS `u` JOIN `tbl_vehicle` AS vehicle ON (`u`.`tbl_vehicle_idtbl_vehicle`=`vehicle`.`idtbl_vehicle`)
JOIN `tbl_supplier` AS supplier ON (`u`.`tbl_supplier_idtbl_supplier`=`supplier`.`idtbl_supplier`)";
$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`approvestatus` = '0'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
