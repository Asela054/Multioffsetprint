<?php

$recordID = $_POST['type'];

if ($recordID == 1) { // Customer

	$table = 'tbl_customer';
	$primaryKey = 'idtbl_customer';
	$columns = array(
		array( 'db' => '`u`.`idtbl_customer`', 'dt' => 'idtbl_customer', 'field' => 'idtbl_customer' ),
		array( 'db' => '`u`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
		array( 'db' => '`u`.`nic`', 'dt' => 'nic', 'field' => 'nic' ),
		array( 'db' => '`u`.`bus_reg_no`', 'dt' => 'bus_reg_no', 'field' => 'bus_reg_no' ),
		array( 'db' => '`u`.`nbt_no`', 'dt' => 'nbt_no', 'field' => 'nbt_no' ),
		array( 'db' => '`u`.`svat_no`', 'dt' => 'svat_no', 'field' => 'svat_no' ),
		array( 'db' => '`u`.`telephone_no`', 'dt' => 'telephone_no', 'field' => 'telephone_no' ),
		array( 'db' => '`u`.`fax_no`', 'dt' => 'fax_no', 'field' => 'fax_no' ),
		array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
	);
	require('config.php');
	$sql_details = array(
		'user' => $db_username,
		'pass' => $db_password,
		'db'   => $db_name,
		'host' => $db_host
	);
	require('ssp.customized.class.php' );
	$joinQuery = "FROM `tbl_customer` AS `u` ";
	$extraWhere = "`u`.`status` IN (3)";
	echo json_encode(
		SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
	);

} else if ($recordID == 2) { // Supplier

	$table = 'tbl_supplier';
	$primaryKey = 'idtbl_supplier';
	$columns = array(
		array( 'db' => '`u`.`idtbl_supplier`', 'dt' => 'idtbl_supplier', 'field' => 'idtbl_supplier' ),
		array( 'db' => '`u`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
		array( 'db' => '`u`.`bus_reg_no`', 'dt' => 'bus_reg_no', 'field' => 'bus_reg_no' ),
		array( 'db' => '`u`.`nbt_no`', 'dt' => 'nbt_no', 'field' => 'nbt_no' ),
		array( 'db' => '`u`.`svat_no`', 'dt' => 'svat_no', 'field' => 'svat_no' ),
		array( 'db' => '`u`.`telephone_no`', 'dt' => 'telephone_no', 'field' => 'telephone_no' ),
		array( 'db' => '`u`.`fax_no`', 'dt' => 'fax_no', 'field' => 'fax_no' ),
		array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
	);
	require('config.php');
	$sql_details = array(
		'user' => $db_username,
		'pass' => $db_password,
		'db'   => $db_name,
		'host' => $db_host
	);
	require('ssp.customized.class.php' );
	$joinQuery = "FROM `tbl_supplier` AS `u` ";
	$extraWhere = "`u`.`status` IN (3)";
	echo json_encode(
		SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
	);

} else if ($recordID == 3) { // GRN

	$table = 'tbl_print_grn';
	$primaryKey = 'idtbl_print_grn';
	$columns = array(
		array( 'db' => '`u`.`idtbl_print_grn`', 'dt' => 'idtbl_print_grn', 'field' => 'idtbl_print_grn' ),
		array( 'db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
		array( 'db' => '`u`.`grntype`', 'dt' => 'grntype', 'field' => 'grntype' ),
		array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
		array( 'db' => '`u`.`grndate`', 'dt' => 'grndate', 'field' => 'grndate' ),
		array( 'db' => '`u`.`invoicenum`', 'dt' => 'invoicenum', 'field' => 'invoicenum' ),
		array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
		array( 'db' => '`ue`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
		array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
	);
	require('config.php');
	$sql_details = array(
		'user' => $db_username,
		'pass' => $db_password,
		'db'   => $db_name,
		'host' => $db_host
	);
	require('ssp.customized.class.php' );
	$joinQuery = "FROM `tbl_print_grn` AS `u`
	 LEFT JOIN `tbl_order_type` AS `ub` ON (`ub`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`)
	 LEFT JOIN `tbl_supplier` AS `ue` ON (`ue`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`)";

	$extraWhere = "`u`.`status` IN (3)";
	echo json_encode(
		SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
	);

} else if ($recordID == 4) { // PO

	$table = 'tbl_print_porder';
	$primaryKey = 'idtbl_print_porder';
	$columns = array(
		array( 'db' => '`u`.`idtbl_print_porder`', 'dt' => 'idtbl_print_porder', 'field' => 'idtbl_print_porder' ),
		array( 'db' => '`u`.`orderdate`', 'dt' => 'orderdate', 'field' => 'orderdate' ),
		array( 'db' => '`u`.`duedate`', 'dt' => 'duedate', 'field' => 'duedate' ),
		array( 'db' => '`u`.`confirmstatus`', 'dt' => 'confirmstatus', 'field' => 'confirmstatus' ),
		array( 'db' => '`u`.`nettotal`', 'dt' => 'nettotal', 'field' => 'nettotal' ),
		array( 'db' => '`u`.`grnconfirm`', 'dt' => 'grnconfirm', 'field' => 'grnconfirm' ),
		array( 'db' => '`ue`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
		array( 'db' => '`ub`.`type`', 'dt' => 'type', 'field' => 'type' ),
		array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
	);
	require('config.php');
	$sql_details = array(
		'user' => $db_username,
		'pass' => $db_password,
		'db'   => $db_name,
		'host' => $db_host
	);
	require('ssp.customized.class.php' );
	$joinQuery = "FROM `tbl_print_porder` AS `u`
	 LEFT JOIN `tbl_order_type` AS `ub` ON (`ub`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`)
	 LEFT JOIN `tbl_supplier` AS `ue` ON (`ue`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`)";
	$extraWhere = "`u`.`status` IN (3)";
	echo json_encode(
		SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
	);

} else if ($recordID == 5) { // New
	
}

else {

	echo 'Data Not Found';

}