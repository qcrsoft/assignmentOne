<?php
$username =  $_REQUEST["username"];
$password =  $_REQUEST["password"];

$sql = "select * from manager where username='$username' and password='$password'";

$conn = new mysqli("localhost", "root", "123456", "wis");
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
	$response = array("result"=>false, "message"=>"username has been existed");
}
else
{
	$sql = "INSERT INTO manager (username, password) VALUES ('$username', '$password')";
	if ($conn->query($sql) === TRUE)
	{
		$response = array("result"=>true, "message"=>"");
	}
	else
	{
		$response = array("result"=>false, "message"=>$conn->error);
	}
}
$conn->close();

echo json_encode($response);
?>