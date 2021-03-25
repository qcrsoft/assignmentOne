<?php
session_start();

$firstName =  $_REQUEST["firstName"];
$lastName =  $_REQUEST["lastName"];
$phone =  $_REQUEST["phone"];
$relation =  $_REQUEST["relation"];
$parentId =  (int)$_REQUEST["parentId"];
$studentId =  (int)$_REQUEST["studentId"];

$firstName =  str_replace("'", "''", $firstName);
$lastName =  str_replace("'", "''", $lastName);
$phone =  str_replace("'", "''", $phone);


if ($parentId==0)
{
	$sql = "INSERT INTO parent (firstName, lastName, relation, phone, studentId) VALUES ('$firstName', '$lastName', '$relation', '$phone', $studentId)";
}
else
{
	$sql = "UPDATE parent SET firstName='$firstName', lastName='$lastName', relation='$relation', phone='$phone', studentId=$studentId where id=$parentId";
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