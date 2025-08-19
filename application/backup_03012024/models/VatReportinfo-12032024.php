<?php

class VatReportinfo extends CI_Model {
    public function Customerget() {

        $this->db->select('name, idtbl_customer');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        $this->db->where('vat_customer', 1);

		$respond=$this->db->get();
        return $respond;

    }
    
}