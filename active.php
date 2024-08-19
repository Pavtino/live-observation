<?php 
include("init.php");

$action = getArrayVal($_GET, "action");
$uid = getArrayVal($_GET, "uid");
$mode = getArrayVal($_GET, "mode");

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
  <form name="frmlogin" id="frmlogin"  action="manageuser.php?action=active&uid=<?=$uid?>" method="post">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-8">
        <h4 >Entrez votre mot de passe pour activer votre compte</h4>
        <p><input class="form-control" type="password" id="pass" name="pass"></p>   
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary" id="connect">Connexion</button>
  </div>
  </form>
</div>

<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/prettify.js"></script>
<script src="js/bootstrap.js"></script>       
             
  
    
  
</body></html>