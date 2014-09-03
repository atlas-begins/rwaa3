<?php

class CalendarPage extends Page {
	
	static $description = "Provides an interface to add calendar events";
	
	public static $db = array(
		"EventTabFirst" => "Boolean",
		"ManageAllEvents" => "Boolean",
		"DisplayEvents" => "Int"
	);
	
	public static $defaults = array(
		"DisplayEvents" => '5'
	);
	
	public static $has_many = array(
		"Events" => "CalendarEntry"
	);
	
	static $icon = array('mysite/images/treeicons/calendar_view', 'file');
	
	function getCMSFields() {
		$fields = parent::getCMSFields();

		if ($this->EventTabFirst) {
			$fields->insertBefore(new Tab('Events'), 'Main');
		}
		
		$config = GridFieldConfig_RecordEditor::create();
		$gridField = new GridField("Events", "Upcoming Events", $this->Events()->where("StartDate >= CURRENT_DATE OR StartDate IS NULL"), $config);
		$fields->addFieldToTab("Root.Events", $gridField);
		
		$config = GridFieldConfig_RecordEditor::create();
		$config->removeComponentsByType('GridFieldAddNewButton');
		$gridField = new GridField("PastEvents", "Past Events", $this->Events()->where("StartDate < CURRENT_DATE"), $config);
		$fields->addFieldToTab("Root.PastEvents", $gridField);
		
		$fields->addFieldToTab("Root.Main", new CheckboxField("EventTabFirst","CMS: Set Events Tab as Default"), "Content");
		$fields->addFieldToTab("Root.Main", new CheckboxField("ManageAllEvents","Template: Display Events from other pages too"), "EventTabFirst");
		$fields->addFieldToTab("Root.Main", new TextField("DisplayEvents", "How many events shown?"), "ManageAllEvents");	
		return $fields;
	}
	
	public static function getSeasonEvents($season) {
		$sDate = $season->SeasonStart;
		$eDate = $season->SeasonEnd;
		$where = "StartDate >= '$sDate' AND StartDate <= '$eDate'";
		$results = GroupedList::create(CalendarEntry::get()->Sort('StartDate, Time')->where($where));
		return $results->sort("StartDate", "DESC");
	}

}

class CalendarPage_Controller extends Page_Controller {

	public static $allowed_actions = array();
	
	public function init() {
		if (Director::fileExists(project() . "/css/calendar.css")) {
			Requirements::css(project() . "/css/calendar.css");
		} else {
			Requirements::css("basic-calendar/css/calendar.css");
		}
		parent::init();
    }

	function getEvents($dates = "all", $limit = '4') {
		$where = null;
		$filter = array();
		if($this->DisplayEvents) $limit = $this->DisplayEvents;
		
		if ($dates == "future") {
			$where = "StartDate >= CURRENT_DATE OR StartDate IS NULL";
			$sort = 'StartDate, Time';
			$sortOrder = 'ASC';
		} else if ($dates == "past") {
			$where = "StartDate < CURRENT_DATE";
			$sort = 'StartDate, Time';
			$sortOrder = 'DESC';
		}
		
		if (!$this->ManageAllEvents) {
			$filter =  array("CalendarPageID"=>$this->ID);
		}
		return GroupedList::create(CalendarEntry::get()->filter( $filter )->Sort($sort, $sortOrder)->where($where)->limit($limit));
	}
	
	function ShowPast() {
		return isset($_GET['past']) ? true : false;
	}
	
	// THIS PAGE'S ENTRIES
	function getFutureCalendarEntries() {
		$entries = GroupedList::create(CalendarEntry::get()->filter( array("CalendarPageID"=>$this-ID) )->Sort('StartDate, Time')->where("StartDate >= CURRENT_DATE OR StartDate IS NULL") );
		return $entries;
	}
	
	function getGroupedPastCalendarEntries() {
		$entries = GroupedList::create(CalendarEntry::get()->filter( array("CalendarPageID"=>$this-ID) )->Sort('StartDate, Time')->where("StartDate < CURRENT_DATE") );
		return $entries;
	}
	
	function getGroupedCalendarEntries() {
		$entries = GroupedList::create(CalendarEntry::get()->filter( array("CalendarPageID"=>$this-ID) )->Sort('StartDate, Time') );
		return $entries;
	}
	
	// ALL ENTRIES - FROM ALL PAGES
	function getAllGroupedFutureCalendarEntries() {
		$entries = GroupedList::create(CalendarEntry::get()->Sort('StartDate, Time')->where("StartDate >= CURRENT_DATE OR StartDate IS NULL") );
		return $entries;
	}
	
	function getAllGroupedPastCalendarEntries() {
		$entries = GroupedList::create(CalendarEntry::get()->Sort('StartDate, Time')->where("StartDate < CURRENT_DATE") );
		return $entries;
	}
	
	function getAllGroupedCalendarEntries() {
		$entries = GroupedList::create(CalendarEntry::get()->Sort('StartDate, Time') );
		return $entries;
	}
}

?>