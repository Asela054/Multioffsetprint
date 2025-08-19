<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Jobcard extends CI_Controller {
	public function index(){
		$this->load->model('Jobcardinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Jobcardinfo->Getcustomerlist();
		$result['materiallist']=$this->Jobcardinfo->Getmateriallist();
		$this->load->view('jobcard', $result);
	}
	// public function Chargesinsertupdate(){
	// 	$this->load->model('Chargesinfo');
    //     $result=$this->Chargesinfo->Chargesinsertupdate();
	// }
	// public function Chargesedit(){
	// 	$this->load->model('Chargesinfo');
    //     $result=$this->Chargesinfo->Chargesedit();
	// }
	// public function Chargesstatus($x, $y){
	// 	$this->load->model('Chargesinfo');
    //     $result=$this->Chargesinfo->Chargesstatus($x, $y);
	// }


	public function get_jobs_by_customer() {
		$this->load->model('Jobcardinfo');
        $customer_id = $this->input->post('customer_id');
        if ($customer_id) {
            $jobs = $this->Jobcardinfo->get_jobs_by_customer($customer_id);
            $data = [];
            foreach ($jobs as $job) {
                $data[] = [
                    'idtbl_customer_job_details' => $job->idtbl_customer_job_details,
                    'job_name' => $job->job_name
                ];
            }
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

	public function get_job_details_by_job_id() {
		$this->load->model('Jobcardinfo');
        $job_id = $this->input->post('job_id');
        if ($job_id) {
            $job_details = $this->Jobcardinfo->get_job_details_by_job_id($job_id);
			$data2 = [];
            foreach ($job_details as $job) {
                $data2[] = [
                    'idtbl_customerinquiry_detail' => $job->idtbl_customerinquiry_detail,
                    'job_no' => $job->job_no
                ];
            }
            echo json_encode($data2);
        } else {
            echo json_encode([]);
        }
    }



}
