<?php
class Jobsinfo extends CI_Model{
	public function GetBoardList(){
        $this->db->select('idtbl_board, name');
        $this->db->from('tbl_board');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetColorList(){
        $this->db->select('idtbl_color, color, unitprice');
        $this->db->from('tbl_color');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetVarnishList(){
        $this->db->select('idtbl_varnish, varnish, perinch_cost');
        $this->db->from('tbl_varnish');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetLaminationList(){
        $this->db->select('idtbl_lamination, lamination, squareinchcost');
        $this->db->from('tbl_lamination');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetRimmingList(){
        $this->db->select('idtbl_rimming, rimming, percost');
        $this->db->from('tbl_rimming');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetPlatesList(){
        $this->db->select('idtbl_plates, plate, size');
        $this->db->from('tbl_plates');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function GetPrimaryJob($recordId){
        $this->db->select('`tbl_customerinquiry_detail.idtbl_customerinquiry_detail`, `tbl_customerinquiry_detail.job`, `tbl_cost_items.costitemname`, `tbl_cost_items.qty`');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->join('tbl_cost_items', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_cost_items.tbl_customerinquiry_detail_idtbl_customerinquiry_detail');
        $this->db->where('tbl_cost_items.idtbl_cost_items', $recordId);
        $this->db->where('tbl_cost_items.status', 1);

        $respond=$this->db->get()->result();
        return json_encode($respond);
    }

	public function GetMaterialList(){
        $this->db->select('idtbl_print_material_info, materialname');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

	public function GetFoilingList(){
        $this->db->select('idtbl_foiling, foiling, perinch_cost');
        $this->db->from('tbl_foiling');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
	
    public function JobInsertUpdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $job_id=$_POST['job_id'];
		$qty=$_POST['qty'];
		$board_type=$_POST['board_type'];
		$material_type=$_POST['material_type'];
		$cut_size=$_POST['cut_size'];
		$number_ofups=$_POST['number_ofups'];
		$wastage=$_POST['wastage'];
		$number_ofsheets=$_POST['number_ofsheets'];
		$number_ofpackets=$_POST['number_ofpackets'];
		$machine=$_POST['machine'];
		$per_hour_cost=$_POST['per_hour_cost'];
		$speed=$_POST['speed'];
		$total_hour=$_POST['total_hour'];
		$cost=$_POST['cost'];
		$board_cost=$_POST['board_cost'];
		$wastage_cost=$_POST['wastage_cost'];
		$print_type=$_POST['print_type'];
        
		$noofcolors=$_POST['noofcolors'];

		$frontvarnish=$_POST['frontvarnish'];
		$frontpersquarecost=$_POST['frontpersquarecost'];
		$frontvarnishinches=$_POST['frontvarnishinches'];
		$frontvarnishcost=$_POST['frontvarnishcost'];

		$backvarnish=$_POST['backvarnish'];
		$backpersquarecost=$_POST['backpersquarecost'];
		$backvarnishinches=$_POST['backvarnishinches'];
		$backvarnishcost=$_POST['backvarnishcost'];

		$laminationtype=$_POST['laminationtype'];
		$laminationpersquarecost=$_POST['laminationpersquarecost'];
		$laminateinches=$_POST['laminateinches'];
		$laminationcost=$_POST['laminationcost'];

		$foiling=$_POST['foiling'];
		$foilingpersquarecost=$_POST['foilingpersquarecost'];
		$foilinginches=$_POST['foilinginches'];
		$foilingcost=$_POST['foilingcost'];

		$cuttingembossing=$_POST['cuttingembossing'];
		$pasting=$_POST['pasting'];
		$pastingcost=$_POST['pastingcost'];
		$rimmingtype=$_POST['rimmingtype'];
		$rimminginches=$_POST['rimminginches'];
		$filmcharges=$_POST['filmcharges'];

		$platetype=$_POST['platetype'];
		$noofplates=$_POST['noofplates'];
		$embosingqty=$_POST['embosingqty'];
		$foilingblockprice=$_POST['foilingblockprice'];
		$cutter=$_POST['cutter'];
		$windowpatch=$_POST['windowpatch'];
		$windowpasting=$_POST['windowpasting'];
		$boardlamination=$_POST['boardlamination'];
		$transport=$_POST['transport'];
		$totalsummary=$_POST['totalsummary'];

        $recordOption=$_POST['recordOption'];
        if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
				'qty'=> $qty, 
				'print_type'=> $print_type, 
				'no_of_ups'=> $number_ofups, 
				'wastage_percentage'=> $wastage, 
				'no_of_sheets'=> $number_ofsheets, 
				'no_of_packets'=> $number_ofpackets, 
				'per_hour_cost'=> $per_hour_cost,
				'speed'=> $speed,  
				'total_hours'=> $total_hour, 
				'cost'=> $cost, 
				'board_cost'=> $board_cost, 
				'wastage_cost'=> $wastage_cost, 
				'noofcolors'=> $noofcolors, 
				'frontvarnish'=> $frontvarnish, 
				'frontpersquarecost'=> $frontpersquarecost, 
				'frontvarnishinches'=> $frontvarnishinches, 
				'frontvarnishcost'=> $frontvarnishcost, 
				'backvarnish'=> $backvarnish, 
				'backpersquarecost'=> $backpersquarecost, 
				'backvarnishinches'=> $backvarnishinches, 
				'backvarnishcost'=> $backvarnishcost, 
				'tbl_lamination_idtbl_lamination'=> $laminationtype, 
				'laminationpersquarecost'=> $laminationpersquarecost, 
				'laminateinches'=> $laminateinches, 
				'laminationcost'=> $laminationcost, 
				'tbl_foiling_idtbl_foiling'=> $foiling, 
				'foilingpersquarecost'=> $foilingpersquarecost, 
				'foilinginches'=> $foilinginches, 
				'foilingcost'=> $foilingcost, 
				'cuttingembossing'=> $cuttingembossing, 
				'pasting'=> $pasting, 
				'pastingcost'=> $pastingcost, 
				'tbl_rimming_idtbl_rimming'=> $rimmingtype, 
				'rimminginches'=> $rimminginches, 
				'filmcharges'=> $filmcharges, 
				'tbl_plate_idtbl_plate'=> $platetype, 
				'noofplates'=> $noofplates, 
				'embosingqty'=> $embosingqty, 
				'foilingblockprice'=> $foilingblockprice, 
				'cutter'=> $cutter, 
				'windowpatch'=> $windowpatch, 
				'windowpasting'=> $windowpasting, 
				'boardlamination'=> $boardlamination, 
				'transport'=> $transport, 
				'total_sum'=> $totalsummary, 
				'tbl_boards_idtbl_boards'=> $board_type, 
				'tbl_print_material_info_tbl_print_material_info'=> $material_type, 
				'tbl_cutsize_idtbl_cutsize'=> $cut_size, 
				'tbl_machine_idtbl_machine'=> $machine, 
				'tbl_cost_items_idtbl_cost_items'=> $job_id, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_jobs', $data);

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

				redirect('Jobs/FetchPassedValue/'. $job_id);

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
            redirect('Jobs');
        }
        else{
            $data = array(
				'qty'=> $qty, 
				'print_type'=> $print_type, 
				'no_of_ups'=> $no_of_ups, 
				'wastage_percentage'=> $wastage_percentage, 
				'no_of_sheets'=> $no_of_sheets, 
				'no_of_packets'=> $no_of_packets, 
				'per_hour_cost'=> $per_hour_cost,
				'speed'=> $speed,  
				'total_hours'=> $total_hours, 
				'cost'=> $cost, 
				'board_cost'=> $board_cost, 
				'wastage_cost'=> $wastage_cost, 
				'tbl_boards_idtbl_boards'=> $board_type, 
				'tbl_cutsize_idtbl_cutsize'=> $cut_size, 
				'tbl_machine_idtbl_machine'=> $machine, 
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_jobs', $recordID);
            $this->db->update('tbl_jobs', $data);

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
                redirect('Jobs');                
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
                redirect('Jobs');
            }
        }
    }
}


