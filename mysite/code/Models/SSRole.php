<?php
class SSRole extends DataObject {

	private static $db = array(
		'Role' => 'Varchar(128)'
		, 'RoleAbbrev' => 'Varchar(4)'
	);
	
	private static $belongs_many = array(
		'Person' => 'SSPerson'
	);
}