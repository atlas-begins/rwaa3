<?php
class VesselReportPage extends VesselHolder {
	
	private static $icon = "mysite/images/treeicons/Vessel.png";
	
	public function getObjectReport($oID) {
		if($result = DataList::create("SSVessel")->byID($oID)) {
			$result->ReportTitle = 'Report for ' . $result->VesselClass . ' "' . $result->VesselName . '"';
			$result->RecordCreated = 'Database record ' . $result->ID . ' created ' . date("Y-m-d g:ia", strtotime($result->Created));
			$result->RecordCreated .= ', last edited ' . date("Y-m-d g:ia", strtotime($result->LastEdited));
			$result->RecordActive = 'Currently ';
			if($result->VesselActive) {
				$result->RecordActive .= 'active, ';
			} else {
				$result->RecordActive .= 'inactive, ';
			}
			if(!$result->ScoutGroupID) {
				$result->RecordActive .= 'not registered with a Scout group';
			} else {
				$result->RecordActive .= 'registered with ' . $result->ScoutGroup()->GroupName;
			}
			$result->RecordYear = 'Year of construction: ';
			if($result->VesselYear) {
				$result->RecordYear .= $result->VesselYear;
			} else {
				$result->RecordYear .= 'unknown';
			}
			$result->VesselCertificates = $result->SurveyCertificate()->sort("IssueDate", "DESC");
			return $result;
		} else {
			return false;
		}
	}
}

class VesselReportPage_Controller extends VesselHolder_Controller {

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
			$pdf->Cell(0, 10, 'Vessel number ' . $result->VesselNumber, 0, 1);
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(0, 6, $result->RecordCreated, 0, 1);
			$pdf->Cell(0, 6, $result->RecordActive, 0, 1);
			$pdf->Cell(0, 6, $result->RecordYear, 0, 1);
			$pdf->Cell(0, 6, 'Construction type: ' . $result->VesselConstruction, 0, 1);
			$pdf->Cell(0, 6, 'Rig: ' . $result->VesselRig, 0, 1);
			$pdf->Cell(0, 6, 'Sailing capacity (min/max): ' . $result->VesselSailCapacityMin . ' / ' . $result->VesselSailCapacityMax, 0, 1);
			$pdf->Cell(0, 6, 'Rowing capacity (min/max): ' . $result->VesselOarCapacityMin . ' / ' . $result->VesselOarCapacityMax, 0, 1);
			$pdf->Cell(0, 6, 'Motoring capacity (min/max): ' . $result->VesselMotorCapacityMin . ' / ' . $result->VesselMotorCapacityMax, 0, 1);
			$pdf->Cell(0, 6, 'Vessel certificates:', 0, 1);
			foreach($result->VesselCertificates as $cert) {
				if($cert->CertValid) {
					$cValid = 'valid';
				} else {
					$cValid = 'invalid/expired';
				}
				$pdf->Cell(5);
				$pdf->Cell(0, 6, '[' . $cert->ID . '] ' . $cert->completeCertNumber() .  ' <' . $cValid . '>', 0, 1);
			}
			$pdf->Output();
    	}
    }
}