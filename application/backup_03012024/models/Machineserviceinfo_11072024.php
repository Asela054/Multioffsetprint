<?php

class Machineserviceinfo extends CI_Model {
	
	public function Getmachinename(){
        $this->db->select('`idtbl_machine`, `machine`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Machineserviceinsertupdate() {
        
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$datetime=date('Y-m-d H:i:s');

		$recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

				$idtbl_machine_service = $this->input->post('idtbl_machine_service');
				$job_type = $this->input->post('job_type');
				$machine = $this->input->post('machine');
				$factory_code = $this->input->post('factory_code');
				$service_date_from = $this->input->post('service_date_from');
				$sevice_date_to = $this->input->post('sevice_date_to');
				$estimated_sevice_hours = $this->input->post('estimated_sevice_hours');
				$estimated_sevice_items = $this->input->post('estimated_sevice_items');

		if($recordOption==1) {

			$data = array(
                'idtbl_machine_service'=> $idtbl_machine_service,  
                'job_type'=> $job_type,  
                'machine'=> $machine,  
                'factory_code'=> $factory_code,  
                'machine_serial_no'=> '0',  
                'service_date_from'=> $service_date_from,  
                'sevice_date_to'=> $sevice_date_to,  
                'estimated_sevice_hours'=> $estimated_sevice_hours,  
                'estimated_sevice_items'=> $estimated_sevice_items,  
                'status'=> '1', 
                'insertdatetime'=> $datetime, 
                'tbl_user_idtbl_user'=> $userID,
            );
			$this->db->insert('tbl_machine_service', $data);

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

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;


			} else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

            }
		} 
		else{
            $data = array(
                'idtbl_machine_service'=> $idtbl_machine_service,  
                'job_type'=> $job_type,  
                'machine'=> $machine,  
                'factory_code'=> $factory_code,  
                'machine_serial_no'=> '0',  
                'service_date_from'=> $service_date_from,  
                'sevice_date_to'=> $sevice_date_to,  
                'estimated_sevice_hours'=> $estimated_sevice_hours,  
                'estimated_sevice_items'=> $estimated_sevice_items,    
                'status'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime' => $datetime,
            );
			$this->db->where('idtbl_machine_service', $recordID);
			$this->db->update('tbl_machine_service', $data);

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

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;


            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

            }
		}
	}

    public function Machineserviceedit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
        $this->db->from('tbl_machine_service');
        $this->db->where('idtbl_machine_service', $recordID);
        $this->db->where('status', 1);

		$respond=$this->db->get();

        $obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_machine_service;
        $obj->idtbl_machine_service=$respond->row(0)->idtbl_machine_service;
        $obj->job_type=$respond->row(0)->job_type;
        $obj->machine=$respond->row(0)->machine;
        $obj->factory_code=$respond->row(0)->factory_code;
        $obj->machine_serial_no=$respond->row(0)->machine_serial_no;
        $obj->service_date_from=$respond->row(0)->service_date_from;
        $obj->sevice_date_to=$respond->row(0)->sevice_date_to;
        $obj->estimated_sevice_hours=$respond->row(0)->estimated_sevice_hours;
        $obj->estimated_sevice_items=$respond->row(0)->estimated_sevice_items;

		echo json_encode($obj);
	}

    public function Machineservicestatus($x, $y) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

		if ($type==1) {
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
			$this->db->where('idtbl_machine_service', $recordID);
            $this->db->update('tbl_machine_service', $data);

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
                redirect('MachineService');

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
                redirect('MachineService');
            }
		}
		else if ($type==2) {
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_machine_service', $recordID);
            $this->db->update('tbl_machine_service', $data);

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
                redirect('MachineService'); 

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
                redirect('MachineService');
            }
		}
		else if ($type==3) {
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_machine_service', $recordID);
            $this->db->update('tbl_machine_service', $data);

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
                redirect('MachineService');      
                       
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
                redirect('MachineService');
            }
        }
	}

}
