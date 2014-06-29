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
    
	public function clearRoles($pID) {
		DB::query("DELETE FROM SSPerson_PersonRole WHERE SSPersonID = '$pID'");
		return true;
	}
}
class PersonPage_Controller extends PersonHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'add' => true
		, 'edit' => true
		, 'doSavePerson' => true
		, 'PersonForm' => true
		, 'PersonNoteForm' => true
	);
	
	// FORMS
	public function PersonForm() {
		$actions = new FieldList(
            new FormAction('doSavePerson', 'Save changes')
        );
        $validator = new RequiredFields('FirstName', 'Surname');
		$allGroupsMap = SSGroup::get()->sort("GroupName")->map("ID", "GroupName");
		$groupField = new DropdownField('ScoutGroupID', 'Scout Group', $allGroupsMap);
			$groupField->setEmptyString('(Select a Group)');
		$roleMap = SSRole::get()->sort("Role")->map('ID', 'Role');
		$fields = singleton('SSPerson')->getFrontendFields();
		$form = new Form($this, 'PersonForm', $fields, $actions, $validator);
		$fields->replaceField('ScoutGroupID', $groupField);
		$roleField = new CheckboxSetField(
			$name = "Roles",
			$title = "Select Roles",
			$source = $roleMap
		);
		if($pID = $this->urlParams['ID']) {
			$fields->push(new HiddenField("ID", "ID", $pID));
			if($result = SSPerson::get()->byID($pID)) {
				if($roles = $result->PersonRole()) {
					$currentRoles = array();
					foreach($roles as $role) {
						$currentRoles[] = $role->ID;
					}
					$roleField->setDefaultItems($currentRoles);
				}
				$form->loadDataFrom($result);
			}
		}
		
		$fields->push($roleField);
		return $form;
    }
    
	public function PersonNoteForm() {
    	$fields = new FieldList();
    	$fields->push(new TextareaField('NoteContents', ''));
    	$fields->push(new HiddenField('PersonID', 'Person ID', $this->request->param('ID')));
    	$actions = new FieldList(
            new FormAction('doSavePersonNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'PersonNoteForm', $fields, $actions, $validator);
		
		return $form;
    }
    
    // FORMS ACTIONS
	public function doSavePerson($data) {
    	$groupID = isset($data['ScoutGroupID']) ? (int) $data['ScoutGroupID'] : false;
    	if(!$data['ID']) {
    		$result = new SSPerson();
    	} else {
    		$result = SSPerson::get()->byID($data['ID']);
    	}
    	if(isset($data['PersonActive'])) {
    		$result->PersonActive = true;
    	} else {
    		$result->PersonActive = false;
    	}
    	if(isset($data['ScoutGroupID'])) {
    		$result->ScoutGroupID = $groupID;
    	} else {
    		$result->ScoutGroupID = 0;
    	}
    	$result->FirstName = $data['FirstName'];
	   	$result->Surname = $data['Surname'];
	   	$result->write();
	   	self::clearRoles($result->ID);
    	if(isset($data['Roles'])) {
    		$pID = $result->ID;
    		foreach($data['Roles'] as $key => $value) {
    			DB::query("INSERT INTO SSPerson_PersonRole(SSPersonID,SSRoleID) VALUES('$pID', '$key')");
    		}
    	}
	   	$returnURL = PersonHolder::getPersonActionPageLink('view') . '/' . $result->ID;
	   	return $this->redirect($returnURL);
    }
	
    public function view($request) {
    	$resultsArray = array();
    	if($result = SSPerson::get_by_id("SSPerson", (int)$this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Details for ' . $result->FirstName . ' ' . $result->Surname;
    		$resultsArray['Person'] = $result;
    	} else {
    		$resultsArray['Title'] = 'Person not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that person.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('PersonPage', 'Page'));
    }
    
	public function edit($request) {
    	$resultsArray = array();
    	if($result = SSPerson::get_by_id("SSPerson", (int)$this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Edit details for ' . $result->FirstName . ' ' . $result->Surname;
    		$resultsArray['Form'] = self::PersonForm($result->ID);
    	} else {
    		$resultsArray['Title'] = 'Person not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that person.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
}
