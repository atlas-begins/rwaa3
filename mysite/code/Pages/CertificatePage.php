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
    
	public function writeCertNote($cert = null, $msg = null) {
    	if($cert && $msg) {
    		$result = new SSNote();
    		$result->NoteContents = $msg;
    		$result->AuthorID = Member::currentUser()->ID;
    		$result->CertificateID = $cert->ID;
    		$result->write();
    	}
    	return true;
    }
}
class CertificatePage_Controller extends CertificateHolder_Controller {
    
	private static $allowed_actions = array (
		'view' => true
		, 'add' => 'ADMIN'
		, 'edit' => 'ADMIN'
		, 'certificateForm' => 'ADMIN'
		, 'CertNoteForm' => true
		, 'doSaveCertNote' => true
		, 'doSaveCertificate' => 'ADMIN'
	);
	
	public function CertNoteForm() {
		$cert = SSVesselCert::get()->byID($this->request->param('ID'));
    	$fields = new FieldList();
    	$fields->push(new TextareaField('NoteContents', ''));
    	$fields->push(new HiddenField('CertificateID', 'Certificate ID', $cert->ID));
    	$fields->push(new HiddenField('VesselID', 'Vessel ID', $cert->ScoutVesselID));
    	$fields->push(new HiddenField('GroupID', 'Group ID', $cert->ScoutGroupID));
    	$actions = new FieldList(
            new FormAction('doSaveCertNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'CertNoteForm', $fields, $actions, $validator);
		return $form;
    }
    
	public function certificateForm() {
    	$fields = new FieldList();
    	$fields->push(new TextareaField('NoteContents', ''));
    	$fields->push(new HiddenField('CertificateID', 'Certificate ID', $cert->ID));
    	$fields->push(new HiddenField('VesselID', 'Vessel ID', $cert->ScoutVesselID));
    	$fields->push(new HiddenField('GroupID', 'Group ID', $cert->ScoutGroupID));
    	$actions = new FieldList(
            new FormAction('doSaveCertNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'CertNoteForm', $fields, $actions, $validator);
		return $form;
    }
    
	public function doSaveCertNote($form, $data) {
    	if($result = SSVesselCert::get_by_id("SSVesselCert", $form['CertificateID'])) {
    		self::writeCertNote($result, $form['NoteContents']);
    		$returnURL = $this->Link() . 'view/' . $form['CertificateID'];
    	}
    	return $this->redirect($returnURL);
    }
	
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
    		$resultsArray['ObjectAction'] = 'add';
			$resultsArray['Title'] = 'Add certificate for "' . $result->VesselName . '"';
			$resultsArray['Form'] = self::certificateForm($this->request->param('ID'));
	    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    	} else {
    		$resultsArray = array(
    			'Title' => 'Vessel not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that vessel and cannot create a certificate.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    	//return $this->customise($resultsArray)->renderWith(array('CertificatePage', 'Page'));
    }
}
