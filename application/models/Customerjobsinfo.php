<?php
class Newcustomerjobsinfo extends CI_Model{

	public function GetCustomerjobid($x){
          $customerid = $x;
		return $respond=$customerid;
	}
    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
    public function Getmateriallist() {
        $this->db->select('`idtbl_print_material_info`, `materialname`');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }

    public function Getprintingformatlist() {
        $this->db->select('`idtbl_printing_format`,`format_name`,`printing_width`,`printing_height`');
        $this->db->from('tbl_printing_format');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }

    // public function Getcolorlist() {
    //     $this->db->select('`idtbl_print_color`,`color_name`');
    //     $this->db->from('tbl_print_color');
    //     $this->db->where('status', 1);
    //     return $respond=$this->db->get();
    // }
    public function Getcolorlist() {
        $this->db->select('`idtbl_color`,`color`');
        $this->db->from('tbl_color');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getvarnishlist() {
        $this->db->select('`idtbl_varnish`,`varnish`');
        $this->db->from('tbl_varnish');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getlaminationlist() {
        $this->db->select('`idtbl_lamination`,`lamination`');
        $this->db->from('tbl_lamination');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getfoilinglist() {
        $this->db->select('`idtbl_foiling`,`foiling`');
        $this->db->from('tbl_foiling');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    } 
    public function Getrimminglist() {
        $this->db->select('`idtbl_rimming`,`rimming`');
        $this->db->from('tbl_rimming');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    } 
    
    public function Getotherfinishinglist() {
        $this->db->select('`idtbl_finishing_other`,`finishing_other`');
        $this->db->from('tbl_finishing_other');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getdiecuttinglist() {
        $this->db->select('`idtbl_diecutting`,`diecutting_name`');
        $this->db->from('tbl_diecutting');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getpastinglist() {
        $this->db->select('`idtbl_pasting`,`pasting_name`');
        $this->db->from('tbl_pasting');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getbinderylist() {
        $this->db->select('`idtbl_bindery`,`bindery_name`');
        $this->db->from('tbl_bindery');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }


	public function Newcustomerjobsinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $jobname=$this->input->post('jobname');
		$jobcode=$this->input->post('jobcode');
		$uom=$this->input->post('uom');
		$unitprice=$this->input->post('unitprice');
		$customerid=$this->input->post('customerid');

        $jobdiscription=$this->input->post('jobdiscription');

        $sizeL=$this->input->post('sizeL');
        $sizeW=$this->input->post('sizeW');
        $sizeH=$this->input->post('sizeH');
        $sizelabelL=$this->input->post('sizelabelL');
        $sizelabelW=$this->input->post('sizelabelW');

        $cutmaterial=$this->input->post('cutmaterial');
        $paperboard=$this->input->post('paperboard');
        $cutsize1=$this->input->post('cutsize1');
        $cutsize2=$this->input->post('cutsize2');
        $noups=$this->input->post('noups');
      
        $printingcolor=$this->input->post('printingcolor');

        $coatingvarnish=$this->input->post('coatingvarnish');

        $laminations=$this->input->post('laminations');
        $lam_option=$this->input->post('lam_option');
        $filmsize=$this->input->post('filmsize');
        $micron=$this->input->post('micron');

        $foiling=$this->input->post('foiling');
        $rimming=$this->input->post('rimming');
        $rimm_option=$this->input->post('rimm_option');
        $rimm_length=$this->input->post('rimm_length');
        $otherfinish=$this->input->post('otherfinish');
        $pachingl=$this->input->post('pachingl');
        $pachingw=$this->input->post('pachingw');
        $patchmicron=$this->input->post('patchmicron');

        $diecutting=$this->input->post('diecutting');
        $pasting=$this->input->post('pasting');
        $Adhesivesname=$this->input->post('Adhesivesname');

        $bindery=$this->input->post('bindery');

        $delivery_option=$this->input->post('delivery_option');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'job_name'=> $jobname, 
				'job_code'=> $jobcode, 
				'measure_type_id'=> $uom, 
				'unitprice'=> $unitprice, 
                'carton_L'=> $sizeL, 
                'carton_W'=> $sizeW, 
                'carton_H'=> $sizeH, 
                'Label_L'=> $sizelabelL,
                'label_W'=> $sizelabelW,
				'tbl_customer_idtbl_customer'=> $customerid, 
                'job_discription'=> $jobdiscription, 
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime,
                'tbl_printing_format_idtbl_printing_format'=> $cutmaterial, 
                'tbl_print_material_info_idtbl_print_material_info'=> $paperboard, 
                'cutsize_W'=> $cutsize1, 
                'cutsize_H'=> $cutsize2, 
                'no_of_ups'=> $noups, 
                'tbl_print_color_idtbl_print_color'=> $printingcolor, 
                'tbl_varnish_idtbl_varnish'=> $coatingvarnish, 
                'tbl_lamination_idtbl_lamination'=> $laminations, 
                'printside'=> $lam_option, 
                'lamination_filmsize'=> $filmsize, 
                'lamination_micron'=> $micron, 
                'tbl_foiling_idtbl_foiling'=> $foiling, 
                'tbl_rimming_idtbl_rimming'=> $rimming, 
                'rimming_side'=> $rimm_option, 
                'rimming_length'=> $rimm_length, 
                'tbl_finishing_other_idtbl_finishing_other'=> $otherfinish, 
                'windowpatch_L'=> $pachingl, 
                'windowpatch_W'=> $pachingw, 
                'windowpatch_micron'=> $patchmicron, 
                'tbl_diecutting_idtbl_diecutting'=> $diecutting,
                'tbl_pasting_idtbl_pasting'=> $pasting,
                'adhesive_name'=> $Adhesivesname,
                'tbl_bindery_idtbl_bindery'=> $bindery,
                'delivery_by'=> $delivery_option,
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_customer_job_details', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Added Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Newcustomerjobs/index/'.$customerid);                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Newcustomerjobs/index/'.$customerid);
            }
        }
        else{
            $data = array(
               'job_name'=> $jobname, 
				'job_code'=> $jobcode, 
				'measure_type_id'=> $uom, 
				'unitprice'=> $unitprice, 
                'carton_L'=> $sizeL, 
                'carton_W'=> $sizeW, 
                'carton_H'=> $sizeH, 
                'Label_L'=> $sizelabelL,
                'label_W'=> $sizelabelW,
				'tbl_customer_idtbl_customer'=> $customerid,
                'job_discription'=> $jobdiscription, 
                'updatedatetime'=> $insertdatetime,
                'tbl_printing_format_idtbl_printing_format'=> $cutmaterial, 
                'tbl_print_material_info_idtbl_print_material_info'=> $paperboard, 
                'cutsize_W'=> $cutsize1, 
                'cutsize_H'=> $cutsize2, 
                'no_of_ups'=> $noups, 
                'tbl_print_color_idtbl_print_color'=> $printingcolor, 
                'tbl_varnish_idtbl_varnish'=> $coatingvarnish, 
                'tbl_lamination_idtbl_lamination'=> $laminations, 
                'printside'=> $lam_option, 
                'lamination_filmsize'=> $filmsize, 
                'lamination_micron'=> $micron, 
                'tbl_foiling_idtbl_foiling'=> $foiling, 
                'tbl_rimming_idtbl_rimming'=> $rimming, 
                'rimming_side'=> $rimm_option, 
                'rimming_length'=> $rimm_length, 
                'tbl_finishing_other_idtbl_finishing_other'=> $otherfinish, 
                'windowpatch_L'=> $pachingl, 
                'windowpatch_W'=> $pachingw, 
                'windowpatch_micron'=> $patchmicron, 
                'tbl_diecutting_idtbl_diecutting'=> $diecutting,
                'tbl_pasting_idtbl_pasting'=> $pasting,
                'adhesive_name'=> $Adhesivesname,
                'tbl_bindery_idtbl_bindery'=> $bindery,
                'delivery_by'=> $delivery_option,
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_customer_job_details', $recordID);
            $this->db->update('tbl_customer_job_details', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
				redirect('Newcustomerjobs/index/'.$customerid);                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
				redirect('Newcustomerjobs/index/'.$customerid);
            }
        }
    }

	public function Newcustomerjobsstatus($x,$z,$y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
		$customerid=$z;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customer_job_details', $recordID);
            $this->db->update('tbl_customer_job_details', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
				redirect('Newcustomerjobs/index/'.$customerid);             
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
				redirect('Newcustomerjobs/index/'.$customerid);
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customer_job_details', $recordID);
            $this->db->update('tbl_customer_job_details', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
				redirect('Newcustomerjobs/index/'.$customerid);               
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Newcustomerjobs/index/'.$customerid);
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('idtbl_customer_job_details', $recordID);
            $this->db->update('tbl_customer_job_details', $data);


            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Newcustomerjobs/index/'.$customerid);             
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
				redirect('Newcustomerjobs/index/'.$customerid);
            }
        }
    }
	public function Newcustomerjobsedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('idtbl_customer_job_details', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customer_job_details;
        $obj->job_name=$respond->row(0)->job_name;
        $obj->job_discription=$respond->row(0)->job_discription; 
		$obj->job_code=$respond->row(0)->job_code;
		$obj->measure_type_id=$respond->row(0)->measure_type_id;
		$obj->unitprice=$respond->row(0)->unitprice;
        $obj->carton_L=$respond->row(0)->carton_L;
		$obj->carton_W=$respond->row(0)->carton_W;
		$obj->carton_H=$respond->row(0)->carton_H;
		$obj->Label_L=$respond->row(0)->Label_L;
        $obj->label_W=$respond->row(0)->label_W;
		$obj->idtbl_printing_format=$respond->row(0)->tbl_printing_format_idtbl_printing_format;
		$obj->idtbl_print_material_info=$respond->row(0)->tbl_print_material_info_idtbl_print_material_info;
		$obj->cutsize_W=$respond->row(0)->cutsize_W;
        $obj->cutsize_H=$respond->row(0)->cutsize_H;
		$obj->no_of_ups=$respond->row(0)->no_of_ups;
		$obj->idtbl_print_color=$respond->row(0)->tbl_print_color_idtbl_print_color;
		$obj->idtbl_varnish=$respond->row(0)->tbl_varnish_idtbl_varnish;
        $obj->idtbl_lamination=$respond->row(0)->tbl_lamination_idtbl_lamination;
		$obj->printside=$respond->row(0)->printside;
		$obj->lamination_filmsize=$respond->row(0)->lamination_filmsize;
		$obj->lamination_micron=$respond->row(0)->lamination_micron;
        $obj->idtbl_foiling=$respond->row(0)->tbl_foiling_idtbl_foiling;
		$obj->idtbl_rimming=$respond->row(0)->tbl_rimming_idtbl_rimming;
		$obj->rimming_side=$respond->row(0)->rimming_side;
		$obj->rimming_length=$respond->row(0)->rimming_length;
        $obj->idtbl_finishing_other=$respond->row(0)->tbl_finishing_other_idtbl_finishing_other;
		$obj->windowpatch_L=$respond->row(0)->windowpatch_L;
		$obj->windowpatch_W=$respond->row(0)->windowpatch_W;
		$obj->windowpatch_micron=$respond->row(0)->windowpatch_micron;
        $obj->idtbl_diecutting=$respond->row(0)->tbl_diecutting_idtbl_diecutting;
		$obj->idtbl_pasting=$respond->row(0)->tbl_pasting_idtbl_pasting;
		$obj->adhesive_name=$respond->row(0)->adhesive_name;
		$obj->idtbl_bindery=$respond->row(0)->tbl_bindery_idtbl_bindery;
        $obj->delivery_by=$respond->row(0)->delivery_by;
        echo json_encode($obj);
    }
}
