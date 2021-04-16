<?php
session_start();

require('/conn.php'); 

$firstName = mysqli_real_escape_string($conn, $_REQUEST["firstName"]);
$lastName =  mysqli_real_escape_string($conn, $_REQUEST["lastName"]);
$phone =  mysqli_real_escape_string($conn, $_REQUEST["phone"]);
$relation =  mysqli_real_escape_string($conn, $_REQUEST["relation"]);
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
