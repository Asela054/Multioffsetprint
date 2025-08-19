<?php
class Assetremoveinfo extends CI_Model{

    public function Assetremoveinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $removetype=$this->input->post('remove_type');
		$currentvalue=$this->input->post('currentvalue');
		$removedate=$this->input->post('removedate');
		
        $assetid=$this->input->post('hiddenassetid');
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'removetype'=> $removetype, 
				'remove_date'=> $removedate,
				'asset_valuability'=> $currentvalue,  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_asset_depreciation_idtbl_asset_depreciation'=> $recordID,  
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_asset_remove', $data);

 // update depreciation status in asset table
            $data2 = array(
                'asset_remove_status' => $removetype,
            );

            $this->db->where('idtbl_asset', $assetid);
            $this->db->update('tbl_asset', $data2);

            // remove asset from depreciation table
            $data3 = array(
                'status' => '3',
            );

            $this->db->where('idtbl_asset_depreciation', $recordID);
            $this->db->update('tbl_asset_depreciation', $data3);


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
                redirect('Assetremove');                
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
                redirect('Assetremove');
            }
        }
        else{
            $data = array(
                'removetype'=> $removetype, 
				'remove_date'=> $removedate,
				'asset_valuability'=> $currentvalue, 
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_asset_remove', $recordID);
            $this->db->update('tbl_asset_remove', $data);
// update remove status in asset table
            $data2 = array(
                'asset_remove_status' => $removetype,
            );

            $this->db->where('idtbl_asset', $assetid);
            $this->db->update('tbl_asset', $data2);


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
                redirect('Assetremove');                
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
                redirect('Assetremove');
            }
        }
    }
    public function Assetremovestatus($x, $y){
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

            $this->db->where('idtbl_asset_remove', $recordID);
            $this->db->update('tbl_asset_remove', $data);


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
                redirect('Assetremove');                
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
                redirect('Assetremove');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_asset_remove', $recordID);
            $this->db->update('tbl_asset_remove', $data);


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
                redirect('Assetremove');                
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
                redirect('Assetremove');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_asset_remove', $recordID);
            $this->db->update('tbl_asset_remove', $data);


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
                redirect('Assetremove');                
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
                redirect('Assetremove');
            }
        }
    }
    public function Assetremoveedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_asset_remove');
        $this->db->join('tbl_asset_depreciation', 'tbl_asset_depreciation.idtbl_asset_depreciation = tbl_asset_remove.tbl_asset_depreciation_idtbl_asset_depreciation', 'left');
        $this->db->where('idtbl_asset_remove', $recordID);
        $this->db->where('tbl_asset_remove.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_asset_remove;
        $obj->purprice=$respond->row(0)->purchest_price;
		$obj->affective_date=$respond->row(0)->depreciation_affective_date;
		$obj->depmonths=$respond->row(0)->depreciation_months;
        $obj->assetid=$respond->row(0)->tbl_asset_idtbl_asset;
        $obj->type=$respond->row(0)->removetype;
        $obj->date=$respond->row(0)->remove_date;
        $obj->valuability=$respond->row(0)->asset_valuability;
        echo json_encode($obj);
    }
}
