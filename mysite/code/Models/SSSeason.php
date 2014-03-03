<?php
class SSSeason extends DataObject {

	private static $db = array(
		'Season' => 'Varchar(128)'
		, 'SeasonStart' => 'SS_Datetime'
		, 'SeasonEnd' => 'SS_Datetime'
	);
	
	private static $has_many = array(
		'ScoutVesselCerts' => 'SSVesselCert'
	);
	
	public function SeasonClass() {
		$refDate = strtotime(date("Y-m-d"));
		$dateW1 = strtotime($this->SeasonStart);
		$dateW2 = strtotime($this->SeasonEnd);
		if(($refDate > $dateW1) && ($refDate < $dateW2)) {
			return 'currentSeason branch_Sea';
		}
	}
	
	public function getSeasonDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("SeasonPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
}