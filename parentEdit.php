<?
session_start();

$relations = array("Mother","Father"); 

$parentId =  (int)$_REQUEST["parentId"];

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/parentEdit.html");
$template->ReplaceVar("parentId", $parentId);

if ($parentId>0)
{
	$sql = "select * from parent where id=$parentId";
	$conn = new mysqli("localhost", "root", "123456", "wis");
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$template->ReplaceVar("firstName", $row["firstName"]);
		$template->ReplaceVar("lastName", $row["lastName"]);
		$template->ReplaceVar("phone", $row["phone"]);

		$template->OpenBlock("list");
		foreach($relations as $g)
		{
			$template->ReplaceVar("value", $g);
			$template->ReplaceVar("text", $g);
			if ($g==$row["relation"])
				$template->ReplaceVar("selected", "selected");
			else
				$template->ReplaceVar("selected", "");

			$template->Flush();
		}
		$template->CloseBlock();

		$conn = new mysqli("localhost", "root", "123456", "wis");
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
	$template->ReplaceVar("firstName", "");
	$template->ReplaceVar("lastName", "");
	$template->ReplaceVar("phone", "");

	$template->OpenBlock("list");
	foreach($relations as $g)
	{
		$template->ReplaceVar("value", $g);
		$template->ReplaceVar("text", $g);
		$template->ReplaceVar("selected", "");

		$template->Flush();
	}
	$template->CloseBlock();

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