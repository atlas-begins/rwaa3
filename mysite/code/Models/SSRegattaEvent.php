<?php
class SSRegattaEvent extends DataObject {

	private static $db = array(
		'EventDescription' => "Enum(array('Junior','Intermediate','Senior','Open','Club','Other'))"
		, 'EventVesselClass' => "Enum(array('cutter','kayak','dinghy','sunburst','crown','whaler','RIB','optimist','Open','Club'))"
		, 'EventActivityClass' => "Enum(array('sailing','sunburst','rowing','kayaking'))"
		, 'EventOrder' => 'Int'
		, 'StartTime' => 'SS_DateTime'
		, 'EndTime' => 'SS_DateTime'
		, 'Status' => "Enum(array('Upcoming','Run','Cancelled'))"
	);
}