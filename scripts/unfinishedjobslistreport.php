<?php

/*
 * DataTables server-side processing for the Finished Jobs report
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

$whereConds = array();
$whereConds[] = "u.status IN (1)";
$whereConds[] = "u.job_finish_status = 0"; // fixed: finished job flag
$whereConds[] = "ub.status IN (1)";

$customer = isset($_POST['customer']) ? $_POST['customer'] : '';
if ($customer !== '' && $customer !== 'all') {
    $whereConds[] = "ub.tbl_customer_idtbl_customer = '$customer'";
}

if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {
    $from = $_POST['search_from_date'];
    $to = $_POST['search_to_date'];
    $whereConds[] = "ub.date BETWEEN '$from' AND '$to'";
}

if (!empty($_POST['job'])) {
    $job = $_POST['job'];
    $whereConds[] = "(u.job LIKE '%$job%' OR u.job_no LIKE '%$job%')";
}

$whereClause = implode(' AND ', $whereConds);

$joinQuery = "FROM tbl_customerinquiry_detail AS u
            JOIN tbl_customerinquiry AS ub ON (ub.idtbl_customerinquiry = u.tbl_customerinquiry_idtbl_customerinquiry)
            JOIN tbl_customer AS uc ON (uc.idtbl_customer = ub.tbl_customer_idtbl_customer)
            LEFT JOIN (SELECT * FROM tbl_print_dispatchdetail AS x WHERE x.status IN (1,2) GROUP BY x.job_no) AS ud ON (ud.job_no = u.job_no)
            LEFT JOIN tbl_print_dispatch AS ue ON (ue.idtbl_print_dispatch = ud.tbl_print_dispatch_idtbl_print_dispatch AND ue.tbl_customerinquiry_idtbl_customerinquiry = ub.idtbl_customerinquiry AND ue.status IN (1,2))
            WHERE $whereClause";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);