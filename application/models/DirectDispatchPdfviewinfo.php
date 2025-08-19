<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class DirectDispatchPdfviewinfo extends CI_Model {
    public function pdfdata($x) {
        $recordID=$x;

        $this->db->select('*');
        $this->db->from('tbl_direct_dispatch');
		$this->db->join('tbl_direct_dispatchdetail', 'tbl_direct_dispatch.idtbl_direct_dispatch = tbl_direct_dispatchdetail.tbl_direct_dispatch_idtbl_direct_dispatch', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_direct_dispatchdetail.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_customer', 'tbl_direct_dispatch.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer', 'left');
        $this->db->join('tbl_measurements', 'tbl_direct_dispatchdetail.tbl_measurements_idtbl_mesurements = tbl_measurements.idtbl_mesurements', 'left');

        $this->db->where('tbl_direct_dispatch.idtbl_direct_dispatch', $recordID);
        
        $query = $this->db->get();

		$dataArray = [];
        $count = 0;
        $section = 1;
		$remark='';
        foreach ($query->result() as $rowlist) {        
            if ($count % 3 == 0) {
                $dataArray[$section] = [];
            }
        
            $dataArray[$section][] = [
                'material' => $rowlist->materialname,
                'qty' => $rowlist->qty,
                'measure_type' => $rowlist->measure_type,
                'comment' => $rowlist->comment,
            ];
        
            $count++;
        
            if ($count % 3 == 0) {
                $section++;
            }

			$remark=$rowlist->remark;
        }

        $this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile, tbl_company.phone companyphone,tbl_company.email AS companyemail, tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_direct_dispatch');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_direct_dispatch.tbl_company_idtbl_company', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_direct_dispatch.tbl_company_branch_idtbl_company_branch', 'left');
		$this->db->where('tbl_direct_dispatch.idtbl_direct_dispatch', $recordID);
		$companydetails = $this->db->get();

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
                    size: 220mm 140mm;
                    margin: 5mm 5mm 5mm 5mm; /* top right bottom left */
                    font-family: Arial, sans-serif;
                }
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.5;
                    text-align:left;
                    margin-top: 150px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    right: 0px;
                    height: 240px;
                }

                /** Define the footer rules **/
                footer {
                    position: fixed; 
                    bottom: 0px; 
                    left: 0px; 
                    right: 0px;
                    height: 70px;
                }
            </style>
        </head>

        <body>
        	<header>
        		<table style="width:100%;border-collapse: collapse;">
        			<tr>
        				<td style="width: 55%;text-align: left;vertical-align: top;">
        					<p style="font-size:15px;font-weight:bold;margin-top:0px;margin-bottom:0px;">ADVICE OF DISPATCH</p>
        					<p style="margin:0px;font-size:13px;font-weight: bold;">'.$query->row(0)->customer.'</p>
                            <p style="margin:0px;font-size:13px;">'. $query->row()->address_line1 .'</p>
                            <p style="margin:0px;font-size:13px;">'. $query->row()->address_line2 .'</p>
                            <p style="margin:0px;font-size:13px;">'. $query->row()->city .'</p>
                            <p style="margin:0px;font-size:13px;">'. $query->row()->state .'</p>
                            <p style="margin:0px;font-size:13px;">'. $query->row()->telephone_no .'</p>
        				</td>
        				<td style="text-align: left;vertical-align: top;padding: 0px;">
                            <p style="font-size: 15px;font-weight: bold; margin-top: 0px; margin-bottom: 0px;text-transform: uppercase;">'.$companydetails->row()->companyname.'</p>
                            <p style="margin:0px;font-size:13px;text-transform: uppercase;">' . $companydetails->row()->companyaddress . '</p>
                            <p style="margin:0px;font-size:13px;">Phone : ' . $companydetails->row()->companymobile . ' / ' . $companydetails->row()->companyphone . '</p>
                            <p style="margin:0px;font-size:13px;"><u>E-Mail : ' . $companydetails->row()->companyemail . '</u></p>
                            <p style="margin:0px;font-size:13px;">Date : ' . $query->row()->date . '</p>
                            <p style="margin:0px;font-size:13px;">Dispatch No : ' . $query->row()->dispatch_no . '</p>
                        </td>
        			</tr>
        		</table>

        	</header>

        	<footer>
        		<table width="100%" style="border-collapse: collapse;">
        			<tr>
        				<td style="text-align: left;font-size:13px;">Gate pass No: .....................................</td>
        				<td>&nbsp;</td>
        				<td style="text-align: right;font-size:13px;">Vehicle No: .....................................</td>
        			</tr>
        			<tr>
        				<td style="text-align: left;font-size:13px;padding-top:15px;">Received By: .....................................</td>
        				<td style="text-align: center;font-size:13px;padding-top:15px;">Checked By: .....................................</td>
        				<td style="text-align: right;font-size:13px;padding-top:15px;">Date: .....................................</td>
        			</tr>
        		</table>
        	</footer>';
			foreach ($dataArray as $index => $section) {
				$html.='
				<main>
					<table width="100%">
						<tr>
							<td style="text-align: center;">
								<p style="margin: 5px;font-size: 13px;font-weight:bold;">(Please accept the following and return the DUPLICATE COPY)</p>
							</td>
						</tr>
					</table>
					<table width="100%" style="border-collapse: collapse;">
						<thead>
							<tr>
								<th style="text-align:left;font-size: 13px;border: 1px thin solid;padding-left: 10px;" width="30%">Material</th>
								<th style="text-align:center;font-size: 13px;border: 1px thin solid;" width="15%">Quantity</th>
								<th style="text-align:center;font-size: 13px;border: 1px thin solid;" width="15%">Measure type</th>
								<th width="25%" style="text-align:center;font-size: 13px;border: 1px thin solid;">Comment</th>
							</tr>
						</thead>
						<tbody>';
						foreach ($section as $row) {
							$html .= '<tr>
								<td style="width: 10%;font-size: 13px;border: 1px thin solid;padding-left: 10px;">' . htmlspecialchars($row['material']) . '</td>
								<td style="width: 15%;text-align:center;font-size: 13px;border: 1px thin solid;">' . htmlspecialchars($row['qty']) . '</td>
								<td style="width: 15%;text-align:center;font-size: 13px;border: 1px thin solid;">' . htmlspecialchars($row['measure_type']) . '</td>
								<td style="width: 25%;text-align:center;font-size: 13px;border: 1px thin solid;">' . htmlspecialchars($row['comment']) . '</td>
							</tr>';
						}
						$html.='</tbody>
					</table>';
					if ($index === count($dataArray)) {
						$html.='<table width="100%" style="border-collapse: collapse;margin-top: 10px;">';
						if (!empty($remark)) {
							$html .= '<tr>
								<td style="border: 1px solid thin;font-size:13px;padding-left: 10px;">' . $remark . '</td>
							</tr>';
						}
						$html.='</table>';
					}
				$html.='</main>';
				if ($index === count($dataArray) - 1) {
					$html .= '<div style="page-break-before: always;"></div>'; 
				}
			}
        $html.='</body>
        </html>
        ';  
        
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("Dispatch Note - ". $recordID .".pdf", ["Attachment"=>0]);
        
        
    }
}