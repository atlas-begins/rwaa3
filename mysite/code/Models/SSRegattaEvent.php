<?php
class SSRegattaEvent extends DataObject {

	private static $db = array(
		'EventDescription' => 'Varchar(128)'
		, 'EventVesselClass' => "Enum(array('cutter','kayak','dinghy','sunburst','crown','whaler','RIB','optimist'))"
	);
	
	private static $belongs_one = array(
		'RegattaPage' => 'RegattaPage'
	);
}