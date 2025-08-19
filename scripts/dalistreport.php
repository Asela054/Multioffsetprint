<?php

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
$table = 'tbl_print_dispatch';

// Table's primary key
$primaryKey = 'idtbl_print_dispatch';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_dispatch`', 'dt' => 'idtbl_print_dispatch', 'field' => 'idtbl_print_dispatch' ),
  array( 'db' => '`u`.`dispatch_no`', 'dt' => 'dispatch_no', 'field' => 'dispatch_no' ),
	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array( 'db' => '`u`.`ponum`', 'dt' => 'ponum', 'field' => 'ponum' ),
	array( 'db' => '`ua`.`job`', 'dt' => 'job', 'field' => 'job' ),
	array( 'db' => '`ua`.`job_no`', 'dt' => 'job_no', 'field' => 'job_no' ),
	array( 'db' => '`ub`.`customer`', 'dt' => 'customer', 'field' => 'customer' ),
   array( 'db' => '`u`.`tbl_customerinquiry_idtbl_customerinquiry`', 'dt' => 'tbl_customerinquiry_idtbl_customerinquiry', 'field' => 'tbl_customerinquiry_idtbl_customerinquiry' ),

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



if(!empty($_POST['search_from_date'] && $_POST['search_to_date'] && $_POST['customer'])){

   $from_date = $_POST['search_from_date'];
   $to_date = $_POST['search_to_date'];
   $customer = $_POST['customer'];
  // $ser_type = $_POST['search_type'];

  if($customer=="all"){
     $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `u`.`date` BETWEEN '$from_date' and '$to_date' ";

     // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
  }
  else{
  $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `u`.`date` BETWEEN '$from_date' and '$to_date' AND u.tbl_customer_idtbl_customer = '$customer'";


  // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
  }
}
elseif ( !empty($_POST['search_month'])) {
  $month=$_POST['search_month'];
  $month_arr=explode('-', $month);
  $customer=$_POST['customer'];

  if($customer=="all") {
     $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND YEAR(`u`.`date`)='$month_arr[0]'AND Month(`u`.`date`)='$month_arr[1]'";

  }

  else {
     $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND YEAR(`u`.`date`)='$month_arr[0]'AND Month(`u`.`date`)='$month_arr[1]'AND u.tbl_customer_idtbl_customer='$customer'";


     // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
  }
}

elseif (!empty($_POST['search_week'])) {
   $week = $_POST['search_week'];
   $customer = $_POST['customer'];

   $weeksep = explode('-W', $week);

   $year = $weeksep[0];
   $week1 = $weeksep[1];

   $dto = new DateTime();
   $dto->setISODate($year, $week1);
   $startDate = $dto->format('Y-m-d');
   $dto->modify('+6 days');
   $endDate = $dto->format('Y-m-d');

   if($customer=="all"){
     $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `u`.`date` BETWEEN '$startDate' AND '$endDate' ";

     // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
  }
  else{
  $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `u`.`date` BETWEEN '$startDate' AND '$endDate' AND `u`.`tbl_customer_idtbl_customer`='$customer'";


  // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
  }
}elseif (!empty($_POST['search_date'])) {
   $date = $_POST['search_date'];
   $customer = $_POST['customer'];

   if($customer=="all"){
     $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `u`.`date` = '$date'";

     // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' ";
  }
  else{
  $joinQuery="FROM `tbl_print_dispatch` AS `u` 
       LEFT JOIN (SELECT * FROM `tbl_print_dispatchdetail` AS `ua` GROUP BY `ua`.`tbl_print_dispatch_idtbl_print_dispatch`) AS `ua` ON (`ua`.`tbl_print_dispatch_idtbl_print_dispatch`=`u`.`idtbl_print_dispatch`) JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer`=`u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `u`.`date`= '$date' AND `u`.`tbl_customer_idtbl_customer`='$customer'";


  // $extraWhere = "`u`.`status` IN (1,2) AND `u`.service_date BETWEEN '$from_date' AND '$to_date' AND  `ua`.idtbl_vehicle = '$vehicleregno'";
  }


}
   echo json_encode(
      SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
   );
