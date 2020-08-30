<?php
session_start();
require 'config.php'; // use config file for connection
$sql= $con->prepare("SELECT * FROM user");
$sql->execute();
$query = $con->prepare("SELECT type,amount,purpose,name,u.user_id,password,t.trans_id, date FROM transactions t inner join balance b on b.trans_id = t.trans_id inner join user u on u.user_id=b.user_id order by t.trans_id desc;"); 
$query->execute();
$_SESSION["request"]=$_GET["request"];
$choice =substr_count($_SESSION["request"],"transaction");
?>
<html>
<head>
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
<script src="https://kit.fontawesome.com/c4b975f7fd.js" crossorigin="anonymous"></script>   
<link rel="stylesheet" href="admin.css">
<style>
.grid-container {
  display: grid;
  background-color: #1a242f;
  height:90px;
  
}
.id {
  display: grid;
  background-color: #fff;
  height:90px;
  float:right;
  margin-right:20px;
  margin-top :10px;
  width:250px;
  border-style:outset;
  border-size:3px;
  border-radius:17px;
}
.pic{
	grid-coloumn:1;
	width:60px;
}
.pic h1{
	margin-top:10px;
	padding-left:10px;
}

.det{
	grid-column:2;
}

.det h1{
	margin-top:12px;
	margin-bottom:0px;
	margin-left:0px;
	font-size:20px;
	font-family: 'Viaoda Libre', cursive;

}

.det p{
	margin-top:0px;
	font-family: 'Viaoda Libre', cursive;
	font-size:22px;
}

.grid-item {
  background-color: #1a242f;
}

.item1{
	  grid-column: 1;
	  
}

.item1 p{
	padding-top : 20px;
	padding-bottom : 0px;
	padding-left : 4px;
}
.item2{
	grid-column:2;
	text-align:center;
}
.item2 h1{
	font-size:30px;
	 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	 padding-top :25px;
	 color:#f3f5f9;
}
.item3{
	grid-column:3;
}
.item3 h1{
	font-size:26px;
	 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	 padding-top :25px;
	 padding-left :175px;
	 color:#f3f5f9;
}
.item3 p{
	font-size:20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	padding-left:175px;
	color:#f3f5f9;
}

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
  text-decoration: none;
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}


.wrapper{
  display: flex;
  position: relative;
}

.wrapper .sidebar{
  width: 200px;
  height: 100%;
  background: #1a242f;
  padding: 30px 0px;
  position: fixed;
}

.wrapper .sidebar h2{
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 20px;
}

.wrapper .sidebar ul li{
  padding: 15px;
  border-bottom: 1px solid #bfc6d5;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  border-top: 1px solid rgba(255,255,255,0.05);
}    
.view{
	color:#bfc6d5;
	display:block;
	cursor:pointer;
}
.view .fas{
	width:25px;
}
.view:hover{
	color:#fff;
}
	
.wrapper .sidebar ul li a{
  color: #bfc6d5;
  display: block;
}

.wrapper .sidebar ul li a .fas{
  width: 25px;
}

.wrapper .sidebar ul li:hover{
  background-color: #bebec0;
}
    
.wrapper .sidebar ul li:hover a{
  color: #fff;
}

#acs {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 60%;
  margin-top:170px;
  margin-left:350px;
}
	
#acs td, #acs th {
  border: 2px solid #ddd;
  padding: 10px;
}

#acs tr:nth-child(even){background-color: #f2f2f2;}

#acs tr:hover {background-color: #ddd;}

#acs th {
  padding-top: 14px;
  padding-bottom: 14px;
  text-align: left;
  background-color: #94a3c1;
  color: white;
}
#acs caption {
	font-weight: bold;
	font-size:47px;
	font-family: Arial;
	color:#444444;
}
#acs td a{
	padding: 5px 24px;
	background-color:#94a3c1;
	border-radius:4px;
	margin-left:40px;
	transition-duration:0.3s;
	color:white
}
#acs td a:hover {
	background-color:white;
	color:black;
	box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}
