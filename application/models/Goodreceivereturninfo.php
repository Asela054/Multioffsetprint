<?php class Goodreceivereturninfo extends CI_Model {
public function Getcompany() {
	$this->db->select('`idtbl_company`, `company`');
	$this->db->from('tbl_company');
	$this->db->where('status', 1);

	return $respond=$this->db->get();
}
public function Getsupplier() {
	$comapnyID=$_SESSION['company_id'];
	$branchID=$_SESSION['branch_id'];

    $this->db->select('`idtbl_supplier`, `suppliername`');
    $this->db->from('tbl_supplier');
    $this->db->where('status', 1);
	$this->db->where('tbl_company_idtbl_company', $comapnyID);

    return $respond=$this->db->get();
}
public function Getgrnaccsupllier() {
	$recordID = $this->input->post('recordID');
	$comapnyID=$_SESSION['company_id'];
	$branchID=$_SESSION['branch_id'];

	$this->db->select('*');
	$this->db->from('tbl_print_grn');
	$this->db->where('status', 1);
	$this->db->where('approvestatus', 1);
	$this->db->where('tbl_supplier_idtbl_supplier', $recordID);
	$this->db->where('tbl_company_idtbl_company', $comapnyID);
	$this->db->where('company_branch_id', $branchID);
	$this->db->where_in('tbl_order_type_idtbl_order_type', array(1, 3, 4));

	$respond = $this->db->get();

	if ($respond->num_rows() > 0) {
		echo json_encode($respond->result());
	}
}
public function Getmeasuretype() {
    $this->db->select('`idtbl_mesurements`, `measure_type`');
    $this->db->from('tbl_measurements');
    $this->db->where('status', 1);

    return $respond=$this->db->get();
}
public function Getordertype() {
    $this->db->select('`idtbl_order_type`, `type`');
    $this->db->from('tbl_order_type');
    $this->db->where('status', 1);
    $this->db->where_in('idtbl_order_type', array(1, 3, 4));

    return $respond=$this->db->get();
}

public function Getordertypesetgrn(){
	$recordID = $this->input->post('recordID');

	$this->db->select('`grntype`,`batchno`');
	$this->db->from('tbl_print_grn');
	$this->db->where('status', 1);
	$this->db->where('idtbl_print_grn', $recordID);

	$respond=$this->db->get();

	$obj=new stdClass();
	$obj->grnType = $respond->row(0)->grntype;
	$obj->batchNo = $respond->row(0)->batchno;

	echo json_encode($obj);
}
public function Getproducts(){
	$grnType = $this->input->post('grnType');
	$grnNo = $this->input->post('grnNo');

	if($grnType == 1){
		$this->db->select('ua.idtbl_spareparts AS id,ua.spare_part_name AS name');
		$this->db->from('tbl_print_grndetail AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_sparepart_id', 'left');
		$this->db->where('u.tbl_print_grn_idtbl_print_grn', $grnNo);
		$this->db->where('u.status', 1);

		$respond = $this->db->get()->result();
	}
	else if($grnType == 4){
		$this->db->select('ua.idtbl_machine AS id,ua.machine AS name');
		$this->db->from('tbl_print_grndetail AS u');
		$this->db->join('tbl_machine AS ua', 'ua.idtbl_machine = u.tbl_machine_id', 'left');
		$this->db->where('u.tbl_print_grn_idtbl_print_grn', $grnNo);
		$this->db->where('u.status', 1);

		$respond = $this->db->get()->result();
	}
	else if($grnType == 3){
		$this->db->select('ua.idtbl_print_material_info AS id,ua.materialname AS name');
		$this->db->from('tbl_print_grndetail AS u');
		$this->db->join('tbl_print_material_info AS ua', 'ua.idtbl_print_material_info = u.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('u.tbl_print_grn_idtbl_print_grn', $grnNo);
		$this->db->where('u.status', 1);

		$respond = $this->db->get()->result();
	}

	echo json_encode($respond);
}

public function Getproductdetails(){
	$productID = $this->input->post('productID');
	$grnType = $this->input->post('grnType');
	$batchNo = $this->input->post('batchNo');
	$grnNo = $this->input->post('grnNo');

	if($grnType == 1){
		$this->db->select('qty');
		$this->db->from('tbl_print_grndetail');
		$this->db->where('tbl_sparepart_id', $productID);
		$this->db->where('tbl_print_grn_idtbl_print_grn', $grnNo);
		$this->db->where('status', 1);

		$respondgrn = $this->db->get();

		$this->db->select('qty,measure_type_id,unitprice');
		$this->db->from('tbl_print_stock');
		$this->db->where('tbl_sparepart_id', $productID);
		$this->db->where('batchno', $batchNo);
        $this->db->where('status', 1);

		$respondstock = $this->db->get();

	}
	else if($grnType == 4){
		$this->db->select('qty');
        $this->db->from('tbl_print_grndetail');
        $this->db->where('tbl_machine_id', $productID);
        $this->db->where('tbl_print_grn_idtbl_print_grn', $grnNo);
        $this->db->where('status', 1);

		$respondgrn = $this->db->get();

		$this->db->select('qty,measure_type_id,unitprice');
		$this->db->from('tbl_print_stock');
		$this->db->where('tbl_machine_id', $productID);
		$this->db->where('batchno', $batchNo);
        $this->db->where('status', 1);

		$respondstock = $this->db->get();
	}
	else if($grnType == 3){
		$this->db->select('qty');
        $this->db->from('tbl_print_grndetail');
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $productID);
        $this->db->where('tbl_print_grn_idtbl_print_grn', $grnNo);
        $this->db->where('status', 1);

		$respondgrn = $this->db->get();

		$this->db->select('qty,measure_type_id,unitprice');
		$this->db->from('tbl_print_stock');
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $productID);
		$this->db->where('batchno', $batchNo);
        $this->db->where('status', 1);

		$respondstock = $this->db->get();
	}

	$obj = new stdClass();
	$obj->orderedQty = $respondgrn->row(0)->qty;
	$obj->stockQty = $respondstock->row(0)->qty;
	$obj->measureType = $respondstock->row(0)->measure_type_id;
	$obj->unitPrice = $respondstock->row(0)->unitprice;

	echo json_encode($obj);
}

