<?php 
include("init.php");

$user = (object) new user();

$action = getArrayVal($_GET, "action");
$id = getArrayVal($_GET, "id");
$mode = getArrayVal($_GET, "mode");
/*if ($action != "login" and $action != "logout" and $action != "resetpassword" and $action != "loginerror") {
    if (!isset($_SESSION["userid"])) {     
        header("Location: login.php?loginerror=0");
        die();
    }
}*/
?>
<!DOCTYPE html>
<html lang="en" class=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>CED</title>

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#5bc0de">
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png">
   
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="css/main.min.css">
      <link href="css/bootstrap.css" rel="stylesheet">
<style>
  body { 
    padding-top: 40px; 
  }
</style>
  <!-- <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet" /> -->
  <link href="css/bootstrap-modal-bs3patch.css" rel="stylesheet">
  <link href="css/bootstrap-modal.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap_datepicker.css">
   <link href="css/Font-Awesome/css/font-awesome.css" rel="stylesheet">
<style>
      html, body, #gmaps-basic {
        height: 100%;
		width:100%;
        margin: auto;
        padding: 0px
      }
	 .contextmenu{
    visibility:hidden;
    background:#ffffff;
    border:1px solid #8888FF;
    z-index: 10;  
    position: relative;
    width: 140px;
}
.contextd{
    visibility:hidden;
}
</style>
    
  </head>
  <body>
      <div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">

          <!-- Brand and toggle get grouped for better mobile display -->
          <header class="navbar-header">
            
            <a href="#" class="navbar-brand">
             <img src="img/logo_ced.gif" alt="">
            </a> 
          </header>
          <div style="float:right; margin-right:300px;" >
          <div id="tspan"><span style="">OBSERVATOIRE DES CONVERSIONS DES TERRES FORESTIERES AU CAMEROUN</span>
          </div>
         
          </div>          
        </nav><!-- /.navbar -->

        <!-- header.head -->
       <!-- <header class="head">
   
         
        
                <!-- end header.head -->
      </div><!-- /#top -->
     
                 <!-- map-->
       
<!--login-->
<div id="login"  tabindex="-1" data-width="460" style=" width: 460px; margin:auto; margin-top:100px;" aria-hidden="true">
  <!--<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Login</h4>
  </div>-->
  <?php 
  if(isset($_GET["loginerror"])&& $_GET["loginerror"]==0)
   echo "<span ><h4 style='color:#F00'>Email ou mot de passe incorrect</h4></span>";
  ?>
  <form name="frmlogin" id="frmlogin"  action="manageuser.php?action=log" method="post">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-8">
        <h4 >Entrez vos identifiants</h4>
        <p><label>Email</label> : <input class="form-control" type="text" id="email" name="email"></p>
        <p><label>Mot de passe</label>:<input class="form-control" type="password" id="pass" name="pass"></p>
        <div id="result" style="color:#F00; display:none">Email ou mot de passe incorrecte</div>    
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" id="close">Annuler</button>
    <button type="submit" class="btn btn-primary" id="connect">Connexion</button>
  </div>
  </form>
</div>


<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/prettify.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap-modalmanager.js"></script>
<script src="lib/datepicker/js/bootstrap-datepicker.js"></script>
 
<script src="js/bootstrap-modal.js"></script>
<script>
	 $(function() 
{
});
	   </script>

                
             
  
   <!-- end minimize and maximize menu panel-->
    <script src="./js/main.min.js"></script>
    
  
</body></html>