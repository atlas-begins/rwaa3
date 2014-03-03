<?php
class SSCharge extends DataObject {

	private static $db = array(
		'ChargeDescription' => 'Varchar(128)'
		, 'ChargeType' => 'Varchar(4)'
	);
	
	private static $has_one = array(
		'ChargeSeason' => 'SSSeason'
	);
	
	private static $belongs_many = array(
		'Person' => 'SSPerson'
	);
}