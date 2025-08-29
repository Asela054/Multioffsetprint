<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialgroup extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialgroupinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('materialgroup', $result);
	}
    public function Materialgroupinsertupdate(){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Materialgroupinsertupdate();
	}
    public function Materialgroupstatus($x, $y){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Materialgroupstatus($x, $y);
	}
    public function Materialgroupedit(){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Materialgroupedit();
	}

    public function Createlabel($mname, $mcode, $grnno, $pono, $mfdate, $expdate, $batchno){
		$this->load->library('Fpdf_gen');
		
		$pdf=new RPDF('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->SetFontSize(12);
		$pdf->TextWithDirection(3,5,'MATERIAL LABEL','R');
		$pdf->SetFont('Arial','',5);
		$pdf->TextWithDirection(3,8,'Name       : '.str_replace('%20', ' ', $mname),'R');
		$pdf->TextWithDirection(3,11,'Code        : '.$mcode,'R');
		$pdf->TextWithDirection(3,14,'GRN No   : '.$grnno,'R');
		$pdf->TextWithDirection(3,17,'PO No      : '.$pono,'R');
        $pdf->TextWithDirection(3,20,'MF Date   : '.$mfdate,'R');
		$pdf->TextWithDirection(3,23,'EXP Date : '.$expdate,'R');
		$pdf->TextWithDirection(3,26,'Batch No  : '.$batchno,'R');
		$pdf->Output();
	}
	public function UOMqtyinsert(){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->UOMqtyinsert();
	}
	public function Getadduomqty(){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Getadduomqty();
	}
	
}