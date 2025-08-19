<?php
class Userinfo extends CI_Model{
    public function LoginUser(){
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $username);
        // $this->db->where('password', $password);
        // $this->db->where('status', 1);
        
        $respond=$this->db->get();
        // print_r($this->db->last_query());

        $hash_password = password_verify($password, $respond->row(0)->password);
		if($hash_password === true) {          
            return $respond->row(0);
        }
        else{
            return false; 
        }
    }


    public function Usertype(){
        $this->db->select('idtbl_user_type, type');
        $this->db->from('tbl_user_type');

        return $respond=$this->db->get();
    }
    public function Useraccountedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->id;
        $obj->name=$respond->row(0)->name;
        $obj->username=$respond->row(0)->email;
        //$obj->type=$respond->row(0)->tbl_user_type_idtbl_user_type;

        echo json_encode($obj);
    }
    public function Useraccountinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $accountname=$this->input->post('accountname');
        $username=$this->input->post('username');
        if (!empty($this->input->post('password'))) {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        //$usertype=$this->input->post('usertype');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'name'=>$accountname, 
                'email'=>$username, 
                'password'=>$password, 
                'status'=>'1', 
                'created_at'=>$updatedatetime, 
            );

            $this->db->insert('users', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
        else{
            if(!empty($this->input->post('password'))){

                $data = array(
                    'name'=>$accountname, 
                    'email'=>$username, 
                    'password'=>$password, 
                    'modified_user_id'=>$userID, 
                    'updated_at'=>$updatedatetime, 
                );
    
                $this->db->where('id', $recordID);
                $this->db->update('users', $data);
            }
            else{
                $data = array(
                    'name'=>$accountname, 
                    'email'=>$username, 
                    'modified_user_id'=>$userID, 
                    'updated_at'=>$updatedatetime, 
                );
    
                $this->db->where('id', $recordID);
                $this->db->update('users', $data);
            }

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
    }
    public function Useraccountstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'modified_user_id'=> $userID, 
                'updated_at'=> $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('users', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'modified_user_id'=> $userID, 
                'updated_at'=> $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('users', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'modified_user_id'=> $userID, 
                'updated_at'=> $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('users', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
    }
    public function Usertypeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_user_type');
        $this->db->where('idtbl_user_type', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_user_type;
        $obj->type=$respond->row(0)->type;

        echo json_encode($obj);
    }
    public function Usertypeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $usertype=$this->input->post('usertype');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'type'=> $usertype,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime
            );

            $this->db->insert('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
        else{
            $data = array(
                'type'=> $usertype,
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
    }
    public function Usertypestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
    }
    public function Menulist(){
        $this->db->select('idtbl_menu_list, menu');
        $this->db->from('tbl_menu_list');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Useraccountmenu(){
        if($_SESSION['userid']==1){
            $this->db->select('id, name');
            $this->db->from('users');
            $this->db->where('status', 1);
        }
        else{
            $this->db->select('id, name');
            $this->db->from('users');
            $this->db->where('id >', '1');
            $this->db->where('status', 1);
        }        

        return $respond=$this->db->get();
    }
    public function Userprivilegeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $userlist=$this->input->post('userlist');
        $menulist=$this->input->post('menulist');
        if(!empty($this->input->post('addcheck'))){$addcheck=$this->input->post('addcheck');}else{$addcheck=0;}
        if(!empty($this->input->post('editcheck'))){$editcheck=$this->input->post('editcheck');}else{$editcheck=0;}
        if(!empty($this->input->post('statuscheck'))){$statuscheck=$this->input->post('statuscheck');}else{$statuscheck=0;}
        if(!empty($this->input->post('removecheck'))){$removecheck=$this->input->post('removecheck');}else{$removecheck=0;}

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d h:i:s');

        if($recordOption==1){
            foreach($menulist as $rowmenulist){
                $data = array(
                    'create'=>$addcheck,
                    'update'=>$editcheck,
                    'statuschange'=>$statuscheck,
                    'delete'=>$removecheck,
                    'view'=>'1',
                    'status'=>'1',
                    'idtbl_user_tbl_user'=>$userlist,
                    'idtbl_menu'=>$rowmenulist
                );

                $this->db->insert('permissions_machines', $data);

               
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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
        else{
            foreach($menulist as $rowmenulist){
                $data = array(
                    'create'=>$addcheck,
                    'update'=>$editcheck,
                    'statuschange'=>$statuscheck,
                    'delete'=>$removecheck,
                    'view'=>'1',
                    'status'=>'1',
                    'idtbl_user_tbl_user'=>$userlist,
                    'idtbl_menu'=>$rowmenulist
                );


                $this->db->where('id', $recordID);
                $this->db->update('permissions_machines', $data);
            }

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
    }
    public function Userprivilegeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('permissions_machines');
        $this->db->where('id', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $menulistArray=array();
        $objmenulist=new stdClass();
        $objmenulist->menulistID=$respond->row(0)->idtbl_menu;
        array_push($menulistArray, $objmenulist);

        $obj=new stdClass();
        $obj->id=$respond->row(0)->id;
        $obj->add=$respond->row(0)->create;
        $obj->edit=$respond->row(0)->update;
        $obj->statuschange=$respond->row(0)->statuschange;
        $obj->remove=$respond->row(0)->delete;
        $obj->user=$respond->row(0)->idtbl_user_tbl_user;
        $obj->menu=$menulistArray;

        echo json_encode($obj);
    }
    public function Userprivilegestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d h:i:s');

        if($type==1){
            $data = array(
                'status' => '1'
            );

            $this->db->where('id', $recordID);
            $this->db->update('permissions_machines', $data);

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2'
            );

            $this->db->where('id', $recordID);
            $this->db->update('permissions_machines', $data);

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3'
            );

            $this->db->where('id', $recordID);
            $this->db->update('permissions_machines', $data);
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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
    }
}