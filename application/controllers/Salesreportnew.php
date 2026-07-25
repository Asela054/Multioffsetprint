<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesreportnew extends CI_Controller {

    public function index(){

        $this->load->model('Salesreportnewinfo');
        $this->load->model('Commeninfo');
        $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Salesreportnewinfo->Customerget();

        $this->load->view('salesreportnew',$result);
    }
}