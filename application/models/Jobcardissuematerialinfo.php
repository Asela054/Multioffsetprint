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

        $this->db->select('tbl_jobcard_material.materialby, tbl_jobcard_material.cutsize, tbl_jobcard_material.cutups, tbl_jobcard_material.upspersheet, tbl_jobcard_material.wastage, tbl_jobcard_material.batchno, tbl_jobcard_material.issueqty, tbl_print_material_info.materialname, tbl_jobcard_issue_meterial.status as issuestatus, tbl_jobcard_issue_meterial.issuedate');
		$this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_material.idtbl_jobcard_material AND tbl_jobcard_issue_meterial.sectiontype = 1 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_material.status', 1);
        $this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');

		$respondmaterial=$this->db->get();

        $this->db->select([
            'tbl_jobcard_color.colormaterialby',
            'tbl_jobcard_color.colortype',
            'tbl_jobcard_color.remark',
            'tbl_jobcard_color.qty',
            'tbl_jobcard_color.issueqty',
            'tbl_jobcard_color.batchno',
            'tbl_print_material_info.materialname',
            'tbl_jobcard_issue_meterial.status as issuestatus',
            'tbl_jobcard_issue_meterial.issuedate'
        ]);
		$this->db->from('tbl_jobcard_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_color.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_color.idtbl_jobcard_color AND tbl_jobcard_issue_meterial.sectiontype = 2 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_color.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_color.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_color.status', 1);
		$this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');

		$respondcolor=$this->db->get();

        $this->db->select('tbl_jobcard_varnish.glossmatt, tbl_jobcard_varnish.fullspot, tbl_jobcard_varnish.varnishQty, tbl_jobcard_varnish.batchno, tbl_jobcard_varnish.issueqty, tbl_varnish.varnish, tbl_print_material_info.materialname, tbl_jobcard_issue_meterial.status as issuestatus, tbl_jobcard_issue_meterial.issuedate');
		$this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_varnish.idtbl_jobcard_varnish AND tbl_jobcard_issue_meterial.sectiontype = 3 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_varnish.status', 1);
        $this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');
		$respondvarnish=$this->db->get();  
        
        $this->db->select('tbl_jobcard_foil.foilmaterialby, tbl_jobcard_foil.qty, tbl_jobcard_foil.remark, tbl_jobcard_foil.batchno, tbl_jobcard_foil.issueqty, tbl_foiling.foiling, tbl_print_material_info.materialname, tbl_jobcard_issue_meterial.status as issuestatus, tbl_jobcard_issue_meterial.issuedate');
		$this->db->from('tbl_jobcard_foil');
        $this->db->join('tbl_foiling', 'tbl_foiling.idtbl_foiling = tbl_jobcard_foil.tbl_foiling_idtbl_foiling', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_foil.idtbl_jobcard_foil AND tbl_jobcard_issue_meterial.sectiontype = 4 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_foil.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_foil.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_foil.status', 1);
        $this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');

		$respondfoiling=$this->db->get();  

        $this->db->select(['tbl_jobcard_lamination.sides', 'tbl_jobcard_lamination.filmsize', 'tbl_jobcard_lamination.lamination_qty', 'tbl_jobcard_lamination.wastage', 'tbl_jobcard_lamination.batchno', 'tbl_jobcard_lamination.issueqty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname', 'tbl_jobcard_issue_meterial.status as issuestatus', 'tbl_jobcard_issue_meterial.issuedate']);
		$this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_lamination.idtbl_jobcard_lamination AND tbl_jobcard_issue_meterial.sectiontype = 5 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_lamination.status', 1);
        $this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');

		$respondlamination=$this->db->get();

        $this->db->select('tbl_jobcard_pasting.pastetype, tbl_jobcard_pasting.pasteqty, tbl_jobcard_pasting.remark, tbl_jobcard_pasting.batchno, tbl_jobcard_pasting.issueqty, tbl_machine.machine, tbl_print_material_info.materialname, tbl_jobcard_issue_meterial.status as issuestatus, tbl_jobcard_issue_meterial.issuedate');
		$this->db->from('tbl_jobcard_pasting');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_jobcard_pasting.tbl_machine_idtbl_machine', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_pasting.idtbl_jobcard_pasting AND tbl_jobcard_issue_meterial.sectiontype = 6 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_pasting.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_pasting.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_pasting.status', 1);
        $this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');

		$respondpasting=$this->db->get();  

        $this->db->select(['tbl_jobcard_diecutting.channel', 'tbl_jobcard_diecutting.board', 'tbl_jobcard_diecutting.size', 'tbl_jobcard_diecutting.qty', 'tbl_jobcard_diecutting.diecutby', 'tbl_jobcard_diecutting.embossby']);
		$this->db->from('tbl_jobcard_diecutting');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select(['tbl_jobcard_rimming.rimmingby', 'tbl_jobcard_rimming.sides', 'tbl_jobcard_rimming.qty', 'tbl_jobcard_rimming.remark', 'tbl_jobcard_rimming.batchno', 'tbl_jobcard_rimming.issueqty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname', 'tbl_jobcard_issue_meterial.status as issuestatus', 'tbl_jobcard_issue_meterial.issuedate']);
		$this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_jobcard_issue_meterial', 'tbl_jobcard_issue_meterial.jobcard_other_id = tbl_jobcard_rimming.idtbl_jobcard_rimming AND tbl_jobcard_issue_meterial.sectiontype = 7 AND tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard = tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', 'left');
		$this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_rimming.status', 1);
        $this->db->where('tbl_jobcard_issue_meterial.status <', 3);
        $this->db->group_by('tbl_jobcard_issue_meterial.jobcard_other_id');

		$respondrimming=$this->db->get();

        $this->db->select('`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`');
		$this->db->from('tbl_jobcard_other');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

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
                    <th>By</th>
                    <th>Material</th>
                    <th>Cut Size</th>
                    <th>Cut Up`s</th>
                    <th>Up Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondmaterial->result() as $rowmaterialdata){
            $html.='
            <tbody>
                <tr class="'.($rowmaterialdata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowmaterialdata->materialby.'</td>
                    <td>'.$rowmaterialdata->materialname.' ('.$rowmaterialdata->issuedate.')</td>
                    <td>'.$rowmaterialdata->cutsize.'</td>
                    <td>'.$rowmaterialdata->cutups.'</td>
                    <td>'.$rowmaterialdata->upspersheet.'</td>
                    <td>'.$rowmaterialdata->batchno.'</td>
                    <td>'.$rowmaterialdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        } 
        if(!empty($respondcolor->result())){
        $html.='
        <h6 class="small title-style"><span>Printing Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
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
                <tr class="'.($rowrespondcolordata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowrespondcolordata->colormaterialby.'</td>
                    <td>'.$rowrespondcolordata->colortype.'</td>
                    <td>'.$rowrespondcolordata->materialname.' ('.$rowrespondcolordata->issuedate.')</td>
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
        if(!empty($respondvarnish->result())){
        $html.='
        <h6 class="small title-style"><span>Coating Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Varnish</th>
                    <th>Gloss | Matt</th>
                    <th>Full | Spot</th>
                    <th>Material</th>
                    <th>Qty(KG)</th>
                    <th>Batch No</th>
                    <th>Issue Qty(KG)</th>
                </tr>
            </thead>';
            foreach($respondvarnish->result() as $rowvarnishdata){
            $html.='
            <tbody>
                <tr class="'.($rowvarnishdata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowvarnishdata->varnish.'</td>
                    <td>'.$rowvarnishdata->glossmatt.'</td>
                    <td>'.$rowvarnishdata->fullspot.'</td>
                    <td>'.$rowvarnishdata->materialname.' ('.$rowvarnishdata->issuedate.')</td>
                    <td>'.$rowvarnishdata->varnishQty.'</td>
                    <td>'.$rowvarnishdata->batchno.'</td>
                    <td>'.$rowvarnishdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        } 
        if(!empty($respondfoiling->result())){
        $html.='
        <h6 class="small title-style"><span>Foiling Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Material</th>
                    <th>Foil Type</th>
                    <th>Remark</th>
                    <th>Qty(Inch)</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondfoiling->result() as $rowfoilingdata){
            $html.='
            <tbody>
                <tr class="'.($rowfoilingdata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowfoilingdata->foilmaterialby.'</td>
                    <td>'.$rowfoilingdata->materialname.' ('.$rowfoilingdata->issuedate.')</td>
                    <td>'.$rowfoilingdata->foiling.'</td>
                    <td>'.$rowfoilingdata->remark.'</td>
                    <td>'.$rowfoilingdata->qty.'</td>
                    <td>'.$rowfoilingdata->batchno.'</td>
                    <td>'.$rowfoilingdata->issueqty.'</td>
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
                    <th>Sides</th>
                    <th>Qty(KG)</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondlamination->result() as $rowrespondlaminationdata){
            $html.='
            <tbody>
                <tr class="'.($rowrespondlaminationdata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowrespondlaminationdata->lamination.'</td>
                    <td>'.$rowrespondlaminationdata->materialname.' ('.$rowrespondlaminationdata->issuedate.')</td>
                    <td>'.$rowrespondlaminationdata->filmsize.'</td>
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
        if(!empty($respondpasting->result())){
        $html.='
        <h6 class="small title-style"><span>Pasting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Machine</th>
                    <th>Paste Type</th>
                    <th>Remark</th>
                    <th>Qty(KG)</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondpasting->result() as $rowpastingdata){
            $html.='
            <tbody>
                <tr class="'.($rowpastingdata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowpastingdata->materialname.' ('.$rowpastingdata->issuedate.')</td>
                    <td>'.$rowpastingdata->machine.'</td>
                    <td>'.$rowpastingdata->pastetype.'</td>
                    <td>'.$rowpastingdata->remark.'</td>
                    <td>'.$rowpastingdata->pasteqty.'</td>
                    <td>'.$rowpastingdata->batchno.'</td>
                    <td>'.$rowpastingdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>';
        }
        if(!empty($responddiecut->result())){
        $html.='
        <h6 class="small title-style"><span>Die Cutting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Channel</th>
                    <th>Board</th>
                    <th>Size</th>
                    <th>Qty(m)</th>
                    <th>Die cutting By</th>
                    <th>Embossing</th>
                </tr>
            </thead>';
            foreach($responddiecut->result() as $rowresponddiecutdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowresponddiecutdata->channel.'</td>
                    <td>'.$rowresponddiecutdata->board.'</td>
                    <td>'.$rowresponddiecutdata->size.'</td>
                    <td>'.$rowresponddiecutdata->qty.'</td>
                    <td>'.$rowresponddiecutdata->diecutby.'</td>
                    <td>'.$rowresponddiecutdata->embossby.'</td>
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
                    <th>By</th>
                    <th>Rimming Type</th>
                    <th>Material</th>
                    <th>Remark</th>
                    <th>Side</th>
                    <th>Qty</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondrimming->result() as $rowrespondrimmingdata){
            $html.='
            <tbody>
                <tr class="'.($rowrespondrimmingdata->issuestatus == 2 ? 'table-primary' : '').'">
                    <td>'.$rowrespondrimmingdata->rimmingby.'</td>
                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                    <td>'.$rowrespondrimmingdata->materialname.' ('.$rowrespondrimmingdata->issuedate.')</td>
                    <td>'.$rowrespondrimmingdata->remark.'</td>
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
        if(!empty($respondother->result())){
        $html.='
        <h6 class="small title-style"><span>Other Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Perforating</th>
                    <th>Gattering</th>
                    <th>Rimming</th>
                    <th>Binding</th>
                    <th>Stapling</th>
                    <th>Padding</th>
                    <th>Creasing</th>
                    <th>Threading</th>
                </tr>
            </thead>';
            foreach($respondother->result() as $rowrespondotherdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondotherdata->perfoating.'</td>
                    <td>'.$rowrespondotherdata->gattering.'</td>
                    <td>'.$rowrespondotherdata->rimming.'</td>
                    <td>'.$rowrespondotherdata->binding.'</td>
                    <td>'.$rowrespondotherdata->stapling.'</td>
                    <td>'.$rowrespondotherdata->padding.'</td>
                    <td>'.$rowrespondotherdata->creasing.'</td>
                    <td>'.$rowrespondotherdata->threading.'</td>
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

            // Update issue material status
            $dataissue = array(
                'status' => '2',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );
            
            $this->db->where('idtbl_jobcard_issue_meterial', $issuematerialID);
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->where('status', '1');
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
        $dompdf->stream("Material Issue Note - ". $recordID .".pdf", ["Attachment"=>0]);
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

    public function Getjobcardissuematerialbatchlist(){
        $recordID = $this->input->post('recordID');

        $warningstockstatus = 0;
        $warningstocktext    = '';
        $warningsection      = '';
        $html                = [];

        // Config: section type => [table, id column]
        $sections = [
            'material'   => ['tbl_jobcard_material',    'idtbl_jobcard_material', '1'],
            'color'      => ['tbl_jobcard_color',       'idtbl_jobcard_color', '2'],
            'varnish'    => ['tbl_jobcard_varnish',     'idtbl_jobcard_varnish', '3'],
            'foil'       => ['tbl_jobcard_foil',        'idtbl_jobcard_foil', '4'],
            'lamination' => ['tbl_jobcard_lamination',  'idtbl_jobcard_lamination', '5'],
            'pasting'    => ['tbl_jobcard_pasting',     'idtbl_jobcard_pasting', '6'],
            'rimming'    => ['tbl_jobcard_rimming',     'idtbl_jobcard_rimming', '7'],
        ];

        foreach ($sections as $type => $tableInfo) {
            list($table, $idCol, $secid) = $tableInfo;

            $rows = $this->_getIssueMaterialRows($recordID, $table, $idCol, $secid);

            $html = array_merge(
                $html,
                $this->_buildMaterialHtml($rows, $idCol, $secid, $warningstockstatus, $warningstocktext, $warningsection, $type)
            );
        }

        $obj=new stdClass();
        $obj->tabledata=$html;
        $obj->warnstatus=$warningstockstatus;
        $obj->warntext=$warningstocktext;
        $obj->warningsection=$warningsection;

        echo json_encode($obj);
    }

    /**
     * Shared query builder for all section types
     * (material, color, varnish, foil, lamination, pasting, rimming).
     */
    private function _getIssueMaterialRows($recordID, $table, $idCol, $secid)
    {
        $fkCol = 'tbl_jobcard_idtbl_jobcard';

        $this->db->select("
            {$table}.{$idCol},
            tbl_print_material_info.materialname,
            {$table}.issueqty,
            {$table}.batchno,
            {$table}.tbl_print_material_info_idtbl_print_material_info,
            tbl_measurements.measure_type,
            tbl_jobcard_issue_meterial.reqissueqty,
            SUM(tbl_print_stock.qty) AS totqty
        ");
        $this->db->from('tbl_jobcard_issue_meterial');
        $this->db->join($table, "{$table}.{$fkCol} = tbl_jobcard_issue_meterial.{$fkCol} AND {$table}.{$idCol} = tbl_jobcard_issue_meterial.jobcard_other_id");
        $this->db->join('tbl_print_material_info', "tbl_print_material_info.idtbl_print_material_info = {$table}.tbl_print_material_info_idtbl_print_material_info", 'left');
        $this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_material_info.tbl_measurements_idtbl_measurements', 'left');
        $this->db->join('tbl_print_stock', "tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = {$table}.tbl_print_material_info_idtbl_print_material_info", 'left');
        $this->db->where("{$table}.{$fkCol}", $recordID);
        $this->db->where('tbl_jobcard_issue_meterial.status', 1);
        $this->db->where("{$table}.status", 1);
        $this->db->where('tbl_jobcard_issue_meterial.sectiontype', $secid);
        $this->db->group_by("{$table}.{$idCol}"); // critical fix, previous message eke explain kala
           
        return $this->db->get()->result();
    }

    /**
     * Builds HTML rows and tracks stock warnings (by reference).
     */
    private function _buildMaterialHtml($resultRows, $idField, $secid, &$warningstockstatus, &$warningstocktext, &$warningsection, $type)
    {
        $html = [];
        $sectionType = null;   // Fixed: was 0 (int), caused loose-comparison bug with string $type

        foreach ($resultRows as $row) {
            if ($sectionType !== $type) {   // Fixed: strict comparison (!==)
                $html[] = '
                    <tr data-otherrow="'.$type.'section">
                        <th colspan="6" class="sectionremove">'.ucfirst($type).' Section</th>
                    </tr>';

                $sectionType = $type;   // Fixed: mark header as already printed for this call
            }

            $html[] = '
                <tr class="'.$type.'section">
                    <td class="d-none">' . $row->$idField . '</td>
                    <td class="d-none">'.$secid.'</td>
                    <td>' . $row->materialname . '</td>
                    <td class="text-center">' . $row->issueqty . '</td>
                    <td class="batchnolist">' . $row->batchno . '</td>
                    <td class="d-none">' . $row->tbl_print_material_info_idtbl_print_material_info . '</td>
                    <td class="text-center">' . $row->measure_type . '</td>
                    <td class="d-none">' . $row->reqissueqty . '</td>
                </tr>
            ';

            if ($row->issueqty > $row->totqty) {
                $warningstockstatus = 1;
                $warningstocktext  .= $row->materialname . ', ';
                $warningsection     = 'materialsection';
            }
        }

        return $html;
    }

    public function Getbatchnolistaccomaterial(){
        $materialID=$this->input->post('materialID');
        $companyID=$_SESSION['company_id'];
        $branchID=$_SESSION['branch_id'];

        // $this->db->select('`batchno`, `qty`, `unitprice`');
        // $this->db->from('tbl_print_stock');
        // $this->db->where('status', 1);
        // $this->db->where('qty >', 0);
        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
        // $this->db->where('tbl_company_idtbl_company', $companyID);
        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

        // $respond=$this->db->get();

        $this->db->select('
            tbl_print_stock.batchno, 
            tbl_print_stock.grndate, 
            tbl_print_stock.unitprice,
            (tbl_print_stock.qty - COALESCE(SUM(tbl_jobcard_issue_meterial.issueqty), 0)) AS qty
        ');
        $this->db->from('tbl_print_stock');
        $this->db->join(
            'tbl_jobcard_issue_meterial',
            'tbl_jobcard_issue_meterial.tbl_print_material_info_idtbl_print_material_info = tbl_print_stock.tbl_print_material_info_idtbl_print_material_info 
            AND tbl_jobcard_issue_meterial.batchno = tbl_print_stock.batchno
            AND tbl_jobcard_issue_meterial.status = 1',
            'left'
        );
        $this->db->join(
            'tbl_jobcard',
            'tbl_jobcard.idtbl_jobcard = tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard
            AND tbl_jobcard.tbl_company_idtbl_company = ' . $companyID . '
            AND tbl_jobcard.tbl_company_branch_idtbl_company_branch = ' . $branchID,
            'left'
        );
        $this->db->where('tbl_print_stock.status', 1);
        $this->db->where('tbl_print_stock.qty >', 0);
        $this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info', $materialID);
        $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_print_stock.tbl_company_branch_idtbl_company_branch', $branchID);
        $this->db->group_by('tbl_print_stock.batchno, tbl_print_stock.qty, tbl_print_stock.unitprice');

        $respond = $this->db->get();

        echo json_encode($respond->result());
    }

    // public function Issuematerialbatchupdate(){
    //     $this->db->trans_begin();

    //     $jobCardID=$this->input->post('batchJobcardID');
    //     $tableData=$this->input->post('tableData');
        
    //     $companyID=$_SESSION['company_id'];
    //     $branchID=$_SESSION['branch_id'];
    //     $userID=$_SESSION['userid'];

    //     $updatedatetime=date('Y-m-d H:i:s');
    //     $allocationdate='';

    //     foreach($tableData as $rowdatalist){
    //         $jobcardotherID=$rowdatalist['col_1'];
    //         $type=$rowdatalist['col_2'];
    //         $materialname=$rowdatalist['col_3'];
    //         $issueqtydata=$rowdatalist['col_4'];
    //         $batchnolist=$rowdatalist['col_5'];
    //         $materialID=$rowdatalist['col_6'];
    //         $unittype=$rowdatalist['col_7'];
    //         $reqissueqty=$rowdatalist['col_7'];

    //         if($type==1){
    //             $this->db->select('issuedate');
    //             $this->db->from('idtbl_jobcard_issue_meterial');
    //             $this->db->where('tbl_jobcard_issue_meterial', $jobcardotherID);
    //             $respond=$this->db->get();
    //             $allocationdate = $respond->row(0)->issuedate;

    //             $data = array(
    //                 'batchno'=> $batchnolist, 
    //                 'updateuser'=> $userID, 
    //                 'updatedatetime'=> $updatedatetime
    //             );

    //             $this->db->where('idtbl_jobcard_material', $jobcardotherID);
    //             $this->db->update('tbl_jobcard_material', $data);
    //         }

    //         $this->db->where('jobcard_other_id', $jobcardotherID);
    //         $this->db->where('tbl_jobcard_idtbl_jobcard', $jobCardID);
    //         $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
    //         $this->db->delete('tbl_jobcard_issue_meterial');

    //         $explodebatch=explode(',', $batchnolist);
                
    //         $balqty=$issueqtydata;

    //         foreach($explodebatch as $rowbatchno){
    //             $this->db->select('`batchno`, `qty`, `unitprice`');
    //             $this->db->from('tbl_print_stock');
    //             $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
    //             $this->db->where('batchno', $rowbatchno);
    //             $this->db->where('tbl_company_idtbl_company', $companyID);
    //             $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
    //             $this->db->where('status', 1);

    //             $respondstock=$this->db->get();

    //             if($balqty>0){
    //                 if($respondstock->row(0)->qty>=$balqty){
    //                     $issueqty=$balqty;
    //                     $balqty=0;
    //                 }
    //                 else{
    //                     $balqty=$balqty-$respondstock->row(0)->qty;
    //                     $issueqty=$respondstock->row(0)->qty;
    //                 }

    //                 $datamaterialissue = array(
    //                     'sectiontype'=> $type, 
    //                     'issuedate'=> $allocationdate, 
    //                     'batchno'=> $rowbatchno, 
    //                     'reqissueqty'=> $reqissueqty, 
    //                     'issueqty'=> $issueqty, 
    //                     'unitprice'=> $respondstock->row(0)->unitprice, 
    //                     'status'=> '1', 
    //                     'insertdatetime'=> $updatedatetime, 
    //                     'tbl_user_idtbl_user'=> $userID, 
    //                     'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
    //                     'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
    //                     'jobcard_other_id'=> $jobcardotherID
    //                 );
        
    //                 $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);
    //             }
    //         }
    //     }

    //     $this->db->trans_complete();

    //     if ($this->db->trans_status() === TRUE) {
    //         $this->db->trans_commit();
            
    //         $actionObj=new stdClass();
    //         $actionObj->icon='fas fa-save';
    //         $actionObj->title='';
    //         $actionObj->message='Record Added Successfully';
    //         $actionObj->url='';
    //         $actionObj->target='_blank';
    //         $actionObj->type='success';

    //         $actionJSON=json_encode($actionObj);

    //         $obj=new stdClass();
    //         $obj->status=1;          
    //         $obj->action=$actionJSON;  
            
    //         echo json_encode($obj);
    //     } else {
    //         $this->db->trans_rollback();

    //         $actionObj=new stdClass();
    //         $actionObj->icon='fas fa-exclamation-triangle';
    //         $actionObj->title='';
    //         $actionObj->message='Record Error';
    //         $actionObj->url='';
    //         $actionObj->target='_blank';
    //         $actionObj->type='danger';

    //         $actionJSON=json_encode($actionObj);

    //         $obj=new stdClass();
    //         $obj->status=0;          
    //         $obj->action=$actionJSON;  
            
    //         echo json_encode($obj);
    //     }
    // }

    public function Issuematerialbatchupdate(){
        $jobCardID = $this->input->post('batchJobcardID');
        $tableData = $this->input->post('tableData');

        $companyID = $_SESSION['company_id'];
        $branchID  = $_SESSION['branch_id'];
        $userID    = $_SESSION['userid'];

        $updatedatetime = date('Y-m-d H:i:s');

        // sectiontype => [table, id column]
        // ⚠️ type numbers (2-7) confirm karanna - color/varnish/foil/lamination/pasting/rimming
        // walata DB eke use wena actual sectiontype values danna
        $typeConfig = [
            1 => ['table' => 'tbl_jobcard_material',   'idcol' => 'idtbl_jobcard_material'],
            2 => ['table' => 'tbl_jobcard_color',      'idcol' => 'idtbl_jobcard_color'],
            3 => ['table' => 'tbl_jobcard_varnish',    'idcol' => 'idtbl_jobcard_varnish'],
            4 => ['table' => 'tbl_jobcard_foil',       'idcol' => 'idtbl_jobcard_foil'],
            5 => ['table' => 'tbl_jobcard_lamination', 'idcol' => 'idtbl_jobcard_lamination'],
            6 => ['table' => 'tbl_jobcard_pasting',    'idcol' => 'idtbl_jobcard_pasting'],
            7 => ['table' => 'tbl_jobcard_rimming',    'idcol' => 'idtbl_jobcard_rimming'],
        ];

        $this->db->trans_begin();

        try {
            foreach ($tableData as $rowdatalist) {
                $jobcardotherID = $rowdatalist['col_1'];
                $type           = $rowdatalist['col_2'];
                $materialname   = $rowdatalist['col_3'];
                $issueqtydata   = $rowdatalist['col_4'];
                $batchnolist    = $rowdatalist['col_5'];
                $materialID     = $rowdatalist['col_6'];
                $unittype       = $rowdatalist['col_7'];
                $reqissueqty    = $rowdatalist['col_7'];

                if (!isset($typeConfig[$type])) {
                    throw new Exception("Unknown section type received: {$type}");
                }

                $tableName      = $typeConfig[$type]['table'];
                $tableIdCol     = $typeConfig[$type]['idcol'];
                $allocationdate = '';

                // Fixed: correct table/column (previously table & column names were swapped)
                $this->db->select('issuedate');
                $this->db->from('tbl_jobcard_issue_meterial');
                $this->db->where('jobcard_other_id', $jobcardotherID);
                $respond = $this->db->get();

                if ($respond->num_rows() > 0) {
                    $allocationdate = $respond->row(0)->issuedate;
                }

                // Updates the section-specific table (material/color/varnish/foil/
                // lamination/pasting/rimming) - now runs for ALL 7 types, not just type==1
                $data = [
                    'batchno'        => $batchnolist,
                    'updatedatetime' => $updatedatetime
                ];

                $this->db->where($tableIdCol, $jobcardotherID);
                $this->db->update($tableName, $data);

                // Clear existing allocation rows for this item before re-inserting
                $this->db->where('jobcard_other_id', $jobcardotherID);
                $this->db->where('tbl_jobcard_idtbl_jobcard', $jobCardID);
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->delete('tbl_jobcard_issue_meterial');

                $explodebatch = explode(',', $batchnolist);
                $balqty = $issueqtydata;

                foreach ($explodebatch as $rowbatchno) {
                    $this->db->select('batchno, qty, unitprice');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock = $this->db->get();

                    if ($respondstock->num_rows() === 0) {
                        throw new Exception("Stock batch not found: {$rowbatchno} (materialID: {$materialID})");
                    }

                    if ($balqty > 0) {
                        if ($respondstock->row(0)->qty >= $balqty) {
                            $issueqty = $balqty;
                            $balqty   = 0;
                        } else {
                            $balqty   = $balqty - $respondstock->row(0)->qty;
                            $issueqty = $respondstock->row(0)->qty;
                        }

                        $datamaterialissue = [
                            'sectiontype'          => $type,
                            'issuedate'            => $allocationdate,
                            'batchno'              => $rowbatchno,
                            'reqissueqty'          => $reqissueqty,
                            'issueqty'             => $issueqty,
                            'unitprice'            => $respondstock->row(0)->unitprice,
                            'status'               => '1',
                            'insertdatetime'       => $updatedatetime,
                            'tbl_user_idtbl_user'  => $userID,
                            'tbl_jobcard_idtbl_jobcard' => $jobCardID,
                            'tbl_print_material_info_idtbl_print_material_info' => $materialID,
                            'jobcard_other_id'     => $jobcardotherID
                        ];

                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);
                    }
                }
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction status check failed');
            }

            $this->db->trans_commit();
            echo json_encode($this->_buildActionResponse(1, 'success', 'fas fa-save', 'Record Added Successfully'));

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Issuematerialbatchupdate failed: ' . $e->getMessage());
            echo json_encode($this->_buildActionResponse(0, 'danger', 'fas fa-exclamation-triangle', 'Record Error'));
        }
    }

    /**
     * Builds the standard status/action JSON response.
     */
    private function _buildActionResponse($status, $type, $icon, $message)
    {
        $actionObj = new stdClass();
        $actionObj->icon    = $icon;
        $actionObj->title   = '';
        $actionObj->message = $message;
        $actionObj->url     = '';
        $actionObj->target  = '_blank';
        $actionObj->type    = $type;

        $obj = new stdClass();
        $obj->status = $status;
        $obj->action = json_encode($actionObj);

        return $obj;
    }

    public function Getissuenoteaccounttransfer(){
        $recordID=$this->input->post('recordID');
        $companyID=$_SESSION['company_id'];
        
        if($companyID==1){$prefix = 'MOPI';} 
        else if($companyID==2){$prefix = 'FTHI';}
        else if($companyID==3){$prefix = 'RMII';}

        $this->db->select("tbl_jobcard.*, `tbl_company`.`company`, `tbl_company_branch`.`branch`, CONCAT(`tbl_company`.`address1`, ' ', `tbl_company`.`address2`) AS `companyaddress`, `tbl_customerinquiry_detail`.`job_no`, `tbl_issue_note`.`issuenoteno`, `tbl_issue_note`.`approvestatus`");
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

        $html='';
        $html.='
        <div class="row">
            <div class="col">
                <label class="small font-weight-bold my-0">Issue No: </label>
                <label class="small my-0">'.$respond->row(0)->issuenoteno.'</label><br>
                <label class="small font-weight-bold my-0">Date: </label>
                <label class="small my-0">'.$respond->row(0)->date.'</label><br>
                <label class="small font-weight-bold my-0">Job Description: </label>
                <label class="small my-0">' . $respond->row()->job_description . '</label>
            </div>
            <div class="col">
                <label class="small font-weight-bold my-0">Company: </label>
                <label class="small my-0">'.$respond->row()->company.'</label><br>
                <label class="small font-weight-bold my-0">Address: </label>
                <label class="small my-0">'.$respond->row()->companyaddress.'</label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h6 class="small title-style my-3"><span>Segregation Information</span></h6>
                <table class="table  table-striped table-sm nowrap small">
                    <thead>
                        <tr>
                            <th>Batch No</th>
                            <th>Material</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responddetail->result() as $rowdatainfo){
                        $html.='
                        <tr>
                            <td>'.$rowdatainfo->batchno.'</td>
                            <td>'.$rowdatainfo->materialname.'</td>
                            <td class="text-center">'.$rowdatainfo->issueqty.'</td>
                        </tr>
                        ';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>';
        if($respond->row(0)->approvestatus==1){
            $html.='<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Approved!</h4>
                <p>This issue note has been approved and transfer to accounting system.</p>
            </div>';
        }

        $obj=new stdClass();
        $obj->html=$html;
        $obj->approvestatus=$respond->row(0)->approvestatus;
        echo json_encode($obj);
    }

    public function Approveissuenote(){
        try {
            $this->db->trans_begin();

            $recordID=$this->input->post('recordID');
            $companyID=$_SESSION['company_id'];
            $branchID=$_SESSION['branch_id'];
            $userID=$_SESSION['userid'];

            $updatedatetime=date('Y-m-d H:i:s');

            $this->db->select('approvestatus, tbl_jobcard_idtbl_jobcard');
            $this->db->from('tbl_issue_note');
            $this->db->where('idtbl_issue_note', $recordID);
            $respond = $this->db->get();

            if ($respond->row() && $respond->row()->approvestatus == 1) {
                throw new Exception('This issue note has already been approved.');
            }

            $data = array(
                'approvestatus'=> 1, 
                'approveby'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_issue_note', $recordID);
            $this->db->update('tbl_issue_note', $data);

            $jobcardID = $respond->row()->tbl_jobcard_idtbl_jobcard;

            // Check batch no have any grn voucher entry
            $this->db->select('tbl_jobcard_issue_meterial.batchno as batchno');
            $this->db->from('tbl_jobcard_issue_meterial');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_issue_meterial.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
            $this->db->where('tbl_jobcard_issue_meterial.status', 2);
            $this->db->where('tbl_issue_note_detail.tbl_issue_note_idtbl_issue_note', $recordID);
            $respondcheckgrnvoucher = $this->db->get();

            // Collect unique batch numbers from the issued materials
            $batchNoList = array();
            foreach ($respondcheckgrnvoucher->result() as $row) {
                if (!empty($row->batchno) && !in_array($row->batchno, $batchNoList)) {
                    $batchNoList[] = $row->batchno;
                }
            }

            // For every batch no, check GRN(s) exist; if a GRN exists, it must have a voucher import cost entry
            foreach ($batchNoList as $batchNo) {

                $this->db->select('idtbl_print_grn, tbl_supplier_idtbl_supplier');
                $this->db->from('tbl_print_grn');
                $this->db->where('batchno', $batchNo);
                $grnCheck = $this->db->get();

                // No GRN for this batch at all - skip, nothing to validate
                if ($grnCheck->num_rows() == 0 || $grnCheck->row(0)->tbl_supplier_idtbl_supplier == 64 || $grnCheck->row(0)->tbl_supplier_idtbl_supplier == 81) {
                    continue;
                }

                // GRN exists - every GRN must have a corresponding voucher import cost entry
                foreach ($grnCheck->result() as $grnRow) {

                    $this->db->select('idtbl_grn_vouchar_import_cost');
                    $this->db->from('tbl_grn_vouchar_import_cost');
                    $this->db->where('tbl_print_grn_idtbl_print_grn', $grnRow->idtbl_print_grn);
                    $voucherCheck = $this->db->get();

                    if ($voucherCheck->num_rows() == 0) {
                        throw new Exception('Batch No ' . $batchNo . ' has a GRN but no voucher entry.');
                    }
                }
            }

            // Get material value
            $this->db->select('tbl_jobcard_issue_meterial.issuedate, SUM(`tbl_jobcard_issue_meterial`.`issueqty`*`tbl_jobcard_issue_meterial`.`unitprice`) AS `issuematerialvalue`, GROUP_CONCAT(`tbl_print_material_info`.`tbl_supplier_idtbl_supplier`) AS `suppliers`');
            $this->db->from('tbl_jobcard_issue_meterial');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_issue_meterial.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_issue_note_detail', 'tbl_issue_note_detail.tbl_jobcard_issue_meterial_idtbl_jobcard_issue_meterial = tbl_jobcard_issue_meterial.idtbl_jobcard_issue_meterial', 'left');
            $this->db->where('tbl_jobcard_issue_meterial.status', 2);
            $this->db->where('tbl_issue_note_detail.tbl_issue_note_idtbl_issue_note', $recordID);
            $respond = $this->db->get();
            
            // Get job description
            $this->db->select('job_description');
            $this->db->from('tbl_jobcard');
            $this->db->where('status', 1);
            $this->db->where('idtbl_jobcard', $jobcardID);
            $respondjobcard = $this->db->get();

            $tradate = $respond->row(0)->issuedate;
            $traamount = $respond->row(0)->issuematerialvalue;
            $suppliersArray = explode(',', $respond->row(0)->suppliers);
            $narrationcr = $respondjobcard->row(0)->job_description.' Material Issued on '.$tradate;
            $narrationdr = $respondjobcard->row(0)->job_description.' Material Issued on '.$tradate;

            $chartspecialcate = array('39', '37');
            $this->db->where('tbl_account_allocation.companybank', $companyID);
            $this->db->where('tbl_account_allocation.branchcompanybank', $branchID);
            $this->db->where_in('tbl_account.specialcate', $chartspecialcate);
            $this->db->where('tbl_account.status', 1);
            $this->db->where('tbl_account_allocation.status', 1);
            $this->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
            $this->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`, `tbl_account`.`specialcate`');
            $this->db->from('tbl_account');
            $this->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');

            $respondchart=$this->db->get();

            foreach($respondchart->result() as $rowchartdata):
                if($rowchartdata->specialcate == '39'):
                    $accountdrno = $rowchartdata->idtbl_account; 
                elseif($rowchartdata->specialcate == '37'):
                    $accountcrno = $rowchartdata->idtbl_account; 
                endif;
            endforeach;

            $isSupplierPartyOnly = false;

            if($traamount <= 0){
                if($companyID == 1){$supplierbypartyID = 64;}
                else if($companyID == 3){$supplierbypartyID = 81;}
                else{$supplierbypartyID = 0;} 

                $suppliersArray = array_filter(array_unique(explode(',', $respond->row(0)->suppliers)));
                $isSupplierPartyOnly = (count($suppliersArray) === 1 && intval(reset($suppliersArray)) === $supplierbypartyID);

                if(!$isSupplierPartyOnly){
                    throw new Exception('Material value is zero, cannot proceed with accounting entry.');
                }
            }

            if($traamount > 0 || !$isSupplierPartyOnly){  // ← only this line changed
                // Make API call
                $apiURL = $_SESSION['accountapiurl'].'Api/Issuematerialprocess';

                $postData = http_build_query([
                    'userid'      => $userID,
                    'company'     => $companyID,
                    'branch'      => $branchID,
                    'tradate'     => $tradate,
                    'traamount'   => $traamount,
                    'accountcrno' => $accountcrno,
                    'narrationcr' => $narrationcr,
                    'accountdrno' => $accountdrno,
                    'narrationdr' => $narrationdr,
                ]);
                
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL            => $apiURL,
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => $postData,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT        => 30,
                    CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
                ]);
                
                $server_output = curl_exec($ch);
                $curlError     = curl_error($ch);
                $httpCode      = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $apiResponse = json_decode($server_output, true);
                if ($httpCode != 200 || !isset($apiResponse['status']) || $apiResponse['status'] !== 'success') {
                    $errorMsg = $apiResponse['message'] ?? 'API request failed';
                    throw new Exception($errorMsg);
                }   
            }

            $this->db->trans_commit();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = 'Issue note approved and accounting entry created successfully.';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = json_encode($actionObj);

        } catch (Exception $e) {
            $this->db->trans_rollback();

            error_log("Error: " . $e->getMessage());
            
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Operation Failed: ' . $e->getMessage();
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $obj = new stdClass();
            $obj->status = 0;
            $obj->action = json_encode($actionObj);
        }

        echo json_encode($obj);
    }
}