<?php
class SeasonHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Season.png";

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Content');
        $fields->addFieldsToTab('Root.Main', new LiteralField('NoContentMsg', '<strong>NOTE:</strong> This page is data-driven and contains no Content.'));
        return $fields;
    }
    
	public function getAllSeasons() {
		if($results = DataList::create("SSSeason")->sort('"SeasonStart" DESC')) {
			return $results;
		}
    	return false;
    }
    
    public function getCurrentSeason() {
    	$seasons = self::getAllSeasons();
    	$refDate = strtotime(date("Y-m-d"));
    	foreach($seasons as $season) {
			$dateW1 = strtotime($season->SeasonStart);
			$dateW2 = strtotime($season->SeasonEnd);
			if(($refDate > $dateW1) && ($refDate < $dateW2)) {
				return $season;
				break;
			}
    	}
    }
}
class SeasonHolder_Controller extends Page_Controller {
	
}
