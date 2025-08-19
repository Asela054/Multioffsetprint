<?php
class Machineinfo extends CI_Model{

	public function GetMachinecategory(){
        $this->db->select('idtbl_machine_type, type');
        $this->db->from('tbl_machine_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
	public function Getfactory(){
        $this->db->select('idtbl_factory, factoryname');
        $this->db->from('tbl_factory');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


    public function Machineinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $machinecat_name=$this->input->post('machinecat_name');
		$categorytype=$this->input->post('categorytype');
		$perhourcost=$this->input->post('perhourcost');
		$hourmaxoutput=$this->input->post('hourmaxoutput');
		$setuptime=$this->input->post('setuptime');
		$boardsize=$this->input->post('boardsize');
		$factory=$this->input->post('factory');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'machine'=> $machinecat_name, 
				'perhour_cost'=> $perhourcost, 
				'perhour_maxoutput'=> $hourmaxoutput, 
				'setuptime'=> $setuptime, 
				'board_size'=> $boardsize, 
				'tbl_machine_type_idtbl_machine_type'=> $categorytype,
				'tbl_factory_idtbl_factory1'=> $factory,
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_machine', $data);

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
                redirect('Machine');                
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
                redirect('Machine');
            }
        }
        else{
            $data = array(
				'machine'=> $machinecat_name, 
				'perhour_cost'=> $perhourcost, 
				'perhour_maxoutput'=> $hourmaxoutput, 
				'setuptime'=> $setuptime, 
				'board_size'=> $boardsize, 
				'tbl_machine_type_idtbl_machine_type'=> $categorytype,
				'tbl_factory_idtbl_factory1'=> $factory, 
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_machine', $recordID);
            $this->db->update('tbl_machine', $data);

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
                redirect('Machine');                
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
                redirect('Machine');
            }
        }
    }
    public function Machinestatus($x, $y){
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

            $this->db->where('idtbl_machine', $recordID);
            $this->db->update('tbl_machine', $data);

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
                redirect('Machine');                
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
                redirect('Machine');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_machine', $recordID);
            $this->db->update('tbl_machine', $data);

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
                redirect('Machine');                
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
                redirect('Machine');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_machine', $recordID);
            $this->db->update('tbl_machine', $data);

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
                redirect('Machine');                
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
                redirect('Machine');
            }
        }
    }
    public function Machineedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_machine');
        $this->db->where('idtbl_machine', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_machine;
        $obj->machine=$respond->row(0)->machine;
		$obj->perhour_cost=$respond->row(0)->perhour_cost;
		$obj->perhour_maxoutput=$respond->row(0)->perhour_maxoutput;
		$obj->setuptime=$respond->row(0)->setuptime;
		$obj->board_size=$respond->row(0)->board_size;
		$obj->machine_type=$respond->row(0)->tbl_machine_type_idtbl_machine_type;
		$obj->factoryid=$respond->row(0)->tbl_factory_idtbl_factory1;
        echo json_encode($obj);
    }

    public function GetMachineList(){
        $this->db->select('idtbl_machine, machine');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
}