public function Goodreceivereturninsertupdate() {
    $this->db->trans_begin();

    $userID=$_SESSION['userid'];

    $tableData=$this->input->post('tableData');

	$supplier = $this->input->post('supplier');
	$grnNo = $this->input->post('grnNo');
	$grnType = $this->input->post('grnType');
	$batchNo = $this->input->post('batchNo');
	$discount = $this->input->post('discount');
	$subTotal = $this->input->post('subTotal');
	$vat = $this->input->post('vat');
	$company_id=$this->input->post('company_id');
	$branch_id=$this->input->post('branch_id');
	$totalPayment = $this->input->post('totalPayment');
	$remark = $this->input->post('remark');

    $updatedatetime=date('Y-m-d H:i:s');

    $data=array(
        'batchno'=> $batchNo,
        'grn_no'=> $grnNo,
        'grn_type'=> $grnType,
        'discount'=> $discount,
        'subtotal'=> $subTotal,
        'vat'=> $vat,
		'tbl_company_idtbl_company'=> $company_id, 
		'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
        'totalpayment'=> $totalPayment, 
        'remark'=> $remark, 
        'approvestatus'=> '0', 
        'status'=> '1',
        'insertdatetime'=> $updatedatetime,
        'tbl_user_idtbl_user '=> $userID,
        'tbl_supplier_idtbl_supplier'=> $supplier
	);

    $this->db->insert('tbl_print_grn_return', $data);

    $grnReturnID=$this->db->insert_id();

	foreach($tableData as $rowtabledata) {
		$product = $rowtabledata['col_2'];
		$orderedQty = $rowtabledata['col_3'];
		$availableStockQty = $rowtabledata['col_4'];
		$returnQty = $rowtabledata['col_5'];
		$unitPrice = $rowtabledata['col_6'];
		$uom = $rowtabledata['col_8'];
		$unitDiscount = $rowtabledata['col_9'];
		$comment = $rowtabledata['col_10'];
		$total = $rowtabledata['col_12'];

        if($grnType == 1){
            $data = array(
				'ordered_qty' => $orderedQty,
				'avalible_stock_qty' => $availableStockQty,
				'return_qty' => $returnQty,
				'measure_type_id' => $uom,
				'unit_price' => $unitPrice,
				'unit_discount' => $unitDiscount,
				'comment' => $comment,
				'total' => $total,
				'status' => '1',
				'insertdatetime' => $updatedatetime,
				'tbl_sparepart_idtbl_spareparts' => $product,
				'tbl_user_idtbl_user' => '',
				'tbl_print_grn_return_idtbl_print_grn_return' => $grnReturnID
			);
        }
		else if($grnType == 4){
			$data = array(
				'ordered_qty' => $orderedQty,
				'avalible_stock_qty' => $availableStockQty,
				'return_qty' => $returnQty,
				'measure_type_id' => $uom,
				'unit_price' => $unitPrice,
				'unit_discount' => $unitDiscount,
				'comment' => $comment,
				'total' => $total,
				'status' => '1',
				'insertdatetime' => $updatedatetime,
				'tbl_machine_idtbl_machine' => $product,
				'tbl_user_idtbl_user' =>  '',
				'tbl_print_grn_return_idtbl_print_grn_return' => $grnReturnID
			);
		}
		else if ($grnType == 3){
			$data = array(
				'ordered_qty' => $orderedQty,
				'avalible_stock_qty' => $availableStockQty,
				'return_qty' => $returnQty,
				'measure_type_id' => $uom,
				'unit_price' => $unitPrice,
				'unit_discount' => $unitDiscount,
				'comment' => $comment,
				'total' => $total,
				'status' => '1',
				'insertdatetime' => $updatedatetime,
				'tbl_print_material_info_idtbl_print_material_info' => $product,
				'tbl_user_idtbl_user' =>  '',
				'tbl_print_grn_return_idtbl_print_grn_return' => $grnReturnID
			);
		}

		$this->db->insert('tbl_print_grn_return_detail', $data);
	}

    if ($this->db->trans_status()===TRUE) {
        $this->db->trans_commit();

        $actionObj=new stdClass();
        $actionObj->icon='fas fa-save';
        $actionObj->title='';
        $actionObj->message='Record Added Successfully';
        $actionObj->url='';
        $actionObj->target='_blank';
        $actionObj->type='success';

        $actionJSON=json_encode($actionObj);

        $obj=new stdClass();
        $obj->status=1;
        $obj->action=$actionJSON;

        echo json_encode($obj);
    }

    else {
        $this->db->trans_rollback();

        $actionObj=new stdClass();
        $actionObj->icon='fas fa-exclamation-triangle';
        $actionObj->title='';
        $actionObj->message='Record Error';
        $actionObj->url='';
        $actionObj->target='_blank';
        $actionObj->type='danger';

        $actionJSON=json_encode($actionObj);

        $obj=new stdClass();
        $obj->status=0;
        $obj->action=$actionJSON;

        echo json_encode($obj);
    }
}

