<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Service extends CI_Controller {
    public function index(){
	    $this->load->model('Serviceinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		 $result['ServiceType']=$this->Serviceinfo->Getservicetype();
		 $result['VehicleRegNo']=$this->Serviceinfo->Getvehicleregno();
		 $result['Supplier']=$this->Serviceinfo->Getsupplier();
		$this->load->view('service',$result);
	}
   
	public function serviceinsertupdate(){
		$this->load->model('Serviceinfo');
        $result=$this->Serviceinfo->serviceinsertupdate();
	}
	public function serviceedit(){
		$this->load->model('Serviceinfo');
        $result=$this->Serviceinfo->serviceedit();
	}
	public function servicestatus($x, $y){
		$this->load->model('Serviceinfo');
        $result=$this->Serviceinfo->servicestatus($x, $y);
	}

	public function mileage(){
        $this->load->model('Serviceinfo');
        $result=$this->Serviceinfo->mileage();
    }
	public function getitem(){
        $this->load->model('Serviceinfo');
        $result=$this->Serviceinfo->getitem();
    }
	public function uploadimg(){
        $this->load->model('Serviceinfo');
        $result=$this->Serviceinfo->uploadimg();
    }
	
}