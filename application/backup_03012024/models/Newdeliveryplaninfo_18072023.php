<?php
class Newdeliveryplaninfo extends CI_Model{

	public function Getcustomer(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetAllProducts(){
        $this->db->select('`idtbl_material_info`, `materialname`');
        $this->db->from('tbl_material_info');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Deliveryplaninsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $customerinquiry=$this->input->post('customerinquiry');
		// $inquirydetailsid=$this->input->post('inquirydetailsid');
		// $selectjobid=$this->input->post('selectjobid');
		$hiddendeliveryplanid=$this->input->post('hiddendeliveryplanid');
		$tableData = $this->input->post('tableData');
		// echo $hiddendeliveryplanid;
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}


        $insertdatetime=date('Y-m-d H:i:s');
        $c = 0;
        $d = 0;
        if($recordOption==1){
            $query = $this->db->query("SELECT * FROM `tbl_delivery_plan` WHERE `idtbl_customerinquiry` = '$customerinquiry'");
            $cnumrows = $query->num_rows();
            $cnumrows = $cnumrows + 1;

            $specialdeliveryid = 'PO-'.$customerinquiry.'/'.$cnumrows;

            $data = array(
                'idtbl_customerinquiry'=> $customerinquiry, 
                'specialdeliveryid'=> $specialdeliveryid, 
				'idtbl_customerinquiry_detail'=> 0, 
				'tbl_cost_items_idtbl_cost_items'=> 0, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_delivery_plan', $data);

			$insertId = $this->db->insert_id();

            foreach($tableData as $rowtabledata){
                $c = $c+1;
                $specialId = 'PO-'.$customerinquiry.'/'.$cnumrows.'/D-'.$c;

                $data = array(
				    'special_id'=> $specialId, 
                    'deliveryDate'=> $rowtabledata['col_3'], 
                    'qty'=> $rowtabledata['col_4'],
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_delivery_plan_idtbl_delivery_plan'=> $insertId, 
                    'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $rowtabledata['col_1'], 
                );
                $this->db->insert('tbl_delivery_plan_details', $data);
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
                // 'idtbl_customerinquiry'=> $customerinquiry, 
				// 'idtbl_customerinquiry_detail'=> $inquirydetailsid, 
				// 'tbl_cost_items_idtbl_cost_items'=> 0, 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_delivery_plan', $recordID);
            $this->db->update('tbl_delivery_plan', $data);

			foreach($tableData as $rowtabledata){
                $d = $d+1;
                $specialId = 'PO:'.$customerinquiry.'/'.$d;

                if($rowtabledata['col_5'] == -99){

                    $joblistlID = $rowtabledata['col_6'];
                    // echo $joblistlID;

                    $data = array(
						'deliveryDate'=> $rowtabledata['col_3'], 
						'qty'=> $rowtabledata['col_4'],
                        'status'=> '1', 
                        'updatedatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_delivery_plan_idtbl_delivery_plan'=> $recordID,
                        'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $rowtabledata['col_1'], 
                    );

                    $this->db->where('idtbl_delivery_plan_details', $joblistlID);
                    $this->db->update('tbl_delivery_plan_details', $data);
                }  else {
                    $data = array(
                        'special_id'=> $specialId,
						'deliveryDate'=> $rowtabledata['col_3'], 
                        'qty'=> $rowtabledata['col_4'],
                        'status'=> '1', 
                        'insertdatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_delivery_plan_idtbl_delivery_plan'=> $recordID, 
                        'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $rowtabledata['col_1'], 
                    );
                    $this->db->insert('tbl_delivery_plan_details', $data);
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
    public function Deliveryplanstatus($x, $y){
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

			$this->db->where('idtbl_delivery_plan', $recordID);
            $this->db->update('tbl_delivery_plan', $data);

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
                redirect('NewDeliveryPlan');                
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
                redirect('NewDeliveryPlan');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_delivery_plan', $recordID);
            $this->db->update('tbl_delivery_plan', $data);


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
                redirect('NewDeliveryPlan');                
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
                redirect('NewDeliveryPlan');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_delivery_plan', $recordID);
            $this->db->update('tbl_delivery_plan', $data);


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
                redirect('NewDeliveryPlan');                
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
                redirect('NewDeliveryPlan');
            }
        }
    }
    public function Deliveryplanedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_delivery_plan');
        $this->db->where('idtbl_delivery_plan', $recordID);
        $this->db->where_in('status', array(1, 2)); 
        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_delivery_plan;
        $obj->inquiryid=$respond->row(0)->idtbl_customerinquiry;
		$obj->inquirydetailid=$respond->row(0)->idtbl_customerinquiry_detail;
		$obj->costitemid=$respond->row(0)->tbl_cost_items_idtbl_cost_items;

        echo json_encode($obj);
    }

    public function GetAllCustomerInquiries(){

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function Deliveryplanlistedit(){
        $recordID=$this->input->post('recordID');

        $html='';
        
        $this->db->select('`tbl_delivery_plan_details`.`idtbl_delivery_plan_details`, `tbl_delivery_plan_details`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail`, `tbl_customerinquiry_detail`.`job`, `tbl_delivery_plan_details`.`deliveryDate`, `tbl_delivery_plan_details`.`qty`');
        $this->db->from('tbl_delivery_plan_details');
        $this->db->join('tbl_delivery_plan', 'tbl_delivery_plan.idtbl_delivery_plan = tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->where('tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan', $recordID);
        $respond=$this->db->get();

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->idtbl_delivery_plan_details.'">
                <td class = "d-none">'.$rowlist->tbl_customerinquiry_detail_idtbl_customerinquiry_detail.'</td>
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->deliveryDate.'</td>
                <td>'.$rowlist->qty.'</td>
                <td class = "d-none">-99</td>
                <td ><button type="button" id="'.$rowlist->idtbl_delivery_plan_details.'" class="btnEditlist btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-pen"></i>
              </button>
              </td>
              <td class="d-none"><input type ="hidden" id ="hiddenid" name="hiddenid" value="'.$rowlist->idtbl_delivery_plan_details.'"></td>
             </tr>
            ';
        }

        echo ($html);
    }
    
	public function Deliveryplanlistitemsedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_delivery_plan_details');
        $this->db->join('tbl_delivery_plan', 'tbl_delivery_plan.idtbl_delivery_plan = tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan');
        $this->db->where('idtbl_delivery_plan_details', $recordID);
        $this->db->where('tbl_delivery_plan_details.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_delivery_plan_details;
        $obj->deliverydate=$respond->row(0)->deliveryDate;
        $obj->qty=$respond->row(0)->qty;
        $obj->idtbl_delivery_plan=$respond->row(0)->tbl_delivery_plan_idtbl_delivery_plan;
        $obj->inquirydetailsId=$respond->row(0)->tbl_customerinquiry_detail_idtbl_customerinquiry_detail;
        $obj->inquiryId=$respond->row(0)->idtbl_customerinquiry;
        echo json_encode($obj);

    }
    public function Deliveryplanviewjoblist(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT `tbl_delivery_plan_details`.`idtbl_delivery_plan_details`, `tbl_customerinquiry_detail`.`job`, `tbl_delivery_plan_details`.`special_id`, `tbl_delivery_plan_details`.`deliveryDate`, `tbl_delivery_plan_details`.`qty` FROM `tbl_delivery_plan_details` LEFT JOIN `tbl_delivery_plan` ON `tbl_delivery_plan`.`idtbl_delivery_plan`=`tbl_delivery_plan_details`.`tbl_delivery_plan_idtbl_delivery_plan` JOIN `tbl_customerinquiry_detail` ON (`tbl_customerinquiry_detail`.`idtbl_customerinquiry_detail` = `tbl_delivery_plan_details`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail`) WHERE `tbl_delivery_plan_idtbl_delivery_plan`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->idtbl_delivery_plan_details.'">
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->special_id.'</td>
                <td>'.$rowlist->deliveryDate.'</td>
                <td>'.$rowlist->qty.'</td>
             </tr>
            
            ';
        }

        echo ($html);


    }
    public function Deliveryplanviewmateriallist(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT `tbl_delivery_plan_material_allocation`.`idtbl_delivery_plan_material_allocation`, `tbl_delivery_plan_material_allocation`.`qty`, `tbl_delivery_plan_details`.`special_id`, `tbl_material_info`.`materialname`, `tbl_material_info`.`materialinfocode` FROM `tbl_delivery_plan_details` JOIN `tbl_delivery_plan` ON `tbl_delivery_plan`.`idtbl_delivery_plan`=`tbl_delivery_plan_details`.`tbl_delivery_plan_idtbl_delivery_plan` JOIN `tbl_delivery_plan_material_allocation` ON (`tbl_delivery_plan_material_allocation`.`tbl_delivery_plan_details_idtbl_delivery_plan_details` = `tbl_delivery_plan_details`.`idtbl_delivery_plan_details`) JOIN `tbl_material_info` ON (`tbl_material_info`.`idtbl_material_info` = `tbl_delivery_plan_material_allocation`.`tbl_material_info_idtbl_material_info`) WHERE `tbl_delivery_plan_idtbl_delivery_plan`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->idtbl_delivery_plan_material_allocation.'">
                <td>'.$rowlist->materialname. '/'. $rowlist->materialinfocode. '</td>
                <td>'.$rowlist->special_id.'</td>
                <td>'.$rowlist->qty.'</td>
             </tr>
            
            ';
        }

        echo ($html);


    }
    public function GetInquiryDetails(){
        $recordID=$this->input->post('recordId');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $respond=$this->db->get();
        return $respond->result_array();
    }

    public function GetPlanDetails(){
        $recordID=$this->input->post('recordId');

        $this->db->select('*');
        $this->db->from('tbl_delivery_plan_details');
        $this->db->where('tbl_delivery_plan_idtbl_delivery_plan', $recordID);
        $this->db->where('status', 1);
        $respond=$this->db->get();
        return $respond->result_array();
    }

    public function AllocationInsertUpdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $updatedatetime=date('Y-m-d H:i:s');
        $userID=$_SESSION['userid'];
 
        foreach($tableData as $rowtabledata){
            $materialname=$rowtabledata['col_1'];
            $planname=$rowtabledata['col_2'];
            $comment=$rowtabledata['col_3'];
            $materialID=$rowtabledata['col_4'];
            $planID=$rowtabledata['col_5'];
            $qty=$rowtabledata['col_6'];
            $reducedqty = $qty;

            $dataone = array(
                'qty'=> $qty, 
                'insertdatetime'=> $updatedatetime, 
                'insertuser'=> $userID, 
                'status'=> 1, 
                'tbl_delivery_plan_details_idtbl_delivery_plan_details'=> $planID, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );
            $this->db->insert('tbl_delivery_plan_material_allocation', $dataone);

            $this->db->select('*');
            $this->db->from('tbl_stock');
            $this->db->where('qty >', 0);
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->order_by('insertdatetime', 'desc');

            $respond=$this->db->get();

            $stockbatch = $respond->row(0)->batchno;
            $batchqty = $respond->row(0)->qty;

            while($batchqty < $reducedqty){
                $data = array(
                    'qty'=> 0, 
                    'updatedatetime' => $updatedatetime
                );
    
                $this->db->where('batchno', $stockbatch);
                $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                $this->db->update('tbl_stock', $data);

                $reducedqty = $reducedqty - $batchqty;

                $this->db->select('*');
                $this->db->from('tbl_stock');
                $this->db->where('qty >', 0);
                $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                $this->db->order_by('insertdatetime', 'desc');
                $respond=$this->db->get();

                $stockbatch = $respond->row(0)->batchno;
                $batchqty = $respond->row(0)->qty;

                if($batchqty > $reducedqty){
                    break;
                }

            }
            
            $data = array(
                'qty'=> $batchqty - $reducedqty, 
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('batchno', $stockbatch);
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->update('tbl_stock', $data);

            
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

    // public function GetJobList(){
    //     $recordID=$this->input->post('recordId');

    //     $this->db->select('*');
    //     $this->db->from('tbl_cost_items');
    //     $this->db->where('tbl_customerinquiry_detail_idtbl_customerinquiry_detail', $recordID);
    //     $this->db->where('status', 1);
    //     $respond=$this->db->get();
    //     return $respond->result_array();
    // }
    
}
