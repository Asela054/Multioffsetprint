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
$table = 'tbl_service';

// Table's primary key
$primaryKey = 'idtbl_service';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

	array( 'db' => '`uc`.`service_type`', 'dt' => 'service_type', 'field' => 'service_type' ),
    array( 'db' => '`u`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity' ),
    // array( 'db' => '`u`.`amount`', 'dt' => 'amount', 'field' => 'amount' )
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


                        
if(!empty($_POST['search_from_date'] && $_POST['search_to_date'] && $_POST['search_vehicle'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $vehicleregno = $_POST['search_vehicle'];
    $servicetype = $_POST['search_type'];

    $joinQuery = "FROM `tbl_service_details` AS `u` JOIN `tbl_service` AS `ua` ON (`ua`.`idtbl_service` = `u`.`tbl_service_idtbl_service`)  JOIN `tbl_vehicle` AS `ub` ON (`ub`.`idtbl_vehicle`=`ua`.`tbl_vehicle_idtbl_vehicle`) JOIN `tbl_service_item_list` AS `uc` ON (`uc`.`idtbl_service_item_list`=`u`.`tbl_service_item_list_idtbl_service_item_list`) WHERE `u`.`status` IN (1,2) AND `ua`.`service_date`BETWEEN '$from_date' and '$to_date' AND ua.tbl_vehicle_idtbl_vehicle = '$vehicleregno'  AND ua.servicetype = '$servicetype' ";


}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);
