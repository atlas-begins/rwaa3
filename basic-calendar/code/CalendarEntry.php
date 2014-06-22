<?php

class CalendarEntry extends DataObject{

 	public static $db = array(
 		"Title" => "Text"
 		, "StartDate" => "Date"
 		, "Time" => "Text"
 		, "Description" => "Text"
 		, 'AltLocation' => 'Varchar(128)'
 		, 'EventType' => "Enum(array('Regatta','Water Activities Meeting','Swimming Sports','Prizegiving','Raft Race','ANZAC Day','Other'))"
 	);
 	
 	static $has_one = array(
 		"CalendarPage" => "CalendarPage"
 		, "Image" => "Image"
 		, "HostGroup" => "SSGroup"
 		, "Season" => "SSSeason"
 		, 'Location' => 'SSLocation'
 	);
	
	public static $summary_fields = array(
    	"StartDate" => "Date"
    	, "Title" => "Title"
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
			if(!$this->ID) {
				$rightNow = date("Y-m-d");
				$allSeasonsMap = DataList::create("SSSeason")->sort("SeasonStart", "ASC")->where("\"SeasonEnd\" > '$rightNow'")->map("ID", "Season");
			} else {
				$allSeasonsMap = DataList::create("SSSeason")->sort("SeasonStart", "ASC")->map("ID", "Season");
			}
			$seasonField = new DropdownField("SeasonID", "Sailing season", $allSeasonsMap);
				$seasonField->setEmptyString('(Select a season)');
			$typeMap = singleton('CalendarEntry')->dbObject('EventType')->enumValues();
			$eventTypeField = new DropdownField("EventType", "What type of event is this?", $typeMap);
				$eventTypeField->setEmptyString('(Select an Event type)');
				
			$datefield = new DateField('StartDate','Start date (DD/MM/YYYY)*');
			$datefield->setConfig('showcalendar', true);
			$datefield->setConfig('dateformat', 'dd/MM/YYYY');
			
			$imagefield = new UploadField('Image','Image');
			$imagefield->allowedExtensions = array('jpg', 'gif', 'png');
			$imagefield->setFolderName("Managed/CalendarImages");
			$imagefield->setCanPreviewFolder(false);
			
			$allGroupsMap = DataList::create("SSGroup")->sort("GroupName")->map("ID", "GroupName");
			$groupField = new DropdownField("HostGroupID", "Which Group is hosting this event?", $allGroupsMap);
				$groupField->setEmptyString('(Select a Group)');
				
			$allLocationsMap = DataList::create("SSLocation")->sort("LocationDescription")->map("ID", "LocationDescription");
			$locationField = new DropdownField("LocationID", "What location?", $allLocationsMap);
				$locationField->setEmptyString('(Select a Location)');
			
			$fields->addFieldToTab('Root.Main', $seasonField);
			$fields->addFieldToTab('Root.Main', $eventTypeField);
			$fields->addFieldToTab('Root.Main', new TextField('Title',"Event Title*"));
			$fields->addFieldToTab('Root.Main', $groupField);
			$fields->addFieldToTab('Root.Main', $datefield);
			$fields->addFieldToTab('Root.Main', new TextField('Time',"Time (HH:MM)"));
			$fields->addFieldToTab('Root.Main', $locationField);
			$fields->addFieldToTab('Root.Main', new TextField('AltLocation', 'Location if not selected above'));
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