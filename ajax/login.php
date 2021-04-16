<?php
session_start();

$_GET		&& SafeFilter($_GET);
$_REQUEST	&& SafeFilter($_REQUEST);
$_POST		&& SafeFilter($_POST);
$_COOKIE	&& SafeFilter($_COOKIE);

$username =  mysqli_real_escape_string($conn, $_REQUEST["username"]);
$password =  mysqli_real_escape_string($conn, $_REQUEST["password"]);
$autologin =  $_REQUEST["autologin"];

if (strlen($username)==0 || strlen($username)>50)
{
	$response = array("result"=>true, "message"=>"the username is too long");
	echo json_encode($response);
	exit;
}

if (strlen($password)==0 || strlen($password)>50)
{
	$response = array("result"=>true, "message"=>"the password is too long");
	echo json_encode($response);
	exit;
}

$password = md5($password);
$sql = "select * from manager where username='$username' and password='$password'";

$conn = new mysqli("localhost", "root", "123456", "wis");
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
	$row = $result->fetch_assoc();

	$_SESSION['currentManagerId'] = $row["id"];
	$_SESSION['currentUsername'] = $row["username"];

	if ($autologin=="1")
	{
		setcookie("currentManagerId", $row["id"], time()+3600*24*30, "/");
		setcookie("currentUsername", $row["username"], time()+3600*24*30, "/");
	}

	setcookie("currentProjectId", $projectId, time()+3600*24*30, "/");

	$response = array("result"=>true, "message"=>"");
}
else
{
	$response = array("result"=>false, "message"=>"username or password is invalid");
}
$conn->close();

echo json_encode($response);

function SafeFilter (&$arr) 
{
   $ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/'
   ,'/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/'
   ,'/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/',
   '/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/'
   ,'/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
     
   if (is_array($arr))
   {
     foreach ($arr as $key => $value) 
     {
        if (!is_array($value))
        {
          if (!get_magic_quotes_gpc())
          {
             $value  = addslashes($value);
          }
          $value       = preg_replace($ra,'',$value);
          $arr[$key]     = htmlentities(strip_tags($value));
        }
        else
        {
          SafeFilter($arr[$key]);
        }
     }
   }
}
