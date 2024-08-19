<?php
include("init.php");
$uid = getArrayVal($_GET, "uid");
$user = (object) new user();
$pass='toto';
if ($user->activate($uid, $pass)) {
      echo 'bon';
    } else {
      echo 'faux';
    }
$pass=sha1($pass);
	 $sel1 = $conn->query("SELECT ID,name,lastlogin,genre,role,active FROM user WHERE uid = '$uid' AND pass = '$pass'");
        $chk = $sel1->fetch();
       
            $_SESSION['userid'] = $chk['ID'];
            $_SESSION['username'] = stripslashes($chk['name']);
            $_SESSION['usergenre'] = $chk['genre'];
			$_SESSION['userrole'] = $chk['role'];
			$_SESSION['active'] = $chk['active'];
			echo $chk['name'];

?>