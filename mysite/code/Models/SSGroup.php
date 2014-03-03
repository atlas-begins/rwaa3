<?php
class SSGroup extends DataObject {

	private static $db = array(
		'GroupName' => 'Varchar(128)'
		, 'GroupAcronym' => 'Varchar(8)'
		, 'GroupBranch' => 'Enum(array("Sea","Land","Air"))'
		, 'GroupLocality' => 'Varchar(64)'
		, 'GroupWebsite' => 'Varchar(128)'
		, 'GroupAddress' => 'Varchar(128)'
		, 'GroupPhone' => 'Varchar(24)'
	);
	
	static $has_one = array(
		'GroupZone' => 'SSZone'
	);
	
	static $has_many = array(
		'GroupVessels' => 'SSVessel'
		, 'GroupPeople' => 'SSPerson'
	);
	
	private static $defaults = array(
		'GroupBranch' => 'Sea'
	);
    
	public function getGroupDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("GroupPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
}