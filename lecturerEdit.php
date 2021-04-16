<?php
session_start();

$genders = array("Female","Male"); 

$lecturerId =  (int)$_REQUEST["lecturerId"];

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/lecturerEdit.html");
$template->ReplaceVar("lecturerId", $lecturerId);

if ($lecturerId>0)
{
	$sql = "select * from lecturer where id=$lecturerId";
	require('/conn.php'); 
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$template->ReplaceVar("firstName", $row["firstName"]);
		$template->ReplaceVar("lastName", $row["lastName"]);
		$template->ReplaceVar("introduction", $row["introduction"]);

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
	$template->ReplaceVar("introduction", "");

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
