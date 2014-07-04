<?php
class RegattaPage extends RegattaHolder {
	
	private static $icon = "mysite/images/treeicons/Regatta.png";
	
	private static $db = array(
		'RegattaDate' => 'SS_DateTime'
	);
	
	static $has_one = array(
		'Season' => 'SSSeason'
		, 'RegattaType' => 'SSRegattaType'
	);
	
	private static $has_many = array(
		'RegattaEvents' => 'SSRegattaEvent'
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        $rSrc = DataList::create("SSRegattaType")->sort("RegattaDescription")->map("ID","RegattaDescription");
        $fields->removeByName('NoContentMsg');
        $fields->addFieldToTab('Root.Main', $cfield1 = new HtmlEditorField('Content'), 'Metadata');
        	$cfield1->setRows(4);
        $fields->addFieldToTab('Root.Main', $cfield2 = new DropdownField('RegattaTypeID', 'What type of regatta is this?', $rSrc), 'Content');
        $cfield3 = new DatetimeField('RegattaDate', 'Regatta date and time');
	        $cfield3->getDateField()->setConfig('showcalendar', true);
        $fields->addFieldToTab('Root.Main', $cfield3, 'Content');
        $fields->addFieldToTab('Root.RegattaEvents', $rfield1 = new TextField('abcdefg', 'sampler'));
        return $fields;
    }
    
    public function onAfterWrite() {
    	parent::onAfterWrite();
    	// need to set season based on regatta date
    }
}
class RegattaPage_Controller extends RegattaHolder_Controller {

	private static $allowed_actions = array (
		
	);
	
	// FORMS
	public function RegattaForm() {
		return true;
    }
}
