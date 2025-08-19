<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class ServiceItemAllocate extends CI_Controller {
 
	public function index(){
		$this->load->model('ServiceItemAllocateinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['serviceno']=$this->ServiceItemAllocateinfo->Getserviceno();
		$this->load->view('serviceitemallocate', $result);
	}
	public function Getmachineservicedetails(){
		$this->load->model('ServiceItemAllocateinfo');
        $result=$this->ServiceItemAllocateinfo->Getmachineservicedetails();
	}

	public function ServiceItemAllocateinsert(){
		$this->load->model('ServiceItemAllocateinfo');
        $result=$this->ServiceItemAllocateinfo->ServiceItemAllocateinsert();
	}

	public function AllocatedServiceItemView(){
		$this->load->model('ServiceItemAllocateinfo');
        $result=$this->ServiceItemAllocateinfo->AllocatedServiceItemView();
	}

	public function ServiceItemAllocateedit(){
		$this->load->model('ServiceItemAllocateinfo');
        $result=$this->ServiceItemAllocateinfo->ServiceItemAllocateedit();
	}
	public function ServiceItemAllocateupdate(){
		$this->load->model('ServiceItemAllocateinfo');
        $result=$this->ServiceItemAllocateinfo->ServiceItemAllocateupdate();
	}
}
