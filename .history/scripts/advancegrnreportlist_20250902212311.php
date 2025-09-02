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
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => '`u`.`idtbl_print_grn`', 'dt' => 'idtbl_print_grn', 'field' => 'idtbl_print_grn'),
    array('db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno'),
    array('db' => '`ub`.`location`', 'dt' => 'location', 'field' => 'location'),
    array('db' => '`ua`.`qty`', 'dt' => 'qty', 'field' => 'qty'),
    array('db' => '`ua`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice'),
    array('db' => '`uc`.`spare_part_name`', 'dt' => 'spare_part_name', 'field' => 'spare_part_name'),
    array('db' => '`ud`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname'),
    array('db' => '`ue`.`machine`', 'dt' => 'machine', 'field' => 'machine')
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
require('ssp.customized.class.php');
$supplier = $_POST['supplier'];
$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : null;
$joinQuery = "FROM `tbl_print_grn` AS `u` 
    LEFT JOIN `tbl_print_grndetail` AS `ua` ON (`ua`.`tbl_print_grn_idtbl_print_grn` = `u`.`idtbl_print_grn`) 
    LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) 
    LEFT JOIN `tbl_print_material_info` AS `ud` ON (`ud`.`idtbl_print_material_info` = `ua`.`tbl_print_material_info_idtbl_print_material_info`) ";

if (!empty($_POST['search_date'])) {
    $date = $_POST['search_date'];

    $extraWhere = "`ua`.`tbl_print_material_info_idtbl_print_material_info` IS NOT NULL AND `ua`.`tbl_sparepart_id` = 0 AND `ua`.`tbl_machine_id` = 0";                                                         

    $extraWhere .= " AND `u`.`status` IN (1, 2) AND `u`.`tbl_supplier_idtbl_supplier`='$supplier' AND `u`.`grndate` = '$date'";

} elseif (!empty($_POST['search_week'])) {
    $week = $_POST['search_week'];

    $weeksep = explode('-W', $week);

    $year = $weeksep[0];
    $week1 = $weeksep[1];

    $dto = new DateTime();
    $dto->setISODate($year, $week1);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');

    $extraWhere = "`ua`.`tbl_print_material_info_idtbl_print_material_info` IS NOT NULL AND `ua`.`tbl_sparepart_id` = 0 AND `ua`.`tbl_machine_id` = 0";             
    $extraWhere .= " AND `u`.`status` IN (1,2) AND `u`.grndate BETWEEN '$startDate' AND '$endDate' AND `u`.`tbl_supplier_idtbl_supplier`='$supplier'";
} elseif (!empty($_POST['search_month'])) {
    $month = $_POST['search_month'];
    $month_arr = explode('-', $month);

    $extraWhere = "`ua`.`tbl_print_material_info_idtbl_print_material_info` IS NOT NULL AND `ua`.`tbl_sparepart_id` = 0 AND `ua`.`tbl_machine_id` = 0";
             
    if($supplier == 0){
        $extraWhere .= " AND `u`.`status` IN (1,2) AND YEAR(`u`.grndate) = '$month_arr[0]' AND Month(`u`.grndate) = '$month_arr[1]'";
    }else{
        $extraWhere .= " AND `u`.`status` IN (1,2) AND YEAR(`u`.grndate) = '$month_arr[0]' AND Month(`u`.grndate) = '$month_arr[1]' AND `u`.`tbl_supplier_idtbl_supplier`='$supplier'";
    }
} elseif (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];

    $extraWhere = "`ua`.`tbl_print_material_info_idtbl_print_material_info` IS NOT NULL AND `ua`.`tbl_sparepart_id` = 0 AND `ua`.`tbl_machine_id` = 0";
    } else if ($search_type == 3) {
        $extraWhere = "`ua`.`tbl_machine_id` IS NOT NULL AND `ua`.`tbl_sparepart_id` = 0 AND `ua`.`tbl_print_material_info_idtbl_print_material_info` = 0";
    }              
    if($supplier == 0){
        $extraWhere .= " AND `u`.`status` IN (1,2) AND `u`.grndate BETWEEN '$from_date' AND '$to_date'";
    }else{
        $extraWhere .= " AND `u`.`status` IN (1,2) AND `u`.grndate BETWEEN '$from_date' AND '$to_date' AND `u`.`tbl_supplier_idtbl_supplier`='$supplier'";
    }

} elseif (!empty($_POST['report_type'])) {

    $extraWhere = "`u`.`status` IN (1,2)";
}                                                                                                                                                                                                                 


$i = 1;









// if ($search_type == 1) {
//     $extraWhere = "`u`.`tbl_print_material_info_idtbl_print_material_info` IS NOT NULL AND `u`.`tbl_machine_id` = 0";
// } else if ($search_type == 2) {
//     $extraWhere = "`u`.`tbl_machine_id` IS NOT NULL AND `u`.`tbl_print_material_info_idtbl_print_material_info` = 0";
// }

// $extraWhere .= " AND `u`.`status` IN (1, 2) AND `u`.`tbl_supplier_idtbl_supplier`='$supplier' AND `u`.`date` = '$date'";

// Fetch and output the data
echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
