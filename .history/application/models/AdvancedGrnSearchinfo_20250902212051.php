<?php

class AdvancedGrnSearchinfo extends CI_Model {
    public function Suppliearget() {

        $this->db->select('suppliername, idtbl_supplier');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

		$respond=$this->db->get();
        return $respond;

    }

    public function Getordertype() {
		$this->db->select('`idtbl_material_group`, `group`');
		$this->db->from('tbl_material_group');
		$this->db->where('status', 1);
		$this->db->where_not_in('idtbl_material_group', array(4));


		return $respond=$this->db->get();
	}
    
}
