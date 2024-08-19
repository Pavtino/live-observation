<?php include("init.php");

$action = getArrayVal($_GET, "action");
$id = getArrayVal($_GET, "id");
$mode = getArrayVal($_GET, "mode");


    if (!isset($_SESSION["userid"])) {
        
        header("Location: login.php?loginerror=0");
        die();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Observations</title>
   
    <link rel="stylesheet" href="css/main.min.css">
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/jquery.bootgrid.css" rel="stylesheet" />
   <link href="css/Font-Awesome/css/font-awesome.css" rel="stylesheet">
   <link href="css/lightbox.css" rel="stylesheet">
   <style>
      html, body,#row{
        height: 100%;
		width:100%;
        margin: auto;
        padding: 0px
      }
	  </style>
      <script src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
    <script src="js/bootstrap.js"></script>
  <script>
   //suppression fichier
 function delfile(id){
		$.getJSON( "poi.php?action=deletefile&idfile="+id, function( data ) {
			location.reload();
			
	      });
     }
  </script>
</head>

<body>
<div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">

          <!-- Brand and toggle get grouped for better mobile display -->
          <header class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
            </button>
            <a href="#" class="navbar-brand">
             <img src="img/logo_ced.gif" alt="">
            </a> 
          </header>
          <div style="margin-left:200px;" >
          <div id="tspan"><span style="">OBSERVATOIRE DES CONVERSIONS DES TERRES FORESTIERES AU CAMEROUN</span>
          </div>
          <div style=" float:right;margin-top:-20px; margin-right:10px">
        
          <span style="">
         
         <a href="#" id="lkdec">Déconnexion</a> 
		  
		 
          </span>
          </div>
          </div>          
        </nav><!-- /.navbar -->

      </div><!-- /#top -->
      
      <div id="wrap">
    <section id="form1" style="margin:auto; width:900px;">
        <div class="row">
       
          <div class="small-18 "  style="margin:auto; text-align:center;">
          <span class="small-18 title" style="font-weight:bold;color:#09F">Panel d'administration des Observations</span>   
          </div>
        
