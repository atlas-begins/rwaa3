<?php
class ZoneHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Zone.png";

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
    
	public function getAllZones() {
		if($results = DataList::create("SSZone")->sort("ZoneName")) {
			return $results;
		}
    	return false;
    }
    
    public function getZoneLink($action = 'view') {
    	switch ($action) {
			case 'add':
				if($result = DataObject::get_one("ZonePage")) {
					return $result->Link() . $action;
				}
			break;
			default:
				if($result = DataObject::get_one("ZonePage")) {
					return $result->Link() . $action . '/' . $this->ID;
				}
			break;
		}
    }
}
class ZoneHolder_Controller extends Page_Controller {
	
}
