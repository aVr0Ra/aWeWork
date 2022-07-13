<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/



/**************************getting username->number******************************/
require 'vendor/autoload.php';
require 'Messager.php';
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$config = require('config.php');
$agentId = $config['APP_ID'];
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);

$list = $api->UserList(3, 0);
$sz = count($list);

$arrayNumber2Userid = array ();

for ($i = 0 ; $i < $sz ; $i ++) {
	$attrsSZ = count($list[$i]->extattr->attrs);
	for ($j = 0 ; $j <= $attrsSZ ; $j ++) {
		if ($list[$i]->extattr->attrs[$j]->name == "学号") {
			$arrayNumber2Userid[$list[$i]->extattr->attrs[$j]->value] = $list[$i]->userid;
			break;
		}
	}
}

//var_dump($list[4]); echo "<br /> <br /> <br /> ";
//var_dump($list[4]->extattr->attrs);
//var_dump($arrayNumber2Userid);

//var_dump($list[4]);

echo "<br />";

/***************************saving file to the server****************************/
echo "Excel chart processing... Please Wait..." . "<br />";

//echo "ver = 0.5" . "<br />";

$target_dir = "upload/";
$file = $_FILES['my_file']['name'];
$path = pathinfo($file);
$filename = "MessageSentAt" . date('Y,m,d;H:i:s'); //filename
//var_dump($filename);
$ext = $path['extension']; //.xlsx
//var_dump($ext);
$temp_name = $_FILES['my_file']['tmp_name'];
$path_filename_ext = $target_dir.$filename.".".$ext;
//var_dump($path_filename_ext);

move_uploaded_file($temp_name,$path_filename_ext);

echo "Congratulations! Chart " . $path_filename_ext . " succcessfully saved in server!.....Waiting for the next step..." . "<br /> <br />";


/**************************processing excel chart******************************/

$inputFileName = $path_filename_ext;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

$prefixNumber = 'A';
$prefixMessage = 'B';

$FLAG = true;
$TOTAL = 0;

$messageB1 = $spreadsheet->getActiveSheet()->getCell('B1')->getValue();
if ($messageB1 == null) {
	echo "Seems like in Cell B1, the first student don't have a message to send. Please Double check it. Program Aborted. <br />";
	exit;
}

for ($i = 1 ; ; $i ++) {
	$nowNumberLoc = $prefixNumber . $i;
	$number = $spreadsheet->getActiveSheet()->getCell($nowNumberLoc)->getValue();
	
	if ($number == null) {
		$TOTAL = $i - 1;
		break;
	}
	
	if ($arrayNumber2Userid[$number] == null) {
		echo "[Warning] At cell A" . $i . ", the program didn't find anyone with that student ID. Please double check it and resubmit later.<br />"; 
		$FLAG = false;
		continue;
	}
}

if ($FLAG == false) {
	echo "<br /> <br /> Something wrong with that chart. No message was sent. Program Aborted.<br />";
	exit;
}
else {
	echo "Double checking completed. Nothing wrong with the chart. Message sending.... <br />";
}

$lastMessage = null;

for ($i = 1 ; $i <= $TOTAL; $i ++) {
	$nowNumberLoc = $prefixNumber . $i;
	$nowMessageLoc = $prefixMessage . $i;
	$number = $spreadsheet->getActiveSheet()->getCell($nowNumberLoc)->getValue();
	$message = $spreadsheet->getActiveSheet()->getCell($nowMessageLoc)->getValue();
	
	
	if ($message == null) {
		$message = $lastMessage;
	}
	else {
		$lastMessage = $message;
	}
	
	$now = new myMessage($arrayNumber2Userid[$number], $message);
	//var_dump($now);
	$now->sendMessage();
	echo "Userid = " . $arrayNumber2Userid[$number] . "; message = " . $message . "; sent successfully!<br />";
}


?>
