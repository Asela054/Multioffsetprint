<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Material extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['measurement']=$this->Materialinfo->Getmeasurement();
        $result['materialcategory']=$this->Materialinfo->Getmaterialcategory();
		$result['materialcolor']=$this->Materialinfo->Getmaterialcolor();
		$result['materialcategorygauge']=$this->Materialinfo->Getmaterialcategorygauge();
		$result['supplierlist']=$this->Materialinfo->Getsupplier();
		$this->load->view('material', $result);
	}
    public function Materialinsertupdate(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialinsertupdate();
	}
    public function Materialstatus($x, $y){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialstatus($x, $y);
	}
    public function Materialedit(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialedit();
	}
    public function Materialupload(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialupload();
	}
    public function Materialcheck(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialcheck();
	}
    public function Getlabelinforaccomaterial(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Getlabelinforaccomaterial();
	}
    public function Getgrninfoaccogrnid(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Getgrninfoaccogrnid();
	}
	public function Getmaterialinfo(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Getmaterialinfo();
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
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->UOMqtyinsert();
	}
	public function Getadduomqty(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Getadduomqty();
	}
	
}