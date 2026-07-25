<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesreportnewinfo extends CI_Model{

    public function Customerget(){

        $this->db->select('idtbl_customer, customer');
        $this->db->from('tbl_customer');
        $this->db->where('status',1);
        $this->db->order_by('customer','ASC');

        return $this->db->get();
    }
}