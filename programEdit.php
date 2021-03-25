<?
session_start();

$programId =  (int)$_REQUEST["programId"];


require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/programEdit.html");

$template->ReplaceVar("programId", $programId);

if ($programId>0)
{
	$sql = "select * from program where enabled=1 and id=$programId";
	$conn = new mysqli("localhost", "root", "123456", "wis");
	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$template->ReplaceVar("name", $row["name"]);
		$template->ReplaceVar("introduction", $row["introduction"]);
	}
	else
	{
		//еврЛЁё
	}
	$conn->close();
}
else
{
	$template->ReplaceVar("name", "");
	$template->ReplaceVar("introduction", "");
	$template->ReplaceVar("programId", "0");
}

echo $template->GetText();
?>