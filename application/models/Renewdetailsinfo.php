<?php
class Renewdetailsinfo extends CI_Model{

	public function GetVehicleid($x){
          $vehicleid = $x;
		return $respond=$vehicleid;
	}

    public function Getrenewtype(){
        $this->db->select('idtbl_renew_type, renew_type');
        $this->db->from('tbl_renew_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getinsurance(){
        $this->db->select('idtbl_supplier, suppliername');
        $this->db->from('tbl_supplier');
        // $this->db->where('status', 1);
        $this->db->where('tbl_supplier_type_idtbl_supplier_type', 1);
        return $respond=$this->db->get();
    }



	public function Renewdetailsinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $renewtype=$this->input->post('renewtype');
		$insurance=$this->input->post('insurance');
        $amount=$this->input->post('amount');
        $renewdate=$this->input->post('renewdate');
        $nextrenewdate=$this->input->post('nextrenewdate');
        $comment=$this->input->post('comment');
        $vehicleid=$this->input->post('vehicleid');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'tbl_vehicle_idtbl_vehicle'=> $vehicleid, 
                'tbl_renew_type_idtbl_renew_type'=> $renewtype, 
                'tbl_supplier_idtbl_supplier'=> $insurance, 
                'amount'=> $amount, 
                'renew_date'=> $renewdate, 
                'next_renew_date'=> $nextrenewdate, 
                'comments'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_renew_details', $data);

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
                redirect('Renewdetails/index/'.$vehicleid);                
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
                redirect('Renewdetails/index/'.$vehicleid); 
            }
        }
        else{
            $data = array(
                'tbl_vehicle_idtbl_vehicle'=> $vehicleid, 
                'tbl_renew_type_idtbl_renew_type'=> $renewtype, 
                'tbl_supplier_idtbl_supplier'=> $insurance, 
                'amount'=> $amount,
                'renew_date'=> $renewdate, 
                'next_renew_date'=> $nextrenewdate, 
                'comments'=> $comment, 
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_renew_details', $recordID);
            $this->db->update('tbl_renew_details', $data);

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
                redirect('Renewdetails/index/'.$vehicleid);                 
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
                redirect('Renewdetails/index/'.$vehicleid); 
            }
        }
    }

	public function Renewdetailsstatus($x,$y,$z){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $vehicleid=$z;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_renew_details', $recordID);
            $this->db->update('tbl_renew_details', $data);

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
                redirect('Renewdetails/index/'.$vehicleid);            
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
                redirect('Renewdetails/index/'.$vehicleid); 
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_renew_details', $recordID);
            $this->db->update('tbl_renew_details', $data);


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
                redirect('Renewdetails/index/'.$vehicleid);           
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
                redirect('Renewdetails/index/'.$vehicleid); 
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_renew_details', $recordID);
            $this->db->update('tbl_renew_details', $data);


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
                redirect('Renewdetails/index/'.$vehicleid);          
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
                redirect('Renewdetails/index/'.$vehicleid); 
            }
        }
    }
	public function Renewdetailsedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_renew_details');
        $this->db->where('idtbl_renew_details', $recordID);
        $this->db->where('status',1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_renew_details;
        $obj->renewtype=$respond->row(0)->tbl_renew_type_idtbl_renew_type;
        $obj->insurance=$respond->row(0)->tbl_supplier_idtbl_supplier ;
        $obj->amount=$respond->row(0)->amount;
        $obj->renewdate=$respond->row(0)->renew_date;
        $obj->nextrenewdate=$respond->row(0)->next_renew_date;
        $obj->comment=$respond->row(0)->comments;
		
        echo json_encode($obj);
    }
}
