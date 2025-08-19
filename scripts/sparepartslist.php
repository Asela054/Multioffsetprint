<?php

$table = 'tbl_spareparts';
$primaryKey = 'idtbl_spareparts';

$columns = array(
    array('db' => '`u`.`idtbl_spareparts`', 'dt' => 'idtbl_spareparts', 'field' => 'idtbl_spareparts'),
    array('db' => '`u`.`spare_part_name`', 'dt' => 'spare_part_name', 'field' => 'spare_part_name'),
    array('db' => '`u`.`part_no`', 'dt' => 'part_no', 'field' => 'part_no'),
    array('db' => '`u`.`rack_no`', 'dt' => 'rack_no', 'field' => 'rack_no'),
    array('db' => '`u`.`unit_price`', 'dt' => 'unit_price', 'field' => 'unit_price'),
    array('db' => '`u`.`supplier_id`', 'dt' => 'supplier_id', 'field' => 'supplier_id'),
    array('db' => '`u`.`machine_models_id`', 'dt' => 'machine_models_id', 'field' => 'machine_models_id'),
    array('db' => '`u`.`machine_type_id`', 'dt' => 'machine_type_id', 'field' => 'machine_type_id'),
    array('db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status'),
    array('db' => '`ub`.`type`', 'dt' => 'type', 'field' => 'type'),
    array('db' => '`ua`.`machinemodels_name`', 'dt' => 'machinemodels_name', 'field' => 'machinemodels_name'),
    array('db' => '`uc`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername')
);

require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);



require('ssp.customized.class.php');

$joinQuery = "FROM `tbl_spareparts` AS `u` LEFT JOIN `tbl_machinemodels` AS `ua` ON (`ua`.`idtbl_machinemodels` = `u`.`machine_models_id`) LEFT JOIN `tbl_machine_type` AS `ub` ON (`ub`.`idtbl_machine_type` = `u`.`machine_type_id`) LEFT JOIN `tbl_supplier` AS `uc` ON (`uc`.`idtbl_supplier` = `u`.`supplier_id`)";

$extraWhere = "`u`.`status` IN (1,2)"; 

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>
