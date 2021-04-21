<?php
session_start();

if ($_SESSION['currentManagerId']==null)
{
	if ($_COOKIE["currentManagerId"]==null || $_COOKIE["currentUsername"]==null)
	{
		header('location:index.php');
		exit;
	}
	else
	{
		$_SESSION['currentManagerId'] = $_COOKIE["currentManagerId"];
		$_SESSION['currentUsername'] = $_COOKIE["currentUsername"];
	}
}

require('repository/qcrsoft.HtmlTemplate.php'); 
$template = new HtmlTemplate("template/main.html");

echo $template->GetText();
