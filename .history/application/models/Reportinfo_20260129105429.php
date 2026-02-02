<?php

class Reportinfo extends CI_Model {

    public function Categoryget() {

        $this->db->select('group, idtbl_material_type');
        $this->db->from('tbl_material_type');
        $this->db->where('status', 1);

		$respond=$this->db->get();
        return $respond;

    }

    public function stockReport() {
        $type=$this->input->post('type');
		$category=$this->input->post('category');
        $companyID=$_SESSION['company_id'];
      
        $this->db->select('tbl_print_stock.idtbl_print_stock, tbl_print_stock.batchno,tbl_location.location,tbl_print_stock.qty,tbl_print_stock.unitprice,tbl_print_stock.total,tbl_print_material_info.materialname,tbl_material_type.paper');
        $this->db->from('tbl_print_stock');
        $this->db->join('tbl_location', 'tbl_location.idtbl_location = tbl_print_stock.location', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_stock.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_material_type', 'tbl_material_type.idtbl_material_type = tbl_print_material_info.tbl_material_type_idtbl_material_type', 'left');
        
        if ($type == '1') {
            $this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info IS NOT NULL', null, false);
            $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
        
            if ($category == '0') {
                $this->db->where_in('tbl_print_stock.status', [1, 2]);
                $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
            } else {
                $this->db->where_in('tbl_print_stock.status', [1, 2]);
                $this->db->where('tbl_material_type.idtbl_material_type', $category);
                $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
            }
        } elseif ($type == '2' || $type == '3') {
            $this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info IS NOT NULL', null, false);
            $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
        }
        
        $query = $this->db->get();
        $result = $query->result();

        echo json_encode($result);

        
      
        
    }
    
}