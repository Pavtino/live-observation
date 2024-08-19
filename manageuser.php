<?php
include("init.php");

$user = (object) new user();

$action = getArrayVal($_GET, "action");
$id = getArrayVal($_GET, "id");
$mode = getArrayVal($_GET, "mode");
$uid = getArrayVal($_GET, "uid");

if ($action != "login" and $action != "logout" and $action != "add" and $action != "loginerror" and $action != "log" and $action != "list" and $action != "reset" and $action != "active") {
    if (!isset($_SESSION["userid"])) {
        
        header("Location: login.php?loginerror=0");
        die();
    }
}

$name = getArrayVal($_POST, "name");
$role = getArrayVal($_POST, "role");
$email = getArrayVal($_POST, "email");
$tel = getArrayVal($_POST, "tel");
$ville = getArrayVal($_POST, "ville");
$prof = getArrayVal($_POST, "prof");
$genre = getArrayVal($_POST, "genre");
$iduser = getArrayVal($_POST, "iduser");
$state = getArrayVal($_POST, "state");

$namein = getArrayVal($_POST, "namein");
$emailin = getArrayVal($_POST, "emailin");
$telin = getArrayVal($_POST, "telin");
$societein = getArrayVal($_POST, "societein");
$societe = getArrayVal($_POST, "societe");
$villein = getArrayVal($_POST, "villein");
$profin = getArrayVal($_POST, "profin");
$passin = getArrayVal($_POST, "passin");
$pass = getArrayVal($_POST, "pass");

$oldpass = getArrayVal($_POST, "oldpass");
$newpass = getArrayVal($_POST, "newpass");
$repeatpass = getArrayVal($_POST, "repeatpass");
$admin = getArrayVal($_POST, "admin");
$turl = getArrayVal($_POST, "web");
$zip = getArrayVal($_POST, "zip");

// get the available languages
$languages = getAvailableLanguages();
//$template->assign("languages", $languages);


if ($action == "loginerror") {
    //$template->display("resetpassword.tpl");
}elseif ($action == "login") {
    $email = getArrayVal($_POST, "email");
    $pass = getArrayVal($_POST, "pass");
    // Normal login
    if ($user->login($email, $pass)) {
        echo json_encode(true);
    }
    // Login Error
    else {
       echo json_encode(false);
    }
} elseif ($action == "logout") {
    if ($user->logout()) {
      header("location: login.php");
    }
} elseif ($action == "jsonout") {
    if ($user->logout()) {
      echo json_encode("true");
    }
} elseif ($action == "active") {
    if ($user->activate($uid, $pass)) {
      header("Location: dash.php?mode=active");
    } else {
       header("Location: login.php?mode=loginerror");
    }
}  elseif ($action == "add") {//add user
	$url="www.kentseyes.com/";
	$uid=$user->add($namein, $emailin, $villein,$societein,$profin, $passin,$telin,"user");
    if (!empty($uid)) {
		// Send e-mail with new password
        $themail = new emailer();
        $themail->send_mail($emailin, "Activation du compte", "Bonjour,<br/><br/>veuillez cliquer <a href='".$url."active.php?uid=$uid'>ici</a> pour activer votre compte<br/>Ou copier ce lien et coller sur une page internet : ".$url."active.php?uid=$uid<br/>.");

      echo json_encode("true");
    }else
	{
		echo json_encode("false");
	}
}elseif ($action == "log") {
    $email = getArrayVal($_POST, "email");
    $pass = getArrayVal($_POST, "pass");
    // Normal login
    if ($user->login($email, $pass)) {
        header("location: index.php");
    }
    // Login Error
    else {
       header("Location: login.php?loginerror=0");
        die();
    }
}elseif ($action == "edit") {
	
	 if ($user->edit($iduser, $name,  $email, $ville,$prof, $genre, $tel,$role,$societe)) {
            
           echo json_encode("true");
	 }
	 
        
}elseif ($action == "profil") {
	
	 if ($user->edit($iduser, $name,  $email, $ville,$prof, $genre, $tel,$role,$societe)) {
            
            header("Location: users.php?mode=edited");
	 }
	 
        
}elseif($action=="del")
 {	
 $id=$_GET["id"];
 
 $poi = $conn->query("DELETE FROM user WHERE ID=$id");
	

		if (!empty($pois))
		{
			echo json_encode( "true");
		}
		else
		{
			echo json_encode("false");
		}
}elseif($action=="views"){
	$profile=$user->getProfile($id);
	echo json_encode($profile);
}
elseif($action=="change"){

if($user->editpass($_SESSION["userid"], $oldpass, $newpass, $repeatpass))
 {
	 header("Location: dash.php?mode=edited");
 }else
 {
	 header("Location: change.php?mode=error");
 }
	
}elseif ($action == "reset") {
    $newpass = $user->resetPassword($email);
    if ($newpass != "") {
        // Send e-mail with new password
        $themail = new emailer();
        $themail->send_mail($email, "Mot de passe perdu", "Bonjour,<br /><br/>veuillez trouver votre <br /><br />Nouveau mot de passe: " . "$newpass<br />.");

        echo json_encode(true);
    } else {
        
       echo json_encode(false);
    }
} elseif ($action == "list") {
 try {

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$limit_lower=0;
$where =" 1=1 ";
$order_by="ID";
$rows=25;
$current=1;
$limit_l=($current * $rows) - ($rows);
$limit_h=$limit_lower + $rows  ;


//Handles Sort querystring sent from Bootgrid
if (isset($_REQUEST['sort']) && is_array($_REQUEST['sort']) )
  {
    $order_by="";
    foreach($_REQUEST['sort'] as $key=> $value)
		$order_by.=" $key $value";
	}

//Handles search  querystring sent from Bootgrid 
if (isset($_REQUEST['searchPhrase']) )
  {
    $search=trim($_REQUEST['searchPhrase']);
  	$where.= " AND ( name LIKE '".$search."%' OR  email LIKE '".$search."%' ) "; 
	}

//Handles determines where in the paging count this result set falls in
if (isset($_REQUEST['rowCount']) )  
  $rows=$_REQUEST['rowCount'];

 //calculate the low and high limits for the SQL LIMIT x,y clause
  if (isset($_REQUEST['current']) )  
  {
   $current=$_REQUEST['current'];
	$limit_l=($current * $rows) - ($rows);
	$limit_h=$rows ;
   }

if ($rows==-1)
$limit="";  //no limit
else   
$limit=" LIMIT $limit_l,$limit_h  ";
   
//NOTE: No security here please beef this up using a prepared statement - as is this is prone to SQL injection.
$sql="SELECT * FROM user WHERE $where ORDER BY $order_by $limit";

$stmt=$conn->prepare($sql);
$stmt->execute();
$results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode( $results_array );

$nRows=$conn->query("SELECT count(*) FROM user WHERE $where")->fetchColumn();   /* specific search then how many match */

header('Content-Type: application/json'); //tell the broswer JSON is coming

if (isset($_REQUEST['rowCount']) )  //Means we're using bootgrid library
echo "{ \"current\":  $current, \"rowCount\":$rows,  \"rows\": ".$json.", \"total\": $nRows }";
else
echo $json;  //Just plain vanillat JSON output 
exit;
}
catch(PDOException $e) {
    echo 'SQL PDO ERROR: ' . $e->getMessage();
}   
}  
?>