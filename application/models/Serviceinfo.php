<?php
class Serviceinfo extends CI_Model{
    public function Getservicetype(){
        $this->db->select('idtbl_service_item_list, service_type');
        $this->db->from('tbl_service_item_list');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getvehicleregno(){
        $this->db->select('idtbl_vehicle, vehicle_reg_no');
        $this->db->from('tbl_vehicle');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
   
    public function Getsupplier(){
        $comapnyID=$_SESSION['company_id'];

        $this->db->select('idtbl_supplier, suppliername');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
        $this->db->where('tbl_company_idtbl_company', $comapnyID);

        return $respond=$this->db->get();
    }

    public function mileage(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_vehicle');
        $this->db->where('idtbl_vehicle', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_vehicle;
        $obj->currentmileage=$respond->row(0)->mileage;
        echo json_encode($obj);
    }

    public function getitem(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_service_item_list');
        $this->db->where('idtbl_service_item_list', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_service_item_list;
        $obj->service_type=$respond->row(0)->service_type;
        echo json_encode($obj);
    }


    public function uploadimg() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
          $error = array('error' => $this->upload->display_errors());
          echo json_encode($error);
        } else {
          $data2 = array('upload_data' => $this->upload->data());
          $file_path = './uploads/' . $data2['upload_data']['file_name'];
          
          $this->db->insert('tbl_service_bill', array('file_path' => $file_path));
          
          $data = array(
            'imagename' => $data2['upload_data']['file_name'],
            'size' => '100',
            'extension' => 'png',
            'status' => '1',
            'insertdatetime' => date('Y-m-d H:i:s'),
            'tbl_user_idtbl_user' => '1',
            'tbl_service_idtbl_service' => '1'
          );
          $this->db->insert('tbl_service_bill', $data);
          
          echo json_encode($data);
        }
      }
    
    public function serviceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $servicetype=$this->input->post('servicetype');
        $servicedate=$this->input->post('servicedate');
        $vehicleregno=$this->input->post('vehicleregno');
        $servicelocation=$this->input->post('servicelocation');
        $amount=$this->input->post('amount');
        $discription=$this->input->post('discription');
        $supplier=$this->input->post('supplier');
        $currentmileage=$this->input->post('currentmileage');
        $mileage=$this->input->post('mileage');
        $nextservicemileage=$this->input->post('nextservicemileage');
        $tableData=$this->input->post('tableData');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'tbl_service_type_idtbl_service_type'=> $servicetype, 
                'service_date'=> $servicedate, 
                'tbl_vehicle_idtbl_vehicle'=> $vehicleregno, 
                'service_location'=> $servicelocation, 
                'amount'=> $amount, 
                'discription'=> $discription, 
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'current_mileage'=> $currentmileage, 
                'service_mileage'=> $mileage, 
                'next_service_mileage'=> $nextservicemileage,
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_service', $data);
            $insertId = $this->db->insert_id();

            foreach($tableData as $rowtabledata){
                $data = array(
                    'tbl_service_idtbl_service'=> $insertId, 
                    'tbl_service_item_list_idtbl_service_item_list'=> $rowtabledata['col_3'], 
                    'quantity'=> $rowtabledata['col_2'],
                    'insertdatetime'=> $insertdatetime, 
                    'status'=> '1', 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_service_details', $data);
                
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
	
				$obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
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
	
				$obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
			}
        }
        else{
            $data = array(
                'tbl_service_type_idtbl_service_type'=> $servicetype, 
                'service_date'=> $servicedate, 
                'tbl_vehicle_idtbl_vehicle'=> $vehicleregno, 
                'service_location'=> $servicelocation, 
                'amount'=> $amount, 
                'discription'=> $discription, 
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'current_mileage'=> $currentmileage, 
                'service_mileage'=> $mileage, 
                'next_service_mileage'=> $nextservicemileage,
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
            );

            $this->db->where('idtbl_service', $recordID);
            $this->db->update('tbl_service', $data);

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
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
                
             
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
                
                
            }
        }
    }
    
    public function servicestatus($x, $y){
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

            $this->db->where('idtbl_service', $recordID);
            $this->db->update('tbl_service', $data);

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
                redirect('Service');                
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
                redirect('Service');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_service', $recordID);
            $this->db->update('tbl_service', $data);

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
                redirect('Service');                
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
                redirect('Service');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_service', $recordID);
            $this->db->update('tbl_service', $data);

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
                redirect('Service');                
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
                redirect('Service');
            }
        }
    }
    public function serviceedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_service');
        $this->db->where('idtbl_service', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_service;
        $obj->servicetype=$respond->row(0)->tbl_service_type_idtbl_service_type;
        $obj->servicedate=$respond->row(0)->service_date;
        $obj->vehicleregno=$respond->row(0)->tbl_vehicle_idtbl_vehicle;
        $obj->servicelocation=$respond->row(0)->service_location;
        $obj->amount=$respond->row(0)->amount;
        $obj->discription=$respond->row(0)->discription;
        $obj->supplier=$respond->row(0)->tbl_supplier_idtbl_supplier;
        $obj->currentmileage=$respond->row(0)->current_mileage;
        $obj->mileage=$respond->row(0)->service_mileage;
        $obj->nextservicemileage=$respond->row(0)->next_service_mileage;

    
        echo json_encode($obj);
    }
}
