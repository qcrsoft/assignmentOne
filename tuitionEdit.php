<?
session_start();

$tuitionId =  (int)$_REQUEST["tuitionId"];

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/tuitionEdit.html");
$template->ReplaceVar("tuitionId", $tuitionId);

if ($tuitionId>0)
{
	$sql = "select * from tuition where id=$tuitionId";
	$conn = new mysqli("localhost", "root", "123456", "wis");
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$template->ReplaceVar("amount", $row["amount"]);

		$sql = "select * from student where enabled=1 OR id=" . $row["studentId"] . " ORDER BY firstName, lastName";

		$resultStudent = $conn->query($sql);

		$template->OpenBlock("students");
		while($rowStudent = $resultStudent->fetch_assoc())
		{
			$template->ReplaceVar("value", $rowStudent["id"]);
			$template->ReplaceVar("text", $rowStudent["firstName"] . " " . $rowStudent["lastName"]);
			if ($row["studentId"]==$rowStudent["id"])
				$template->ReplaceVar("selected", "selected");
			else
				$template->ReplaceVar("selected", "");

			$template->Flush();
		}
		$template->CloseBlock();
	}
	else
	{
		//Òì³£
	}
	$conn->close();
}
else  //ÐÂÔö
{
	$template->ReplaceVar("amount", "");

	$conn = new mysqli("localhost", "root", "123456", "wis");

	$sql = "select * from student where enabled=1 ORDER BY firstName, lastName";
	$resultStudent = $conn->query($sql);

	$template->OpenBlock("students");
	while($rowStudent = $resultStudent->fetch_assoc())
	{
		$template->ReplaceVar("value", $rowStudent["id"]);
		$template->ReplaceVar("text", $rowStudent["firstName"] . " " . $rowStudent["lastName"]);
		$template->ReplaceVar("selected", "");

		$template->Flush();
	}
	$template->CloseBlock();
}

echo $template->GetText();
?>