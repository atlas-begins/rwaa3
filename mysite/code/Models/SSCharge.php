<?php
class SSCharge extends DataObject {

	private static $db = array(
		'IssueDate' => 'Date'
		, 'ChargeNumber' => 'Varchar(11)'
		, 'ChargeActive' => 'Boolean'
	);
	
	private static $has_one = array(
		'ChargeHolder' => 'SSPerson'
		, 'ChargeIssuer' => 'SSPerson'
	);
	
	private static $has_many = array(
		'Endorsements' => 'SSChargeEndorsement'
		, 'ChargeNote' => 'SSNote'
	);
	
	private static $defaults = array(
		'ChargeActive' => 1
	);
	
	public function getChargeEndorsements() {
		$descs = singleton('SSChargeEndorsement')->endorsements();
		$results = new ArrayList();
		if($eItems = $this->Endorsements()->sort('EndorsementDate', 'ASC')) {
			foreach($eItems as $eItem) {
				$eItem->Description = $descs[$eItem->EndorsementCode];
				$results->push($eItem);
			}
		}
		return $results;
	}
	
	public function writeChargeNote($charge = null, $msg = null) {
    	if($charge && $msg) {
    		$result = new SSNote();
    		$result->NoteContents = $msg;
    		$result->AuthorID = Member::currentUser()->ID;
    		$result->ChargeID = $charge->ID;
    		$result->write();
    	}
    	return true;
    }
}