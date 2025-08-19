<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Jobcardissuematerial extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("Commeninfo");
        $this->load->model("Jobcardissuematerialinfo");
    }
    public function index(){
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('jobcardissuematerial',$result);
	}
    public function Getjobissuematerialinfo(){
        $result=$this->Jobcardissuematerialinfo->Getjobissuematerialinfo();
	}
    public function Materialissue(){
        $result=$this->Jobcardissuematerialinfo->Materialissue();
	}
    public function jobCardIssueNote($x){
        $result=$this->Jobcardissuematerialinfo->jobCardIssueNote($x);
	}
    public function Getissuenotelist(){
        $result=$this->Jobcardissuematerialinfo->Getissuenotelist();
	}
}