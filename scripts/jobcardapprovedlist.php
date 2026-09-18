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
	array( 'db' => '`derived_table`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`derived_table`.`notapprovecount`', 'dt' => 'notapprovecount', 'field' => 'notapprovecount' ),
	array( 'db' => '`derived_table`.`issuedate`', 'dt' => 'issuedate', 'field' => 'issuedate' ),
	array( 'db' => '`derived_table`.`idtbl_jobcard_issue_meterial`', 'dt' => 'idtbl_jobcard_issue_meterial', 'field' => 'idtbl_jobcard_issue_meterial' )
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
        ua.customer,
        ub.company,
        uc.branch,
        (
            SELECT COUNT(*)
            FROM `tbl_issue_note` AS inote
            WHERE inote.tbl_jobcard_idtbl_jobcard = u.idtbl_jobcard
              AND inote.tbl_company_idtbl_company = u.tbl_company_idtbl_company
              AND inote.tbl_company_branch_idtbl_company_branch = u.tbl_company_branch_idtbl_company_branch
              AND inote.approvestatus = 0
        ) AS notapprovecount,
        (
            SELECT im.issuedate
            FROM `tbl_jobcard_issue_meterial` AS im
            WHERE im.tbl_jobcard_idtbl_jobcard = u.idtbl_jobcard
              AND im.status IN (1, 2)
            ORDER BY im.idtbl_jobcard_issue_meterial DESC
            LIMIT 1
        ) AS issuedate,
        (
            SELECT im.idtbl_jobcard_issue_meterial
            FROM `tbl_jobcard_issue_meterial` AS im
            WHERE im.tbl_jobcard_idtbl_jobcard = u.idtbl_jobcard
              AND im.status IN (1, 2)
            ORDER BY im.idtbl_jobcard_issue_meterial DESC
            LIMIT 1
        ) AS idtbl_jobcard_issue_meterial
    FROM `tbl_jobcard` AS `u`
    LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)
    LEFT JOIN `tbl_company` AS `ub` ON (`ub`.`idtbl_company` = `u`.`tbl_company_idtbl_company`)
    LEFT JOIN `tbl_company_branch` AS `uc` ON (`uc`.`idtbl_company_branch` = `u`.`tbl_company_branch_idtbl_company_branch`)
    WHERE `u`.`status` IN (1, 2)
      AND `u`.`tbl_company_idtbl_company` = '$companyid'
      AND `u`.`tbl_company_branch_idtbl_company_branch` = '$branchid'
      AND `u`.`approvestatus` = 1
    ORDER BY idtbl_jobcard_issue_meterial DESC
) AS derived_table";

$extraWhere = "";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);