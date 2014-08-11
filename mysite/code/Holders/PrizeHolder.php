<?php
class PrizeHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/SSTrophy_gold.png";

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	private static $default_child = 'PrizePage';
	
	public static $prizeSeason = '8';
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
    
    public function getRecentPrizeSeasons($limit = 5) {
    	$thisDate = date("Y-m-d");
    	if($results = DataList::create("SSSeason")->where("SeasonStart < '$thisDate'")->sort("SeasonStart", "DESC")->limit($limit)) {
    		return $results;
    	}
    	return false;
    }
}
class PrizeHolder_Controller extends Page_Controller {
	private static $allowed_actions = array (
		'viewseason' => true
		, 'index' => true
	);
	
	public function viewseason($request) {
		if($this->request->param('ID')) {
			echo 'yes set';
		} else {
			echo 'not set';
		}
	}
}
