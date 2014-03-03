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
    
    public function getVesselActionPageLink($action = null) {
    	return $this->Link() . $action;
    }
}
class VesselHolder_Controller extends Page_Controller {
	
}
