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
		, 'VesselNoteForm' => true
		, 'addCutter' => true
		, 'addSunburst' => TRUE
		, 'addKayak' => TRUE
		, 'addOther' => true
		, 'doSaveVessel' => TRUE
		, 'doSaveVesselImage' => true
		, 'doSaveVesselNote' => true
	);
	
	// FORMS
	public function VesselForm($vtype) {
		$actions = new FieldList(
            new FormAction('doSaveVessel', 'Save changes')
        );
        $validator = new RequiredFields();
		$allGroupsMap = DataList::create("SSGroup")->sort("GroupName")->map("ID", "GroupName");
		$groupField = new DropdownField('ScoutGroupID', 'Scout Group', $allGroupsMap);
			$groupField->setEmptyString('(Select a Group)');
		$fields = singleton('SSVessel')->getFrontendFields();
		$fields->replaceField('ScoutGroupID', $groupField);
		$fields->removeByName('VesselGallery');
		
		// creates the form object
		$form = new Form($this, 'VesselForm', $fields, $actions, $validator);
		
		// if numerical value, assume refers to existing vessel object
		// if string, assume refers to vessel class via add
		if(is_numeric($vtype) && $result = SSVessel::get_by_id("SSVessel", $vtype)) {
			$fields->push(new HiddenField("ID", "ID", $vtype));
			$form->loadDataFrom($result);
		} else {
			$fields->replaceField('VesselActive', new HiddenField("VesselActive", "Vessel Active", '1'));
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
					$fields->replaceField('VesselClass', new HiddenField("VesselClass", "VesselType", $vtype));
					// removes the capacities, populated on submit
					$fields->removeByName('VesselSailCapacityMin');
					$fields->removeByName('VesselSailCapacityMax');
					$fields->removeByName('VesselOarCapacityMin');
					$fields->removeByName('VesselOarCapacityMax');
					$fields->removeByName('VesselMotorCapacityMin');
					$fields->removeByName('VesselMotorCapacityMax');
				break;
			}
		}
		return $form;
    }
    
	public function VesselImageForm() {
    	$fields = new FieldList();
    	$fields->push(new FileField('VesselImage', ''));
    	$actions = new FieldList(
            new FormAction('doSaveVesselImage', 'Save image')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'VesselImageForm', $fields, $actions, $validator);
		
		return $form;
    }
    
	public function VesselNoteForm() {
    	$fields = new FieldList();
    	$fields->push(new TextField('VesselNote', ''));
    	$actions = new FieldList(
            new FormAction('doSaveVesselNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'VesselNoteForm', $fields, $actions, $validator);
		
		return $form;
    }
    
    // FORM ACTIONS
    public function doSaveVessel($data, $form) {
    	print_r('saving record ');
    	die();
    	if(isset($form['ID'])) {
    		$result = SSVessel::get_by_id("SSVessel", $form['ID']);
    		$form->saveInto($result);
    	} else {
    		$result = Object::create("SSVessel");
    		if(isset($data['VesselClass'])) {
    			if($vcaps = SSVessel::vesselMinMax($data['VesselClass'])) {
    				$data['VesselSailCapacityMin'] = $vcaps['MinSail'];
	    			$data['VesselSailCapacityMax'] = $vcaps['MaxSail'];
	    			$data['VesselOarCapacityMin'] = $vcaps['MinOar'];
	    			$data['VesselOarCapacityMax'] = $vcaps['MaxOar'];
	    			$data['VesselMotorCapacityMin'] = $vcaps['MinMotor'];
	    			$data['VesselMotorCapacityMax'] = $vcaps['MaxMotor'];
    			}
    		}
    		$data->saveInto($result);
    	}
    	//$result->write();
    	//$returnURL = SSVessel::getVesselDetailPageLink('view') . '/' . $result->ID;
    	return $this->redirect($returnURL);
    }
	
    // OTHER ACTIONS
	public function view($request) {
    	if($result = SSVessel::get_by_id("SSVessel", (int)$this->request->param('ID'))) {
    		$result->VesselImageForm = self::VesselImageForm();
    		$result->VesselNoteForm = self::VesselNoteForm();
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
			$imageFolder = Folder::find_or_make('Uploads/Vessels/Vessel' . $result->ID);
			$result->VesselGalleryID = $imageFolder->ID;
			$result->write();
			$namedetail = ' for ';
			if($result->VesselName) {
				$namedetail .= '"' . $result->VesselName .'"';
			} else {
				$namedetail .= $result->VesselClass . ' ' . $result->VesselNumber;
			}
    		$resultsArray['Title'] = 'Edit details' . $namedetail;
    		$resultsArray['Vessel'] = $result;
    		$resultsArray['Form'] = self::VesselForm($result->ID);
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
    
    public function justTesting() {
    	echo 'hello';
    	die();
    }
}
