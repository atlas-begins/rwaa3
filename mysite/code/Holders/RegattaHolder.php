<?php
class RegattaHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Regatta.png";

	private static $db = array(
	);
	
	private static $default_child = 'RegattaPage';

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Content');
        $fields->addFieldsToTab('Root.Main', new LiteralField('NoContentMsg', '<strong>NOTE:</strong> This page is data-driven and contains no Content.'));
        return $fields;
    }
}
class RegattaHolder_Controller extends Page_Controller {
	
}
