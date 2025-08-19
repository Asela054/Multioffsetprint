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
$table = 'tbl_print_grn';

// Table's primary key
$primaryKey = 'idtbl_print_grn';

// Array of database columns which should be read and sent back to DataTables.
// The db parameter represents the column name in the database, while the dt
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'u.idtbl_print_grn', 'dt' => 'idtbl_print_grn', 'field' => 'idtbl_print_grn'),
    array('db' => 'ua.suppliername', 'dt' => 'suppliername', 'field' => 'suppliername'),
    array('db' => 'u.batchno', 'dt' => 'batchno', 'field' => 'batchno'),
    array('db' => 'u.grndate', 'dt' => 'grndate', 'field' => 'grndate'),
    array('db' => 'u.invoicenum', 'dt' => 'invoicenum', 'field' => 'invoicenum'),
    array('db' => 'u.total', 'dt' => 'total', 'field' => 'total')

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

if(!empty($_POST['search_from_date'] && $_POST['search_to_date'] && $_POST['supplier'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $supplier = $_POST['supplier'];

	if($supplier=="all"){
		$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1) AND u.approvestatus = '1' AND u.`grndate`BETWEEN '$from_date' and '$to_date' ";
	}
   else{
	$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1,2) AND u.approvestatus = '1' AND u.`grndate`BETWEEN '$from_date' and '$to_date' AND u.tbl_supplier_idtbl_supplier = '$supplier'";
	}
}elseif (!empty($_POST['search_month'])) {
    $month = $_POST['search_month'];
    $month_arr = explode('-', $month);
    $supplier = $_POST['supplier'];

    if($supplier=="all"){
		$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1) AND u.approvestatus = '1' AND  YEAR(u.grndate) ='$month_arr[0]' AND Month(u.grndate) = '$month_arr[1]'";
	}
   else{
	$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1) AND u.approvestatus = '1' AND  YEAR(u.grndate) ='$month_arr[0]' AND Month(u.grndate) = '$month_arr[1]' AND u.tbl_supplier_idtbl_supplier = '$supplier'";
   }
}elseif (!empty($_POST['search_week'])) {
    $week = $_POST['search_week'];
    $supplier = $_POST['supplier'];

    $weeksep = explode('-W', $week);

    $year = $weeksep[0];
    $week1 = $weeksep[1];

    $dto = new DateTime();
    $dto->setISODate($year, $week1);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');

    if($supplier=="all"){
		$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1) AND u.approvestatus = '1' AND u.`grndate`BETWEEN '$startDate' AND '$endDate' ";

	}
   else{
	$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1,2) AND u.approvestatus = '1' AND u.`grndate`BETWEEN '$startDate' AND '$endDate' AND u.tbl_supplier_idtbl_supplier='$supplier'";

	
   }
}elseif (!empty($_POST['search_date'])) {
    $date = $_POST['search_date'];
    $supplier = $_POST['supplier'];

    if($supplier=="all"){
		$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1) AND u.approvestatus = '1' AND u.grndate = '$date'";

	}
   else{
	$joinQuery = "FROM tbl_print_grn AS u JOIN tbl_supplier AS ua ON (ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier)  WHERE u.status IN (1,2) AND u.approvestatus = '1' AND u.grndate = '$date' AND u.tbl_supplier_idtbl_supplier='$supplier'";

	
   }

}
   echo json_encode(
      SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
   );