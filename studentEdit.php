<?
session_start();

$genders = array("Female","Male"); 

$studentId =  (int)$_REQUEST["studentId"];

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/studentEdit.html");
$template->ReplaceVar("studentId", $studentId);

if ($studentId>0)
{
	$sql = "select * from student where enabled=1 and id=$studentId";
	$conn = new mysqli("localhost", "root", "123456", "wis");
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$template->ReplaceVar("firstName", $row["firstName"]);
		$template->ReplaceVar("lastName", $row["lastName"]);
		$template->ReplaceVar("major", $row["major"]);

		$template->OpenBlock("list");
		foreach($genders as $g)
		{
			$template->ReplaceVar("value", $g);
			$template->ReplaceVar("text", $g);
			if ($g==$row["gender"])
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
	$template->ReplaceVar("major", "");

	$template->OpenBlock("list");
	foreach($genders as $g)
	{
		$template->ReplaceVar("value", $g);
		$template->ReplaceVar("text", $g);
		$template->ReplaceVar("selected", "");

		$template->Flush();
	}
	$template->CloseBlock();

}

echo $template->GetText();
?>