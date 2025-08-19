<?php

// DB table to use
$table = 'tbl_charges';

// Table's primary key
$primaryKey = 'idtbl_charges';

// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_charges`', 'dt' => 'idtbl_charges', 'field' => 'idtbl_charges' ),
	array( 'db' => '`u`.`charges_type`', 'dt' => 'charges_type', 'field' => 'charges_type' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `tbl_charges` AS `u`";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
