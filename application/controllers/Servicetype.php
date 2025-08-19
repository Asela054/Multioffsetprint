<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Servicetype extends CI_Controller {

	public function index(){
		$this->load->model('Servicetypeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('servicetype', $result);
	}
    public function Servicetypeinsertupdate(){
		$this->load->model('Servicetypeinfo');
        $result=$this->Servicetypeinfo->Servicetypeinsertupdate();
	}
    public function Servicetypeedit(){
		$this->load->model('Servicetypeinfo');
        $result=$this->Servicetypeinfo->Servicetypeedit();
	}
    public function Servicetypestatus($x, $y){
		$this->load->model('Servicetypeinfo');
        $result=$this->Servicetypeinfo->Servicetypestatus($x, $y);
	}

}