<?php

/*
 * DataTables server-side processing for the Job Material Issue Report
 */

// DB table to use
$table = 'tbl_jobcard_issue_meterial';

// Table's primary key
$primaryKey = 'idtbl_jobcard_issue_meterial';


// Columns read and sent back to DataTables
$columns = array(

    array(
        'db' => 'u.idtbl_jobcard_issue_meterial',
        'dt' => 'idtbl_jobcard_issue_meterial',
        'field' => 'idtbl_jobcard_issue_meterial'
    ),

    array(
        'db' => "(SELECT GROUP_CONCAT(
                    DISTINCT tin.issuenoteno
                    SEPARATOR ', '
                )
                FROM tbl_issue_note_detail tind
                JOIN tbl_issue_note tin
                    ON tin.idtbl_issue_note =
                       tind.tbl_issue_note_idtbl_issue_note
                WHERE tind.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial =
                      u.idtbl_jobcard_issue_meterial
              )",
        'dt' => 'issuenoteno',
        'field' => 'issuenoteno',
        'as' => 'issuenoteno'
    ),

    array(
        'db' => 'u.issuedate',
        'dt' => 'issuedate',
        'field' => 'issuedate'
    ),

    array(
        'db' => 'COALESCE(uj.jobcardno, ujm.jobcardno)',
        'dt' => 'jobcardno',
        'field' => 'jobcardno',
        'as' => 'jobcardno'
    ),

    array(
        'db' => 'uc.customer',
        'dt' => 'customer',
        'field' => 'customer'
    ),

    array(
        'db' => 'COALESCE(uj.date, ujm.date)',
        'dt' => 'jobdate',
        'field' => 'jobdate',
        'as' => 'jobdate'
    ),

    array(
        'db' => 'cid.job_no',
        'dt' => 'jobno',
        'field' => 'jobno',
        'as' => 'jobno'
    ),

    array(
        'db' => 'COALESCE(uj.job_description, ujm.job_description)',
        'dt' => 'job_description',
        'field' => 'job_description',
        'as' => 'job_description'
    ),

    array(
        'db' => "CASE
                    WHEN u.sectiontype = 1 THEN 'Material Section'
                    WHEN u.sectiontype = 2 THEN 'Printing Section'
                    WHEN u.sectiontype = 3 THEN 'Coating Section'
                    WHEN u.sectiontype = 4 THEN 'Foiling Section'
                    WHEN u.sectiontype = 5 THEN 'Lamination Section'
                    WHEN u.sectiontype = 6 THEN 'Pasting Section'
                    WHEN u.sectiontype = 7 THEN 'Rimming Section'
                    ELSE ''
                END",
        'dt' => 'sectiontype',
        'field' => 'sectiontype',
        'as' => 'sectiontype'
    ),

    array(
        'db' => 'um.materialinfocode',
        'dt' => 'materialinfocode',
        'field' => 'materialinfocode'
    ),

    array(
        'db' => 'um.materialname',
        'dt' => 'materialname',
        'field' => 'materialname'
    ),

    array(
        'db' => 'u.batchno',
        'dt' => 'batchno',
        'field' => 'batchno'
    ),

    array(
        'db' => 'u.reqissueqty',
        'dt' => 'reqissueqty',
        'field' => 'reqissueqty'
    ),

    array(
        'db' => 'u.issueqty',
        'dt' => 'issueqty',
        'field' => 'issueqty'
    ),

    array(
        'db' => 'ums.measure_type',
        'dt' => 'uom',
        'field' => 'uom',
        'as' => 'uom'
    ),

    array(
        'db' => 'u.unitprice',
        'dt' => 'unitprice',
        'field' => 'unitprice'
    ),

    array(
        'db' => '(u.issueqty * u.unitprice)',
        'dt' => 'total',
        'field' => 'total',
        'as' => 'total'
    ),

    array(
        'db' => 'u.status',
        'dt' => 'status',
        'field' => 'status'
    )
);


