<?php
class MachineAllocationReportInfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function FetchAllocationData(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT `a`.`startdatetime`, `a`.`enddatetime`, `c`.`costitemname`, `c`.`qty` FROM `tbl_machine_allocation` AS `a`
		LEFT JOIN `tbl_cost_items` AS `c` ON `a`.`tbl_cost_items_idtbl_cost_items`=`c`.`idtbl_cost_items`
		WHERE `a`.`tbl_machine_idtbl_machine`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->costitemname.'">
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->startdatetime.'</td>
                <td>'.$rowlist->enddatetime.'</td>
             </tr>
            
            ';
        }

        echo ($html);
    }
    
    public function GetInquieryDetails(){
        $recordID=$this->input->post('recordId');

        $sql="SELECT * FROM `tbl_customerinquiry_detail` WHERE `tbl_customerinquiry_idtbl_customerinquiry` = '$recordID'";
        $respond=$this->db->query($sql);
        return $respond->result_array();
    }

    public function GetCostItemData(){
        $recordID=$this->input->post('recordId');

        $sql="SELECT * FROM `tbl_cost_items` WHERE `tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = '$recordID' AND `status` = '1'";
        $respond=$this->db->query($sql);
        return $respond->result_array();

    }

    public function GetAllocationData(){
        $recordID=$this->input->post('recordId');

        $html='';

        $sql = "SELECT * FROM `tbl_machine_allocation` AS `ma` LEFT JOIN `tbl_machine` AS `m` ON (`m`.`idtbl_machine` = `ma`.`tbl_machine_idtbl_machine`) LEFT JOIN `tbl_cost_items` AS `ci` ON (`ci`.`idtbl_cost_items` = `ma`.`tbl_cost_items_idtbl_cost_items`) LEFT JOIN `tbl_employee` AS `e` ON (`e`.`idtbl_employee` = `ma`.`tbl_employee_idtbl_employee`) LEFT JOIN `tbl_customerinquiry_detail` AS `d` ON (`d`.`idtbl_customerinquiry_detail` = `ci`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail`) LEFT JOIN `tbl_customerinquiry` AS `i` ON (`i`.`idtbl_customerinquiry` = `d`.`tbl_customerinquiry_idtbl_customerinquiry`) LEFT JOIN `tbl_customer` AS `c` ON (`c`.`idtbl_customer` = `i`.`tbl_customer_idtbl_customer`) WHERE `ma`.`tbl_machine_idtbl_machine` = '$recordID' ORDER BY `ma`.`startdatetime` ASC";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_customerinquiry.'">
                <td>'.$rowlist->idtbl_customerinquiry.'</td>
                <td>'.$rowlist->customer.'</td>
                <td>'.$rowlist->fullname.'</td>
                <td>'.$rowlist->po_number.'</td>
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->startdatetime.'</td>
                <td>'.$rowlist->enddatetime.'</td>
                <td>'.round((strtotime($rowlist->enddatetime) - strtotime($rowlist->startdatetime))/3600, 1).'</td>
                <td class = "text-right">
                ';
                if($rowlist->allocationstart == 0){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-warning btn-sm btnStartAllocation mr-1"><i class="fa fa-check"></i></button>'; 
                }else{
                    $html .= '<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-success btn-sm mr-1"><i class="fa fa-check"></i></button>';
                } 
                if($rowlist->breakdown_status == 0 && $rowlist->allocationstart == 1){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-primary btn-sm btnBreakDown mr-1"><i class="fas fa-tools"></i></button>'; 
                }else if ($rowlist->breakdown_status == 1 && $rowlist->allocationstart == 1){
                    $html .= '<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-danger btn-sm mr-1"><i class="fas fa-tools"></i></button>';
                } 
                if($rowlist->breakdown_status == 1 && $rowlist->breakdown_fixed_status == 1){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-warning btn-sm btnFixBreakDown mr-1"><i class="fa fa-wrench"></i></button>'; 
                }
                $html .= '
                <button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-danger btn-sm btnQaIssues mr-1"><i class="fas fa-exclamation-circle"></i>
                </button>';
                if($rowlist->completed_status == 0 && $rowlist->allocationstart == 1 && $rowlist->breakdown_status == 0){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-warning btn-sm btnComplete mr-1"><i class="fa fa-times"></i></button>'; 
                }else if ($rowlist->completed_status == 1 && $rowlist->allocationstart == 1 && $rowlist->breakdown_status == 0){
                    $html .= '<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-success btn-sm mr-1"><i class="fa fa-check"></i></button>';
                } 
                if($rowlist->allocationstart == 1 && $rowlist->breakdown_status == 0){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-info btn-sm btnDetails mr-1"><i class="fa fa-eye"></i>
                </button></td>';
                }
                $html .= '</tr>';
        }

        echo $html;
    }
}