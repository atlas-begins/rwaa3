<?php
class SSSeason extends DataObject {

	private static $db = array(
		'Season' => 'Varchar(128)'
		, 'SeasonStart' => 'SS_Datetime'
		, 'SeasonEnd' => 'SS_Datetime'
	);
	
	static $seasonID = 0;
	
	private static $has_many = array(
		'ScoutVesselCerts' => 'SSVesselCert'
		, 'SeasonPrizes' => 'SeasonGroupPrize'
	);
	
	public function SeasonClass() {
		$refDate = strtotime(date("Y-m-d"));
		$dateW1 = strtotime($this->SeasonStart);
		$dateW2 = strtotime($this->SeasonEnd);
		if(($refDate > $dateW1) && ($refDate < $dateW2)) {
			return 'currentSeason branch_Air';
		}
	}
	
	public function getSeasonDetailPageLink($action = 'view') {
		if($result = DataObject::get_one("SeasonPage")) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
	}
	
	public function getPrizeHolderSeasonLink($action = 'viewseason') {
    	if($result = DataList::create("PrizeHolder")->First()) {
			return $result->Link() . $action . '/' . $this->ID;
		}
		return false;
    }
	
	public function getSortedPrizePages($sID) {
		$pPages = PrizePage::get()->sort("Sort");
		$season = DataObject::get_by_id("SSSeason", $sID);
    	if($pPages) {
    		$results = new ArrayList();
    		foreach($pPages as $pPage) {
    			$pPage->SeasonID = $season->ID;
    			$pPage->SeasonName = $season->Season;
    			$results->push($pPage);
    		}
    		return $results;
    	} else {
    		return false;
    	}
	}
	
	public static function getCurrentSeason() {
		$refDate = strtotime(date("Y-m-d"));
		$dateW1 = strtotime($this->SeasonStart);
		$dateW2 = strtotime($this->SeasonEnd);
		return DataList::create("SSSeason")->filter(array($refDate > 'SeasonStart', $refDate < 'SeasonEnd'))->first();
	}
}