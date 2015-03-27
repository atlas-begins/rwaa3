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
    
	public function writePersonNote($person = null, $msg = null) {
    	if($person && $msg) {
    		$result = new SSNote();
    		$result->NoteContents = $msg;
    		$result->AuthorID = Member::currentUser()->ID;
    		$result->PersonID = $person->ID;
    		$result->write();
    	}
    	return true;
    }
}
class PersonPage_Controller extends PersonHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'add' => true
		, 'edit' => true
		, 'createCharge' => true
		, 'PersonForm' => true
		, 'PersonNoteForm' => true
		, 'PersonChargeForm' => TRUE
		, 'doSavePerson' => true
		, 'doSavePersonNote' => true
		, 'doSavePersonCharge' => true
	);
	
	// FORMS
	public function PersonForm() {
		//Create form Action
		$cancelButton = new FormAction("cancelForm");
		//Set it to use button
		$cancelButton->useButtonTag = true;
		$cancelButton->setButtonContent('No, changed my mind');
		$cancelButton->addExtraClass('cancelButton');
		$actions = new FieldList(
            new FormAction('doSavePerson', 'Save changes')
            , $cancelButton
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
		// $fields->push(new LiteralField('CancelForm', '<a id="cancelButton" href="" title="Changed my mind about this">No, changed my mind</a>'));
		return $form;
    }
    
	public function PersonNoteForm() {
		$person = SSPerson::get()->byID($this->request->param('ID'));
    	$fields = new FieldList();
    	$fields->push(new TextareaField('NoteContents', ''));
    	$fields->push(new HiddenField('PersonID', 'Person ID', $person->ID));
    	$fields->push(new HiddenField('GroupID', 'Group ID', $person->ScoutGroupID));
    	$actions = new FieldList(
            new FormAction('doSavePersonNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'PersonNoteForm', $fields, $actions, $validator);
		
		return $form;
    }
    
	public function PersonChargeForm() {
		$person = SSPerson::get()->byID($this->request->param('ID'));
    	$fields = new FieldList();
    		$pField = new HiddenField('PersonID', 'Person ID', $this->request->param('ID'));
    			$fields->push($pField);
    		$cField = new TextField('ChargeNumber', 'Charge Number');
    			$fields->push($cField);
    		$dField = new DateField('IssueDate', 'Issue Date');
				$dField->setConfig('datavalueformat', 'yyyy-MM-dd'); // global setting
				$dField->setConfig('showcalendar', 1); // field-specific setting
				$dField->setLocale('en_NZ');
    			$fields->push($dField);
    		
    	$actions = new FieldList(
            new FormAction('doSavePersonCharge', 'Save Charge')
        );
        $validator = new RequiredFields('Issue Date', 'Charge Number');
		$form = new Form($this, 'PersonChargeForm', $fields, $actions, $validator);
		
		return $form;
    }
    
    // FORMS ACTIONS
	public function doSavePerson($data) {
    	$groupID = isset($data['ScoutGroupID']) ? (int) $data['ScoutGroupID'] : false;
    	if(!$data['ID']) {
    		$result = new SSPerson();
    		$msg = 'Created new person record';
    	} else {
    		$result = SSPerson::get()->byID($data['ID']);
    		$msg = 'Edited person record';
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
	   	self::writePersonNote($result, $msg);
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
    
	public function doSavePersonNote($form, $data) {
    	if($result = SSPerson::get_by_id("SSPerson", $form['PersonID'])) {
    		self::writePersonNote($result, $form['NoteContents']);
    		$returnURL = $this->Link() . 'view/' . $form['PersonID'];
    	}
    	return $this->redirect($returnURL);
    }
    
	public function doSavePersonCharge($form, $data) {
		print_r($form['PersonID'] . '<br>');
		
		die();
		
    	if($result = SSPerson::get_by_id("SSPerson", $form['PersonID'])) {
    		$result = new SSCharge();
    		$form->saveInto($result);
    		$result->write();
    		$returnURL = $this->Link() . 'view/' . $form['PersonID'];
    	}
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
    
	public function createCharge($request) {
    	$resultsArray = array();
    	if($result = SSPerson::get_by_id("SSPerson", (int)$this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Create a charge certificate for ' . $result->FirstName . ' ' . $result->Surname;
    		$resultsArray['Form'] = self::PersonChargeForm($result->ID);
    	} else {
    		$resultsArray['Title'] = 'Person not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that person.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
}
