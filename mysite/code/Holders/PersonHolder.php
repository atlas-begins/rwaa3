<?php
class PersonHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Person.png";

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Content');
        $fields->addFieldsToTab('Root.Main', new LiteralField('NoContentMsg', '<strong>NOTE:</strong> This page is data-driven and contains no Content.'));
        return $fields;
    }
    
    public function allGroupPeople() {
    	$groups = GroupHolder::getGroupInformation();
    	return $groups;
    }
    
	public static function getPersonActionPageLink($action = 'add') {
    	if($result = DataObject::get_one("PersonPage")) {
			return $result->Link() . $action;
		}
		return false;
    }
}
class PersonHolder_Controller extends Page_Controller {
	
}
