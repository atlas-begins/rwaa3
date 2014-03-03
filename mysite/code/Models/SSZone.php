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
}