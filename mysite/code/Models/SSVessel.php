<?php
class SSVessel extends DataObject {

	private static $db = array(
		'VesselName' => 'Varchar(128)'
		, 'VesselNumber' => 'Varchar(8)'
		, 'VesselYear' => 'Int'
		, 'VesselSailCapacityMin' => 'Int'
		, 'VesselSailCapacityMax' => 'Int'
		, 'VesselOarCapacityMin' => 'Int'
		, 'VesselOarCapacityMax' => 'Int'
		, 'VesselMotorCapacityMin' => 'Int'
		, 'VesselMotorCapacityMax' => 'Int'
		, 'VesselConstruction' => "Enum(array('wood','fibreglass', 'GRP', 'RIB','plastic'))"
		, 'VesselClass' => "Enum(array('cutter','kayak','dinghy','sunburst','crown','whaler','RIB','optimist'))"
		, 'VesselActive' => 'Boolean'
		, 'VesselRig' => "Enum(array('none','Bermuda','Gunter','Sloop', 'Sunburst', 'Optimist', 'other'))"
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
		, 'VesselSailCapacityMax' => 0
		, 'VesselOarCapacityMax' => 0
		, 'VesselMotorCapacityMax' => 0
	);
	
	private static $searchable_fields = array(
		'VesselName'
		, 'VesselNumber'
	);
	
	public function getVesselDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("VesselPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
	
	public function getVesselNewestCertificate() {
		if($result = DataList::create("SSVesselCert")->where("ScoutVesselID = '$this->ID'")->sort("SailingSeasonID DESC")->limit(1)) {
			return $result;
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
	
	public static function getGroupVesselMap($gID) {
		if($vessels = DataList::create("SSVessel")->filter(array('ScoutGroupID' => $gID))->sort('VesselClass')) {
			$results = new ArrayList();
			foreach($vessels as $vessel) {
				$vessel->Fullname = '[' . $vessel->VesselClass . '] ' . $vessel->VesselName;
				$results->push($vessel);
			}
			return $results;
		}
		return false;
	}
	
	public static function vesselCapacityArray() {
		return array('0'=>'0', '1'=>'1', '2'=>'2', '3'=>'3', '7'=>'7', '10'=>'10');
	}
	
	public function sortedVesselNote() {
		return $results = $this->VesselNote()->sort("Created", "DESC");
	}
}