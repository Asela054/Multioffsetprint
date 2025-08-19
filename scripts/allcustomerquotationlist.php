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
$table = 'tbl_jobquatation';

// Table's primary key
$primaryKey = 'idtbl_jobquatation';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_jobquatation`', 'dt' => 'idtbl_jobquatation', 'field' => 'idtbl_jobquatation' ),
	// array( 'db' => '`u`.`approvedstatus`', 'dt' => 'approvedstatus', 'field' => 'approvedstatus' ),
	array( 'db' => '`ub`.`job`', 'dt' => 'job', 'field' => 'job' ),
	array( 'db' => '`ub`.`job_id`', 'dt' => 'job_id', 'field' => 'job_id' ),
	array( 'db' => '`ub`.`job_no`', 'dt' => 'job_no', 'field' => 'job_no' ),
	array( 'db' => '`ub`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM `tbl_jobquatation` AS `u` JOIN `tbl_inquiry_allocated_materials` AS `ua` ON (`ua`.`tbl_jobquatation_idtbl_jobquatation` = `u`.`idtbl_jobquatation`)
              JOIN `tbl_customerinquiry_detail` AS `ub` ON (`ub`.`job_id` = `u`.`customerjob_id`)";

$extraWhere = "`u`.`status` IN (1, 2)";
$groupBy ="`u`.`idtbl_jobquatation`";
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere,$groupBy)
);
