<?php
session_start();

require('/conn.php'); 
$firstName = mysqli_real_escape_string($conn, $_REQUEST["firstName"]);
$lastName =  mysqli_real_escape_string($conn, $_REQUEST["lastName"]);
$introduction =  mysqli_real_escape_string($conn, $_REQUEST["introduction"]);
$gender =  mysqli_real_escape_string($conn, $_REQUEST["gender"]);
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
