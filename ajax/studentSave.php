<?php
session_start();

$firstName =  $_REQUEST["firstName"];
$lastName =  $_REQUEST["lastName"];
$major =  $_REQUEST["major"];
$gender =  $_REQUEST["gender"];
$studentId =  (int)$_REQUEST["studentId"];

$firstName =  str_replace("'", "''", $firstName);
$lastName =  str_replace("'", "''", $lastName);
$major =  str_replace("'", "''", $major);


if ($studentId==0)
{
	$sql = "INSERT INTO student (firstName, lastName, gender, major) VALUES ('$firstName', '$lastName', '$gender', '$major')";
}
else
{
	$sql = "UPDATE student SET firstName='$firstName', lastName='$lastName', gender='$gender', major='$major' where id=$studentId";
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