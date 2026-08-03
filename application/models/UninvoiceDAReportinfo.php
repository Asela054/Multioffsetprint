<?php

class UninvoiceDAReportinfo extends CI_Model {
    public function Customerget() {


        $company_id = $this->session->userdata('company_id');

        $this->db->select('`idtbl_customer`, `customer`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        $this->db->where('tbl_company_idtbl_company', $company_id);
        $this->db->order_by('customer', 'ASC');
       
		$respond=$this->db->get();
        return $respond;

    }
    
}