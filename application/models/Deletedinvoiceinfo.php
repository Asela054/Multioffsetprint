<?php

class Deletedinvoiceinfo extends CI_Model {

    public function Customerget() {

        $comapnyID=$_SESSION['company_id'];

        $this->db->select('customer, idtbl_customer');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);  
        $this->db->where('company_id', $comapnyID);     
		$respond=$this->db->get();
        
        return $respond;

    }
    
}