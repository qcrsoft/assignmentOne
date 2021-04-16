<?php
session_start();

require('repository/qcrsoft.HtmlTemplate.php'); 

$template = new HtmlTemplate("template/welcome.html");

echo $template->GetText();
