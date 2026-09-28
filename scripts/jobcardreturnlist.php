<?php
require_once '../external.php';

$CI =& get_instance();
$CI->load->library('session');
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
$table = 'tbl_jobcard_return_material';

// Table's primary key
$primaryKey = 'idtbl_jobcard_return_material';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
	array( 'db' => '`derived_table`.`idtbl_jobcard_return_material`', 'dt' => 'idtbl_jobcard_return_material', 'field' => 'idtbl_jobcard_return_material' ),
	array( 'db' => '`derived_table`.`returndate`', 'dt' => 'returndate', 'field' => 'returndate' ),
	array( 'db' => '`derived_table`.`jobcardno`', 'dt' => 'jobcardno', 'field' => 'jobcardno' ),
	array( 'db' => '`derived_table`.`section_name`', 'dt' => 'section_name', 'field' => 'section_name' ),
	array( 'db' => '`derived_table`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`derived_table`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
	array( 'db' => '`derived_table`.`returnqty`', 'dt' => 'returnqty', 'field' => 'returnqty' ),
	array( 'db' => '`derived_table`.`approvedstatus`', 'dt' => 'approvedstatus', 'field' => 'approvedstatus' )
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

$companyid=$_SESSION['company_id'];
$branchid=$_SESSION['branch_id'];
$jobcardID=$_POST['jobcardID'];

$joinQuery = "FROM (
    SELECT `tbl_jobcard_return_material`.`idtbl_jobcard_return_material`, `tbl_jobcard`.`jobcardno`, CASE `tbl_jobcard_return_material`.`sectiontype`
        WHEN 1 THEN 'Material Section'
        WHEN 2 THEN 'Printing Section'
        WHEN 3 THEN 'Coating Section'
        WHEN 4 THEN 'Foiling Section'
        WHEN 5 THEN 'Lamination Section'
        WHEN 6 THEN 'Pasting Section'
        WHEN 7 THEN 'Rimming Section'
        ELSE 'Unknown'
    END AS `section_name`, `tbl_print_material_info`.`materialname`, `tbl_jobcard_return_material`.`batchno`, `tbl_jobcard_return_material`.`returnqty`, `tbl_jobcard_return_material`.`returndate`, `tbl_jobcard_return_material`.`approvedstatus` FROM `tbl_jobcard_return_material` LEFT JOIN `tbl_jobcard` ON `tbl_jobcard`.`idtbl_jobcard` = `tbl_jobcard_return_material`.`tbl_jobcard_idtbl_jobcard` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_jobcard_return_material`.`tbl_print_material_info_idtbl_print_material_info` WHERE `tbl_jobcard_return_material`.`status` = 1 AND `tbl_jobcard_return_material`.`tbl_jobcard_idtbl_jobcard` = '$jobcardID' AND  `tbl_jobcard`.`tbl_company_idtbl_company` = '$companyid' AND `tbl_jobcard`.`tbl_company_branch_idtbl_company_branch` = '$branchid' ORDER BY `tbl_jobcard_return_material`.`idtbl_jobcard_return_material` DESC
) AS derived_table";

$extraWhere = "";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
