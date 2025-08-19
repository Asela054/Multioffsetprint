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
	array( 'db' => '`u`.`idtbl_print_invoice`', 'dt' => 'idtbl_print_invoice', 'field' => 'idtbl_print_invoice' ),
   array( 'db' => '`u`.`inv_no`', 'dt' => 'inv_no', 'field' => 'inv_no' ),
   array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
    array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
    array( 'db' => '`ua`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
    array( 'db' => '`ub`.`amount`', 'dt' => 'amount', 'field' => 'amount' ),
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

$joinQuery = "FROM `tbl_print_invoice` AS `u`
              LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)
              LEFT JOIN `tbl_receivable_info` AS `ub` ON (`u`.`idtbl_print_invoice` = `ub`.`invoiceno`)";
 
if(!empty($_POST['search_date'])){ 
    $date = $_POST['search_date'];
    $customer = $_POST['customer'];
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.date = '$date' AND `ua`.`idtbl_customer` = '$customer' AND `ub`.`amount` < `u`.`total`";

}elseif (!empty($_POST['search_week'])){
    $week = $_POST['search_week'];
    $customer = $_POST['customer'];
    
    $weeksep=explode('-W', $week);
    
    $year=$weeksep[0];
    $week1=$weeksep[1];
    
    $dto = new DateTime();
    $dto->setISODate($year, $week1);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');
    
    $extraWhere = "`u`.`status` IN (0,1) AND `ua`.`idtbl_customer` = '$customer' AND `u`.date BETWEEN '$startDate' AND '$endDate' AND `ub`.`amount` < `u`.`total`";

}elseif(!empty($_POST['search_month'])){
    $month = $_POST['search_month'];
    $customer = $_POST['customer'];
    $month_arr = explode('-',$month);
    $extraWhere = "`u`.`status` IN (0,1) AND `ua`.`idtbl_customer` = '$customer' AND YEAR(`u`.date) = '$month_arr[0]' AND Month(`u`.date) = '$month_arr[1]' AND `ub`.`amount` < `u`.`total`";

}elseif(!empty($_POST['search_from_date'] && $_POST['search_to_date'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $customer = $_POST['customer'];

    $extraWhere = "`u`.`status` IN (1,2) AND `ua`.`idtbl_customer` = '$customer' AND `u`.date BETWEEN '$from_date' AND '$to_date' AND `ub`.`amount` < `u`.`total`";

}elseif ($_POST['all'] == 1) {
    $extraWhere = "`ub`.`amount` < `u`.`total`";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
);