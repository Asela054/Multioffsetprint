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
$table = 'tbl_jobcard_manual_issue';

// Table's primary key
$primaryKey = 'idtbl_jobcard_manual_issue';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_jobcard_manual_issue`', 'dt' => 'idtbl_jobcard_manual_issue', 'field' => 'idtbl_jobcard_manual_issue' ),
	array( 'db' => '`u`.`issuedate`', 'dt' => 'issuedate', 'field' => 'issuedate' ),
	array( 'db' => '`jc`.`jobcardno`', 'dt' => 'jobcardno', 'field' => 'jobcardno' ),
	array( 'db' => '`cust`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
	array( 'db' => '`cust`.`telephone_no`', 'dt' => 'telephone_no', 'field' => 'telephone_no' ),
	array( 'db' => '`jc`.`jobcardtype`', 'dt' => 'jobcardtype', 'field' => 'jobcardtype' ),
	array( 'db' => '`jc`.`job_description`', 'dt' => 'job_description', 'field' => 'job_description' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`usr`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array(
        'db' => "CASE 
                WHEN `u`.`status` = 1 THEN '<span class=\"badge badge-success\">Active</span>'
                ELSE '<span class=\"badge badge-danger\">Inactive</span>'
            END",
        'dt' => 'status_display',
        'field' => 'status_display',
        'as' => 'status_display'
		),
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
$companyID = $_POST['company_id'];

$joinQuery = "FROM `tbl_jobcard_manual_issue` AS `u` 
LEFT JOIN `tbl_jobcard` AS `jc` ON (`jc`.`idtbl_jobcard` = `u`.`tbl_jobcard_idtbl_jobcard`) 
LEFT JOIN `tbl_customer` AS `cust` ON (`cust`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) 
LEFT JOIN `tbl_user` AS `usr` ON (`usr`.`idtbl_user` = `u`.`tbl_user_idtbl_user`)";

$extraWhere = "`u`.`status` IN (1,2) AND `jc`.`tbl_company_idtbl_company`='$companyID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);

?>
