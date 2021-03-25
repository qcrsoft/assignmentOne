<?php
session_start();

$username =  $_REQUEST["username"];
$password =  $_REQUEST["password"];
$autologin =  $_REQUEST["autologin"];

$sql = "select * from manager where username='$username' and password='$password'";

$conn = new mysqli("localhost", "root", "123456", "wis");
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
	$row = $result->fetch_assoc();

	$_SESSION['currentManagerId'] = $row["id"];
	$_SESSION['currentUsername'] = $row["username"];

	if ($autologin=="1")
	{
		setcookie("currentManagerId", $row["id"], time()+3600*24*30, "/");
		setcookie("currentUsername", $row["username"], time()+3600*24*30, "/");
	}

	setcookie("currentProjectId", $projectId, time()+3600*24*30, "/");

	$response = array("result"=>true, "message"=>"");
}
else
{
	$response = array("result"=>false, "message"=>"username or password is invalid");
}
$conn->close();

echo json_encode($response);
?>