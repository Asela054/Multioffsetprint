<?php

/*
 * DataTables server-side processing for the Job Material Issue Report
 */

// DB table to use
$table = 'tbl_jobcard_issue_meterial';

// Table's primary key
$primaryKey = 'idtbl_jobcard_issue_meterial';

// Columns read and sent back to DataTables
$columns = array(
    array('db' => 'u.idtbl_jobcard_issue_meterial', 'dt' => 'idtbl_jobcard_issue_meterial', 'field' => 'idtbl_jobcard_issue_meterial'),
    array('db' => 'uc.customer', 'dt' => 'customer', 'field' => 'customer'),
    array('db' => 'u.issuedate', 'dt' => 'issuedate', 'field' => 'issuedate'),
    array('db' => 'COALESCE(uj.jobcardno, ujm.jobcardno)', 'dt' => 'jobcardno', 'field' => 'jobcardno', 'as' => 'jobcardno'),
    array('db' => 'COALESCE(uj.job_description, ujm.job_description)', 'dt' => 'job_description', 'field' => 'job_description', 'as' => 'job_description'),
    array('db' => 'u.sectiontype', 'dt' => 'sectiontype', 'field' => 'sectiontype'),
    array('db' => 'um.materialname', 'dt' => 'materialname', 'field' => 'materialname'),
    array('db' => 'u.batchno', 'dt' => 'batchno', 'field' => 'batchno'),
    array('db' => 'u.reqissueqty', 'dt' => 'reqissueqty', 'field' => 'reqissueqty'),
    array('db' => 'u.issueqty', 'dt' => 'issueqty', 'field' => 'issueqty'),
    array('db' => 'u.unitprice', 'dt' => 'unitprice', 'field' => 'unitprice'),
    array('db' => '(u.issueqty * u.unitprice)', 'dt' => 'total', 'field' => 'total', 'as' => 'total'),
    array('db' => 'u.status', 'dt' => 'status', 'field' => 'status'),
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
$whereConds[] = "u.status IN (2)";
$whereConds[] = "COALESCE(uj.tbl_company_idtbl_company, ujm.tbl_company_idtbl_company) = '".$companyID."'";

$customer = isset($_POST['customer']) ? $conn->real_escape_string($_POST['customer']) : '';
if ($customer !== '' && $customer !== 'all') {
    $whereConds[] = "COALESCE(uj.tbl_customer_idtbl_customer, ujm.tbl_customer_idtbl_customer) = '$customer'";
}

if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {
    $from = $conn->real_escape_string($_POST['search_from_date']);
    $to = $conn->real_escape_string($_POST['search_to_date']);
    $whereConds[] = "u.issuedate BETWEEN '$from' AND '$to'";
}

if (!empty($_POST['job'])) {
    $job = $conn->real_escape_string($_POST['job']);
    $whereConds[] = "(uj.jobcardno LIKE '%$job%' OR ujm.jobcardno LIKE '%$job%')";
}

$conn->close();

$extraWhere = implode(' AND ', $whereConds);

$joinQuery = "FROM tbl_jobcard_issue_meterial AS u
            LEFT JOIN tbl_jobcard AS uj ON (uj.idtbl_jobcard = u.tbl_jobcard_idtbl_jobcard)
            LEFT JOIN tbl_jobcard_manual_issue AS umi ON (umi.idtbl_jobcard_manual_issue = u.tbl_jobcard_manual_issue_idtbl_jobcard_manual_issue)
            LEFT JOIN tbl_jobcard AS ujm ON (ujm.idtbl_jobcard = umi.tbl_jobcard_idtbl_jobcard)
            LEFT JOIN tbl_customer AS uc ON (uc.idtbl_customer = COALESCE(uj.tbl_customer_idtbl_customer, ujm.tbl_customer_idtbl_customer))
            LEFT JOIN tbl_print_material_info AS um ON (um.idtbl_print_material_info = u.tbl_print_material_info_idtbl_print_material_info)";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);