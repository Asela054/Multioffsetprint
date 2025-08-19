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
$table = 'tbl_print_invoice';

// Table's primary key
$primaryKey = 'idtbl_print_invoice';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => '`u`.`idtbl_print_invoice`', 'dt' => 'idtbl_print_invoice', 'field' => 'idtbl_print_invoice'),
    array('db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date'),
    array('db' => '`ua`.`customer`', 'dt' => 'customer', 'field' => 'customer'),
    // array('db' => '`ua`.`vat_no`', 'dt' => 'vat_no', 'field' => 'vat_no'),
    array('db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total'),
    // array('db' => '`ub`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname'),
    // array('db' => '`u`.`vat_amount`', 'dt' => 'vat_amount', 'field' => 'vat_amount')
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
require('ssp.customized.class.php');


if(!empty($_POST['search_from_date'] && $_POST['search_to_date'] && $_POST['customer'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $customer = $_POST['customer'];
	// $ser_type = $_POST['search_type'];

	if($customer=="all"){
		$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND `u`.`date`BETWEEN '$from_date' and '$to_date' ";

		// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
	}
   else{
	$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND `u`.`date`BETWEEN '$from_date' and '$to_date' AND u.customer_id = '$customer'";

	
	// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
   }
}elseif (!empty($_POST['search_month'])) {
    $month = $_POST['search_month'];
    $month_arr = explode('-', $month);
    $customer = $_POST['customer'];

    if($customer=="all"){
		$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND  YEAR(`u`.date) ='$month_arr[0]' AND Month(`u`.date) = '$month_arr[1]'";
		// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
	}
   else{
	$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND  YEAR(`u`.date) ='$month_arr[0]' AND Month(`u`.date) = '$month_arr[1]' AND u.customer_id = '$customer'";

	
	// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
   }
}elseif (!empty($_POST['search_week'])) {
    $week = $_POST['search_week'];
    $customer = $_POST['customer'];

    $weeksep = explode('-W', $week);

    $year = $weeksep[0];
    $week1 = $weeksep[1];

    $dto = new DateTime();
    $dto->setISODate($year, $week1);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');

    if($customer=="all"){
		$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND `u`.`date`BETWEEN '$startDate' AND '$endDate' ";

		// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
	}
   else{
	$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND `u`.`date`BETWEEN '$startDate' AND '$endDate' AND `u`.`customer_id`='$customer'";

	
	// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
   }
}elseif (!empty($_POST['search_date'])) {
    $date = $_POST['search_date'];
    $customer = $_POST['customer'];

    if($customer=="all"){
		$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND `u`.`date` = '$date'";

		// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
	}
   else{
	$joinQuery = "FROM `tbl_print_invoice` AS `u` JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status` IN (3) AND `u`.`date` = '$date' AND `u`.`customer_id`='$customer'";

	
	// $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
   }


}








echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);