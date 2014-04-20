<?php

class CalendarEntry extends DataObject{

 	public static $db = array(
 		"Title" => "Text",
 		"StartDate" => "Date",
 		"Time" => "Text",
 		"Description" => "Text"
 	);
 	
 	static $has_one = array(
 		"CalendarPage" => "CalendarPage",
 		"Image" => "Image",
 		"HostGroup" => "SSGroup"
 	);
	
	public static $summary_fields = array(
    	"StartDate" => "Date",
    	"Title" => "Title"
    );
	
	static $default_sort = "StartDate ASC, Time ASC";
	
 	public function validate() {
        $result = parent::validate();
        if(!$this->Title) {
            $result->error('Title is required');
        }
        if(!$this->StartDate) {
            $result->error('A start date is required');
        } 
        return $result;
    }
 	
 	function getCMSFields() {
		
		$this->beforeUpdateCMSFields(function($fields) {
			$datefield = new DateField('StartDate','Start date (DD/MM/YYYY)*');
			$datefield->setConfig('showcalendar', true);
			$datefield->setConfig('dateformat', 'dd/MM/YYYY');
			
			$imagefield = new UploadField('Image','Image');
			$imagefield->allowedExtensions = array('jpg', 'gif', 'png');
			$imagefield->setFolderName("Managed/CalendarImages");
			$imagefield->setCanPreviewFolder(false);
			
			$groupfield = new DropdownField("HostGroupID", "Which Group is hosting this event?");
			
			$fields->addFieldToTab('Root.Main', new TextField('Title',"Event Title*"));
			$fields->addFieldToTab('Root.Main', $groupfield);
			$fields->addFieldToTab('Root.Main', $datefield);
			$fields->addFieldToTab('Root.Main', new TextField('Time',"Time (HH:MM)"));
			$fields->addFieldToTab('Root.Main', new TextareaField('Description'));
			$fields->addFieldToTab('Root.Main', $imagefield);
		});

		$fields = parent::getCMSFields();
		
		$this->extend('updateCMSFields', $fields);	

		$fields->removeFieldFromTab("Root.Main","CalendarPageID");

		return $fields;		
	}
	
	function getMonthDigit(){
	 	$date = strtotime($this->StartDate);
		return date('m',$date);
	}
	
	function getYear(){
		$date = strtotime($this->StartDate);
		return date('Y',$date);
	}
	
	function makeFullDate() {
		$basetime = strtotime($this->StartDate . ' ' . $this->Time);
		$result = new SS_Datetime();
		$result->setValue($basetime);
		return $result;
	}
		
	function canCreate($members = null) {
		return true;
	}
	
	function canEdit($members = null) {
		return true;
	}
	
	function canDelete($members = null) {
		return true;
	}
	
	function canView($members = null) {
		return true;
	}
 	
}
?>