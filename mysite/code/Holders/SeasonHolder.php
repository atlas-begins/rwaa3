<?php
class SeasonHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Season.png";

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
    
	public function getAllSeasons() {
		if($results = DataList::create("SSSeason")->sort('"SeasonStart" DESC')) {
			return $results;
		}
    	return false;
    }
    
    public function getCurrentSeason($uDate = null) {
    	$seasons = self::getAllSeasons();
    	$refDate = strtotime(date("Y-m-d"));
    	if($uDate) $refDate = strtotime($uDate);
    	foreach($seasons as $season) {
			$dateW1 = strtotime($season->SeasonStart);
			$dateW2 = strtotime($season->SeasonEnd);
			if(($refDate > $dateW1) && ($refDate < $dateW2)) {
				return $season;
				break;
			}
    	}
    }
    
    public function getSeasonEvents() {
    	$events = CalendarPage::getSeasonEvents(self::getCurrentSeason());
    	return $events;
    }
    
	public function getSeasonActionPageLink($action = 'add') {
    	if($result = DataObject::get_one("SeasonHolder")) {
			return $result->Link() . $action;
		}
		return false;
    }
}
class SeasonHolder_Controller extends Page_Controller {
	
	private static $allowed_actions = array (
		'view' => true
		, 'add' => true
		, 'edit' => true
		, 'SeasonForm' => true
		, 'doSaveSeason' => true
	);
	
	// FORMS
	public function SeasonForm() {
		$fields = singleton('SSSeason')->getFrontendFields();
		if($this->urlParams['ID']) {
			$idField = new HiddenField("ID", "ID", $this->urlParams['ID']);
			$fields->push($idField);
		}
		$zoneField = new DropdownField('GroupZoneID', 'Zone', $allZonesMap);
			$zoneField->setEmptyString('(Select a Zone)');
			$fields->push($zoneField);
		$actions = new FieldList(
            new FormAction('doSaveGroup', 'Save changes')
        );
        $validator = new RequiredFields('GroupName', 'GroupZoneID');
		$form = new Form($this, 'GroupForm', $fields, $actions, $validator);
		if($this->urlParams['ID'] && $result = SSGroup::get()->byID($this->urlParams['ID'])) {
			$form->loadDataFrom($result);
		}
		return $form;
    }
	
	public function add($request) {
    	$result = new SSSeason();
    	$latestSeason = SSSeason::get()->sort('SeasonEnd', 'DESC')->first();
    	$result->SeasonStart = date('Y-m-d', strtotime("+1 year", strtotime($latestSeason->SeasonStart)));
    	$result->SeasonEnd = date('Y-m-d 23:59:59', strtotime("+1 year", strtotime($latestSeason->SeasonEnd)));
    	$result->Season = date('Y', strtotime($result->SeasonStart)) .  '/' . date('y', strtotime($result->SeasonEnd));
    	$result->write();
    	return $this->redirectBack();
    }
}
