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
		, 'GroupScoutMeet' => 'Varchar(24)'
		, 'GroupVenturerMeet' => 'Varchar(24)'
		, 'Lat' => 'Varchar(16)'
		, 'Lng' => 'Varchar(16)'
	);
	
	static $has_one = array(
		'GroupZone' => 'SSZone'
	);
	
	static $has_many = array(
		'GroupVessels' => 'SSVessel'
		, 'GroupPeople' => 'SSPerson'
		, 'GroupNote' => 'SSNote'
	);
	
	private static $defaults = array(
		'GroupBranch' => 'Sea'
	);
	
	private static $searchable_fields = array(
		'GroupName'
		, 'GroupZone.ZoneName'
		, 'GroupPeople.FirstName'
		, 'GroupPeople.Surname'
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
	
	public function getGroupAddVesselLink($action = 'view', $groupID = null) {
		if($result = DataObject::get_one("VesselPage")) {
			return $result->Link() . 'add/Vessel';
		}
		return false;
	}
	
	public function getGroupAddCertificates() {
		if($result = DataObject::get_one("GroupPage")) {
			return $result->Link() . 'certificates/' . $this->ID;
		}
		return false;
	}
	
	public function sortedGroupNote() {
		return $results = $this->GroupNote()->sort("Created", "DESC");
	}
	
	/*
	public static function requireDefaultRecords() {
		parent::requireDefaultRecords();
		if(class_exists('SSGroup')) {
			$gArray = new ArrayList();
			$gArray[] = array('GroupName' => 'Britannia', 'GroupAcronym' => 'BR', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Wellington');
			$gArray[] = array('GroupName' => 'Eastern Bays', 'GroupAcronym' => 'EB', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Miramar');
			$gArray[] = array('GroupName' => 'St James', 'GroupAcronym' => 'SJ', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Petone');
			$gArray[] = array('GroupName' => 'Ngati Toa', 'GroupAcronym' => 'NT', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Mana');
			$gArray[] = array('GroupName' => 'Paraparaumu Beach', 'GroupAcronym' => 'PB', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Paraparaumu Beach');
			$gArray[] = array('GroupName' => 'Kotuku', 'GroupAcronym' => 'KT', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Levin');
			$gArray[] = array('GroupName' => 'Westshore', 'GroupAcronym' => 'WS', 'GroupBranch' => 'Sea', 'GroupLocality' => 'Napier');
			$gArray[] = array('GroupName' => 'St Augustines', 'GroupAcronym' => 'SA', 'GroupBranch' => 'Land', 'GroupLocality' => 'Lower Hutt');
			foreach($gArray as $gArrayV) {
				if(!$xGrp = DataList::create("SSGroup")->filter("GroupName", $gArrayV['GroupName'])) {
					$result = new SSGroup($gArrayV);
					$result->write();
				}
			}
		}
	}
	*/
}