<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- Sweet Alert -->  
    </head>
</html>
<?php
session_start();
require 'config.php';
$show_modal=false;

if(isset($_POST['but_submit']))
{
  $a = $_POST['user_id'];  //Input for User Id.
  $b = $_POST['username']; //Input for Name.
  $c =$_POST['email'];     //Input for Email Id.
  $d = $_POST['office'];   //Input for Office Address.
  $e=$_POST['contact'];    //Input for Contact number.
  $f = $_POST['fund'];     //Input for Initial Funding.
  $g= $_POST['pass'];      //Input for Password.
  $k= $_POST['passchk'];   //Input for Confirm Password.
  $h= date("Y-m-d");       //Input for Date.
  
  $query = $con->prepare('select email_id from user where user.user_id = ?'); 
  $query->execute(array($a));
  $row = $query->fetch(PDO::FETCH_ASSOC); //Fetches and displays User Details.
  if($row)
  {
    echo "<script type='text/javascript'>
              Swal.fire('Error','User Already Exists!!','error')
            </script>";
  }
  else
  {
    if( $g!=$k)
    // Check if Password and Confirm Password are same.
    {
      echo "<script type='text/javascript'>
                Swal.fire('Error','Entered Passwords Didnot Match!','error')
              </script>";
    }
    else
    {
        $sql="INSERT INTO `user`(`user_id`, `email_id`, `name`, `password`, `contact`, `office`, `add_date`, `left_balance`) VALUES (:a,:c,:b,:g,:e,:d,:h,:f)";
        //sql query to insert values into table.
        $result=$con->prepare($sql);
        $row=$result->execute(array(":a"=>$a,":c"=>$c,":b"=>$b,":g"=>$g,":e"=>$e,":d"=>$d,":h"=>$h,":f"=>$f));

        if($row) 
        { 
            mkdir("../uploads/".$a); // To make a directory for uploading this particular user's files 
            //Dialog box if insertion into database is successfull.
            $sql = "INSERT INTO work (user_id, admin_id)  values (:a,:b)";
            $result = $con->prepare($sql);
            $row=$result->execute(array(":a"=>$a,":b"=>$_SESSION['admin_id']));
            echo "<script type='text/javascript'>
                    Swal.fire('Success','New User Added!!','success')
                </script>";
        }
        else
        {
          //Else error.
          echo "<script type='text/javascript'>
                    Swal.fire('Error','Unable to add User!!','error')
                </script>";
        }
    }
  }
}




?>

<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="new_user.css">
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
<script src="https://kit.fontawesome.com/c4b975f7fd.js" crossorigin="anonymous"></script>   
<link rel="stylesheet" href="admin.css">
</head>

<body>
<section>
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
<div class="container magic">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
              <div style="text-align: right;"><a class = "text-muted" href="admin.php"> Go Back </a></div>
                <h5 class="card-title text-center g3">Create New User</h5>
                <form action="" method = "post" class="form-signin">
                  <div class="form-label-group">
                    <input type="text" maxlength="29" name="user_id" class="form-control" placeholder="User Id" required autofocus>
                    <label for="username">User Id</label>
                  </div>
                  <div class="form-label-group">
                    <input type="text" maxlength="24" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))' name="username" class="form-control" placeholder="Name" required autofocus>
                    <label for="username">Name</label>
                  </div>
                  <div class="form-label-group">
                    <input type="email" maxlength="29" name="email" class="form-control" placeholder="Email address" required autofocus>
                    <label for="inputEmail">Email Id</label>
                  </div>
                  <div class="form-label-group">
                    <input  type="text" maxlength="20" name="office"  class="form-control" placeholder="Office Address" required>
                    <label for="inputOffice">Office Address</label>
                  </div>
                  <div class="form-label-group">
                    <input type="tel" name="contact"  class="form-control" placeholder="Contact Number" pattern="[0-9]{10}" required>
                    <p style="text-align:center;font-size:0.8vw">Contact number must contain 10 digits</p>
                    <label for="inputContact">Contact Number</label>
                  </div>
                  <div class="form-label-group">
                    <input type="number" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))" min="0" max="999999999999999" name="fund" class="form-control" placeholder="Initial Funding" required>
                    <label for="inputFunding">Initial Funding in Rupees</label>
                  </div>
                  <div class="form-label-group">
                    <input type="password" maxlength="25" name="pass" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Password</label>
                  </div>
                  <div class="form-label-group">
                    <input type="password" name  = "passchk" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Confirm Password</label>
                  </div>
                  <button class="btn btn-lg btn-primary btn-block text-uppercase"  id="lgin"  name ='but_submit' type="submit">Submit</button>
             </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
</body>
</html>