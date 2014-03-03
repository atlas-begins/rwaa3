<?php
class PersonPage extends PersonHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class PersonPage_Controller extends PersonHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'add' => 'ADMIN'
		, 'edit' => 'ADMIN'
	);
	
    public function view($request) {
    	if($result = SSPerson::get_by_id("SSPerson", (int)$this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Details for ' . $result->FirstName . ' ' . $result->Surname
    			, 'Person' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Person not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that person.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('PersonPage', 'Page'));
    }
}
