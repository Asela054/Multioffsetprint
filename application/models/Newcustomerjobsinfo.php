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

		$prepressArtworkby=$this->input->post('prepressArtworkby');
		$prepressFormat=$this->input->post('prepressFormat');
		$prepressPlateby=$this->input->post('prepressPlateby');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}
        
        $materialTable = $this->input->post('materialTable');
        $colorTable = $this->input->post('colorTable');
        $varnishTable = $this->input->post('varnishTable');
        $foilTable = $this->input->post('foilTable');
        $laminationTable = $this->input->post('laminationTable');
        $pastingTable = $this->input->post('pastingTable');
        $rimmingTable = $this->input->post('rimmingTable');

        if(!empty($this->input->post('diecutby'))){$diecutby=$this->input->post('diecutby');}else{$diecutby='0';}
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

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'jobbomname'=> $bomtitle, 
                'artworkby'=> $prepressArtworkby, 
                'format'=> $prepressFormat, 
                'plateby'=> $prepressPlateby, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customer_job_details_idtbl_customer_job_details'=> $jobid
            );
            $this->db->insert('tbl_jobcard_bom', $data);
            $jobbomID = $this->db->insert_id(); // Get the inserted ID

            // Material Section
            if(!empty($materialTable)){
                foreach($materialTable as $materialData){
                    $materialby=$materialData['col_1'];
                    $materialID=$materialData['col_2'];
                    $cutSize=$materialData['col_5'];
                    $cutups=$materialData['col_6'];
                    $upspersheet=$materialData['col_7'];
                    $wastage=$materialData['col_8'];

                    $materialListData = array(
                        'materialby'=> $materialby, 
                        'cutsize'=> $cutSize, 
                        'cutups'=> $cutups, 
                        'upspersheet'=> $upspersheet, 
                        'wastage'=> $wastage, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID,
                    );
                    $this->db->insert('tbl_jobcard_bom_material', $materialListData);
                }
            }
            // Printing Section
            if(!empty($colorTable)){
                foreach($colorTable as $colorData){
                    $printmaterialby=$colorData['col_1'];
                    $printmaterialID=$colorData['col_2'];
                    $colortype=$colorData['col_5'];
                    $colorqty=$colorData['col_6'];
                    $remark=$colorData['col_7'];

                    $datacolor = array(
                        'colormaterialby'=> $printmaterialby, 
                        'colortype'=> $colortype, 
                        'remark'=> $remark, 
                        'qty'=> $colorqty, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $printmaterialID
                    );
                    $this->db->insert('tbl_jobcard_bom_color', $datacolor);
                }
            }
            // Varnish Section
            if(!empty($varnishTable)){
                foreach($varnishTable as $varnishData){
                    $varnishMaterialId=$varnishData['col_1'];
                    $varnishId=$varnishData['col_4'];
                    $glossmatt=$varnishData['col_6'];
                    $fullspot=$varnishData['col_7'];
                    $varnishSheetQty=$varnishData['col_8'];
                    $remark=$varnishData['col_9'];

                    $varnishListData = array(
                        'glossmatt'=> $glossmatt, 
                        'fullspot'=> $fullspot, 
                        'varnishQty'=> $varnishSheetQty, 
                        'remark'=> $remark, 
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
            // Foiling Section
            if(!empty($foilTable)){
                foreach($foilTable as $foilData){
                    $foilingby=$foilData['col_1'];
                    $foimaterialID=$foilData['col_2'];
                    $foiltype=$foilData['col_5'];
                    $foilqty=$foilData['col_7'];
                    $remark=$foilData['col_8'];

                    $foilListData = array(
                        'foilmaterialby'=> $foilingby, 
                        'qty'=> $foilqty, 
                        'remark'=> $remark, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_foiling_idtbl_foiling'=> $foiltype,
                        'tbl_print_material_info_idtbl_print_material_info'=> $foimaterialID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
                    );
                    $this->db->insert('tbl_jobcard_bom_foil', $foilListData);
                }
            }
            // Lamination Section
            if(!empty($laminationTable)){
                foreach($laminationTable as $laminationData){
                    $laminationMaterialId=$laminationData['col_1'];
                    $laminationId=$laminationData['col_4'];
                    $filmSize=$laminationData['col_6'];
                    $laminationPrintSides=$laminationData['col_7'];
                    $laminationqty=$laminationData['col_8'];
                    $laminationwastage=$laminationData['col_9'];

                    $laminationListData = array(
                        'sides'=> $laminationPrintSides, 
                        'filmsize'=> $filmSize, 
                        'lamination_qty'=> $laminationqty, 
                        'wastage'=> $laminationwastage, 
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
            // Pasting Section
            if(!empty($pastingTable)){
                foreach($pastingTable as $pastingData){
                    $pastematerialID=$pastingData['col_1'];
                    $machineID=$pastingData['col_4'];
                    $pastetype=$pastingData['col_6'];
                    $pasteqty=$pastingData['col_7'];
                    $pasteremark=$pastingData['col_8'];

                    $pastingListData = array(
                        'pastetype'=> $pastetype, 
                        'pasteqty'=> $pasteqty, 
                        'remark'=> $pasteremark, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_machine_idtbl_machine'=> $machineID,
                        'tbl_print_material_info_idtbl_print_material_info'=> $pastematerialID,
                        'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
                    );
                    $this->db->insert('tbl_jobcard_bom_pasting', $pastingListData);
                }
            }
            // Die Cutting Section
            $dieCuttingListData = array(
                'channel'=> $diechannel, 
                'board'=> $dieboard, 
                'size'=> $diesize, 
                'qty'=> $dieqty, 
                'diecutby'=> $diecutby, 
                'embossby'=> $diecutembrossby, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
            );
            $this->db->insert('tbl_jobcard_bom_diecutting', $dieCuttingListData);
            // Rimming Section
            if(!empty($rimmingTable)){
                foreach($rimmingTable as $rimmingData){
                    $rimmingby=$rimmingData['col_1'];
                    $rimmingMaterialId=$rimmingData['col_2'];
                    $rimmingId=$rimmingData['col_5'];
                    $printedSides=$rimmingData['col_7'];
                    $rimmingQty=$rimmingData['col_8'];
                    $rimmingremark=$rimmingData['col_9'];

                    $rimmingListData = array(
                        'rimmingby'=> $rimmingby, 
                        'sides'=> $printedSides, 
                        'qty'=> $rimmingQty, 
                        'remark'=> $rimmingremark, 
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
            // Other Section
            $dataOther = array(
                'perfoating'=> $otherPerforating, 
                'gattering'=> $otherGattering, 
                'rimming'=> $otherRimming, 
                'binding'=> $otherBinding, 
                'stapling'=> $otherStapling, 
                'padding'=> $otherPadding, 
                'creasing'=> $otherCreasing, 
                'threading'=> $otherThreading, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbomID
            );
            $this->db->insert('tbl_jobcard_bom_other', $dataOther);
        
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

        $this->db->select('`jobbomname`, `artworkby`, `format`, `plateby`');
        $this->db->from('tbl_jobcard_bom');
        $this->db->where('idtbl_jobcard_bom', $recordID);
        $this->db->where('status', 1);
        $respond=$this->db->get();

		$this->db->select('tbl_jobcard_bom_material.materialby, tbl_jobcard_bom_material.cutsize, tbl_jobcard_bom_material.cutups, tbl_jobcard_bom_material.upspersheet, tbl_jobcard_bom_material.wastage, tbl_print_material_info.materialname, tbl_print_material_info.materialinfocode');
		$this->db->from('tbl_jobcard_bom_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_material.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_material.status', 1);

		$respondmaterial=$this->db->get();

        $this->db->select([
            'tbl_jobcard_bom_color.colormaterialby',
            'tbl_jobcard_bom_color.colortype',
            'tbl_jobcard_bom_color.remark',
            'tbl_jobcard_bom_color.qty',
            'tbl_print_material_info.materialname',
            'tbl_print_material_info.materialinfocode'
        ]);
		$this->db->from('tbl_jobcard_bom_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_color.status', 1);

		$respondcolor=$this->db->get();

        $this->db->select('tbl_jobcard_bom_varnish.glossmatt, tbl_jobcard_bom_varnish.fullspot, tbl_jobcard_bom_varnish.varnishQty, tbl_jobcard_bom_varnish.remark, tbl_varnish.varnish, tbl_print_material_info.materialname, tbl_print_material_info.materialinfocode');
		$this->db->from('tbl_jobcard_bom_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_bom_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_varnish.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_varnish.status', 1);

		$respondvarnish=$this->db->get();

        $this->db->select('tbl_jobcard_bom_foil.foilmaterialby, tbl_jobcard_bom_foil.qty, tbl_jobcard_bom_foil.remark, tbl_foiling.foiling, tbl_print_material_info.materialname, tbl_print_material_info.materialinfocode');
		$this->db->from('tbl_jobcard_bom_foil');
        $this->db->join('tbl_foiling', 'tbl_foiling.idtbl_foiling = tbl_jobcard_bom_foil.tbl_foiling_idtbl_foiling', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_foil.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_foil.status', 1);

		$respondfoil=$this->db->get();

        $this->db->select(['tbl_jobcard_bom_lamination.sides', 'tbl_jobcard_bom_lamination.filmsize', 'tbl_jobcard_bom_lamination.lamination_qty', 'tbl_jobcard_bom_lamination.wastage', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname', 'tbl_print_material_info.materialinfocode']);
		$this->db->from('tbl_jobcard_bom_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_bom_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_lamination.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_lamination.status', 1);

		$respondlamination=$this->db->get();

        $this->db->select('tbl_jobcard_bom_pasting.pastetype, tbl_jobcard_bom_pasting.pasteqty, tbl_jobcard_bom_pasting.remark, tbl_machine.machine, tbl_print_material_info.materialname, tbl_print_material_info.materialinfocode');
		$this->db->from('tbl_jobcard_bom_pasting');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_jobcard_bom_pasting.tbl_machine_idtbl_machine', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_pasting.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_pasting.status', 1);

		$respondpasting=$this->db->get();

        $this->db->select(['tbl_jobcard_bom_rimming.rimmingby', 'tbl_jobcard_bom_rimming.sides', 'tbl_jobcard_bom_rimming.qty', 'tbl_jobcard_bom_rimming.remark', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname', 'tbl_print_material_info.materialinfocode']);
		$this->db->from('tbl_jobcard_bom_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_bom_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_bom_rimming.tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('tbl_jobcard_bom_rimming.status', 1);

		$respondrimming=$this->db->get();

        $this->db->select('`channel`, `board`, `size`, `qty`, `diecutby`, `embossby`');
		$this->db->from('tbl_jobcard_bom_diecutting');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`');
		$this->db->from('tbl_jobcard_bom_other');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $recordID);
		$this->db->where('status', 1);

		$respondother=$this->db->get();

        $html='';

        $html.='
        <h6 class="small title-style"><span>Other Section</span></h6>
        <div class="card shadow-none border">
            <div class="card-body p-2 small">
                <div class="row">
                    <div class="col-md-6 mb-1"><strong>BOM Name :</strong> '.$respond->row(0)->jobbomname.'</div>
                    <div class="col-md-6 mb-1"><strong>Artwork By :</strong> '.$respond->row(0)->artworkby.'</div>
                    <div class="col-md-6 mb-1"><strong>Format :</strong> '.$respond->row(0)->format.'</div>
                    <div class="col-md-6 mb-1"><strong>Plate By :</strong> '.$respond->row(0)->plateby.'</div>
                </div>
            </div>
        </div>
        <h6 class="small title-style"><span>Material Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Code</th>
                    <th>Material</th>
                    <th>Cut Size (Inch)</th>
                    <th class="text-center">Material Cut UPs</th>
                    <th class="text-center">UPs per Sheet</th>
                    <th class="text-center">Wastage</th>
                </tr>
            </thead>';
            foreach($respondmaterial->result() as $rowmaterialdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowmaterialdata->materialby.'</td>
                    <td>'.$rowmaterialdata->materialinfocode.'</td>
                    <td>'.$rowmaterialdata->materialname.'</td>
                    <td>'.$rowmaterialdata->cutsize.'</td>
                    <td class="text-center">'.$rowmaterialdata->cutups.'</td>
                    <td class="text-center">'.$rowmaterialdata->upspersheet.'</td>
                    <td class="text-center">'.$rowmaterialdata->wastage.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Printing Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th>Color Type</th>
                    <th class="text-center">Qty</th>
                    <th>Remark</th>
                </tr>
            </thead>';
            foreach($respondcolor->result() as $rowrespondcolordata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondcolordata->colormaterialby.'</td>
                    <td>'.$rowrespondcolordata->materialinfocode.'</td>
                    <td>'.$rowrespondcolordata->materialname.'</td>
                    <td>'.$rowrespondcolordata->colortype.'</td>
                    <td class="text-center">'.$rowrespondcolordata->qty.'</td>
                    <td>'.$rowrespondcolordata->remark.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Coating Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th>Varnish Type</th>
                    <th class="text-center">Qty</th>
                    <th>Remark</th>
                </tr>
            </thead>';
            foreach($respondvarnish->result() as $rowvarnishdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowvarnishdata->materialinfocode.'</td>
                    <td>'.$rowvarnishdata->materialname.'</td>
                    <td>'.$rowvarnishdata->varnish.' - '.$rowvarnishdata->glossmatt.' - '.$rowvarnishdata->fullspot.'</td>
                    <td class="text-center">'.$rowvarnishdata->varnishQty.'</td>
                    <td>'.$rowvarnishdata->remark.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Foiling Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th>Foil Type</th>
                    <th class="text-center">Qty(Inch)</th>
                    <th>Remark</th>
                </tr>
            </thead>';
            foreach($respondfoil->result() as $rowfoildata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowfoildata->foilmaterialby.'</td>
                    <td>'.$rowfoildata->materialinfocode.'</td>
                    <td>'.$rowfoildata->materialname.'</td>
                    <td>'.$rowfoildata->foiling.'</td>
                    <td class="text-center">'.$rowfoildata->qty.'</td>
                    <td>'.$rowfoildata->remark.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Lamination Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th>Lamination</th>
                    <th>Film Size</th>
                    <th>Sides</th>
                    <th class="text-center">Qty(KG)</th>
                    <th class="text-center">Wastage(%)</th>
                </tr>
            </thead>';
            foreach($respondlamination->result() as $rowrespondlaminationdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondlaminationdata->materialinfocode.'</td>
                    <td>'.$rowrespondlaminationdata->materialname.'</td>
                    <td>'.$rowrespondlaminationdata->lamination.'</td>
                    <td>'.$rowrespondlaminationdata->filmsize.'</td>
                    <td>'.$rowrespondlaminationdata->sides.'</td>
                    <td class="text-center">'.$rowrespondlaminationdata->lamination_qty.'</td>
                    <td class="text-center">'.$rowrespondlaminationdata->wastage.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Pasting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th>Machine</th>
                    <th>Paste Type</th>
                    <th class="text-center">Qty(KG)</th>
                    <th>Remark</th>
                </tr>
            </thead>';
            foreach($respondpasting->result() as $rowpastingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowpastingdata->materialinfocode.'</td>
                    <td>'.$rowpastingdata->materialname.'</td>
                    <td>'.$rowpastingdata->machine.'</td>
                    <td>'.$rowpastingdata->pastetype.'</td>
                    <td class="text-center">'.$rowpastingdata->pasteqty.'</td>
                    <td>'.$rowpastingdata->remark.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Die Cutting Section</span></h6>
        <div class="card shadow-none border">
            <div class="card-body p-2 small">
                <div class="row">
                    <div class="col-6"><strong>Channel :</strong> '.$responddiecut->row(0)->channel.'</div>
                    <div class="col-6"><strong>Board :</strong> '.$responddiecut->row(0)->board.'</div>
                    <div class="col-6"><strong>Size :</strong> '.$responddiecut->row(0)->size.'</div>
                    <div class="col-6"><strong>Qty :</strong> '.$responddiecut->row(0)->qty.'</div>
                    <div class="col-6"><strong>Die Cut By :</strong> '.$responddiecut->row(0)->diecutby.'</div>
                    <div class="col-6"><strong>Emboss By :</strong> '.$responddiecut->row(0)->embossby.'</div>
                </div>
            </div>
        </div>
        <h6 class="small title-style"><span>Rimming Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th>Rimming Type</th>
                    <th>Sides</th>
                    <th class="text-center">Qty</th>
                    <th>Remark</th>
                </tr>
            </thead>';
            foreach($respondrimming->result() as $rowrespondrimmingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondrimmingdata->rimmingby.'</td>
                    <td>'.$rowrespondrimmingdata->materialinfocode.'</td>
                    <td>'.$rowrespondrimmingdata->materialname.'</td>
                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                    <td>'.$rowrespondrimmingdata->sides.'</td>
                    <td class="text-center">'.$rowrespondrimmingdata->qty.'</td>
                    <td>'.$rowrespondrimmingdata->remark.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Other Section</span></h6>
        <div class="card shadow-none border">
            <div class="card-body p-2 small">
                <div class="row">
                    <div class="col-6"><strong>Perfoating :</strong> '.$respondother->row(0)->perfoating.'</div>
                    <div class="col-6"><strong>Gattering :</strong> '.$respondother->row(0)->gattering.'</div>
                    <div class="col-6"><strong>Rimming :</strong> '.$respondother->row(0)->rimming.'</div>
                    <div class="col-6"><strong>Binding :</strong> '.$respondother->row(0)->binding.'</div>
                    <div class="col-6"><strong>Stapling :</strong> '.$respondother->row(0)->stapling.'</div>
                    <div class="col-6"><strong>Padding :</strong> '.$respondother->row(0)->padding.'</div>
                    <div class="col-6"><strong>Creasing :</strong> '.$respondother->row(0)->creasing.'</div>
                    <div class="col-6"><strong>Threading :</strong> '.$respondother->row(0)->threading.'</div>
                </div>
            </div>
        </div>
        ';

        echo $html;
    }
}
