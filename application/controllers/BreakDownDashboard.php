<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class BreakDownDashboard extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Breakdowndashboardinfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['fixedBreakdowns']=$this->Breakdowndashboardinfo->GetFixedBreakDowms();
		$result['fixedAndNotStarted']=$this->Breakdowndashboardinfo->GetFixedAndNotStartedBreakDowms();
		$result['acceptedbreakdown']=$this->Breakdowndashboardinfo->GetAcceptedBreakDowms();
		$result['newBreakdown']=$this->Breakdowndashboardinfo->GetNewBreakDowms();

		$this->load->view('breakdowndashboard', $result);
	}

    public function AcceptBreakDown($x){
		$this->load->model('Breakdowndashboardinfo');
        $result=$this->Breakdowndashboardinfo->AcceptBreakDown($x);
	}
    public function CompleteBreakdown($x, $y){
		$this->load->model('Breakdowndashboardinfo');
        $result=$this->Breakdowndashboardinfo->CompleteBreakdown($x, $y);
	}

}