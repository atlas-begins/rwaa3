<?php
class CertificateHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Certificate.png";

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
}
class CertificateHolder_Controller extends Page_Controller {
	
	
}
