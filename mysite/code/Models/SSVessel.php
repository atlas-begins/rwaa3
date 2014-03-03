<?php
class SSVessel extends DataObject {

	private static $db = array(
		'VesselName' => 'Varchar(128)'
		, 'VesselNumber' => 'Varchar(8)'
		, 'VesselYear' => 'Int'
		, 'VesselSailCapacityMax' => 'Int'
		, 'VesselMotorCapacityMax' => 'Int'
		, 'VesselOarCapacityMax' => 'Int'
		, 'VesselSailCapacityMin' => 'Int'
		, 'VesselOarCapacityMin' => 'Int'
		, 'VesselMotorCapacityMin' => 'Int'
		, 'VesselConstruction' => "Enum(array('wood','fibreglass','RIB','plastic'))"
		, 'VesselClass' => "Enum(array('cutter','kayak','dinghy','sunburst','crown','whaler','RIB','optimist'))"
		, 'VesselActive' => 'Boolean'
	);

	private static $has_one = array(
		'ScoutGroup' => 'SSGroup'
	);
	
	private static $belongs_one = array(
		'ScoutGroup' => 'SSGroup'
	);
	
	private static $has_many = array(
		'SurveyCertificate' => 'SSVesselCert'
	);
	
	private static $defaults = array(
		'VesselActive' => 1
		, 'VesselSailCapacityMin' => 1
		, 'VesselOarCapacityMin' => 1
		, 'VesselMotorCapacityMin' => 1
	);
	
	public function getVesselDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("VesselPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
	
	public function getVesselCertificates() {
		if($results = SSVesselCert::get()->where("ScoutVesselID = '$this->ID'")->sort("SailingSeasonID DESC")) {
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