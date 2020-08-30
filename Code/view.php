<?php
session_start();
// https://www.codexworld.com/upload-multiple-images-store-in-database-php-mysql/
// Remember to make change in php.ini file(search file_uploads)
//Make a dialogue box for succesfull update
//unable to upload file of size >10MB
// 3rd april
require 'config.php';
$uID = ($_SESSION['username']);
$query = $con->prepare('select * from user where user.user_id = ?');
$query->execute(array($uID));
$row = $query->fetch(PDO::FETCH_ASSOC);

?>
 <html>
        <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="admin.css">
        </head>
        <body>
		<div class="grid-container">
  <div class="grid-item item1"><p><img src="./assets/logo.png" /></p></div>
  <div class="grid-item item2"><h1>FUND MANAGEMENT SYSTEM</h1></div>
  <div class="grid-item item3"><h1>CSE Department</h1><p>User Page</p></div>  
</div>
<div class="wrapper">
    <div class="sidebar">
        <h2 class="new_h1">Logged In As <p><?php echo $row["name"]?></p></h2>
        <ul>
            <li><a href="user.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="edituser.php"><i class="far fa-file-alt"></i> Edit Details</a></li>
            <li>
            <form id = "my_form" action="view.php" method= "post">
            <a name  =  "view" href="javascript:{}" onclick="document.getElementById('my_form').submit();"><i class = "fas fa-file-alt"></i>View Document</a>
            <input type  ="hidden"  name = "view" value = "javascript:{}" />  
            </form>
            </li>
            <li>
            <form id = "my_form" action="user.php" method= "post">
            <a name  =  "view" href="javascript:{}" onclick="myfunction()"><i class="fas fa-file-invoice-dollar"></i>Past Transactions</a>
            <input type  ="hidden"  name = "view" value = "javascript:{}" />  
            </form>
            <li>
            <form id = "my_form1" action="user.php" method= "post">
            <a name  =  "logout" href="javascript:{}" onclick="document.getElementById('my_form1').submit();"><i class = "fas fa-sign-out-alt"></i>Log Out</a>
            <input type  ="hidden"  name = "logout" value = "javascript:{}" />
            </form>
            </li>
        </ul> 
      </div>
    </div>
</div>
<div id=displaytable class="container f3">
        <table class="table table-hover">
            <thead>
                <?php
                
                echo'<tr>
                <th scope="col">User ID</th>
                <th scope="col">File(s)</th>   
                </tr>';
                ?>
            </thead>
            <tbody>
<?php
if(isset($_POST["view"])){
	echo'<style type="text/css">
                    #displaytable{display:block;}
                    .f3{
                        padding-left: 5%;
                        padding-right: 5%;
                        padding-top : 5%;
                        padding-bottom: 3%;
                        }</style>';
$target_dir="../uploads/".$uID."/";

if ($handle = opendir($target_dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			$lin="<a href='download.php?file=".$entry." & userid=".$uID."'>".$entry."</a></br>";
			echo '<tr>
                        <td>'.$uID.'</td>
                        <td style : "text-align : center">'.$lin.'</td> 
                        </tr>';	
		}
    	}
    	closedir($handle);
	}
}
?>
</tbody>
		</body>
 </html>