public function Goodreceivereturnview() {
    $recordID=$this->input->post('recordID');

	$this->db->select('u.*,ua.suppliername AS suppliername');
	$this->db->from('tbl_print_grn_return AS u');
	$this->db->join('tbl_supplier AS ua', 'ua.idtbl_supplier = u.tbl_supplier_idtbl_supplier', 'left');
	$this->db->where('u.idtbl_print_grn_return', $recordID);
	$this->db->where('u.status', 1);

	$respond = $this->db->get();

	$grnType = $respond->row(0)->grn_type;

	$this->db->select('u.*,ua.materialname,ua.materialinfocode,ub.machine,ub.machinecode,uc.spare_part_name,ud.measure_type');
	$this->db->from('tbl_print_grn_return_detail AS u');
	$this->db->join('tbl_print_material_info AS ua', 'ua.idtbl_print_material_info = u.tbl_print_material_info_idtbl_print_material_info', 'left');
	$this->db->join('tbl_machine AS ub', 'ub.idtbl_machine = u.tbl_machine_idtbl_machine', 'left');
	$this->db->join('tbl_spareparts AS uc', 'uc.idtbl_spareparts = u.tbl_sparepart_idtbl_spareparts', "left");
	$this->db->join('tbl_measurements AS ud', 'ud.idtbl_mesurements = u.measure_type_id', "left");
	$this->db->where('u.tbl_print_grn_return_idtbl_print_grn_return', $recordID);
	$this->db->where('u.status', 1);

	$responddetails = $this->db->get();

    $html='';
    $html.='
			<div class="row">
				<div class="col-12 text-right font-family: cursive;font-size:15px; font-weight: bold;">'.$respond->row(0)->suppliername.'</div>
				<div class="col-12"><hr>
					<h6>Batch No: '.$respond->row(0)->batchno.'</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-12"><hr>
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr>
							<th>Material Info</th>
							<th class="text-right">Unit Price</th>
							<th class="text-right">Return Qty</th>
							<th class="text-center">Uom</th>
							<th class="text-right">Discount</th>
							<th>Comment</th>
							<th class="text-right">Total</th>
						</tr>
					</thead>
					<tbody>';
		foreach($responddetails->result() as $rowdetails) {
			if($grnType==1) {
				$html.='<tr>
							<td>'.$rowdetails->spare_part_name.'</td>
							<td class="text-right">'.number_format(($rowdetails->unit_price), 2).'</td>
							<td class="text-right">'.$rowdetails->return_qty.'</td>
							<td class="text-center">'.$rowdetails->measure_type.'</td>
							<td class="text-right">'.number_format(($rowdetails->unit_discount), 2).'</td>
							<td>'.$rowdetails->comment.'</td>
							<td class="text-right">'.number_format(($rowdetails->total), 2).'</td>
						</tr>';
			}
			else if($grnType==4){
				$html.='<tr>
							<td>'.$rowdetails->machine.'/'.$rowdetails->machinecode.'</td>
							<td class="text-right">'.number_format(($rowdetails->unit_price), 2).'</td>
							<td class="text-right">'.$rowdetails->return_qty.'</td>
							<td class="text-center">'.$rowdetails->measure_type.'</td>
							<td class="text-right">'.number_format(($rowdetails->unit_discount), 2).'</td>
							<td>'.$rowdetails->comment.'</td>
							<td class="text-right">'.number_format(($rowdetails->total), 2).'</td>
						</tr>';
			}
			else if($grnType==3){
				$html.='<tr>
							<td>'.$rowdetails->materialname.'/'.$rowdetails->materialinfocode.'</td>
							<td class="text-right">'.number_format(($rowdetails->unit_price), 2).'</td>
							<td class="text-right">'.$rowdetails->return_qty.'</td>
							<td class="text-center">'.$rowdetails->measure_type.'</td>
							<td class="text-right">'.number_format(($rowdetails->unit_discount), 2).'</td>
							<td>'.$rowdetails->comment.'</td>
							<td class="text-right">'.number_format(($rowdetails->total), 2).'</td>
						</tr>';
			}
		}
			$html .= '</tbody>
				</table>				
				<table border="0" width="100%" style="border-collapse: collapse;">
					<tbody>
						<tr>
							<td width="80%" style="text-align: right; font-weight: bold; padding: 5px;">Discount</td>
							<td width="20%" style="text-align: right; font-weight: bold; padding: 5px;">Rs. ' . number_format(($respond->row(0)->discount), 2) . '</td>
						</tr>
						<tr>
							<td width="80%" style="text-align: right; font-weight: bold; padding: 5px;">Sub Total</td>
							<td width="20%" style="text-align: right; font-weight: bold; padding: 5px;">Rs. ' . number_format(($respond->row(0)->subtotal), 2) . '</td>
						</tr>
						<tr>
							<td width="80%" style="text-align: right; font-weight: bold; padding: 5px;">Vat(%)</td>
							<td width="20%" style="text-align: right; font-weight: bold; padding: 5px;">' . $respond->row(0)->vat . '%</td>
						</tr>
						<tr>
							<td width="80%" style="text-align: right; font-weight: bold; padding: 5px;"><strong><span style="color: black; font-size: 18px;">Final Price</span></strong></td>
							<td width="20%" style="text-align: right; font-weight: bold; padding: 5px;"><span style="color: black; font-size: 18px;">Rs. ' . number_format(($respond->row(0)->totalpayment), 2) . '</span></td>
						</tr>
					</tbody>
				</table>
			</div>';
		echo $html;
}

