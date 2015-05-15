<?php
class SSChargeImport extends DataObject {

	private static $db = array(
		'IssueDate' => 'Date'
		, 'ChargeNumber' => 'Varchar(11)'
		, 'ChargeActive' => 'Boolean'
		, 'EndorsementA' => 'Boolean'
		, 'EndorsementB' => 'Boolean'
		, 'EndorsementE' => 'Boolean'
		, 'EndorsementK' => 'Boolean'
	);
	
	private static $has_one = array(
		'SSPerson' => 'SSPerson'
		, 'ScoutGroup' => 'SSGroup'
		, 'ChargeIssuer' => 'SSPerson'
	);
	
	private static $defaults = array(
		'ChargeActive' => 0
		, 'EndorsementA' => 0
		, 'EndorsementB' => 0
		, 'EndorsementE' => 0
		, 'EndorsementK' => 0
		, 'ChargeIssuer' => '34'
	);
}