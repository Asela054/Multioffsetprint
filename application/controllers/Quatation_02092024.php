<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Quatation extends CI_Controller {

	public function index(){
		$this->load->model('Quatationinfo');
        $this->load->model('Customerjobsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('quatation', $result);
	}

    public function newquotation(){

        $this->load->model('Quatationinfo');
        $this->load->model('Customerjobsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Quatationinfo->Getcustomerlist();
        $result['measurelist']=$this->Customerjobsinfo->Getmeasuretype();
		$result['materiallist']=$this->Customerjobsinfo->Getmateriallist();
		$result['printingformatlist']=$this->Customerjobsinfo->Getprintingformatlist();
		$result['colorlist']=$this->Customerjobsinfo->Getcolorlist();
		$result['foilinglist']=$this->Customerjobsinfo->Getfoilinglist();
		$result['rimminglist']=$this->Customerjobsinfo->Getrimminglist();
		$result['otherfinishinglist']=$this->Customerjobsinfo->Getotherfinishinglist();
		$result['diecuttinglist']=$this->Customerjobsinfo->Getdiecuttinglist();
		$result['pastinglist']=$this->Customerjobsinfo->Getpastinglist();
		$result['binderylist']=$this->Customerjobsinfo->Getbinderylist();
        $result['platelist']=$this->Quatationinfo->getplates();
        $result['varnishlist']=$this->Quatationinfo->Getmaterialvarnishlist();
		$result['laminationlist']=$this->Quatationinfo->Getmateriallaminationlist();
		$this->load->view('quatationnew', $result);
    }

	public function get_jobs_by_customer() {
		$this->load->model('Quatationinfo');
        $customer_id = $this->input->post('customer_id');
        if ($customer_id) {
            $jobs = $this->Quatationinfo->get_jobs_by_customer($customer_id);
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
        $this->load->model('Quatationinfo');
        $job_id = $this->input->post('job_id');
        if ($job_id) {
            $job_details = $this->Quatationinfo->get_job_details_by_job_id($job_id);
            $data2 = [];
            foreach ($job_details as $job) {
                $data2[] = [
                    'job_id' => $job->job_id,
                    'job_no' => $job->job_no,
                    'qty' => $job->qty,
                ];
            }
            echo json_encode($data2);
        } else {
            echo json_encode([]);
        }
    }

    public function get_boardpaper_batch() {
        $this->load->model('Quatationinfo');
        $boardpaper_id = $this->input->post('boardpaperID');
        if ($boardpaper_id) {
            $jobs = $this->Quatationinfo->get_boardpaper_batch($boardpaper_id);
            $data = [];
            foreach ($jobs as $job) {
                $data[] = [
                    'idtbl_print_stock' => $job->idtbl_print_stock,
                    'batchno' => $job->batchno,
                    'unitprice' => $job->unitprice
                ];
            }
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

    public function getjobinstruction(){
        $this->load->model('Quatationinfo');
        $result=$this->Quatationinfo->getjobinstroctions();
    }
    public function Quotationinsertupdate(){
		$this->load->model('Quatationinfo');
        $result=$this->Quatationinfo->Quotationinsertupdate();
	}
	public function Quotationstatus($x,$z){
		$this->load->model('Quatationinfo');
        $result=$this->Quatationinfo->Quotationstatus($x,$z);
	}

    public function Quotationedit($quotationId){
        $this->load->model('Quatationinfo');
        $this->load->model('Customerjobsinfo');
        $this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['customerlist']=$this->Quatationinfo->Getcustomerlist();
        $result['jobslist']=$this->Quatationinfo->Getjobs();
        $result['jobidlist']=$this->Quatationinfo->getjobsid();

        $result['measurelist']=$this->Customerjobsinfo->Getmeasuretype();;
		$result['printingformatlist']=$this->Customerjobsinfo->Getprintingformatlist();
		$result['colorlist']=$this->Customerjobsinfo->Getcolorlist();
		$result['foilinglist']=$this->Customerjobsinfo->Getfoilinglist();
		$result['rimminglist']=$this->Customerjobsinfo->Getrimminglist();
		$result['otherfinishinglist']=$this->Customerjobsinfo->Getotherfinishinglist();
		$result['diecuttinglist']=$this->Customerjobsinfo->Getdiecuttinglist();
		$result['pastinglist']=$this->Customerjobsinfo->Getpastinglist();
		$result['binderylist']=$this->Customerjobsinfo->Getbinderylist();
        $result['platelist']=$this->Quatationinfo->getplates();

        $result['varnishlist']=$this->Quatationinfo->Getmaterialvarnishlist();
		$result['laminationlist']=$this->Quatationinfo->Getmateriallaminationlist();
        $result['materiallist']=$this->Quatationinfo->Getmateriallist();

        $result['quotationDetails'] = $this->Quatationinfo->Quotationedit($quotationId);
        $this->load->view('quatationedit', $result);
    }
}
