<?php
$_GET		&& SafeFilter($_GET);
$_REQUEST	&& SafeFilter($_REQUEST);
$_POST		&& SafeFilter($_POST);
$_COOKIE	&& SafeFilter($_COOKIE);

require('/conn.php'); 
$username =  mysqli_real_escape_string($conn, $_REQUEST["username"]);
$password =  mysqli_real_escape_string($conn, $_REQUEST["password"]);

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

$result = $conn->query($sql);

if ($result->num_rows > 0)
{
	$response = array("result"=>false, "message"=>"username has been existed");
}
else
{
	$sql = "INSERT INTO manager (username, password) VALUES ('$username', '$password')";
	if ($conn->query($sql) === TRUE)
	{
		$response = array("result"=>true, "message"=>"");
	}
	else
	{
		$response = array("result"=>false, "message"=>$conn->error);
	}
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
          if (!get_magic_quotes_gpc())  //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
          {
             $value  = addslashes($value); //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）
             #加上反斜线转义
          }
          $value       = preg_replace($ra,'',$value);     //删除非打印字符，粗暴式过滤xss可疑字符串
          $arr[$key]     = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
        }
        else
        {
          SafeFilter($arr[$key]);
        }
     }
   }
}
