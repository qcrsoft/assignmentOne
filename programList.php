<?php
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/programList.html");

$sql = "select * from program where enabled=1 order by id desc";
require('/conn.php'); 
$result = $conn->query($sql);

$template->OpenBlock("list");
while($row = $result->fetch_assoc())
{
	$template->ReplaceVar("name", $row["name"]);
	$template->ReplaceVar("id", $row["id"]);
	$template->ReplaceVar("createdAt", $row["createdAt"]);

	$template->Flush();
}
$template->CloseBlock();

$conn->close();

echo $template->GetText();
