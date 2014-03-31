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
		, 'VesselNote' => 'SSNote'
	);
	
	private static $defaults = array(
		'GroupBranch' => 'Sea'
	);
    
	public function getGroupDetailPageLink($action = 'view', $groupID = null) {
		if($result = DataObject::get_one("GroupPage")) {
			$useID = $this->ID;
			if($groupID) {
				$useID = $groupID;
			}
			return $result->Link() . $action . '/' . $useID;
		}
		return false;
	}
}