<?php
session_start();

unset($_SESSION['currentManagerId']);
unset($_SESSION['currentUsername']);
setcookie("currentManagerId", "", time() - 3600, "/");
setcookie("currentUsername", "", time() - 3600, "/");

$response = array("result"=>true, "message"=>"");
echo json_encode($response);
?>