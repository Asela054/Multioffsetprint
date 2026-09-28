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
    public function Getjobcardissuematerialbatchlist(){
        $result=$this->Jobcardissuematerialinfo->Getjobcardissuematerialbatchlist();
	}
    public function Getbatchnolistaccomaterial(){
        $result=$this->Jobcardissuematerialinfo->Getbatchnolistaccomaterial();
	}
    public function Issuematerialbatchupdate(){
        $result=$this->Jobcardissuematerialinfo->Issuematerialbatchupdate();
	}
    public function Getissuenoteaccounttransfer(){
        $result=$this->Jobcardissuematerialinfo->Getissuenoteaccounttransfer();
	}
    public function Approveissuenote(){
        $result=$this->Jobcardissuematerialinfo->Approveissuenote();
	}
    public function Getjobcardreturndata(){
        $result=$this->Jobcardissuematerialinfo->Getjobcardreturndata();
	}
    public function Getmaterialaccosectiontype(){
        $result=$this->Jobcardissuematerialinfo->Getmaterialaccosectiontype();
    }
    public function Getbatchnoaccomaterial(){
        $result=$this->Jobcardissuematerialinfo->Getbatchnoaccomaterial();
    }
    public function Jobcardreturninsertupdate(){
        $result=$this->Jobcardissuematerialinfo->Jobcardreturninsertupdate();
    }
    public function Jobcardissuematerialreturnstatus($x, $y){
        $result=$this->Jobcardissuematerialinfo->Jobcardissuematerialreturnstatus($x, $y);
    }
    public function Approvejobcardreturnmaterial(){
        $result=$this->Jobcardissuematerialinfo->Approvejobcardreturnmaterial();
    }
}