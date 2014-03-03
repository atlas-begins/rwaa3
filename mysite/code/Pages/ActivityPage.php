<?php
class ActivityPage extends ActivityHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class ActivityPage_Controller extends ActivityHolder_Controller {
	
	private static $allowed_actions = array (
		'view' => true
		, 'add' => 'ADMIN'
		, 'edit' => 'ADMIN'
	);
}
