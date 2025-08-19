<?php
class OrderReconsilationinfo extends CI_Model{
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
        $sql = "SELECT `c`.`idtbl_cost_items`, `c`.`costitemname`, `c`.`comment`, `c`.`qty`, SUM(`md`.`completedqty`) AS 'completeqty', SUM(`md`.`wastageqty`) AS 'wasteqty' FROM `tbl_cost_items` AS `c` JOIN `tbl_customerinquiry_detail` AS `d` ON (`c`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = `d`.`idtbl_customerinquiry_detail`) JOIN `tbl_machine_allocation` AS `m` ON (`m`.`tbl_cost_items_idtbl_cost_items` = `c`.`idtbl_cost_items`) JOIN `tbl_machine_allocation_details` AS `md` ON (`m`.`idtbl_machine_allocation` = `md`.`tbl_machine_allocation_idtbl_machine_allocation`) WHERE `c`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = '$recordID' AND `c`.`status` = '1' GROUP BY `c`.`idtbl_cost_items`";
        $respond=$this->db->query($sql, array(1, $recordID));
              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_cost_items.'">
                <td>'.$rowlist->idtbl_cost_items.'</td>
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->comment.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->completeqty.'</td>
                <td>'.$rowlist->wasteqty.'</td>
                </tr>';
        }

        echo $html;
    }
}