<?
session_start();

if ($_SESSION['currentManagerId']!=null || $_COOKIE["currentManagerId"]!=null)
{
	if ($_SESSION["managerId"]==null)
	{
		$_SESSION['currentManagerId'] = $_COOKIE["currentManagerId"];
		$_SESSION['currentUsername'] = $_COOKIE["currentUsername"];
	}

	header('location:main.php');
	exit;
}

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/signup.html");
echo $template->GetText();
?>