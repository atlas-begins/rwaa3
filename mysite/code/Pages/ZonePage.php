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
		, 'ZoneForm' => true
		, 'doSaveZone' => true
	);
	
	// FORMS
	public function ZoneForm() {
        $fields = singleton('SSZone')->getFrontendFields();
        $actions = new FieldList(
            new FormAction('doSaveZone', 'Save changes')
        );
        $validator = new RequiredFields();
        $form = new Form($this, 'ZoneForm', $fields, $actions, $validator);
		if($this->urlParams['ID'] && $result = SSZone::get()->byID($this->urlParams['ID'])) {
			$fields->push(new HiddenField("ID", "ID", $this->urlParams['ID']));
			$form->loadDataFrom($result);
		}
        return $form;
    }
    
    // FORM ACTIONS
    public function doSaveZone($form) {
    	$zID = isset($form['ID']) ? (int) $form['ID'] : false;
    	if(!$zID) {
    		$result = new SSZone();
    	} else {
    		$result = SSZone::get()->byID($form['ID']);
    		$result->write();
    	}
    	$result->ZoneName = $form['ZoneName'];
    	$result->write();
    	$returnURL = ZoneHolder::getZoneActionPageLink('view') . '/' . $result->ID;
    	return $this->redirect($returnURL);
    }
	
    // OTHER ACTIONS
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
		if($result = SSZone::get()->byID($this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Edit ' . $result->ZoneName . ' Zone';
    		$resultsArray['Form'] = self::ZoneForm($result->ID);
    	} else {
    		$resultsArray['Title'] = 'Zone not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that zone.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function add() {
		$resultsArray = array(
    		'Title' => 'Add a Zone'
    		, 'Form' => self::ZoneForm()
   		);
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
}
