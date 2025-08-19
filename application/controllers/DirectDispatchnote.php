<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class DirectDispatchnote extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('DirectDispatchnoteinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['measurelist']=$this->DirectDispatchnoteinfo->Getmeasuretype();
		$this->load->view('directdispatchnote', $result);
	}
    public function DirectDispatchnoteinsertupdate(){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->DirectDispatchnoteinsertupdate();
	}
    public function DirectDispatchnotestatus($x, $y){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->DirectDispatchnotestatus($x, $y);
	}
    public function DirectDispatchview(){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->DirectDispatchview();
	}
    public function Directdispatchviewheader(){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->Directdispatchviewheader();
	}
    public function Approdispatch(){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->Approdispatch();
	}
    public function Dispatchnotecheckstatus(){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->Dispatchnotecheckstatus();
	}
    public function Getbatchlist(){
		$this->load->model('DirectDispatchnoteinfo');
        $result=$this->DirectDispatchnoteinfo->Getbatchlist();
	}
    public function pdfget($x) {
        $this->load->model('DirectDispatchPdfviewinfo');
        $this->DirectDispatchPdfviewinfo->pdfdata($x);
    }

    public function GetAllMaterialList(){
		$searchTerm=$this->input->post('searchTerm');
		$searchCategory=json_decode($this->input->post('searchCategory'));
		$result=GetAllMaterialList($searchTerm, $searchCategory);
	}
}