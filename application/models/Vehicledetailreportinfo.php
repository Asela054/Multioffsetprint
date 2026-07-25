<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Vehicledetailreportinfo extends CI_Model{


public function VehicleModelget(){

$this->db->select('idtbl_vehicle_model,vehicle_model');
$this->db->where('status',1);
return $this->db->get('tbl_vehicle_model');

}



public function VehicleBrandget(){

$this->db->select('idtbl_vehicle_brand,vehicle_brand');
$this->db->where('status',1);
return $this->db->get('tbl_vehicle_brand');

}


}