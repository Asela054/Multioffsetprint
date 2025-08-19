<?php
class IssueMaterialsinfo extends CI_Model{

    public function Fetchinsertedmaterials(){
        $inquiryId=$this->input->post('inquiryId');
      
        $this->db->select('`tbl_inquiry_allocated_materials`.`issued_status`, `tbl_customerinquiry_detail`.`job`, `tbl_inquiry_allocated_materials.idtbl_inquiry_allocated_materials`, `tbl_inquiry_allocated_materials.qty`, `tbl_inquiry_allocated_materials.unitprice`, `tbl_print_material_info.materialname`, `tbl_print_material_info.idtbl_print_material_info`, `tbl_inquiry_allocated_materials.tbl_material_type_idtbl_material_type`, `tbl_inquiry_allocated_materials.tbl_categorygauge_idtbl_categorygauge`');
        $this->db->from('tbl_inquiry_allocated_materials');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_inquiry_allocated_materials.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_inquiry_allocated_materials.tbl_customerinquiry_detail_idtbl_customerinquiry_detail', 'left');
        $this->db->where('tbl_inquiry_allocated_materials.status', 1);
        $this->db->where('tbl_inquiry_allocated_materials.tbl_customerinquiry_detail_idtbl_customerinquiry_detail', $inquiryId);
        $respond=$this->db->get();

        echo json_encode($respond->result());
    }    

    public function UpdateStockForMaterialIssue(){
        $inquiryId=$this->input->post('inquiryId');
		$tableData = $this->input->post('tableData');
		$tableData2 = $this->input->post('tableData');

        
        foreach($tableData as $rowtabledata){
            $qty = $rowtabledata['col_3'];
            $materialId = $rowtabledata['col_6'];
            $issuedStatus = $rowtabledata['col_11'];

            if($issuedStatus == 0){
                $this->db->select_sum('qty');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialId);
                $query = $this->db->get('tbl_print_stock');
    
                if ($query->num_rows() > 0) {
                    $availabletotqty = $query->row()->qty; 
                    if($availabletotqty < $qty){
                        $actionObj=new stdClass();
                        $actionObj->icon='fas fa-save';
                        $actionObj->title='';
                        $actionObj->message='Not Enough Stock Available';
                        $actionObj->url='';
                        $actionObj->target='_blank';
                        $actionObj->type='danger';

                        $actionJSON=json_encode($actionObj);
                    
                        $obj=new stdClass();
                        $obj->status=1;          
                        $obj->action=$actionJSON;  
                            
                        echo json_encode($obj);
                        return;
                    }
                } else {
                    $actionObj=new stdClass();
                    $actionObj->icon='fas fa-save';
                    $actionObj->title='';
                    $actionObj->message='Not Enough Stock Available';
                    $actionObj->url='';
                    $actionObj->target='_blank';
                    $actionObj->type='danger';
                        
                    $actionJSON=json_encode($actionObj);
                    
                    $obj=new stdClass();
                    $obj->status=1;          
                    $obj->action=$actionJSON;  
                        
                    echo json_encode($obj);
                    return;
                }
            }
            
        }

        foreach($tableData2 as $rowtabledata2){
            $qty = $rowtabledata2['col_3'];
            $remainingqty = $qty;
            $count = 0;

            $materialId = $rowtabledata2['col_6'];
            $inquiryallocmaterialId = $rowtabledata2['col_10'];
            $issuedStatus = $rowtabledata2['col_11'];

            $this->db->select('*');
            $this->db->from('tbl_print_stock');
            $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialId);
            $this->db->order_by('idtbl_print_stock', 'asc');
            $query = $this->db->get();

            if($issuedStatus == 0){
                foreach ($query->result() as $row) {
                    $stockqty = $row->qty;
                    $stockId = $row->idtbl_print_stock;

                    if($remainingqty <= $stockqty){
                        $updatestockdata = array(
                            'qty'=> $stockqty - $remainingqty,
                        );

                        $this->db->where('idtbl_print_stock', $stockId);
                        $this->db->update('tbl_print_stock', $updatestockdata);

                        break;

                    }else{
                        $remainingqty = $remainingqty - $stockqty;

                        $updatestockdata = array(
                            'qty'=> 0,
                        );

                        $this->db->where('idtbl_print_stock', $stockId);
                        $this->db->update('tbl_print_stock', $updatestockdata);
                    }
                }
                $statusupdate = array(
                    'issued_status'=> 1,
                );

                $this->db->where('idtbl_inquiry_allocated_materials', $inquiryallocmaterialId);
                $this->db->update('tbl_inquiry_allocated_materials', $statusupdate);
            }
        }

        
        $actionObj=new stdClass();
		$actionObj->icon='fas fa-save';
		$actionObj->title='';
		$actionObj->message='Stock Updated Successfully';
		$actionObj->url='';
		$actionObj->target='_blank';
		$actionObj->type='success';

		$actionJSON=json_encode($actionObj);
	
		$obj=new stdClass();
		$obj->status=1;          
		$obj->action=$actionJSON;  
			
		echo json_encode($obj);
        return;
    }    

    public function ApproveMaterialIssue($x){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $updatedatetime=date('Y-m-d H:i:s');
        $z = 4;

        $data = array(
            'is_materialissue_approved' => '1',
            'tbl_user_idtbl_user'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_customerinquiry_detail', $recordID);
        $this->db->update('tbl_customerinquiry_detail', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            $actionObj->message='Record Updated Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('IssueMaterials');                 
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
            redirect('IssueMaterials'); 
        }
    }
}
