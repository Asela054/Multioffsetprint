<?php

/*
 * DataTables server-side processing script for tbl_direct_invoice.
 *
 * @license MIT - http://datatables.net/license_mit
 */

// DB table to use
$table = 'tbl_direct_invoice';

// Table's primary key
$primaryKey = 'idtbl_direct_invoice';

// Array of database columns which should be read and sent back to DataTables
$columns = array(
    array('db' => '`main`.`idtbl_direct_invoice`', 'dt' => 'idtbl_direct_invoice', 'field' => 'idtbl_direct_invoice'),
    array('db' => '`main`.`date`', 'dt' => 'date', 'field' => 'date'),
    array('db' => '`main`.`total`', 'dt' => 'total', 'field' => 'total'),
    array('db' => '`main`.`inv_no`', 'dt' => 'inv_no', 'field' => 'inv_no'),
    array('db' => '`main`.`customer`', 'dt' => 'customer', 'field' => 'customer'),
    array('db' => '`main`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus'),
    array('db' => '`main`.`status`', 'dt' => 'status', 'field' => 'status'),
    array('db' => '`main`.`check_by`', 'dt' => 'check_by', 'field' => 'check_by'),
    array('db' => '`main`.`name`', 'dt' => 'name', 'field' => 'name'),
    array('db' => '`main`.`tbl_direct_dispatch_idtbl_direct_dispatch`', 'dt' => 'tbl_direct_dispatch_idtbl_direct_dispatch', 'field' => 'tbl_direct_dispatch_idtbl_direct_dispatch'),
    	array(
        'db' => "CONCAT(
            CASE 
                WHEN `main`.`approvestatus` = 1 THEN '<i class=\"fas fa-check text-success mr-2\"></i>Approved Invoice'
                WHEN `main`.`approvestatus` = 2 THEN '<i class=\"fa fa-times text-danger mr-2\"></i>Reject Invoice'
                ELSE '<i class=\"fa fa-spinner text-warning mr-2\"></i>Pending Invoice for Approval'
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

require('ssp.customized.class.php' );
$companyID = $_POST['company_id'];
// Customized join and subquery
$joinQuery = "FROM (
    SELECT 
        u.idtbl_direct_invoice,
        u.date,
        u.total,
        u.inv_no,
		u.tbl_company_idtbl_company,
        ub.customer,
		u.approvestatus,
        u.status,
        u.check_by,
        us.name,
        u.tbl_direct_dispatch_idtbl_direct_dispatch
    FROM 
        tbl_direct_invoice AS u
    LEFT JOIN 
        tbl_direct_dispatch AS ua ON ua.idtbl_direct_dispatch = u.tbl_direct_dispatch_idtbl_direct_dispatch
    LEFT JOIN 
        tbl_customer AS ub ON ub.idtbl_customer = ua.tbl_customer_idtbl_customer
    LEFT JOIN 
        tbl_direct_invoicedetail AS v ON v.tbl_direct_invoice_idtbl_direct_invoice = u.idtbl_direct_invoice
    LEFT JOIN 
        tbl_user AS us ON u.check_by = us.idtbl_user
    WHERE 
        u.status IN (1, 2, 4)
    GROUP BY 
        u.idtbl_direct_invoice
) AS main";

$extraWhere = "`main`.`status` IN (1,2,4) AND `main`.`tbl_company_idtbl_company` = '$companyID'";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);