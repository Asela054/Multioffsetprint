<?php

$table = 'tbl_print_dispatch';

$primaryKey = 'idtbl_print_dispatch';

$columns = array(
    array('db' => 'u.idtbl_print_dispatch', 'dt' => 'idtbl_print_dispatch', 'field' => 'idtbl_print_dispatch'),
    array('db' => 'u.date', 'dt' => 'date', 'field' => 'date'),
    array('db' => 'u.ponum', 'dt' => 'ponum', 'field' => 'ponum'),
    array('db' => 'ua.job', 'dt' => 'job', 'field' => 'job'),
    array('db' => 'ua.job_no', 'dt' => 'job_no', 'field' => 'job_no'),
    array('db' => 'ub.customer', 'dt' => 'customer', 'field' => 'customer'),
    array('db' => 'u.tbl_customerinquiry_idtbl_customerinquiry', 'dt' => 'tbl_customerinquiry_idtbl_customerinquiry', 'field' => 'tbl_customerinquiry_idtbl_customerinquiry'),
);

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

$whereConds = array();
$whereConds[] = "u.invoice_status IN (0)";

// company filter
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;
$whereConds[] = "u.tbl_company_idtbl_company='".$companyID."'";

$customer = isset($_POST['customer']) ? $conn->real_escape_string($_POST['customer']) : '';
if ($customer !== '' && $customer !== 'all') {
    $whereConds[] = "u.tbl_customer_idtbl_customer = '$customer'";
}

if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {
    $from = $conn->real_escape_string($_POST['search_from_date']);
    $to = $conn->real_escape_string($_POST['search_to_date']);
    $whereConds[] = "u.date BETWEEN '$from' AND '$to'";
} elseif (!empty($_POST['search_month'])) {
    $month = $conn->real_escape_string($_POST['search_month']);
    $month_arr = explode('-', $month);
    $whereConds[] = "YEAR(u.date)='{$month_arr[0]}' AND MONTH(u.date)='{$month_arr[1]}'";
} elseif (!empty($_POST['search_week'])) {
    $week = $conn->real_escape_string($_POST['search_week']);
    $weeksep = explode('-W', $week);
    $year = $weeksep[0];
    $week1 = $weeksep[1];

    $dto = new DateTime();
    $dto->setISODate($year, $week1);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');

    $whereConds[] = "u.date BETWEEN '$startDate' AND '$endDate'";
} elseif (!empty($_POST['search_date'])) {
    $date = $conn->real_escape_string($_POST['search_date']);
    $whereConds[] = "u.date = '$date'";
}

if (!empty($_POST['job'])) {
    $job = $conn->real_escape_string($_POST['job']);
    $whereConds[] = "(ua.job LIKE '%$job%' OR ua.job_no LIKE '%$job%')";
}

$conn->close();

$whereClause = implode(' AND ', $whereConds);

$joinQuery = "FROM tbl_print_dispatch AS u 
            LEFT JOIN (SELECT * FROM tbl_print_dispatchdetail AS ua GROUP BY ua.tbl_print_dispatch_idtbl_print_dispatch) AS ua ON (ua.tbl_print_dispatch_idtbl_print_dispatch=u.idtbl_print_dispatch) 
            JOIN tbl_customer AS ub ON (ub.idtbl_customer=u.tbl_customer_idtbl_customer) 
            WHERE $whereClause";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);