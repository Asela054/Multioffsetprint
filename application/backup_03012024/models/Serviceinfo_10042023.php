<?php
class Serviceinfo extends CI_Model{
    public function Getvehicleregno(){
        $this->db->select('idtbl_vehicle, vehicle_reg_no');
        $this->db->from('tbl_vehicle');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getsupplier(){
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

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

    
    public function serviceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $servicedate=$this->input->post('servicedate');
        $vehicleregno=$this->input->post('vehicleregno');
        $servicelocation=$this->input->post('servicelocation');
        $nextservicedate=$this->input->post('nextservicedate');
        $discription=$this->input->post('discription');
        $supplier=$this->input->post('supplier');
        $currentmileage=$this->input->post('currentmileage');
        $mileage=$this->input->post('mileage');
        $nextservicemileage=$this->input->post('nextservicemileage');

      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'service_date'=> $servicedate, 
                'tbl_vehicle_idtbl_vehicle'=> $vehicleregno, 
                'service_location'=> $servicelocation, 
                'next_service_date'=> $nextservicedate, 
                'discription'=> $discription, 
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'current_mileage'=> $currentmileage, 
                'service_mileage'=> $mileage, 
                'next_service_mileage'=> $nextservicemileage,
                // 'path'=> $bill, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_service', $data);



// Configure upload directory and allowed file types
$upload_dir = 'images\bill'.DIRECTORY_SEPARATOR;
$allowed_types = array('jpg', 'png', 'jpeg', 'gif');

// Define maxsize for files i.e 2MB
$maxsize = 10 * 1024 * 1024;

// Checks if user sent an empty form
if(!empty(array_filter($_FILES['files']['name']))) {

   // Loop through each file in files[] array
   foreach ($_FILES['files']['tmp_name'] as $key => $value) {
      
      $file_tmpname = $_FILES['files']['tmp_name'][$key];
      $file_name = $_FILES['files']['name'][$key];
      $file_size = $_FILES['files']['size'][$key];
      $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

      // Set upload file path
      $filepath = $upload_dir.$file_name;

      // Check file type is allowed or not
      if(in_array(strtolower($file_ext), $allowed_types)) {

         // Verify file size - 2MB max
         if ($file_size > $maxsize)    
            echo "Error: File size is larger than the allowed limit.";

         // If file with name already exist then append time in
         // front of name of the file to avoid overwriting of file
         if(file_exists($filepath)) {
            $filepath = $upload_dir.time().$file_name;
            
            $this->db->select('idtbl_service');
            $this->db->from('tbl_service');
            $this->db->ORDER_BY('idtbl_service', 'DESC', 'LIMIT1');
            $this->db->where('status', 1);
    
            $respond=$this->db->get();
    
            $idtbl_service=$respond->row(0)->idtbl_service;

            if( move_uploaded_file($file_tmpname, $filepath)) {
                $filedata = array(
                    'imagename'=> $file_name, 
                    'size'=> $file_size, 
                    'extension'=> $file_ext, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_service_idtbl_service'=> $idtbl_service,
                );
                $this->db->insert('tbl_service_bill', $filedata);
            //    echo "{$file_name} successfully uploaded <br />";
            }
            else {               
            //    echo "Error uploading {$file_name} <br />";
            }
         }
         else {
            $this->db->select('idtbl_service');
            $this->db->from('tbl_service');
            $this->db->ORDER_BY('idtbl_service', 'DESC' ,'LIMIT 1');
            $this->db->where('status', 1);
    
            $respond=$this->db->get();
    
            $idtbl_service=$respond->row(0)->idtbl_service;
            
            if( move_uploaded_file($file_tmpname, $filepath)) {
                
                
                $filedata = array(
                    'imagename'=> $file_name, 
                    'size'=> $file_size, 
                    'extension'=> $file_ext, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_service_idtbl_service'=> $idtbl_service,
                );
                $this->db->insert('tbl_service_bill', $filedata);
            //    echo "{$file_name} successfully uploaded <br />";
            }
            else {               
            //    echo "Error uploading {$file_name} <br />";
            }
         }
      }
      else {
         
         // If file extension not valid
         echo "Error uploading {$file_name} ";
         echo "({$file_ext} file type is not allowed)<br / >";
      }
   }
}
else {
   
   // If no files selected
   echo "No files selected.";
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
        else{
            $data = array(
                'service_date'=> $servicedate, 
                'tbl_vehicle_idtbl_vehicle'=> $vehicleregno, 
                'service_location'=> $servicelocation, 
                'next_service_date'=> $nextservicedate, 
                'discription'=> $discription, 
                'tbl_supplier_idtbl_supplier '=> $supplier,
                'next_service_mileage'=> $nextservicemileage,
                // 'path'=> $bill, 
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
            );

            $this->db->where('idtbl_service', $recordID);
            $this->db->update('tbl_service', $data);


// Configure upload directory and allowed file types
$upload_dir = 'images\bill'.DIRECTORY_SEPARATOR;
$allowed_types = array('jpg', 'png', 'jpeg', 'gif');

// Define maxsize for files i.e 2MB
$maxsize = 10 * 1024 * 1024;

// Checks if user sent an empty form
if(!empty(array_filter($_FILES['files']['name']))) {

   // Loop through each file in files[] array
   foreach ($_FILES['files']['tmp_name'] as $key => $value) {
      
      $file_tmpname = $_FILES['files']['tmp_name'][$key];
      $file_name = $_FILES['files']['name'][$key];
      $file_size = $_FILES['files']['size'][$key];
      $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

      // Set upload file path
      $filepath = $upload_dir.$file_name;

      // Check file type is allowed or not
      if(in_array(strtolower($file_ext), $allowed_types)) {

         // Verify file size - 2MB max
         if ($file_size > $maxsize)    
            echo "Error: File size is larger than the allowed limit.";

         // If file with name already exist then append time in
         // front of name of the file to avoid overwriting of file
         if(file_exists($filepath)) {
            $filepath = $upload_dir.time().$file_name;
            
            
            if( move_uploaded_file($file_tmpname, $filepath)) {
                $filedata = array(
                    'imagename'=> $file_name, 
                    'size'=> $file_size, 
                    'extension'=> $file_ext, 
                    'updateuser'=> $userID, 
                    'updatedatetime' => $insertdatetime,
                );
                $this->db->where('idtbl_service_bill', $recordID);
                $this->db->update('tbl_service_bill', $filedata);
            //    echo "{$file_name} successfully uploaded <br />";
            }
            else {               
            //    echo "Error uploading {$file_name} <br />";
            }
         }
         else {

            
            if( move_uploaded_file($file_tmpname, $filepath)) {
                
                
                $filedata = array(
                    'imagename'=> $file_name, 
                    'size'=> $file_size, 
                    'extension'=> $file_ext, 
                    'updateuser'=> $userID, 
                    'updatedatetime' => $insertdatetime,
                );
                $this->db->where('idtbl_service_bill', $recordID);
                $this->db->update('tbl_service_bill', $filedata);
            //    echo "{$file_name} successfully uploaded <br />";
            }
            else {               
            //    echo "Error uploading {$file_name} <br />";
            }
         }
      }
      else {
         
         // If file extension not valid
         echo "Error uploading {$file_name} ";
         echo "({$file_ext} file type is not allowed)<br / >";
      }
   }
}
else {
   
   // If no files selected
   echo "No files selected.";
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
        $obj->servicedate=$respond->row(0)->service_date;
        $obj->vehicleregno=$respond->row(0)->tbl_vehicle_idtbl_vehicle;
        $obj->servicelocation=$respond->row(0)->service_location;
        $obj->nextservicedate=$respond->row(0)->next_service_date;
        $obj->discription=$respond->row(0)->discription;
        $obj->supplier=$respond->row(0)->tbl_supplier_idtbl_supplier;
        $obj->currentmileage=$respond->row(0)->current_mileage;
        $obj->mileage=$respond->row(0)->service_mileage;
        $obj->nextservicemileage=$respond->row(0)->next_service_mileage;

    
        echo json_encode($obj);
    }
}