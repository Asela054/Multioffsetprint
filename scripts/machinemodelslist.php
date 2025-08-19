<?php


$table = 'tbl_machinemodels';

$primaryKey = 'idtbl_machinemodels';


$columns = array(
	array( 'db' => 'u.idtbl_machinemodels', 'dt' => 'idtbl_machinemodels', 'field' => 'idtbl_machinemodels' ),
	array( 'db' => 'u.machinemodels_name', 'dt' => 'machinemodels_name', 'field' => 'machinemodels_name' ),
	array( 'db' => 'u.status', 'dt' => 'status', 'field' => 'status' )

	 
);


require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);


require('ssp.customized.class.php' );

$joinQuery = "FROM tbl_machinemodels AS u";

$extraWhere = "u.status IN (1,2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);