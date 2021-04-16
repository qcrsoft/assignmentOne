<?php
session_start();

require('/conn.php'); 
$firstName = mysqli_real_escape_string($conn, $_REQUEST["firstName"]);
$lastName =  mysqli_real_escape_string($conn, $_REQUEST["lastName"]);
$major =  mysqli_real_escape_string($conn, $_REQUEST["major"]);
$gender =  mysqli_real_escape_string($conn, $_REQUEST["gender"]);
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
