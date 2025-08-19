<?php
class Vehiclerenewforapproveinfo extends CI_Model{
    public function Getvehicleregno(){
        $this->db->select('idtbl_vehicle, vehicle_reg_no');
        $this->db->from('tbl_vehicle');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getsupplier(){
        $this->db->select('idtbl_supplier, suppliername');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Vehiclerenewforapproveinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        //$date=$this->input->post('date');
		$vehicleregno=$this->input->post('vehicleregno');
		$supplier=$this->input->post('supplier');
		$comment = $this->input->post('comment');
		
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'comment'=> $comment, 
				'tbl_vehicle_idtbl_vehicle'=> $vehicleregno, 
				'tbl_supplier_idtbl_supplier'=> $supplier, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_vehiclerenew_inquiry', $data);

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
                redirect('Vehiclerenewforapprove');                
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
	
				$this->session->set_flashdata('msg', $actionJSON);
                redirect('Vehiclerenewforapprove');
			}

        }
        else{
            $data = array(
                'comment'=> $comment, 
				'tbl_vehicle_idtbl_vehicle'=> $vehicleregno, 
				'tbl_supplier_idtbl_supplier'=> $supplier,
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_vehiclerenew_inquiry', $recordID);
            $this->db->update('tbl_vehiclerenew_inquiry', $data);

            $this->db->trans_complete();

			if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				
				$actionObj=new stdClass();
				$actionObj->icon='fas fa-save';
				$actionObj->title='';
				$actionObj->message='Record Update Successfully';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='success';
	
                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Vehiclerenewforapprove');               
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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Vehiclerenewforapprove');
			}
        }
    }
    public function Vehiclerenewforapprovestatus($x, $y){
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

			$this->db->where('idtbl_vehiclerenew_inquiry', $recordID);
            $this->db->update('tbl_vehiclerenew_inquiry', $data);

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
                redirect('Vehiclerenewforapprove');                
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
                redirect('Vehiclerenewforapprove');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_vehiclerenew_inquiry', $recordID);
            $this->db->update('tbl_vehiclerenew_inquiry', $data);


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
                redirect('Vehiclerenewforapprove');                
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
                redirect('Vehiclerenewforapprove');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_vehiclerenew_inquiry', $recordID);
            $this->db->update('tbl_vehiclerenew_inquiry', $data);


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
                redirect('Vehiclerenewforapprove');                
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
                redirect('Vehiclerenewforapprove');
            }
        }
    }
    public function Vehiclerenewforapproveedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_vehiclerenew_inquiry');
        $this->db->where('idtbl_vehiclerenew_inquiry', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_vehiclerenew_inquiry;
        $obj->comment=$respond->row(0)->comment;
		$obj->vehicleregno=$respond->row(0)->tbl_vehicle_idtbl_vehicle;
		$obj->supplier=$respond->row(0)->tbl_supplier_idtbl_supplier;

        echo json_encode($obj);
    }


    public function Vehiclerenewforapprovestatusapprove($x) {

		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$recordID=$x;
		$updatedatetime=date('Y-m-d H:i:s');
		$data=array('approvestatus'=> '1',
			'tbl_user_idtbl_user'=> $userID,
			'updatedatetime'=> $updatedatetime);

		$this->db->where('idtbl_vehiclerenew_inquiry', $recordID);
		$this->db->update('tbl_vehiclerenew_inquiry', $data);


		$this->db->trans_complete();

		if ($this->db->trans_status()===TRUE) {
			$this->db->trans_commit();

			$actionObj=new stdClass();
			$actionObj->icon='fas fa-times';
			$actionObj->title='';
			$actionObj->message='Record Approved Successfully';
			$actionObj->url='';
			$actionObj->target='_blank';
			$actionObj->type='info';

			$actionJSON=json_encode($actionObj);

			$this->session->set_flashdata('msg', $actionJSON);
			redirect('Vehiclerenewforapprove');
		}

		else {
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
			redirect('Vehiclerenewforapprove');
		}
	}
	
}
