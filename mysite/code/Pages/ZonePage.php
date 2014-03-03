<?php
class ZonePage extends ZoneHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class ZonePage_Controller extends ZoneHolder_Controller {
	
	private static $allowed_actions = array (
		'view' => true
		, 'add' => true
		, 'edit' => true
	);
	
    public function view($request) {
    	if($result = SSZone::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Details about ' . $result->ZoneName . ' Zone'
    			, 'Zone' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Zone not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that zone.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('ZonePage', 'Page'));
    }
    
	public function edit() {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'edit';
		if($result = SSZone::get()->byID($this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Edit ' . $result->ZoneName . ' Zone';
    		$resultsArray['Zone'] = $result;
    	} else {
    		$resultsArray['Title'] = 'Zone not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that zone.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ZonePage_actions', 'Page'));
    }
    
	public function add() {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'add';
		$resultsArray['Title'] = 'Add a Zone';
    	return $this->customise($resultsArray)->renderWith(array('ZonePage_actions', 'Page'));
    }
}
