<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Jobs extends CI_Controller {
    public function index(){
		$recordId = $_GET['recordId'];

		$this->load->model('Jobsinfo');
		$this->load->model('Commeninfo');
		$this->load->model('Machineinfo');
		$this->load->model('Boardinfo');
		$this->load->model('Colorinfo');
		$this->load->model('Varnishinfo');
		$this->load->model('Laminationinfo');
		$this->load->model('Rimminginfo');
		$this->load->model('Platesinfo');
		$this->load->model('Foilinginfo');


		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['machineList']=$this->Machineinfo->GetMachineList();
		$result['boardList']=$this->Boardinfo->GetBoardList();
		$result['colorList']=$this->Colorinfo->GetColorList();
		$result['varnishList']=$this->Varnishinfo->GetVarnishList();
		$result['laminationList']=$this->Laminationinfo->GetLaminationList();
		$result['rimmingList']=$this->Rimminginfo->GetRimmingList();
		$result['platesList']=$this->Platesinfo->GetPlatesList();
		$result['foilingList']=$this->Foilinginfo->GetFoilingList();
		$result['jobId']=$recordId;

		$this->load->view('jobs',$result);
	}

	public function FetchPassedValue($x){
		$recordId = $x;

		$this->load->model('Jobsinfo');
		$this->load->model('Commeninfo');
		$this->load->model('Machineinfo');
		$this->load->model('Boardinfo');
		$this->load->model('Colorinfo');
		$this->load->model('Varnishinfo');
		$this->load->model('Laminationinfo');
		$this->load->model('Rimminginfo');
		$this->load->model('Platesinfo');
		$this->load->model('Foilinginfo');


		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['machineList']=$this->Machineinfo->GetMachineList();
		$result['materialList']=$this->Jobsinfo->GetMaterialList();
		$result['boardList']=$this->Boardinfo->GetBoardList();
		$result['colorList']=$this->Colorinfo->GetColorList();
		$result['varnishList']=$this->Varnishinfo->GetVarnishList();
		$result['laminationList']=$this->Laminationinfo->GetLaminationList();
		$result['rimmingList']=$this->Rimminginfo->GetRimmingList();
		$result['platesList']=$this->Platesinfo->GetPlatesList();
		$result['foilingList']=$this->Foilinginfo->GetFoilingList();
		$result['jobId']=$recordId;
		$result['jobDetails']=$this->Jobsinfo->GetPrimaryJob($recordId);


		$this->load->view('jobs',$result);
	}
   
	public function JobInsertUpdate(){
		$this->load->model('Jobsinfo');
        $result=$this->Jobsinfo->JobInsertUpdate();
	}

	
}
