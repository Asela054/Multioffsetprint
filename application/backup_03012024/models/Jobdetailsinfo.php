<?php
class Jobdetailsinfo extends CI_Model{

	public function Getcustomer(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetPrimaryJob($recordId){
        $this->db->select('`idtbl_customerinquiry_detail`, `job`');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('status', 1);
        $this->db->where('idtbl_customerinquiry_detail', $recordId);

        $respond=$this->db->get()->result();
        return json_encode($respond);
    }

    public function Jobdetailsinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $costitemname=$this->input->post('costitemname');
		$qty=$this->input->post('qty');
		$comment=$this->input->post('comment');
		$inquirerydetailsId=$this->input->post('inquirerydetailsId');
        $tableData = $this->input->post('tableData');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'costitemname'=> $costitemname, 
				'qty'=> $qty, 
				'comment'=> $comment, 
				'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $inquirerydetailsId,
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_cost_items', $data);
            $insertId = $this->db->insert_id();

            $c = 0;
            //Inserting machine allocation steps
            foreach($tableData as $rowtabledata){
                $c = $c + 1;
                $dataMachineList = array(
                    'tbl_machine_idtbl_machine'=> $rowtabledata['col_1'], 
                    'step'=> $c,
                    'tbl_cost_items_idtbl_cost_items'=> $insertId, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_cost_item_steps', $dataMachineList);
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
                redirect('Jobdetails/FetchPassedValue/'.$inquirerydetailsId.'');                
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
                redirect('Jobdetails/FetchPassedValue/'.$inquirerydetailsId.'');                
            }
        }
        else{
            $data = array(
				'costitemname'=> $costitemname, 
				'qty'=> $qty, 
				'comment'=> $comment, 
				'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $inquirerydetailsId,
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_cost_items', $recordID);
            $this->db->update('tbl_cost_items', $data);

            $this->db->trans_complete();


            $this->db->where('tbl_cost_items_idtbl_cost_items', $recordID);
            $this->db->delete('tbl_cost_item_steps');

            $c = 0;
            //Inserting machine allocation steps
            foreach($tableData as $rowtabledata){
                $c = $c + 1;
                $dataMachineList = array(
                    'tbl_machine_idtbl_machine'=> $rowtabledata['col_1'], 
                    'step'=> $c,
                    'tbl_cost_items_idtbl_cost_items'=> $recordID, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_cost_item_steps', $dataMachineList);
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
                redirect('Jobdetails/FetchPassedValue/'.$inquirerydetailsId.'');                               
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
                redirect('Jobdetails/FetchPassedValue/'.$inquirerydetailsId.'');                
            }
        }
    }

    public function Jobdetailsstatus($x, $y, $z){
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

            $this->db->where('idtbl_cost_items', $recordID);
            $this->db->update('tbl_cost_items', $data);

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
                redirect('Jobdetails//'.$z.'');                 
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
                redirect('Jobdetails/FetchPassedValue/'.$z.''); 
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_cost_items', $recordID);
            $this->db->update('tbl_cost_items', $data);

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
                redirect('Jobdetails/FetchPassedValue/'.$z.'');                 
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
                redirect('Jobdetails/FetchPassedValue/'.$z.''); 
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_cost_items', $recordID);
            $this->db->update('tbl_cost_items', $data);

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
                redirect('Jobdetails/FetchPassedValue/'.$z.'');                 
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
                redirect('Jobdetails/FetchPassedValue/'.$z.''); 
            }
        }
    }

    public function Jobdetailsedit(){
        $recordID=$this->input->post('recordID');
        $arraylist=array();

        $this->db->select('*');
        $this->db->from('tbl_cost_items');
        $this->db->where('idtbl_cost_items', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $this->db->select('*');
        $this->db->from('tbl_cost_item_steps');
        $this->db->join('tbl_machine','tbl_machine.idtbl_machine = tbl_cost_item_steps.tbl_machine_idtbl_machine');
        $this->db->where('tbl_cost_items_idtbl_cost_items', $recordID);
        $respond2=$this->db->get();

        foreach($respond2->result() as $rowlist){
            $obj=new stdClass();
            $obj->machineId=$rowlist->tbl_machine_idtbl_machine;
            $obj->machineName=$rowlist->machine;
            array_push($arraylist, $obj);
        }
          
        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_cost_items;
        $obj->name=$respond->row(0)->costitemname;
		$obj->qty=$respond->row(0)->qty;
		$obj->comment=$respond->row(0)->comment;
		$obj->arrayList=$arraylist;

        echo json_encode($obj);
    }
    public function FetchJobInfo(){
        $recordID=$this->input->post('recordID');
        $arraylist=array();

        $this->db->select('*');
        $this->db->from('tbl_jobs');
        $this->db->where('tbl_cost_items_idtbl_cost_items', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();


          
        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_jobs;
        $obj->qty=$respond->row(0)->qty;
        $obj->noofups=$respond->row(0)->no_of_ups;
		$obj->wastagepercentage=$respond->row(0)->wastage_percentage;
		$obj->noofsheets=$respond->row(0)->no_of_sheets;
		$obj->noofpackets=$respond->row(0)->no_of_packets;
		$obj->hourcost=$respond->row(0)->per_hour_cost;
		$obj->speed=$respond->row(0)->speed;
		$obj->totalhours=$respond->row(0)->total_hours;
		$obj->totalcost=$respond->row(0)->total_sum;

        echo json_encode($obj);
    }
}
