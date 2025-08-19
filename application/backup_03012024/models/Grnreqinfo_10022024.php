<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Grnreqinfo extends CI_Model {

    public function Printinvoice($x){
        $recordID=$x;

        $this->db->select('*');
        $this->db->from('tbl_grn_req');
		$this->db->join('tbl_grn_req_detail', 'tbl_grn_req.idtbl_grn_req = tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req', 'left');
        $this->db->join('tbl_machine', 'tbl_grn_req_detail.tbl_machine_id = tbl_machine.idtbl_machine', 'left');
        $this->db->join('tbl_measurements', 'tbl_grn_req_detail.tbl_measurements_id = tbl_measurements.idtbl_mesurements', 'left');
        $this->db->join('tbl_location', 'tbl_grn_req.company_id = tbl_location.idtbl_location', 'left');
        $this->db->join('departments', 'tbl_grn_req.departments_id = departments.id', 'left');
        $this->db->join('tbl_order_type', 'tbl_grn_req.tbl_order_type_idtbl_order_type = tbl_order_type.idtbl_order_type', 'left');
        $this->db->where('tbl_grn_req.idtbl_grn_req', $recordID);
        
        $query = $this->db->get();
        
        $path = 'images/book.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

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
                    <title>Multi Offset Printers (Pvt) Ltd</title>
                  <style>
						@font-face {
							font-family: "comicz";
							src: url("' . $fontDir . 'comicz.ttf");
						}
						@font-face {
							font-family: "RussoOne";
							src: url("' . $fontDir . 'RussoOne.ttf");
						}

                        body{
                            font-family: Arial, sans-serif;
                            margin: 0px; 
                            padding: 0px;
                        }
        
                        .container {
							display: flex; 
							width: 100%;
							justify-content: center; 
							align-items: center; 
							flex-wrap: wrap; 
						}

                        .logo {
							width: 100%; 
							float: left;
							margin-left: 30px;
						}
								
                        .contact-details {
							float: center;
                            text-align: center; 
                            width: 100%; 
							margin-top: 0px;
                        }
        
                        .name {
							font-size: 1.3rem;
                            margin-top: 1px;
							line-height: 1px;
                        
                        }
        
                        .address {
                            font-size: 0.75rem;
                            line-height: 0.2px;
                        }
        
                        .phone{
                            font-size: 0.75rem;
                            line-height: 0.2px;
                        }
        
                        .mail{
                            font-size: 0.75rem;
                            line-height: 0.2px;
                        }
        
                        .fax{
							font-size: 0.75rem;
                            line-height: 0.2px;
                        }
        
                        .grn {
							font: comicz;
							width: 100%;
							font-size: 1.4rem;
							text-align: left; 
						}

						.grn2 {
                            font-size: 1rem;
                            line-height: 5px;

						}	

						.company{
							font-size: 1rem;
                            line-height: 5px;
						}				
						
						.department{
							font-size: 1rem;
                            line-height: 5px;
						}

						.ordertype {
							font-size: 1rem;
							line-height: 9px;

						}

						.table2 {
							width: 100%;
							border-collapse: collapse; 
							border: none;
							margin-top: 130px;
						}
						
						.table2 td {
							border: none;
						}
						
						.table2 h3 {
							margin: 0;
						}

						table {
							border-collapse: collapse;
							width: 100%; 
							margin-top: 23px;
							margin-left: 4px;
						}

                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                      
                        }

                        th {
                            background-color: #f2f2f2;
                        }

						hr {
							color: #ddd;
							width: 100%;
							margin-top: 3px;
						}
						.hedfont {
							font: 21px comicz;
						}
						.textfont {
							font: RussoOne;
						}
		
                  </style>
             </head>
             
			 
			 <body>
                 <div class="container">
                     <div class="logo">
                           <img src="' . $base64 . '" width="135">
                     </div>
                     <div class="contact-details">
                            <p class="name"><i><strong>MULTI OFFSET PRINTERS (PVT) LTD</strong></i></p>
                            <p class="address"><i>345, NEGOMBO ROAD MUKALANGAMUWA, SEEDUWA</i></p>
                            <p class="phone"><i>Phone: +94-11-2253505, 2253876, 2256615</i></p>
                            <p class="mail"><i>E-Mail: multioffsetprinters@gmail.com</i></p>
                            <p class="fax"><i>Fax: +94-11-2254057</i></p>
                      </div>
					  <table class="table2" width="100%" border="0" cellspacing="0">
							<tr>
								<td class="grn"><h3 class="hedfont">Good Receive Note Request</h3></td>
							</tr>
							<tr>
								<td valign="top">
									<p class="grn2">MO/GRNR-0000'.$query->row()->idtbl_grn_req.'</p>   
								</td>
								<td align="right" width="50%" valign="top">
									<p class="company"><strong>Company : '.$query->row()->location.'</strong></p>
									<p class="department"><strong>Department : '.$query->row()->name.'</strong></p>
									<p class="ordertype"><strong>Order Type : '.$query->row()->type.'</strong></p>
								</td>
							</tr>
				     </table>
				  </div>
				 
				 <hr>

                  <div> 
                      <table>
                          <tr>
							 <th width="50%"><strong class="textfont">Item</strong></th>
							 <th  style="text-align: center;" width="25%"><strong class="textfont">Qty</strong></th>  
							 <th  style="text-align: center;" width="25%"><strong class="textfont">Measurement</strong></th>               
                           </tr>

						  <tbody>';

								if ($query->row()->tbl_order_type_idtbl_order_type == 2) {
									$itemtype = "Service";
								} elseif ($query->row()->tbl_order_type_idtbl_order_type == 3) {
									$itemtype = "Material";
								} else {
									$itemtype = "Machine";
								}

								foreach ($query->result() as $row) {
								$html .= '
									<tr>
									<td>'. $row->machine . ' / ' . $row->machinecode .' - ' . $row->type .'</td>
									<td style="text-align: center;">'.$query->row()->qty.'</td>
									<td style="text-align: center;">'.$query->row()->measure_type.'</td>
									</tr>';
								}
								$html .= '

                            </tbody>
                     </table>
                  </div>
        
              </body>
         </html>
        
        ';
         
		// $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Good Receive Note Request - '.$recordID.'.pdf', ["Attachment"=>0]);
    }

}
