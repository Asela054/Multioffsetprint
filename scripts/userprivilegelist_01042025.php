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
$table = 'permissions_machines';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`id`', 'dt' => 'idtbl_user_privilege', 'field' => 'id' ),
	array( 'db' => '`ua`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`ub`.`menu`', 'dt' => 'menu', 'field' => 'menu' ),
	array( 'db' => '`u`.`create`', 'dt' => 'create', 'field' => 'create' ),
	array( 'db' => '`u`.`update`', 'dt' => 'edit', 'field' => 'update' ),
	array( 'db' => '`u`.`statuschange`', 'dt' => 'statuschange', 'field' => 'statuschange' ),
	array( 'db' => '`u`.`delete`', 'dt' => 'remove', 'field' => 'delete' ),
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

$joinQuery = "FROM `permissions_machines` AS `u` JOIN `users` AS `ua` ON (`ua`.`id` = `u`.`idtbl_user_tbl_user`) JOIN `tbl_menu_list` AS `ub` ON (`ub`.`idtbl_menu_list` = `u`.`idtbl_menu`)";

if($_POST['userID']==1){
    $extraWhere = "`u`.`status` IN (1, 2) AND `u`.`idtbl_menu`!=0";
}
else{
    $extraWhere = "`u`.`status` IN (1, 2) AND `ua`.`idtbl_user_tbl_user`!=1 AND `u`.`idtbl_menu`!=0";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
