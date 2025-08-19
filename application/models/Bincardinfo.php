<?php

class Bincardinfo extends CI_Model {

    public function Materialget(){
        $comapnyID=$_SESSION['company_id'];

        $this->db->select('`idtbl_print_material_info`, `materialname`');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        $this->db->where('company_id', $comapnyID);

        return $respond=$this->db->get();
    }

    public function bincardReport() {
        $material=$this->input->post('material');
      
        $this->db->select('tbl_print_grndetail.date, tbl_print_grndetail.qty,tbl_print_grndetail.tbl_print_grn_idtbl_print_grn,tbl_print_grndetail.comment,tbl_print_material_info.materialname');
        $this->db->from('tbl_print_grndetail');
        $this->db->join('tbl_print_grn', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info', 'left');
      
            $this->db->where('tbl_print_grndetail.status', 1);
            $this->db->where('tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info', $material);
            
        $query = $this->db->get();
        $result = $query->result();

        echo json_encode($result);

        
      
        
    }
    
}