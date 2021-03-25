<?
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/tuitionList.html");

$sql = "select tuition.*, student.firstName as studentFirstname, student.lastName as studentLastname from tuition, student WHERE tuition.studentId=student.id order by tuition.id desc";
$conn = new mysqli("localhost", "root", "123456", "wis");
$result = $conn->query($sql);

$template->OpenBlock("list");
while($row = $result->fetch_assoc())
{
	$template->ReplaceVar("amount", $row["amount"]);
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