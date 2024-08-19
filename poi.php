<?php
include("init.php");
//global $conn;	
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
 //$result=mysql_connect("localhost","root","");
 $action=$_GET["action"];
 if($action=="insert")
 {	
 $titre=htmlentities($_POST["titre"],ENT_QUOTES);
 $lieu=htmlentities($_POST["lieu"],ENT_QUOTES);
 $desc= htmlentities($_POST["desc"],ENT_QUOTES);
 $lat=$_POST["lat"];
 $long=$_POST["long"];
 $dep=htmlentities($_POST["dep"],ENT_QUOTES);
 $ard=htmlentities($_POST["ard"],ENT_QUOTES);
 $dateob=$_POST["dateob"];
 $status=0;
 $userid=0;
 if(isset($_SESSION["userid"]))
  {
  $userid=$_SESSION["userid"];
  }
 $ins1Stmt= $conn->prepare("INSERT INTO poi(titre,lieu,description,status, lat,lng,dep,ard,dateob,datejour,userid) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
 $ins1 = $ins1Stmt->execute(array($titre,$lieu,$desc,$status, $lat, $long,$dep,$ard,$dateob,date("Y-m-d"),$userid));
	
	if ($ins1) {
	  //create user account
	  $insid = $conn->lastInsertId();
	  $_SESSION["id"]=$insid;
      echo json_encode($insid);
	}
	else
	{
		echo json_encode("false");;
	}
 }elseif($action=="file")
 {
	include("include/thumb.php");
	$idpoi=$_GET["idpoi"];
	$imgcount=$_POST["imgcount"];
    $othercount=$_POST["othercount"];
	$videocount=$_POST["videocount"];
	
	$count=0;
	//upload des fichiers
	$i=0;
while($imgcount>$i)
{
	$name=$_FILES["image".$i]["name"];
	$fileurl=upload($_FILES["image".$i]);
	$thumb="files/thumb".substr($fileurl,5);
    createthumb($fileurl,$thumb,50,50);
	$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url,thumb)VALUES(?,?,?,?,?)");
    $ins1 = $ins1Stmt->execute(array($idpoi,"image",$name,$fileurl,$thumb));

	$i++;
}
$i=0;

while($othercount>$i)
{
	$name=$_FILES["file".$i]["name"];
	$fileurl=upload($_FILES["file".$i]);
	$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url)VALUES(?,?,?,?)");
    $ins1 = $ins1Stmt->execute(array($idpoi,"file",$name,$fileurl));

	$i++;
}
$i=0;

