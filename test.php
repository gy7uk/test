<?php
ini_set('display_errors', 1);
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>REST/OAuth Example</title>
    </head>
    <body>
	<?php
            require_once ('/var/www/soapclient/SforcePartnerClient.php');
            require_once ('/var/www/soapclient/SforceHeaderOptions.php');

		// I added some changes
		// I added some changes2

		$username = "elena_grow@mail.ru";
		$password = "GY7uk197784";
		$securityToken = "tQX7v96KJmYdPT1lbPLV7b9u";
		
		try {	
			$mySforceConnection = new SforcePartnerClient();
			$mySforceConnection->createConnection('/var/www/soapclient/partner.wsdl.xml');
			if (isset($_SESSION['partnerSessionId'])) {
				$location = $_SESSION['partnerLocation'];
				$sessionId = $_SESSION['partnerSessionId'];

				$mySforceConnection->setEndpoint($location);
				$mySforceConnection->setSessionHeader($sessionId);
			} else {
				$mySforceConnection->login($username, $password . $securityToken);
				
				$_SESSION['partnerLocation'] = $mySforceConnection->getLocation();
				$_SESSION['partnerSessionId'] = $mySforceConnection->getSessionId();
			}
			
			// Select records
			
			$query = "Select Id, Description__c, Price__c, Total_Inventory__c, Name from Merchandise__c";
			$response = $mySforceConnection->query($query);
			
			foreach ($response->records as $record) {
				$sObject = new SObject($record);
				echo $sObject->fields->Description__c."<br/> ".$sObject->fields->Price__c."<br/>"
				.$sObject->fields->Total_Inventory__c."<br/>"
				.$sObject->Id."<br/>"
				.$sObject->fields->Name."<br/>\n";
				
			}

			
			/*echo "<pre>";
			print_r($response);
			echo "</pre>";*/
			
			
			// Insert record
			
			/*$records2 = array();
			
			$records2[0] = new SObject();
			$records2[0]->fields = array(
				'Description__c' => 'New merchandise 2 added',
				'Price__c' => '77.02',
				'Total_Inventory__c' => '4702',
				'Name' => 'MerchName2'		
			);
			$records2[0]->type = 'Merchandise__c';
			$records2[0]->fieldsToNull = null;
			
			$response2 = $mySforceConnection->create($records2);

			$ids = array();
			foreach ($response2 as $i => $result) {
				if ($result->success == 1) {
					echo "One record was added successfully";
					array_push($ids, $result->id);
				} else {
					echo "Error: ". $result->errors->message."<br/>";
				}		
			}*/

			// Update record
			
			/*
			$ids = array();
			$ids[] = 'a01E000000DaRXjIAN';
			$ids[] = 'a01E000000DaRadIAF';		
			
			$records = array();
			$records[0] = new SObject();
			$records[0]->Id = $ids[0];
			$records[0]->fields = array('Name' => 'New beautiful name');
			$records[0]->type = 'Merchandise__c';
			$records[0]->fieldsToNull = null;
			
			$records[1] = new SObject();
			$records[1]->Id = $ids[1];
			$records[1]->fields = array('Name' => 'The second beautiful name');
			$records[1]->type = 'Merchandise__c';
			$records[1]->fieldsToNull = null;

			$responseUpdate = $mySforceConnection->update($records);
			echo "<pre>";
			print_r($responseUpdate);
			echo "</pre>";
			foreach ($responseUpdate as $result) {
				if ($result->success == 1) {
					echo $result->id . " updated<br/>\n";
				}
			}
			*/
			

		} catch (Exception $e) {
				
			echo "Exception ".$e->faultstring."<br/><br/>";
			/*echo "Last Request: <br/><br/>";
			echo $mySforceConnection->getLastRequestHeaders();
			echo "<br/><br/>";
			echo $mySforceConnection->getLastRequest();
			echo "<br/><br/>";
			echo $mySforceConnection->getLastResponseHeaders();
			echo "<br/><br/>";
			echo $mySforceConnection->getLastResponse();*/
		}
			?>
	</body>
</html>
