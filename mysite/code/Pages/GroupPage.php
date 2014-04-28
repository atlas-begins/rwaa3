<?php
class GroupPage extends GroupHolder {
	
	private static $icon = array("mysite/images/treeicons/Group.png");

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
    
    public function getGroupHolderPageLink() {
    	if($result = DataObject::get_one("GroupHolder")) {
			return $result->Link();
		}
		return false;
    }
    
}

class GroupPage_Controller extends GroupHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'add' => true
		, 'edit' => true
		, 'GroupForm' => true
		, 'PersonForm' => true
		, 'doSaveGroup' => true
		, 'doSavePerson' => true
		, 'addPerson' => true
	);
	
	// FORMS
	public function GroupForm() {
		$allZonesMap = SSZone::get()->sort("ZoneName")->map("ID", "ZoneName");
		$fields = singleton('SSGroup')->getFrontendFields();
		$fields->removeByName('GroupZoneID');
		if($this->urlParams['ID']) {
			$idField = new HiddenField("ID", "ID", $this->urlParams['ID']);
			$fields->push($idField);
		}
		$zoneField = new DropdownField('GroupZoneID', 'Zone', $allZonesMap);
			$zoneField->setEmptyString('(Select a Zone)');
			$fields->push($zoneField);
		$actions = new FieldList(
            new FormAction('doSaveGroup', 'Save changes')
        );
        $validator = new RequiredFields('GroupName', 'GroupZoneID');
		$form = new Form($this, 'GroupForm', $fields, $actions, $validator);
		if($this->urlParams['ID'] && $result = SSGroup::get()->byID($this->urlParams['ID'])) {
			$form->loadDataFrom($result);
		}
		return $form;
    }
    
	public function PersonForm($groupID = null) {
		$fields = singleton('SSPerson')->getFrontendFields();
		$fields->removeByName('ScoutGroupID');
		if($groupID) {
			$idField = new DropdownField("ScoutGroupID", "Add to group", DataList::create("SSGroup")->sort("GroupName")->map("ID", "GroupName"), $groupID);
			$fields->push($idField);
		}
		$roleMap = DataObject::get("SSRole", '', "Role")->map('ID', 'Role');
		$roleField = new CheckboxSetField(
			$name = "Roles",
			$title = "Select Roles",
			$source = $roleMap
			);
		$fields->push($roleField);
		$activeField = $fields->dataFieldByName('PersonActive'); 
		$activeField->setValue('1');
		$actions = new FieldList(
            new FormAction('doSavePerson', 'Save changes')
        );
        $validator = new RequiredFields('FirstName', 'Surname');
		$form = new Form($this, 'PersonForm', $fields, $actions, $validator);
		return $form;
    }
    
    // FORM ACTIONS
    public function doSaveGroup($data, $form) {
    	$groupID = isset($data['ID']) ? (int) $data['ID'] : false;
    	if(!$groupID) {
    		$result = new SSGroup();
    	} else {
    		$result = SSGroup::get()->byID($data['ID']);
    	}
    	$result->GroupName = $data['GroupName'];
    	$result->GroupAcronym = $data['GroupAcronym'];
    	$result->GroupBranch = $data['GroupBranch'];
    	$result->GroupLocality = $data['GroupLocality'];
    	$result->GroupWebsite = $data['GroupWebsite'];
    	$result->GroupPhone = $data['GroupPhone'];
    	$result->GroupScoutMeet = $data['GroupScoutMeet'];
    	$result->GroupVenturerMeet = $data['GroupVenturerMeet'];
    	$result->GroupZoneID = $data['GroupZoneID'];
    	$result->write();
    	$returnURL = GroupHolder::getGroupActionPageLink('view') . '/' . $result->ID;
    	return $this->redirect($returnURL);
    }
    
	public function doSavePerson($data, $form) {
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
	
    // ACTIONS
    public function view($request) {
    	if($result = SSGroup::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Details about ' . $result->GroupName
    			, 'Group' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Group not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that group.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('GroupPage', 'Page'));
    }
    
	public function add($request) {
    	$resultsArray = array(
    		'Title' => 'Add a Group'
    		, 'Form' => self::GroupForm()
    		, 'Group' => false
   		);
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function edit($request) {
    	$resultsArray = array();
    	if($result = SSGroup::get()->byID($this->request->param('ID'))) {
    		$resultsArray['Title'] = 'Edit "'. $result->GroupName . '"';
    		$resultsArray['Form'] = self::GroupForm($result->ID);
    	} else {
    		$resultsArray['Title'] = 'Group not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that group.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function addPerson($request) {
    	if($result = SSGroup::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Add a Person'
    			, 'Form' => self::PersonForm($result->ID)
    			, 'Group' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Group not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that group.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function addVessel($request) {
    	if($result = SSGroup::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Add a Vessel'
    			, 'Form' => self::GroupForm($result->ID)
    			, 'Group' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Group not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that group.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->ObjectPage_actions(array('ObjectPage_actions', 'Page'));
    }
}
