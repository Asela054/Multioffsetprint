<?php
class Approvedcustomerinquiryinfo extends CI_Model{

    public function Getcustomer(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
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
}
