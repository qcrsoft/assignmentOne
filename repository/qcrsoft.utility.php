<?
function randomString($type, $length)
{
	if ($type==0)
		$pattern = "0123456789";
	else if ($type==1)
		$pattern = "123456789ABCDEFGHJKLMNPQRSTUVWXYZ";
	else
		$pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

	$p = strlen($pattern);
	for($i=0; $i<$length; $i++)
	{
		$arr[] = $pattern{mt_rand(0,$p-1)};    //生成php随机数
	}
	return implode("",$arr);
}

/*
type: 0数字
      1数字加大写字母(不含数字）
	  2数字加大小写字母(不含数字0和1）
*/
function GenerateCode($amount, $type, $itemCount, $itemLength, $splitter)
{
	for($i=0; $i<$amount; $i++)
	{
		$ss = array();
		for($t=0; $t<$itemCount; $t++)
		{
			$ss[] = randomString($type, $itemLength);
		}
		$codes[] = implode($splitter, $ss);
	}

	return $codes;
}

function GetCurrentProjectId()
{
	$domain = $_SERVER['HTTP_HOST'];
	$sql = "SELECT * FROM project WHERE enabled=1";
	$conn = new mysqli("localhost", "wa3239_2", "Ww040506#", "wa3239_db2");
	$result = $conn->query($sql);
	$projectId = 0;
	while($row = $result->fetch_assoc())
	{
		if (stristr($domain, $row["name"]))
		{
			$projectId = $row["id"];
			break;
		}
	}

	return $projectId;
}

?>