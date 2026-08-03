<?php

/*
 * DataTables server-side processing for the Unfinished Jobs report
 */

$table = 'tbl_customerinquiry_detail';
$primaryKey = 'idtbl_customerinquiry_detail';

$columns = array(
    array('db' => 'u.idtbl_customerinquiry_detail', 'dt' => 'idtbl_customerinquiry_detail', 'field' => 'idtbl_customerinquiry_detail'),
    array('db' => 'uc.customer',    'dt' => 'customer',      'field' => 'customer'),
    array( 'db' => '`ub`.`date`', 'dt' => 'inquiry_date', 'field' => 'inquiry_date', 'as' => 'inquiry_date' ),
    array('db' => 'u.job_no',       'dt' => 'job_no',        'field' => 'job_no'),
    array('db' => 'u.job',          'dt' => 'job',           'field' => 'job'),
    array('db' => 'ub.po_number',   'dt' => 'po_number',     'field' => 'po_number'),
    array('db' => 'u.qty',          'dt' => 'qty',           'field' => 'qty'),
    array('db' => 'u.uom',          'dt' => 'uom',           'field' => 'uom'),
    array('db' => 'ue.dispatch_no', 'dt' => 'dispatch_no',   'field' => 'dispatch_no'),
    array( 'db' => '`ue`.`date`', 'dt' => 'dispatch_date', 'field' => 'dispatch_date', 'as' => 'dispatch_date' ),
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

// Get company_id passed from the view (which reads it from the CI session)
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;

$whereConds = array();
$whereConds[] = "u.status IN (1)";
$whereConds[] = "u.job_finish_status = 0"; // unfinished job flag
$whereConds[] = "ub.status IN (1)";
$whereConds[] = "ub.tbl_company_idtbl_company='".$companyID."'";

$customer = isset($_POST['customer']) ? $conn->real_escape_string($_POST['customer']) : '';
if ($customer !== '' && $customer !== 'all') {
    $whereConds[] = "ub.tbl_customer_idtbl_customer = '$customer'";
}

if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {
    $from = $conn->real_escape_string($_POST['search_from_date']);
    $to = $conn->real_escape_string($_POST['search_to_date']);
    $whereConds[] = "ub.date BETWEEN '$from' AND '$to'";
}

if (!empty($_POST['job'])) {
    $job = $conn->real_escape_string($_POST['job']);
    $whereConds[] = "(u.job LIKE '%$job%' OR u.job_no LIKE '%$job%')";
}

$conn->close();

$extraWhere = implode(' AND ', $whereConds);

$joinQuery = "FROM tbl_customerinquiry_detail AS u
            JOIN tbl_customerinquiry AS ub ON (ub.idtbl_customerinquiry = u.tbl_customerinquiry_idtbl_customerinquiry)
            JOIN tbl_customer AS uc ON (uc.idtbl_customer = ub.tbl_customer_idtbl_customer)
            LEFT JOIN (SELECT * FROM tbl_print_dispatchdetail AS x WHERE x.status IN (1,2) GROUP BY x.job_no) AS ud ON (ud.job_no = u.job_no)
            LEFT JOIN tbl_print_dispatch AS ue ON (ue.idtbl_print_dispatch = ud.tbl_print_dispatch_idtbl_print_dispatch AND ue.tbl_customerinquiry_idtbl_customerinquiry = ub.idtbl_customerinquiry AND ue.status IN (1,2))";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);