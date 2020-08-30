<?php
session_start();
require 'config.php';
require 'PHPMailerAutoload.php';
//$dsn = "mysql:host=localhost;port=3308;dbname=fund";
//$con = new PDO($dsn,"root","");
$sql= $con->prepare("SELECT * FROM user ");
$sql->execute();
$bool=false;

if(isset($_POST['but_submit'])){
    $uname = ($_POST['username']);
    $password = ($_POST['password']);
    if ($uname != "" && $password != ""){
      $query = $con->prepare('select * from admin where admin.admin_id = ? and admin.password = ?');
      $query->execute(array($uname,$password));
      $row = $query->fetch(PDO::FETCH_ASSOC);
      if($query->rowCount()>0) {
		  $email="";
		  $email=$row["email_id"];
          $_SESSION['admin'] = $row["name"];
          $_SESSION["admin_id"] = $row["admin_id"];
          $bool=true;
          header('location: direct.php');
      } 
      else {
          $message = "Username/Password is wrong";
          echo '<script> alert ("Wrong user id or password"); window.history.back();</script>';
      }
    }
}
        if($bool){
			$host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
            $mail = new PHPMailer;
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'myggl.uday@gmail.com';                 // SMTP username
            $mail->Password = 'M.uk@2k18';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->setFrom('myggl.uday@gmail.com', 'CSE DEPARTMENT');
            $mail->addAddress($email,$_SESSION['admin']);     // Add a recipient
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);   
            $body="<h4>This is a computer generated mail.</h4><p>Login noticed on ".date("Y-m-d-h-i-sa")."  as ".$_SESSION['admin'].".<br/>IP address:".$host."<br/>KKS<br/>Something<br/>Office Address<br/>CSE DEPARTMENT <br/> Indian Institute Of Technology Indore";
            $Content="Login noticed on".date("Y-m-d-h-i-sa")."as".$_SESSION['admin'].'.';
            $mail->Subject = 'Notification for Login';
            $mail->Body   = $body;
            $mail->AltBody=$Content;
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                } 
            else {
                echo 'Message has been sent';
                    }

            }
?>