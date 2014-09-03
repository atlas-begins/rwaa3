<?php
class SeasonGroupPrize extends DataObject {

	private static $db = array(
		'Finish' => 'Int'
	);
	
	static $has_one = array(
		'Season' => 'SSSeason'
		, 'Group' => 'SSGroup'
		, 'Trophy' => 'SSTrophy'
	);
	
	private static $defaults = array(
		'Finish' => "Enum(array('1','2','3'))"
	);
	
	/**
	 * 
	 * returns record based on trophy, season and position
	 * @param int $tItem trophy id
	 * @param int $sID season id
	 * @param int $fID finish id
	 */
	public static function getSeasonPlaceResult($tID, $sID, $fID) {
		if($placeResults = DataObject::get("SeasonGroupPrize")->filter(array("SeasonID" => $sID, "Finish" => $fID, "TrophyID" => $tID))) {
			return $placeResults;
		}
	}
}