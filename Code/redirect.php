<?php
session_start();
$_SESSION['username'] = $_GET["userid"];
$_SESSION['pass'] = $_GET["pass"];
?>
<html>
<head>
<meta http-equiv="refresh" content="0;URL=admin_edituser.php">
</head>
</html>