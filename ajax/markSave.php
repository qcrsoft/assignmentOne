<?php
session_start();

$markId =  $_REQUEST["markId"];
$score =  $_REQUEST["score"];
$studentId =  (int)$_REQUEST["studentId"];
$programId =  (int)$_REQUEST["programId"];

if ($markId==0)
{
	$sql = "INSERT INTO mark (score, programId, studentId) VALUES ($score, $programId, $studentId)";
}
else
{
	$sql = "UPDATE mark SET score=$score, programId=$programId, studentId=$studentId where id=$markId";
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