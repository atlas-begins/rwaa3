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
}
class GroupPage_Controller extends GroupHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'add' => 'ADMIN'
		, 'edit' => 'ADMIN'
	);
	
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
}
