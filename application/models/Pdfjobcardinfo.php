<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfjobcardinfo extends CI_Model {

    public function pdfgrnget($x) {

            $recordID=$x;
    
            $this->db->select('*');
            $this->db->from('tbl_customerinquiry');
            // $this->db->join('tbl_print_porder_req_detail', 'idtbl_print_porder_req = tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', 'left');
            // $this->db->join('tbl_order_type', 'tbl_print_porder_req.tbl_order_type_idtbl_order_type = tbl_order_type.idtbl_order_type', 'left');
            // $this->db->join('tbl_service_type', 'tbl_print_porder_req_detail.tbl_service_type_id = tbl_service_type.idtbl_service_type', 'left');
            // $this->db->join('tbl_machine', 'tbl_print_porder_req_detail.tbl_machine_id = tbl_machine.idtbl_machine', 'left');
            // $this->db->join('tbl_print_material_info', 'tbl_print_porder_req_detail.tbl_material_id = tbl_print_material_info.idtbl_print_material_info', 'left');
            // $this->db->join('tbl_supplier', 'tbl_print_porder_req.tbl_supplier_idtbl_supplier  = tbl_supplier.idtbl_supplier', 'left');
            // $this->db->join('tbl_measurements', 'tbl_print_porder_req_detail.measure_type_id = tbl_measurements.idtbl_mesurements', 'left');
            $this->db->where('tbl_customerinquiry.idtbl_customerinquiry', $recordID);
            
            
    
            // $path = 'images/book.jpg';
            // $type = pathinfo($path, PATHINFO_EXTENSION);
            // $data = file_get_contents($path);
            // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    
            $this->load->library('pdf');
    
            $fontDir = 'fonts/';
            $options = new Options();
            $options->set('fontDir', $fontDir);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
    
            $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Job Card</title>
                <style>
                    @font-face {
                        font-family: "comicz";
                        src: url("' . $fontDir . 'comicz.ttf");
                    }
                    @font-face {
                        font-family: "RussoOne";
                        src: url("' . $fontDir . 'RussoOne.ttf");
                    }
                     body {
               margin: 0;
               /* font-family: "Metropolis", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial,
               sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
               font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                   sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
               font-size: 1rem;
               font-weight: 400;
               line-height: 1.5;
               color: #687281;
               text-align:left;
             }
                    p {
                        font-size: 14px;
                        line-height: 3px;
                    }
                    .pheader {
                        font-size: 12px;
                        line-height: 1.5px;
                    }
                    .tablec {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    .thc, .tdc {
                        padding: 5px;
                        text-align: left;
                        border: 1px solid black;
                    }
                    .thc {
                        background-color: #f2f2f2;
                        font: RussoOne;
                    }
                    hr {
                        border: 1px solid #ddd;
                    }
                    .postion {
                        position: relative;

                    }
                    .pos{
                        padding-bottom: -20px; 
                    }
                    .hedfont {
                        font: 20px comicz;
                    }
                </style>
            </head>
            <body>
    
                <table style="width:100%;">
                    <tr>
                        <td style="width: 100%;text-align: center;">
                            <h2 style="font-size:18px;  font-weight:bold;margin-top:-10px;  font-family: Arial, sans-serif;">MULTI GROUP OF COMPANIES</h2>
                            <h2 style="font-size:15px;  font-weight:bold;margin-top:-10px;   font-family: Arial, sans-serif;">JOB CARD<</h2>
                        </td>
                    </tr>
                </table> 
                <table style="width:100%;">
                        <tr>
                        <td style="width: 50%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">To : The Works Manager,</h3>
                        </td>
                        <td style="width: 40%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:145px;  font-family: Arial, sans-serif;">345,Mukalangamuwa</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:-10px;margin-left:145px;   font-family: Arial, sans-serif;">Seeduwa</h3>
                        </td>   
                      
                        </tr>
                </table>
                <table style="width:100%;">
                        <tr>
                        <td style="width: 60%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:-5px;margin-left:145px;  font-family: Arial, sans-serif;">Order No: .............................................. of ..............................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:0px;margin-left:145px;   font-family: Arial, sans-serif;">Description: .............................................................................................</h3>
                        </td>   
                        </tr>
                </table>
                <table style="width:100%;">
                        <tr>
                        <td style="width: 50%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Please execute the following order as per instructions given,as early as possible.</h3>
                        </td>
                        </tr>
                </table>
                <table style="width:100%;">
                        <tr>
                        <td style="width: 50%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Name of Customer</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Address</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Description & Quantity</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Quantity of Paper / Board to be Issued</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Size of Paper / Board</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">No. of Colours</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Any Other Impression</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">No. of Labels / Cartons per Sheet</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Specimens</h3>
                        </td>
                        <td style="width: 50%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;   font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;   font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;   font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;   font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:-10px;margin-left:-60px;   font-family: Arial, sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( To be Perforated / Punched / Paste ) </h3>
                            </td>
                        </tr>
                </table>

                <table style="width:100%;">
                        <tr>
                        <td style="width: 50%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Proof to be Approved before</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Additional Instructions</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:40px;   font-family: Arial, sans-serif;">............................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Date</h3>
                        </td>
                        <td style="width: 50%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;   font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;   font-family: Arial, sans-serif;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.......................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;margin-left:-60px;  font-family: Arial, sans-serif;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Manager
                </table>
                <hr>
                <table style="width:100%;">
                    <tr>
                        <td style="width: 100%;text-align: center;">
                            <h2 style="font-size:15px;  font-weight:bold;margin-top:-10px;  font-family: Arial, sans-serif;">( FOR FACTORY USE ONLY )</h2>
                            
                        </td>
                    </tr>
                </table> 
                <table style="width:100%;">
                        <tr>
                        <td style="width: 100%;text-align: left;vertical-align: top;">
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Order received on ................................................... date of 1 st Colour started .................................................. date of</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">last Colour finished ................................................... date of delivery .......................................................... the above</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">order NEW / REPEAT / POSITIVES / BLOCKS / DESIGN / TO BE PREPARED and given to the Art </h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Department / Printing Department for Printing /Processing. Job given to Mr................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">......................................................... Machine No :............................................................ on .............................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">quantity of Paper / Board issued ......................................................................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:20px;   font-family: Arial, sans-serif;">............................................... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.............................................</h3>
                            <h3 style="font-size:12px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supervisor</h3>
                
                        
                        </tr>
                </table>
                
            </body>
            </html>
            ';  
    
           // $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream("Job Card- ". $recordID .".pdf", ["Attachment"=>0]);
        }
    
    }