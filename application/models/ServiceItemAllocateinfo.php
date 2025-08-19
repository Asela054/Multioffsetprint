<?php

class ServiceItemAllocateinfo extends CI_Model {

	public function Getserviceno(){
		$this->db->select('idtbl_machine_service');
        $this->db->from('tbl_machine_service');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
	}

	public function Getmachineservicedetails(){
		$recordID=$this->input->post('recordID');
		
		$this->db->select('ua.type AS machinetype,ub.machine AS machinename');
        $this->db->from('tbl_machine_service AS u');
		$this->db->join('tbl_machine_type AS ua', 'ua.idtbl_machine_type = u.tbl_machine_type_idtbl_machine_type', 'left');
		$this->db->join('tbl_machine AS ub', 'ub.idtbl_machine = u.tbl_machine_idtbl_machine', 'left');
        $this->db->where('u.idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);

		$respond=$this->db->get();

		$this->db->select('u.qty,ua.idtbl_spareparts,ua.spare_part_name');
        $this->db->from('tbl_machine_service_details AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_spareparts_idtbl_spareparts', 'left');
        $this->db->where('u.tbl_machine_service_idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);

		$responddetails=$this->db->get();

		$html='';
		foreach($responddetails->result() as $row){
			$this->db->select('SUM(allocated_qty) AS allocated_qty');
			$this->db->from('tbl_machine_service_allocated_items');
			$this->db->where('tbl_machine_service_idtbl_machine_service', $recordID);
			$this->db->where('tbl_spareparts_idtbl_spareparts', $row->idtbl_spareparts);

			$query = $this->db->get();

			if ($query->row(0)->allocated_qty > 0) {
				$allocatedQuantity = $query->row(0)->allocated_qty;
			} else {
				$allocatedQuantity = 0;
			}
			
			$html.='<tr class="pointer">
						<td class="d-none">'.$row->idtbl_spareparts.'</td>
						<td>'.$row->spare_part_name.'</td>
                        <td class="text-right"><input type="number" class="form-control form-control-sm" id ="estimatedQuantity" name="estimatedQuantity[]" value="'.$row->qty.'" readonly></td>
                        <td class="text-right"><input type="number" class="form-control form-control-sm" id ="allocatedQuantity" name="allocatedQuantity[]" value="'.$allocatedQuantity.'" readonly></td>
                        <td class="text-right"><input type="number" class="form-control form-control-sm" id ="newAllocatedQuantity" name="newAllocatedQuantity[]" value="0" required></td>
						<td class="text-right"><button class="btn btn-danger btn-sm btnRowRemove mr-1"><i class="fa fa-trash text-white"></i></button></td>
					</tr>';
		}

		$html2='<div class="col">
					<label class="small font-weight-bold text-black">Machine Type : </label>
                </div>
                <div class="col">
					<label class="small text-black">'.$respond->row(0)->machinetype.'</label>
                </div>';

		$html3='<div class="col">
			<label class="small font-weight-bold text-black">Machine Name : </label>
		</div>
		<div class="col">
			<label class="small text-black">'.$respond->row(0)->machinename.'</label>
		</div>';

        $obj=new stdClass();
		$obj->viewmachinetype=$html2;
        $obj->viewmachinename=$html3;
		$obj->view = $html;

		echo json_encode($obj);
	}

    public function ServiceItemAllocateinsert() {
        
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$datetime=date('Y-m-d H:i:s');

        $serviceID = $this->input->post('serviceID');
        $allocatedDetails = $this->input->post('allocatedDetails');

		foreach($allocatedDetails as $row){
			$sparepartID = $row['sparepartID'];
			$newAllocatedQty = $row['newAllocatedQty'];

			$data = array( 
				'allocated_qty'=> $newAllocatedQty,
				'status'=> '1',
				'insertdatetime'=> $datetime,
				'tbl_spareparts_idtbl_spareparts' => $sparepartID,
				'tbl_machine_service_idtbl_machine_service' => $serviceID,
				'tbl_user_idtbl_user' => $userID
			);
		
			$this->db->insert('tbl_machine_service_allocated_items', $data);
		}

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

			$actionJSON = json_encode($actionObj);

			$obj = new stdClass();
			$obj->status = 1;
			$obj->action = $actionJSON;

			echo json_encode($obj);
		} 
		else {
			$this->db->trans_rollback();

			$actionObj=new stdClass();
			$actionObj->icon='fas fa-warning';
			$actionObj->title='';
			$actionObj->message='Record Error';
			$actionObj->url='';
			$actionObj->target='_blank';
			$actionObj->type='danger';

			$actionJSON = json_encode($actionObj);

			$obj = new stdClass();
			$obj->status = 0;
			$obj->action = $actionJSON;

			echo json_encode($obj);
		}
	}

	public function AllocatedServiceItemView(){
		$recordID=$this->input->post('recordID');

		$html='';
		$html2='';

		$this->db->select('SUM(u.allocated_qty) AS total_allocated_qty,ua.spare_part_name,ua.unit_price,u.tbl_spareparts_idtbl_spareparts');
		$this->db->from('tbl_machine_service_allocated_items AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_spareparts_idtbl_spareparts', 'left');
		$this->db->where('u.tbl_machine_service_idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);
		$this->db->group_by('u.tbl_spareparts_idtbl_spareparts');

		$respond = $this->db->get();

		foreach($respond->result() as $row){
			$this->db->select('qty');
			$this->db->from('tbl_machine_service_details');
			$this->db->where('tbl_machine_service_idtbl_machine_service', $recordID);
			$this->db->where('tbl_spareparts_idtbl_spareparts', $row->tbl_spareparts_idtbl_spareparts);

			$query = $this->db->get();

			$html.='<tr class="pointer">
				<td>'.$row->spare_part_name.'</td>
				<td class="text-right">'.$query->row(0)->qty.'</td>
				<td class="text-right">'.$row->total_allocated_qty.'</td>
                <td class="text-right">'.number_format($row->unit_price, 2).'</td>
			</tr>';
		}

		$this->db->select('u.allocated_qty,u.insertdatetime,u.tbl_spareparts_idtbl_spareparts,ua.spare_part_name,ua.unit_price');
		$this->db->from('tbl_machine_service_allocated_items AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_spareparts_idtbl_spareparts', 'left');
		$this->db->where('u.tbl_machine_service_idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);

		$respondAllocateDetails = $this->db->get();

		foreach($respondAllocateDetails->result() as $row){
			$html2.='<tr class="pointer">
				<td>'.$row->spare_part_name.'</td>
				<td class="text-right">'.$row->allocated_qty.'</td>
                <td class="text-right">'.number_format($row->unit_price, 2).'</td>
				<td class="text-right">'.date('Y-m-d', strtotime($row->insertdatetime)).'</td>
			</tr>';
		}

        $obj=new stdClass();
		$obj->allocatedService = $html;
		$obj->allocatedServiceDetails=$html2;

		echo json_encode($obj);
	}

    public function ServiceItemAllocateedit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('u.allocated_qty,ua.spare_part_name,ua.unit_price,u.tbl_spareparts_idtbl_spareparts');
		$this->db->from('tbl_machine_service_allocated_items AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_spareparts_idtbl_spareparts', 'left');
		$this->db->where('u.tbl_machine_service_idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);

		$respond = $this->db->get();

		$html='';
		foreach($respond->result() as $row){
			$this->db->select('qty');
			$this->db->from('tbl_machine_service_details');
			$this->db->where('tbl_machine_service_idtbl_machine_service', $recordID);
			$this->db->where('tbl_spareparts_idtbl_spareparts', $row->tbl_spareparts_idtbl_spareparts);

			$query = $this->db->get();

			$html.='<tr class="pointer">
				<td class="d-none">'.$row->tbl_spareparts_idtbl_spareparts.'</td>
				<td>'.$row->spare_part_name.'</td>
                <td class="text-right"><input type="number" class="form-control form-control-sm" id ="estimatedQuantity" name="estimatedQuantity[]" value="'.$query->row(0)->qty.'" readonly></td>
                <td class="text-right"><input type="number" class="form-control form-control-sm" id ="allocatedQuantity" name="allocatedQuantity[]" value="'.$row->allocated_qty.'" required></td>
                <td class="text-right">'.number_format($row->unit_price, 2).'</td>
				<td class="text-right"><button class="btn btn-danger btn-sm btnRowRemove mr-1"><i class="fa fa-trash text-white"></i></button></td>
			</tr>';
		}
		
        $obj=new stdClass();
		$obj->allocatedServiceEdit = $html;
		$obj->serviceID = $recordID;
		echo json_encode($obj);
	}
	public function ServiceItemAllocateupdate() {
        
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$datetime=date('Y-m-d H:i:s');

        $serviceID = $this->input->post('serviceID');
        $allocatedDetails = $this->input->post('allocatedDetails');

		$this->db->where('tbl_machine_service_idtbl_machine_service', $serviceID);
		$this->db->delete('tbl_machine_service_allocated_items');

		foreach($allocatedDetails as $row){
			$sparepartID = $row['sparepartID'];
			$allocatedQuantity = $row['allocatedQuantity'];

			$data = array( 
				'allocated_qty'=> $allocatedQuantity,
				'status'=> '1',
				'insertdatetime'=> $datetime,
				'tbl_spareparts_idtbl_spareparts' => $sparepartID,
				'tbl_machine_service_idtbl_machine_service' => $serviceID,
				'tbl_user_idtbl_user' => $userID
			);
		
			$this->db->insert('tbl_machine_service_allocated_items', $data);
		}

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

			$actionJSON = json_encode($actionObj);

			$obj = new stdClass();
			$obj->status = 1;
			$obj->action = $actionJSON;

			echo json_encode($obj);
		} 
		else {
			$this->db->trans_rollback();

			$actionObj=new stdClass();
			$actionObj->icon='fas fa-warning';
			$actionObj->title='';
			$actionObj->message='Record Error';
			$actionObj->url='';
			$actionObj->target='_blank';
			$actionObj->type='danger';

			$actionJSON = json_encode($actionObj);

			$obj = new stdClass();
			$obj->status = 0;
			$obj->action = $actionJSON;

			echo json_encode($obj);
		}
	}
}
