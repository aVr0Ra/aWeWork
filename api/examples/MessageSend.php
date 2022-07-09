<?php
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");


$config = require('./config.php');
$agentId = $config['APP_ID'];
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);

//require_once('checkbox.php');

echo "Message Sending...... <br />";

try {
	$message = new Message();
	{
		$message->sendToAll = false;
		$check = $_POST['like'];
		$checkSize = count($check);
		echo "check Size = " . $checkSize . "<br />";
		
		//successfully get userid and put it into $message->touser array
		foreach($check as $nowValue) {
			//echo "nowValue = " . $nowValue . "<br />";
			array_push($message->touser, $nowValue);
			//var_dump($message->touser);
		}
		//var_dump($message->touser);

		$message->agentid = $agentId;
        	$message->safe = 0;

		echo "check point 1: success!<br />";
		$message->messageContent = new TextMessageContent();
		echo "check point 2: success!<br />";
		$content = $_POST['description'];
		//$content = "Hello";
		$message->messageContent->__construct($content);
		echo "check point 2.5: success! <br />";
		$invalidUserIdList = null;
    		$invalidPartyIdList = null;
    		$invalidTagIdList = null;
		echo "check point 3: success!<br />";
    		$api->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
		echo "Congratulations! Message Sent Successfully!" . "<br />";
	} 
}
catch (Exception $e) {
	echo $e->getMessage() . "\n";
}
?>
