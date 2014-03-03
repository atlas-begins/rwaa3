<?php
class CertificatePage extends CertificateHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class CertificatePage_Controller extends CertificateHolder_Controller {
    
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
    	return $this->customise($resultsArray)->renderWith(array('CertificatePage', 'Page'));
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
    	return $this->customise($resultsArray)->renderWith(array('CertificatePage', 'Page'));
    }
}
