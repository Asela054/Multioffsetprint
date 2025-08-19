<?php
class Assetinfo extends CI_Model{

	public function GetAssetsubcategory(){

		$this->db->select('idtbl_assetsub_category, sub_category');
        $this->db->from('tbl_assetsub_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();

	}
    public function Assetinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];


        $category=$this->input->post('Asset_cat');
		$purdate=$this->input->post('purdate');
		$purprice=$this->input->post('purprice');
		$usedate=$this->input->post('usedate');
        $location=$this->input->post('location');
		$code=$this->input->post('code');
		$discription=$this->input->post('discription');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}



        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){

            $this->db->select('tbl_assetsub_category.* ,tbl_assetmain_category.code AS maincode');
            $this->db->from('tbl_assetsub_category');
            $this->db->join('tbl_assetmain_category', 'tbl_assetmain_category.idtbl_assetmain_category = tbl_assetsub_category.tbl_assetmain_category_idtbl_assetmain_category', 'left');
            $this->db->where('idtbl_assetsub_category', $category);
            $this->db->where('tbl_assetsub_category.status', 1);
    
            $respond=$this->db->get();
            $subcode= $respond->row(0)->code;
            $maincode = $respond->row(0)->maincode;
            $fullassetcode =$maincode."/".$subcode."/".$code."/".$purdate;
           
            
            $data = array(
                'Purchase_date'=> $purdate, 
				'purchase_price'=> $purprice,
				'date'=> $usedate, 
				'location'=> $location,  
                'code'=> $fullassetcode, 
				'discription'=> $discription,  
                'depreciation_ststus'=> '0', 
				'tbl_assetsub_category_idtbl_assetsub_category'=> $category,  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_asset', $data);

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
                redirect('Asset');                
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
                redirect('Asset');
            }
        }
        else{
            $data = array(
                'Purchase_date'=> $purdate, 
				'purchase_price'=> $purprice,
				'date'=> $usedate, 
				'location'=> $location,  
                'code'=> $code, 
				'discription'=> $discription,  
                'depreciation_ststus'=> '0', 
				'tbl_assetsub_category_idtbl_assetsub_category'=> $category,  
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_asset', $recordID);
            $this->db->update('tbl_asset', $data);

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
                redirect('Asset');                
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
                redirect('Asset');
            }
        }
    }
    public function Assetstatus($x, $y){
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

            $this->db->where('idtbl_asset', $recordID);
            $this->db->update('tbl_asset', $data);



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
                redirect('Asset');                
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
                redirect('Asset');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_asset', $recordID);
            $this->db->update('tbl_asset', $data);



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
                redirect('Asset');                
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
                redirect('Asset');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_asset', $recordID);
            $this->db->update('tbl_asset', $data);



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
                redirect('Asset');                
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
                redirect('Asset');
            }
        }
    }
    public function Assetedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_asset');
        $this->db->where('idtbl_asset', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_asset;
        $obj->Purdate=$respond->row(0)->Purchase_date;
		$obj->purprice=$respond->row(0)->purchase_price;
		$obj->date=$respond->row(0)->date;
		$obj->location=$respond->row(0)->location;
        $obj->code=$respond->row(0)->code;
        $obj->discription=$respond->row(0)->discription;
        $obj->idtbl_assetsub_category=$respond->row(0)->tbl_assetsub_category_idtbl_assetsub_category;
        echo json_encode($obj);
    }
}
