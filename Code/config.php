<hmtl>
  <head>
  <script src="https://kit.fontawesome.com/c4b975f7fd.js" crossorigin="anonymous"></script>
  </head>
</hmtl>
<?php 
$dsn = "mysql:host=localhost;port=3307;dbname=fund";

try{
$con = new PDO($dsn,"root","");
/*$query =  "select * from id_pass";
$data = $con->query($query);
echo '<table width = "70%" border = "1" cellpadding = "5" cellspacing = "5">
        <tr>
            <th>id</th>
            <th>user_id</th>
            <th>password</th>
            <th>type</th>
        </tr>';
    foreach($data as $row){
        echo '<tr>
        <th>'.$row["id"].'</th>
        <th>'.$row["user_id"].'</th>
        <th>'.$row["password"].'</th>
        <th>'.$row["type"].'</th>
        </tr>';
    }
    echo '</table>';*/
  }catch(PDOException $e){
    die("Error: " . $e->getMessage());
  }
?>