<?php
class SSCharge extends DataObject {

	private static $db = array(
		'IssueDate' => 'Date'
		, 'ChargeNumber' => 'Varchar(20)'
	);
	
	private static $belongs_one = array(
		'ChargeHolder' => 'SSPerson'
	);
}