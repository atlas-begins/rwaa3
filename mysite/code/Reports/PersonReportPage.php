<?php
class PersonReportPage extends PersonHolder {
	
	private static $icon = "mysite/images/treeicons/Person.png";
	
	public function getObjectReport($oID) {
		if($result = DataList::create("SSPerson")->byID($oID)) {
			$result->ReportTitle = 'Report for ' . $result->FirstName . ' ' . $result->Surname;
			$result->RecordCreated = 'Database record ' . $result->ID . ' created ' . date("Y-m-d g:ia", strtotime($result->Created));
			$result->RecordCreated .= ', last edited ' . date("Y-m-d g:ia", strtotime($result->LastEdited));
			$result->RecordActive = 'Currently ';
			if($result->PersonActive) {
				$result->RecordActive .= 'active, ';
			} else {
				$result->RecordActive .= 'inactive, ';
			}
			if(!$result->ScoutGroupID) {
				$result->RecordActive .= 'not registered with a Scout group';
			} else {
				$result->RecordActive .= 'registered with ' . $result->ScoutGroup()->GroupName;
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
			$pdf->Output();
    	}
    }
}