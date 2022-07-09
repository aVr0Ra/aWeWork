<?php
class myMessage {
	private $userid;
	private $message;

	public function __construct($a, $b) {
		$this->userid = $a;
		$this->message = $b;
		return ;
	}
	
	public function sendMessage() {
		include_once("../../src/CorpAPI.class.php");
		include_once("../../src/ServiceCorpAPI.class.php");
		include_once("../../src/ServiceProviderAPI.class.php");
	
		$config = require('../config.php');
		$agentId = $config['APP_ID'];
		$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);
		
		$message = new Message();
		{
			$message->sendToAll = false;
			$message->touser = array($this->userid);
			$message->agentid = $agentId;
			$message->safe = 0;
			
			$message->messageContent = new TextMessageContent();
			$content = $this->message;
			$message->messageContent->__construct($content);
			$invalidUserIdList = null;
	    		$invalidPartyIdList = null;
	    		$invalidTagIdList = null;
	    		$api->MessageSend($message, $invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
			//echo "Congratulations! Message Sent Successfully!" . "<br />";
		}
		return ;
	}
}

?>
