<?
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/lecturerList.html");

$sql = "select * from lecturer order by id desc";
$conn = new mysqli("localhost", "root", "123456", "wis");
$result = $conn->query($sql);

$template->OpenBlock("list");
while($row = $result->fetch_assoc())
{
	$template->ReplaceVar("firstName", $row["firstName"]);
	$template->ReplaceVar("lastName", $row["lastName"]);
	$template->ReplaceVar("gender", $row["gender"]);
	$template->ReplaceVar("createdAt", $row["createdAt"]);
	$template->ReplaceVar("id", $row["id"]);

	$template->Flush();
}
$template->CloseBlock();

$conn->close();

echo $template->GetText();
?>