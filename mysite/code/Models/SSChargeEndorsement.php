<?php
class SSChargeEndorsement extends DataObject {

	private static $db = array(
		'EndorsementCode' => "Enum('A,B,E,K','A')"
		, 'EndorsementDate' => 'Date'
		, 'EndorsementNote' => 'Text'
	);
	
	private static $has_one = array(
		'Examiner' => 'SSPerson'
		, 'Charge' => 'SSCharge'
	);
	
	public static function endorsements() {
		$results = array(
			'A' => 'Open boat under oars'
			, 'B' => 'Open boat with outboard motor'
			, 'E' => 'Open boat under sail'
			, 'K' => 'Kayak Leader Certificate'
		);
		return $results;
	}
}