<?php
/*
 * Modified server-side processing script with combined field for searching
 */

// DB table to use
$table = 'tbl_print_stock';

// Table's primary key
$primaryKey = 'idtbl_print_stock';

// Array of database columns which should be read and sent back to DataTables.
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

$joinQuery = "FROM `tbl_print_stock` AS `u`
LEFT JOIN `tbl_location` As `ua` ON (`ua`.`idtbl_location` = `u`.`location`)
LEFT JOIN `tbl_print_material_info` As `ub` ON (`ub`.`idtbl_print_material_info` = `u`.`tbl_print_material_info_idtbl_print_material_info`)";

$extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyID'";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);