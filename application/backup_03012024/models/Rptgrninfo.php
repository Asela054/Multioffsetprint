<?php

class Rptgrninfo extends CI_Model {
    public function Suppliearget() {

        $this->db->select('name, idtbl_supplier');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

		$respond=$this->db->get();
        return $respond;

    }
    
}