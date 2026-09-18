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
$table = 'tbl_jobcard';

// Table's primary key
$primaryKey = 'idtbl_jobcard';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
// $columns = array(
// 	array( 'db' => '`u`.`idtbl_jobcard`', 'dt' => 'idtbl_jobcard', 'field' => 'idtbl_jobcard' ),
// 	array( 'db' => '`u`.`jobcardno`', 'dt' => 'jobcardno', 'field' => 'jobcardno' ),
// 	array( 'db' => '`u`.`job_description`', 'dt' => 'job_description', 'field' => 'job_description' ),
// 	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
// 	array( 'db' => '`u`.`issueqty`', 'dt' => 'issueqty', 'field' => 'issueqty' ),
// 	array( 'db' => '`ua`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
// 	array( 'db' => '`ub`.`company`', 'dt' => 'company', 'field' => 'company' ),
// 	array( 'db' => '`uc`.`branch`', 'dt' => 'branch', 'field' => 'branch' ),
// 	array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
// 	array( 'db' => '`u`.`issuematerialstatus`', 'dt' => 'issuematerialstatus', 'field' => 'issuematerialstatus' ),
// 	array( 'db' => '`u`.`check_by`', 'dt' => 'check_by', 'field' => 'check_by' ),
// 	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
// 	array( 'db' => '`latest_issue`.`issuedate`', 'dt' => 'issuedate', 'field' => 'issuedate' ),
// 	array( 'db' => '`latest_issue`.`idtbl_jobcard_issue_meterial`', 'dt' => 'idtbl_jobcard_issue_meterial', 'field' => 'idtbl_jobcard_issue_meterial' )
// );
$columns = array(
	array( 'db' => '`derived_table`.`idtbl_jobcard`', 'dt' => 'idtbl_jobcard', 'field' => 'idtbl_jobcard' ),
	array( 'db' => '`derived_table`.`jobcardno`', 'dt' => 'jobcardno', 'field' => 'jobcardno' ),
	array( 'db' => '`derived_table`.`job_description`', 'dt' => 'job_description', 'field' => 'job_description' ),
	array( 'db' => '`derived_table`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array( 'db' => '`derived_table`.`issueqty`', 'dt' => 'issueqty', 'field' => 'issueqty' ),
	array( 'db' => '`derived_table`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
	array( 'db' => '`derived_table`.`company`', 'dt' => 'company', 'field' => 'company' ),
	array( 'db' => '`derived_table`.`branch`', 'dt' => 'branch', 'field' => 'branch' ),
	array( 'db' => '`derived_table`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`derived_table`.`issuematerialstatus`', 'dt' => 'issuematerialstatus', 'field' => 'issuematerialstatus' ),
	array( 'db' => '`derived_table`.`check_by`', 'dt' => 'check_by', 'field' => 'check_by' ),
	array( 'db' => '`derived_table`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`derived_table`.`latest_issuedate`', 'dt' => 'latest_issuedate', 'field' => 'latest_issuedate' ),
	array( 'db' => '`derived_table`.`latest_issue_id`', 'dt' => 'latest_issue_id', 'field' => 'latest_issue_id' )
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

// $joinQuery = "FROM `tbl_jobcard` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) LEFT JOIN `tbl_company` AS `ub` ON (`ub`.`idtbl_company` = `u`.`tbl_company_idtbl_company`) LEFT JOIN `tbl_company_branch` AS `uc` ON (`uc`.`idtbl_company_branch` = `u`.`tbl_company_branch_idtbl_company_branch`) LEFT JOIN (
// 		SELECT `t1`.`tbl_jobcard_idtbl_jobcard`, `t1`.`issuedate`
// 		FROM `tbl_jobcard_issue_meterial` AS `t1`
// 		INNER JOIN (
// 			SELECT `tbl_jobcard_idtbl_jobcard`, MAX(`issuedate`) AS `max_issuedate`
// 			FROM `tbl_jobcard_issue_meterial`
// 			GROUP BY `tbl_jobcard_idtbl_jobcard`
// 		) AS `t2` ON `t1`.`tbl_jobcard_idtbl_jobcard` = `t2`.`tbl_jobcard_idtbl_jobcard`
// 			AND `t1`.`issuedate` = `t2`.`max_issuedate`
// 	) AS `latest_issue` ON `latest_issue`.`tbl_jobcard_idtbl_jobcard` = `u`.`idtbl_jobcard`";

$joinQuery = "FROM (
    SELECT 
        u.*,
        ua.customer,
        ub.company,
        uc.branch,
        (
            SELECT im.issuedate
            FROM `tbl_jobcard_issue_meterial` AS im
            WHERE im.tbl_jobcard_idtbl_jobcard = u.idtbl_jobcard
              AND im.status IN (1, 2)
            ORDER BY im.idtbl_jobcard_issue_meterial DESC
            LIMIT 1
        ) AS latest_issuedate,
        (
            SELECT im.idtbl_jobcard_issue_meterial
            FROM `tbl_jobcard_issue_meterial` AS im
            WHERE im.tbl_jobcard_idtbl_jobcard = u.idtbl_jobcard
              AND im.status IN (1, 2)
            ORDER BY im.idtbl_jobcard_issue_meterial DESC
            LIMIT 1
        ) AS latest_issue_id
    FROM `tbl_jobcard` AS `u`
    LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)
    LEFT JOIN `tbl_company` AS `ub` ON (`ub`.`idtbl_company` = `u`.`tbl_company_idtbl_company`)
    LEFT JOIN `tbl_company_branch` AS `uc` ON (`uc`.`idtbl_company_branch` = `u`.`tbl_company_branch_idtbl_company_branch`)
    WHERE `u`.`status` IN (1, 2)
      AND `u`.`tbl_company_idtbl_company` = '$companyid'
      AND `u`.`tbl_company_branch_idtbl_company_branch` = '$branchid'
    ORDER BY latest_issue_id DESC
) AS derived_table";

$extraWhere = "";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
