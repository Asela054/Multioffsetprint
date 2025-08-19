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
        $sql = "SELECT `c`.`idtbl_cost_items`, `c`.`costitemname`, `c`.`comment`, `c`.`qty`, `dp`.`idtbl_delivery_plan` FROM `tbl_cost_items` AS `c` JOIN `tbl_customerinquiry_detail` AS `d` ON (`c`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = `d`.`idtbl_customerinquiry_detail`) JOIN `tbl_delivery_plan` AS `dp` ON (`dp`.`tbl_cost_items_idtbl_cost_items` = `c`.`idtbl_cost_items`) JOIN `tbl_delivery_plan_details` AS `dd` ON (`dp`.`idtbl_delivery_plan` = `dd`.`tbl_delivery_plan_idtbl_delivery_plan`) WHERE `c`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = '$recordID' GROUP BY `dp`.`idtbl_delivery_plan`";
        $respond=$this->db->query($sql);
              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_cost_items.'">
                <td>'.$rowlist->idtbl_cost_items.'</td>
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->comment.'</td>
                <td>'.$rowlist->qty.'</td>
                <td class = "text-center">
                <button type="button" id="'.$rowlist->idtbl_cost_items. ','.$rowlist->idtbl_delivery_plan.'" class="btn btn-outline-primary btn-sm btnViewDelivery mr-1"><i class="fas fa-calendar-check"></i>
                </button>
                </td>
       
                </tr>';
        }

        echo $html;
    }

    public function GetDeliveryPlanDetails(){
        $costItemId=$this->input->post('costItemId');
        $deliveryId=$this->input->post('deliveryId');
        $today = date("Y-m-d");

        $html=''; 
        $sql = "SELECT `c`.`idtbl_cost_items`, `c`.`costitemname`, `c`.`comment`, `dd`.`deliveryDate`, `dd`.`special_id`, `dd`.`qty`, `dd`.`idtbl_delivery_plan_details`, `dd`.`completestatus` FROM `tbl_cost_items` AS `c` JOIN `tbl_customerinquiry_detail` AS `d` ON (`c`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = `d`.`idtbl_customerinquiry_detail`) JOIN `tbl_delivery_plan` AS `dp` ON (`dp`.`tbl_cost_items_idtbl_cost_items` = `c`.`idtbl_cost_items`) JOIN `tbl_delivery_plan_details` AS `dd` ON (`dp`.`idtbl_delivery_plan` = `dd`.`tbl_delivery_plan_idtbl_delivery_plan`) WHERE `dp`.`tbl_cost_items_idtbl_cost_items` = '$costItemId' AND `dd`.`status` = '1' ORDER BY `dd`.`deliveryDate`";
        $respond=$this->db->query($sql);
              
        foreach($respond->result() as $rowlist){
            if($rowlist->completestatus == 1){
                $html .= '<tr class = "table-success" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            }else if($rowlist->completestatus == 0 && $today > $rowlist->deliveryDate ){
                $html .= '<tr class = "table-danger" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            }else{
                $html .= '<tr class = "" id ="'.$rowlist->idtbl_delivery_plan_details.'">';
            }
            
            $html .= '<td>'.$rowlist->special_id.'</td>
                <td>'.$rowlist->deliveryDate.'</td>
                <td>'.$rowlist->qty.'</td>
                <td class = "text-center">
                <button type="button" id="'.$rowlist->idtbl_cost_items.'" class="btn btn-outline-primary btn-sm btnViewDelivery mr-1"><i class="fas fa-calendar-check"></i>
                </button>
                </td>
       
                </tr>';
        }

        echo $html;
    }
}