<?php
class VesselHolder extends Page {
	
	private static $icon = "mysite/images/treeicons/Vessel.png";

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
    
	public function getVesselInformation($vtype = 'null') {
		switch ($vtype) {
			case 'cutter'; case 'sunburst'; case 'kayak';
				$results = DataList::create("SSVessel")->where('"VesselClass" = \'' . $vtype . '\'')->sort('VesselName');
			break;
			default:
				$results = DataList::create("SSVessel")->where('"VesselClass" NOT IN(\'cutter\', \'sunburst\', \'kayak\')')->sort("VesselClass ASC, VesselName ASC");
			break;
		}
		return $results;
    }
    
	public function getVesselCount($vtype = 'null') {
		switch ($vtype) {
			case 'cutter'; case 'sunburst'; case 'kayak';
				$result = DataList::create("SSVessel")->where('"VesselClass" = \'' . $vtype . '\'')->Count();
			break;
			default:
				$result = DataList::create("SSVessel")->where('"VesselClass" NOT IN(\'cutter\', \'sunburst\', \'kayak\')')->Count();
			break;
		}
    	return $result;
    }
    
    public function getVesselActionPageLink($action = 'addCutter') {
    	if($result = DataObject::get_one("VesselPage")) {
			return $this->Link() . substr($action, 0, 3) . '/' . substr($action, 3, 12);
		}
		return false;
    }
}
class VesselHolder_Controller extends Page_Controller {
	private static $allowed_actions = array (
		'view' => true
		, 'edit' => true
		, 'add' => true
		, 'VesselForm' => true
	);
	
	public function add($request) {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = $this->request->param('Action');
		$resultsArray['Title'] = 'Add a ' . $this->request->param('ID');
		$resultsArray['Form'] = self::VesselForm($this->request->param('ID'));
		
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function VesselForm($vtype) {
		$fields = singleton('SSVessel')->getFrontendFields();
		$allGroupsMap = SSGroup::get()->sort("GroupName")->map("ID", "GroupName");
		if($vtype == 'Vessel') {} else {
			$vSpecs = SSVessel::vesselMinMax($vtype);
			$fields->replaceField('VesselSailCapacityMin', new HiddenField("VesselSailCapacityMin", "ID", $vSpecs['MinSail']));
			$fields->replaceField('VesselSailCapacityMax', new HiddenField("VesselSailCapacityMax", "ID", $vSpecs['MaxSail']));
			$fields->replaceField('VesselOarCapacityMin', new HiddenField("VesselOarCapacityMin", "ID", $vSpecs['MinOar']));
			$fields->replaceField('VesselOarCapacityMax', new HiddenField("VesselOarCapacityMax", "ID", $vSpecs['MaxOar']));
			$fields->replaceField('VesselMotorCapacityMin', new HiddenField("VesselMotorCapacityMin", "ID", $vSpecs['MinMotor']));
			$fields->replaceField('VesselMotorCapacityMax', new HiddenField("VesselMotorCapacityMax", "ID", $vSpecs['MaxMotor']));
			$fields->replaceField('VesselClass', new HiddenField("VesselClass", "Vessel Class", strtolower($vtype)));
		}
		$fields->replaceField('VesselActive', new HiddenField("VesselActive", "Vessel Active", '1'));
		$fields->removeByName('ScoutGroupID');
		$groupField = new DropdownField('ScoutGroupID', 'Scout Group', $allGroupsMap);
			$groupField->setEmptyString('(Select a Group)');
			$fields->push($groupField);
		$actions = new FieldList(
            new FormAction('doSaveVessel', 'Save changes')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'VesselForm', $fields, $actions, $validator);
		if($this->urlParams['ID'] && $result = SSVessel::get()->byID($this->urlParams['ID'])) {
			$form->loadDataFrom($result);
		}
		return $form;
    }
}
