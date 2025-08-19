<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class AdvancedStockSearch extends CI_Controller {

	public function index(){
		$this->load->model('AdvancedStockSearchinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getsuppier']=$this->AdvancedStockSearchinfo->Suppliearget();
		$this->load->view('advancedStockSearch', $result);
	}
}