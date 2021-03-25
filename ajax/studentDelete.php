<?php
session_start();

$ids =  $_REQUEST["ids"];

if ($ids!="")
{
	$conn = new mysqli("localhost", "root", "123456", "wis");

	$sql = "UPDATE student SET enabled=0 WHERE id IN ($ids)";
	if ($conn->query($sql) === TRUE)
	{
		$response = array("result"=>true, "message"=>"");
	}
	else
	{
		$response = array("result"=>false, "message"=>$conn->error);
	}
	
	$conn->close();
}
else
{
	$response = array("result"=>false, "message"=>"Invalid parameter");
}

echo json_encode($response);
?>