<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>IIT Indore Fund Management system</title>
  <!-- fav and touch icons -->
	<link rel="shortcut icon" href="assets/ico/favicon.ico">
<style>
body {
  background-color: #1a242f;
  	line-height: 10px;
	padding : 300px;
	background-color: #1a242f;
	text-align: center;
	font-size:30px;
	  color:white;
	  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;

}
</style>
<meta http-equiv="refresh" content="0;URL=admin.php">
</head>
<body>
<?php
?>
<h1>Welcome</h1>

<p><?php echo strtoupper($_SESSION["admin"]);?></p>
</body>
</html>