while($videocount>$i)
{
	$name=$_FILES["video".$i]["name"];
	$fileurl=upload($_FILES["video".$i]);
	$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url)VALUES(?,?,?,?)");
    $ins1 = $ins1Stmt->execute(array($idpoi,"video",$name,$fileurl));

	$i++;
}
	//fin upload des fichiers
 if($ins1)
 {
	  echo json_encode("ok");
 }
	
 }elseif($action=="edit")
 {	
 $titre=htmlentities($_POST["titreed"],ENT_QUOTES);
 $desc=htmlentities($_POST["desc"],ENT_QUOTES);
 $lat=$_POST["lated"];
 $long=$_POST["longed"];
 $dep=htmlentities($_POST["deped"],ENT_QUOTES);
 $ard=htmlentities($_POST["arded"],ENT_QUOTES);
 $lieu=htmlentities($_POST["lieued"],ENT_QUOTES);
 $idata=$_POST["idata"];
 $dateed=$_POST["dateed"];
 

   if($_SESSION["role"]=="admin")
	{
		$status=$_POST["status"];
        $visible=$_POST["visible"];
		 if($status==0)
		 {
			 $img="img/orange.png";
		 }elseif($status==1)
		 {
			 $img="img/red.png";
		 }elseif($status==2)
		 {
			 $img="img/green.png";
		 }
   $ins1Stmt= $conn->prepare("UPDATE poi SET titre=?,description=?,status=?,img=?, lat=?,lng=?,dep=?,ard=?,lieu=?,visible=?,dateob=? WHERE ID=?");
 $ins1 = $ins1Stmt->execute(array($titre,$desc,$status,$img,$lat,$long,$dep,$ard,$lieu,$visible,$dateed,$idata));
	}else
	{
	$ins1Stmt= $conn->prepare("UPDATE poi SET titre=?,description=?,lat=?,lng=?,dep=?,ard=?,lieu=?,dateob=? WHERE ID=?");
 $ins1 = $ins1Stmt->execute(array($titre,$desc,$lat,$long,$dep,$ard,$lieu,$dateed,$idata));	
	}
	if ($ins1) {
	  //create user account
	  $insid = $idata;
	  //$_SESSION["id"]=$insid;
      echo json_encode($insid);
	}
	else
	{
		echo json_encode("false");;
	}
 }elseif($action=="search")
 {	
 $titre=htmlentities($_POST["titresr"],ENT_QUOTES);
 $datepoi1=$_POST["datesr1"];
 $datepoi2=$_POST["datesr2"];
 $lieu=htmlentities($_POST["lieusr"],ENT_QUOTES);
 $sql="";
 if(!empty($titre))
     $sql=$sql."titre LIKE '%$titre%'";
 if(!empty($lieu)&&!empty($titre))
 	 $sql=$sql." OR lieu LIKE '%$lieu%'";
 elseif(!empty($lieu)&&empty($titre))
     $sql=$sql."lieu LIKE '%$lieu%'";
if(!empty($lieu)||!empty($titre))
{
 if(!empty($datepoi1)&&!empty($datepoi2))	
     $sql=$sql." OR (dateob>='$datepoi1' AND dateob<='$datepoi2')";
 if(empty($datepoi1)&&!empty($datepoi2))
	$sql=$sql." OR dateob>='$datepoi1'";
 if(!empty($datepoi1)&&empty($datepoi2)) 
    $sql=$sql." OR dateob<='$datepoi2'";
}elseif(empty($lieu)||empty($titre))
{
if(!empty($datepoi1)&&!empty($datepoi2))	
     $sql=" (dateob>='$datepoi1' AND dateob<='$datepoi2')";
 if(empty($datepoi1)&&!empty($datepoi2))
	$sql=" dateob>='$datepoi1'";
 if(!empty($datepoi1)&&empty($datepoi2)) 
    $sql=" dateob<='$datepoi2'";	
}
 
 $poi = $conn->query("SELECT  * FROM poi WHERE $sql");
                     // ." OR (dateob>='$datepoi1' AND dateob<='$datepoi2')");
	
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
			echo json_encode( $pois);
		}
		else
		{
			echo json_encode("ok");
		}
 }elseif($action=="del")
 {	
 $id=$_GET["id"];
 
 $poi = $conn->query("DELETE FROM poi WHERE ID=$id");
                     // ." OR (dateob>='$datepoi1' AND dateob<=$datepoi2)");
	

		if (!empty($pois))
		{
			echo json_encode( "true");
		}
		else
		{
			echo json_encode("false");
		}
 }elseif($action=="doc")
 {	
 $id=$_GET["id"];
 
 $file = $conn->query("SELECT * FROM fichiers WHERE idpoi=$id");
                     // ." OR (dateob>='$datepoi1' AND dateob<=$datepoi2)");
	

		$files = array();
        while ($usfile = $file->fetch()) {
            array_push($files,$usfile);
        }

		if (!empty($files))
		{
			echo json_encode( $files);
		}
		else
		{
			echo json_encode("false");
		}
 }elseif($action=="editfile")
 {
	 include("include/thumb.php");
	$idpoi=$_GET["idpoi"];
	$imgcount=$_POST["imgcount"];
    $othercount=$_POST["othercount"];
	$videocount=$_POST["videocount"];
	
	$hdvideo=$_POST["hdvideo"];
	$hdfile=$_POST["hdfile"];
	$hdimage=$_POST["hdimage"];
	
	$count="";
	//upload des fichiers
	$count=$_FILES["image3"]["name"];
	$i=1;
while($imgcount>=$i)
{
	if($hdimage>=1)
	{
		$hdimage--;
	}else
	{
		if(isset($_FILES["image".$i]["name"]))
		{
			
		$name=$_FILES["image".$i]["name"];
		$fileurl=upload($_FILES["image".$i]);
		$thumb="files/thumb".substr($fileurl,5);
		createthumb($fileurl,$thumb,50,50);
		$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url,thumb)VALUES(?,?,?,?,?)");
		$ins1 = $ins1Stmt->execute(array($idpoi,"image",$name,$fileurl,$thumb));
		}
	}
	$i++;
}
$i=1;

while($othercount>$i)
{
	if($hdfile>=1)
	{
		$hdfile--;
	}else
	{
		if(isset($_FILES["file".$i]["name"]))
		{
		  $name=$_FILES["file".$i]["name"];
		  $fileurl=upload($_FILES["file".$i]);
		  $ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url)VALUES(?,?,?,?)");
		  $ins1 = $ins1Stmt->execute(array($idpoi,"file",$name,$fileurl));
		}
	}
	$i++;
}
$i=0;

while($videocount>$i)
{
	if($hdvideo>=1)
	{
		$hdvideo--;
	}else
	{
		if(isset($_FILES["video".$i]["name"]))
		{
		$name=$_FILES["video".$i]["name"];
		$fileurl=upload($_FILES["video".$i]);
		$ins1Stmt= $conn->prepare("INSERT INTO fichiers (idpoi,type,name,url)VALUES(?,?,?,?)");
		$ins1 = $ins1Stmt->execute(array($idpoi,"video",$name,$fileurl));
		}
	}
	$i++;
}
	
	  echo json_encode($count);

 }elseif($action=="deletefile")
 {
	 $idfile=$_GET["idfile"];
	 $idpoi=$_GET["idpoi"];
	$ins1Stmt= $conn->prepare("DELETE FROM fichiers WHERE idfile=?");
	$ins1 = $ins1Stmt->execute(array($idfile)); 
	if($ins1)
	{
	header("Location: files.php?id=$idpoi");
	}
 }
 

		
?>