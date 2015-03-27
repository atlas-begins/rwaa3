<?php
class GroupReportPage extends GroupHolder {
	
	private static $icon = array("mysite/images/treeicons/Group.png");
	
	public function getObjectReport($oID) {
		if($result = DataList::create("SSGroup")->byID($oID)) {
			$result->ReportTitle = 'Report for group "' . $result->GroupName . '"';
			$result->RecordCreated = 'Database record ' . $result->ID . ' created ' . date("Y-m-d g:ia", strtotime($result->Created));
			$result->RecordCreated .= ', last edited ' . date("Y-m-d g:ia", strtotime($result->LastEdited));
			return $result;
		} else {
			return false;
		}
	}
}

class GroupReportPage_Controller extends GroupHolder_Controller {

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
			$pdf->Cell(0, 6, 'Branch: ' . $result->GroupBranch, 0, 1);
			$pdf->Cell(0, 6, 'Zone: ' . $result->GroupZone()->ZoneName, 0, 1);
			$pdf->Cell(0, 6, 'Locality: ' . $result->GroupLocality, 0, 1);
			if($result->GroupWebsite) {
				$pdf->Cell(0, 6, 'Website: ' . $result->GroupWebsite, 0, 1);
			}
			$pdf->Cell(0, 6, '', 0, 1);
			$pdf->Cell(0, 6, 'People', 0, 1);
			if($persons = $result->GroupPeople()) {
				foreach($persons as $person) {
					$pData = '[' . $person->ID . '] ' . $person->FirstName . ' ' . $person->Surname . ' ';
					foreach($person->PersonRole() as $role) {
						$pData .= '(' . $role->RoleAbbrev . ') ';
					}
					$pData .= ' <';
					if($person->PersonActive) {
						$pData .=  'active';
					} else {
						$pData .=  'inactive';
					}
					$pData .=  '>';
					$pdf->Cell(5);
					$pdf->Cell(0, 6, $pData, 0, 1);
				}
			} else {
				$pdf->Cell(5);
				$pdf->Cell(0, 6, 'No people records', 0, 1);
			}
			$pdf->Cell(0, 6, '', 0, 1);
			$pdf->Cell(0, 6, 'Vessels', 0, 1);
			if($vessels = $result->GroupVessels()->sort('VesselClass', 'ASC')) {
				foreach($vessels as $vessel) {
					$vData = '[' . $vessel->ID . '] ' . $vessel->VesselClass;
					if($vessel->VesselNumber) $vData .= ' (' . $vessel->VesselNumber . ')';
					$vData .= ' "' . $vessel->VesselName . '" <' ;
					if($vessel->VesselActive) {
						$vData .=  'active';
					} else {
						$vData .=  'inactive';
					}
					$vData .=  '>';
					$pdf->Cell(5);
					$pdf->Cell(0, 6, $vData, 0, 1);
				}
			} else {
				$pdf->Cell(5);
				$pdf->Cell(0, 6, 'No vessel records', 0, 1);
			}
			$pdf->Output();
    	}
    }
}