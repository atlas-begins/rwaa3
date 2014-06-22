<?php
class GroupHolder extends Page {
	
	private static $icon = array("mysite/images/treeicons/Group.png");

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
    
    public static function getGroupInformation() {
    	$results = DataList::create('SSGroup')->sort("GroupName");
       	return $results;
    }
    
	public static function getGroupMarkers() {
    	if($results = DataList::create('SSGroup')->sort("GroupName")->where('"Lng" > 0')) {
    		return $results;
    	}
    }

    public static function getGroupMarkerArray() {
    	if($results = DataList::create('SSGroup')->sort("GroupName")->where('"Lng" > 0')) {
    		$mArr = array();
    		// subarray structure
    		/*
    		 * 0 GroupName
    		 * 1 GroupBranch
    		 * 2 GroupLocality
    		 * 3 marker icon
    		 * 4 Lat
    		 * 5 Long
    		 * 
    		 */
    		foreach($results as $result) {
    			$mRec = array();
    			$mRec[] = $result->GroupName;
    			$mRec[] = $result->GroupBranch;
    			$mRec[] = $result->GroupLocality;
    			switch($result->GroupBranch) {
    				case 'Air':
    					$mRec[] = "../themes/simple/images/map_icons/Air_Marker.png";
    				break;
    				case 'Land':
    					$mRec[] = "../themes/simple/images/map_icons/Land_Marker.png";
    				break;
    				case 'Sea':
    					$mRec[] = "../themes/simple/images/map_icons/Sea_Marker.png";
    				break;
    				default:
    					$mRec[] = "../themes/simple/images/map_icons/Scout_Marker.png";
    				break;
    			}
    			$mRec[] = $result->Lat;
    			$mRec[] = $result->Lng;
    			$mArr[] = $mRec;
    		}
    		$json = Convert::array2json($mArr);
    		return $json;
    	}
    }
    
	public static function getGroupActionPageLink($action = 'add') {
    	if($result = DataObject::get_one("GroupPage")) {
			return $result->Link() . $action;
		}
		return false;
    }
}
class GroupHolder_Controller extends Page_Controller {
	
}
