<?php
session_start();
require 'config.php';
if(isset($_POST['but_submit'])){
    echo "1";
    $uname = ($_POST['username']);
    //$_SESSION['uname'] = $uname;
    $pd = ($_POST['pass']);
    //$_SESSION['pd'] = (($_POST['pass']));
    if ($uname != "" && $pd != ""){
      $query = $con->prepare('select user_id, password from user where user.user_id = ? and user.password = ?');
      $query->execute(array($uname,$pd));
      $row = $query->fetch(PDO::FETCH_BOTH);
      if($query->rowCount()>0) {
          echo '1';
          $_SESSION['username'] = $uname;
          $_SESSION['pass'] = $pd;
          header('location: user.php');
      } 
      else {
          echo "1";
          $message = "Username/Password is wrong";
          echo '<script> alert ("Wrong user id or password"); window.history.back();</script>';
      }
    }
}