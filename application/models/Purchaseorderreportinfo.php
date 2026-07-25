<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Purchaseorderreportinfo extends CI_Model{


public function Supplierget(){

$this->db->select('idtbl_supplier,suppliername');
$this->db->where('status',1);
return $this->db->get('tbl_supplier');

}


}