// SQL server connection information
require('config.php');

$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php');


// Database connection
$conn = new mysqli(
    $db_host,
    $db_username,
    $db_password,
    $db_name
);

if ($conn->connect_error) {
    die(json_encode(array(
        'error' => 'Database connection failed'
    )));
}


// Get company ID
$companyID = isset($_POST['company_id'])
    ? $conn->real_escape_string($_POST['company_id'])
    : 0;


// Build WHERE conditions
$whereConds = array();


// Only active issue records
$whereConds[] = "u.status IN (2)";


// Company filter
$whereConds[] = "
    COALESCE(
        uj.tbl_company_idtbl_company,
        ujm.tbl_company_idtbl_company
    ) = '".$companyID."'
";


// Customer filter
$customer = isset($_POST['customer'])
    ? $conn->real_escape_string($_POST['customer'])
    : '';

if ($customer !== '' && $customer !== 'all') {

    $whereConds[] = "
        COALESCE(
            uj.tbl_customer_idtbl_customer,
            ujm.tbl_customer_idtbl_customer
        ) = '$customer'
    ";
}


// Date filter
if (
    !empty($_POST['search_from_date']) &&
    !empty($_POST['search_to_date'])
) {

    $from = $conn->real_escape_string(
        $_POST['search_from_date']
    );

    $to = $conn->real_escape_string(
        $_POST['search_to_date']
    );

    $whereConds[] = "
        u.issuedate BETWEEN '$from' AND '$to'
    ";
}


// Job filter
if (!empty($_POST['job'])) {

    $job = $conn->real_escape_string(
        $_POST['job']
    );

    $whereConds[] = "
        cid.job_no LIKE '%$job%'
    ";
}


$conn->close();


// Convert WHERE conditions into string
$extraWhere = implode(
    ' AND ',
    $whereConds
);


// JOIN tables
$joinQuery = "

    FROM tbl_jobcard_issue_meterial AS u


    /*
     * Normal Job Card
     */
    LEFT JOIN tbl_jobcard AS uj
        ON uj.idtbl_jobcard =
           u.tbl_jobcard_idtbl_jobcard


    /*
     * Manual Job Card Issue
     */
    LEFT JOIN tbl_jobcard_manual_issue AS umi
        ON umi.idtbl_jobcard_manual_issue =
           u.tbl_jobcard_manual_issue_idtbl_jobcard_manual_issue


    /*
     * Job Card connected to manual issue
     */
    LEFT JOIN tbl_jobcard AS ujm
        ON ujm.idtbl_jobcard =
           umi.tbl_jobcard_idtbl_jobcard


    /*
     * Customer
     */
    LEFT JOIN tbl_customer AS uc
        ON uc.idtbl_customer =
           COALESCE(
               uj.tbl_customer_idtbl_customer,
               ujm.tbl_customer_idtbl_customer
           )


    /*
     * Customer Inquiry Detail
     *
     * tbl_jobcard
     *      |
     *      | tbl_customerinquiry_idtbl_customerinquiry
     *      v
     * tbl_customerinquiry_detail
     */
    LEFT JOIN tbl_customerinquiry_detail AS cid
        ON cid.tbl_customerinquiry_idtbl_customerinquiry =
           COALESCE(
               uj.tbl_customerinquiry_idtbl_customerinquiry,
               ujm.tbl_customerinquiry_idtbl_customerinquiry
           )


    /*
     * Material
     */
    LEFT JOIN tbl_print_material_info AS um
        ON um.idtbl_print_material_info =
           u.tbl_print_material_info_idtbl_print_material_info


    /*
     * Measurement / UOM
     */
    LEFT JOIN tbl_measurements AS ums
        ON ums.idtbl_mesurements =
           um.tbl_measurements_idtbl_measurements
";


echo json_encode(
    SSP::simple(
        $_POST,
        $sql_details,
        $table,
        $primaryKey,
        $columns,
        $joinQuery,
        $extraWhere
    )
);