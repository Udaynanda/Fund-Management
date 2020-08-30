<?php
session_start();
require 'config.php'; // use config file for connection
$sql = $con->prepare("SELECT * FROM user;");
$sql->execute();
$xyz = '';
if(isset($_POST['btn_search'])){
  $uid = ($_POST['viewuser']);
  if (!is_null($uid)){
    $query = $con->prepare('select *from user where user_id = ?');
    $query->execute(array($uid));
    $xyz = $query->fetch(PDO::FETCH_ASSOC);
    if($query->rowCount()>0) {
      $user_id =$xyz["user_id"];
        header('location: viewuser.php?userid='.$user_id.'');
    } 
    
  }
}
$search = $con->prepare("SELECT password from user where user_id=?;");
$t=time();
$ti = $t - 86400;
$time = date("Y-m-d",$ti);
$query = $con->prepare("SELECT type,amount,purpose,name,u.user_id,password, date FROM transaction t inner join balance b on b.trans_id = t.trans_id inner join user u on u.user_id=b.user_id WHERE t.date>=? order by t.trans_id asc;"); 
$query->execute(array($time));
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
	<title>IIT Indore Fund Management system</title>
    <link rel="shortcut icon" href="	./assets/favicon.jpeg">
    <script src="https://kit.fontawesome.com/c4b975f7fd.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	.sidebar a{
		cursor:pointer;
	}
	</style>
  </head>
  <body>
  <section>
    <div class="grid-container">
		<div class="grid-item item1"><p><img src="./assets/logo.png" style="max-width:100%;"></p></div>
		<div class="grid-item item2"><h1>FUND MANAGEMENT SYSTEM</h1></div>
		<div class="grid-item item3"><h1>CSE DEPARTMENT</h1><p>ADMIN PAGE</p></div>  
	</div>
    <input type="checkbox" id="check">
    <label for="check">
      <i class="fas fa-bars" id="btn"></i>
      <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
      <header>BROWSE</header>
      <a href="#" >
        <i class="fas fa-home"></i>
        <span>Home</span>
      </a>
      <a href="#">
        <i class="fas fa-user-plus"></i>
        <span>Create User</span>
      </a>
      <a href="#">
        <i class="fas fa-stream"></i>
        <span>User Records</span>
      </a>
      <a href="#">
         <i class="fas fa-dollar-sign"></i>
        <span>Transaction</span>
      </a>
      <a href="#">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Transaction log</span>
      </a>
      <a href="#">
        <i class="fas fa-user-minus"></i>
        <span>Delete User</span>
      </a>
      <a onclick="myf()">
        <i class="fas fa-upload"></i>
        <span>Upload file</span>
      </a>
      <a href="#">
        <i class="fas fa-eye"></i>
        <span>view file</span>
      </a>	  
    </div>
	<div class = "id">
		<div class ="pic"><h1><i class="fas fa-id-card fa-1g"></i></h1></div>
		<div class ="det"><p><?php echo $_SESSION["admin"]?></p></div>
	</div>
	<form autocomplete="off" method="post" action="admin.php" >
		<div class="autocomplete" id="search1">
		<input id="myInput" type="text" name="viewuser" placeholder="Search User">
		<button type="submit" class="bt" name = "btn_search"><i class="fa fa-search fa-lg"></i></button>
		</div>
	</form>
	<div id="dcs" class="dcs">
		<form action ="adminUpload.php" method= "post" enctype="multipart/form-data">Select Files to Upload : 
            <input type="file" name="fileToUpload[]" id="fileToUpload" multiple></br>
            <button class="btn-primary btn-lg" id="fileToUpload" name ="submit" type="submit">Upload Files</button>	
		</form>
	</div>
	<div class ="announcements">
		<div class="picture">
			<div class ="ball">
				<i class="fas fa-rupee-sign fa-1g"></i>
			</div>
		</div>
		<div class="head">
			<h>Recent transactions</h>
		</div>
		<div class ="trans">
			<hr class ="line">
			<?php
			echo '<marquee behavior="scroll" direction="up" scrollamount="2" height=200px onmouseover="this.stop();"onmouseout ="this.start();"><ol>';
			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$user_id = $row["user_id"];
				$password = $row["password"];
				echo '<li><a href="redirect.php?subject='.$user_id.'& web='.$password .'" >'.strtoupper($row["name"]).'s account has been '.$row["type"].'ed for Rs.'.$row["amount"].'<br>on '.$row["date"].' for the  purpose:'.strtoupper($row["purpose"]).'</a></li><hr style="border-top: 0.1px dashed white ;border-bottom: 0.1px dashed white ">';	
			}
			echo '</ol></marquee>'
			?>
		</div>
	</div>

	<script>
		document.getElementById("search1").style.display = "block";
		function myf() {
		document.getElementById("dcs").style.display = "block";
		}
	</script>	
	</section>
</body>
</html>
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var users = [];
<?php
  while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	  $acc = '<a href="default.asp" target="_blank">visit page</a>';
    echo'users.push("'.$row["user_id"].'");';
  }
	
?>
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), users);
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_REQUEST["viewuser"];
  if (empty($name)) {
    echo 'Name is empty';
  } else {
	  $SESSION["username"] = $name;
	  $search->execute(array($name));
	  while($row = $search->fetch(PDO::FETCH_ASSOC)){
		  $_SESSION["pass"]= $row["password"];
	  }
	  
    echo '<meta http-equiv="refresh" content="0;URL=user.php">';
  }
}
?>
