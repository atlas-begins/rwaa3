<?php

class ImportChargeDataTask extends BuildTask {
 
    protected $title = 'Import bulk SSCharge and SSChargeEndorsement data';
 
    protected $description = 'Processes data to create charge records and associated endorsements';
 
    protected $enabled = true;
 
    function run($request) {
    	$stime = time();
    	$c = 0;
    	$e = 0;
    	if($results = DataList::create("SSChargeImport")) {
    		DB::query("truncate table sscharge"); // temp only!!
    		DB::query("update ssperson set personchargeid = 0");  // temp only!
    		foreach($results as $result) {
    			// first check to see if person exists
    			echo '<br>checking person id ' . $result->SSPersonID;
    			if($person = DataList::create("SSPerson")->byID($result->SSPersonID)) {
    				echo ' yes they exist';// then check to see if the person already has a charge
    				if(!$charge = DataList::create("SSCharge")->filter('ChargeHolderID', $person->ID)->First()) {
    					echo ', no charge yet';
    					// if not then create a new charge record
    					$charge = self::createCharge($result, $person);
    					self::updateChargeEndorsements($charge, $result);
    					$c++;
    				} else {
    					echo ', yes already have a charge';
    					$e++;
    				}
    			}
    			
    		}
    	}
    	echo '<br>created ' . $c . ' new charges';
    	echo '<br>updated ' . $e . ' existing charges';
    	self::reportTime($stime);
	}
	
	public function createCharge($result, $person) {
		$charge = SSCharge::create();
    		$charge->IssueDate = $result->IssueDate;
    		$charge->ChargeNumber = $result->ChargeNumber;
    		$charge->ChargeHolderID = $result->SSPersonID;
    		$charge->ChargeIssuerID = $result->ChargeIssuerID;
    		$charge->write();
    	$person->PersonChargeID = $charge->ID;
    		$person->write();
    	return $charge;
	}
	
	public function updateChargeEndorsements($charge, $result) {
		// check for endorsements against the charge
		/*
		 * 				db record
		 * 					0	|	1
		 * 				=================
		 * 	import	0		0	|	d
		 * 	record		-----------------
		 * 			1		a	|	0
		 * 
		 * a = add
		 * d = deactivate
		 * 
		 */
		if($result->EndorsementA) {
			$endo_a = SSChargeEndorsement::create();
			$endo_a->ChargeID = $charge->ID;
			$endo_a->ExaminerID = $charge->ChargeIssuerID;
			$endo_a->EndorsementCode = 'A';
			$endo_a->EndorsementDate = $charge->IssueDate;
			$endo_a->write();
		}
		if($result->EndorsementB) {
			$endo_b = SSChargeEndorsement::create();
			$endo_b->ChargeID = $charge->ID;
			$endo_b->ExaminerID = $charge->ChargeIssuerID;
			$endo_b->EndorsementCode = 'B';
			$endo_b->EndorsementDate = $charge->IssueDate;
			$endo_b->write();
		}
		if($result->EndorsementE) {
			$endo_e = SSChargeEndorsement::create();
			$endo_e->ChargeID = $charge->ID;
			$endo_e->ExaminerID = $charge->ChargeIssuerID;
			$endo_e->EndorsementCode = 'E';
			$endo_e->EndorsementDate = $charge->IssueDate;
			$endo_e->write();
		}
		if($result->EndorsementK) {
			$endo_k = SSChargeEndorsement::create();
			$endo_k->ChargeID = $charge->ID;
			$endo_k->ExaminerID = $charge->ChargeIssuerID;
			$endo_k->EndorsementCode = 'E';
			$endo_k->EndorsementDate = $charge->IssueDate;
			$endo_k->write();
		}
		
	}
	
	public function reportTime($stime) {
		$ctime = time();
		$etime = $ctime - $stime;
		echo '<br>Completed in ' . $etime . ' seconds';
	}
}
