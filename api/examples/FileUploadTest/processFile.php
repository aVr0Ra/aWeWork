<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



/**************************getting username->number******************************/
include_once("../../src/CorpAPI.class.php");
include_once("../../src/ServiceCorpAPI.class.php");
include_once("../../src/ServiceProviderAPI.class.php");

$config = require('../config.php');
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
require 'vendor/autoload.php';
require 'Messager.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inputFileName = $path_filename_ext;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

$prefixNumber = 'A';
$prefixMessage = 'B';

$lastMessage = null;

for ($i = 1 ; ; $i ++) {
	$nowNumberLoc = $prefixNumber . $i;
	$nowMessageLoc = $prefixMessage . $i;
	$number = $spreadsheet->getActiveSheet()->getCell($nowNumberLoc)->getValue();
	$message = $spreadsheet->getActiveSheet()->getCell($nowMessageLoc)->getValue();
	
	if ($number == null) {
		break;
	}
	
	if ($arrayNumber2Userid[$number] == null) {
		echo "<br /> <br />[Warning] At cell A" . $i . ", the program didn't find any student with that student ID number. The message of this student didn't send correctly. <br /> <br />"; 
		continue;
	}
	
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
