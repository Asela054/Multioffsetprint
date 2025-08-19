<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Newcustomerjobs extends CI_Controller {
    public function index(){
		$this->load->model('Newcustomerjobsinfo');
		$this->load->model('Jobcardallocationinfo');
		$this->load->model('Materialallocationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['measurelist']=$this->Jobcardallocationinfo->Getmeasuretype();
		$result['printingformatlist']=$this->Jobcardallocationinfo->Getprintingformatlist();
		$result['colorlist']=$this->Jobcardallocationinfo->Getcolorlist();
		$result['varnishlist']=$this->Jobcardallocationinfo->Getvarnishlist();
		$result['laminationlist']=$this->Jobcardallocationinfo->Getlaminationlist();
		$result['foilinglist']=$this->Jobcardallocationinfo->Getfoilinglist();
		$result['machielist']=$this->Jobcardallocationinfo->Getmachinelist();
		$result['rimminglist']=$this->Jobcardallocationinfo->Getrimminglist();
		$this->load->view('newcustomerjobs',$result);
	}
	public function Newcustomerjobsinsertupdate(){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->Newcustomerjobsinsertupdate();
	}
	public function Newcustomerjobsstatus($x,$y){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->Newcustomerjobsstatus($x,$y);
	}
	public function Getcustomerlist(){
		$searchTerm=$this->input->post('searchTerm');
		$result=SearchCustomerList($searchTerm);
	}
	public function GetMaterialList(){
		$searchTerm=$this->input->post('searchTerm');
		$searchCategory=json_decode($this->input->post('searchCategory'));
		$result=GetMaterialList($searchTerm, $searchCategory);
	}
	public function Newcustomerjobbominsertupdate(){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->Newcustomerjobbominsertupdate();
	}
	public function CustomerJobBomstatus($x,$y){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->CustomerJobBomstatus($x,$y);
	}
	public function Newcustomerjobsedit(){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->Newcustomerjobsedit();
	}
	public function Newcustomerjobbomedit(){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->Newcustomerjobbomedit();
	}
	public function viewBomInfo(){
		$this->load->model('Newcustomerjobsinfo');
        $result=$this->Newcustomerjobsinfo->viewBomInfo();
	}
}
