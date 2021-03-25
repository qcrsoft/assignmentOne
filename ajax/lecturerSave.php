<?php
session_start();

$firstName =  $_REQUEST["firstName"];
$lastName =  $_REQUEST["lastName"];
$introduction =  $_REQUEST["introduction"];
$gender =  $_REQUEST["gender"];
$lecturerId =  (int)$_REQUEST["lecturerId"];

$firstName =  str_replace("'", "''", $firstName);
$lastName =  str_replace("'", "''", $lastName);
$introduction =  str_replace("'", "''", $introduction);


if ($lecturerId==0)
{
	$sql = "INSERT INTO lecturer (firstName, lastName, gender, introduction) VALUES ('$firstName', '$lastName', '$gender', '$introduction')";
}
else
{
	$sql = "UPDATE lecturer SET firstName='$firstName', lastName='$lastName', gender='$gender', introduction='$introduction' where id=$lecturerId";
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