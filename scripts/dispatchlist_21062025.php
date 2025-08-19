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
$table = 'tbl_print_dispatch';

// Table's primary key
$primaryKey = 'idtbl_print_dispatch';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_dispatch`', 'dt' => 'idtbl_print_dispatch', 'field' => 'idtbl_print_dispatch' ),
	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array( 'db' => '`u`.`ponum`', 'dt' => 'ponum', 'field' => 'ponum' ),
	array( 'db' => '`u`.`dispatch_no`', 'dt' => 'dispatch_no', 'field' => 'dispatch_no' ),
	array( 'db' => '`ua`.`job`', 'dt' => 'job', 'field' => 'job' ),
	array( 'db' => '`ua`.`job_no`', 'dt' => 'job_no', 'field' => 'job_no' ),
	array( 'db' => '`ub`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
	array( 'db' => '`u`.`tbl_customerinquiry_idtbl_customerinquiry`', 'dt' => 'tbl_customerinquiry_idtbl_customerinquiry', 'field' => 'tbl_customerinquiry_idtbl_customerinquiry' ),
	array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`u`.`check_by`', 'dt' => 'check_by', 'field' => 'check_by' ),
	array( 'db' => '`uc`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array(
        'db' => "CONCAT(
            CASE 
                WHEN `u`.`approvestatus` = 1 THEN '<i class=\"fas fa-check text-success mr-2\"></i>Approved Dispatch Note'
                WHEN `u`.`approvestatus` = 2 THEN '<i class=\"fa fa-times text-danger mr-2\"></i>Reject Dispatch Note'
                ELSE '<i class=\"fa fa-spinner text-warning mr-2\"></i>Pending Dispatch Note'
            END
        )",
        'dt' => 'approvestatus_display',
        'field' => 'approvestatus_display',
        'as' => 'approvestatus_display'
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

$joinQuery = "FROM `tbl_print_dispatch` AS `u`
LEFT JOIN `tbl_customer` As `ub` ON (`ub`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)
LEFT JOIN `tbl_print_dispatchdetail` As `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch` = `u`.`idtbl_print_dispatch`)
LEFT JOIN `tbl_user` AS `uc` ON (`uc`.`idtbl_user` = `u`.`check_by`)";

$extraWhere = "`u`.`status` IN (1,2) AND `ua`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
