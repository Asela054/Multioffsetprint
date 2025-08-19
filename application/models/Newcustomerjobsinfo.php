<?php
class Newcustomerjobsinfo extends CI_Model{
    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
    public function Getprintingformatlist() {
        $this->db->select('`idtbl_printing_format`,`format_name`,`printing_width`,`printing_height`');
        $this->db->from('tbl_printing_format');
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
    public function Getrimminglist() {
        $this->db->select('`idtbl_rimming`,`rimming`');
        $this->db->from('tbl_rimming');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getcolorlist() {
        $this->db->select('`idtbl_color`,`color`');
        $this->db->from('tbl_color');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getfoilinglist() {
        $this->db->select('`idtbl_foiling`,`foiling`');
        $this->db->from('tbl_foiling');
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

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'job_name'=> $jobname, 
				'job_code'=> $jobcode, 
				'tbl_measurements_idtbl_measurements'=> $uom, 
				'unitprice'=> $unitprice, 
                'carton_L'=> $sizeL, 
                'carton_W'=> $sizeW, 
                'carton_H'=> $sizeH, 
                'Label_L'=> $sizelabelL,
                'label_W'=> $sizelabelW,
				'tbl_customer_idtbl_customer'=> $customerid, 
                'job_discription'=> $jobdiscription, 
                'status'=> '1', 
                'updatedatetime'=> $updatedatetime,
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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
            }
        }
        else{
            $data = array(
                'job_name'=> $jobname, 
				'job_code'=> $jobcode, 
				'tbl_measurements_idtbl_measurements'=> $uom, 
				'unitprice'=> $unitprice, 
                'carton_L'=> $sizeL, 
                'carton_W'=> $sizeW, 
                'carton_H'=> $sizeH, 
                'Label_L'=> $sizelabelL,
                'label_W'=> $sizelabelW,
				'tbl_customer_idtbl_customer'=> $customerid, 
                'job_discription'=> $jobdiscription, 
                'updatedatetime'=> $updatedatetime,
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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
            }
        }
    }
    public function Newcustomerjobsedit(){
        $recordID=$this->input->post('recordID');

		$this->db->select('tbl_customer_job_details.*, tbl_customer.customer');
		$this->db->from('tbl_customer_job_details');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customer_job_details.tbl_customer_idtbl_customer', 'left');
		$this->db->where('tbl_customer_job_details.idtbl_customer_job_details', $recordID);
		$this->db->where('tbl_customer_job_details.status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_customer_job_details;
		$obj->job_name=$respond->row(0)->job_name;
		$obj->job_code=$respond->row(0)->job_code;
		$obj->mesureid=$respond->row(0)->tbl_measurements_idtbl_measurements;
		$obj->unitprice=$respond->row(0)->unitprice;
		$obj->carton_L=$respond->row(0)->carton_L;
		$obj->carton_W=$respond->row(0)->carton_W;
		$obj->carton_H=$respond->row(0)->carton_H;
		$obj->Label_L=$respond->row(0)->Label_L;
		$obj->label_W=$respond->row(0)->label_W;
		$obj->customerid=$respond->row(0)->tbl_customer_idtbl_customer;
		$obj->customer=$respond->row(0)->customer;
		$obj->job_discription=$respond->row(0)->job_discription;

		echo json_encode($obj);
    }
	public function Newcustomerjobsstatus($x,$y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
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
				redirect('Newcustomerjobs');             
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
				redirect('Newcustomerjobs');
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
				redirect('Newcustomerjobs');               
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
                redirect('Newcustomerjobs');
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
                redirect('Newcustomerjobs');             
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
				redirect('Newcustomerjobs');
            }
        }
    }
    public function Newcustomerjobbominsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $jobid=$this->input->post('jobid');
		$bomtitle=$this->input->post('bomtitle');
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}
        
        $materialTable = $this->input->post('materialTable');
        $colorTable = $this->input->post('colorTable');
        $varnishTable = $this->input->post('varnishTable');
        $foilTable = $this->input->post('foilTable');
        $laminationTable = $this->input->post('laminationTable');
        $pastingTable = $this->input->post('pastingTable');
        $rimmingTable = $this->input->post('rimmingTable');

        $diecutby=$this->input->post('diecutby');
        $diechannel=$this->input->post('diechannel');
        $dieboard=$this->input->post('dieboard');
        $diesize=$this->input->post('diesize');
        $dieqty=$this->input->post('dieqty');
        $diecutembrossby=$this->input->post('diecutembrossby');
        $otherPerforating=$this->input->post('otherPerforating');
        $otherGattering=$this->input->post('otherGattering');
        $otherRimming=$this->input->post('otherRimming');
        $otherBinding=$this->input->post('otherBinding');
        $otherStapling=$this->input->post('otherStapling');
        $otherPadding=$this->input->post('otherPadding');
        $otherCreasing=$this->input->post('otherCreasing');
        $otherThreading=$this->input->post('otherThreading');
        $delivery=$this->input->post('delivery');

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'jobbomname'=> $bomtitle, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customer_job_details_idtbl_customer_job_details'=> $jobid
            );
            $this->db->insert('tbl_jobcard_bom', $data);
            $jobbomID = $this->db->insert_id(); // Get the inserted ID

            if(!empty($materialTable)){
                foreach($materialTable as $materialData){
                    $printingformatId=$materialData['col_1'];
                    $cutMaterialId=$materialData['col_2'];
                    $cutSize=$materialData['col_5'];
                    $sheetQty=$materialData['col_6'];
                    $wastage=$materialData['col_7'];
                    $stockId=$materialData['col_8'];

                    $materialListData = array(
                        'cutsize'=> $cutSize, 
                        'sheetqty'=> $sheetQty, 
                        'wastage'=> $wastage, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_printing_format_idtbl_printing_format'=> $printingformatId,
                        'tbl_print_material_info_idtbl_print_material_info'=> $cutMaterialId,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID,
                    );
                    $this->db->insert('tbl_jobcard_bom_material', $materialListData);
                }
            }

            if(!empty($varnishTable)){
                foreach($varnishTable as $varnishData){
                    $varnishId=$varnishData['col_1'];
                    $varnishMaterialId=$varnishData['col_2'];
                    $varnishSheetQty=$varnishData['col_5'];
                    $stockId=$varnishData['col_6'];

                    $varnishListData = array(
                        'varnishQty'=> $varnishSheetQty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $varnishMaterialId,
                        'tbl_varnish_idtbl_varnish'=> $varnishId,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
                    );
                    $this->db->insert('tbl_jobcard_bom_varnish', $varnishListData);
                }
            }
        
            if(!empty($laminationTable)){
                foreach($laminationTable as $laminationData){
                    $laminationId=$laminationData['col_1'];
                    $laminationMaterialId=$laminationData['col_2'];
                    $laminationPrintSides=$laminationData['col_3'];
                    $filmSize=$laminationData['col_6'];
                    $micron=$laminationData['col_7'];
                    $laminationsheet_qty=$laminationData['col_9'];
                    $stockId=$laminationData['col_10'];

                    $laminationListData = array(
                        'sides'=> $laminationPrintSides, 
                        'filmsize'=> $filmSize, 
                        'micron'=> $micron, 
                        'lamination_qty'=> $laminationsheet_qty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $laminationMaterialId,
                        'tbl_lamination_idtbl_lamination'=> $laminationId,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
                    );
                    $this->db->insert('tbl_jobcard_bom_lamination', $laminationListData);
                }
            }
        
            if(!empty($rimmingTable)){
                foreach($rimmingTable as $rimmingData){
                    $rimmingId=$rimmingData['col_1'];
                    $rimmingMaterialId=$rimmingData['col_2'];
                    $printedSides=$rimmingData['col_3'];
                    $length=$rimmingData['col_6'];
                    $rimmingQty=$rimmingData['col_8'];
                    $stockId=$rimmingData['col_9'];

                    $rimmingListData = array(
                        'sides'=> $printedSides, 
                        'length'=> $length, 
                        'qty'=> $rimmingQty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $rimmingMaterialId,
                        'tbl_rimming_idtbl_rimming'=> $rimmingId,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
                    );
                    $this->db->insert('tbl_jobcard_bom_rimming', $rimmingListData);
                }
            }
            
            if(!empty($diecuttingTable)){
                foreach($diecuttingTable as $dieCuttingData){
                    $peraforation=$dieCuttingData['col_1'];
                    $halfCutting=$dieCuttingData['col_2'];
                    $fullCutting=$dieCuttingData['col_3'];
                    $qty=$dieCuttingData['col_4'];

                    $dieCuttingListData = array(
                        'peraforation'=> $peraforation, 
                        'halfCutting'=> $halfCutting, 
                        'fullCutting'=> $fullCutting, 
                        'qty'=> $qty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
                    );
                    $this->db->insert('tbl_jobcard_bom_diecutting', $dieCuttingListData);
                }
            }

            if(!empty($colorTable)){
                foreach($colorTable as $colorData){
                    $cmyk=$colorData['col_1'];
                    $metlic=$colorData['col_2'];
                    $anyother=$colorData['col_3'];
                    $colormaterialID=$colorData['col_4'];
                    $colorqty=$colorData['col_7'];
                    $remark=$colorData['col_8'];

                    $datacolor = array(
                        'cmyk'=> $cmyk, 
                        'metlic'=> $metlic, 
                        'anyother'=> $anyother, 
                        'remark'=> $remark, 
                        'qty'=> $colorqty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $colormaterialID
                    );
                    $this->db->insert('tbl_jobcard_bom_color', $datacolor);
                }
            }

            if(!empty($otherTable)){
                foreach($otherTable as $otherData){
                    $othermaterialID=$otherData['col_1'];
                    $otherqty=$otherData['col_3'];

                    $dataOther = array(
                        'qty'=> $otherqty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $othermaterialID
                    );
                    $this->db->insert('tbl_jobcard_bom_other', $dataOther);
                }
            }

            
        
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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
            }
        }
        else{
            $data = array(
                'jobbomname'=> $bomtitle, 
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('idtbl_jobcard_bom', $recordID);
            $this->db->update('tbl_jobcard_bom', $data);

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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
            }
        }
    }
    public function CustomerJobBomstatus($x,$y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_jobcard_bom', $recordID);
            $this->db->update('tbl_jobcard_bom', $data);

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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);                      
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_jobcard_bom', $recordID);
            $this->db->update('tbl_jobcard_bom', $data);

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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);               
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('idtbl_jobcard_bom', $recordID);
            $this->db->update('tbl_jobcard_bom', $data);


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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);                     
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);         
            }
        }
    }
    public function Newcustomerjobbomedit(){
        $recordID=$this->input->post('recordID');

		$this->db->select('*');
		$this->db->from('tbl_jobcard_bom');
		$this->db->where('idtbl_jobcard_bom', $recordID);
		$this->db->where('status', 1);

		$respond=$this->db->get();

        $obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_jobcard_bom;
		$obj->jobbomname=$respond->row(0)->jobbomname;

		echo json_encode($obj);
    }
    public function viewBomInfo(){
        $recordID=$this->input->post('recordID');

		$this->db->select('tbl_jobcard_bom_material.cutsize, tbl_jobcard_bom_material.sheetqty, tbl_jobcard_bom_material.wastage, tbl_printing_format.format_name, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_bom_material');
        $this->db->join('tbl_printing_format', 'tbl_printing_format.idtbl_printing_format = tbl_jobcard_bom_material.tbl_printing_format_idtbl_printing_format', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_material.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_material.status', 1);

		$respondmaterial=$this->db->get();

        $this->db->select('tbl_jobcard_bom_varnish.varnishQty, tbl_varnish.varnish, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_bom_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_bom_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_varnish.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_varnish.status', 1);

		$respondvarnish=$this->db->get();

        $this->db->select([
            'TRIM(BOTH ", " FROM CONCAT(
                IF(tbl_jobcard_bom_color.cmyk = 1, "CMYK, ", ""),
                IF(tbl_jobcard_bom_color.metlic = 1, "Metlic Color, ", ""),
                IF(tbl_jobcard_bom_color.anyother = 1, "Any Other, ", "")
            )) AS color_types',
            'tbl_jobcard_bom_color.remark',
            'tbl_jobcard_bom_color.qty',
            'tbl_print_material_info.materialname'
        ]);
		$this->db->from('tbl_jobcard_bom_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_color.status', 1);

		$respondcolor=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_bom_lamination.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_bom_lamination.filmsize', 'tbl_jobcard_bom_lamination.micron', 'tbl_jobcard_bom_lamination.lamination_qty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_bom_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_bom_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_lamination.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_lamination.status', 1);

		$respondlamination=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_bom_rimming.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_bom_rimming.length', 'tbl_jobcard_bom_rimming.qty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_bom_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_bom_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_rimming.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_rimming.status', 1);

		$respondrimming=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_bom_diecutting.peraforation = 1, "Yes", "No") AS peraforation', 'IF(tbl_jobcard_bom_diecutting.halfCutting = 1, "Yes", "No") AS halfCutting', 'IF(tbl_jobcard_bom_diecutting.fullCutting = 1, "Yes", "No") AS fullCutting', 'tbl_jobcard_bom_diecutting.qty']);
		$this->db->from('tbl_jobcard_bom_diecutting');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('tbl_jobcard_bom_other.qty, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_bom_other');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_other.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_other.status', 1);

		$respondother=$this->db->get();

        $html='';

        $html.='
        <h6 class="small title-style"><span>Material Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Format</th>
                    <th>Material</th>
                    <th>Cut Size</th>
                    <th>Sheet Size</th>
                    <th>Wastage</th>
                </tr>
            </thead>';
            foreach($respondmaterial->result() as $rowmaterialdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowmaterialdata->format_name.'</td>
                    <td>'.$rowmaterialdata->materialname.'</td>
                    <td>'.$rowmaterialdata->cutsize.'</td>
                    <td>'.$rowmaterialdata->sheetqty.'</td>
                    <td>'.$rowmaterialdata->wastage.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Coating Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Varnish</th>
                    <th>Material</th>
                    <th>Sheets</th>
                </tr>
            </thead>';
            foreach($respondvarnish->result() as $rowvarnishdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowvarnishdata->varnish.'</td>
                    <td>'.$rowvarnishdata->materialname.'</td>
                    <td>'.$rowvarnishdata->varnishQty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Color Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Color Type</th>
                    <th>Material</th>
                    <th>Qty</th>
                    <th>Remark</th>
                </tr>
            </thead>';
            foreach($respondcolor->result() as $rowrespondcolordata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondcolordata->color_types.'</td>
                    <td>'.$rowrespondcolordata->materialname.'</td>
                    <td>'.$rowrespondcolordata->qty.'</td>
                    <td>'.$rowrespondcolordata->remark.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Lamination Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Lamination</th>
                    <th>Material</th>
                    <th>Film Size</th>
                    <th>Microne</th>
                    <th>Sides</th>
                    <th>Sheets</th>
                </tr>
            </thead>';
            foreach($respondlamination->result() as $rowrespondlaminationdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondlaminationdata->lamination.'</td>
                    <td>'.$rowrespondlaminationdata->materialname.'</td>
                    <td>'.$rowrespondlaminationdata->filmsize.'</td>
                    <td>'.$rowrespondlaminationdata->micron.'</td>
                    <td>'.$rowrespondlaminationdata->sides.'</td>
                    <td>'.$rowrespondlaminationdata->lamination_qty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Rimming Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Rimming Type</th>
                    <th>Material</th>
                    <th>Length</th>
                    <th>Sides</th>
                    <th>Sheets</th>
                </tr>
            </thead>';
            foreach($respondrimming->result() as $rowrespondrimmingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                    <td>'.$rowrespondrimmingdata->materialname.'</td>
                    <td>'.$rowrespondrimmingdata->length.'</td>
                    <td>'.$rowrespondrimmingdata->sides.'</td>
                    <td>'.$rowrespondrimmingdata->qty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Die Cutting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Perforaction</th>
                    <th>Half Cutting</th>
                    <th>Full Cutting</th>
                </tr>
            </thead>';
            foreach($responddiecut->result() as $rowresponddiecutdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowresponddiecutdata->qty.'</td>
                    <td>'.$rowresponddiecutdata->peraforation.'</td>
                    <td>'.$rowresponddiecutdata->halfCutting.'</td>
                    <td>'.$rowresponddiecutdata->fullCutting.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Other Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Qty</th>
                </tr>
            </thead>';
            foreach($respondother->result() as $rowotherdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowotherdata->materialname.'</td>
                    <td>'.$rowotherdata->qty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        ';

        echo $html;
    }
}
