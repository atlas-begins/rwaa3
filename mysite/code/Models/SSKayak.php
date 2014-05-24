<?php
class SSKayak extends DataObject {

	private static $db = array(
		'VesselName' => 'Varchar(128)'
		, 'VesselNumber' => 'Varchar(8)'
		, 'VesselYear' => 'Int'
		, 'VesselOarCapacityMin' => 'Int'
		, 'VesselOarCapacityMax' => 'Int'
		, 'VesselConstruction' => "Enum(array('plastic','fibreglass','wood'))"
		, 'VesselConfiguration' => "Enum(array('sit-in','sit-on'))"
		, 'VesselModel' => 'Varchar(48)'
		, 'VesselMake' => 'Varchar(48)'
		, 'VesselActive' => 'Boolean'
	);

	private static $has_one = array(
		'ScoutGroup' => 'SSGroup'
		, 'VesselGallery' => 'Folder'
	);
	
	private static $belongs_one = array(
		'ScoutGroup' => 'SSGroup'
	);
	
	private static $has_many = array(
		'SurveyCertificate' => 'SSVesselCert'
		, 'VesselNote' => 'SSNote'
		, 'VesselImage' => 'Image'
	);
	
	private static $defaults = array(
		"VesselActive" => "1"
		, "VesselOarCapacityMin" => "1"
		, "VesselOarCapacityMax" => "1"
	);
	
	public function getVesselDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("VesselPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
	
	public function getVesselCertificates() {
		if($results = SSVesselCert::get()->where("ScoutVesselID = '$this->ID'")->sort("SailingSeasonID DESC")->sort("IssueDate DESC")) {
			return $results;
		}
		return false;
	}
	
	public function getCertActionPageLink($action = 'view') {
		if($result = DataObject::get_one("CertificatePage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
	}
}