<?php

// DB table to use
$table = 'tbl_charges_detail';

// Table's primary key
$primaryKey = 'idtbl_charges_detail';

// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_charges_detail`', 'dt' => 'idtbl_charges_detail', 'field' => 'idtbl_charges_detail' ),
	array( 'db' => '`ua`.`charges_type`', 'dt' => 'charges_type', 'field' => 'charges_type' ),
    array( 'db' => '`u`.`charges_date`', 'dt' => 'charges_date', 'field' => 'charges_date' ),
    array( 'db' => '`u`.`charges_effective`', 'dt' => 'charges_effective', 'field' => 'charges_effective' ),
    array( 'db' => '`u`.`price`', 'dt' => 'price', 'field' => 'price' ),
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

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `tbl_charges_detail` AS `u` LEFT JOIN `tbl_charges` AS `ua` ON (`ua`.`idtbl_charges` = `u`.`charges_type`)";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
