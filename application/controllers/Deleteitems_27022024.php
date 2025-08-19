<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Deleteitems extends CI_Controller {

    public function index(){
		$this->load->model('Deleteitemsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('deleteitems',$result);
	}

    public function CustomerView(){ // Customer
		$data['check'] = 1;
		$this->load->view('deleteviewdata', $data);
	}
    public function SupplierView(){ // Supplier
		$data['check'] = 2;
		$this->load->view('deleteviewdata', $data);
	}
	public function GRNView(){ // GRN
		$data['check'] = 3;
		$this->load->view('deleteviewdata', $data);
	}
	public function PORView(){ // POR
		$data['check'] = 4;
		$this->load->view('deleteviewdata', $data);
	}

}