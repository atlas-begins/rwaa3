<?php
class SSPerson extends DataObject {

	private static $db = array(
		'FirstName' => 'Varchar(64)'
		, 'Surname' => 'Varchar(64)'
		, 'PersonActive' => 'Boolean'
	);
	
	private static $many_many = array(
		'PersonRole' => 'SSRole'
		, 'PersonCharge' => 'SSCharge'
	);
	
	static $has_one = array(
		'ScoutGroup' => 'SSGroup'
	);
	
	private static $defaults = array(
		'PersonActive' => 1
	);
	
	public function getPersonDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("PersonPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
}