@media screen and (max-width : 1024px){
	#acs{
		width : 60%;
		margin-top: 100px;
		margin-left: 230px;
		
	}
	#acs th {
	padding-top: 14px;
	padding-bottom: 14px;
	text-align: left;
	background-color: #94a3c1;
	color: white;
	}
	#acs td, #acs th {
	border: 2px solid #ddd;
	padding: 2px;
	}
	#acs td a{
	padding: 5px 20px;
	background-color:#94a3c1;
	border-radius:4px;
	margin-left:5px;
	transition-duration:0.3s;
	color:white
}
#acs caption {
	font-size:30px;
	font-weight: bold;
	font-family: Arial;
	color:#444444;
}
}
</style>
</head>
<body>
<div class="grid-container">
  <div class="grid-item item1"><p><img src="./assets/logo.png" /></p></div>
  <div class="grid-item item2"><h1>FUND MANAGEMENT SYSTEM</h1></div>
  <div class="grid-item item3"><h1>CSE Department</h1><p>Admin Page</p></div>  
</div>
<div class="wrapper">
    <div class="sidebar">
        <h2 class="new_h1">Logged In As <p><?php echo $_SESSION["admin"]?></p></h2>
        <ul>
            <li><a href="admin.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="new_user.php"><i class="fas fa-user-plus"></i>Create User</a></li>
			<li><a href="del_user.php"><i class="fas fa-address-book"></i>Delete User</a></li>
            <li><a href="access.php?request=user"><i class="far fa-file-alt"></i> Access User Records</a></li>
            <li>
            <form id = "my_form" action="adminUpload.php" method= "post">
            <a name  =  "view" href="javascript:{}" onclick="document.getElementById('my_form').submit();"><i class = "fas fa-file-alt"></i>View Document</a>
            <input type  ="hidden"  name = "view" value = "javascript:{}" />  
            </form>
            </li>
            <li><a href="transaction.php"><i class="fas fa-file-invoice-dollar"></i>Update Fund</a></li>
            <li><a href="access.php?request=transaction"><i class="fas fa-file-invoice-dollar"></i>Transactions log</a></li>
            <li>
            <form id = "my_form1" action="admin.php" method= "post">
            <a name  =  "logout" href="javascript:{}" onclick="document.getElementById('my_form1').submit();"><i class = "fas fa-sign-out-alt"></i>Log Out</a>
            <input type  ="hidden"  name = "logout" value = "javascript:{}" />
            </form>
            </li>
        </ul> 
      </div>
    </div>
</div>

<table id="acs" style="float : left"> 
<?php
if($choice <1){
	echo'<caption>USER RECORDS</caption>
	<tr>
	<th style = "text-align : center">USER_ID</th>
	<th style = "text-align : center">NAME</th>
	<th style = "text-align : center">EMAIL ID</th>
	<th style = "text-align : center">BALANCE</th>
	<th style = "text-align : center">OFFICE</th>
	<th style = "text-align : center">CONTACT</th>
	<th style = "text-align : center">REG DATE</th>
	<th style = "text-align : center">EDIT</th>
	</tr>'; 	
	$user_id="";
	$password="";
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$user_id =$row["user_id"];
		$password =$row["password"];
		$acc ='<a href="redirect.php?userid='.$user_id.'& pass='.$password .'" >Edit</a>';
		echo'<tr>
		<td>'.$row["user_id"].'</td>
		<td>'.$row["name"].'</td>
		<td>'.$row["email_id"].'</td>
		<td>'.$row["left_balance"].'</td>
		<td>'.$row["office"].'</td>
		<td>'.$row["contact"].'</td> 
		<td>'.$row["add_date"].'</td> 
		<td style : "text-align : center">'.$acc.'</td> 
		</tr>';
	}
}
else{
	echo'<caption>TRANSACTION LOG</caption>
	<tr>
	<th>TRANS_ID</th>
	<th>NAME</th>
	<th>AMOUNT</th>
	<th>TYPE</th>
	<th>DATE</th>
	<th>PURPOSE</th>
	</tr>'; 

	$user_id="";
	$password="";
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		$user_id =$row["user_id"];
		$password =$row["password"];
		$acc ='<a href="redirect.php?userid='.$user_id.'& pass='.$password .'" >Visit page</a>';
		echo'<tr>
		<td>'.$row["trans_id"].'</td>
		<td>'.$row["name"].'</td>
		<td> Rs.'.$row["amount"].'</td>
		<td>'.$row["type"].'</td>
		<td>'.$row["date"].'</td>
		<td>'.$row["purpose"].'</td> 
		</tr>';
	}	
}
?>
</table>
</body>
</html>