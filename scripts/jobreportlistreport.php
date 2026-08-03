<?php

/*
 * DataTables server-side processing for the Job Report
 * (same shape as scripts/uninvoicedalistreport.php)
 */

// DB table to use
$table = 'tbl_customerinquiry';

// Table's primary key
$primaryKey = 'idtbl_customerinquiry';

// Columns read and sent back to DataTables
$columns = array(
    array('db' => 'u.idtbl_customerinquiry', 'dt' => 'idtbl_customerinquiry', 'field' => 'idtbl_customerinquiry'),
    array('db' => 'ub.customer', 'dt' => 'customer', 'field' => 'customer'),
    array('db' => 'u.date', 'dt' => 'date', 'field' => 'date'),
    array('db' => 'ua.job_no', 'dt' => 'job_no', 'field' => 'job_no'),
    array('db' => 'ua.job', 'dt' => 'job', 'field' => 'job'),
    array('db' => 'u.po_number', 'dt' => 'po_number', 'field' => 'po_number'),
    array('db' => 'ua.qty', 'dt' => 'qty', 'field' => 'qty'),
    array('db' => 'ua.uom', 'dt' => 'uom', 'field' => 'uom'),
    array('db' => 'u.approvestatus', 'dt' => 'approvestatus', 'field' => 'approvestatus'),
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php');

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die(json_encode(array('error' => 'Database connection failed')));
}

// Get company_id passed from the view (which reads it from the CI session)
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;

// build dynamic WHERE clause based on posted filters
$whereConds = array();
$whereConds[] = "u.status IN (1)";
$whereConds[] = "u.tbl_company_idtbl_company='".$companyID."'";

$customer = isset($_POST['customer']) ? $conn->real_escape_string($_POST['customer']) : '';
if ($customer !== '' && $customer !== 'all') {
    $whereConds[] = "u.tbl_customer_idtbl_customer = '$customer'";
}

if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {
    $from = $conn->real_escape_string($_POST['search_from_date']);
    $to = $conn->real_escape_string($_POST['search_to_date']);
    $whereConds[] = "u.date BETWEEN '$from' AND '$to'";
}

if (!empty($_POST['job'])) {
    $job = $conn->real_escape_string($_POST['job']);
    $whereConds[] = "(ua.job LIKE '%$job%' OR ua.job_no LIKE '%$job%')";
}

$conn->close();

$extraWhere = implode(' AND ', $whereConds);

$joinQuery = "FROM tbl_customerinquiry AS u
            LEFT JOIN (SELECT * FROM tbl_customerinquiry_detail AS ua WHERE ua.status=1 GROUP BY ua.tbl_customerinquiry_idtbl_customerinquiry) AS ua ON (ua.tbl_customerinquiry_idtbl_customerinquiry=u.idtbl_customerinquiry)
            JOIN tbl_customer AS ub ON (ub.idtbl_customer=u.tbl_customer_idtbl_customer)";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);