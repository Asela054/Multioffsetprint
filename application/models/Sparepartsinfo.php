<?php
class Sparepartsinfo extends CI_Model {

    public function Getmachinetype(){
        $this->db->select('idtbl_machine_type,type');
        $this->db->from(' tbl_machine_type');
        // $this->db->limit(2);
        $this->db->where('status',1);

        return $respond=$this->db->get();

    }
      public function Getmachinemodels(){
        $this->db->select('idtbl_machinemodels,machinemodels_name');
        $this->db->from('tbl_machinemodels');
        // $this->db->limit(2);
        $this->db->where('status',1);

        return $respond=$this->db->get();
    }

    public function Getsupplier(){
        $this->db->select('idtbl_supplier,suppliername');
        $this->db->from('tbl_supplier');
        // $this->db->limit(2);
        $this->db->where('status',1);

        return $respond=$this->db->get();
    }

    public function Sparepartsinsertupdate() {
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $spare_part_name=$this->input->post('spare_part_name');
        $machine_type_id=$this->input->post('machine_type_id');
        $machine_models_id=$this->input->post('machine_models_id');
        $part_no=$this->input->post('part_no');
        $rack_no=$this->input->post('rack_no');
        $unit_price=$this->input->post('unit_price');
        $supplier_id=$this->input->post('supplier_id');
       

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'spare_part_name'=> $spare_part_name, 
                'machine_type_id'=> $machine_type_id, 
                'machine_models_id'=> $machine_models_id,
                'part_no'=> $part_no,
                'rack_no'=> $rack_no,
                'unit_price'=> $unit_price, 
                'supplier_id'=> $supplier_id,
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_spareparts', $data);

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
                redirect('Spareparts');                
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
                redirect('Spareparts');
            }
        }
        else{
            $data = array(
                'spare_part_name'=> $spare_part_name, 
                'machine_type_id'=> $machine_type_id, 
                'machine_models_id'=> $machine_models_id,
                'part_no'=> $part_no,
                'rack_no'=> $rack_no,
                'unit_price'=> $unit_price, 
                'supplier_id'=> $supplier_id,
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->where('idtbl_spareparts', $recordID);
            $this->db->update('tbl_spareparts', $data);

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
                redirect('Spareparts');                
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
                redirect('Spareparts');
            }
        }
    }
    public function Sparepartsstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_spareparts', $recordID);
            $this->db->update('tbl_spareparts', $data);

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
                redirect('Spareparts');                
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
                redirect('Spareparts');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_spareparts', $recordID);
            $this->db->update('tbl_spareparts', $data);

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
                redirect('Spareparts');                
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
                redirect('Spareparts');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_spareparts', $recordID);
            $this->db->update('tbl_spareparts', $data);

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
                redirect('Spareparts');                
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
                redirect('Spareparts');
            }
        }
    }
    public function Sparepartsedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_spareparts');
        $this->db->where('idtbl_spareparts', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_spareparts;
        $obj->spare_part_name=$respond->row(0)->spare_part_name;
        $obj->machine_type_id=$respond->row(0)->machine_type_id;
        $obj->machine_models_id=$respond->row(0)->machine_models_id;
        $obj->part_no=$respond->row(0)->part_no;
        $obj->rack_no=$respond->row(0)->rack_no;
        $obj->unit_price=$respond->row(0)->unit_price;
        $obj->supplier_id=$respond->row(0)->supplier_id;
        

        echo json_encode($obj);
    }
}