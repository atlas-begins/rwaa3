<?php
class SSRegattaType extends DataObject {

	private static $db = array(
		'RegattaDescription' => 'Varchar(128)'
		, 'Lat' => 'Decimal(9,9)'
		, 'Lng' => 'Decimal(9,9)'
	);
}