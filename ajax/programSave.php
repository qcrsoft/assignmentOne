<?php
session_start();

$name =  $_REQUEST["name"];
$introduction =  $_REQUEST["introduction"];
$programId =  (int)$_REQUEST["programId"];

$name =  str_replace("'", "''", $name);
$introduction =  str_replace("'", "''", $introduction);


if ($programId==0)
{
	$sql = "INSERT INTO program (name, introduction) VALUES ('$name', '$introduction')";
}
else
{
	$sql = "UPDATE program SET name='$name' $m1, introduction='$introduction' where id=$programId";
}
$conn = new mysqli("localhost", "root", "123456", "wis");

if ($conn->query($sql) === TRUE)
{
	$response = array("result"=>true, "message"=>"");
}
else
{
	$response = array("result"=>false, "message"=>$conn->error);
}
$conn->close();

echo json_encode($response);
?>