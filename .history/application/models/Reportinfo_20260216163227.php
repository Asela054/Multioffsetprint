<?php

class Reportinfo extends CI_Model {

    public function Categoryget() {

        $this->db->select('group, idtbl_material_group');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

		$respond=$this->db->get();
        return $respond;

    }

public function stockReport() {
    $category   = $this->input->post('category'); // material group id or 'by_customer'
    $customer   = $this->input->post('customer'); // customer id if selected
    $companyID  = $_SESSION['company_id'];

    $this->db->select('
        tbl_print_stock.idtbl_print_stock,
        tbl_print_stock.batchno,
        tbl_location.location,
        tbl_print_stock.qty,
        tbl_print_stock.unitprice,
        tbl_print_stock.total,
        tbl_print_material_info.materialname,
        tbl_material_group.group,
        tbl_print_material_info.tbl_customer_idtbl_customer
    ');

    $this->db->from('tbl_print_stock');
    $this->db->join('tbl_location', 'tbl_location.idtbl_location = tbl_print_stock.location', 'left');
    $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_stock.tbl_print_material_info_idtbl_print_material_info', 'left');
    $this->db->join('tbl_material_group', 'tbl_material_group.idtbl_material_group = tbl_print_material_info.tbl_material_group_idtbl_material_group', 'left');

    $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
    $this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info IS NOT NULL', null, false);
    $this->db->where_in('tbl_print_stock.status', [1, 2]);

    // Filter by category (material group) if not '0' or 'by_customer'
    if ($category != '0' && $category != '' && $category != 'by_customer') {
        $this->db->where('tbl_print_material_info.tbl_material_group_idtbl_material_group', $category);
    }

    // Filter by customer if category is 'by_customer' and customer selected
    if ($category == 'by_customer' && !empty($customer)) {
        $this->db->where('tbl_print_material_info.tbl_customer_idtbl_customer', $customer);
    }

    $query  = $this->db->get();
    $result = $query->result();

    echo json_encode($result);
}


    
}