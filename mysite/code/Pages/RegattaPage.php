<?php
class RegattaPage extends RegattaHolder {
	
	private static $icon = "mysite/images/treeicons/Regatta.png";
	
	private static $db = array(
		'RegattaDate' => 'SS_DateTime'
		, 'RegattaStatus' => "Enum(array('Upcoming','Cancelled - weather','Postponed','Run - successfully'))"
		, 'WaterTemp' => 'Decimal'
		, 'RegattaLocation' => "Enum(array('Onepoto','Kapiti','Evans Bay','Lowry Bay','Worser Bay','Westshore'))"
		, 'AttendanceJunior' => 'Int'
		, 'AttendanceIntermediate' => 'Int'
		, 'AttendanceSenior' => 'Int'
		, 'AttendanceAdult' => 'Int'
	);
	
	static $has_one = array(
		'RegattaCourse' => 'File'
		, 'SailingSeason' => 'SSSeason'
	);
	
	private static $many_many = array(
		'RegattaEvents' => 'SSRegattaEvent'
		, 'RegattaPrizes' => 'SSTrophy'
	);
	
	public function getCMSFields() {
		// sources
		$TrophySrc = DataList::create("SSTrophy")->sort("TrophyName")->map("ID", "TrophyName");
		$SeasonSrc = DataList::create("SSSeason")->sort("SeasonStart", 'DESC')->map("ID", "Season");
		$StatusSrc = singleton('RegattaPage')->dbObject('RegattaStatus')->enumValues();
		
		//fields
        $fields = parent::getCMSFields();
        $fields->removeByName('NoContentMsg');
        $fields->addFieldToTab('Root.Main', $cfield0 = new HtmlEditorField('Content'), 'Metadata');
        	$cfield0->setRows(4);
        //$fields->addFieldToTab('Root.Main', $cfield1 = new TreeDropdownField("RegattaCourseID", "Select course map:", "Image"), 'Content');
        $eventTypeSrc = DataList::create("SSRegattaEvent")->sort("EventOrder")->map("ID", "EventDescription");
        $fields->addFieldToTab('Root.RegattaEvents', $rfield1 = new CheckboxSetField("RegattaEvents", "Regatta Events", $eventTypeSrc));
        $fields->addFieldToTab('Root.Prizes', $rfield2 = new CheckboxSetField("RegattaPrizes", "Regatta Prizes", $TrophySrc));
        
        // details tab
        $sField = new DropdownField('SailingSeasonID', 'Sailing season', $SeasonSrc);
        	$sField->setEmptyString('Select a season');
        $dField = new DateField('RegattaDate', 'Date');
        $wtField = new TextField('WaterTemp', 'Water temperature');
        $ajField = new TextField('AttendanceJunior', 'Junior attendance');
        $aiField = new TextField('AttendanceIntermediate', 'Intermediate attendance');
        $asField = new TextField('AttendanceSenior', 'Senior attendance');
        $aaField = new TextField('AttendanceAdult', 'Adult attendance');
        
        $stField = new DropdownField('RegattaStatus', 'Status', $StatusSrc);
        	$stField->setEmptyString('Select a status');
        $fields->addFieldToTab('Root.Details', $sField);
        //$fields->addFieldToTab('Root.Details', $dField);
        $fields->addFieldToTab('Root.Details', $stField);
        $fields->addFieldToTab('Root.Details', $wtField);
        $fields->addFieldToTab('Root.Details', $ajField);
        $fields->addFieldToTab('Root.Details', $aiField);
        $fields->addFieldToTab('Root.Details', $asField);
        $fields->addFieldToTab('Root.Details', $aaField);
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
