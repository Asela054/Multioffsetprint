<?php
class Assetremoveapproveinfo extends CI_Model{

    public function Assetremoveapproveinsert(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $approveorreject=$this->input->post('approveorreject');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

      
            $data = array( 
                'approve_status'=>  $approveorreject, 
                'insertdatetime'=> $insertdatetime,   
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_asset_remove', $recordID);
            $this->db->update('tbl_asset_remove', $data);          
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Updated Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Assetremoveapprove');                
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
                redirect('Assetremoveapprove');
            
        }
       
    }
    public function Assetremoveapproveedit(){
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
