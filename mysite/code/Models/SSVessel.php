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
		'VesselActive' => 1
		, 'VesselSailCapacityMin' => 0
		, 'VesselOarCapacityMin' => 0
		, 'VesselMotorCapacityMin' => 0
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
	
	public static function vesselMinMax($vtype = null) {
		if($vtype) {
			$vSpecs = array();
			switch ($vtype) {
				case 'Cutter':
					$vSpecs['MinOar'] = '3';
					$vSpecs['MaxOar'] = '10';
					$vSpecs['MinSail'] = '3';
					$vSpecs['MaxSail'] = '7';
					$vSpecs['MinMotor'] = '0';
					$vSpecs['MaxMotor'] = '0';
				break;
				case 'Sunburst':
					$vSpecs['MinOar'] = '1';
					$vSpecs['MaxOar'] = '3';
					$vSpecs['MinSail'] = '2';
					$vSpecs['MaxSail'] = '3';
					$vSpecs['MinMotor'] = '0';
					$vSpecs['MaxMotor'] = '0';
				break;
				case 'Kayak':
					$vSpecs['MinOar'] = '1';
					$vSpecs['MaxOar'] = '1';
					$vSpecs['MinSail'] = '0';
					$vSpecs['MaxSail'] = '0';
					$vSpecs['MinMotor'] = '0';
					$vSpecs['MaxMotor'] = '0';
				break;
			}
			return $vSpecs;
		} return false;
	}
}