<div id="views"  tabindex="-1" data-width="460" style=" width:460px; margin:auto; margin-top:100px;" aria-hidden="true">
 
   <form   name="frmupload" id="frmupload" enctype="multipart/form-data">
  
    <div class="row">
     <!-- <div class="col-md-12" id='ins'>-->
          <?php
		  
		  $files = $conn->query("SELECT * FROM fichiers WHERE  type='file' and idpoi=$id");
		  $images = $conn->query("SELECT * FROM fichiers WHERE type='image' and idpoi=$id");
		  $videos = $conn->query("SELECT * FROM fichiers WHERE type='video' and idpoi=$id");
		  $file =1;
		  $image=1;
		  $video=1;
        
		  if($images->rowCount()!=0)
		  {
			  while ($usfile = $images->fetch()) {
               	 if($image==1)
					 {
						 echo '<div class="row">
              <div class="col-lg-12">
                <div class="box">
				<header>
                    <h5>Gestion des images</h5>
                  </header>
				  <div  class="body">
                      <div id="imageGroup" >
	                   <div id="imageBoxDiv1">';
					 }
		  ?>
            
                  
                  
                  
        <div class="form-group">      
        <label class="control-label">
        <a href="<?=$usfile['url']?>" data-lightbox="roadtrip" style="margin-left:20px">
        <img src="<?=$usfile['thumb']?>" width="50" height="50"/></a></label> 
           <div class="col-lg-5">
         <a href="poi.php?action=deletefile&idfile=<?=$usfile['idfile']?>&idpoi=<?=$id?>"  class="btn btn-danger btsup" >Supprimer</a> 
            </div>
        </div>
         <?php
		  $image++;
			  }
		  
				echo '</div>
            </div>
	     </div>

       <input type="button" value="Ajouter" id="addimage" class="btn btn-success">
       <input type="button" value="Annuler" id="removeimage" class="btn btn-default">
	   </div>
     </div></div>';
		}else
		{
		$image=2;	
			?>
		<div class="row">
            <div class="col-lg-12">
               <div class="box">
				  <header>
                    <h5>Gestion des fichiers</h5>
                   </header>
				  <div  class="body">
                  <div id="imageGroup" >
                     <div id="imageBoxDiv1">
                      <div class="form-group">
                      <label>Image</label>
                      <input type="file" id="image1" accept="image/*" class="filestyle" data-filename-placement="inside" data-buttonText="Choisir l'image" data-input="false">
                      </div>
              </div>
            </div>
	     </div> 
       <input type="button" value="Ajouter" id="addimage" class="btn btn-success">
       <input type="button" value="Annuler" id="removeimage" class="btn btn-default">
     </div>
     </div>
     </div>


       <?php     
		}//end rowcount image
		 
		 if($files->rowCount()!=0)
		  {
			  while ($usfile = $files->fetch()) {
				   if($file==1)
					 {
						 echo '<div class="row">
              <div class="col-lg-12">
                <div class="box">
				<header>
                    <h5>Gestion des fichiers</h5>
                  </header>
				  <div  class="body">
                      <div id="fileGroup" >
	                   <div id="fileBoxDiv1">';
					 }
		  ?>
        <div class="form-group">      
        <a class="control-label">fichiers:<?=$usfile['name']?></a> 
           <div class="col-lg-5">
          <a href="poi.php?action=deletefile&idfile=<?=$usfile['idfile']?>&idpoi=<?=$id?>"  class="btn btn-danger btsup" >Supprimer</a>
            </div>
        </div>
         <?php
		 $file++;
		}
		 
			 echo '</div>
            </div>
	     </div>
        
       <input type="button" value="Ajouter" id="addfile" class="btn btn-success">
       <input type="button" value="Annuler" id="removefile" class="btn btn-default">
	   </div>
     </div></div>';
	 }else
	 {
		 $file=2;
		 ?>
         <div class="row">
            <div class="col-lg-12">
               <div class="box">
				  <header>
                    <h5>Gestion des fichiers</h5>
                   </header>
				  <div  class="body">
                    <div id='fileGroup' >
	                  <div id="fileBoxDiv1">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" id="file1"  class="filestyle" data-buttonText="Choisir le fichier" data-input="false" data-filename-placement="inside">
                        </div>
                      </div>
                    </div>
	               </div>
                   
                 <input type='button' value='Ajouter' id='addfile' class="btn btn-success">
                 <input type='button' value='Annuler' id='removefile' class="btn btn-default">
                </div><!-- box-->
            </div>
        </div>
     <?php
	 }
	 //video
        if($videos->rowCount()!=0)
		  {
			  while ($usfile = $videos->fetch()) {
				   if($video==1)
					 {
						 echo '<div class="row">
					  <div class="col-lg-12">
						 <div class="box">
							<header>
							  <h5>Gestion des fichiers</h5>
							 </header>
				             <div  class="body">
                                <div id="videoGroup" >
	                             <div id="videoBoxDiv1">';
					 }
		  ?>
        <div class="form-group">      
        <a class="control-label">fichiers:<?=$usfile['name']?><a> 
           <div class="col-lg-5">
          <a href="poi.php?action=deletefile&idfile=<?=$usfile['idfile']?>&idpoi=<?=$id?>"  class="btn btn-danger btsup" >Supprimer</a>
            </div>
        </div>
         <?php
		 $video++;
			 }
			 echo '</div>
            </div>
	     </div> 
       <input type="button" value="Ajouter" id="addvideo" class="btn btn-success">
       <input type="button" value="Annuler" id="removevideo" class="btn btn-default">
     </div>
	 </div>
	 </div>';
		 }else
		 {
		  $video=2;
		  ?>
          <div class="row">
            <div class="col-lg-12">
               <div class="box">
				  <header>
                    <h5>Gestion des videos</h5>
                   </header>
				  <div  class="body">
        <div id='videoGroup' >
	       <div id="videoBoxDiv1">
                <div class="form-group">
                <label>video</label>
                <input type="file" id="video1" accept="video/*" class="filestyle" data-buttonText="Choisir la video" data-input="false" data-filename-placement="inside">
                </div>
              </div>
            </div>
	     </div>
 
       <input type='button' value='Ajouter' id='addvideo' class="btn btn-success">
       <input type='button' value='Annuler' id='removevideo' class="btn btn-default">
        </div>
       </div>
     </div>
          <?php
		 }
		?>
      
      </div>
      </div>
   <div class="modal-footer">
   <a href="dash.php" class="btn btn-default">Annuler</a>
    <button type="button" class="btn btn-primary" id="save">Valider</button>
  </form>   
    </div>

    </div>
   </section>  
	
    <script src="js/lightbox.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.bootgrid.js"></script>
 
