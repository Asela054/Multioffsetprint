<?php
class Materialallocationinfo extends CI_Model{

    public function GetMaterialList(){
        $this->db->select('idtbl_print_material_info, materialname');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Suppliertypeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $supplier_cat=$this->input->post('supplier_cat');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'type'=> $supplier_cat, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_supplier_type', $data);

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
                redirect('Suppliertype');                
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
                redirect('Suppliertype');
            }
        }
        else{
            $data = array(
				'type'=> $supplier_cat,
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_supplier_type', $recordID);
            $this->db->update('tbl_supplier_type', $data);

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
                redirect('Suppliertype');                
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
                redirect('Suppliertype');
            }
        }
    }
    public function Suppliertypestatus($x, $y){
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

			$this->db->where('idtbl_supplier_type', $recordID);
            $this->db->update('tbl_supplier_type', $data);

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
                redirect('Suppliertype');                
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
                redirect('Suppliertype');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_supplier_type', $recordID);
            $this->db->update('tbl_supplier_type', $data);

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
                redirect('Suppliertype');                
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
                redirect('Suppliertype');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_supplier_type', $recordID);
            $this->db->update('tbl_supplier_type', $data);

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
                redirect('Suppliertype');                
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
                redirect('Suppliertype');
            }
        }
    }
    public function Suppliertypeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_supplier_type');
        $this->db->where('idtbl_supplier_type', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_supplier_type;
        $obj->type=$respond->row(0)->type;
        echo json_encode($obj);
    }
    public function Getmaterialdetailsforqutation(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_print_material_info');
        $this->db->where('idtbl_print_material_info', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_print_material_info;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->materialtype=$respond->row(0)->tbl_material_type_idtbl_material_type;
        $obj->categorygaugetype=$respond->row(0)->tbl_categorygauge_idtbl_categorygauge;
        echo json_encode($obj);
    }

    public function Getcustomerlist(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getcustomerjobs() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('`idtbl_customerinquiry_detail`,`job`, `job_no`, `job_id`');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry.tbl_customer_idtbl_customer', $recordID);
        $this->db->group_by('job_id');

    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }

    public function Getjobvisequotations() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('`idtbl_jobquatation`,`quantity`');
		$this->db->from('tbl_jobquatation');
		$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.job_id = tbl_jobquatation.customerjob_id');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.approvestatus', 1);
		$this->db->where('tbl_jobquatation.approvedstatus', 0);
		$this->db->where('tbl_jobquatation.customerjob_id', $recordID);
        $this->db->group_by('idtbl_jobquatation');

    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
    public function Getquotationdetailsfortable() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('`tbl_jobquatation.idtbl_jobquatation`,`tbl_jobquatation.no_sheet` AS `qty`, `tbl_jobquatation_material_detail.total`,`tbl_jobquatation_material_detail.unit_price`, `tbl_print_material_info.materialname`, `tbl_print_material_info.idtbl_print_material_info`, `tbl_print_material_info.tbl_material_type_idtbl_material_type`, `tbl_print_material_info.tbl_categorygauge_idtbl_categorygauge`,');
		$this->db->from('tbl_jobquatation');
		$this->db->join('tbl_jobquatation_material_detail', 'tbl_jobquatation_material_detail.tbl_jobquatation_idtbl_jobquatation = tbl_jobquatation.idtbl_jobquatation');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobquatation_material_detail.tbl_print_material_info_idtbl_print_material_info');
		$this->db->where('tbl_jobquatation.status', 1);
		$this->db->where('tbl_jobquatation_material_detail.tbl_jobquatation_idtbl_jobquatation', $recordID);
       
        $respond1 = $this->db->get();

        $this->db->select('`tbl_jobquatation.idtbl_jobquatation`,`tbl_jobquotation_foiling_details.qty1` AS `qty`, `tbl_jobquotation_foiling_details.total`,`tbl_jobquotation_foiling_details.unit_price`, `tbl_print_material_info.materialname`, `tbl_print_material_info.idtbl_print_material_info`, `tbl_print_material_info.tbl_material_type_idtbl_material_type`, `tbl_print_material_info.tbl_categorygauge_idtbl_categorygauge`,');
		$this->db->from('tbl_jobquatation');
		$this->db->join('tbl_jobquotation_foiling_details', 'tbl_jobquotation_foiling_details.tbl_jobquatation_idtbl_jobquatation = tbl_jobquatation.idtbl_jobquatation');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobquotation_foiling_details.tbl_foiling_idtbl_foiling');
		$this->db->where('tbl_jobquatation.status', 1);
		$this->db->where('tbl_jobquotation_foiling_details.tbl_jobquatation_idtbl_jobquatation', $recordID);
        
        $respond2 = $this->db->get();
        
        $this->db->select('`tbl_jobquatation.idtbl_jobquatation`,`tbl_jobquotation_varnish_details.qty1` AS `qty`, `tbl_jobquotation_varnish_details.total`,`tbl_jobquotation_varnish_details.unit_price`, `tbl_print_material_info.materialname`, `tbl_print_material_info.idtbl_print_material_info`, `tbl_print_material_info.tbl_material_type_idtbl_material_type`, `tbl_print_material_info.tbl_categorygauge_idtbl_categorygauge`,');
		$this->db->from('tbl_jobquatation');
		$this->db->join('tbl_jobquotation_varnish_details', 'tbl_jobquotation_varnish_details.tbl_jobquatation_idtbl_jobquatation = tbl_jobquatation.idtbl_jobquatation');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobquotation_varnish_details.tbl_print_material_info_idtbl_print_material_info');
		$this->db->where('tbl_jobquatation.status', 1);
		$this->db->where('tbl_jobquotation_varnish_details.tbl_jobquatation_idtbl_jobquatation', $recordID);
        
        $respond3 = $this->db->get();
   
        $this->db->select('`tbl_jobquatation.idtbl_jobquatation`,`tbl_jobquotation_rimming_details.qty` AS `qty`, `tbl_jobquotation_rimming_details.total`,`tbl_jobquotation_rimming_details.unit_price`, `tbl_print_material_info.materialname`, `tbl_print_material_info.idtbl_print_material_info`, `tbl_print_material_info.tbl_material_type_idtbl_material_type`, `tbl_print_material_info.tbl_categorygauge_idtbl_categorygauge`,');
		$this->db->from('tbl_jobquatation');
		$this->db->join('tbl_jobquotation_rimming_details', 'tbl_jobquotation_rimming_details.tbl_jobquatation_idtbl_jobquatation = tbl_jobquatation.idtbl_jobquatation');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobquotation_rimming_details.tbl_rimming_idtbl_rimming');
		$this->db->where('tbl_jobquatation.status', 1);
		$this->db->where('tbl_jobquotation_rimming_details.tbl_jobquatation_idtbl_jobquatation', $recordID);
        
        $respond4 = $this->db->get();
   
        $merged_results = array_merge(
            $respond1->result_array(),
            $respond2->result_array(),
            $respond3->result_array(),
            $respond4->result_array()
        );

        echo json_encode($merged_results);
    }

    public function Getjoblist() {
        $customerId=$this->input->post('customerId');

		$this->db->select('`idtbl_customerinquiry_detail`,`job`, `job_no`');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry_detail.tbl_customer_idtbl_customer', $customerId);
		
		// Exclude records where job_finish_status is 1
		$this->db->where('tbl_customerinquiry_detail.job_finish_status !=', 1);
		
		// Include records where (qty - actual_qty) > 0
		$this->db->where('(tbl_customerinquiry_detail.qty - tbl_customerinquiry_detail.actual_qty) >', 0);
		$this->db->order_by('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', 'DESC');
	
		return $respond=$this->db->get();
	}

    public function Insertupdateallocatedmaterials(){
        $this->db->trans_begin();
        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $quotationid=$this->input->post('quotationid');
      
        $materialrecordID=$this->input->post('materialrecordID');
        $materialrecordOption=$this->input->post('materialrecordOption');

        $insertdatetime=date('Y-m-d H:i:s');


        foreach($tableData as $rowtabledata){
            $qty=$rowtabledata['col_2'];
            $unitprice=$rowtabledata['col_3'];
            $totalsum=$rowtabledata['col_4'];

            $materialId=$rowtabledata['col_6'];
            $materialtypeId=$rowtabledata['col_7'];
            $gaugetypeId=$rowtabledata['col_8'];

            // $allocatedmaterialId=$rowtabledata['col_8'];
            $allocatedmaterialId = 0;

            if($materialrecordOption == 0){
                $data = array(
                    'qty'=> $qty, 
                    'unitprice'=> $unitprice, 
                    'totalprice'=> $qty * $unitprice, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialId, 
                    'tbl_categorygauge_idtbl_categorygauge'=> $gaugetypeId, 
                    'tbl_material_type_idtbl_material_type'=> $materialtypeId, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobquatation_idtbl_jobquatation'=> $quotationid,
                );
                $this->db->insert('tbl_inquiry_allocated_materials', $data);
            }else if($materialrecordOption == 1){

                $data = array(
                    'qty'=> $qty, 
                    'unitprice'=> $unitprice, 
                    'totalprice'=> $qty * $unitprice, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialId, 
                    'tbl_categorygauge_idtbl_categorygauge'=> $gaugetypeId, 
                    'tbl_material_type_idtbl_material_type'=> $materialtypeId, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobquatation_idtbl_jobquatation'=> $quotationid,
                );

                $this->db->where('idtbl_inquiry_allocated_materials', $allocatedmaterialId);
                $this->db->update('tbl_inquiry_allocated_materials', $data);
            }
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Updated Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='primary';

            $actionJSON=json_encode($actionObj);
            echo $actionJSON;
            
            // redirect('Approvedcustomerinquiry');                
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
            
            echo $actionJSON;
            // redirect('Approvedcustomerinquiry');
        }
    }
    public function ApproveAllocatedQuotation($quotationid){
        $this->db->trans_begin();
        $userID=$_SESSION['userid'];

        $data = array(
            'approvedstatus'=> 1
        );

        $this->db->where('idtbl_jobquatation', $quotationid);
        $this->db->update('tbl_jobquatation', $data);

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

            redirect('MaterialAllocation');

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
        }
        redirect('MaterialAllocation');

    }

    public function GetAllocationdetailsformodal(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT * FROM `tbl_inquiry_allocated_materials` 
		LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_inquiry_allocated_materials`.`tbl_print_material_info_idtbl_print_material_info`
		WHERE `tbl_inquiry_allocated_materials`.`tbl_jobquatation_idtbl_jobquatation`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
           
            $html.='
            <tr">
                <td>'.$rowlist->materialname.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->unitprice.'</td>
                <td>'.$rowlist->qty * $rowlist->unitprice.'</td>
             </tr>
            ';
        }
        echo ($html);
    }

}
