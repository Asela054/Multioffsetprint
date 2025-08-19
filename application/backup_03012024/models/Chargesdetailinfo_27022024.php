<?php
class Chargesdetailinfo extends CI_Model {

    public function Getchargestype() {
        $this->db->select('`idtbl_charges`, `charges_type`');
        $this->db->from('tbl_charges');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Chargesdetailinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$charges_type=$this->input->post('charges_type');
        $charges_date=$this->input->post('charges_date');
        $charges_effective=$this->input->post('charges_effective');
        $charges_price=$this->input->post('charges_price');
		$datetime=date('Y-m-d H:i:s');

		$recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $existing_records = $this->db->where('charges_type', $charges_type)
                                     ->order_by('charges_date', 'desc')
                                     ->limit(1)
                                     ->get('tbl_charges_detail')
                                     ->row();

        if (!empty($existing_records)) {
            $effective_date = date('Y-m-d', strtotime($existing_records->charges_date . ' - 1 day'));
        } else {
            $effective_date = NULL;
        }
		
		if($recordOption==1) {

			$data = array(
                'charges_type' => $charges_type, 
                'charges_date' => $charges_date,
                'charges_effective' => $effective_date,
                'price' => $charges_price,  
                'status' => '1', 
                'insertdatetime' => $datetime, 
                'tbl_user_idtbl_user' => $userID,
            );
            $this->db->insert('tbl_charges_detail', $data);

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
                redirect('Chargesdetail');

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
                redirect('Chargesdetail');
            }

		} 
		else{
            $data = array(
                'charges_type'=> $charges_type, 
                'charges_date'=> $charges_date,
                'charges_effective'=> $charges_effective,
                'price'=> $charges_price,    
                'status'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime' => $datetime,
            );
			$this->db->where('idtbl_charges_detail', $recordID);
			$this->db->update('tbl_charges_detail', $data);

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
                redirect('Chargesdetail');                
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
                redirect('Chargesdetail');
            }
		}
	}

    public function Chargesdetailedit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
        $this->db->from('tbl_charges_detail');
        $this->db->where('idtbl_charges_detail', $recordID);
        $this->db->where('status', 1);

		$respond=$this->db->get();

        $obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_charges_detail;
        $obj->charges_type=$respond->row(0)->charges_type;
        $obj->charges_date=$respond->row(0)->charges_date;
        $obj->charges_effective=$respond->row(0)->charges_effective;
        $obj->price=$respond->row(0)->price;

		echo json_encode($obj);
	}

    public function Chargesdetailstatus($x, $y) {
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
			$this->db->where('idtbl_charges_detail', $recordID);
            $this->db->update('tbl_charges_detail', $data);

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
                redirect('Chargesdetail');                
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
                redirect('Chargesdetail');
            }
		}
		else if ($type==2) {
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_charges_detail', $recordID);
            $this->db->update('tbl_charges_detail', $data);

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
                redirect('Chargesdetail');                
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
                redirect('Chargesdetail');
            }
		}
		else if ($type==3) {
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_charges_detail', $recordID);
            $this->db->update('tbl_charges_detail', $data);

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
                redirect('Chargesdetail');                
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
                redirect('Chargesdetail');
            }
        }
	}

}