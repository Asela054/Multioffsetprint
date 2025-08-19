<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Approvedgoodreceiverequest extends CI_Controller {
    public function index(){
		$this->load->model('Goodreceiverequestinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('approvedgoodreceiverequest',$result);
	}
}
