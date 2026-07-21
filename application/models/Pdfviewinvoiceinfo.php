<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfviewinvoiceinfo extends CI_Model {

    public function pdfdata($x) {

        $recordID=$x;

		$comapnyID=$_SESSION['company_id'];


		$this->db->select('*, COALESCE(tbl_print_invoice.idtbl_print_invoice, 0) AS idtbl_print_invoice, COALESCE(tbl_print_invoice.vat, 0) AS vatpercent, COALESCE(tbl_print_invoice.vat_amount, 0) AS vatamount, COALESCE(tbl_print_invoice.inv_no, 0) AS inv_number, COALESCE(tbl_print_invoice.tax_invoice_num, 0) AS tax_inv_number, COALESCE(tbl_print_invoice.date, 0) AS invoice_date, COALESCE(tbl_print_invoicedetail.total, 0) AS detail_total, COALESCE(tbl_print_invoice.total, 0) AS net_total, COALESCE(tbl_customer_job_details.job_name, 0) AS jobname, COALESCE(tbl_print_invoicedetail.unitprice, 0) AS unit_price, COALESCE(tbl_print_invoicedetail.qty, 0) AS quantity, COALESCE(tbl_print_invoicedetail.job, 0) As job, COALESCE(tbl_print_invoicedetail.job_no, 0) As job_no,COALESCE(tbl_print_invoicedetail.dispatch_no, 0) As dispatch_number');
        $this->db->from('tbl_print_invoice');
		$this->db->join('tbl_print_invoicedetail', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoicedetail.tbl_print_invoice_idtbl_print_invoice', 'left');
		$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_print_invoicedetail.job_id', 'left');
		$this->db->join('tbl_customer_job_details', 'tbl_customer_job_details.idtbl_customer_job_details = tbl_customerinquiry_detail.job_id', 'left');
        $this->db->join('tbl_customer', 'tbl_print_invoice.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer', 'left');
        $this->db->join('tbl_print_dispatch', 'tbl_print_invoicedetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_invoicedetail.tbl_measurements_idtbl_measurements = tbl_measurements.idtbl_mesurements', 'left');

        $this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
        
        $query = $this->db->get();


		$this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_invoice');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_invoice.tbl_company_idtbl_company', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_invoice.tbl_company_branch_idtbl_company_branch', 'left');
		$this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
		$companydetails = $this->db->get();


        $tblcharges='';

		$this->db->select('tbl_print_invoice_charge_detail.charge_amount, tbl_charges.charges_type, tbl_print_invoice.vat, tbl_customer.vat_customer');
		$this->db->from('tbl_print_invoice');
		$this->db->join('tbl_print_invoice_charge_detail', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoice_charge_detail.tbl_print_invoice_idtbl_print_invoice', 'left');
		$this->db->join('tbl_charges', 'tbl_charges.idtbl_charges = tbl_print_invoice_charge_detail.charge_id', 'left');
		$this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_print_invoice.tbl_customer_idtbl_customer', 'left');
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


        $options = new Options();
		$options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

		$vat_customer = $query->row()->vat_customer;
		$isPostJuly = strtotime($query->row()->invoice_date) >= strtotime('2026-07-01');

		$taxNum = $query->row()->tax_inv_number;
		$displayInvoiceNo = (!empty($taxNum) && $taxNum != '0')
			? $taxNum
			: $query->row()->inv_number;

		$displayInvoiceLabel = $isPostJuly
			? 'Invoice No.'                       // unified format for everyone post-Jul-1
			: ($vat_customer == 1 ? 'Tax Invoice No.' : 'Invoice No.');

		//     $html = '
		//     <!DOCTYPE html>
		//     <html lang="en">
		//     <head>
		//         <meta charset="UTF-8">
		//         <meta name="viewport" content="width=device-width, initial-scale=1.0">
		//         <title>Invoice</title>
		//         <style>
		//             body {
		//                 margin: 0px;
		//                 padding: 0px;
		//                 font-family: Arial, sans-serif;
		//                 width: 100%;
		//             }
		//             p {
		// 				margin-top: 0px;
		//                 font-size: 14px;
		//                 line-height: 3px;
		//             }
		//             .pheader {
		// 				margin-top: 2px;
		//                 font-size: 12px;
		//                 line-height: 1.5px;
		//             }
		//             .tablec {
		//                 width: 100%;
		//                 border-collapse: collapse;
		//                 margin-top: 5px;
		//             }
		//             .thc, .tdc {
		//                 padding: 8px;
		// 				font-size: 13px;
		//             }
		//             .thc {
		//                 font: Arial, sans-serif;
		// 				font-size: 13px;
		//             }
		//             hr {
		//                 border: 1px solid black;
		// 				position: fixed;
		// 				bottom: 1px;
		//             }
		//             .postion {
		//                 position: relative;
		//             }
					
		//             .foot{
		//                 font-size: 13px;
		//             }
		//             .tax {
		// 				font-size: 30px;
		// 				color: white;
		// 				background-color: black;
		// 				padding: 5px; 
		// 			}
		// 			.pono{
		// 				text-align: left;
		// 				margin-top: 40px;
		// 			}
		// 			.footertable{
		// 				border-collapse: collapse;
		// 				padding: 2px;
		// 				text-align: center;
		// 				font-size: 13px;
		// 				position: fixed;
		// 				bottom: 90px;
		// 			}
		// 			.telephone{
		// 				border: 0px solid black;
		// 				border-collapse: collapse;
		// 				text-align: center;
		// 				position: fixed;
		// 				bottom: 60px;
		// 			}
		// 			.footer{
		// 				position: fixed;
		//                 bottom: 0;
		// 				border: 0px solid black;
		// 				border-collapse: collapse;
		// 				text-align: center;
		// 				font-size: 11px;
		// 			}
					
					

					
		
		//         </style>
		//     </head>
		//     <body>';


		//     $html .= '<table border="0" width="100%">
		//                 <tr>
		//                     <td rowspan="2" align="left">
		//                         <h2 class="pheader" style="font-size: 22px; margin-top: 2px;">'.$companydetails->row()->companyname.'</h2> 
		//                         <p class="pheader" style="margin-top: 2px;font-size: 14px;">'.$companydetails->row()->companyaddress.'</p>
		//                         <p class="pheader" style="font-size: 14px;">'.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'</p>         
		// 						<p class="pheader" style="font-size: 14px;">'.$companydetails->row()->companyemail.'</p>                
		//                     </td>';

		//     if ($vat_customer == 1) {
		//         $html .= '<td class="tax" align="center"><strong>Tax Invoice</strong></td>';
		//     } 
		//     elseif ($vat_customer == 2) {
		//         $html .= '<td class="tax" align="center"><strong>SVAT Invoice</strong></td>';
		//     }
		//     else {
		//         $html .= '<td class="tax" align="center"><strong>Invoice</strong></td>';
		//     }

		//    $html .= '</tr>
		//             </table>
				
					
		// 			<table border="0" width="100%">
		// 			 <tr>
		// 			  <td colspan="3">
		// 				  <table width="100%" border="0" cellspacing="10">
		// 					  <tr>
		// 						  <td valign="top">
		// 							  <p>To:&nbsp;' . $query->row()->customer . '</p>
		// 							  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->address_line1 . '</p>
		// 							  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->address_line2 . '</p>
		// 							  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->city . '</p>
		// 							  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $query->row()->state . '</p>
		// 							  <p class="pono">P.O. No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;'. $query->row()->ponum.'</p>';
		//                               if ($vat_customer == 1) {
		//                                 $html .= '<p>VAT Reg. No&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'. $query->row()->vat_no .'-7000</p>';
		//                             } elseif ($vat_customer == 2) {
		//                                 $html .= '<p>VAT Reg. No&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'. $query->row()->vat_no .'-7000</p>
		//                                           <p>SVAT No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'. $query->row()->svat_no .'</p>';
		//                             }
									

		// 							$html .= '</td>
							
									
		// 							<td align="left" width="35%" height="20%" valign="top">
		// 								<p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;'. $query->row()->invoice_date .'</p>
		// 								<p>Invoice No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;'. $query->row()->inv_number .'</p>
		// 								<p>Page No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;Page 1 of 1</p>
		// 								<p>Ref. No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;';
		// 									if ($comapnyID == 1) {
		// 										$html .= 'MOP/CU/' . $query->row()->ref_no . '';
		// 									} elseif ($comapnyID == 2) {
		// 										$html .= 'FT/CU/' . $query->row()->ref_no . '';
		// 									} else {
		// 										$html .= 'RMI/CU/' . $query->row()->ref_no . '';
		// 									}
		// 									$html .= '</p>
		// 								'.($comapnyID != 3 ? '
		// 								<p>VAT Reg. No&nbsp; :&nbsp;103305667-7000</p>
		// 								<p>SVAT No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;12446</p>
		// 								' : '').'
		// 							</td>
		//                         </tr>
								
		//                     </table>
		//                 </td>
		//              </tr>

		//              <tr>
		//                 <td colspan="3">
		//                     <table class="tablec" border="0">
		//                         <thead class="thc">
		//                             <tr>
		// 							    <th class="thc" width="16%" style="border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;"><strong>Dispatch No</strong></th>
		//                                 <th class="thc" width="30%" style="border: 1px solid black; border-right: 0px solid black; border-right: 0px solid black; border-left: 0px solid black;"><strong>Job</strong></th>
		//                                 <th class="thc" style="text-align:center; border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;" width="10%"><strong>Quantity</strong></th>
		//                                 <th class="thc" style="text-align:center; border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;" width="6%"><strong>UOM</strong></th>
		//                                 <th class="thc" width="29%" style="text-align:right; border: 1px solid black; border-left: 0px solid black; border-right: 0px solid black;"><strong>Unit Price</strong></th>
		//                                 <th class="thc" width="25%" style="text-align:right; border: 1px solid black; border-right: 0px solid black; border-left: 0px solid black;"><strong>Total</strong></th>
		//                             </tr>
		//                         </thead>
		//                         <tbody class="tdc">';

		// 						foreach ($query->result() as $row) {
		// 							$vat_percentage = $row->vat;
		// 							$vat_customer = $row->vat_customer;

		// 							$job = $row->job_no;
		// 							$jobname = $row->job;
		// 							$jobname_without_job = str_replace(" / $job", '', $jobname);
								
		// 							if ($vat_customer == 0) {
		// 								$vat_multiply = 1 + ($vat_percentage / 100);
		// 								$unitprice = number_format($row->unit_price * $vat_multiply, 2, '.', ''); 
		// 								$total = number_format(($row->unit_price * $vat_multiply) * $row->quantity, 2, '.', '');
		// 							} else {
		// 								$unitprice = number_format($row->unit_price, 2, '.', '');
		// 								$total = number_format($row->detail_total, 2, '.', '');
		// 							}
								
		// 							$html .= '
		// 								<tr>
		// 									<td class="tdc" style="width: 80px;">' . $row->dispatch_number .'</td>
		// 									<td class="tdc" style="text-align: left; width: 310px; white-space: normal; word-wrap: break-word;">' . $jobname . '</td>
		// 									<td class="tdc" style="text-align: center;">' . $row->quantity . '</td>
		// 									<td class="tdc" style="text-align: center;">' . $row->measure_type . '</td>
		// 									<td class="tdc" style="text-align: right; width: 61px;">' . number_format($unitprice, 2, '.', ',') . '</td>
		// 									<td class="tdc" style="text-align: right;">' . number_format($total, 2, '.', ',') . '</td>
		// 								</tr>';                      
		// 						}   
													
		//                         $html .= '

		// 						</tbody>';
														
		// 						$html .= '
		// 						<tbody class="foot">
		// 						'.$tblcharges.'
		// 						</tbody>';

		// 						if ($query->row()->subtotal != 0) {
		// 							$invoiceLabel = '';
		// 							$border = 'border-bottom: 2px double black;'; 
		// 							$vat_html = ''; // Initialize VAT HTML
									
		// 							if ($vat_customer == 0) {
		// 								$fulltotal = number_format($query->row()->net_total, 2, '.', ''); 
		// 								$invoiceLabel = 'Total Invoice Value';
		// 								$border = 'border-bottom: 2px double black;'; 
		// 							} elseif ($vat_customer == 1) {
		// 								$fulltotal = number_format($query->row()->subtotal, 2, '.', '');
		// 								$invoiceLabel = 'Gross Invoice Value';
		// 								$border = 'border-bottom: none;';
		// 							} elseif ($vat_customer == 2) {
		// 								$fulltotal = number_format($query->row()->subtotal, 2, '.', '');
		// 								$invoiceLabel = 'Total Invoice Value'; 
		// 								$border = 'border-bottom: 2px double black;';
		// 							}
									
		// 								$html .= '
		// 								<tbody class="foot">
		// 									<tr>
		// 										<td colspan="5" style="text-align:right; border: none;">
		// 											<strong style="font-size: 14px; padding-right: 15px;">' . $invoiceLabel . '</strong>
		// 										</td>
		// 										<td width="20%" style="'.$border.' text-align:right; border-right: none; border-left: none; border-top: 1px solid black; padding: 10px;">
		// 											<strong style="font-size: 14px;">' . number_format($fulltotal, 2, '.', ',') . '</strong>
		// 										</td>
		// 									</tr>';

		// 								// Show VAT for standard VAT customers (status 1) or suspended customers (status 2)
		// 								if ($vat_customer == 1 || $vat_customer == 2) {
		// 									$vat_amount = ($query->row()->subtotal * $query->row()->vatpercent) / 100;
											
		// 									if ($vat_customer == 2) {
		// 										// Suspended VAT - Left aligned with colon and proper spacing
		// 										$html .= '
		// 										<tr>
		// 											<td colspan="6" style="text-align:left; border: none; padding-left: 15px;">
		// 												<strong style="font-size: 13px;">SUSPENDED VAT AMOUNT (' . $query->row()->vatpercent . '%) : ' . number_format($vat_amount, 2, '.', ',') . '</strong>
		// 											</td>
		// 										</tr>';
		// 									} else {
		// 										// Regular VAT - Right aligned (original format)
		// 										$html .= '
		// 										<tr>
		// 											<td colspan="5" style="text-align:right; border: none; padding-right: 15px;">
		// 												<strong style="font-size: 13px;">VAT AMOUNT (' . $query->row()->vatpercent . '%)</strong>
		// 											</td>
		// 											<td width="20%" style="text-align:right; border-right: none; border-left: none; padding: 5px 10px;">
		// 												<strong style="font-size: 14px;">' . number_format($vat_amount, 2, '.', ',') . '</strong>
		// 											</td>
		// 										</tr>';
		// 									}
		// 								}

		// 								$html .= '</tbody>';
									
		// 							// Additional total for non-VAT-exempt and non-suspended customers
		// 							if ($vat_customer == 1) {
		// 								$html .= '
		// 								<tbody>
		// 									<tr>
		// 										<td colspan="5" width="25%" style="text-align:right; border: 0px solid black; border-left: 0px solid black; padding: 10px; font-size: 14px;"><strong>Total Invoice Value</strong></td>
		// 										<td width="20%" style="text-align:right; border-bottom: 2px double black; border-right: none; border-left: none; border-top: 1px solid black; padding: 10px;"><strong style="font-size: 14px;">'. number_format($query->row()->net_total, 2, '.', ',') .'</strong></td>
		// 									</tr>
		// 								</tbody>';
		// 							}
		// 						}

		// 						$html .= '
		// 							</table>
		// 						</td>
		// 						</tr>
		// 						</table>
		// 					<table class="footertable" width="100%">
		// 						<tbody>
		// 							<tr>
		// 								<td class="footertable" width="28%" style="border-bottom: none; border-right: none; border-left: none; border-top: 1px solid black;">Prepared By</td>
		// 								<td class="footertable" width="8%"></td>
		// 								<td class="footertable" width="28%" style="border-bottom: none; border-right: none; border-left: none; border-top: 1px solid black;">Checked By</td>
		// 								<td class="footertable" width="8%"></td>
		// 								<td class="footertable" width="28%" style="border-bottom: none; font-size:12px; border-right: none; border-left: none; border-top: 1px solid black;">
		// 									';
		// 									if ($comapnyID == 1) {
		// 										$html .= 'For Multi Offset Printers (Pvt) Ltd';
		// 									} else if ($comapnyID == 2) {
		// 										$html .= ' For Fair Trading';
		// 									} else {
		// 										$html .= ' For Rajah Multi Industries';
		// 									}
		// 									$html .= '
		// 								</td>
		// 							</tr>
		// 						</tbody>
		// 					</table>
		// 					<hr>
		// 					<table class="footer" width="100%">
		// 						<tbody>
		// 							<tr>
		// 								<td class="footer">Remarks : Please quote our invoice number when settling account.</td>
		// 							</tr>
		// 							<tr>
		// 								<td class="footer">
		// 									Make all cheques payable to 
		// 									"';
		// 									if ($comapnyID == 1) {
		// 										$html .= 'Multi Offset Printers (Pvt) Ltd';
		// 									} elseif ($comapnyID == 2) {
		// 										$html .= 'Fair Trading';
		// 									} else {
		// 										$html .= 'Rajah Multi Industries';
		// 									}
		// 									$html .= '" and crossed "Account Payee Only"
		// 								</td>
		// 							</tr>
		// 						</tbody>
		// 					</table>

		// 	    </body>
		// </html>
		// ';  
		$safeInvoiceNo = preg_replace('/[^A-Za-z0-9_\-\/]/', '_', $displayInvoiceNo);
		
		$html = '
		<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				 <title>'.$safeInvoiceNo.'</title>
				<style>
					* {
						margin: 0;
						padding: 0;
						box-sizing: border-box;
					}

					body {
						font-family: DejaVu Sans, sans-serif;
						font-size: 12px;
						color: #000;
						padding: 20px;
						margin-top: 80px;
					}

					 /** Define the header rules **/
					header {
						position: fixed;
						top: 15px;
						left: 0px;
						right: 0px;
						height: 255px;
					}

					/* ── Header ── */
					.header {
						text-align: center;
						margin-bottom: 15px;
					}

					.header img {
						width: 80px;
						height: auto;
						margin-bottom: 5px;
					}

					.company-name {
						font-size: 16px;
						font-weight: bold;
						text-transform: uppercase;
						margin-bottom: 2px;
					}

					.company-sub {
						font-size: 12px;
						margin-bottom: 2px;
					}

					/* ── Info Table ── */
					.info-table {
						width: 100%;
						// border-collapse: collapse;
						border-spacing: 15px 10px;
						// margin-bottom: 10px;
					}

					.info-table td {
						border: 1px solid #000;
						padding: 5px 8px;
						vertical-align: top;
						width: 50%;
					}

					.label {
						font-weight: bold;
					}

					/* Style for the inner layout tables */
					.inner-details-table {
						width: 100%;
						table-layout: fixed;
						border-collapse: collapse;
					}

					.inner-details-table th {
						text-align: left; /* PDF engines default <th> to center alignment */
						font-weight: bold;
					}

					.inner-details-table td {
						text-align: left; /* PDF engines default <th> to center alignment */
					}

					/* ── Additional Info ── */
					.additional-info {
						border: 1px solid #000;
						padding: 6px 8px;
						margin-bottom: 10px;
						margin-left: 15px;
						margin-right: 15px;
						min-height: 30px;
					}

					/* ── Items Table ── */
					.items-table {
						width: 100%;
						border-collapse: collapse;
						margin-left: 12px;
						margin-right: 19px;
					}

					.items-table th {
						border: 1px solid #000;
						padding: 6px 5px;
						text-align: center;
						font-weight: bold;
						background-color: #f0f0f0;
						font-size: 12px;
					}

					.items-table td {
						border: 1px solid #000;
						padding: 5px;
						vertical-align: top;
						font-size: 12px;
					}

					.items-table .col-ref       { width: 10%; text-align: center; }
					.items-table .col-desc      { width: 42%; text-align: left;   }
					.items-table .col-qty       { width: 10%; text-align: center; }
					.items-table .col-unitprice { width: 18%; text-align: right;  }
					.items-table .col-amount    { width: 20%; text-align: right;  }

					.items-table .empty-row td  { height: 25px; }

					/* ── Summary ── */
					.summary-label { text-align: left;  font-size: 12px; }
					.summary-value { text-align: right; font-size: 12px; font-weight: bold; }

					/* ── Total Words & Mode ── */
					.total-words-box {
						border: 1px solid #000;
						padding: 6px 8px;
						min-height: 28px;
						margin-top: 15px;
						margin-left: 15px;
						margin-right: 15px;
					}

					.mode-payment-box {
						border: 1px solid #000;
						border-top: 0;
						padding: 6px 8px;
						min-height: 28px;
						margin-left: 15px;
						margin-right: 15px;
					}

					/* ── Footer ── */
					.footer-ref {
						text-align: left;
						font-size: 9px;
						margin-top: 15px;
					}

					.footer {
						margin-top: 5px;
						font-size: 9px;
						text-align: center;
						color: #555;
						border-top: 1px solid #000;
						padding-top: 5px;
					}

					/* ── Utilities ── */
					.text-right  { text-align: right;  }
					.text-center { text-align: center; }
					.text-left   { text-align: left;   }
					.font-bold   { font-weight: bold;  }
					.asterisk    { color: #888; 	  }

					/** Define the footer rules **/
					footer {
						position: fixed; 
						bottom: 0px; 
						left: 0px; 
						right: 0px;
						height: 120px; /* Slightly increased to fit signatures comfortably */
					}

					.footertable {
						width: 100%;
						text-align: center;
						border-collapse: collapse;
						margin-top: 10px;
					}

					.footertable td {
						width: 33.33%;
						padding-top: 60px; /* Creates the space for physical signatures */
						vertical-align: bottom;
					}

					.sig-line {
						border-top: 1px dotted #000;
						width: 80%;
						margin: 0 auto 5px auto;
					}

				</style>
			</head>
			<body>

				<!-- ══ HEADER ══════════════════════════════════════════════════════ -->
				<header>
					<div class="header">
						<div class="company-name">'.$companydetails->row()->companyname.'</div>
						<div class="company-sub">'.$companydetails->row()->companyaddress.'</div>
						<div class="company-sub">Tel: '.$companydetails->row()->companymobile.' / '.$companydetails->row()->companyphone.' | Email: '.$companydetails->row()->companyemail.'</div>
					</div>
				</header>

				<!-- ══ FOOTER ══════════════════════════════════════════════════════ -->
				<footer>
                    <table class="footertable">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="sig-line"></div>
                                    Prepared By
                                </td>
                                <td>
                                    <div class="sig-line"></div>
                                    Checked By
                                </td>
                                <td>
                                    <div class="sig-line"></div>';
                                    if ($comapnyID == 1) {
                                        $html .= 'For Multi Offset Printers (Pvt) Ltd';
                                    } else if ($comapnyID == 2) {
                                        $html .= 'For Fair Trading';
                                    } else {
                                        $html .= 'For Rajah Multi Industries';
                                    }
                                    $html .= '
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </footer>

				<!-- ══ TITLE ════════════════════════════════════════════════════════ -->
				<div style="text-align: center; margin-bottom: 15px;">
					<table style="margin: 0 auto; border-collapse: collapse;">
						<tr>
							<td style="
								border: 2px solid #000;
								padding: 8px 30px;
								font-size: 16px;
								font-weight: bold;
								letter-spacing: 2px;
								text-align: center;
							">'.($vat_customer == 1 ? 'TAX INVOICE' : 'INVOICE').'</td>
						</tr>
					</table>
				</div>

				<!-- ══ SUPPLIER & PURCHASER INFO ════════════════════════════════════ -->

				<table class="info-table">

					<!-- Row 1: Date of Invoice | Tax Invoice No -->
					<tr>
						<td>
							<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
								<tr>
									<th style="border: none;width:38%;vertical-align: top;">Date of Invoice</th>
									<th style="border: none;width:2%;vertical-align: top;">:</th>
									<td style="border: none;width:60%;vertical-align: top;padding-top:0;">'. date('m/d/Y', strtotime($query->row()->invoice_date)) .'</td>
								</tr>
							</table>
						</td>
						<td>
							<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
								<tr>
									<th style="border: none;width:38%;vertical-align: top;">'.$displayInvoiceLabel.'</th>
									<th style="border: none;width:2%;vertical-align: top;">:</th>
									<td style="border: none;width:60%;vertical-align: top;padding-top:0;">'. $displayInvoiceNo .'</td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- Row 2: Supplier TIN | Purchaser TIN -->
					<tr>
						<td>	
							<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
								<tr>
									<th style="border: none;width:38%;vertical-align: top;">Supplier`s TIN</th>
									<th style="border: none;width:2%; width: 2px;vertical-align: top;">:</th>
									<td style="border: none;width:60%;vertical-align: top;padding-top:0;">'.($comapnyID == 1 ? '103305667' : '').'</td>
								</tr>
								<tr>
									<th style="border: none;vertical-align: top;">Supplier`s Name</th>
									<th style="border: none;vertical-align: top;">:</th>
									<td style="border: none;vertical-align: top;padding-top:0;">'.$companydetails->row()->companyname.'</td>
								</tr>
								<tr>
									<th style="border: none;vertical-align: top;">Address</th>
									<th style="border: none;vertical-align: top;">:</th>
									<td style="border: none;vertical-align: top;padding-top:0;">'.$companydetails->row()->companyaddress.'</td>
								</tr>
								<tr>
									<th style="border: none;vertical-align: top;">Telephone No. </th>
									<th style="border: none;vertical-align: top;">:</th>
									<td style="border: none;vertical-align: top;padding-top:0;">'.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'</td>
								</tr>
							</table>
						</td>
						<td>
							<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
								<tr>
									<th style="border: none;width:38%;vertical-align: top;">Purchaser`s TIN</th>
									<th style="border: none;width:2%;vertical-align: top;">:</th>
									<td style="border: none;width:60%;vertical-align: top;padding-top:0;">'. $query->row()->vat_no .'</td>
								</tr>
								<tr>
									<th style="border: none;vertical-align: top;">Purchaser`s Name</th>
									<th style="border: none;vertical-align: top;">:</th>
									<td style="border: none;vertical-align: top;padding-top:0;">' . $query->row()->customer . '</td>
								</tr>
								<tr>
									<th style="border: none;vertical-align: top;">Address</th>
									<th style="border: none;vertical-align: top;">:</th>
									<td style="border: none;vertical-align: top;padding-top:0;">' . $query->row()->address_line1 . ' ' . $query->row()->address_line2 . ' ' . $query->row()->city . ' ' . $query->row()->state . '</td>
								</tr>
								<tr>
									<th style="border: none;vertical-align: top;">Telephone No.</th>
									<th style="border: none;vertical-align: top;">:</th>
									<td style="border: none;vertical-align: top;padding-top:0;">' . $query->row()->telephone_no . '</td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- Row 6: Date of Supply | Place of Supply -->
					<tr>
						<td>
							<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
								<tr>
									<th style="border: none;width:38%;vertical-align: top;">Date of Supply</th>
									<th style="border: none;width:2%;vertical-align: top;">:</th>
									<td style="border: none;width:60%;vertical-align: top;padding-top:0;">'. date('m/d/Y', strtotime($query->row()->invoice_date)) .'</td>
								</tr>
							</table>							
						</td>
						<td>
							<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
								<tr>
									<th style="border: none;width:38%;vertical-align: top;">Place of Supply </th>
									<th style="border: none;width:2%;vertical-align: top;">:</th>
									<td style="border: none;width:60%;vertical-align: top;padding-top:0;">' . $query->row()->address_line1 . ' ' . $query->row()->address_line2 . ' ' . $query->row()->city . ' ' . $query->row()->state . '</td>
								</tr>
							</table>							
						</td>
					</tr>

				</table>

				<!-- ══ ADDITIONAL INFORMATION ════════════════════════════════════════ -->
				<div class="additional-info">
					<table style="width: 100%; border-collapse: collapse;">
						<tr>
							<td style="width: 50%;padding-left: 1px;vertical-align: top;">
								<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
									<tr>
										<th style="border: none;width:35%;vertical-align: top;">Job No</th>
										<th style="border: none;width:2%;vertical-align: top;">:</th>
										<td style="border: none;width:60%;vertical-align: top;padding-top:0;padding-left: 7px;">' . $query->row()->job_no . '</td>
									</tr>
								</table>
							</td>
							<td style="width: 50%;padding-left: 16px;vertical-align: top;">
								<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
									<tr>
										<th style="border: none;width:38%;vertical-align: top;">P.O. No</th>
										<th style="border: none;width:5%;vertical-align: top;">:</th>
										<td style="border: none;width:57%;vertical-align: top;padding-top:0;padding-left: -2px;">' . $query->row()->ponum . '</td>
									</tr>
								</table>	
							</td>
						</tr>
					
					</table>					
				</div>

				<!-- ══ ITEMS TABLE ════════════════════════════════════════════════════ -->
				<table class="items-table">

					<!-- ── Head ── -->
					<thead>
						<tr>
							<th class="col-ref" style="vertical-align: top;">
								Reference
							</th>
							<th class="col-desc" style="vertical-align: top;">Description of Goods or Services</th>
							<th class="col-qty" style="vertical-align: top;">Quantity</th>
							<th class="col-unitprice" style="vertical-align: top;">Unit Price</th>
							<th class="col-amount" style="vertical-align: top;">
								Amount Excluding VAT (Rs.)
							</th>
						</tr>
					</thead>

					<!-- ── Body ── -->
					<tbody>';
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
							$html.='<tr>
								<td class="col-ref text-center">'. $row->dispatch_number .'</td>
								<td class="col-desc">' . $jobname . '</td>
								<td class="col-qty text-center">' . $row->quantity . '</td>
								<td class="col-unitprice text-right">' . number_format($unitprice, 2, '.', ',') . '</td>
								<td class="col-amount text-right">' . number_format($total, 2, '.', ',') . '</td>
							</tr>';
						}
						if ($chargesquery->num_rows() > 0) {
							$charges = $chargesquery->result_array();
							
							foreach ($charges as $rowlist) {
								if ($rowlist['vat_customer'] == 0) {
									$vat = $rowlist['charge_amount'] * $rowlist['vat'] / 100;
									$chargeamount = $rowlist['charge_amount'] + $vat;
								} else {
									$chargeamount = $rowlist['charge_amount'];
								}

								if($chargeamount>0):
								$html.='<tr>
									<td colspan="4" class="summary-label">
										'.$rowlist['charges_type'] .'
									</td>
									<td class="text-right">
										' . number_format($chargeamount, 2) . '
									</td>
								</tr>';
								endif;
							}
						}
					$html.='</tbody>';
					
					$vat_amount = ($vat_customer == 1 || $vat_customer == 2) ? ($query->row()->subtotal * $query->row()->vatpercent) / 100 : '0.00';

					$subtotal = ($vat_customer == 1 || $vat_customer == 2) ? $query->row()->subtotal : $query->row()->net_total;

					$nettotal = $query->row()->net_total;

					$rupeetext=$this->Pdfviewinvoiceinfo->ConvertRupeeToText(round($query->row()->net_total, 2));

					$html.='
					<!-- ── Summary ── -->
					<tfoot>';
						if($vat_customer == 1):
						$html.='<tr>
							<td colspan="4" class="summary-label">
								Total Value of Supply :
							</td>
							<td class="summary-value text-right">
								' . number_format($subtotal, 2, '.', ',') . '
							</td>
						</tr>
						<tr>
							<td colspan="4" class="summary-label">
								VAT Amount (Total Value of Supply @ ' . $query->row()->vatpercent . '%)
							</td>
							<td class="summary-value text-right">
								' . number_format($vat_amount, 2, '.', ',') . '
							</td>
						</tr>';
						endif;
						$html.='<tr>
							<td colspan="4" class="summary-label font-bold">
								Total Amount / consideration including VAT :
							</td>
							<td class="summary-value text-right font-bold">
								' . number_format($nettotal, 2, '.', ',') . '
							</td>
						</tr>
					</tfoot>

				</table>

				<!-- ══ TOTAL IN WORDS ════════════════════════════════════════════════ -->
				<div class="total-words-box">
					<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
						<tr>
							<th style="border: none;width:24%;vertical-align: top;">Total Amount in words</th>
							<th style="border: none;width:2%;vertical-align: top;">:</th>
							<td style="border: none;width:74%;vertical-align: top;padding-top:0;">'. $rupeetext .'</td>
						</tr>
					</table>	
				</div>

				<!-- ══ MODE OF PAYMENT ═══════════════════════════════════════════════ -->
				<div class="mode-payment-box">
					<table class="inner-details-table" style="width: 100%; border: none; border-collapse: collapse;">
						<tr>
							<th style="border: none;width:24%;vertical-align: top;">Mode of Payment</th>
							<th style="border: none;width:2%;vertical-align: top;">:</th>
							<td style="border: none;width:74%;vertical-align: top;padding-top:0;"></td>
						</tr>
					</table>	
				</div>
			</body>
			</html>
		';
		
		// echo $html;
       	// $dompdf = new Dompdf();
        $fileNamePrefix = ($vat_customer == 1) ? 'Job Invoice_Vat' : (($vat_customer == 2) ? 'Job Invoice_Svat' : 'Job Invoice_Non Vat');
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$safeInvoiceNo = preg_replace('/[^A-Za-z0-9_\-]/', '_', $displayInvoiceNo);

		$dompdf->stream($fileNamePrefix . " - " . $safeInvoiceNo . ".pdf", ["Attachment" => 0]);

    }
	public function ConvertRupeeToText($amount) {
        $ones = array(
            0 => '',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen'
        );
    
        $tens = array(
            2 => 'twenty',
            3 => 'thirty',
            4 => 'forty',
            5 => 'fifty',
            6 => 'sixty',
            7 => 'seventy',
            8 => 'eighty',
            9 => 'ninety'
        );
    
        $amount = str_replace(',', '', $amount);
        $rupees = intval($amount);
        $cents = intval(round(($amount - $rupees) * 100));
    
        $words = '';
    
        $numberToWords = function($num) use (&$numberToWords, $ones, $tens) {
            $str = '';
    
            if ($num >= 1000000000) {
                $str .= $numberToWords(intval($num / 1000000000)) . ' billion ';
                $num %= 1000000000;
            }
    
            if ($num >= 1000000) {
                $str .= $numberToWords(intval($num / 1000000)) . ' million ';
                $num %= 1000000;
            }
    
            if ($num >= 1000) {
                $str .= $numberToWords(intval($num / 1000)) . ' thousand ';
                $num %= 1000;
            }
    
            if ($num >= 100) {
                $str .= $ones[intval($num / 100)] . ' hundred ';
                $num %= 100;
            }
    
            if ($num > 0) {
                if ($str !== '') {
                    $str .= ' ';
                }
    
                if ($num < 20) {
                    $str .= $ones[$num];
                } else {
                    $str .= $tens[intval($num / 10)];
                    if ($num % 10 > 0) {
                        $str .= '-' . $ones[$num % 10];
                    }
                }
            }
    
            return trim($str);
        };
    
        if ($rupees > 0) {
            $words .= $numberToWords($rupees);
        }
    
        if ($cents > 0) {
            if ($rupees > 0) {
                $words .= ' and ';
            }
            $words .= $numberToWords($cents) . ' cents';
        }
    
        if ($words === '') {
            $words = 'zero';
        }
    
        return ucfirst(trim($words));
    }
}
