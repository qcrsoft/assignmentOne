<?
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/parentList.html");

$sql = "select parent.*, student.firstName as studentFirstname, student.lastName as studentLastname from parent, student WHERE parent.studentId=student.id order by parent.id desc";
$conn = new mysqli("localhost", "root", "123456", "wis");
$result = $conn->query($sql);

$template->OpenBlock("list");
while($row = $result->fetch_assoc())
{
	$template->ReplaceVar("firstName", $row["firstName"]);
	$template->ReplaceVar("lastName", $row["lastName"]);
	$template->ReplaceVar("relation", $row["relation"]);
	$template->ReplaceVar("phone", $row["phone"]);
	$template->ReplaceVar("studentFirstname", $row["studentFirstname"]);
	$template->ReplaceVar("studentLastname", $row["studentLastname"]);
	$template->ReplaceVar("createdAt", $row["createdAt"]);
	$template->ReplaceVar("id", $row["id"]);

	$template->Flush();
}
$template->CloseBlock();

$conn->close();

echo $template->GetText();
?>