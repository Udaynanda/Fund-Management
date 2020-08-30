<?php
// 3rd April
// https://stackoverflow.com/questions/12094080/download-files-from-server-php
// https://www.media-division.com/the-right-way-to-handle-file-downloads-in-php/
// need to do the css
// need to understand the header lines
// on clicking the file gets downloaded directly (i.e force download)
session_start();
$uID = ($_GET['userid']);
$target_dir="../uploads/".$uID."/";
echo $target_dir;
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