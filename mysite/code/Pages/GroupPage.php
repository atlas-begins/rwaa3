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
		, 'doSaveGroup' => true
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
    
    // FORM PROCESSORS
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
    	$result->GroupZoneID = $data['GroupZoneID'];
    	$result->write();
    	echo SSGroup::getGroupDetailPageLink('view');
    	die();
    	return Director::redirect(SSGroup::getGroupDetailPageLink('view'));
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
    	return $this->customise($resultsArray)->renderWith(array('GroupPage_actions', 'Page'));
    }
    
	public function edit($request) {
    	if($result = SSGroup::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Edit "'. $result->GroupName . '"'
    			, 'Form' => self::GroupForm($result->ID)
    			, 'Group' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Group not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that group.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('GroupPage_actions', 'Page'));
    }
}
