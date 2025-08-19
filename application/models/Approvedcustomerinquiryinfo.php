<?php
class Approvedcustomerinquiryinfo extends CI_Model{

    public function Getcustomer(){
        $this->db->select('`idtbl_customer`, `customer`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialtype(){
        $this->db->select('`idtbl_material_type`, `paper`');
        $this->db->from('tbl_material_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getgaugetype(){
        $this->db->select('`idtbl_categorygauge`, `categorygauge_type`');
        $this->db->from('tbl_categorygauge');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Approvedcustomerinquirystatus($x, $y){
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

			$this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);

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
                redirect('Approvedcustomerinquiry');                
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
                redirect('Approvedcustomerinquiry');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);


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
                redirect('Approvedcustomerinquiry');                
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
                redirect('Approvedcustomerinquiry');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);


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
                redirect('Approvedcustomerinquiry');                
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
                redirect('Approvedcustomerinquiry');
            }
        }
    }
    public function Approvedcustomerinquiryedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry');
		$this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer', 'left');
        $this->db->where('idtbl_customerinquiry', $recordID);
        $this->db->where('tbl_customerinquiry.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customerinquiry;
        $obj->date=$respond->row(0)->date;
		$obj->po_number=$respond->row(0)->po_number;
		$obj->customer=$respond->row(0)->name;

        echo json_encode($obj);
    }

	public function Approvedcustomerinquiryjobeditview(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT * FROM `tbl_customerinquiry_detail` 
		LEFT JOIN `tbl_customerinquiry` ON `tbl_customerinquiry`.`idtbl_customerinquiry`=`tbl_customerinquiry_detail`.`tbl_customerinquiry_idtbl_customerinquiry`
		WHERE `tbl_customerinquiry_idtbl_customerinquiry`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
           
            $html.='
            <tr id ="'.$rowlist->idtbl_customerinquiry_detail.'">
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->uom.'</td>
                <td>'.$rowlist->unitprice.'</td>
                <td>'.$rowlist->job_no.'</td>
                <td>'.$rowlist->comments.'</td>
                <td><button class="btn btn-primary btn-sm btnAssignMaterials mr-1 text-right" id="' .$rowlist->idtbl_customerinquiry_detail. '"><i class="fa fa-wrench"></i></button></td>
             </tr>
            ';
        }
        echo ($html);
    }

    public function Approvedcustomerinquiryjoblistedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('idtbl_customerinquiry_detail', $recordID);
        $this->db->where('tbl_customerinquiry_detail.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customerinquiry_detail;
        $obj->job=$respond->row(0)->job;
        $obj->qty=$respond->row(0)->qty;
        $obj->comments=$respond->row(0)->comments;
        $obj->idtbl_customerinquiry=$respond->row(0)->tbl_customerinquiry_idtbl_customerinquiry;
        echo json_encode($obj);

    }

    public function Approvedcustomerinquiryjobedit(){
        $recordID=$this->input->post('recordID');

    $html='';

		$sql="SELECT * FROM `tbl_customerinquiry_detail` 
		LEFT JOIN `tbl_customerinquiry` ON `tbl_customerinquiry`.`idtbl_customerinquiry`=`tbl_customerinquiry_detail`.`tbl_customerinquiry_idtbl_customerinquiry`
		WHERE `tbl_customerinquiry_idtbl_customerinquiry`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
           
            $html.='
            <tr id ="'.$rowlist->idtbl_customerinquiry_detail.'">
               
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->comments.'</td>
                <td class="d-none"> '.$rowlist->tbl_customerinquiry_idtbl_customerinquiry.'</td>
                <td ><button type="button" id="'.$rowlist->idtbl_customerinquiry_detail.'" class="btnEditlist btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-pen"></i>
              </button>
              </td>
              <td class="d-none"><input type ="hidden" id ="hiddenid" name="hiddenid" value="'.$rowlist->idtbl_customerinquiry_detail.'"></td>
                
             </tr>
            
            ';
            
        }

        echo ($html);


    }

    public function Customerinquiryapproveedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry');
        $this->db->where('idtbl_customerinquiry', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customerinquiry;
        $obj->date=$respond->row(0)->date;
		$obj->po_number=$respond->row(0)->po_number;
		$obj->customer=$respond->row(0)->tbl_customer_idtbl_customer;

        echo json_encode($obj);
    }

    public function Approvedcustomerinquiryinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $date=$this->input->post('date');
		$ponumber=$this->input->post('ponumber');
		$customer=$this->input->post('customer');
		$tableData = $this->input->post('tableData');
		
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'date'=> $date, 
				'po_number'=> $ponumber, 
				'tbl_customer_idtbl_customer'=> $customer, 
                'status'=> '1', 
				'approvestatus'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_customerinquiry', $data);

			$insertId = $this->db->insert_id();

            foreach($tableData as $rowtabledata){
                $data = array(
                    'job'=> $rowtabledata['col_1'], 
                    'qty'=> $rowtabledata['col_2'],
                    'comments'=> $rowtabledata['col_3'], 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_customerinquiry_idtbl_customerinquiry'=> $insertId, 
                );
                $this->db->insert('tbl_customerinquiry_detail', $data);
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
				$actionObj->icon='fas fa-exclamation-triangle';
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
				'date'=> $date, 
				'po_number'=> $ponumber, 
				'tbl_customer_idtbl_customer'=> $customer, 
                'status'=> '1', 
				'approvestatus'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);

			foreach($tableData as $rowtabledata){


                if(isset($rowtabledata['col_5'])){

                    $joblistlID = $rowtabledata['col_5'];
                    $data = array(
						'job'=> $rowtabledata['col_1'], 
						'qty'=> $rowtabledata['col_2'],
						'comments'=> $rowtabledata['col_3'], 
                        'status'=> '1', 
                        'updatedatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_customerinquiry_idtbl_customerinquiry'=> $rowtabledata['col_4'],
                    );

                    $this->db->where('idtbl_customerinquiry_detail', $joblistlID);
                    $this->db->update('tbl_customerinquiry_detail', $data);
                }  else {
                    $data = array(
						'job'=> $rowtabledata['col_1'], 
						'qty'=> $rowtabledata['col_2'],
						'comments'=> $rowtabledata['col_3'],  
                        'status'=> '1', 
                        'insertdatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_customerinquiry_idtbl_customerinquiry'=> $recordID,
                    );
                    $this->db->insert('tbl_customerinquiry_detail', $data);
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
				$actionObj->icon='fas fa-exclamation-triangle';
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

    public function Getfilteredmaterials(){
        $gaugetype=$this->input->post('gaugetype');
        $materialtype=$this->input->post('materialtype');
      
        $this->db->select('`idtbl_print_material_info`, `materialname`');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        $this->db->where('tbl_material_type_idtbl_material_type', $materialtype);
        $this->db->where('tbl_categorygauge_idtbl_categorygauge', $gaugetype);
        $respond=$this->db->get();

        echo json_encode($respond->result());
    }
    
    public function Getmaterialunitprice(){
        $recordId=$this->input->post('recordId');

        $this->db->select('*');
        $this->db->from('tbl_print_material_info');
        $this->db->where('idtbl_print_material_info', $recordId);
        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->unitprice=$respond->row(0)->unitprice;

        echo json_encode($obj);
    }

    public function Insertupdateallocatedmaterials(){
        $this->db->trans_begin();
        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $detailsId=$this->input->post('detailsId');
      
        $materialrecordID=$this->input->post('materialrecordID');
        if(!empty($this->input->post('materialrecordOption'))){$materialrecordOption=$this->input->post('materialrecordOption');}

        $insertdatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowtabledata){
            $qty=$rowtabledata['col_2'];
            $materialId=$rowtabledata['col_5'];
            $materialtypeId=$rowtabledata['col_6'];
            $gaugetypeId=$rowtabledata['col_7'];
            $totalsum=$rowtabledata['col_8'];
            $unitprice=$rowtabledata['col_9'];

            $inserttype=$rowtabledata['col_10'];
            $allocatedmaterialId=$rowtabledata['col_11'];

            if($inserttype == 0){
                $data = array(
                    'qty'=> $qty, 
                    'unitprice'=> $unitprice, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialId, 
                    'tbl_categorygauge_idtbl_categorygauge'=> $gaugetypeId, 
                    'tbl_material_type_idtbl_material_type'=> $materialtypeId, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $detailsId,
                );
                $this->db->insert('tbl_inquiry_allocated_materials', $data);
            }else if($inserttype == 1){

                $data = array(
                    'qty'=> $qty, 
                    'unitprice'=> $unitprice, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialId, 
                    'tbl_categorygauge_idtbl_categorygauge'=> $gaugetypeId, 
                    'tbl_material_type_idtbl_material_type'=> $materialtypeId, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $detailsId,
                );

                $this->db->where('idtbl_inquiry_allocated_materials', $allocatedmaterialId);
                $this->db->update('tbl_inquiry_allocated_materials', $data);
            }
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Updated Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='primary';

            $actionJSON=json_encode($actionObj);
            echo $actionJSON;
            
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
            
            echo $actionJSON;
        }
       
    }

    public function Fetchinsertedmaterials(){
        $detailsId=$this->input->post('detailsId');
      
        $this->db->select('`tbl_inquiry_allocated_materials.idtbl_inquiry_allocated_materials`, `tbl_inquiry_allocated_materials.qty`, `tbl_inquiry_allocated_materials.unitprice`, `tbl_print_material_info.materialname`, `tbl_print_material_info.idtbl_print_material_info`, `tbl_inquiry_allocated_materials.tbl_material_type_idtbl_material_type`, `tbl_inquiry_allocated_materials.tbl_categorygauge_idtbl_categorygauge`');
        $this->db->from('tbl_inquiry_allocated_materials');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_inquiry_allocated_materials.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_inquiry_allocated_materials.status', 1);
        $this->db->where('tbl_inquiry_allocated_materials.tbl_customerinquiry_detail_idtbl_customerinquiry_detail', $detailsId);
        $respond=$this->db->get();

        echo json_encode($respond->result());
    }


    
}
