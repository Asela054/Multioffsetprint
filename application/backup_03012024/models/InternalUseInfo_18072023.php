<?php
class InternalUseInfo extends CI_Model{

    public function GetAllProducts(){
        $this->db->select('`idtbl_material_info`, `materialname`');
        $this->db->from('tbl_material_info');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function InternalUseinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $product=$this->input->post('product');
        $qty=$this->input->post('qty');
        $reason=$this->input->post('reason');
        $reducedqty = $qty;

        $recordOption=$this->input->post('recordOption');

        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'tbl_material_info_idtbl_material_info'=> $product, 
                'qty'=> $qty, 
                'reason'=> $reason, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'insertuser'=> $userID,
            );

            $this->db->insert('tbl_internal_use', $data);

            $this->db->select('*');
            $this->db->from('tbl_stock');
            $this->db->where('qty >', 0);
            $this->db->where('tbl_material_info_idtbl_material_info', $product);
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
                $this->db->where('tbl_material_info_idtbl_material_info', $product);
                $this->db->update('tbl_stock', $data);

                $reducedqty = $reducedqty - $batchqty;

                $this->db->select('*');
                $this->db->from('tbl_stock');
                $this->db->where('qty >', 0);
                $this->db->where('tbl_material_info_idtbl_material_info', $product);
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
            $this->db->where('tbl_material_info_idtbl_material_info', $product);
            $this->db->update('tbl_stock', $data);

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
                redirect('InternalUse');                
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
                redirect('InternalUse');
            }
        }
        else{
            $data = array(
                'title'=> $title, 
                'firstname'=> $fname, 
                'middlename'=> $mname, 
                'lastname'=> $lname, 
                'joindate'=> $joindate,
                'designation'=> $designation, 
                'contact'=> $contact, 
                'contact2'=> $contact2, 
                'email'=> $email, 
                'address'=> $address,
                'updateuser'=> $userID, 
                'updatedatetime' => $updatedatetime,
            );

            $this->db->where('idtbl_employee', $recordID);
            $this->db->update('tbl_employee', $data);

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
                redirect('InternalUse');                
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
                redirect('InternalUse');
            }
        }
    }
    public function InternalUsestatus($x, $y){
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

            $this->db->where('idtbl_employee', $recordID);
            $this->db->update('tbl_employee', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_employee', $recordID);
            $this->db->update('tbl_employee', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_employee', $recordID);
            $this->db->update('tbl_employee', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
    }
    public function InternalUseedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_employee');
        $this->db->where('idtbl_employee', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_employee;
        $obj->title=$respond->row(0)->title;
        $obj->fname=$respond->row(0)->firstname;
        $obj->mname=$respond->row(0)->middlename;
        $obj->lname=$respond->row(0)->lastname;
        $obj->joindate=$respond->row(0)->joindate;
        $obj->designation=$respond->row(0)->designation;
        $obj->contact=$respond->row(0)->contact;
        $obj->contact2=$respond->row(0)->contact2;
        $obj->email=$respond->row(0)->email;
        $obj->address=$respond->row(0)->address;

        echo json_encode($obj);
    }

    public function FetchAvailableStock(){
        $recordID=$this->input->post('recordID');

        $this->db->select('SUM(qty) AS total_quantity');
        $this->db->from('tbl_stock');
        $this->db->where('tbl_material_info_idtbl_material_info', $recordID);
        $this->db->where('status', 1);
        $this->db->group_by('tbl_material_info_idtbl_material_info');


        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->quantity=$respond->row(0)->total_quantity;

        echo json_encode($obj);
    }

    function updateStock($materialID, $reducedqty){
        

    }
}