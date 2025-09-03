<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class AdvancedGrnSearch extends CI_Controller {

	public function index(){
		$this->load->model('AdvancedGrnSearchinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getsuppier']=$this->AdvancedGrnSearchinfo->Suppliearget();
		$result['ordertypelist']=$this->Goodreceiveinfo->Getordertype();
		$this->load->view('advancedGrnSearch', $result);
	}
}
