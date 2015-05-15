<?php
class SSNote extends DataObject {

	private static $db = array(
		'NoteContents' => 'Text'
	);
	
	private static $has_one = array(
		'Vessel' => 'SSVessel'
		, 'Group' => 'SSGroup'
		, 'Person' => 'SSPerson'
		, 'Author' => 'Member'
		, 'Certificate' => 'SSVesselCert'
		, 'Trophy' => 'SSTrophy'
		, 'Charge' => 'SSCharge'
    );
}