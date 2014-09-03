<?php
class PrizePage extends PrizeHolder {

	private static $icon = "mysite/images/treeicons/SSTrophy_silver.png";
	
	private static $db = array(
	);

	private static $has_one = array(
		'Season' => 'SSSeason'
	);
	
	private static $has_many = array(
		'PrizeNote' => 'SSNote'
		, 'Trophies' => 'SSTrophy'
	);
	
	static $defaults = array(
		'ShowInMenus' => false
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
    
	public function writePrizeNote($cert = null, $msg = null) {
    	if($cert && $msg) {
    		$result = new SSNote();
    		$result->NoteContents = $msg;
    		$result->AuthorID = Member::currentUser()->ID;
    		$result->write();
    	}
    	return true;
    }
    
    public function getSeasonTrophies($sID) {
    	if($tItems = $this->Trophies()->sort("SortOrder")) {
    		$results = new ArrayList();
    		foreach($tItems as $tItem) {
    			$tItem->FirstPlace = SeasonGroupPrize::getSeasonPlaceResult($tItem->ID, $sID, '1');
    			$tItem->SecondPlace = SeasonGroupPrize::getSeasonPlaceResult($tItem->ID, $sID, '2');
    			$tItem->ThirdPlace = SeasonGroupPrize::getSeasonPlaceResult($tItem->ID, $sID, '3');
    			$results->push($tItem);
    		}
    		return $results;
    	} else {
    		return false;
    	}
    }
}
class PrizePage_Controller extends PrizeHolder_Controller {
    
	private static $allowed_actions = array (
		'view' => true
		, 'add' => 'ADMIN'
		, 'edit' => 'ADMIN'
	);
	
    public function view($request) {
    	if($result = SSVesselCert::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Survey certificate details'
    			, 'Certificate' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Certificate not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that certificate.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('PrizePage', 'Page'));
    }
    
	public function add($request) {
    	if($result = SSVessel::get()->byID($this->request->param('ID'))) {
    		$newTitle = 'Add certificate for "' . $result->VesselName . '"';
    		$newCert = Object::create("SSVesselCert");
    		$resultsArray = array(
    			'Title' => $newTitle
    			, 'Certificate' => $newCert
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Vessel not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that vessel and cannot create a certificate.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('PrizePage', 'Page'));
    }
}
