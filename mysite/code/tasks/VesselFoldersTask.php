<?php

class VesselFoldersTask extends BuildTask {
 
    protected $title = 'Set up Vessel gallery folders';
 
    protected $description = 'Ensures each Vessel in the system has a folder for its gallery images';
 
    protected $enabled = true;
 
    function run($request) {
    	if($results = DataList::create("SSVessel")) {
    		echo '<p>Checking each vessel:';
    		foreach($results as $result) {
    			echo '<br>Vessel ' . $result->ID;
    			$imageFolder = Folder::find_or_make('Uploads/Vessels/Vessel' . $result->ID);
    			if($imageFolder->ID == $result->ID) {
    				echo ' has a folder';
    			} else {
    				$result->VesselGalleryID = $imageFolder->ID;
    				$result->write();
    				echo ' did not have a folder';
    			}
    		}
    	}
    	echo '</p><p>Done</p>';
	}
}
