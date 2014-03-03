<?php
class SeasonPage extends SeasonHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class SeasonPage_Controller extends SeasonHolder_Controller {
	
	private static $allowed_actions = array (
		'view' => true
		, 'add' => 'ADMIN'
		, 'edit' => 'ADMIN'
	);
}
