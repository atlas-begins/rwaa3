<?php
class VesselPage extends VesselHolder {
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }
    
	public function vesselMinMax($vtype = null) {
		$vSpecs = array();
		switch ($vtype) {
			case 'Cutter':
				$vSpecs["MinSail"] = '3';
				$vSpecs["MaxSail"] = '7';
				$vSpecs["MinOar"] = '3';
				$vSpecs["MaxOar"] = '10';
				$vSpecs["MinMotor"] = '0';
				$vSpecs["MaxMotor"] = '0';
			break;
			case 'Sunburst':
				$vSpecs["MinSail"] = '2';
				$vSpecs["MaxSail"] = '3';
				$vSpecs["MinOar"] = '1';
				$vSpecs["MaxOar"] = '3';
				$vSpecs["MinMotor"] = '0';
				$vSpecs["MaxMotor"] = '0';
			break;
			case 'Kayak':
				$vSpecs["MinSail"] = '0';
				$vSpecs["MaxSail"] = '0';
				$vSpecs["MinOar"] = '1';
				$vSpecs["MaxOar"] = '1';
				$vSpecs["MinMotor"] = '0';
				$vSpecs["MaxMotor"] = '0';
			break;
			default:
				$vSpecs["MinSail"] = '0';
				$vSpecs["MaxSail"] = '0';
				$vSpecs["MinOar"] = '0';
				$vSpecs["MaxOar"] = '0';
				$vSpecs["MinMotor"] = '0';
				$vSpecs["MaxMotor"] = '0';
			break;	
		}
		return $vSpecs;
	}
	
    public function writeVesselNote($vessel = null, $msg = null) {
    	if($vessel && $msg) {
    		$result = new SSNote();
    		$result->NoteContents = $msg;
    		$result->AuthorID = Member::currentUser()->ID;
    		$result->GroupID = $vessel->ScoutGroupID;
    		$result->VesselID = $vessel->ID;
    		$result->write();
    	}
    	return true;
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
		$vessel = SSVessel::get()->byID($this->request->param('ID'));
    	$fields = new FieldList();
    	$fields->push(new TextareaField('NoteContents', ''));
    	$fields->push(new HiddenField('VesselID', 'Vessel ID', $vessel->ID));
    	$fields->push(new HiddenField('GroupID', 'Group ID', $vessel->ScoutGroupID));
    	$actions = new FieldList(
            new FormAction('doSaveVesselNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'VesselNoteForm', $fields, $actions, $validator);
		
		return $form;
    }
    
    // FORM ACTIONS
    public function doSaveVessel($form, $data) {
    	$vp = DataObject::get_one("VesselPage");
    	$returnURL = $vp->Link();
    	$vID = isset($form['ID']) ? (int) $form['ID'] : false;
    	if($vID) {
    		$result = SSVessel::get()->byID($form['ID']);
    		$result->VesselName = $form['VesselName'];
    		$result->VesselNumber = $form['VesselNumber'];
    		$result->VesselYear = $form['VesselYear'];
   			$result->VesselConstruction = $form['VesselConstruction'];
   			$result->VesselRig = $form['VesselRig'];
   			$result->ScoutGroupID = $form['ScoutGroupID'];
   			$result->VesselSailCapacityMin = $form["VesselSailCapacityMin"];
	    	$result->VesselSailCapacityMax = $form["VesselSailCapacityMax"];
	   		$result->VesselOarCapacityMax = $form["VesselOarCapacityMax"];
	   		$result->VesselOarCapacityMin = $form["VesselOarCapacityMin"];
	   		$result->VesselMotorCapacityMin = $form["VesselMotorCapacityMin"];
	   		$result->VesselMotorCapacityMax = $form["VesselMotorCapacityMax"];
    		$imageFolder = Folder::find_or_make('Uploads/Vessels/Vessel' . $result->ID);
			$result->VesselGalleryID = $imageFolder->ID;
			$result->write();
			self::writeVesselNote($result, 'Edited vessel record');
    	} else {
    		if($form['VesselClass']) {
    			$vcaps = self::vesselMinMax($form['VesselClass']);
    			$result = new SSVessel();
    			$result->VesselClass = $form['VesselClass'];
    			$result->VesselName = $form['VesselName'];
    			$result->VesselNumber = $form['VesselNumber'];
    			$result->VesselYear = $form['VesselYear'];
    			$result->VesselConstruction = $form['VesselConstruction'];
    			$result->ScoutGroupID = $form['ScoutGroupID'];
    			$result->VesselSailCapacityMin = $vcaps["MinSail"];
	    		$result->VesselSailCapacityMax = $vcaps["MaxSail"];
	    		$result->VesselOarCapacityMax = $vcaps["MinOar"];
	    		$result->VesselOarCapacityMin = $vcaps["MaxOar"];
	    		$result->VesselMotorCapacityMin = $vcaps["MinMotor"];
	    		$result->VesselMotorCapacityMax = $vcaps["MaxMotor"];
	    		$result->write();
	    		$imageFolder = Folder::find_or_make('Uploads/Vessels/Vessel' . $result->ID);
				$result->VesselGalleryID = $imageFolder->ID;
				$result->write();
				self::writeVesselNote($result, 'Created vessel record');
    		} else {
	    		return $this->redirect($returnURL);
    		}
    	}
		$returnURL .= 'view/' . $result->ID;
		return $this->redirect($returnURL);
    }
    
    public function doSaveVesselNote($form, $data) {
    	if($result = SSVessel::get_by_id("SSVessel", $form['VesselID'])) {
    		self::writeVesselNote($result, $form['NoteContents']);
    		$returnURL = $this->Link() . 'view/' . $form['VesselID'];
    	}
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
}
