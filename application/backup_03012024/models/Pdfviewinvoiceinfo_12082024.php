<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfviewinvoiceinfo extends CI_Model {

    public function pdfdata($x) {

        $recordID=$x;

		$this->db->select('*, COALESCE(tbl_print_invoice.idtbl_print_invoice, 0) AS idtbl_print_invoice, COALESCE(tbl_print_invoice.date, 0) AS invoice_date, COALESCE(tbl_print_invoicedetail.total, 0) AS detail_total, COALESCE(tbl_print_invoice.total, 0) AS net_total, COALESCE(tbl_customer_job_details.job_name, 0) AS jobname, COALESCE(tbl_print_invoicedetail.unitprice, 0) AS unit_price, COALESCE(tbl_print_invoicedetail.qty, 0) AS quantity, COALESCE(tbl_print_invoicedetail.job, 0) As job, COALESCE(tbl_print_invoicedetail.job_no, 0) As job_no');
        $this->db->from('tbl_print_invoice');
		$this->db->join('tbl_print_invoicedetail', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoicedetail.tbl_print_invoice_idtbl_print_invoice', 'left');

		$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_print_invoicedetail.job_id', 'left');
		$this->db->join('tbl_customer_job_details', 'tbl_customer_job_details.idtbl_customer_job_details = tbl_customerinquiry_detail.job_id', 'left');


        $this->db->join('tbl_customer', 'tbl_print_invoice.customer_id = tbl_customer.idtbl_customer', 'left');
        $this->db->join('tbl_print_dispatch', 'tbl_print_invoice.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_invoicedetail.measure_id = tbl_measurements.idtbl_mesurements', 'left');

        $this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
        
        $query = $this->db->get();


		$this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_invoice');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_invoice.company_id', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_invoice.company_branch_id', 'left');
		$this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
		$companydetails = $this->db->get();


        $tblcharges='';

		$this->db->select('tbl_print_invoice_charge_detail.charge_amount, tbl_charges.charges_type, tbl_print_invoice.vat, tbl_customer.vat_customer');
		$this->db->from('tbl_print_invoice');
		$this->db->join('tbl_print_invoice_charge_detail', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoice_charge_detail.tbl_print_invoice_idtbl_print_invoice', 'left');
		$this->db->join('tbl_charges', 'tbl_charges.idtbl_charges = tbl_print_invoice_charge_detail.charge_id', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_print_invoice.customer_id', 'left');
		$this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
		$chargesquery = $this->db->get();

		if ($chargesquery->num_rows() > 0) {
			$charges = $chargesquery->result_array();
			
			foreach ($charges as $rowlist) {
				if ($rowlist['vat_customer'] == 0) {
					$vat = $rowlist['charge_amount'] * $rowlist['vat'] / 100;
					$chargeamount = $rowlist['charge_amount'] + $vat;
				} else {
					$chargeamount = $rowlist['charge_amount'];
				}

				$tblcharges.='
				<tr>
					<td style="border: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
					<td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="20%"></td>
					<td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
					<td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="6%"></td>
					<td width="29%" style="text-align:right; border: 0px solid black; border-left: 0px solid black; padding: 10px;"><strong style="font-size: 13px;">'.$rowlist['charges_type'] .'</strong></td>
					<td width="25%" style="text-align:right; border-top: none; border-right: none; border-left: none; border-bottom: none; padding: 10px; font-size: 13px;"> ' . number_format($chargeamount, 2) . '<td>   
				</tr>';
			}
		}


       
        
        $path = 'images/book.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->load->library('pdf');

        // $this->db->select('*, COALESCE(tbl_print_grn.idtbl_print_grn, 0) AS idtbl_print_grn, COALESCE(tbl_print_grn.total, 0) AS grn_total, COALESCE(tbl_print_grn.discount, 0) AS discount, COALESCE(tbl_print_grndetail.qty, 0) AS qty, COALESCE(tbl_print_grndetail.unitprice, 0) AS unitprice');
        // $this->db->from('tbl_print_grn');
        // $this->db->join('tbl_print_grndetail', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
        // $this->db->join('tbl_print_material_info', 'tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
        // $this->db->join('tbl_machine', 'tbl_print_grndetail.tbl_machine_id = tbl_machine.idtbl_machine', 'left');
        // $this->db->join('tbl_supplier', 'tbl_print_grn.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier', 'left');
        // $this->db->join('tbl_location', 'tbl_print_grn.tbl_location_idtbl_location = tbl_location.idtbl_location', 'left');
        // $this->db->join('tbl_order_type', 'tbl_print_grn.tbl_order_type_idtbl_order_type = tbl_order_type.idtbl_order_type', 'left');
        // $this->db->join('tbl_measurements', 'tbl_print_grndetail.measure_type_id = tbl_measurements.idtbl_mesurements', 'left');
        // $this->db->where('tbl_print_grn.idtbl_print_grn' ,$recordID);
        // $query = $this->db->get();

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
            <title>Invoice</title>
            <style>
                body {
                    margin: 0px;
                    padding: 0px;
                    font-family: Arial, sans-serif;
                    width: 100%;
                }
                p {
					margin-top: 0px;
                    font-size: 14px;
                    line-height: 3px;
                }
                .pheader {
					margin-top: 2px;
                    font-size: 12px;
                    line-height: 1.5px;
                }
                .tablec {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 5px;
                }
                .thc, .tdc {
                    padding: 8px;
					font-size: 13px;
                }
                .thc {
                    font: Arial, sans-serif;
					font-size: 13px;
                }
                hr {
                    border: 1px solid black;
					position: fixed;
					bottom: 1px;
                }
                .postion {
                    position: relative;
                }
                
                .foot{
                    font-size: 13px;
                }
                .tax {
					font-size: 30px;
					color: white;
					background-color: black;
					padding: 5px; 
				}
				.pono{
					text-align: left;
					margin-top: 40px;
				}
				.footertable{
					border-collapse: collapse;
					padding: 2px;
					text-align: center;
					font-size: 13px;
					position: fixed;
					bottom: 90px;
				}
				.telephone{
					border: 0px solid black;
					border-collapse: collapse;
					text-align: center;
					position: fixed;
					bottom: 60px;
				}
				.footer{
					position: fixed;
                    bottom: 0;
					border: 0px solid black;
					border-collapse: collapse;
					text-align: center;
					font-size: 11px;
				}
				
				

                
            </style>
        </head>
        <body>';

        $vat_customer = $query->row()->vat_customer;

        $html .= '<table border="0" width="100%">
                    <tr>
                        <td rowspan="2" align="left">
                            <h2 class="pheader" style="font-size: 22px; margin-top: 2px;">'.$companydetails->row()->companyname.'</h2> 
                            <p class="pheader" style="margin-top: 2px;font-size: 14px;">'.$companydetails->row()->companyaddress.'</p>
                            <p class="pheader" style="font-size: 14px;">'.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'</p>         
							<p class="pheader" style="font-size: 14px;">'.$companydetails->row()->companyemail.'</p>                
                        </td>';

        if ($vat_customer == 1) {
            $html .= '<td class="tax" align="center"><strong>Tax Invoice</strong></td>';
        } 
        elseif ($vat_customer == 2) {
            $html .= '<td class="tax" align="center"><strong>SVAT Invoice</strong></td>';
        }
        else {
            $html .= '<td class="tax" align="center"><strong>Invoice</strong></td>';
        }

       $html .= '</tr>
                </table>
			
				
				<table border="0" width="100%">
				 <tr>
				  <td colspan="3">
					  <table width="100%" border="0" cellspacing="10">
						  <tr>
							  <td valign="top">
								  <p>To:&nbsp;' . $query->row()->name . '</p>
								  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->address_line1 . '</p>
								  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->address_line2 . '</p>
								  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->city . '</p>
								  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->state . '</p>
								  <p class="pono" style="line-height: 10px;">P.O. No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;PO-'. $query->row()->ponum .' on '. $query->row()->date .'</p>';
                                  if ($vat_customer == 1) {
                                    $html .= '<p style="line-height: 10px;">VAT Reg. No&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'. $query->row()->vat_no .'-7000</p>';
                                } elseif ($vat_customer == 2) {
                                    $html .= '<p style="line-height: 10px;">VAT Reg. No&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'. $query->row()->vat_no .'-7000</p>
                                              <p style="line-height: 10px;">SVAT No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'. $query->row()->svat_no .'</p>';
                                }
                                

								$html .= '</td>
						
								
                                <td align="left" width="35%" height="20%" valign="top">
								    <p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;'. $query->row()->invoice_date .'</p>
                                    <p style="line-height: 13px;">Invoice No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;INV000'. $query->row()->idtbl_print_invoice .'</p>
                                    <p style="line-height: 13px;">Order No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;</p>
                                    <p style="line-height: 13px;">Page No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;Page 1 of 1</p>
                                    <p style="line-height: 13px;">Ref. No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;MOP/CU/123</p>
                                    <p style="line-height: 13px;">VAT Reg. No&nbsp; :&nbsp;103305667-7000</p>
                                    <p style="line-height: 13px;">SVAT No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;12446</p>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                 </tr>

                 <tr>
                    <td colspan="3">
                        <table class="tablec" border="0">
                            <thead class="thc">
                                <tr>
								    <th class="thc" width="16%" style="border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;"><strong>Dispatch No</strong></th>
                                    <th class="thc" width="30%" style="border: 1px solid black; border-right: 0px solid black; border-right: 0px solid black; border-left: 0px solid black;"><strong>Job</strong></th>
                                    <th class="thc" style="text-align:center; border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;" width="10%"><strong>Quantity</strong></th>
                                    <th class="thc" style="text-align:center; border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;" width="6%"><strong>UOM</strong></th>
                                    <th class="thc" width="29%" style="text-align:right; border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;"><strong>Unit Price</strong></th>
                                    <th class="thc" width="25%" style="text-align:right; border: 1px solid black; border-right: 0px solid black; border-left: 0px solid black;"><strong>Total</strong></th>
                                </tr>
                            </thead>
                            <tbody class="tdc">';

							foreach ($query->result() as $row) {
								$vat_percentage = $row->vat;
								$vat_customer = $row->vat_customer;

								$job = $row->job_no;
								$jobname = $row->job;
								$jobname_without_job = str_replace(" / $job", '', $jobname);
							
								if ($vat_customer == 0) {
									$vat_multiply = 1 + ($vat_percentage / 100);
									$unitprice = number_format($row->unit_price * $vat_multiply, 2, '.', ''); 
									$total = number_format(($row->unit_price * $vat_multiply) * $row->quantity, 2, '.', '');
								} else {
									$unitprice = number_format($row->unit_price, 2, '.', '');
									$total = number_format($row->detail_total, 2, '.', '');
								}
							
								$html .= '
									<tr>
										<td class="tdc">' . $row->dispatch_no . '</td>
										<td class="tdc">' . $jobname_without_job . '</td>
										<td class="tdc" style="text-align:center;">' . $row->quantity . '</td>
										<td class="tdc" style="text-align:center;">' . $row->measure_type . '</td>
										<td class="tdc" style="text-align:right;">' . $unitprice . '</td>
										<td class="tdc" style="text-align:right;">' . $total . '</td>
									</tr>';                      
							}   
							                      
                            $html .= '

                            </tbody>';
                           
                                $html .= '
                                <tbody class="foot">
                                   '.$tblcharges.'
                                </tbody>';
								 
							// if ($query->row()->discount != 0) {
							// 	$discount = number_format($query->row()->discount, 2, '.', '');
							// 	$html .= '
							// 	<tbody class="foot">
							// 	<tr>
							// 		<td style="border: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
							// 		<td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="20%"></td>
							// 		<td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
							// 		<td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="6%"></td>
							// 		<td width="29%" style="text-align:right; border: 0px solid black; border-left: 0px solid black; padding: 10px;"><strong>discount</strong></td>
							// 		<td width="25%" style="text-align:right; border-top: none; border-right: none; border-left: none; border-bottom: none; padding: 10px;"> (' .$discount. ')<td>   
							//     </tr>
							// 	</tbody>';
							// }
                            
							if ($query->row()->subtotal != 0) {
								$invoiceLabel = '';
								$border = 'border-bottom: 2px double black;'; 
							
								if ($vat_customer == 0) {
									$fulltotal = number_format($query->row()->net_total, 2, '.', ''); 
									$invoiceLabel = 'Total Invoice Value';
									$border = 'border-bottom: 2px double black;'; 
								} elseif ($vat_customer == 1) {
									$fulltotal = number_format($query->row()->subtotal, 2, '.', '');
									$invoiceLabel = 'Gross Invoice Value';
									$border = 'border-bottom: none;';
								} elseif ($vat_customer == 2) {
									$fulltotal = number_format($query->row()->subtotal, 2, '.', '');
									$invoiceLabel = 'Total Invoice Value'; 
									$border = 'border-bottom: 2px double black;';
								}
							
								$html .= '
								<tbody class="foot">
									<tr>
										<td style="border: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
										<td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="20%"></td>
										<td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="10%"></td>
										<td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="6%"></td>
										<td width="29%" style="text-align:right; border: 0px solid black; border-left: 0px solid black; padding: 10px;"><strong style="font-size: 14px;">' . $invoiceLabel . '</strong></td>
										<td width="25%" style="' . $border . 'text-align:right; border-right: none; border-left: none; border-top: 1px solid black; padding: 10px;"><strong style="font-size: 14px;">' . $fulltotal . '</strong></td>
									</tr>
								</tbody>';
							}
													
							if ($query->row()->vat_amount != 0 && $vat_customer != 0) {
                                $vat_amount = number_format($query->row()->vat_amount, 2, '.', '');
                                $vat_label = $query->row()->vat_customer == 2 ? 'Suspended VAT Amount' : 'VAT Amount(' . $query->row()->vat . '%)';
                                $html .= '
                                    <tbody class="foot">
                                        <tr>
                                            <td style="border: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
                                            <td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="20%"></td>
                                            <td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="10%"></td>
                                            <td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="6%"></td>
                                            <td width="29%" style="text-align:right; border: 0px solid black; border-left: 0px solid black; padding: 10px;"><strong style="font-size: 13px;">' . $vat_label . '</strong></td>
                                            <td width="25%" style="text-align:right; border: 0px solid black; padding: 10px; font-size: 13px;">'. $vat_amount .'</td>
                                        </tr>
                                    </tbody>';
                            }
                            
                            if ($vat_customer != 0 && $vat_customer != 2) {
								$html .= '
								<tbody>
									<tr>
										<td style="border: 0px solid black; border-right: 0px solid black; padding: 10px;" width="10%"></td>
										<td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="20%"></td>
										<td style="border: 0px solid black; border-right: 0px solid black; border-left: 0px solid black; padding: 10px;" width="10%"></td>
										<td style="text-align:center; border: 0px solid black; border-left: 0px solid black; border-right: 0px solid black; padding: 10px;" width="6%"></td>
										<td width="29%" style="text-align:right; border: 0px solid black; border-left: 0px solid black; padding: 10px; font-size: 14px;"><strong>Total Invoice Value</strong></td>
										<td width="25%" style="text-align:right; border-bottom: 2px double black; border-right: none; border-left: none; border-top: 1px solid black; padding: 10px;"><strong style="font-size: 14px;">'. number_format($query->row()->net_total, 2, '.', '') .'</strong></td>
									</tr>
								</tbody>';
							}
							$html .= '
                        </table>
                    </td>
                  </tr>
              </table>

						<table class="footertable" width="100%">
							<tbody>
								<tr>
									<td class="footertable" width="28%" style="border-bottom: none; border-right: none; border-left: none; border-top: 1px solid black;">Prepared By</td>
									<td class="footertable" width="8%"></td>
									<td class="footertable" width="28%" style="border-bottom: none; border-right: none; border-left: none; border-top: 1px solid black;">Checked By</td>
									<td class="footertable" width="8%"></td>
									<td class="footertable" width="28%" style="border-bottom: none; border-right: none; border-left: none; border-top: 1px solid black;">For Multi Offset Printers (Pvt) Ltd</td>
								</tr>
							</tbody>
						</table>
						<table class="telephone" width="100%">
							<tbody>
								<tr>
									<td class="telephone">Tel: +94-11-2253505, 2253876, 4362219 Fax: +94-11-2254057</td>
								</tr>
								<tr>
									<td class="telephone" style="color: blue; text-decoration: underline;">multioffset@sltnet.lk</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<table class="footer" width="100%">
							<tbody>
								<tr>
									<td class="footer">Remarks : Please quote our invoice number when settling account.</td>
								</tr>
								<tr>
									<td class="footer">Make all cheques payable to "Multi Offset Printers (Pvt) Ltd " and crossed "Account Payee Only"</td>
								</tr>
							</tbody>
						</table>

		    </body>
	</html>
	';  

       // $dompdf = new Dompdf();
        $fileNamePrefix = ($vat_customer == 1) ? 'Job Invoice_Vat' : (($vat_customer == 2) ? 'Job Invoice_Svat' : 'Job Invoice_Non Vat');
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($fileNamePrefix . " - " . $recordID . ".pdf", ["Attachment" => 0]);

    }

}
