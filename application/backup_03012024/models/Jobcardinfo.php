<?php
class Jobcardinfo extends CI_Model {

    public function Getcustomerlist() {
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getmateriallist() {
        $this->db->select('`idtbl_print_material_info`, `materialname`');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }

    public function get_jobs_by_customer($customer_id) {
        $this->db->select('idtbl_customer_job_details, job_name, job_code');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('tbl_customer_idtbl_customer', $customer_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_job_details_by_job_id($job_id) {
        $this->db->select('idtbl_customerinquiry_detail, job_no');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('job_id', $job_id);
        $query = $this->db->get();
        return $query->result();
    }


}