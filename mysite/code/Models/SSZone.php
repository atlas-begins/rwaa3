<?php
class SSZone extends DataObject {

	private static $db = array(
		'ZoneName' => 'Varchar(128)'
	);

	private static $has_many = array(
		'ScoutGroups' => 'SSGroup'
	);
	
	public function getZoneDetailPageLink($action = 'view') {
		switch ($action) {
			case 'add':
				if($result = DataObject::get_one("ZonePage")) {
					return $result->Link() . $action;
				}
			break;
			default:
				if($result = DataObject::get_one("ZonePage")) {
					return $result->Link() . $action . '/' . $this->ID;
				}
			break;
		}
		
		return false;
	}
	
	public function getZoneByID($zID) {
		if($result = DataList::create("SSZone")->byID($zID)) {
			return $result;
		}
	}
	
	public function getZoneByName($zName) {
		if($result = DataList::create("SSZone")->filter('GroupName', $zName)->First()) {
			return $result;
		}
	}
	
	/*
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
		if(class_exists('SSZone')) {
			$acts = array(
				'Taranaki'
				, 'New Horizons'
				, 'Waiapu'
				, 'Manawatu Rivers'
				, 'Kapiti Coastal'
				, 'Rimutaka'
				, 'Lower Hutt'
				, 'Wellington'
			);
			foreach($acts as $key => $value) {
				if(!$xZone = DataList::create("SSZone")->filter("ZoneName", $value)) {
					$result = Object::create("SSZone");
					$result->ZoneName = $value;
					$result->write();
				}
			}
		}
	}
	*/
}