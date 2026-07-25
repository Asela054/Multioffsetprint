<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Vehicleservicereportinfo extends CI_Model{


public function ServiceTypeget(){

$this->db->select('idtbl_service_type,service_name');
$this->db->where('status',1);

return $this->db->get('tbl_service_type');

}


}