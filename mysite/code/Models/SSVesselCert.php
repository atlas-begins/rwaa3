<?php
class SSVesselCert extends DataObject {

	private static $db = array(
		'VesselCertNumber' => 'Int'
		, 'SurveyDate' => 'Date'
		, 'IssueDate' => 'Date'
	);
	
	private static $has_one = array(
		'VesselSurveyor' => 'SSPerson'
		, 'ScoutVessel' => 'SSVessel'
		, 'SailingSeason' => 'SSSeason'
		, 'ScoutGroup' => 'SSGroup'
		, 'SurveyForm' => 'File'
		, 'IssuedBy' => 'SSPerson'
	);
	
	public function completeCertNumber($region = 'LNI') {
		$season = SSSeason::get()->byID($this->SailingSeasonID);
		return $region . '-' . $season->Season . '-' . $this->VesselCertNumber;
	}
	
	public function getCertDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("CertificatePage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
}