<?php
class VesselPage extends VesselHolder {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
class VesselPage_Controller extends VesselHolder_Controller {

	private static $allowed_actions = array (
		'view' => true
		, 'edit' => true
		, 'add' => true
		, 'VesselForm' => true
		, 'VesselImageForm' => true
		, 'addCutter' => true
		, 'addSunburst' => TRUE
		, 'addKayak' => TRUE
		, 'addOther' => true
	);
	
	// FORMS
	public function VesselForm($vtype) {
		$fields = singleton('SSVessel')->getFrontendFields();
		$allGroupsMap = DataList::create("SSGroup")->sort("GroupName")->map("ID", "GroupName");
		// if numerical value, assume refers to existing vessel object
		// if string, assume refers to vessel class via add
		if(is_numeric($vtype)) {
			if($result = SSVessel::get_by_id("SSVessel", $vtype)) {
	    		$form->loadDataFrom($result);
	    	} else {
	    		return FALSE;
	    	}
		} else {
			$fields->replaceField('VesselActive', new HiddenField("VesselActive", "Vessel Active", '1'));
			$fields->removeByName('ScoutGroupID');
			$groupField = new DropdownField('ScoutGroupID', 'Scout Group', $allGroupsMap);
				$groupField->setEmptyString('(Select a Group)');
				$fields->push($groupField);
			switch ($vtype) {
				case 'Vessel':
					// set default values for capacities fields to 0
					$fields->replaceField('VesselSailCapacityMin', new TextField("VesselSailCapacityMin", "Minimum sail capacity", '0'));
					$fields->replaceField('VesselSailCapacityMax', new TextField("VesselSailCapacityMax", "Maximum sail capacity", '0'));
					$fields->replaceField('VesselOarCapacityMin', new TextField("VesselOarCapacityMin", "Minimum rowing capacity", '0'));
					$fields->replaceField('VesselOarCapacityMax', new TextField("VesselOarCapacityMax", "Maximum rowing capacity", '0'));
					$fields->replaceField('VesselMotorCapacityMin', new TextField("VesselMotorCapacityMin", "Minimum motoring capacity", '0'));
					$fields->replaceField('VesselMotorCapacityMax', new TextField("VesselMotorCapacityMax", "Maximum motoring capacity", '0'));
				break;
				default:
					// creates array of default values for vessel classes
					$vSpecs = SSVessel::vesselMinMax($vtype);
					$fields->replaceField('VesselSailCapacityMin', new HiddenField("VesselSailCapacityMin", "ID", $vSpecs['MinSail']));
					$fields->replaceField('VesselSailCapacityMax', new HiddenField("VesselSailCapacityMax", "ID", $vSpecs['MaxSail']));
					$fields->replaceField('VesselOarCapacityMin', new HiddenField("VesselOarCapacityMin", "ID", $vSpecs['MinOar']));
					$fields->replaceField('VesselOarCapacityMax', new HiddenField("VesselOarCapacityMax", "ID", $vSpecs['MaxOar']));
					$fields->replaceField('VesselMotorCapacityMin', new HiddenField("VesselMotorCapacityMin", "ID", $vSpecs['MinMotor']));
					$fields->replaceField('VesselMotorCapacityMax', new HiddenField("VesselMotorCapacityMax", "ID", $vSpecs['MaxMotor']));
					$fields->replaceField('VesselClass', new HiddenField("VesselClass", "Vessel Class", strtolower($vtype)));
					$fields->push(new LiteralField("VesselClassX", "Vessel class: <strong>" . $vtype . '</strong><br>'));
					$fields->push(new LiteralField("VesselSailCapacityMinX", "Sail capacity (min/max): <strong>" . $vSpecs['MinSail'] . ' / ' . $vSpecs['MaxSail'] . '</strong><br>'));
					$fields->push(new LiteralField("VesselOarCapacityMinX", "Rowing capacity (min/max): <strong>" . $vSpecs['MinOar'] . ' / ' . $vSpecs['MaxOar'] . '</strong><br>'));
					$fields->push(new LiteralField("VesselMotorCapacityMaxX", "Motoring capacity (min/max): <strong>" . $vSpecs['MinMotor'] . ' / ' . $vSpecs['MaxMotor'] . '</strong><br>'));
				break;
			}
		}
		$actions = new FieldList(
            new FormAction('doSaveVessel', 'Save changes')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'VesselForm', $fields, $actions, $validator);
		
		return $form;
    }
	
	public function view($request) {
    	if($result = SSVessel::get_by_id("SSVessel", (int)$this->request->param('ID'))) {
    		$namedetail = '';
    		if($result->VesselName) $namedetail = ' for "' . $result->VesselName . '"';
    		$resultsArray = array(
    			'Title' => 'Details' . $namedetail
    			, 'Vessel' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Vessel not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that vessel.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('VesselPage', 'Page'));
    }
    
	public function edit($request) {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'edit';
		if($result = SSVessel::get()->byID($this->request->param('ID'))) {
			$namedetail = ' for ';
			if($result->VesselName) {
				$namedetail .= '"' . $result->VesselName .'"';
			} else {
				$namedetail .= $result->VesselClass . ' ' . $result->VesselNumber;
			}
    		$resultsArray['Title'] = 'Edit details' . $namedetail;
    		$resultsArray['Vessel'] = $result;
    		//$resultsArray['Form'] = self::VesselForm($result->ID);
    	} else {
    		$resultsArray['Title'] = 'Vessel not found';
    		$resultsArray['Content'] = '<p>Sorry, we cannot locate records for that vessel.</p><p>Please return to the main page and make another selection.</p>';
    	}
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function addCutter($request) {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'add';
		$resultsArray['Title'] = 'Add a cutter';
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
    
	public function add($request) {
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'add';
		$resultsArray['Title'] = 'Add a ' . $this->request->param('ID');
		$resultsArray['Form'] = self::VesselForm($this->request->param('ID'));
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
    }
}
