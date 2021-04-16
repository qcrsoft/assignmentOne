<?php
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/studentList.html");

$sql = "select * from student where enabled=1 order by id desc";
require('/conn.php'); 
$result = $conn->query($sql);

$template->OpenBlock("list");
while($row = $result->fetch_assoc())
{
	$template->ReplaceVar("firstName", $row["firstName"]);
	$template->ReplaceVar("lastName", $row["lastName"]);
	$template->ReplaceVar("major", $row["major"]);
	$template->ReplaceVar("gender", $row["gender"]);
	$template->ReplaceVar("createdAt", $row["createdAt"]);
	$template->ReplaceVar("id", $row["id"]);

	$template->Flush();
}
$template->CloseBlock();

$conn->close();

echo $template->GetText();