<!--succes-->
</div>
<script type="text/javascript">

$(function(){
    var image=<?=$image?>;
	var file=<?=$file?>;
	var video=<?=$video?>;
	var idpoi=<?=$id?>;
	var hdfile=file-1;
	var hdimage=image-1;
	var hdvideo=video-1;
	
    $("#addimage").click(function () {
	
	var newTextBoxDiv = $(document.createElement('div')).attr("id", 'imageBoxDiv' +image);                
	newTextBoxDiv.after().html('<label>Image'+ image + ' : </label>' +
	      '<input name="image' +image +'" id="image' +image + '" class="filestyle" type="file"  >');            
	newTextBoxDiv.appendTo("#imageGroup");			
	image++;
     });

     $("#removeimage").click(function () {
	if(image==1){   return false;}  
	//
	if(((hdimage+1)==image)&&(hdimage!=0))
	{
		hdimage--
	}
	   image--;			
        $("#imageBoxDiv" + image).remove();
			
     });
	 //add-remove file
	 $("#addfile").click(function () {
	
	var newTextBoxDiv = $(document.createElement('div')).attr("id", 'fileBoxDiv' + file);                
	newTextBoxDiv.after().html('<label>fichier'+ file + ' : </label>' +
	      '<input name="file' + file +'" id="file' + file + '" class="filestyle" type="file"  >');            
	newTextBoxDiv.appendTo("#fileGroup");			
	file++;
     });

     $("#removefile").click(function () {
	if(file==0){   return false;} 
	if((hdfile+1)==file&&!(hdfile!=0))
	{
		hdfile--;
	}          
	   file--;			
        $("#fileBoxDiv" + file).remove();
			
     });
	 //add-remove video
	 $("#addvideo").click(function () {
	
	var newTextBoxDiv = $(document.createElement('div')).attr("id", 'videoBoxDiv' + video);                
	newTextBoxDiv.after().html('<label>video'+ video + ' : </label>' +
	      '<input name="video' + video +'" id="video' + video + '" class="filestyle" type="file"  >');            
	newTextBoxDiv.appendTo("#videoGroup");			
	video++;
     });

     $("#removevideo").click(function () {
	if(video==1)   return false;    
	
	if((hdvideo+1)==video&&!(hdvideo!=0))
	{
		hdvideo--;
	}       
	   video--;			
        $("#videoBoxDiv" + video).remove();
			
     });
	 //test
	 $("#save").click(function(e){
		  e.preventDefault();
          var postUrl='poi.php?action=editfile&idpoi='+idpoi;
		
			
				//add files
				var formData = new FormData((document.forms.namedItem("frmupload")));
			
				 formData.append('imgcount',image);
				 formData.append('othercount',file);
				 formData.append('videocount',video);
				 //end add file
				
				 formData.append('hdfile',hdfile);
				 formData.append('hdimage',hdimage);
				 formData.append('hdvideo',hdvideo);
				 $.ajax({
					 url: postUrl,
					 success: function (e) {
					  window.location.href="files.php?id="+idpoi;
					 },
					 error: function (e) {
					   alert('error ' + e.message);
					 },
					 // Form data
					 data: formData,
					 type: 'POST',
					 //Options to tell jQuery not to process data or worry about content-type.
					 cache: false,
					 contentType: false,
					 processData: false
				  });
    
	 });
	
  });
</script>
</body>

</html>