<?php
class VesselPage extends VesselHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class VesselPage_Controller extends VesselHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'edit' => 'ADMIN'
		, 'add' => 'ADMIN'
		
	);
	
	public function view($request) {
    	if($result = SSVessel::get_by_id("SSVessel", (int)$this->request->param('ID'))) {
    		$namedetail = '';
    		if($result->VesselName) $namedetail = ' for "' . $result->VesselName . '"';
    		$resultsArray = array(
    			'Title' => 'Details' . $namedetail
    			, 'Vessel' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Vessel not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that vessel.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('VesselPage', 'Page'));
    }
    
	public function edit() {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'edit';
		if($result = SSVessel::get()->byID($this->request->param('ID'))) {
			$namedetail = ' for ';
			if($result->VesselName) {
				$namedetail .= '"' . $result->VesselName .'"';
			} else {
				$namedetail .= $result->VesselClass . ' ' . $result->VesselNumber;
			}
    		$resultsArray['Title'] = 'Edit details' . $namedetail;
    		$resultsArray['Vessel'] = $result;
    	} else {
    		$resultsArray['Title'] = 'Vessel not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that vessel.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('VesselPage_actions', 'Page'));
    }
}
