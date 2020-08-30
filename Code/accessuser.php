<?php
require 'config.php'; // use config file for connection
$sql= $con->prepare("SELECT * FROM user");
$sql->execute();
 
?>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="user.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<style>
#iit{
	background-color:blue;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	width:100%;
	height:200px;
	border-radius: 50px;
}
#iit h1{
	padding-top:70px;
	padding:100px;
	
}
#acs {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  margin:250px 35px 35px 175px;
  width: 75%;
}
#acs tr{
	border : 1px solid #ddd;
	border-radius:25px;

}
#acs td, #acs th {
  border: 2px solid #ddd;
  padding: 8px;
}
#acs td{
	text-align:left;
}

#acs tr:nth-child(even){background-color: #f2f2f2;}

#acs tr:hover {background-color: #ddd;}

#acs th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: 007fff;
  color: white;
}
</style>
</head>
<div class="container-fluid c0">
        <div class="jumbotron f1">
          <img class="img-responsive img" src="logo1.png" alt="">
        </div>
      <div>
  <table id="acs"> 
  <tr>
  <th>User ID</th>
  <th>Name</th>
  <th>Email ID</th>
  <th>Availabe Balance</th>
  <th>Office</th>
  <th>Contact</th>
  </tr> 

  <?php
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    
      echo'<tr>
      <td>'.$row["user_id"].'</td>
      <td>'.$row["name"].'</td>
      <td>'.$row["email_id"].'</td>
      <td>'.$row["left_balance"].'</td>
      <td>'.$row["office"].'</td>
      <td>'.$row["contact"].'</td> 
      </tr>';
    }
  ?>
  </table>
</body>
</html>