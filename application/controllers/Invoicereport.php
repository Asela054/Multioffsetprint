<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicereport extends CI_Controller {

    public function index(){

        $this->load->model('InvoiceReportinfo');
        $this->load->model('Commeninfo');
        $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->InvoiceReportinfo->Customerget();

        $this->load->view('invoicereport',$result);
    }
}