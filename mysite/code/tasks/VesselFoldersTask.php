<?php

class VesselFoldersTask extends BuildTask {
 
    protected $title = 'Set up Vessel gallery folders';
 
    protected $description = 'Ensures each Vessel in the system has a folder for its gallery images';
 
    protected $enabled = true;
 
    function run($request) {
    	if($results = DataList::create("SSVessel")) {
    		$hasf = '0';
    		$hasn = '0';
    		$hasv = '0';
			echo '<p>Checking ' . $results->Count() . ' vessels:';
    		foreach($results as $result) {
    			$imageFolder = Folder::find_or_make('Uploads/Vessels/Vessel' . $result->ID);
    			if($imageFolder->ID == $result->VesselGalleryID) {
    				$hasf++;
    			} else {
    				$result->VesselGalleryID = $imageFolder->ID;
    				$result->write();
    				$hasn++;
    			}
    		}
    		
    		$pFolderID = Folder::find_or_make('Uploads/Vessels')->ID;
    		
    		if($vFolders = DataList::create("Folder")->filter('ParentID', '$pFolderID')) {
    			foreach($vFolders as $vFolder) {
    				$fID = $vFolder->ID;
	    			if(!$vessel = DataList::create("SSVessel")->filter('VesselGalleryID', '$fID')) {
	    				$hasv++;
	    				$vFolder->delete();
	    			}
    			}	
    		}
    		
    		echo '<br>' . $hasf . ' had folders';
    		echo '<br>' . $hasn . ' did not have folders';
    		echo '<br>' . $hasv . ' folders did not have a corresponding vessel';
    	}
    	echo '</p><p>Done</p>';
	}
}
