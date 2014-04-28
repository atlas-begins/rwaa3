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
		, 'add' => true
		, 'edit' => true
		, 'doSavePerson' => true
	);
	
	// FORMS
	public function PersonForm($pID = null) {
		$result = SSPerson::get()->byID($pID);
		$fields = singleton('SSPerson')->getFrontendFields();
		$fields->removeByName('ScoutGroupID');
		$idField = new DropdownField("ScoutGroupID", "Belongs to group", DataList::create("SSGroup")->sort("GroupName")->map("ID", "GroupName"));
			$fields->push($idField);
		$roleArray = array();
		if($rolesDB = DB::query("SELECT SSRoleID FROM SSPerson_PersonRole WHERE SSPersonID = '$result->ID'")) {
			foreach($rolesDB as $roleDB) {
				$roleArray[] = $roleDB['SSRoleID'];
			}
		}
		$roleMap = DataObject::get("SSRole", '', "Role")->map('ID', 'Role');
		$roleField = new CheckboxSetField(
			$name = "Roles",
			$title = "Select Roles",
			$source = $roleMap
			);
		$roleField->setDefaultItems($roleArray);
		$fields->push($roleField);
		$actions = new FieldList(
            new FormAction('doSavePerson', 'Save changes')
        );
        $validator = new RequiredFields('FirstName', 'Surname');
		$form = new Form($this, 'PersonForm', $fields, $actions, $validator);
		$form->loadDataFrom($result);
		return $form;
    }
    
    // FORMS ACTIONS
	public function doSavePerson($data) {
    	$groupID = isset($data['ScoutGroupID']) ? (int) $data['ScoutGroupID'] : false;
    	if($groupID) {
    		$result = new SSPerson();
    		$result->FirstName = $data['FirstName'];
	    	$result->Surname = $data['Surname'];
	    	$result->ScoutGroupID = $groupID;
	    	$result->PersonActive = $data['PersonActive'];
	    	$result->write();
	    	if(isset($data['Roles'])) {
	    		$pID = $result->ID;
	    		foreach($data['Roles'] as $key => $value) {
	    			DB::query("INSERT INTO SSPerson_PersonRole(SSPersonID,SSRoleID) VALUES('$pID', '$key')");
	    		}
	    	}
	    	$returnURL = PersonHolder::getPersonActionPageLink('view') . '/' . $result->ID;
	    	return $this->redirect($returnURL);
    	}
    }
	
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
    
	public function edit($request) {
    	$resultsArray = array();
    	if($result = SSPerson::get()->byID($this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Edit details for ' . $result->FirstName . ' ' . $result->Surname;
    		$resultsArray['Form'] = self::PersonForm($result->ID);
    	} else {
    		$resultsArray['Title'] = 'Person not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that person.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
}
