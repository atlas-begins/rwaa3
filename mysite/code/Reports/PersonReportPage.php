<?php
class PersonReportPage extends PersonHolder {
	
	private static $icon = "mysite/images/treeicons/Person.png";
	
	public function getObjectReport($oID) {
		if($result = DataList::create("SSPerson")->byID($oID)) {
			$result->ReportTitle = 'Report for ' . $result->FirstName . ' ' . $result->Surname;
			$result->RecordCreated = 'Database record ' . $result->ID . ' created ' . date("Y-m-d g:ia", strtotime($result->Created));
			$result->RecordCreated .= ', last edited ' . date("Y-m-d g:ia", strtotime($result->LastEdited));
			
			if(!$result->ScoutGroupID) {
				$result->RecordActive = 'Not registered with a Scout group';
			} else {
				$result->RecordActive = 'Registered with ' . $result->ScoutGroup()->GroupName;
			}
			if($result->PersonActive) {
				$result->RecordActive .= ' <active> ';
			} else {
				$result->RecordActive .= ' <inactive> ';
			}
			if($result->PersonCharge()->ID) {
				$result->Charge = $result->PersonCharge();
			} else {
				$result->Charge = null;
			}
			
			return $result;
		} else {
			return false;
		}
	}
}

class PersonReportPage_Controller extends PersonHolder_Controller {

	private static $allowed_actions = array (
		'report' => true
	);
	
	public function report($request) {
		$oID = (int)$this->request->param('ID');
    	if($result = self::getObjectReport($oID)) {
    		$pdf = new FPDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(40, 10, $result->ReportTitle, 0, 1);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(0, 5, '(Cmd+S or Ctrl+S to save this document)', 0, 1);
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(0, 6, $result->RecordCreated, 0, 1);
			$pdf->Cell(0, 6, $result->RecordActive, 0, 1);
			$pdf->Cell(0, 6, 'Roles:', 0, 1);
			$roleSet = $result->PersonRole();
			foreach($roleSet as $roleItem) {
				$pdf->Cell(5);
				$pdf->Cell(0, 6, '[' . $roleItem->RoleAbbrev .'] ' . $roleItem->Role, 0, 1);
			}
    		
			if($charge = $result->Charge) {
				$descs = singleton('SSChargeEndorsement')->endorsements();
				$certString = 'Charge Certificate ' . $charge->ChargeNumber;
				if($charge->ChargeActive) {
					$certString .= ' <active>';
				} else {
					$certString .= ' <inactive>';
				}
				$certString .= ' Issued on ' . $charge->IssueDate;
				$certString .= ' by '. $charge->ChargeIssuer()->FirstName . ' ' . $charge->ChargeIssuer()->Surname;
				
				$pdf->Cell(0, 6, $certString, 0, 1);
				if($eItems = $charge->Endorsements()) {
					foreach($eItems as $eItem) {
						$pdf->Cell(5);
						$pdf->Cell(0, 6, '[' . $eItem->EndorsementCode . '] ' . $descs[$eItem->EndorsementCode] . ' - Issued ' . $eItem->EndorsementDate . ' by ' . $eItem->Examiner()->FirstName . ' ' . $eItem->Examiner()->Surname, 0, 1);
					}
				} else {
					$pdf->Cell(5);
					$pdf->Cell(0, 6, 'No endorsements', 0, 1);
				}
			}
			
			$pdf->Output();
    	}
    }
}