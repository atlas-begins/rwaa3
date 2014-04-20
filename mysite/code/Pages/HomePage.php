<?php
class HomePage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCurrentSeason() {
		$refDate = date("Y-m-d 00:00:00");
		if($result = DataObject::get_one("SSSeason", "(\"SeasonStart\" < '$refDate') AND (\"SeasonEnd\" > '$refDate')")) {
			return $result;
		}
		return null;
	}
	
	public function HomePageStats() {
		$result = new DataObject();
		$result->GroupCount = DataList::create("SSGroup")->Count();
		$result->VesselCount = DataList::create("SSVessel")->where('"VesselActive" = 1')->Count();
		$result->PersonCount = DataList::create("SSPerson")->where('"PersonActive" = 1')->Count();
		$result->ZoneCount = DataList::create("SSZone")->Count();
		$result->CertCount = DataList::create("SSVesselCert")->filter(array('SailingSeasonID' => $this->getCurrentSeason()->ID))->Count();
		return $result; 
	}
	
	public function NextEvent() {
		$where = "StartDate >= CURRENT_DATE OR StartDate IS NULL";
		$sort = 'StartDate, Time';
		$sortOrder = 'ASC';
		if($result = GroupedList::create(CalendarEntry::get()->Sort($sort, $sortOrder)->where($where)->limit('1'))) {
			return $result;
		}
		return false;
	}
}
class HomePage_Controller extends Page_Controller {
	
}
