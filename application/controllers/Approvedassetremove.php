<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Approvedassetremove extends CI_Controller {
    public function index(){
		$this->load->model('Approvedassetremoveinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('approvedassetremove',$result);
	}

	public function Approvedassetremoveedit(){
		$this->load->model('Approvedassetremoveinfo');
        $result=$this->Approvedassetremoveinfo->Approvedassetremoveedit();
	}
	
}
