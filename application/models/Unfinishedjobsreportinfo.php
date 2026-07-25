<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unfinishedjobsreportinfo extends CI_Model{

    // Customer dropdown for the filter
    public function Customerget(){
        $this->db->select('`idtbl_customer`, `customer`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        $this->db->order_by('customer', 'ASC');

        return $respond=$this->db->get();
    }
}