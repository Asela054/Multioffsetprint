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
$table = 'tbl_vehicle';

// Table's primary key
$primaryKey = 'idtbl_vehicle';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	
	array( 'db' => '`ub`.`next_renew_date`', 'dt' => 'next_renew_date', 'field' => 'next_renew_date' ),
    array( 'db' => '`u`.`amount`', 'dt' => 'amount', 'field' => 'amount' ),
    array( 'db' => '`u`.`service_date`', 'dt' => 'service_date', 'field' => 'service_date' ),
    array( 'db' => '`u`.`servicetype`', 'dt' => 'servicetype', 'field' => 'servicetype' ),
    array( 'db' => '`uc`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`u`.`next_service_mileage`', 'dt' => 'next_service_mileage', 'field' => 'next_service_mileage' ),
	array( 'db' => '`ua`.`mileage`', 'dt' => 'mileage', 'field' => 'mileage' ),
	array( 'db' => '`ua`.`vehicle_reg_no`', 'dt' => 'vehicle_reg_no', 'field' => 'vehicle_reg_no' )
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




// $joinQuery = "SELECT ub.next_renew_date, ub.amount, u.service_date, u.servicetype, u.next_service_mileage, ub.mileage, ub.vehicle_reg_no
// FROM tbl_renew_details rd
// INNER JOIN tbl_service s ON s.tbl_vehicle_idtbl_vehicle = rd.tbl_vehicle_idtbl_vehicle
// INNER JOIN tbl_vehicle v ON v.idtbl_vehicle = s.tbl_vehicle_idtbl_vehicle;";

if(!empty($_POST['search_from_date'] && $_POST['search_to_date'] && $_POST['search_vehicle'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $vehicleregno = $_POST['search_vehicle'];
	// $ser_type = $_POST['search_type'];

	if($vehicleregno=="all"){
		$joinQuery = "FROM `tbl_service` AS `u` JOIN `tbl_vehicle` AS `ua` ON (`ua`.`idtbl_vehicle` = `u`.`tbl_vehicle_idtbl_vehicle`) LEFT JOIN `tbl_renew_details` AS `ub` ON (`ub`.`tbl_vehicle_idtbl_vehicle`=`ua`.`idtbl_vehicle`) JOIN `tbl_supplier` AS `uc` ON (`uc`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) WHERE `u`.`status` IN (1) AND `u`.`service_date`BETWEEN '$from_date' and '$to_date' ";

		// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
	}
   else{
	$joinQuery = "FROM `tbl_service` AS `u` JOIN `tbl_vehicle` AS `ua` ON (`ua`.`idtbl_vehicle` = `u`.`tbl_vehicle_idtbl_vehicle`) LEFT JOIN `tbl_renew_details` AS `ub` ON (`ub`.`tbl_vehicle_idtbl_vehicle`=`ua`.`idtbl_vehicle`) JOIN `tbl_supplier` AS `uc` ON (`uc`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier` ) WHERE `u`.`status` IN (1,2) AND `u`.`service_date`BETWEEN '$from_date' and '$to_date' AND u.tbl_vehicle_idtbl_vehicle = '$vehicleregno'  GROUP BY `u`.`servicetype`";

	
	// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
   }




}elseif(!empty($_POST['search_from_date'] && $_POST['search_to_date'] && $_POST['search_supplier'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $supplier = $_POST['search_supplier'];
	// $ser_type = $_POST['search_type'];

	if($supplier=="all"){
		$joinQuery = "FROM `tbl_service` AS `u` JOIN `tbl_vehicle` AS `ua` ON (`ua`.`idtbl_vehicle` = `u`.`tbl_vehicle_idtbl_vehicle`) LEFT JOIN `tbl_renew_details` AS `ub` ON (`ub`.`tbl_vehicle_idtbl_vehicle`=`ua`.`idtbl_vehicle`) JOIN `tbl_supplier` AS `uc` ON (`uc`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) WHERE `u`.`service_date`BETWEEN '$from_date' and '$to_date' ";

		// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
	}
   else{
	$joinQuery = "FROM `tbl_service` AS `u` JOIN `tbl_vehicle` AS `ua` ON (`ua`.`idtbl_vehicle` = `u`.`tbl_vehicle_idtbl_vehicle`) LEFT JOIN `tbl_renew_details` AS `ub` ON (`ub`.`tbl_vehicle_idtbl_vehicle`=`ua`.`idtbl_vehicle`) JOIN `tbl_supplier` AS `uc` ON (`uc`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier` ) WHERE `u`.`status` IN (1,2) AND `u`.`service_date` BETWEEN '$from_date' and '$to_date' AND u.tbl_supplier_idtbl_supplier = '$supplier' ";

	
	// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
   }




}
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);