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
$table = 'tbl_customerinquiry';

// Table's primary key
$primaryKey = 'idtbl_customerinquiry';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`derived_table`.`idtbl_customerinquiry`', 'dt' => 'idtbl_customerinquiry', 'field' => 'idtbl_customerinquiry' ),
	array( 'db' => '`derived_table`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
	array( 'db' => '`derived_table`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array( 'db' => '`derived_table`.`po_number`', 'dt' => 'po_number', 'field' => 'po_number' ),
	array( 'db' => '`derived_table`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`derived_table`.`job_finish_status`', 'dt' => 'job_finish_status', 'field' => 'job_finish_status' ),
	array( 'db' => '`derived_table`.`job`', 'dt' => 'job', 'field' => 'job' ),
	array( 'db' => '`derived_table`.`job_no`', 'dt' => 'job_no', 'field' => 'job_no' ),
	array( 'db' => '`derived_table`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`derived_table`.`status_display`', 'dt' => 'status_display', 'field' => 'status_display' )
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

$joinQuery = "FROM (
                SELECT 
                    u.*, 
                    ua.job_finish_status,
                    ua.job,
                    ua.job_no,
                    ub.customer,
                    CASE 
                        WHEN ua.job_finish_status = 1 THEN 'Inquiry Finished'
                        WHEN u.approvestatus = 1 THEN 'Inquiry Approved'
                        WHEN u.approvestatus = 2 THEN 'Inquiry Rejected'
                        ELSE 'Inquiry Not Approved'
                    END AS status_display
                FROM `tbl_customerinquiry` AS `u` 
                JOIN `tbl_customerinquiry_detail` AS `ua` ON (`ua`.`tbl_customerinquiry_idtbl_customerinquiry` = `u`.`idtbl_customerinquiry`)
                JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)
                WHERE `u`.`status` IN (1, 2) AND `u`.`tbl_company_idtbl_company` = '$companyid'
                GROUP BY `u`.`idtbl_customerinquiry`
              ) AS derived_table";

$extraWhere = "";
$groupBy ="";
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere,$groupBy)
);
