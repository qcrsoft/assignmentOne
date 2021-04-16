<?php
session_start();

$tuitionId =  $_REQUEST["tuitionId"];
$amount =  $_REQUEST["amount"];
$studentId =  (int)$_REQUEST["studentId"];

if ($tuitionId==0)
{
	$sql = "INSERT INTO tuition (amount, studentId) VALUES ($amount, $studentId)";
}
else
{
	$sql = "UPDATE tuition SET amount=$amount, studentId=$studentId where id=$tuitionId";
}
require('/conn.php'); 

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
