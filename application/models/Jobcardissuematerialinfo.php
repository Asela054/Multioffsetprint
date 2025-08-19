<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Jobcardissuematerialinfo extends CI_Model {
    public function Getjobissuematerialinfo(){
        $recordID=$this->input->post('recordID');

        $this->db->select('jobcardno, job_description, date, company, branch, customer');
		$this->db->from('tbl_jobcard');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_jobcard.tbl_company_idtbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_jobcard.tbl_company_branch_idtbl_company_branch');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_jobcard.tbl_customer_idtbl_customer');
		$this->db->where('tbl_jobcard.status', 1);
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
		$respond=$this->db->get();

        $this->db->select('tbl_jobcard_material.cutsize, tbl_jobcard_material.sheetqty, tbl_jobcard_issue_meterial.batchno, tbl_jobcard_issue_meterial.issueqty, tbl_printing_format.format_name, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_printing_format', 'tbl_printing_format.idtbl_printing_format = tbl_jobcard_material.tbl_printing_format_idtbl_printing_format', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_material.idtbl_jobcard_material AND tbl_jobcard_issue_meterial.sectiontype = 1', 'left');
        $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
		$this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_material.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial IS NULL', null, false);

		$respondmaterial=$this->db->get();

        $this->db->select('tbl_jobcard_varnish.varnishQty, tbl_jobcard_issue_meterial.batchno, tbl_jobcard_issue_meterial.issueqty, tbl_varnish.varnish, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_varnish.idtbl_jobcard_varnish AND tbl_jobcard_issue_meterial.sectiontype = 2', 'left');
        $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
		$this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_varnish.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial IS NULL', null, false);

		$respondvarnish=$this->db->get();

        $this->db->select([
            'TRIM(BOTH ", " FROM CONCAT(
                IF(tbl_jobcard_color.cmyk = 1, "CMYK, ", ""),
                IF(tbl_jobcard_color.metlic = 1, "Metlic Color, ", ""),
                IF(tbl_jobcard_color.another = 1, "Any Other, ", "")
            )) AS color_types',
            'tbl_jobcard_color.remark',
            'tbl_jobcard_color.qty',
            'tbl_jobcard_issue_meterial.issueqty',
            'tbl_jobcard_issue_meterial.batchno',
            'tbl_print_material_info.materialname'
        ]);
		$this->db->from('tbl_jobcard_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_color.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_color.idtbl_jobcard_color AND tbl_jobcard_issue_meterial.sectiontype = 3', 'left');
        $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
		$this->db->where('tbl_jobcard_color.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_color.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial IS NULL', null, false);

		$respondcolor=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_lamination.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_lamination.filmsize', 'tbl_jobcard_lamination.micron', 'tbl_jobcard_lamination.lamination_qty', 'tbl_jobcard_issue_meterial.batchno', 'tbl_jobcard_issue_meterial.issueqty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_lamination.idtbl_jobcard_lamination AND tbl_jobcard_issue_meterial.sectiontype = 4', 'left');
        $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
		$this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_lamination.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial IS NULL', null, false);

		$respondlamination=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_rimming.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_rimming.length', 'tbl_jobcard_rimming.qty', 'tbl_jobcard_issue_meterial.batchno', 'tbl_jobcard_issue_meterial.issueqty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_rimming.idtbl_jobcard_rimming AND tbl_jobcard_issue_meterial.sectiontype = 5', 'left');
        $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
		$this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_rimming.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial IS NULL', null, false);

		$respondrimming=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_diecutting.peraforation = 1, "Yes", "No") AS peraforation', 'IF(tbl_jobcard_diecutting.halfCutting = 1, "Yes", "No") AS halfCutting', 'IF(tbl_jobcard_diecutting.fullCutting = 1, "Yes", "No") AS fullCutting', 'tbl_jobcard_diecutting.qty']);
		$this->db->from('tbl_jobcard_diecutting');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('tbl_jobcard_other.qty, tbl_jobcard_issue_meterial.batchno, tbl_jobcard_issue_meterial.issueqty, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_other');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_other.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_other.idtbl_jobcard_other AND tbl_jobcard_issue_meterial.sectiontype = 7', 'left');
        $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
		$this->db->where('tbl_jobcard_other.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_other.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial IS NULL', null, false);

		$respondother=$this->db->get();

        $html='';
        $html.='
        <div class="row">
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Date:</label> '.$respond->row(0)->date.'<br><label class="small font-weight-bold text-dark mb-1">PO No:</label> '.$respond->row(0)->jobcardno.'<br><label class="small font-weight-bold text-dark mb-1">Job Desc:</label> '.$respond->row(0)->job_description.'</div>
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Customer:</label> '.$respond->row(0)->customer.'<br><label class="small font-weight-bold text-dark mb-1">Company:</label> '.$respond->row(0)->company.'<br><label class="small font-weight-bold text-dark mb-1">Branch:</label> '.$respond->row(0)->branch.'</div>
        </div>
        <hr class="border-dark">';
        if(!empty($respondmaterial->result())){
        $html.='
        <h6 class="small title-style"><span>Material Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Format</th>
                    <th>Material</th>
                    <th>Cut Size</th>
                    <th>Sheet Size</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondmaterial->result() as $rowmaterialdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowmaterialdata->format_name.'</td>
                    <td>'.$rowmaterialdata->materialname.'</td>
                    <td>'.$rowmaterialdata->cutsize.'</td>
                    <td>'.$rowmaterialdata->sheetqty.'</td>
                    <td>'.$rowmaterialdata->batchno.'</td>
                    <td>'.$rowmaterialdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        } 
        if(!empty($respondvarnish->result())){
        $html.='
        <h6 class="small title-style"><span>Coating Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Varnish</th>
                    <th>Material</th>
                    <th>Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondvarnish->result() as $rowvarnishdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowvarnishdata->varnish.'</td>
                    <td>'.$rowvarnishdata->materialname.'</td>
                    <td>'.$rowvarnishdata->varnishQty.'</td>
                    <td>'.$rowvarnishdata->batchno.'</td>
                    <td>'.$rowvarnishdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        } 
        if(!empty($respondcolor->result())){
        $html.='
        <h6 class="small title-style"><span>Color Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Color Type</th>
                    <th>Meterial</th>
                    <th>Qty</th>
                    <th>Remark</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondcolor->result() as $rowrespondcolordata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondcolordata->color_types.'</td>
                    <td>'.$rowrespondcolordata->materialname.'</td>
                    <td>'.$rowrespondcolordata->qty.'</td>
                    <td>'.$rowrespondcolordata->remark.'</td>
                    <td>'.$rowrespondcolordata->batchno.'</td>
                    <td>'.$rowrespondcolordata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        } 
        if(!empty($respondlamination->result())){
        $html.='
        <h6 class="small title-style"><span>Lamination Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Lamination</th>
                    <th>Material</th>
                    <th>Film Size</th>
                    <th>Microne</th>
                    <th>Sides</th>
                    <th>Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondlamination->result() as $rowrespondlaminationdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondlaminationdata->lamination.'</td>
                    <td>'.$rowrespondlaminationdata->materialname.'</td>
                    <td>'.$rowrespondlaminationdata->filmsize.'</td>
                    <td>'.$rowrespondlaminationdata->micron.'</td>
                    <td>'.$rowrespondlaminationdata->sides.'</td>
                    <td>'.$rowrespondlaminationdata->lamination_qty.'</td>
                    <td>'.$rowrespondlaminationdata->batchno.'</td>
                    <td>'.$rowrespondlaminationdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        }
        if(!empty($respondrimming->result())){
        $html.='
        <h6 class="small title-style"><span>Rimming Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Rimming Type</th>
                    <th>Material</th>
                    <th>Length</th>
                    <th>Sides</th>
                    <th>Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondrimming->result() as $rowrespondrimmingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                    <td>'.$rowrespondrimmingdata->materialname.'</td>
                    <td>'.$rowrespondrimmingdata->length.'</td>
                    <td>'.$rowrespondrimmingdata->sides.'</td>
                    <td>'.$rowrespondrimmingdata->qty.'</td>
                    <td>'.$rowrespondrimmingdata->batchno.'</td>
                    <td>'.$rowrespondrimmingdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        }
        // if(!empty($responddiecut->result())){
        // $html.='
        // <h6 class="small title-style"><span>Die Cutting Section</span></h6>
        // <table class="table table-striped table-bordered table-sm small w-100 nowrap">
        //     <thead>
        //         <tr>
        //             <th>Qty</th>
        //             <th>Perforaction</th>
        //             <th>Half Cutting</th>
        //             <th>Full Cutting</th>
        //         </tr>
        //     </thead>';
        //     foreach($responddiecut->result() as $rowresponddiecutdata){
        //     $html.='
        //     <tbody>
        //         <tr>
        //             <td>'.$rowresponddiecutdata->qty.'</td>
        //             <td>'.$rowresponddiecutdata->peraforation.'</td>
        //             <td>'.$rowresponddiecutdata->halfCutting.'</td>
        //             <td>'.$rowresponddiecutdata->fullCutting.'</td>
        //         </tr>
        //     </tbody>
        //     ';
        //     }
        // $html.='</table>';
        // }
        if(!empty($respondother->result())){
        $html.='
        <h6 class="small title-style"><span>Other Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Qty</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondother->result() as $rowrespondotherdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondotherdata->materialname.'</td>
                    <td>'.$rowrespondotherdata->qty.'</td>
                    <td>'.$rowrespondotherdata->batchno.'</td>
                    <td>'.$rowrespondotherdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        ';
        }

        echo $html;
    }
    public function Materialissue(){       
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $recordID = $this->input->post('recordID');
        $updatedatetime = date('Y-m-d H:i:s');
        $today = date('Y-m-d');
    
        $obj = new stdClass();
        $actionObj = new stdClass();
    
        try {
            $this->db->trans_begin();

            $this->db->select('date'); 
            $this->db->from('tbl_jobcard');
            $this->db->where('idtbl_jobcard', $recordID);
            $this->db->where('status', 1);
            $respond = $this->db->get();

            $recorddate = $respond->row(0)->date;
            $currentYear = date("Y", strtotime($recorddate));
            $currentMonth = date("m", strtotime($recorddate));

            if ($currentMonth < 4) { //03
                $startDate = $currentYear."-04-01";
                $startDate = date('Y-m-d',  strtotime($startDate.'-1 year'));
                $endDate = $currentYear."-03-31";
            } else {
                $startDate = $currentYear."-04-01";
                $endDate = $currentYear."-03-31";
                $endDate = date('Y-m-d',  strtotime($endDate.'+1 year'));
            }

            $fromyear = date("Y-m-d", strtotime($startDate));
            $toyear = date("Y-m-d", strtotime($endDate));

            $this->db->select('issuenoteno');
            $this->db->from('tbl_issue_note');
            $this->db->where('tbl_company_idtbl_company', $companyID);
            $this->db->where("DATE(date) >=", $fromyear);
            $this->db->where("DATE(date) <=", $toyear);
            $this->db->order_by('issuenoteno', 'DESC');
            $this->db->limit(1);
            $respond = $this->db->get();
            
            if ($respond->num_rows() > 0) {
                $last_inv_no = $respond->row()->issuenoteno;
                $inv_number = intval(substr($last_inv_no, -4));
                $count = $inv_number;
            } else {
                $count = 0;
            }

            $count++; 
            $countPrefix = sprintf('%04d', $count);

            $yearDigit = substr(date("Y", strtotime($fromyear)), -2);

            $issuenoteno = $yearDigit . $countPrefix;
    
            $data = array(
                'issuematerialstatus' => '1',
                'updatedatetime' => $updatedatetime
            );
            
            $this->db->where('idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard', $data);

            //Create issue note
            $dataissuenote = array(
                'date'=> $today, 
                'issuenoteno'=> $issuenoteno, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_jobcard_idtbl_jobcard'=> $recordID,
                'tbl_company_idtbl_company'=> $companyID, 
                'tbl_company_branch_idtbl_company_branch'=> $branchID, 
            );
    
            $this->db->insert('tbl_issue_note', $dataissuenote);
            $issuenoteID=$this->db->insert_id();

            //Deduct stock
            $this->db->select('`idtbl_jobcard_issue_meterial`, `batchno`, `issueqty`, `tbl_print_material_info_idtbl_print_material_info`');
            $this->db->from('tbl_jobcard_issue_meterial');
            $this->db->where('status', '1');
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $respondissue=$this->db->get();

            foreach ($respondissue->result() as $rowissue) {
                $issuematerialID=$rowissue->idtbl_jobcard_issue_meterial;
                $issueqty=$rowissue->issueqty;
                $batchno=$rowissue->batchno;
                $materialID=$rowissue->tbl_print_material_info_idtbl_print_material_info;

                $this->db->where('batchno', $batchno);
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_company_idtbl_company', $companyID);
                $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                $this->db->set('qty', 'qty - '.$issueqty, false);
                $this->db->update('tbl_print_stock');

                //Issuenote Detail
                $dataissuenotedetail = array(
                    'batchno'=> $batchno, 
                    'issueqty'=> $issueqty, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_issue_note_idtbl_issue_note'=> $issuenoteID,
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial'=> $issuematerialID, 
                );
        
                $this->db->insert('tbl_issue_note_detail', $dataissuenotedetail);
            }

            // Get material value
            $this->db->select('SUM(`tbl_jobcard_issue_meterial`.`issueqty`*`tbl_jobcard_issue_meterial`.`unitprice`) AS `issuematerialvalue`');
            $this->db->from('tbl_jobcard_issue_meterial');
            $this->db->where('status', 1);
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $respond = $this->db->get();

            // Get job description
            $this->db->select('job_description');
            $this->db->from('tbl_jobcard');
            $this->db->where('status', 1);
            $this->db->where('idtbl_jobcard', $recordID);
            $respondjobcard = $this->db->get();

            $tradate = date('Y-m-d');
            $traamount = $respond->row(0)->issuematerialvalue;
            $narrationcr = $respondjobcard->row(0)->job_description.' Material Issued on '.$tradate;
            $narrationdr = $respondjobcard->row(0)->job_description.' Material Issued on '.$tradate;
            if ($companyID == 1) {
                $accountdrno = 114;
                $accountcrno = 115;
            }

            // Make API call
            $apiURL = $_SESSION['accountapiurl'].'Api/Issuematerialprocess';
            $postData = "userid=$userID&company=$companyID&branch=$branchID&tradate=$tradate&traamount=$traamount&accountcrno=$accountcrno&narrationcr=$narrationcr&accountdrno=$accountdrno&narrationdr=$narrationdr";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $server_output = curl_exec($ch);
            
            if (curl_errno($ch)) {
                throw new Exception("API call failed: " . curl_error($ch));
            }
            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode != 200) {
                throw new Exception("API returned HTTP code: $httpCode");
            }

            // Update issue material status
            $dataissue = array(
                'status' => '2',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );
            
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_issue_meterial', $dataissue);
    
            $this->db->trans_commit();
    
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = 'Material Issued Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $obj->status = 1;
            $obj->action = json_encode($actionObj);
    
        } catch (Exception $e) {
            $this->db->trans_rollback();
            
            error_log("MaterialAllocationapprove Error: " . $e->getMessage());
            
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Operation Failed: ' . $e->getMessage();
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $obj->status = 0;
            $obj->action = json_encode($actionObj);
        }
    
        echo json_encode($obj);
    }
    public function jobCardIssueNote($x){
        $recordID=$x;
        $companyID=$_SESSION['company_id'];
        
        if($companyID==1){$prefix = 'MOPI';} 
        else if($companyID==2){$prefix = 'FTHI';}
        else if($companyID==3){$prefix = 'RMII';}

        $this->db->select("tbl_jobcard.*, `tbl_company`.`company`, `tbl_company_branch`.`branch`, CONCAT(`tbl_company`.`address1`, ' ', `tbl_company`.`address2`) AS `companyaddress`, `tbl_customerinquiry_detail`.`job_no`, `tbl_issue_note`.`issuenoteno`");
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry = tbl_jobcard.tbl_customerinquiry_idtbl_customerinquiry', 'left');
        $this->db->join('tbl_issue_note', 'tbl_issue_note.tbl_jobcard_idtbl_jobcard = tbl_jobcard.idtbl_jobcard', 'left');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_jobcard.tbl_company_idtbl_company', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_jobcard.tbl_company_branch_idtbl_company_branch', 'left');
        $this->db->where('tbl_issue_note.idtbl_issue_note', $recordID);
        $this->db->where('tbl_jobcard.status', 1);
        $respond=$this->db->get();

        $this->db->select('tbl_issue_note_detail.*, tbl_print_material_info.materialname');
        $this->db->from('tbl_issue_note_detail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_issue_note_detail.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_issue_note_detail.status', 1);
        $this->db->where('tbl_issue_note_detail.tbl_issue_note_idtbl_issue_note', $recordID);
        $responddetail=$this->db->get();

        $dataArray = [];
        $count = 0;
        $section = 1;

        $totalSum = 0;
        // $othercosttotal = $respond->row()->total;

        foreach ($responddetail->result() as $rowlist) {
            if ($count % 10 == 0) {
                $dataArray[$section] = [];
            }
        
            $dataArray[$section][] = [
                'batchno' => $rowlist->batchno,
                'materialname' => $rowlist->materialname,
                'issueqty' => $rowlist->issueqty
            ];
        
            $count++;
        
            if ($count % 10 == 0) {
                $section++;
            }
        } 

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Material Issue Note</title>
            <style>
                @page {
                    size: 220mm 140mm;
                    margin: 5mm 5mm 5mm 5mm; /* top right bottom left */
                    font-family: Arial, sans-serif;
                }
                body {
                    font-family: Arial, sans-serif; 
                    line-height: 1.5;
                    text-align:left;
                    margin-top: 115px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    right: 0px;
                    height: 210px;
                }

                /** Define the footer rules **/
                footer {
                    position: fixed; 
                    bottom: 0px; 
                    left: 0px; 
                    right: 0px;
                    height: 40px;
                }
            </style>
        </head>
        <body>
        <header>
            <table style="width:100%;border-collapse: collapse;">
                <tr>
                    <td style="text-align: center;vertical-align: top;padding: 0px;font-size: 18px;font-weight: bold;">
                        <u>Inventory Issue Note</u>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%;border-collapse: collapse;">
                            <td width="60%" style="vertical-align: top;">
                                <p style="margin:0px;font-size: 13px;font-weight: bold;">Issue Note: '.$prefix. $respond->row()->issuenoteno . '</p>
                                <p style="margin:0px;font-size: 13px;">Job Desc: ' . $respond->row()->job_description . '</p>
                                <p style="margin:0px;font-size: 13px;">Date: ' . $respond->row()->date . '</p>
                            </td>
                            <td style="vertical-align: top;">
                                <p style="font-size: 15px;font-weight: bold; margin-top: 0px; margin-bottom: 0px;text-transform: uppercase;">'.$respond->row()->company.'</p>
                                <p style="margin:0px;font-size:13px;text-transform: uppercase;">' . $respond->row()->companyaddress . '</p>
                            </td>
                        </table>
                    </td>
                </tr>
            </table>
        </header>
        <footer>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="text-align: left;font-size:13px;padding-top:15px;">Received By:.....................................</td>
                    <td style="text-align: center;font-size:13px;padding-top:15px;">Checked By:.....................................</td>
                    <td style="text-align: right;font-size:13px;padding-top:15px;">Date: .....................................</td>
                </tr>
            </table>
        </footer>
        ';
            foreach ($dataArray as $index => $section) {
                $html.='
                <main>
                    <table style="width:100%;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="padding-left: 10px;text-align:left;font-size: 12px;border: 1px thin solid;">Batch No</th>
                                <th style="padding-left: 10px;text-align:left;font-size: 12px;border: 1px thin solid;">Material</th>
                                <th style="padding-left: 10px;text-align:center;font-size: 12px;border: 1px thin solid;">Qty</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($section as $row) {
                                $html .= '<tr>
                                    <td style="text-align:left;font-size: 12px;border: 1px thin solid;padding-left: 10px;">' . htmlspecialchars($row['batchno']) . '</td>
                                    <td style="font-size: 12px;border: 1px thin solid;padding-left: 10px;">' . htmlspecialchars($row['materialname']) . '</td>
                                    <td style="text-align:center;font-size: 12px;border: 1px thin solid;padding-left: 10px;">' . htmlspecialchars($row['issueqty']) . '</td>
                                </tr>';
                            }
                        $html.='</tbody>
                    </table>
                </main>
                ';
            }   
            $html.='</body>
        </html>
        '; 
        // echo $html;
        $this->load->library('pdf');

        $options = new Options();
		$options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Goods Received Note - ". $recordID .".pdf", ["Attachment"=>0]);
    }
    public function Getissuenotelist(){
        $recordID=$this->input->post('recordID');
        
        $this->db->select('`idtbl_issue_note`, `issuenoteno`');
        $this->db->from('tbl_issue_note');
        $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        echo json_encode($respond->result());
    }
}