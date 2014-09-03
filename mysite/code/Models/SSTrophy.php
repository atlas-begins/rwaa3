<?php
class SSTrophy extends DataObject {

	private static $db = array(
		'TrophyName' => 'Varchar(128)'
		, 'AwardedFor' => 'Varchar(256)'
		, 'History' => 'Text'
		, 'Year' => 'Int'
		, 'SortOrder' => 'Int'
	);
	
	private static $has_one = array(
        'TrophyImage' => 'Image'
        , 'PrizePage' => 'PrizePage'
    );
    
    private static $has_many = array(
		'TrophyNote' => 'SSNote'
		, 'SeasonPrizes' => 'SeasonGroupPrize'
	);
    
    public function getUnselected() {
    	$results = SSTrophy::get()->where("\"PrizePage\" = '0'")->sort("TrophyName");
    	return $results;
    }
    
    public function getTrophySeasonAward($sID = 0) {
    	$tID = $this->ID;
    	$result = new DataObject();
    	$result->FirstPlace = self::getTrophySeasonPlaceResults($sID, $tID, 1);
    	$result->SecondPlace = self::getTrophySeasonPlaceResults($sID, $tID, 2);
    	$result->ThirdPlace = self::getTrophySeasonPlaceResults($sID, $tID, 3);
    }
    
	public function getTrophyWinner() {
		$tID = $this->ID;
		$result = SeasonGroupPrize::getTrophyWinners($tID);
    	return true;
    }
    
    /**
     * 
     * retrieves a record of finishes for a particular trophy 
     * @param int $sID season id
     * @param int $tID trophy id
     * @param int $fID finish place
     * @return datalist $results
     */
    public function getTrophySeasonPlaceResults($sID, $tID, $fID) {
    	return DataList::create("SeasonGroupPrize")->where("SeasonID = '$sID' AND TrophyID = '$tID' AND Finish = '$fID'");
    }
    
    public function getTrophyDetailPage($action = 'view') {
    	if($result = DataObject::get_one("TrophyPage")) {
    		return $result->Link() . $action . '/' . $this->ID;
    	}
    	return false;
    }
    
	public function sortedTrophyNote() {
		return $results = $this->TrophyNote()->sort("Created", "DESC");
	}
	
	public function getWinnerList() {
		if($seasonlist = DB::query("SELECT distinct seasonid FROM seasongroupprize inner join ssseason on seasongroupprize.seasonid = ssseason.id ORDER BY ssseason.season desc")) {
			$results = new ArrayList();
			foreach($seasonlist as $seasonObj) {
				$sID = $seasonObj['seasonid'];
				$tID = $this->ID;
				$result = new DataObject();
				$result->Season = DataObject::get_by_id("SSSeason", $sID);
	    		$result->FirstPlace = self::getTrophySeasonPlaceResults($sID, $tID, 1);
	    		$result->SecondPlace = self::getTrophySeasonPlaceResults($sID, $tID, 2);
	    		$result->ThirdPlace = self::getTrophySeasonPlaceResults($sID, $tID, 3);
				$results->push($result);
    		}
    		return $results;
    	} else {
    		return false;
    	}
	}
}