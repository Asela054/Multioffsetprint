<?php

class Customerstatementinfo extends CI_Model {

    public function Customerget(){
        $this->db->select('`idtbl_customer`, `customer`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function customerstatementReport() {
        $customer=$this->input->post('customer');
		// $category=$this->input->post('category');
      
        $this->db->select('tbl_sales_info.invno, tbl_sales_info.invdate,tbl_sales_info.amount,tbl_customer.customer,tbl_print_invoicedetail.job');
        $this->db->from('tbl_sales_info');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_sales_info.tbl_customer_idtbl_customer', 'left');
        $this->db->join('tbl_print_invoicedetail', 'tbl_print_invoicedetail.tbl_print_invoice_idtbl_print_invoice = tbl_sales_info.invno', 'left');
        // $this->db->join('tbl_print_dispatchdetail', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_sales_info.idtbl_customer', 'left');
      
            $this->db->where('tbl_sales_info.status', 1);
            // $this->db->where('tbl_sample_payment_info.status', 1);
            $this->db->where('tbl_sales_info.tbl_customer_idtbl_customer', $customer);
            
        $query = $this->db->get();
        $result = $query->result();

        echo json_encode($result);

        
      
        
    }
    
}