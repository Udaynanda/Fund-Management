<?php
session_start();
// https://www.codexworld.com/upload-multiple-images-store-in-database-php-mysql/
// Remember to make change in php.ini file(search file_uploads)
//Make a dialogue box for succesfull update
//unable to upload file of size >10MB
// 3rd april
require 'config.php';
$uID = ($_SESSION['admin_id']);
$dis=false;
$allowed=array('pdf','txt','png'); //File types
$target_dir="../uploads/".$uID."/"; //Target Directory for a specific user // path from root 
if(isset($_POST["submit"])){
$statusMsg ='Hello';
$fileNames = array_filter($_FILES['fileToUpload']['name']);
if(!empty($fileNames)){
	foreach ($_FILES['fileToUpload']['name'] as $key => $val) {
		// file upload path
		$fileName=basename($_FILES['fileToUpload']['name'][$key]); //see this
		$targetFilePath=$target_dir.$fileName;
		$size= $_FILES["fileToUpload"]["size"][$key];
		// Check whether file type is valid 
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION)); 
        if(in_array($fileType, $allowed)){
        	// Upload file to Server
           // echo $targetFilePath;
        	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key],$targetFilePath)){
        		$statusMsg="File Uploaded Succesfully";
        	}
        	else{
        		//$errorUpload.=$_FILES["fileToUpload"]["name"][$key].' | ';
        		$statusMsg="Error in Upload";
        	}
        }
        else {
        	//$errorUpload.=$_FILES["fileToUpload"]["name"][$key].' | ';
        	$statusMsg="Wrong File Format For ".$_FILES["fileToUpload"]["name"][$key];
        }

	}
	
}
else {
		$statusMsg="Please Select a File to Upload";
	}
	echo $statusMsg;
}


if(isset($_POST["view"])){
    $query = $con->prepare('SELECT user_id from work where admin_id = ?');
    $query->execute(array($uID));
    $dis=true;
}
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
  <div class="grid-item item1"><p><img src="./assets/logo.png" style = "max-width : 100%; " /></p></div>
  <div class="grid-item item2"><h1>FUND MANAGEMENT SYSTEM</h1></div>
  <div class="grid-item item3"><h1>CSE Department</h1><p>Admin Page</p></div>  
</div>
<div class="wrapper padding-top : 100px">
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
        <div id=displaytable class="container f3">
        <table class="table table-hover">
            <thead>
                <?php
                if($dis){
                echo'<tr>
                <th scope="col">User ID</th>
                <th scope="col">File(s)</th>   
                </tr>';}
                ?>
            </thead>
            <tbody>
                <?php
                    if($dis){
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
                    $lin= "<a href='downloadAdmin.php?file=".$entry."'>".$entry."</a></br>";
                    echo '<tr>
                        <td>'.$uID.'</td>
                        <td style : "text-align : center">'.$lin.'</td> 
                        </tr>';
                    }
                }
                closedir($handle);
                    }
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
                        $uid=$row["user_id"];
                        $target_dir="../uploads/".$uid."/";
                        if ($handle = opendir($target_dir)) {
                        while (false !== ($entry = readdir($handle))) {
                         if ($entry != "." && $entry != "..") {
                            $lin="<a href='download.php?file=".$entry." & userid=".$uid."'>".$entry."</a></br>";
                        echo '<tr>
                        <td>'.$row["user_id"].'</td>
                        <td style : "text-align : center">'.$lin.'</td> 
                        </tr>';
                    }
                }
                        closedir($handle);
                        }
                    }
                } 
                ?>
            </tbody>
    </body>
    