<?php

/*
 * DataTables server-side processing script for tbl_print_invoice.
 *
 * @license MIT - http://datatables.net/license_mit
 */

// DB table to use
$table = 'tbl_print_invoice';

// Table's primary key
$primaryKey = 'idtbl_print_invoice';

// Array of database columns which should be read and sent back to DataTables
$columns = array(
    array('db' => '`main`.`idtbl_print_invoice`', 'dt' => 'idtbl_print_invoice', 'field' => 'idtbl_print_invoice'),
    array('db' => '`main`.`date`', 'dt' => 'date', 'field' => 'date'),
    array('db' => '`main`.`total`', 'dt' => 'total', 'field' => 'total'),
    array('db' => '`main`.`inv_no`', 'dt' => 'inv_no', 'field' => 'inv_no'),
    array('db' => '`main`.`customer`', 'dt' => 'customer', 'field' => 'customer'),
    array('db' => '`main`.`job_no`', 'dt' => 'job_no', 'field' => 'job_no'),
    array('db' => '`main`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus'),
    array('db' => '`main`.`status`', 'dt' => 'status', 'field' => 'status'),
    array('db' => '`main`.`tbl_print_dispatch_idtbl_print_dispatch`', 'dt' => 'tbl_print_dispatch_idtbl_print_dispatch', 'field' => 'tbl_print_dispatch_idtbl_print_dispatch')
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php' );
$companyID = $_POST['company_id'];
// Customized join and subquery
$joinQuery = "FROM (
    SELECT 
        u.idtbl_print_invoice,
        u.date,
        u.total,
        u.inv_no,
		u.tbl_company_idtbl_company,
        ua.customer,
 		GROUP_CONCAT(DISTINCT v.job_no SEPARATOR ', ') AS job_no, -- Ensure DISTINCT job_no,
		u.approvestatus,
        u.status,
        v.tbl_print_dispatch_idtbl_print_dispatch
    FROM 
        tbl_print_invoice AS u
    LEFT JOIN 
        tbl_customer AS ua ON ua.idtbl_customer = u.tbl_customer_idtbl_customer
    LEFT JOIN 
        tbl_print_invoicedetail AS v ON v.tbl_print_invoice_idtbl_print_invoice = u.idtbl_print_invoice
    WHERE 
        u.status IN (1, 2, 4)
    GROUP BY 
        u.idtbl_print_invoice
) AS main";

$extraWhere = "`main`.`status` IN (1,2,4) AND `main`.`tbl_company_idtbl_company` = '$companyID'";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);