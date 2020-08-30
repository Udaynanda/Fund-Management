<?php
session_start();
require 'config.php';
$uID = ($_SESSION['admin_id']);
$target_dir="../uploads/".$uID."/";

$path_parts=pathinfo($_GET['file']);
$file = $path_parts['basename'];
$file = $target_dir.$file;
if(!file_exists($file)){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: no-cache, must-revalidate");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: binary");
    
    // read the file from disk

    readfile($file);

    
}
?>