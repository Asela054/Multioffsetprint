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
    array( 'db' => '`u`.`idtbl_print_stock`', 'dt' => 'idtbl_print_stock', 'field' => 'idtbl_print_stock' ),
    array( 'db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
    array( 'db' => '`ua`.`location`', 'dt' => 'location', 'field' => 'location' ),
    array( 'db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
    array( 'db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
    array( 'db' => '`ub`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
    array( 'db' => '`uc`.`machine`', 'dt' => 'machine', 'field' => 'machine' ),
    array( 'db' => '`ud`.`spare_part_name`', 'dt' => 'spare_part_name', 'field' => 'spare_part_name' )
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

$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : null;
$joinQuery = "FROM `tbl_print_stock` AS `u` LEFT JOIN `tbl_location` AS `ua` ON (`ua`.`idtbl_location` = `u`.`location`) LEFT JOIN `tbl_print_material_info` AS `ub` ON (`ub`.`idtbl_print_material_info` = `u`.`tbl_print_material_info_idtbl_print_material_info`) LEFT JOIN `tbl_machine` AS `uc` ON (`uc`.`idtbl_machine` = `u`.`tbl_machine_id`) LEFT JOIN `tbl_spareparts` AS `ud` ON (`ud`.`idtbl_spareparts` = `u`.`tbl_sparepart_id`)";


if ($search_type == 1) {
    $extraWhere = "`u`.`tbl_print_material_info_idtbl_print_material_info` IS NOT NULL AND `u`.`tbl_machine_id` = 0 AND `u`.`tbl_sparepart_id` = 0 ";
} else if ($search_type == 2) {
    $extraWhere = "`u`.`tbl_machine_id` IS NOT NULL AND `u`.`tbl_print_material_info_idtbl_print_material_info` = 0 AND `u`.`tbl_sparepart_id` = 0";
} else if ($search_type == 3) {
    $extraWhere = "`u`.`tbl_sparepart_id` IS NOT NULL AND `u`.`tbl_print_material_info_idtbl_print_material_info` = 0 AND `u`.`tbl_machine_id` = 0";
}

$extraWhere .= " AND `u`.`status` IN (1, 2)";

// Fetch and output the data
echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);

?>
