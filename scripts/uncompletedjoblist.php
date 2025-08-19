<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
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
$table = 'tbl_customerinquiry';

// Table's primary key
$primaryKey = 'idtbl_customerinquiry';

// Array of database columns which should be read and sent back to DataTables.
// The db parameter represents the column name in the database, while the dt
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'u.idtbl_customerinquiry', 'dt' => 'idtbl_customerinquiry', 'field' => 'idtbl_customerinquiry'),
    array('db' => 'u.date', 'dt' => 'date', 'field' => 'date'),
    array('db' => 'u.po_number', 'dt' => 'po_number', 'field' => 'po_number'),
    array('db' => 'ua.job', 'dt' => 'job', 'field' => 'job'),
    array('db' => 'ua.qty', 'dt' => 'qty', 'field' => 'qty'),
    array('db' => 'ua.uom', 'dt' => 'uom', 'field' => 'uom'),
    array('db' => 'ub.customer', 'dt' => 'customer', 'field' => 'customer'),
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

// Include your customized SSP class
require('ssp.customized.class.php');

// Initialize joinQuery variable
$joinQuery = '';

// Process POST data to build the query
if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date']) && !empty($_POST['customer'])) {
    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $customer = $_POST['customer'];

    if ($customer == "all") {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND u.date BETWEEN '$from_date' AND '$to_date' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0)";
    } else {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND u.date BETWEEN '$from_date' AND '$to_date' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0) 
            AND u.tbl_customer_idtbl_customer = '$customer'";
    }
} elseif (!empty($_POST['search_month'])) {
    $month = $_POST['search_month'];
    $month_arr = explode('-', $month);
    $customer = $_POST['customer'];

    if ($customer == "all") {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND YEAR(u.date)='$month_arr[0]' AND MONTH(u.date)='$month_arr[1]' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0)";
    } else {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND YEAR(u.date)='$month_arr[0]' AND MONTH(u.date)='$month_arr[1]' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0) 
            AND u.tbl_customer_idtbl_customer='$customer'";
    }
} elseif (!empty($_POST['search_week'])) {
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

    if ($customer == "all") {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND u.date BETWEEN '$startDate' AND '$endDate' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0)";
    } else {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND u.date BETWEEN '$startDate' AND '$endDate' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0) 
            AND u.tbl_customer_idtbl_customer='$customer'";
    }
} elseif (!empty($_POST['search_date'])) {
    $date = $_POST['search_date'];
    $customer = $_POST['customer'];

    if ($customer == "all") {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND u.date = '$date' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0)";
    } else {
        $joinQuery = "FROM tbl_customerinquiry AS u 
            LEFT JOIN tbl_customerinquiry_detail AS ua ON ua.tbl_customerinquiry_idtbl_customerinquiry = u.idtbl_customerinquiry 
            JOIN tbl_customer AS ub ON ub.idtbl_customer = u.tbl_customer_idtbl_customer 
            WHERE u.status = 1 AND u.date = '$date' 
            AND (ua.job_finish_status = 0 AND ua.actual_qty <= 0) 
            AND u.tbl_customer_idtbl_customer='$customer'";
    }
}

// Fetch data using SSP::simple with the customized joinQuery
echo json_encode(SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery));
?>
