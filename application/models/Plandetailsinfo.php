<?php
class Plandetailsinfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function GetInquiryDetails(){
        $recordID=$this->input->post('recordId');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $respond=$this->db->get();
        return $respond->result_array();
    }
   

    public function GetJobList(){
        $recordID=$this->input->post('recordId');


        $html=''; 
        $sql = "SELECT `dp`.`idtbl_customerinquiry_detail`, `dp`.`job`, `dp`.`qty`, `dp`.`comments`, `p`.`idtbl_delivery_plan` FROM `tbl_customerinquiry` AS `d` JOIN `tbl_customerinquiry_detail` AS `dp` ON (`dp`.`tbl_customerinquiry_idtbl_customerinquiry` = `d`.`idtbl_customerinquiry`) JOIN `tbl_delivery_plan` AS `p` ON (`p`.`idtbl_customerinquiry` = `d`.`idtbl_customerinquiry`) WHERE `dp`.`tbl_customerinquiry_idtbl_customerinquiry` = '$recordID' GROUP BY `dp`.`idtbl_customerinquiry_detail`";
        $respond=$this->db->query($sql);
              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_customerinquiry_detail.'">
                <td>'.$rowlist->idtbl_customerinquiry_detail.'</td>
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->comments.'</td>
                <td>'.$rowlist->qty.'</td>
                <td class = "text-center">
                <button type="button" id="'.$rowlist->idtbl_customerinquiry_detail. ','.$rowlist->idtbl_delivery_plan.'" class="btn btn-outline-primary btn-sm btnViewDelivery mr-1"><i class="fas fa-calendar-check"></i>
                </button>
                </td>
       
                </tr>';
        }

        echo $html;
    }

    public function GetDeliveryist(){
        $recordID=$this->input->post('recordId');


        $html=''; 
        $this->db->select('`tbl_customerinquiry`.`po_number`, `tbl_delivery_plan`.`specialdeliveryid`, `tbl_delivery_plan`.`idtbl_delivery_plan`');
        $this->db->from('tbl_delivery_plan');
        $this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_delivery_plan.idtbl_customerinquiry');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry = tbl_customerinquiry.idtbl_customerinquiry');
        $this->db->where('tbl_delivery_plan.idtbl_customerinquiry', $recordID);
        $this->db->where('tbl_delivery_plan.status', '1');
        $this->db->group_by('tbl_delivery_plan.idtbl_delivery_plan');
        $respond=$this->db->get();
              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_delivery_plan.'">
                <td>'.$rowlist->idtbl_delivery_plan.'</td>
                <td>'.$rowlist->po_number.'</td>
                <td>'.$rowlist->specialdeliveryid.'</td>
                <td class = "text-center">
                <button type="button" id="'.$rowlist->idtbl_delivery_plan.'" class="btn btn-outline-primary btn-sm btnViewDelivery mr-1"><i class="fas fa-calendar-check"></i>
                </button>
                </td>
       
                </tr>';
        }

        echo $html;
    }

    public function GetDeliveryPlanDetails(){
        $deliveryId=$this->input->post('deliveryId');
        $today = date("Y-m-d");

        $this->db->select('`tbl_delivery_plan_details`.`idtbl_delivery_plan_details`, `tbl_delivery_plan_details`.`deliveryDate`, `tbl_delivery_plan_details`.`qty`, `tbl_delivery_plan_details`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail`, `tbl_customerinquiry_detail`.`job`, `tbl_delivery_plan_details`.`completestatus`, `tbl_delivery_plan_details`.`special_id`');
        $this->db->from('tbl_delivery_plan');
        $this->db->join('tbl_delivery_plan_details', 'tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan = tbl_delivery_plan.idtbl_delivery_plan');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->where('tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan', $deliveryId);
        $respond=$this->db->get();

        $html=''; 
              
        foreach($respond->result() as $rowlist){
            if($rowlist->completestatus == 1){
                $html .= '<tr class = "table-success" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            }else if($rowlist->completestatus == 0 && $today > $rowlist->deliveryDate ){
                $html .= '<tr class = "table-danger" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            }else{
                $html .= '<tr class = "" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            }
            
            $html .= '<td>'.$rowlist->special_id.'</td>
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->deliveryDate.'</td>
                <td>'.$rowlist->qty.'</td>
                <td class = "text-center">
                <button type="button" id="'.$rowlist->idtbl_delivery_plan_details.'" class="btn btn-outline-primary btn-sm btnViewDeliveryQuantities mr-1"><i class="fas fa-eye"></i>
                </button>
                </td>
       
                </tr>';
        }

        echo $html;
    }

    public function GetFinishQtyList(){
        $deliveryId=$this->input->post('deliveryId');
        $today = date("Y-m-d");
        $this->db->select('`tbl_delivery_plan_details`.`idtbl_delivery_plan_details`, `tbl_delivery_plan_details`.`completestatus`, `tbl_cost_items`.`costitemname`, `tbl_cost_items`.`qty`, `tbl_delivery_plan_details`.`qty` as `deliveryqty`, `tbl_customerinquiry_detail`.`qty` as `inquiryqty`, SUM(`tbl_machine_allocation_details`.`completedqty`) AS `finishedqty`, SUM(`tbl_machine_allocation_details`.`wastageqty`) AS `wastageqty`');
        $this->db->from('tbl_delivery_plan_details');
        $this->db->join('tbl_machine_allocation', 'tbl_machine_allocation.tbl_delivery_plan_details_idtbl_delivery_plan_details = tbl_delivery_plan_details.idtbl_delivery_plan_details');
        $this->db->join('tbl_machine_allocation_details', 'tbl_machine_allocation_details.tbl_machine_allocation_idtbl_machine_allocation = tbl_machine_allocation.idtbl_machine_allocation');
        $this->db->join('tbl_cost_items', 'tbl_cost_items.tbl_customerinquiry_detail_idtbl_customerinquiry_detail = tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->where('tbl_machine_allocation.tbl_delivery_plan_details_idtbl_delivery_plan_details', $deliveryId);
        $this->db->where('tbl_cost_items.status', '1');
        $this->db->where('tbl_machine_allocation.used_status', '0');
        $this->db->group_by('tbl_cost_items.idtbl_cost_items, tbl_machine_allocation.idtbl_machine_allocation');
        $respond=$this->db->get();
        
        $html=''; 
              
        foreach($respond->result() as $rowlist){
            // if($rowlist->completestatus == 1){
            //     $html .= '<tr class = "table-success" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            // }else if($rowlist->completestatus == 0){
            //     $html .= '<tr class = "table-danger" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            // }else{
            //     $html .= '<tr class = "" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            // }
            $html .= '<tr class = "" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            $html .= '<td>'.$rowlist->costitemname.'</td>
                <td>'.($rowlist->deliveryqty) * ($rowlist->qty/$rowlist->inquiryqty).'</td>
                <td>'.$rowlist->qty/$rowlist->inquiryqty.'</td>
                <td>'.$rowlist->finishedqty.'</td>
                <td>'.$rowlist->wastageqty.'</td>
                </tr>';
        }
        echo $html;
    }
    public function GetAvailabilityOfItems(){
        $deliveryId=$this->input->post('deliveryId');
        $today = date("Y-m-d");
        $this->db->select('`tbl_delivery_plan_details`.`idtbl_delivery_plan_details`, `tbl_delivery_plan_details`.`completestatus`, `tbl_cost_items`.`costitemname`, `tbl_cost_items`.`qty`, `tbl_delivery_plan_details`.`qty` as `deliveryqty`, `tbl_customerinquiry_detail`.`qty` as `inquiryqty`, SUM(`tbl_machine_allocation_details`.`completedqty`) AS `finishedqty`, SUM(`tbl_machine_allocation_details`.`wastageqty`) AS `wastageqty`');
        $this->db->from('tbl_delivery_plan_details');
        $this->db->join('tbl_machine_allocation', 'tbl_machine_allocation.tbl_delivery_plan_details_idtbl_delivery_plan_details = tbl_delivery_plan_details.idtbl_delivery_plan_details');
        $this->db->join('tbl_machine_allocation_details', 'tbl_machine_allocation_details.tbl_machine_allocation_idtbl_machine_allocation = tbl_machine_allocation.idtbl_machine_allocation');
        $this->db->join('tbl_cost_items', 'tbl_cost_items.tbl_customerinquiry_detail_idtbl_customerinquiry_detail = tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->where('tbl_machine_allocation.tbl_delivery_plan_details_idtbl_delivery_plan_details', $deliveryId);
        $this->db->where('tbl_cost_items.status', '1');
        $this->db->where('tbl_machine_allocation.used_status', '0');
        $this->db->group_by('tbl_cost_items.idtbl_cost_items, tbl_machine_allocation.idtbl_machine_allocation');
        $respond=$this->db->get();

        $createQty = 9999999999999;
        foreach($respond->result() as $rowlist){
            $obj=new stdClass();
            $deliveryqty = $rowlist->deliveryqty;
            $minval1 = ($rowlist->finishedqty) / ($rowlist->qty/$rowlist->inquiryqty);
            if($createQty > $minval1){
                $createQty = $minval1;
            }
        }
        
        $obj->possibleqty=floor($createQty);
        $obj->deliveryqty=$deliveryqty;
        echo json_encode($obj);
    }

    public function FinishDelivery(){
        $deliverydetailsid=$this->input->post('deliverydetailsid');
        $finishqty=$this->input->post('finishqty');

        $data = array(
            'completestatus'=> 1
        );

        $this->db->where('idtbl_delivery_plan_details', $deliverydetailsid);
        $this->db->update('tbl_delivery_plan_details', $data);

        $this->db->trans_complete();

        $this->db->select('*');
        $this->db->from('tbl_delivery_plan_details');
        $this->db->join('tbl_machine_allocation', 'tbl_machine_allocation.tbl_delivery_plan_details_idtbl_delivery_plan_details = tbl_delivery_plan_details.idtbl_delivery_plan_details');
        $this->db->where('idtbl_delivery_plan_details', $deliverydetailsid);
        $respond=$this->db->get();

        foreach($respond->result() as $rowlist){
            $allocationId = $rowlist->idtbl_machine_allocation;

            $allocationdata = array(
                'used_status'=> 1,
            );
    
            $this->db->where('idtbl_machine_allocation', $allocationId);
            $this->db->update('tbl_machine_allocation', $allocationdata);
        }
        
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
            redirect('PlanDetails');                
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
            redirect('PlanDetails');
        }

    }
}