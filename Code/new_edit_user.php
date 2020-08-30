<?php
    session_start();
    require 'PHPMailerAutoload.php';
    require 'config.php';
    $bool = false;
    $var = " ";
    $user_id = " ";
    $user = "";
    $name = " ";
    $email_id = " ";
    $contact = " ";
    $office = " ";
    $add_date = " ";
    $left_balance = " ";
    $tr_type = " ";
    $email= " ";
    $nameUser=" ";
    $msg = '';
    $msg1 = '';
    if(isset($_POST['search_by_userID'])){
        $var = $_POST['search_by_userID'];
        $query = $con->prepare('select * from user where user_id = ?');
        $query->execute(array($var));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount()>0){
            $user_id = $row['user_id'];
            $name= $row['name'];
            $email_id = $row['email_id'];
            $contact = $row['contact'];
            $office = $row['office'];
            $add_date = $row['add_date'];
            $left_balance = $row['left_balance'];
            /*$_SESSION['new_var'] = $user_id;
            $_SESSION['email'] = $email_id;
            $_SESSION['name'] = $name;*/
        }
        else{
            echo '<script> alert ("User does not EXIST"); window.history.back();</script>';
        }
    }
    if(isset($_POST['search_by_emailID'])){
        $var1 = $_POST['search_by_emailID'];
        $query = $con->prepare('select *from user where email_id = ?');
        $query->execute(array($var1));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount()>0){
            $user_id = $row['user_id'];
            $name= $row['name'];
            $email_id = $row['email_id'];
            $contact = $row['contact'];
            $office = $row['office'];
            $add_date = $row['add_date'];
            $left_balance = $row['left_balance'];
        }
        else{
            echo '<script> alert ("User does not EXIST"); window.history.back();</script>';
        }
    }
    if(isset($_POST['tr-btn'])){
        $tr_type = "";
        $tr_type = $_POST['tr_type'];
        $amount = $_POST['amount'];
        $user = $_POST['new_user_id'];
        $email = $_POST['new_email_id'];
        if($tr_type == "Add Fund" && $user != ''){
            $data = ['user_id' => $user, 'amount' => $amount];
            $sql = $con->prepare('update user set left_balance = left_balance + :amount where user_id=:user_id');
            $status = $sql->execute($data);
            $sql = $con->prepare('select max(trans_id) as m from transactions');
            $sql->execute();
            $id = $sql->fetch(PDO::FETCH_ASSOC);
            $id1 = 0;
            $id1 = $id['m'];
            if(isset($user))$msg = '<div class = "alert alert-success w-100" role = "alert" style = "margin : auto; text-align:center"> <strong>Transaction Successful !!! </strong> </div>';
            
            $data = ['trans_id' => $id1+1, 'credit' => "Credit", 'amount' => $amount];
            $sql = $con->prepare('insert into transactions(trans_id, type, amount, date,purpose) values (:trans_id,:credit,:amount,NOW(),"Online Payment")');
            $status = $sql->execute($data);
            $data = ['trans_id' => $id1+1, 'user_id' => $user];
            $sql = $con->prepare('insert into balance values(:user_id,:trans_id)');
            $status = $sql->execute($data);
            $bool = true; 
            $type="Credited";
            
        }
        else if ($tr_type == "Withdraw Fund" && $user != ''){
            $sql = $con->prepare('select left_balance from user where user_id= ?') ;
            $sql->execute(array($user));
            $loc = $sql->fetch(PDO::FETCH_ASSOC);
            $loc1 = $loc['left_balance'];
            if($loc1 >= $amount){
            $data = ['user_id' => $user, 'amount' => $amount];
            $sql = $con->prepare('update user set left_balance = left_balance - :amount where user_id=:user_id');
            
            $sql = $con->prepare('select max(trans_id) as m from transactions');
            $sql->execute();
            $id = $sql->fetch(PDO::FETCH_ASSOC);
            $id1 = 0;
            $id1 = $id['m'];
            $data = ['trans_id' => $id1+1, 'credit' => "Debit", 'amount' => $amount];
            $sql = $con->prepare('insert into transactions(trans_id, type, amount, date,purpose) values (:trans_id,:credit,:amount,NOW(),"online payment")');
            $sql->execute($data);
            $data = ['trans_id' => $id1+1, 'user_id' => $user];
            $sql = $con->prepare('insert into balance values(:user_id,:trans_id)');
            $sql->execute($data);
            if($sql)$msg = '<div class = "alert alert-success w-100" role = "alert" style = "margin : auto; text-align:center"> <strong>Transaction Successful !!! </strong> </div>';
            $bool = true;
            $type="Debited";
            }
            else $msg = '<div class = "alert alert-danger w-100" role = "alert" style = "margin : auto; text-align:center"> <strong>Insufficient Balance !!!</strong>  </div>';
        }
        else {
            $msg = '<div class = "alert alert-danger w-100" role = "alert" style = "margin : auto; text-align:center"> <strong>Something Went Wrong !!!</strong>  </div>';
        }
        if($bool){
		//echo !extension_loaded('openssl')?"Not Available":"Available";
		 $query = $con->prepare('select left_balance from user where user_id = ?');
            $query->execute(array($user));
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $left=$row['left_balance'];
            $mail = new PHPMailer;
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'myggl.uday@gmail.com';                 // SMTP username
            $mail->Password = 'M.uk@2k18';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;
            $mail->addAddress($email,$nameUser);     // Add a recipient
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);   
            $body="<h4>This is a computer generated mail.</h4><p>Your account is ".$type." for Rs. ".$amount." /- on ".date("Y/m/d")." by Transfer.</p>Available Balance is Rs. ".$left." /-. (UPI REFERENCE NO is : ".$user_id.").<br/>KKS<br/>Something<br/>Office Address<br/>CSE DEPARTMENT <br/> Indian Institute Of Technology INDORE.";
            $Content="Your account has been ".$type." with Rs. ".$amount." /-. The Left Balance is Rs. ".$left." /-";
            $mail->Subject = 'Notification for Fund Credit/Debit';
            $mail->Body   = $body;
            $mail->AltBody=$Content;
            if(!$mail->send()) {
               //
            } 
            else {
                $msg1 = '<div class = "alert alert-success w-100" role = "alert" style = "margin : auto; text-align:center"> <strong> An Email has been sent to the User !!! </strong> </div>';
            }
        }
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="transaction.css">
        <link href='//fonts.googleapis.com/css?family=RobotoDraft:regular,bold,italic,thin,light,bolditalic,black,medium&lang=en' rel='stylesheet'> 
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



        <div class = "container main">
            <div class = "mt-2 container prime1 border border-secondary" style = "padding-top : 0.5%; padding-bottom : 0.5%; border-radius: 8px">
                <div class="row">
                <div class="col-6" style = "text-align:left;color: #3B5998">
                    <h4>Transaction Management</h4>
                </div>
                <div class = "col-6" style = "text-align:right;color: #3B5998">
                    <a class = "btn" href = "admin.php"><h5 style="color: #3B5998">Home</h5></a>
                </div>
                </div>
            </div>    
            <div class="mt-2 container prime border border-secondary">
                <div class ="container searchBox">
                    <div class = "row">
                    <?php if(!is_null($msg)) echo $msg?>
                    </div>
                    <div class = "row">
                    <?php if(!is_null($msg1)) echo $msg1?>
                    </div>
                    <div class = "row">
                        <div class="col-md-auto searchText">
                            <i class = "text-secondary searchText1" style = "font-family :-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Search by User ID</i> 
                        </div>
                        <form action = "transaction.php" method="post">
                        <div class="col-md-auto  func0">
                            <input type="text" class="search-hover" name="search_by_userID" placeholder="search here...">
                        </div></form>
                        <div class="col searchText createuser">
                            <a href="new_user.php" class = "text-danger searchText1" style = "font-family :-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Create New User</a>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-md-auto searchText">
                            <i class = "text-secondary searchText1" style = "font-family :-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Search by Email ID</i> 
                        </div>
                        <form action = "transaction.php" method="post">
                        <div class="col-md-auto">
                            <input type="text" class="search-hover" name="search_by_emailID" placeholder="search here...">
                        </div></form> 
                    </div>    
                </div>
            </div>
            <form action = 'transaction.php' method = 'post'>
            <div class = "mt-2 container prime1 border border-secondary">  
                <div class="row">
                    <div class="col-2" style="text-align:left">
                        <h5> User-Id : </h5>
                    </div>
                    <div class="col-3" style="text-align:left">
                        <input class = "h5" name  = "new_user_id" style="border: none;" value = <?php if(isset($user_id))echo $user_id ?>>
                    </div>
                    <div class="col-2" style="text-align:left">
                        <h5> Email-Id: </h5>
                    </div>
                    <div class="col-5" style="text-align:left">
                    <input class = "h5" name  = "new_email_id" style="border: none;" value = <?php if(isset($email_id))echo $email_id ?>>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2" style="text-align:left">
                        <h5> Name: </h5>
                    </div>
                    <div class="col-3" style="text-align:left">
                        <h5> <?php echo $name ?> </h5>
                    </div>
                    <div class="col-2" style="text-align:left">
                        <h5> Contact : </h5>
                    </div>
                    <div class="col-5" style="text-align:left">
                        <h5> <?php echo $contact ?> </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2" style="text-align:left">
                        <h5> Office : </h5>
                    </div>
                    <div class="col-3" style="text-align:left">
                        <h5> <?php echo $office ?> </h5>
                    </div>
                    <div class="col-2" style="text-align:left">
                        <h5> Reg. Date : </h5>
                    </div>
                    <div class="col-5" style="text-align:left">
                        <h5> <?php echo $add_date ?> </h5>
                    </div>
                </div>
            </div>
            <div class = "mt-2 container prime2 border border-secondary">
                <!--form action = 'transaction.php' method = 'post'-->
                <div class = 'row'>    
                    <div class='col-md-1.5 ml-2' style = "text-align:left">
                        <p style = "font-size : 20px">Avail. Bal:</p>
                    </div>
                    <div class = "col-md-2 text-success ml-2"style = "text-align:center">
                        <p style = 'font-size:20px'><?php echo 'Rs. '.$left_balance.'/-' ?></p> 
                    </div>
                    <div class='col-md-1.5' style ='text-align:right'>
                        <p style="font-size: 20px">Update Bal : </p>
                    </div>
                    <div class = 'col-md-3'>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rs.</span>
                            </div>
                            <input type="text" class="form-control" name = "amount"placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>
                    </div>
                    <div class= 'col-md-2' style= 'padding-top:0.0%; padding-left:2%'>
                        <select class="form-control" name="tr_type">
                            <option>Add Fund</option>
                            <option>Withdraw Fund</option>
                        </select>
                    </div>
                    
                    <div class = 'col-md-1'>
                        <button name = "tr-btn" class="btn btn-primary " type ="submit" onclick = "myFunction">Update</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </body>
</html>