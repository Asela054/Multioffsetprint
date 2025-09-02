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
$table = 'tbl_print_stock';

// Table's primary key
$primaryKey = 'idtbl_print_stock';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => '`u`.`idtbl_print_stock`', 'dt' => 'idtbl_print_stock', 'field' => 'idtbl_print_stock'),
    array('db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno'),
    array('db' => '`ua`.`location`', 'dt' => 'location', 'field' => 'location'),
    array('db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty'),
    array('db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total'),
    array('db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice'),
    array('db' => '`ub`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname')
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
$companyID = $_POST['company_id'];

$threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));

$joinQuery = "FROM `tbl_print_stock` AS `u`
LEFT JOIN `tbl_location` As `ua` ON (`ua`.`idtbl_location` = `u`.`location`)
LEFT JOIN `tbl_print_material_info` As `ub` ON (`ub`.`idtbl_print_material_info` = `u`.`tbl_print_material_info_idtbl_print_material_info`)
LEFT JOIN `tbl_jobcard_issue_meterial` AS `ue` ON (`ue`.`batchno` = `u`.`batchno` AND `ue`.`tbl_print_material_info_idtbl_print_material_info` = `u`.`tbl_print_material_info_idtbl_print_material_info` AND `ue`.`issuedate` >= '$threeMonthsAgo' AND `ue`.`status` = 1)";

$extraWhere = "`u`.`status` IN (1,2) 
AND `u`.`tbl_company_idtbl_company` = '$companyID'
AND `ue`.`batchno` IS NULL";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);