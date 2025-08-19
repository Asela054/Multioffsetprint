<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfviewinfo extends CI_Model {

    public function pdfdata($x) {

        $recordID=$x;

        $this->db->select('*');
        $this->db->from('tbl_print_dispatch');
		$this->db->join('tbl_print_dispatchdetail', 'tbl_print_dispatch.idtbl_print_dispatch = tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch', 'left');
        $this->db->join('tbl_customer', 'tbl_print_dispatch.customer_id = tbl_customer.idtbl_customer', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_dispatchdetail.measure_id = tbl_measurements.idtbl_mesurements', 'left');

        $this->db->where('tbl_print_dispatch.idtbl_print_dispatch', $recordID);
        
        $query = $this->db->get();

        $this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_dispatch');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_dispatch.company_id', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_dispatch.company_branch_id', 'left');
		$this->db->where('tbl_print_dispatch.idtbl_print_dispatch', $recordID);
		$companydetails = $this->db->get();
        
        $path = 'images/book.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->load->library('pdf');

        
        $options = new Options();
		$options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dispatch Note</title>
            <style>
            @page {
                    size: 220mm 120mm;
                    margin: 5mm 15mm 5mm 5mm; /* top right bottom left */
                }
              body {
               margin: 0;
               /* font-family: "Metropolis", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial,
               sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
               font-family: Arial, sans-serif;
               font-size: 1rem;
               line-height: 1.5;
               text-align:left;
             }
                p {
                    margin-top: 0px;
                    font-size: 12px; 
                    line-height: 0.1px;               
                }
                .pheader {
                    margin-top: 0px;
                    font-size: 12px;
                    border-collapse: collapse;
                    line-height: 0.1px;
                }
                .tablec {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 1px;
                }
                .thc, .tdc {
                    padding: 2px;
                    text-align: left;
                    border: 1px solid black;
                    font-size: 12px;
                }
                .thc {
                    background-color: white;
                    font: Arial, sans-serif;
                }
                hr {
                    border: 1px solid #ddd;
                }
                .postion {
                    position: relative;
                    font-size: 12px;
                }
                .pos{
                    padding-bottom: -20px; 
                }
                .footer{
					position: fixed;
                    bottom: 100px;
					font-size: 14px;
                    box-sizing: content-box;
				}
            </style>
        </head>
        <body>

            <table style="width:100%;">
                <tr>
                    <td style="text-align: left;vertical-align: top;">
                        <h3 style="font-size:15px;  font-weight:bold;margin-top:-10px;  font-family: Arial, sans-serif;">ADVICE OF DESPATCH</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:-20px;   font-family: Arial, sans-serif;">To : '.$query->row(0)->name.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:25px; font-family: Arial, sans-serif;">'. $query->row()->address_line1 .',</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:25px; font-family: Arial, sans-serif;">'. $query->row()->address_line2 .' ,</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:25px; font-family: Arial, sans-serif;">'. $query->row()->city .' .</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:25px; font-family: Arial, sans-serif;">'. $query->row()->state .' </h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:25px; font-family: Arial, sans-serif;">'. $query->row()->telephone_no .' </h3>

                   
                    </td>
                    <td style="text-align: left;vertical-align: top;">
                        <h3 style="font-size:15px;  font-weight:bold;margin-top:-10px;margin-left:320px;  font-family: Arial, sans-serif;">'.$companydetails->row()->companyname.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-20px;margin-left:320px;   font-family: Arial, sans-serif;">'.$companydetails->row()->companyaddress.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:320px;margin-bottom:20px;   font-family: Arial, sans-serif;">Phone : '.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'&nbsp;&nbsp;&nbsp; E-Mail : '.$companydetails->row()->companyemail.'</h3>

                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-0px;margin-left:320px;   font-family: Arial, sans-serif;">Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '. $query->row()->date .'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-14px;margin-left:320px;   font-family: Arial, sans-serif;">Dispatch No : &nbsp;&nbsp;&nbsp;&nbsp;DPN000'. $query->row()->idtbl_print_dispatch .'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-14px;margin-left:320px;   font-family: Arial, sans-serif;">PO No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $query->row()->ponum .'</h3>
                    </td>
                </tr>
        </table>

            <table border="0" width="100%" style="margin-top:5px;">

                <tr>
                   <td colspan="3" style="text-align: center; font-size: 10px; padding: 1px; font-weight: bold;">(Please accept the following and return the DUPLICATE COPY)</td>
                </tr>

                <tr>
                    <td colspan="3" >
                        <table class="tablec">
                            <thead class="thc">
                                <tr>
                                    <th class="thc" style="text-align:left;font-size: 12px;" width="30%"><strong>Job</strong></th>
                                    <th class="thc" style="text-align:center;font-size: 12px;" width="15%"><strong>Job Number</strong></th>
                                    <th class="thc" style="text-align:center;font-size: 12px;" width="15%"><strong>Quantity</strong></th>
                                    <th class="thc" style="text-align:center;font-size: 12px;" width="15%"><strong>Measure type</strong></th>
                                    <th class="thc" width="25%" style="text-align:center;font-size: 12px;"><strong>Remark</strong></th>
                                </tr>
                            </thead>
                            <tbody class="tdc">';

                            foreach ($query->result() as $row) {

                               
                                    $html .= '
                                    <tr>
                                    <td class="tdc" style="border-right: 1px solid black; border-top: none; border-bottom: none;">' . $row->job . '</td>
                                    <td class="tdc" style="text-align:center; border-right: 1px solid black; border-top: none; border-bottom: none;">' . $row->job_no . '</td>
                                    <td class="tdc" style="text-align:center; border-right: 1px solid black; border-top: none; border-bottom: none;">' . $row->qty . '</td>
                                    <td class="tdc" style="text-align:center; border-right: 1px solid black; border-top: none; border-bottom: none;">' . $row->measure_type . '</td>
                                    <td class="tdc" style="text-align:center; border-right: 1px solid black; border-top: none; border-bottom: none;">' . $row->comment . '</td>                                    
                                    </tr>';                      
                                }
                        
                            $html .= '

                            </tbody>
                        </table>
                    </td>
                </tr>';
                if (!empty($row->remark)) {
        $html .= '

                
              <tr>
            <td colspan="3">
                <table class="tablec">
                    <thead class="thc">
                        <tr>
                            <td class="tdc" style="border-right: 1px solid black; border-top: none; border-bottom: none;">' . $row->remark . '</td>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>';
    }

$html .= '
   
</table>
<table width="100%" style="border-collapse: collapse;font-size: 12px;margin-top: 20px;">
    <tr>
        <td>Gate pass No  :  ...........................</td>
        <td>&nbsp;</td>
        <td>Vehicle No :  ...................................</td>
    </tr>
    <tr>
        <td style="padding-top: 15px;">Received By:  ............................</td>
        <td style="padding-top: 15px;">Checked By :  ...................................</td>
        <td style="padding-top: 15px;">Date :  ..............................</td>
    </tr>
</table>
            <!--<table class="footer" border="0" width="100%" style="border-collapse: collapse; margin-top: -20px;">
                <tbody>
                    <tr>
                        <td width="33%" style="padding: 12px;">Gate pass No  :  ...........................</td>
                        <td width="34%" style="padding: 12px;"></td>
                        <td width="33%" style="padding: 12px;">Vehicle No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  ...................................</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px;">Received By &nbsp; :  ............................</td>
                        <td style="padding: 12px;">Checked By&nbsp;&nbsp;&nbsp;&nbsp;:  ...................................</td>
                        <td style="padding: 12px;">Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  :  ..............................</td>
                    </tr>
                </tbody>-->
          </table>
        
        </body>
        </html>
        ';  

        // $width = 21.5 * 72 / 2.54; // 21.5 cm in points
        // $height = 14 * 72 / 2.54;  // 14 cm in points
        
        $dompdf->loadHtml($html);
        // $dompdf->setPaper(array(0, 0, $width, $height), 'portrait');
        $dompdf->render();
        $dompdf->stream("Dispatch Note - ". $recordID .".pdf", ["Attachment"=>0]);
        
        
    }

}