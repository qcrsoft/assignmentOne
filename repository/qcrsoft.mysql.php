<?
function query($sql)
{
	$conn = new mysqli("localhost", "wa3239_1", "Ww040506#", "wa3239_db1");
	$result = $conn->query($sql);
	$conn->close();

	return $result;
}
?>