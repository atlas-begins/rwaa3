<?php
class SSPerson extends DataObject {

	private static $db = array(
		'FirstName' => 'Varchar(64)'
		, 'Surname' => 'Varchar(64)'
		, 'PersonActive' => 'Boolean'
	);
	
	private static $many_many = array(
		'PersonRole' => 'SSRole'
	);
	
	static $has_one = array(
		'ScoutGroup' => 'SSGroup'
		, 'PersonCharge' => 'SSCharge'
		
	);
	
	private static $has_many = array(
		'PersonNote' => 'SSNote'
	);
	
	private static $defaults = array(
		'PersonActive' => 1
	);
	
	private static $searchable_fields = array(
		'FirstName'
		, 'Surname'
		, 'PersonRole.Role'
	);
	
	public function getPersonDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("PersonPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
	
	public function getReportPageLink($action = 'report') {
		if($result = DataObject::get_one("PersonReportPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
	
	public function sortedPersonNote() {
		return $results = $this->PersonNote()->sort("Created", "DESC");
	}
	
}