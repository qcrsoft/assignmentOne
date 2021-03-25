<?
session_start();

$markId =  (int)$_REQUEST["markId"];

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/markEdit.html");
$template->ReplaceVar("markId", $markId);

if ($markId>0)
{
	$sql = "select * from mark where id=$markId";
	$conn = new mysqli("localhost", "root", "123456", "wis");
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$template->ReplaceVar("score", $row["score"]);

		//$conn = new mysqli("localhost", "root", "123456", "wis");
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

		$sql = "select * from program where enabled=1 OR id=" . $row["programId"] . " ORDER BY name";

		$resultProgram = $conn->query($sql);

		$template->OpenBlock("programs");
		while($rowProgram = $resultProgram->fetch_assoc())
		{
			$template->ReplaceVar("value", $rowProgram["id"]);
			$template->ReplaceVar("text", $rowProgram["name"]);
			if ($row["programId"]==$rowProgram["id"])
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
	$template->ReplaceVar("score", "");

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

	$sql = "select * from program where enabled=1 ORDER BY name";
	$resultProgram = $conn->query($sql);

	$template->OpenBlock("programs");
	while($rowProgram = $resultProgram->fetch_assoc())
	{
		$template->ReplaceVar("value", $rowProgram["id"]);
		$template->ReplaceVar("text", $rowProgram["name"]);
		$template->ReplaceVar("selected", "");

		$template->Flush();
	}
	$template->CloseBlock();
}

echo $template->GetText();
?>