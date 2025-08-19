<?php
class Quatationinfo extends CI_Model{

    public function Getcustomerlist() {
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function getplates(){
        $this->db->select('`idtbl_plates`,`plate`,`size`');
        $this->db->from('tbl_plates');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }

    public function Getjobs(){
        $this->db->select('idtbl_customer_job_details, job_name, job_code');
        $this->db->from('tbl_customer_job_details');
        return $respond=$this->db->get();
    }

    public function getjobsid(){
        $this->db->select('job_id, job_no');
        $this->db->from('tbl_customerinquiry_detail');
        return $respond=$this->db->get();
    }
    public function get_jobs_by_customer($customer_id) {
        $this->db->select('idtbl_customer_job_details, job_name, job_code');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('tbl_customer_idtbl_customer', $customer_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_job_details_by_job_id($job_id) {
        $this->db->select('job_id, job_no');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('job_id', $job_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_boardpaper_batch($boardpaper_id) {
        $this->db->select('idtbl_print_stock, batchno,unitprice');
        $this->db->from('tbl_print_stock');
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $boardpaper_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getjobinstroctions(){

        $recordID=$this->input->post('JobID');

        $this->db->select('*');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('idtbl_customer_job_details', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        if ($respond->num_rows() > 0) {
            $row = $respond->row();
    
            $obj = new stdClass();
            $obj->id = $row->idtbl_customer_job_details;
            $obj->unitprice = $row->unitprice;
            $obj->carton_L = $row->carton_L;
            $obj->carton_W = $row->carton_W;
            $obj->carton_H = $row->carton_H;
            $obj->Label_L = $row->Label_L;
            $obj->label_W = $row->label_W;
            $obj->idtbl_printing_format = $row->tbl_printing_format_idtbl_printing_format;
            $obj->idtbl_print_material_info = $row->tbl_print_material_info_idtbl_print_material_info;
            $obj->cutsize_W = $row->cutsize_W;
            $obj->cutsize_H = $row->cutsize_H;
            $obj->no_of_ups = $row->no_of_ups;
            $obj->idtbl_print_color = $row->tbl_print_color_idtbl_print_color;
            $obj->idtbl_varnish = $row->tbl_varnish_idtbl_varnish;
            $obj->idtbl_lamination = $row->tbl_lamination_idtbl_lamination;
            $obj->lamination_filmsize = $row->lamination_filmsize;
            $obj->lamination_micron = $row->lamination_micron;
            $obj->idtbl_foiling = $row->tbl_foiling_idtbl_foiling;
            $obj->idtbl_rimming = $row->tbl_rimming_idtbl_rimming;
            $obj->rimming_side = $row->rimming_side;
            $obj->rimming_length = $row->rimming_length;
            $obj->idtbl_finishing_other = $row->tbl_finishing_other_idtbl_finishing_other;
            $obj->windowpatch_L = $row->windowpatch_L;
            $obj->windowpatch_W = $row->windowpatch_W;
            $obj->windowpatch_micron = $row->windowpatch_micron;
            $obj->idtbl_diecutting = $row->tbl_diecutting_idtbl_diecutting;
            $obj->idtbl_pasting = $row->tbl_pasting_idtbl_pasting;
            $obj->adhesive_name = $row->adhesive_name;
            $obj->idtbl_bindery = $row->tbl_bindery_idtbl_bindery;
            $obj->delivery_by = $row->delivery_by;

            echo json_encode($obj);
        }
    }

    public function Quotationinsertupdate(){

        $this->db->trans_begin();
        $userID=$_SESSION['userid'];


        $customer=$this->input->post('customer');
		$customerjob=$this->input->post('customerjob');
		$jobno=$this->input->post('jobno');
		$quantity=$this->input->post('quantity');
		$boardpaper=$this->input->post('boardpaper');
        $printformat=$this->input->post('printformat');
        $cutsize1=$this->input->post('cutsize1');
        $cutsize2=$this->input->post('cutsize2');
        $noofpacts=$this->input->post('noofpacts');
        $nosheet=$this->input->post('nosheet');
        $wastage=$this->input->post('wastage');
        $boardsize1=$this->input->post('boardsize1');
        $boardsize12=$this->input->post('boardsize12');
        $wastageboard=$this->input->post('wastageboard');
        $cutsize3=$this->input->post('cutsize3');
        $cutsize4=$this->input->post('cutsize4');
        $cutssheetsper=$this->input->post('cutssheetsper');
        $noofups=$this->input->post('noofups');
        $net_total=$this->input->post('net_total');
        $margin=$this->input->post('margin');
        $margincalculation=$this->input->post('margincalculation');
        $totalmargin=$this->input->post('totalmargin');
        $calvalue=$this->input->post('calvalue');
        $credit=$this->input->post('credit');
        $credittotal=$this->input->post('credittotal');
        $creditwithtotal=$this->input->post('creditwithtotal');
        $vat=$this->input->post('vat');
        $vat2=$this->input->post('vat2');
        $vatcount=$this->input->post('vatcount');
        $tptalwithvat=$this->input->post('tptalwithvat');


        $boardpaperselect=$this->input->post('boardpaperselect');
        $boardpaperbatch=$this->input->post('boardpaperbatch');
        $board_unitprice=$this->input->post('board_unitprice');
        $board_quantity=$this->input->post('board_quantity');
        $board_quantity2=$this->input->post('board_quantity2');
        $board_total=$this->input->post('board_total');


        $wastagelist=$this->input->post('wastagelist');
        $wastage_cal1=$this->input->post('wastage_cal1');
        $wastage_cal2=$this->input->post('wastage_cal2');
        $wastage_total=$this->input->post('wastage_total');


        $colors=$this->input->post('colors');
        $colorsbatch=$this->input->post('colorsbatch');
        $colors_unitprice=$this->input->post('colors_unitprice');
        $colors_quantity=$this->input->post('colors_quantity');
        $colors_total=$this->input->post('colors_total');

        $varnish=$this->input->post('varnish');
        $varnishbatch=$this->input->post('varnishbatch');
        $varnish_unitprice=$this->input->post('varnish_unitprice');
        $varnish_quantity=$this->input->post('varnish_quantity');
        $varnish_quantity2=$this->input->post('varnish_quantity2');
        $varnish_total=$this->input->post('varnish_total');


        $lamination=$this->input->post('lamination');
        $laminationbatch=$this->input->post('laminationbatch');
        $lamination_unitprice=$this->input->post('lamination_unitprice');
        $lamination_quantity=$this->input->post('lamination_quantity');
        $lamination_quantity2=$this->input->post('lamination_quantity2');
        $lamination_total=$this->input->post('lamination_total');

        $foiling=$this->input->post('foiling');
        $foilingbatch=$this->input->post('foilingbatch');
        $foiling_unitprice=$this->input->post('foiling_unitprice');
        $foiling_quantity=$this->input->post('foiling_quantity');
        $foiling_quantity2=$this->input->post('foiling_quantity2');
        $foiling_total=$this->input->post('foiling_total');

        $rimming=$this->input->post('rimming');
        $rimmingbatch=$this->input->post('rimmingbatch');
        $rimming_unitprice=$this->input->post('rimming_unitprice');
        $rimming_quantity=$this->input->post('rimming_quantity');
        $rimming_total=$this->input->post('rimming_total');

        $cutting=$this->input->post('cutting');
        $cuttingbatch=$this->input->post('cuttingbatch');
        $cutting_unitprice=$this->input->post('cutting_unitprice');
        $cutting_quantity=$this->input->post('cutting_quantity');
        $cutting_total=$this->input->post('cutting_total');


        $pasting=$this->input->post('pasting');
        $pastingbatch=$this->input->post('pastingbatch');
        $pasting_unitprice=$this->input->post('pasting_unitprice');
        $pasting_quantity=$this->input->post('pasting_quantity');
        $pasting_total=$this->input->post('pasting_total');

        $filmchage_unitprice=$this->input->post('filmchage_unitprice');
        $filmchage_quantity=$this->input->post('filmchage_quantity');
        $filmchage_quantity2=$this->input->post('filmchage_quantity2');
        $filmchage_total=$this->input->post('filmchage_total');


        $plates=$this->input->post('plates');
        $platesbatch=$this->input->post('platesbatch');
        $plates_unitprice=$this->input->post('plates_unitprice');
        $plates_quantity=$this->input->post('plates_quantity');
        $plates_total=$this->input->post('plates_total');

        $embosing_price=$this->input->post('embosing_price');
        $embosing_total=$this->input->post('embosing_total');
        $foilingblock_price=$this->input->post('foilingblock_price');
        $foilingblock_total=$this->input->post('foilingblock_total');
        $cutter_price=$this->input->post('cutter_price');
        $cutter_total=$this->input->post('cutter_total');
        $windowpasting_price=$this->input->post('windowpasting_price');
        $windowpasting_total=$this->input->post('windowpasting_total');
        $WindowpatchFilm_price=$this->input->post('WindowpatchFilm_price');
        $Windowpatch_width=$this->input->post('Windowpatch_width');
        $Windowpatch_height=$this->input->post('Windowpatch_height');
        $Windowpatch_total=$this->input->post('Windowpatch_total');
        $boardlamination_price=$this->input->post('boardlamination_price');
        $boardlamination_width=$this->input->post('boardlamination_width');
        $boardlamination_height=$this->input->post('boardlamination_height');
        $boardlamination_total=$this->input->post('boardlamination_total');
        $transport=$this->input->post('transport');
        $transport_total=$this->input->post('transport_total');
        $commision=$this->input->post('commision');
        $commision_total=$this->input->post('commision_total');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'customer_id' => $customer, 
                'customerjob_id' => $customerjob, 
                'customer_jobno' => $jobno, 
                'quantity' => $quantity, 
                'cutsize_width' => $cutsize1, 
                'cutsize_height' => $cutsize2, 
                'no_of_pcts' => $noofpacts, 
                'no_sheet' => $nosheet, 
                'wastage' => $wastage, 
                'board_width' => $boardsize1, 
                'board_height' => $boardsize12, 
                'wastage_board' => $wastageboard, 
                'board_cut1' => $cutsize3, 
                'board_cut2' => $cutsize4, 
                'no_ofcutsheet_perpct' => $cutssheetsper, 
                'no_of_ups' => $noofups, 
                'net_total' => $net_total, 
                'margin' => $margin, 
                'margin_cal' => $margincalculation, 
                'totalwith_margin' => $totalmargin, 
                'valuennew' => $calvalue, 
                'credit' => $credit, 
                'credittotal' => $credittotal, 
                'creditwithtotal' => $creditwithtotal, 
                'vat' => $vat, 
                'vat2' => $vat2, 
                'vat_count' => $vatcount, 
                'total_with_vat' => $tptalwithvat, 
                'status' => 1,
                'tbl_print_material_info_idtbl_print_material_info' => $boardpaper,
                'tbl_printing_format_idtbl_printing_format' => $printformat,
                'createdatetime' => $insertdatetime,
                'updatedatetime' => 0,
                'tbl_user_idtbl_user' => $userID,
            );
            
            $this->db->insert('tbl_jobquatation', $data);
            $insert_id = $this->db->insert_id();

            // add board/paper details into database
            if($boardpaperselect != ''){
                $materialdata = array(
                'batch_id' => $boardpaperbatch, 
                'unit_price' => $board_unitprice, 
                'board_width' => $board_quantity, 
                'board_height' => $board_quantity2, 
                'total' => $board_total, 
                'status' => 1,
                'tbl_print_material_info_idtbl_print_material_info' => $boardpaperselect,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'insertdatetime' => $insertdatetime,
                'updatedatetime' => 0,
                'tbl_user_idtbl_user' => $userID,
                );
                $this->db->insert('tbl_jobquatation_material_detail', $materialdata);
            }

            // add wastage details into database
            if($wastagelist != ''){
                $wastagedata = array(
                'wastage' => $wastagelist, 
                'wastage_cal1' => $wastage_cal1, 
                'wastage_cal2' => $wastage_cal2, 
                'total' => $wastage_total, 
                'status' => 1,
                'insertdatetime' => $insertdatetime,
                'updatedatetime' => 0,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                );
                $this->db->insert('tbl_jobquotation_wastage_details', $wastagedata);
            }

            // add color details into database
            if($colors != ''){
                $colorsdata = array(
                'batch_id' => $colorsbatch, 
                'unit_price' => $colors_unitprice, 
                'qty' => $colors_quantity, 
                'total' => $colors_total, 
                'status' => 1,
                'insertdatetime' => $insertdatetime,
                'updatedatetime' => 0,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_print_color_idtbl_print_color' => $colors,
                );
                $this->db->insert('tbl_jobquotation_color_details', $colorsdata);
            }

             // add varnish details into database
            if($varnish != ''){
                $varnishdata = array(
                'batch_id' => $varnishbatch, 
                'unit_price' => $varnish_unitprice, 
                'qty1' => $varnish_quantity, 
                'qty2' => $varnish_quantity2, 
                'total' => $varnish_total, 
                'status' => 1,   
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_varnish_idtbl_varnish' => $varnish,
                );
                $this->db->insert('tbl_jobquotation_varnish_details', $varnishdata);
            }
  
            // add laminaion details into database
            if($lamination != ''){
                $laminaiondata = array(
                'batch_id' => $laminationbatch, 
                'unit_price' => $lamination_unitprice, 
                'qty1' => $lamination_quantity, 
                'qty2' => $lamination_quantity2, 
                'total' => $lamination_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_lamination_idtbl_lamination' => $lamination,
                );
                $this->db->insert('tbl_jobquotation_lamination_details', $laminaiondata);
            }

            // add foiling details into database
            if($foiling != ''){
                $foilingdata = array(
                'batch_id' => $foilingbatch, 
                'unit_price' => $foiling_unitprice, 
                'qty1' => $foiling_quantity, 
                'qty2' => $foiling_quantity2, 
                'total' => $foiling_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_foiling_idtbl_foiling' => $foiling,
                
                );
                $this->db->insert('tbl_jobquotation_foiling_details', $foilingdata);
            }

            // add rimming details into database
            if($rimming != ''){
                $rimmingdata = array(
                'batch_id' => $rimmingbatch, 
                'unit_price' => $rimming_unitprice, 
                'qty' => $rimming_quantity, 
                'total' => $rimming_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_rimming_idtbl_rimming' => $rimming,
                
                );
                $this->db->insert('tbl_jobquotation_rimming_details', $rimmingdata);
            }

            // add cutting details into database
            if($cutting != ''){
                $cuttingdata = array(
                'batch_id' => $cuttingbatch, 
                'unit_price' => $cutting_unitprice, 
                'qty' => $cutting_quantity, 
                'total' => $cutting_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_diecutting_idtbl_diecutting' => $cutting,
                );
                $this->db->insert('tbl_jobquotation_diecutting_details', $cuttingdata);
            }

            // add pasting details into database
            if($pasting != ''){
                $pastingdata = array(
                'batch_id' => $pastingbatch, 
                'unit_price' => $pasting_unitprice, 
                'qty' => $pasting_quantity, 
                'total' => $pasting_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                'tbl_pasting_idtbl_pasting' => $pasting,
                );
                $this->db->insert('tbl_jobquotation_pasting_details', $pastingdata);
            }

            // add filmchage details into database
            if($filmchage_unitprice != ''){
                $filmchagedata = array(
                'unit_price' => $filmchage_unitprice, 
                'qty' => $filmchage_quantity, 
                'qty2' => $filmchage_quantity2, 
                'total' => $filmchage_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                );
                $this->db->insert('tbl_jobquotation_filmcharge_details', $filmchagedata);
            }

            // add plates details into database
            if($plates != ''){
                $platesdata = array(
                'batch_id' => $platesbatch, 
                'unit_price' => $plates_unitprice, 
                'qty' => $plates_quantity, 
                'total' => $plates_total, 
                'status' => 1,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_plates_idtbl_plates' => $plates,
                'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                );
                $this->db->insert('tbl_jobquotation_plates_details', $platesdata);
            }

            // add other details into database
            if($embosing_price != '' || $foilingblock_price != '' || $cutter_price != '' || $windowpasting_price != ''|| $WindowpatchFilm_price != ''
             ||$boardlamination_price != '' ||$transport != '' ||$commision != ''){

                $otherdata = array(
                    'embosing_block_amount' => $embosing_price,
                    'embosing_block_total' => $embosing_total,
                    'foiling_block_amount' => $foilingblock_price,
                    'foiling_block_total' => $foilingblock_total,
                    'cutter_amount' => $cutter_price,
                    'cutter_total' => $cutter_total,
                    'window_pasting_amount' => $windowpasting_price,
                    'window_pasting_total' => $windowpasting_total,
                    'window_patch_film_amount' => $WindowpatchFilm_price,
                    'window_patch_film_width' => $Windowpatch_width,
                    'window_patch_film_height' => $Windowpatch_height,
                    'window_patch_film_total' => $Windowpatch_total,
                    'board_lamination_amount' => $boardlamination_price,
                    'board_lamination_width' => $boardlamination_width,
                    'board_lamination_height' => $boardlamination_height,
                    'board_lamination_total' => $boardlamination_total,
                    'transport_amount' => $transport,
                    'transport_total' => $transport_total,
                    'commision_amount' => $commision,
                    'commision_total' => $commision_total,
                    'status' => 1,
                    'updatedatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_jobquatation_idtbl_jobquatation' => $insert_id,
                );
                
                $this->db->insert('tbl_jobquotation_other_details', $otherdata);
                
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

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Quatation/index');                
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
                redirect('Quatation/index');
            }
        }

        else{
            $materialrow_id=$this->input->post('materialrow_id');
            $wastagerow_id=$this->input->post('wastagerow_id');
            $colorrow_id=$this->input->post('colorrow_id');
            $varnishrow_id=$this->input->post('varnishrow_id');
            $laminationrow_id=$this->input->post('laminationrow_id');
            $foliingrow_id=$this->input->post('foliingrow_id');
            $rimmingrow_id=$this->input->post('rimmingrow_id');
            $cuttingrow_id=$this->input->post('cuttingrow_id');
            $pastingrow_id=$this->input->post('pastingrow_id');
            $filmchrgerow_id=$this->input->post('filmchrgerow_id');
            $platesrow_id=$this->input->post('platesrow_id');
            $otherchargerow_id=$this->input->post('otherchargerow_id');

            $data = array(
                'quantity' => $quantity, 
                'cutsize_width' => $cutsize1, 
                'cutsize_height' => $cutsize2, 
                'no_of_pcts' => $noofpacts, 
                'no_sheet' => $nosheet, 
                'wastage' => $wastage, 
                'board_width' => $boardsize1, 
                'board_height' => $boardsize12, 
                'wastage_board' => $wastageboard, 
                'board_cut1' => $cutsize3, 
                'board_cut2' => $cutsize4, 
                'no_ofcutsheet_perpct' => $cutssheetsper, 
                'no_of_ups' => $noofups, 
                'net_total' => $net_total, 
                'margin' => $margin, 
                'margin_cal' => $margincalculation, 
                'totalwith_margin' => $totalmargin, 
                'valuennew' => $calvalue, 
                'credit' => $credit, 
                'credittotal' => $credittotal, 
                'creditwithtotal' => $creditwithtotal, 
                'vat' => $vat, 
                'vat2' => $vat2, 
                'vat_count' => $vatcount, 
                'total_with_vat' => $tptalwithvat, 
                'tbl_print_material_info_idtbl_print_material_info' => $boardpaper,
                'tbl_printing_format_idtbl_printing_format' => $printformat,
                'updatedatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
            );

            $this->db->where('idtbl_jobquatation', $recordID);
            $this->db->update('tbl_jobquatation', $data);

            if($boardpaperselect != ''){
                if( $materialrow_id != ''){

                    $materialdata = array(
                        'batch_id' => $boardpaperbatch, 
                        'unit_price' => $board_unitprice, 
                        'board_width' => $board_quantity, 
                        'board_height' => $board_quantity2, 
                        'total' => $board_total, 
                        'tbl_print_material_info_idtbl_print_material_info' => $boardpaperselect,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        );

                         $this->db->where('idtbl_jobquatation_material_detail', $materialrow_id);
                         $this->db->update('tbl_jobquatation_material_detail', $materialdata);

                }else{
                    $materialdata = array(
                        'batch_id' => $boardpaperbatch, 
                        'unit_price' => $board_unitprice, 
                        'board_width' => $board_quantity, 
                        'board_height' => $board_quantity2, 
                        'total' => $board_total, 
                        'status' => 1,
                        'tbl_print_material_info_idtbl_print_material_info' => $boardpaperselect,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'insertdatetime' => $insertdatetime,
                        'updatedatetime' => 0,
                        'tbl_user_idtbl_user' => $userID,
                        );
                        $this->db->insert('tbl_jobquatation_material_detail', $materialdata);
                }
            }

            if($wastagelist != ''){
                if( $wastagerow_id != ''){
                    $wastagedata = array(
                        'wastage' => $wastagelist, 
                        'wastage_cal1' => $wastage_cal1, 
                        'wastage_cal2' => $wastage_cal2, 
                        'total' => $wastage_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        );
                         $this->db->where('idtbl_jobquotation_wastage_details', $wastagerow_id);
                         $this->db->update('tbl_jobquotation_wastage_details', $wastagedata);

                }else{
                    $wastagedata = array(
                        'wastage' => $wastagelist, 
                        'wastage_cal1' => $wastage_cal1, 
                        'wastage_cal2' => $wastage_cal2, 
                        'total' => $wastage_total, 
                        'status' => 1,
                        'insertdatetime' => $insertdatetime,
                        'updatedatetime' => 0,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        );
                        $this->db->insert('tbl_jobquotation_wastage_details', $wastagedata);
                }
            }

            if($colors != ''){
                if( $colorrow_id != ''){
                    $colorsdata = array(
                        'batch_id' => $colorsbatch, 
                        'unit_price' => $colors_unitprice, 
                        'qty' => $colors_quantity, 
                        'total' => $colors_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_print_color_idtbl_print_color' => $colors );
                         $this->db->where('idtbl_jobquotation_color_details', $colorrow_id);
                         $this->db->update('tbl_jobquotation_color_details', $colorsdata);

                }else{
                    $colorsdata = array(
                        'batch_id' => $colorsbatch, 
                        'unit_price' => $colors_unitprice, 
                        'qty' => $colors_quantity, 
                        'total' => $colors_total, 
                        'status' => 1,
                        'insertdatetime' => $insertdatetime,
                        'updatedatetime' => 0,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'tbl_print_color_idtbl_print_color' => $colors,
                        );
                        $this->db->insert('tbl_jobquotation_color_details', $colorsdata);
                }
            }

            if($varnish != ''){
                if( $varnishrow_id != ''){
                    $varnishdata = array(
                        'batch_id' => $varnishbatch, 
                        'unit_price' => $varnish_unitprice, 
                        'qty1' => $varnish_quantity, 
                        'qty2' => $varnish_quantity2, 
                        'total' => $varnish_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_varnish_idtbl_varnish' => $varnish );
                         $this->db->where('idtbl_jobquotation_varnish_details', $varnishrow_id);
                         $this->db->update('tbl_jobquotation_varnish_details', $varnishdata);

                }else{
                    $varnishdata = array(
                        'batch_id' => $varnishbatch, 
                        'unit_price' => $varnish_unitprice, 
                        'qty1' => $varnish_quantity, 
                        'qty2' => $varnish_quantity2, 
                        'total' => $varnish_total, 
                        'status' => 1,   
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'tbl_varnish_idtbl_varnish' => $varnish,
                        );
                        $this->db->insert('tbl_jobquotation_varnish_details', $varnishdata);
                }
            }

            if($lamination != ''){
                if( $laminationrow_id != ''){
                    $laminaiondata = array(
                        'batch_id' => $laminationbatch, 
                        'unit_price' => $lamination_unitprice, 
                        'qty1' => $lamination_quantity, 
                        'qty2' => $lamination_quantity2, 
                        'total' => $lamination_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_lamination_idtbl_lamination' => $lamination,
                        );
                         $this->db->where('idtbl_jobquotation_lamination_details', $laminationrow_id);
                         $this->db->update('tbl_jobquotation_lamination_details', $laminaiondata);

                }else{
                    $laminaiondata = array(
                        'batch_id' => $laminationbatch, 
                        'unit_price' => $lamination_unitprice, 
                        'qty1' => $lamination_quantity, 
                        'qty2' => $lamination_quantity2, 
                        'total' => $lamination_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'tbl_lamination_idtbl_lamination' => $lamination,
                        );
                        $this->db->insert('tbl_jobquotation_lamination_details', $laminaiondata);
                }
            }

            if($foiling != ''){
                if( $foliingrow_id != ''){

                    $foilingdata = array(
                        'batch_id' => $foilingbatch, 
                        'unit_price' => $foiling_unitprice, 
                        'qty1' => $foiling_quantity, 
                        'qty2' => $foiling_quantity2, 
                        'total' => $foiling_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_foiling_idtbl_foiling' => $foiling,
                        );
                         $this->db->where('idtbl_jobquotation_foiling_details', $foliingrow_id);
                         $this->db->update('tbl_jobquotation_foiling_details', $foilingdata);

                }else{
                    $foilingdata = array(
                        'batch_id' => $foilingbatch, 
                        'unit_price' => $foiling_unitprice, 
                        'qty1' => $foiling_quantity, 
                        'qty2' => $foiling_quantity2, 
                        'total' => $foiling_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'tbl_foiling_idtbl_foiling' => $foiling,
                        );
                        $this->db->insert('tbl_jobquotation_foiling_details', $foilingdata);
                }
            }
            if($rimming != ''){
                if( $rimmingrow_id != ''){

                    $rimmingdata = array(
                        'batch_id' => $rimmingbatch, 
                        'unit_price' => $rimming_unitprice, 
                        'qty' => $rimming_quantity, 
                        'total' => $rimming_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_rimming_idtbl_rimming' => $rimming );

                         $this->db->where('idtbl_jobquotation_rimming_details', $rimmingrow_id);
                         $this->db->update('tbl_jobquotation_rimming_details', $rimmingdata);

                }else{
                       $rimmingdata = array(
                            'batch_id' => $rimmingbatch, 
                            'unit_price' => $rimming_unitprice, 
                            'qty' => $rimming_quantity, 
                            'total' => $rimming_total, 
                            'status' => 1,
                            'updatedatetime' => $insertdatetime,
                            'tbl_user_idtbl_user' => $userID,
                            'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                            'tbl_rimming_idtbl_rimming' => $rimming,
                );
                $this->db->insert('tbl_jobquotation_rimming_details', $rimmingdata);
                }
            }

            if($cutting != ''){
                if( $cuttingrow_id != ''){
                    $cuttingdata = array(
                    'batch_id' => $cuttingbatch, 
                    'unit_price' => $cutting_unitprice, 
                    'qty' => $cutting_quantity, 
                    'total' => $cutting_total, 
                    'updatedatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_diecutting_idtbl_diecutting' => $cutting );
                    
                    $this->db->where('idtbl_jobquotation_diecutting_details', $cuttingrow_id);
                    $this->db->update('tbl_jobquotation_diecutting_details', $cuttingdata);

                }else{
                    $cuttingdata = array(
                        'batch_id' => $cuttingbatch, 
                        'unit_price' => $cutting_unitprice, 
                        'qty' => $cutting_quantity, 
                        'total' => $cutting_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'tbl_diecutting_idtbl_diecutting' => $cutting );

                        $this->db->insert('tbl_jobquotation_diecutting_details', $cuttingdata);

                }
            }
            
            if($pasting != ''){
                if( $pastingrow_id != ''){
                    $pastingdata = array(
                        'batch_id' => $pastingbatch, 
                        'unit_price' => $pasting_unitprice, 
                        'qty' => $pasting_quantity, 
                        'total' => $pasting_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_pasting_idtbl_pasting' => $pasting,
                        );
                         $this->db->where('idtbl_jobquotation_pasting_details', $pastingrow_id);
                         $this->db->update('tbl_jobquotation_pasting_details', $pastingdata);

                }else{
                    $pastingdata = array(
                        'batch_id' => $pastingbatch, 
                        'unit_price' => $pasting_unitprice, 
                        'qty' => $pasting_quantity, 
                        'total' => $pasting_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        'tbl_pasting_idtbl_pasting' => $pasting,
                        );
                        $this->db->insert('tbl_jobquotation_pasting_details', $pastingdata);
                }
            }

            if($filmchage_unitprice != ''){
                if( $filmchrgerow_id != ''){

                    $filmchagedata = array(
                        'unit_price' => $filmchage_unitprice, 
                        'qty' => $filmchage_quantity, 
                        'qty2' => $filmchage_quantity2, 
                        'total' => $filmchage_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID );

                         $this->db->where('idtbl_jobquotation_filmcharge_details', $materialrow_id);
                         $this->db->update('tbl_jobquotation_filmcharge_details', $materialdata);

                }else{
                    $filmchagedata = array(
                        'unit_price' => $filmchage_unitprice, 
                        'qty' => $filmchage_quantity, 
                        'qty2' => $filmchage_quantity2, 
                        'total' => $filmchage_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                        );
                        $this->db->insert('tbl_jobquotation_filmcharge_details', $filmchagedata);
                }
            }

           if($plates != ''){
                if( $platesrow_id != ''){

                    $platesdata = array(
                        'batch_id' => $platesbatch, 
                        'unit_price' => $plates_unitprice, 
                        'qty' => $plates_quantity, 
                        'total' => $plates_total, 
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_plates_idtbl_plates' => $plates );
                  
                         $this->db->where('idtbl_jobquotation_plates_details', $platesrow_id);
                         $this->db->update('tbl_jobquotation_plates_details', $platesdata);
                }else{
                    $platesdata = array(
                        'batch_id' => $platesbatch, 
                        'unit_price' => $plates_unitprice, 
                        'qty' => $plates_quantity, 
                        'total' => $plates_total, 
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_plates_idtbl_plates' => $plates,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID );

                        $this->db->insert('tbl_jobquotation_plates_details', $platesdata);
                }
          }

           if($embosing_price != '' || $foilingblock_price != '' || $cutter_price != '' || $windowpasting_price != ''|| $WindowpatchFilm_price != ''
             ||$boardlamination_price != '' ||$transport != '' ||$commision != ''){
                if( $otherchargerow_id != ''){

                    $otherdata = array(
                        'embosing_block_amount' => $embosing_price,
                        'embosing_block_total' => $embosing_total,
                        'foiling_block_amount' => $foilingblock_price,
                        'foiling_block_total' => $foilingblock_total,
                        'cutter_amount' => $cutter_price,
                        'cutter_total' => $cutter_total,
                        'window_pasting_amount' => $windowpasting_price,
                        'window_pasting_total' => $windowpasting_total,
                        'window_patch_film_amount' => $WindowpatchFilm_price,
                        'window_patch_film_width' => $Windowpatch_width,
                        'window_patch_film_height' => $Windowpatch_height,
                        'window_patch_film_total' => $Windowpatch_total,
                        'board_lamination_amount' => $boardlamination_price,
                        'board_lamination_width' => $boardlamination_width,
                        'board_lamination_height' => $boardlamination_height,
                        'board_lamination_total' => $boardlamination_total,
                        'transport_amount' => $transport,
                        'transport_total' => $transport_total,
                        'commision_amount' => $commision,
                        'commision_total' => $commision_total,
    
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                    );
                         $this->db->where('idtbl_jobquotation_other_details', $otherchargerow_id);
                         $this->db->update('tbl_jobquotation_other_details', $otherdata);

                }else{
                    $otherdata = array(
                        'embosing_block_amount' => $embosing_price,
                        'embosing_block_total' => $embosing_total,
                        'foiling_block_amount' => $foilingblock_price,
                        'foiling_block_total' => $foilingblock_total,
                        'cutter_amount' => $cutter_price,
                        'cutter_total' => $cutter_total,
                        'window_pasting_amount' => $windowpasting_price,
                        'window_pasting_total' => $windowpasting_total,
                        'window_patch_film_amount' => $WindowpatchFilm_price,
                        'window_patch_film_width' => $Windowpatch_width,
                        'window_patch_film_height' => $Windowpatch_height,
                        'window_patch_film_total' => $Windowpatch_total,
                        'board_lamination_amount' => $boardlamination_price,
                        'board_lamination_width' => $boardlamination_width,
                        'board_lamination_height' => $boardlamination_height,
                        'board_lamination_total' => $boardlamination_total,
                        'transport_amount' => $transport,
                        'transport_total' => $transport_total,
                        'commision_amount' => $commision,
                        'commision_total' => $commision_total,
                        'status' => 1,
                        'updatedatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_jobquatation_idtbl_jobquatation' => $recordID,
                    );
                    
                    $this->db->insert('tbl_jobquotation_other_details', $otherdata);
                    
                }
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

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Quatation');                
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
                redirect('Quatation');
            }
        }

    }

    public function Quotationstatus($x, $y){
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

			$this->db->where('idtbl_jobquatation', $recordID);
            $this->db->update('tbl_jobquatation', $data);

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
                redirect('Quatation');                
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
                redirect('Quatation');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_jobquatation', $recordID);
            $this->db->update('tbl_jobquatation', $data);

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
                redirect('Quatation');                
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
                redirect('Quatation');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_jobquatation', $recordID);
            $this->db->update('tbl_jobquatation', $data);

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
                redirect('Quatation');                
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
                redirect('Quatation');
            }
        }
    }


    public function Quotationedit($quotationId)
    {
        // Fetch main quotation details
        $this->db->select('*');
        $this->db->from('tbl_jobquatation');
        $this->db->where('idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query = $this->db->get();
        $quotation = $query->row_array();
    
        // Fetch material details
        $this->db->select('*');
        $this->db->from('tbl_jobquatation_material_detail');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1); 
        $query2 = $this->db->get();
        $materialDetails = $query2->row_array();
    
       // Fetch wastage details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_wastage_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query3 = $this->db->get();
        $wastageDetails = $query3->row_array();

        // Fetch color details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_color_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query4 = $this->db->get();
        $colorDetails = $query4->row_array();

        // Fetch varnish details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_varnish_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query5 = $this->db->get();
        $varnishDetails = $query5->row_array();

        // Fetch lamination details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_lamination_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query6 = $this->db->get();
        $laminationDetails = $query6->row_array();

        // Fetch foiling details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_foiling_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query7 = $this->db->get();
        $foilingDetails = $query7->row_array();

        // Fetch rimming details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_rimming_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query8 = $this->db->get();
        $rimmingDetails = $query8->row_array();

        // Fetch cutting details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_diecutting_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query9 = $this->db->get();
        $cuttingDetails = $query9->row_array();

        // Fetch pasting details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_pasting_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query10 = $this->db->get();
        $pastingDetails = $query10->row_array();

        // Fetch filmcharge details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_filmcharge_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query11 = $this->db->get();
        $filmchargeDetails = $query11->row_array();

        // Fetch plates details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_plates_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query12 = $this->db->get();
        $platesDetails = $query12->row_array();

        // Fetch other details
        $this->db->select('*');
        $this->db->from('tbl_jobquotation_other_details');
        $this->db->where('tbl_jobquatation_idtbl_jobquatation', $quotationId);
        $this->db->where('status', 1);  // Add status check
        $query13 = $this->db->get();
        $otherDetails = $query13->row_array();
    
        return [
            'quotation' => $quotation,
            'materialDetail' => $materialDetails,
            'wastageDetails' => $wastageDetails,
            'colorDetails' => $colorDetails,
            'varnishDetails' => $varnishDetails,
            'laminationDetails' => $laminationDetails,
            'foilingDetails' => $foilingDetails,
            'rimmingDetails' => $rimmingDetails,
            'cuttingDetails' => $cuttingDetails,
            'pastingDetails' => $pastingDetails,
            'filmchargeDetails' => $filmchargeDetails,
            'platesDetails' => $platesDetails,
            'otherDetails' => $otherDetails,
        ];
    }


    }
