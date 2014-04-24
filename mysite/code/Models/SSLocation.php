<?php
class SSLocation extends DataObject {

	static $db = array(
		'LocationDescription' => 'Varchar(64)'
	);
	
	static $belongs_many_many = array(
		'Event' => 'CalendarEntry'
	);
}