public function Goodreceivereturnstatus($x, $y) {
    $this->db->trans_begin();

    $userID=$_SESSION['userid'];
    $recordID=$x;
    $type=$y;
    $updatedatetime=date('Y-m-d H:i:s');

    if($type==1){
		$data = array(
			'approvestatus' => '1',
			'updateuser'=> $userID, 
			'updatedatetime'=> $updatedatetime
		);

		$this->db->where('idtbl_print_grn_return', $recordID);
		$this->db->update('tbl_print_grn_return', $data);

		$this->db->select('batchno,grn_type,tbl_supplier_idtbl_supplier');
		$this->db->from('tbl_print_grn_return');
		$this->db->where('idtbl_print_grn_return', $recordID);
		$this->db->where('status', 1);

		$respond = $this->db->get();

		$batchno = $respond->row(0)->batchno;
		$grnType = $respond->row(0)->grn_type;
		$supplier = $respond->row(0)->tbl_supplier_idtbl_supplier;

		$this->db->select('return_qty,tbl_print_material_info_idtbl_print_material_info,tbl_machine_idtbl_machine,tbl_sparepart_idtbl_spareparts');
		$this->db->from('tbl_print_grn_return_detail');
		$this->db->where('tbl_print_grn_return_idtbl_print_grn_return', $recordID);
		$this->db->where('status', 1);

		$responddetails = $this->db->get();

		foreach($responddetails->result() as $rowdetail) {
            $return_qty = $rowdetail->return_qty;
            $material_id = $rowdetail->tbl_print_material_info_idtbl_print_material_info;
            $machine_id = $rowdetail->tbl_machine_idtbl_machine;
            $sparepart_id = $rowdetail->tbl_sparepart_idtbl_sp;

			if($grnType==1){
				$this->db->set('qty', 'qty-'.$return_qty, FALSE);
                $this->db->where('tbl_sparepart_id', $sparepart_id);
                $this->db->where('batchno', $batchno);
                $this->db->where('supplier_id', $supplier);
                $this->db->update('tbl_print_stock');
			}
			else if($grnType==4){
				$this->db->set('qty', 'qty-'.$return_qty, FALSE);
                $this->db->where('tbl_machine_id', $machine_id);
                $this->db->where('batchno', $batchno);
                $this->db->where('supplier_id', $supplier);
                $this->db->update('tbl_print_stock');
			}
			else if($grnType==3){
				$this->db->set('qty', 'qty-'.$return_qty, FALSE);
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $material_id);
                $this->db->where('batchno', $batchno);
                $this->db->where('supplier_id', $supplier);
                $this->db->update('tbl_print_stock');
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			
			$actionObj=new stdClass();
			$actionObj->icon='fas fa-check';
			$actionObj->title='';
			$actionObj->message='Approved Successfully';
			$actionObj->url='';
			$actionObj->target='_blank';
			$actionObj->type='success';

			$actionJSON=json_encode($actionObj);
			
			$this->session->set_flashdata('msg', $actionJSON);
			redirect('Goodreceivereturn');                
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
			redirect('Goodreceivereturn');
		}
	}
	else if($type==3){
		$data = array(
			'status' => '3',
			'updateuser'=> $userID, 
			'updatedatetime'=> $updatedatetime
		);

		$this->db->where('idtbl_print_grn_return', $recordID);
		$this->db->update('tbl_print_grn_return', $data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			
			$actionObj=new stdClass();
			$actionObj->icon='fas fa-trash-alt';
			$actionObj->title='';
			$actionObj->message='Reject Successfully';
			$actionObj->url='';
			$actionObj->target='_blank';
			$actionObj->type='danger';

			$actionJSON=json_encode($actionObj);
			
			$this->session->set_flashdata('msg', $actionJSON);
			redirect('Goodreceivereturn');                
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
			redirect('Goodreceivereturn');
		}
	}
}
}
