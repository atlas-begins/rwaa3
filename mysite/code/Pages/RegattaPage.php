<?php
class RegattaPage extends RegattaHolder {
	
	private static $icon = "mysite/images/treeicons/Regatta.png";
	
	private static $db = array();
	
	static $has_one = array(
		'RegattaCourse' => 'File'
	);
	
	private static $many_many = array(
		'RegattaEvents' => 'SSRegattaEvent'
		, 'RegattaPrizes' => 'SSTrophy'
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('NoContentMsg');
        
        
        $fields->addFieldToTab('Root.Main', $cfield0 = new HtmlEditorField('Content'), 'Metadata');
        	$cfield0->setRows(4);
        //$fields->addFieldToTab('Root.Main', $cfield1 = new TreeDropdownField("RegattaCourseID", "Select course map:", "Image"), 'Content');
        $eventTypeSrc = DataList::create("SSRegattaEvent")->sort("EventOrder")->map("ID", "EventDescription");
        $fields->addFieldToTab('Root.RegattaEvents', $rfield1 = new CheckboxSetField("RegattaEvents", "Regatta Events", $eventTypeSrc));
        $TrophySrc = DataList::create("SSTrophy")->sort("TrophyName")->map("ID", "TrophyName");
        $fields->addFieldToTab('Root.Prizes', $rfield2 = new CheckboxSetField("RegattaPrizes", "Regatta Prizes", $TrophySrc));
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
