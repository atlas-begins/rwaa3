<?php
class TrophyPage extends Page {

	private static $icon = "mysite/images/treeicons/SSTrophy_silver.png";
	
	private static $db = array(
	);
	
	private static $has_many = array();
	
	static $defaults = array(
		'ShowInMenus' => false
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
	}
}
class TrophyPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
	}
	
	private static $allowed_actions = array (
		'view' => true
		, 'edit' => 'ADMIN'
	);
	
    public function view($request) {
    	if($result = SSTrophy::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Records for "' . $result->TrophyName . '"'
    			, 'Result' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Trophy not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that trophy.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('TrophyPage', 'Page'));
    }
}
