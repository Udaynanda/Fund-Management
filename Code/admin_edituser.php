<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- Sweet Alert -->  
    </head>
</html>

<?php
session_start();
require 'config.php';

$uname =  ($_SESSION['username']);  //username of user
$pd = ($_SESSION['pass']);
$query = $con->prepare('select email_id, name, contact, office from user where user.user_id = ?'); 
$query->execute(array($uname));
$row = $query->fetch(PDO::FETCH_ASSOC); //Fetches and displays User Details.

if(isset($_POST['but_submit']))
{
    $a = $_POST['mail_id'];  //Input for Email Id.
    $b = $_POST['username']; //Input for Username.
    $d = $_POST['office'];   //Input for Office Address.
    $e=$_POST['contact'];    //Input for Contact Number

      $sql1 = 'update user set 
               email_id =:a , 
              name = :b, 
              office = :d, 
              contact = :e 
              where user_id=:h'; //sql query for updating details in table.
      $statement = $con->prepare($sql1);
      $new=$statement->execute(array(":a"=>$a,":b"=>$b,":e"=>$e,":d"=>$d,":h"=>$uname));
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      if($new) 
      {
          echo "<script type='text/javascript'>
            Swal.fire('Success','Edited User Details!!','success')
          </script>";
          $query = $con->prepare('select email_id, name, contact, office from user where user.user_id = ?');
          $query->execute(array($uname));
          $row = $query->fetch(PDO::FETCH_ASSOC); //Displays Details after Edit operation by fetching details from table in database. 
      }
      else
      {
        echo "<script type='text/javascript'>
        Swal.fire('Error','Unable to Edit User Details!!','error')
        </script>";
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
    <body>
    <div class="container-fluid c0">
        <div class="jumbotron f1">
          <img class="img-responsive img" src="./assets/logo1.png" alt="">
        </div>
      <div>
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
              <div style="text-align: right;"><a class = "text-muted" href="admin.php"> Go Back </a></div>
                <h5 class="card-title text-center g3">Edit User Details</h5>
                <form action="" method = "post" class="form-signin">
                <div class="form-label-group">
                    <?php
                    echo '<input type="email" maxlength="29" name="mail_id" value="'.$row['email_id'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="inputEmail">Email Id</label>
                  </div>
                  <div class="form-label-group">
                    <?php
                    echo '<input type= "text" maxlength="24" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))" name="username" value="'.$row['name'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="username">Name</label>
                  </div>
                  <div class="form-label-group">
                    <?php
                    echo '<input name="office" maxlength="20" value="'.$row['office'].'" class="form-control" placeholder="Office" Required>';
                    ?>
                    <label for="inputOffice">Office Address</label>
                  </div>
                  <div class="form-label-group">
                  <?php
                    echo '<input type="tel" name="contact" value="'.$row['contact'].'" class="form-control" placeholder="Name" pattern="[0-9]{10}" Required>';
                    ?>
                    <p style="text-align:center;font-size:0.8vw">Contact Number Format: 9876543210</p>
                    <label for="inputContact">Contact Number</label>
                  </div>
                  <button class="btn btn-lg btn-primary btn-block text-uppercase"  id="lgin"  name ='but_submit' type="submit">Save Changes</button>
             </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>