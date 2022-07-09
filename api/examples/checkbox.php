<!DOCTYPE html>
<form action = "MessageSend.php" method = "post">
<html>
  <head>
    <title> Welcome to WeWork Message Sending System by aVr0Ra! </title>
  </head>
  <body>
    <table style = "border : 0px; padding : 3px">
    <tr>
      <td style = "background : #cccccc;" text-align : center;"> UserID </td>
      <td style = "background : #cccccc;" text-align : center;"> UserName </td>
      <td style = "background : #cccccc;" text-align : center;"> 发送消息 </td>
    </tr>
<?php
include_once("../src/CorpAPI.class.php");
include_once("../src/ServiceCorpAPI.class.php");
include_once("../src/ServiceProviderAPI.class.php");

$config = require('./config.php');
 
$agentId = $config['APP_ID'];
$api = new CorpAPI($config['CORP_ID'], $config['APP_SECRET']);

try {
	$department_id = 3;
	$fetchChild = 0;
	$list = $api->UserSimpleList($department_id, $fetchChild);

	$num = count($list);

	for ($i = 0 ; $i < $num ; $i ++) {
		$tmp = $list[$i]->userid;
echo 
"<tr>
<td style = \"text-align:right;\">".$list[$i]->userid."</td>
<td style = \"text-align:right;\">".$list[$i]->name."</td>
<td><input type= \"checkbox\" name=\"like[]\" value= $tmp> </td>
</tr>
\n";
	}

	fclose($fp);
}
catch (Exception $e) {
	echo $e->getMessage() . "\n";
}
?>

<tr>请在这里输入您想发送的信息: <textarea name="description"></textarea></tr><br /><br />
<tr>请选择您想发送消息给哪位（哪些）学生？（请至少选择一名学生）</tr>
<tr>
  <td colspan = "3" style = "text-align:center;"><input type = "submit" value = "提交上述信息" /></td>
</tr>
  </body>
</html>

