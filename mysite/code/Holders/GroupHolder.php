<?php
class GroupHolder extends Page {
	
	private static $icon = array("mysite/images/treeicons/Group.png");

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
    
    public function getGroupInformation() {
    	$results = DataList::create('SSGroup')->sort("GroupName");
    	return $results;
    }
}
class GroupHolder_Controller extends Page_Controller {
	
}
