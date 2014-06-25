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
			return $result->Link() . substr($action, 0, 3) . '/' . substr($action, 3, 12);
		}
		return false;
    }
}
class VesselHolder_Controller extends Page_Controller {
	private static $allowed_actions = array (
		'VesselSearchForm' => TRUE
		, 'doVesselSearch' => TRUE
	);
	
	public function VesselSearchForm() {
		$actions = new FieldList(new FormAction('doVesselSearch', 'search'));
		$fields = new FieldList(new TextField('vesselClue', 'Search by name, number or class:'));
		$validator = new RequiredFields();
		$form = new Form($this, 'VesselSearchForm', $fields, $actions, $validator);
		return $form;
	}
	
	public function doVesselSearch($data, $form) {
		// decide if we are searching by number or name
		if(is_numeric($data['vesselClue'])) {
			
		} else {
			
		}
		
		$resultsArray = array();
		$resultsArray['ObjectAction'] = 'searchVessels';

    	$resultsArray['Title'] = 'Vessels not found';
    	$resultsArray['Content'] = '<p>Sorry, we cannot locate records for any vessels by that name, number or class.</p><p>Please return to the <a href="' . $this->Link() . '" title="">main page</a> and try another search term.</p>';
    	return $this->customise($resultsArray)->renderWith(array('ObjectPage_actions', 'Page'));
		
		
		
	}
}
