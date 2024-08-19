<?php include("init.php");

$action = getArrayVal($_GET, "action");
$id =$_SESSION["userid"];
$mode = getArrayVal($_GET, "mode");
$user=new user();
$profil=array();
    if (!isset($_SESSION["userid"])) {
        
        header("Location: login.php?loginerror=0");
        die();
    }else{
	  if(isset($id))
	  {
		  $profil=$user->getProfile($id);
	  }
	}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Observations</title>
   <link rel="stylesheet" href="css/main.min.css">
    <link href="css/bootstrap.css" rel="stylesheet" />   
   <link href="css/Font-Awesome/css/font-awesome.css" rel="stylesheet">
   <style>
      html, body,#row{
        height: 100%;
		width:100%;
        margin: auto;
        padding: 0px
      }
	  </style>
    <script src="js/bootstrap.js"></script>

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
            <div style=" float:right;margin-top:-20px; margin-right:150px">
        
         <div class="btn-group user-dropdown" style="text-align:left">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu</a>
              <ul class="dropdown-menu">
               <?php if($_SESSION["userrole"]=="admin")
			  {?>
              <li><a href="users.php">Utilisateurs</a></li>
              <?php }?>
              <li><a href="dash.php">Point d'inter&ecirc;ts</a></li>
              <li><a href="profil.php?id=<?=$_SESSION["userid"]?>">Profil</a></li>
                <li><a href="change.php">Mot de passe</a></li>
                <li><a href="manageuser.php?action=logout">d&eacute;connexion</a></li>
              </ul>
                
              </div>
          </div>
          </div>          
        </nav><!-- /.navbar -->

      </div><!-- /#top -->
      
      <div id="wrap">
    <section id="form1" style="margin:auto; width:900px;">
        <div class="row">
       
          <div class="small-18 "  style="margin:auto; text-align:center;">
          <span class="small-18 title" style="font-weight:bold;color:#09F">Modifier votre profile</span>   
          </div>
       
            
<!--modification observation-->
<div id="edit"  tabindex="-1" data-width="400" style="width: 600px; margin:auto;" aria-hidden="true">
  <div class="modal-header">
    <h4 class="modal-title" id="obtitle"></h4>
  </div>
  <form name="profilfrm" id="profilfrm"   method="post" action="manageuser.php?action=profil&id=<?=$id?>">
  <div class="modal-body">
  <div class="row">
        <div class="form-group">      
        <label class="col-lg-4 control-label">Noms:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="name" name="name" value="<?=$profil["name"]?>">
            </div>
        </div>
        
        <div class="form-group">      
        <label class="col-lg-4 control-label">Email:</label> 
           <div class="col-lg-6">
         <input type="text" name="email" id="email" class="form-control" value="<?=$profil["email"]?>"/>
            </div>
        </div>
        
         <div class="form-group">      
        <label class="col-lg-4 control-label">Telephone:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="tel" name="tel" value="<?=$profil["tel"]?>">
            </div>
        </div>
        
        
         <div class="form-group">      
        <label class="col-lg-4 control-label">Genre:</label> 
           <div class="col-lg-6">
          <select name="genre" id="genre" class="form-control">
          
             <option value="M" "<?php if($profil["genre"]=="M") echo "selected";?>">Masculin</option>
             <option value="F" "<?php if($profil["genre"]=="F") echo "selected";?>">Feminin</option>
             </select>
            </div>
        </div>
        
        <div class="form-group">      
        <label class="col-lg-4 control-label">Societe:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="societe" name="societe"  value="<?=$profil["societe"]?>">
            </div>
        </div>
        
        <div class="form-group">      
        <label class="col-lg-4 control-label">Profession:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="prof" name="prof"  value="<?=$profil["prof"]?>">
            </div>
        </div>
        <div class="form-group">      
        <label class="col-lg-4 control-label">Ville:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="ville" name="ville" value="<?=$profil["ville"]?>">
            </div>
        </div>
             
            <input type="hidden"  name="role" id="role" value="<?=$profil["role"]?>"/>
            <input type="hidden"  name="iduser" id="iduser" value="<?=$profil["ID"]?>"/>
          
    </div>  
  </div>
  <div class="modal-footer">
    <a href="dash.php"  class="btn btn-default" >Fermer</a>
    <button type="submit" class="btn btn-primary" id="save">Valider</button>
  </div>
  </form>
</div>

   </section>  
	
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</div>
</body>

</html>