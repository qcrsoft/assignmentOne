<?php
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/markList.html");

$sql = "select mark.*, student.firstName as studentFirstname, student.lastName as studentLastname, program.name as programName from mark, student, program WHERE mark.studentId=student.id AND mark.programId=program.id order by mark.id desc";
require('/conn.php'); 
$result = $conn->query($sql);

$template->OpenBlock("list");
while($row = $result->fetch_assoc())
{
	$template->ReplaceVar("score", $row["score"]);
	$template->ReplaceVar("studentFirstname", $row["studentFirstname"]);
	$template->ReplaceVar("studentLastname", $row["studentLastname"]);
	$template->ReplaceVar("programName", $row["programName"]);
	$template->ReplaceVar("programName", $row["score"]);
	$template->ReplaceVar("createdAt", $row["createdAt"]);
	$template->ReplaceVar("id", $row["id"]);

	$template->Flush();
}
$template->CloseBlock();

$conn->close();

echo $template->GetText();
