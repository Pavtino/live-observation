<?php
include("init.php");

$user = (object) new user();

$action = getArrayVal($_GET, "action");
$id = getArrayVal($_GET, "id");
$mode = getArrayVal($_GET, "mode");


$name = getArrayVal($_POST, "name");
$realname = getArrayVal($_POST, "realname");
$role = getArrayVal($_POST, "role");
$email = getArrayVal($_POST, "email");
$tel1 = getArrayVal($_POST, "tel1");

// get the available languages
$languages = getAvailableLanguages();
//$template->assign("languages", $languages);


if ($action == "view") {
	
	
		$poi = $conn->query("SELECT  * FROM poi WHERE visible=1 ORDER BY ID desc ");
	
        $pois = array();
        while ($uspoi = $poi->fetch()) {
			//choose files
		$file = $conn->query("SELECT * FROM fichiers WHERE idpoi=".$uspoi["ID"]);
		$files = array();
        while ($usfile = $file->fetch()) {
            array_push($files,$usfile);
        }
		//end choosing files
		$uspoi["files"]=$files;
            array_push($pois, $uspoi);
        }


		if (!empty($pois))
		{
			echo json_encode($pois);
		}
		else
		{
			echo json_encode("ok");
		}
    
}elseif ($action == "dash") {
	
	
		$poi = $conn->query("SELECT  * FROM poi  WHERE ID=$id");
	
       $uspoi = $poi->fetch();
			//choose files
		$file = $conn->query("SELECT * FROM fichiers WHERE idpoi=".$uspoi["ID"]);
		$files = array();
        while ($usfile = $file->fetch()) {
            array_push($files,$usfile);
        }
		//end choosing files
		$uspoi["files"]=$files;

		if (!empty($uspoi))
		{
			echo json_encode($uspoi);
		}
		else
		{
			echo json_encode("ok");
		}
    
}elseif ($action == "files") {
	include("include/thumb.php");
			//choose files
			
	$file = $conn->query("SELECT * FROM fichiers WHERE idpoi=".$id);
		  $files = array();
        $valid=true;
	//upload fichier modifier
	if($file->fetch())
	{
	  while ($usfile = $file->fetch()) {
		
		if($usfile['type']=="image" && !empty($_FILES["image".$usfile['idfile']]["name"]))
		{ 
			$name=$_FILES["image".$usfile['idfile']]["name"];
			$fileurl=upload($_FILES["image".$usfile['idfile']]);
			$thumb="files/thumb".substr($fileurl,5);
			createthumb($fileurl,$thumb,50,50);
			$ins1Stmt= $conn->prepare("UPDATE  fichiers SET url=?,thumb=? WHERE idfile=?");
			$ins1 = $ins1Stmt->execute(array($fileurl,$thumb,$usfile['idfile']));
		}
		if($usfile['type']=="file" && !empty($_FILES["file".$usfile['idfile']]["name"]))
		{ 
			$name=$_FILES["file".$usfile['idfile']]["name"];
			$fileurl=upload($_FILES["file".$usfile['idfile']]);
			$ins1Stmt= $conn->prepare("UPDATE  fichiers SET url=?,thumb=? WHERE idfile=?");
			$ins1 = $ins1Stmt->execute(array($fileurl,$thumb,$usfile['idfile']));
		}
		if($usfile['type']=="video" && !empty($_FILES["video".$usfile['idfile']]["name"]))
		{ 
			$name=$_FILES["video".$usfile['idfile']]["name"];
			$fileurl=upload($_FILES["video".$usfile['idfile']]);
			$ins1Stmt= $conn->prepare("UPDATE  fichiers SET url=?,thumb=? WHERE idfile=?");
			$ins1 = $ins1Stmt->execute(array($fileurl,$thumb,$usfile['idfile']));
		}
	
	  }
	}else
	{
	$imgcount=count($_FILES["images"]["tmp_name"]);
    $othercount=count($_FILES["files"]["tmp_name"]);
	$videocount=count($_FILES["videos"]["tmp_name"]);
	
	$count=0;
	//upload des fichiers
	$target_dir = "files/";
	$i=0;
 foreach( $_FILES[ 'images' ][ 'tmp_name' ] as $index => $tmpName )
    {
      
               
	$name=$_FILES["images"]["name"][$index];
	$extension = pathinfo($name,PATHINFO_EXTENSION);

	$nomImage = md5(uniqid()) .'.'. $extension;
	$fileurl=$target_dir.$nomImage;
    if(move_uploaded_file($_FILES["images"]["tmp_name"][$index], $target_dir.$nomImage)) 
	{
	$thumb="files/thumb".substr($fileurl,5);
    createthumb($fileurl,$thumb,50,50);
	$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url,thumb)VALUES(?,?,?,?,?)");
    $ins1 = $ins1Stmt->execute(array($id,"image",$name,$fileurl,$thumb));
	}

	$i++;
}
$i=0;

foreach( $_FILES[ 'files' ][ 'tmp_name' ] as $index => $tmpName )
    {
	$name=$_FILES["files"]["name"][$i];
	$extension = pathinfo($name,PATHINFO_EXTENSION);
	$nomImage = md5(uniqid()) .'.'. $extension;
	$fileurl=$target_dir.$nomImage;
    if(move_uploaded_file($_FILES["files"]["tmp_name"][$index], $target_dir.$nomImage)) 
	{
	$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url,thumb)VALUES(?,?,?,?,?)");
    $ins1 = $ins1Stmt->execute(array($id,"file",$name,$fileurl,$thumb));
	}
	$i++;
}
$i=0;

foreach( $_FILES[ 'videos' ][ 'tmp_name' ] as $index => $tmpName )
    {
	$name=$_FILES["videos"]["name"][$i];
	$extension = pathinfo($name,PATHINFO_EXTENSION);
	$nomImage = md5(uniqid()) .'.'. $extension;
	$fileurl=$target_dir.$nomImage;
    if(move_uploaded_file($_FILES["videos"]["tmp_name"][$index], $target_dir.$nomImage)) 
	{
	$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url,thumb)VALUES(?,?,?,?,?)");
    $ins1 = $ins1Stmt->execute(array($id,"video",$name,$fileurl,$thumb));
	}
	$i++;
}
	//fin upload des fichiers
}

		if ($file)
		{
			header('Location: dash.php');
		}
		else
		{
			return false;
		}
    
} elseif ($action == "poi") {
 try {

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$limit_lower=0;
if($_SESSION["userrole"]=="admin")
{
$where =" 1=1 ";	
}else
{
$where =" userid=".$_SESSION["userid"];
}
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
  	$where.= " AND ( titre LIKE '".$search."%' OR  description LIKE '".$search."%' ) "; 
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
$sql="SELECT * FROM poi WHERE $where ORDER BY $order_by $limit";

$stmt=$conn->prepare($sql);
$stmt->execute();
$results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode( $results_array );

$nRows=$conn->query("SELECT count(*) FROM poi WHERE $where")->fetchColumn();   /* specific search then how many match */

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
} elseif ($action == "mark") {
$poi1 = $conn->query("SELECT  * FROM poi WHERE ID=$id")->fetch();
echo json_encode($poi1);
	
}
?>