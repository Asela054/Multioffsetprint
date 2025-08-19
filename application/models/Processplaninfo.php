<?php
class Processplaninfo extends CI_Model{
    public function Getcustomer(){
        $this->db->select('`idtbl_customer`, `customer`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function ProcessPlaninsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $processplanname=$this->input->post('processplanname');
        $tableData = $this->input->post('tableData');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'name'=> $processplanname, 
				'status'=> 1, 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_process_plan', $data);
            $insertId = $this->db->insert_id();

            //Inserting machine allocation steps
            foreach($tableData as $rowtabledata){
                $dataMachineList = array(
                    'tbl_job_task_list_idtbl_job_task_list'=> $rowtabledata['col_1'], 
                    'sequence_no'=> $rowtabledata['col_2'],
                    'tbl_process_plan_idtbl_process_plan'=> $insertId, 
                    'no_of_days'=> $rowtabledata['col_5'], 
                    'qty'=> $rowtabledata['col_4'], 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_process_plan_details', $dataMachineList);
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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Processplan');                
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
                redirect('Processplan');                
            }
        }
        else{
            $data = array(
                'name'=> $processplanname, 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_process_plan', $recordID);
            $this->db->update('tbl_process_plan', $data);

            $this->db->trans_complete();


            $this->db->where('tbl_process_plan_idtbl_process_plan', $recordID);
            $this->db->delete('tbl_process_plan_details');

            //Inserting machine allocation steps
            foreach($tableData as $rowtabledata){
                $dataMachineList = array(
                    'tbl_job_task_list_idtbl_job_task_list'=> $rowtabledata['col_1'], 
                    'sequence_no'=> $rowtabledata['col_2'],
                    'tbl_process_plan_idtbl_process_plan'=> $recordID, 
                    'no_of_days'=> $rowtabledata['col_5'], 
                    'qty'=> $rowtabledata['col_4'], 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_process_plan_details', $dataMachineList);
            }

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
                redirect('Processplan');                               
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
                redirect('Processplan');                
            }
        }
    }

    public function Processplansstatus($x, $y){
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

            $this->db->where('idtbl_process_plan', $recordID);
            $this->db->update('tbl_process_plan', $data);

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
                redirect('Processplan');                 
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
                redirect('Processplan'); 
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_process_plan', $recordID);
            $this->db->update('tbl_process_plan', $data);

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
                redirect('Processplan');                 
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
                redirect('Processplan'); 
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_process_plan', $recordID);
            $this->db->update('tbl_process_plan', $data);

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
                redirect('Processplan');                 
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
                redirect('Processplan'); 
            }
        }
    }

    public function Processplanedit(){
        $recordID=$this->input->post('recordID');
        $arraylist=array();

        $this->db->select('*');
        $this->db->from('tbl_process_plan');
        $this->db->where('idtbl_process_plan', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $this->db->select('*');
        $this->db->from('tbl_process_plan_details');
        $this->db->join('tbl_job_task_list','tbl_job_task_list.idtbl_job_task_list = tbl_process_plan_details.tbl_job_task_list_idtbl_job_task_list');
        $this->db->where('tbl_process_plan_idtbl_process_plan', $recordID);
        $this->db->order_by('sequence_no');
        $respond2=$this->db->get();

        foreach($respond2->result() as $rowlist){
            $obj=new stdClass();
            $obj->taskId=$rowlist->tbl_job_task_list_idtbl_job_task_list;
            $obj->taskName=$rowlist->name;
            $obj->qty=$rowlist->qty;
            $obj->sequenceno=$rowlist->sequence_no;
            $obj->noofdays=$rowlist->no_of_days;
            array_push($arraylist, $obj);
        }
          
        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_process_plan;
        $obj->processplanname=$respond->row(0)->name;
		$obj->arrayList=$arraylist;

        echo json_encode($obj);
    }


}
