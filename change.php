<?php include("init.php");

$action = getArrayVal($_GET, "action");
$id =$_SESSION["userid"];
$mode = getArrayVal($_GET, "mode");

$profil=array();
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
   <link rel="stylesheet" href="css/bootstrapValidator.css"/>
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
   <!-- <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />-->
     <script src="js/jquery-1.11.1.min.js"></script>
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
                <li><a href="manageuser.php?action=profile">Profil</a></li>
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
       
            
<!--modification observation-->
<div id="edit"  tabindex="-1" data-width="400" style="width: 600px; margin:auto;" aria-hidden="true">
  <div class="modal-header">
    <h4 class="modal-title" id="obtitle">Changer votre mot de passe</h4>
  </div>
  <form name="profilfrm" id="profilfrm"   method="post" action="manageuser.php?action=change">
  <div class="modal-body">
  <div class="row">
  <?php
  if(isset($_GET['mode'])&&$_GET['mode']=="error")
  {
  ?>
  <div style="color:#F00; font-weight:bold">Mot de passe incorrecte</div>
  <?php
  }
  ?>
        <div class="form-group">      
        <label class="col-lg-4 control-label">Ancien mot de passe:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="password" id="oldpass" name="oldpass">
            </div>
        </div>
        
        <div class="form-group">      
        <label class="col-lg-4 control-label">Nouveau mot de passe:</label> 
           <div class="col-lg-6">
         <input type="password" name="newpass" id="newpass" class="form-control" />
            </div>
        </div>
        
         <div class="form-group">      
        <label class="col-lg-4 control-label">Confirmer le mot de passe:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="password" id="repeatpass" name="repeatpass" >
            </div>
        </div>
    </div>
    </div>  
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" id="close">Fermer</button>
    <button type="submit" class="btn btn-primary" id="save">Valider</button>
  </div>
  </form>
</div>

   </section>  
    <script src="js/bootstrap.min.js"></script>
    
 <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.min.js"></script>    
<script>

    $('#poifrm')
        .bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                newpass: {
                    validators: {
                        notEmpty: {
                            message: 'Ce champ ne doit pas &ecirc;tre vide'
                        },
						stringLength: {                        
                        min: 5,
                        message: '5 caract&egrave;res aux minimun sont autoris&eacute;s'
                      }
                    }
                },
                repeatpass: {
                    validators: {
                        notEmpty: {
                            message: 'Ce champ ne doit pas &ecirc;tre vide'
                        },
						numeric: {
                            message: 'Ce champ doit &ecirc;tre num&eacute;que',
                            // The default separators
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }
                    }
                }
               
				
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent submit form
          e.preventDefault();
          var postUrl='poi.php?action=insert';
		
		 
			$.post(postUrl,$('#poifrm').serialize(),function(data){
			
			},"json");
        });
</script>

</div>
</body>

</html>