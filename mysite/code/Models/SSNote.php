<?php
class SSNote extends DataObject {

	private static $db = array(
		'NoteContents' => 'Text'
	);
	
	private static $has_one = array(
        'Vessel' => 'SSVessel'
        , 'Group' => 'SSGroup'
        , 'Author' => 'Member'
    );
}