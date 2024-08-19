<?php 
include("init.php");

$user = (object) new user();

$action = getArrayVal($_GET, "action");
$id = getArrayVal($_GET, "id");
$mode = getArrayVal($_GET, "mode");

?>
<!DOCTYPE html>
<html lang="fr" class=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>PSOD</title>

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#5bc0de">
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png">
   
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="css/main.min.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrapValidator.css"/>
	<link href="css/bootstrap-modal-bs3patch.css" rel="stylesheet">
	<link href="css/bootstrap-modal.css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap_datepicker.css">
	<link href="css/Font-Awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/gdropdown.css">
    <link href="css/lightbox.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 	<link rel="stylesheet" type="text/css" href="./css/hiala.css">
	<link rel="stylesheet" type="text/css" href="./css/modal.css">
	
    <script>
	function test(id)
	{
		$.getJSON( "managepoi.php?action=mark&id="+id, function( data ) {
			//
			$('#nom-af').text(data.titre);
			$('#desc-af').text(data.description);
			$('#splat').text(data.lat);
			$('#splng').text(data.lng);	
			$('#img1').attr('src',data.photo1);
			$('#img2').attr('src',data.photo2);		
			
	});
	$('#views').modal();
	$('.contextmenu').attr('display','none');
	}
//modification
	 function edit(id){
		$.getJSON( "managepoi.php?action=mark&id="+id, function( data ) {
			//
			$('#titreed').val(data.titre);
			$('#desc').val(data.description);
			$('#lated').val(data.lat);
			$('#lnged').val(data.lng);
			$('#idata').val(data.ID);
			//$('#status').val(data.ID);	
			
			
	});
	$('#edit').modal();
	}
	 function delpoi(id){
		 $('#before').modal();
		 delid=id;     
		
	}
	 function delpoifinal(){
		 $.getJSON( "poi.php?action=del&id="+delid, function( data ) {
		window.location.reload();
	});
	function change_curseur() {
			document.getElementById("gmaps-basic").style.cursor = "crosshair";
		}
	}
    </script>
	
	
  </head>
  <body>
		<div id="top">
		  
			  <div id="logo">
				<a href="#" class="navbar-brand">
				 <img src="img/logo_ced.gif" alt="CED Centre pour l'Environnement et le Développement - Cameroun">
				</a> 
			  </div>

			  <div id="titre-plateforme">PLATEFORME DE SIGNALEMENT D'UNE OBSERVATION EN DIRECT</div>
			  <div id="bloc_ajout">
				
				<button type="button" class="btn btn-primary" id="poi">Nouvelle observation</button>
				
				<span style="">
				<!--<a href="#" id="lksearch">Rechercher</a>-->
				<?php if(!isset($_SESSION['userid'])) {?>
					<a href="#" id="lkconect">Connexion</a>
				</span>
				<?php } else
				{?>
				<div id="utilisateur-connecte">
				<!-- message de bienvenue -->
				<p id="bienvenue"> Bienvenue <?php echo $_SESSION['username']; ?></p>
				<a href="dash.php" target="_blank" id="">Gestion</a>&nbsp;<a href="#" id="lkdec">Déconnexion</a> 
				</div>  
				<?php
				}
				?>
				</span>
			  </div>

		</div><!-- /#top -->
     
		<!-- map-->
		
		<div id="gmaps-basic" ></div>
		
		<!-------------------- Légende -------------------->
		
		<div id="legend"><span style="font-size:12px; font-weight:bold">Légende</span>
			<div> <img src="img/orange.png" alt="non verifié"/> Observation non vérifiée</div>
			<div> <img src="img/red.png" alt="verifié"/> Observation vérifiée</div>
			<div> <img src="img/green.png" alt="Sanctionné"/> Observation sanctionnée</div>
        </div> 
        
		<!-------------------- Type de points à afficher -------------------->
		
        <select name="mkchange" id="mkchange"  class="form-control" style="width:120px">
			<option value="0">Tout afficher</option>
			<option value="1">Non vérifié</option>
            <option value="2">vérifié</option>
            <option value="3">Sanctionné</option>
        </select>        

					
		<div id="observation" class="modal fade" tabindex="-1" data-width="600" style="display: none; width: 600px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
		<!-- Le div observation est à ne surtout pas fermer -->
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="obtitle">Ajout d'une observation : Observateur anonyme</h4>
			</div>
  
			<div class="modal-body">
				<form name="poifrm" id="poifrm"  enctype="multipart/form-data" method="post" action="poi.php">		
				
					<div class="row">
						<div class="col-md-12">
							<p class="form-group"> * Champ requis </p>
							
							<p class="form-group"> <label>Titre : </label> <input class="form-control" type="text" id="titre" name="titre"/> </p>
							
							<p class="form-group"> <label>Description (500 mots environ) : * </label> <textarea name="desc" id="desc" /> </textarea> <p>
							
							<p class="form-group"> <label>Latitude : * </label> <input class="form-control" type="text" id="lat" name="lat" /> <p>
							
							<p class="form-group"> <label>Longitude : * </label> <input class="form-control" type="text" id="lng" name="long" /></p>
							
							<p class="form-group"> <label>P&eacute;riode : * </label> <input class="form-control" type="text" id="dateob" name="dateob" data-date-format="yyyy-mm-dd" /> </p>
							
							<p class="form-group"> <label>Département : * </label> <input class="form-control" type="text" id="dep" name="dep" /> </p>
							
							<p class="form-group"> <label>Arrondissement : * </label> <input class="form-control" type="text" id="ard" name="ard" /> </p>
							
							<p class="form-group"> <label>ville ou village : * </label> <input class="form-control" type="text" id="lieu" name="lieu" /> </p>
							
							<p class="form-group"> <label>Images : * </label> <input name="images[]" id="images" class="file" data-input="false" data-filename-placement="inside" type="file" accept="image/*" multiple /> </p>  
							
							<p class="form-group"> <label>Videos : * </label> <input name="videos[]" id="videos" class="file" data-input="false" data-filename-placement="inside" type="file" accept="video/*" multiple /> </p>  
							
							<p class="form-group"> <label>Fichiers : * </label> <input name="files[]" id="files" class="file" data-input="false" data-filename-placement="inside" type="file"   multiple /> </p>      
						</div>				
					</div>
						
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-default" id="close">Fermer</button>
						<button type="submit" class="btn btn-primary" id="addpoi">Enregistrer</button>
					</div>
				</form>
			</div>


			<!--progress bar-->
			<div id="prog" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
			  <div class="modal-header">
				<h4 class="modal-title">Chargement</h4>
			  </div>
			  <div class="modal-body">
				<div class="row">
				  <div class="col-md-12">
					<h4>Veuillez patienter...?</h4>
					  <div id="progressbar"></div>
				  </div>     
				</div>
			  </div>
			</div>

		<!--login-->
		<div id="login" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">Connexion</h4>
		  </div>
		  <form name="frmlogin" id="frmlogin"  >
		  <div class="modal-body">
			<div class="row">
			  <div class="col-md-12">
				<div id="result" ></div> 
				<p><label>Email</label> : <input class="form-control" type="text" id="email" name="email"></p>
				<p><label>Mot de passe</label>:<input class="form-control" type="password" id="pass" name="pass"></p>
				<br/>
			<p><a id="lkreset" href="#">Mot de passe oublié ?</a>&nbsp;|&nbsp;<a id="lksub" href="#">Inscription</a></p>   
			  </div>     
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-default" id="close">Annuler</button>
			<button type="button" class="btn btn-primary" id="connect">Connexion</button>
		  </div>
		  </form>
		</div>
       <!--reset-->
       
       <div id="reset" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">Récupération du mot de passe</h4>
		  </div>
		  <form name="resetfrm" id="resetfrm"  >
		  <div class="modal-body">
			<div class="row">
   <div class="col-md-12">
	
            <p><label>Email</label> : <input class="form-control" type="text" id="email" name="email"></p>   
          </div>
    </div>
  </div>
		  <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-default" id="closereset">Annuler</button>
			<button type="button" class="btn btn-primary" id="savereset">Envoyer</button>
		  </div>
		  </form>
		</div>
        
           <div id="reseterror" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">R&eacute;initialisation du mot de passe</h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
		<div class="col-md-12">
			<div  id="resetmsg">Un mail vous a &eacute;t&eacute; envoy&eacute; avec votre nouveau mot de passe</div>            
          </div>
    </div>
  </div>
		  <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-default" id="closereseter">Fermer</button>
		  </div>
		</div>
   <!--     fin reinitialisation-->
   
		<!--inscription-->
		<div id="sub" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Inscription</h4>
			</div>
			
			<form name="frmsub" id="frmsub"  >
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">

							<p> * Champ requis </p>	
							
							<p class="form-group"> <label>Pseudo : *</label> <input class="form-control" type="text" id="namein" name="namein" /> </p>	
							
							<p class="form-group"> <label>Email : *</label> <input class="form-control" type="text" id="emailin" name="emailin" /> </p>
							
							<p class="form-group"> <label>Telephone : *</label> <input class="form-control" type="text" id="telin" name="telin" /> </p>
							
							<p class="form-group"> <label>Mot de passe : *</label> <input class="form-control" type="password" id="passin" name="passin" /> </p>
							
							<p class="form-group"> <label>Confirmer le mot de passe : *</label> <input class="form-control" type="password" id="cpassin" name="cpassin" /> </p>
							
							<p class="form-group"> <label>Ville : *</label> <input class="form-control" type="text" id="villein" name="villein" /> </p>
							
							<p class="form-group"> <label>Profession : *</label> <input class="form-control" type="text" id="profin" name="profin" /> </p>
							
							<p class="form-group"> <label>Structure / Organisation :</label> <input class="form-control" type="text" id="societein" name="societein" /> </p>
								
						</div>
					</div>
				</div>
					
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default" id="anbtn">Annuler</button>
					<button type="submit" class="btn btn-primary" id="btnsub">Valider</button>
				</div>
			</form>

		<!--fin inscription-->
		
		
<!--identification oui/non-->

<div id="ouinon" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Identification</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <p>Voulez-vous vous identifier?</p>
          
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" id="non">NON</button>
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="oui">OUI</button>
  </div>
</div>


<!--avant selection observation-->
<div id="before" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Ajout d'une observation</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <p>Cliquez sur la carte &agrave; l’endroit où est situ&eacute; l’observation</p>
          
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" onclick="change-curseur()" id="nonb">OK</button>
  </div>
</div>


<!--/*deconnexion*/-->
<div id="deconnexion" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Déconnexion</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <p>Voulez-vous vous déconnecter?</p>
          
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" id="logno">NON</button>
    <button type="button" data-dismiss="modal" class="btn btn-default" id="logyes">OUI</button>
  </div>
</div>


<!--affichage-->
<div id="views" class="modal fade" tabindex="-1" data-width="600" style="display: none; width: 600px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="obtitle">Observation anonyme</h4>
  </div>
   <form >
  <div class="modal-body" style="width:600px">
    <div class="row">
      <div class="col-md-8">
        <p>Nom : <div id="nom-af"></div></p>
        <p><label>Description</label>:<div id="desc-af"></div></p>
        <p>Latitude: <span id="splat"></span></p>
        <p>Longitude: <span id="splng"></span></p>
        <p><img src="" id="img1" class="img-responsive img-rounded img-thumbnail" style="width:170px;">  
       <img src="" id="img2" class="img-responsive img-rounded img-thumbnail" style="width:170px;"></p>  
      </div> 
      </div>
      </div>
   <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="close">Fermer</button>
  </div> 
  </form>   
</div>
  
  <!--modification observation-->
<div id="edit" class="modal fade" tabindex="-1" data-width="400" style="display: none; width: 600px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="obtitle">Observateur anonyme</h4>
  </div>
  <form name="editpoi" id="editpoi"  enctype="multipart/form-data" method="post" action="poi.php">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-8">
        <p><label>Titre</label> : <input class="form-control" type="text" id="titreed" name="titreed"></p>
        <p><label>Description</label>:</p>
        <p><textarea rows="4" cols="25" name="desc" id="desc"></textarea></p>
        <p><label>Latitude</label>:<input class="form-control" type="text" id="lated" name="lated">
        <label>Longitude</label>:<input class="form-control" type="text" id="lnged" name="longed"></p>  
        <p><label>P&eacute;riode d&rsquo;observation</label>:<input class="form-control" type="text" id="dateed" name="dateed"></p>
        <p><label>Lieu d&rsquo;observation</label>:<input class="form-control" type="text" id="lieued" name="lieued"></p>
         <p>Images:<input name="images[]" id="images" class="file" type="file" accept="image/*" multiple></p>
        <p>videos:<input name="videos[]" id="videos" class="file" type="file" accept="video/*" multiple></p>
        <p>fichiers:<input name="files[]" id="files" class="file" type="file"   multiple></p> 
         
        <p><select name="status" id="status">
        <option value="0" selected>Choisir</option>
        <option value="1">Valider</option>
        <option value="2">Sanctionner</option>
        </select></p>
        <input class="form-control" type="hidden" id="idata" name="idata">   
        <p><!--<label>Photo 2</label>:<input class="form-control" type="file" id="photo2" name="photo2">--></p>  
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" id="close">Fermer</button>
    <button type="button" class="btn btn-primary" id="save">Valider</button>
  </div>
  </form>
</div>
<!--end modification-->

 <!--Recherche -->
<div id="searchdiv" class="modal fade" tabindex="-1" data-width="400" style="display: none; width: 600px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="obtitle">Rechercher une Observation</h4>
  </div>
  <form name="frmsearch" id="frmsearch"  enctype="multipart/form-data" method="post" >
  <div class="modal-body">
    <div class="row">
      <div class="col-md-8">
        <p><label>Titre</label> :<input type="text" name="titresr" id="titresr" class="form-control" ></p>
        <p><label>Lieu</label>:</p>
        <p><input type="text" name="lieusr" id="lieusr" class="form-control"></p>
        <p><label>De</label>:<input type="text" data-date-format="dd/mm/yy" name="datesr1" id="datesr1" class="form-control">
        <label>A</label>:<input type="text" value="" data-date-format="dd/mm/yy"  name="datesr2" id="datesr2" class="form-control" ></p>  
         
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <input type="submit" class="btn btn-primary" name="searchbt" id="searchbt" value="Rechercher">
  </div>
  </form>
</div>

<!--end modification-->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="js/jquery-1.11.1.min.js"></script>
 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="js/lightbox.min.js"></script>
 <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.min.js"></script> 
<script type="text/javascript" src="js/prettify.js"></script>  
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap-modalmanager.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="lib/datepicker/js/bootstrap-datepicker.js"></script>

 <script type="text/javascript">
        $(function() {
            $('#datesr1').datepicker();
			$('#datesr2').datepicker();
			$('#dateed').datepicker();
			$('#dateob').datepicker();
			
        });
    </script>

<script src="js/bootstrap-modal.js"></script>
<script>
	 $(function() 
{
	$('#lksub').click(function(){
	$('#login').modal('hide');	
	$('#sub').modal();
});
$('#lksub1').click(function(){
	$('#login').modal('hide');	
	$('#sub').modal();
});
function initialize() {
		
    var myCenter=new google.maps.LatLng(5.112792710924348,12.67822265625);
	<?php if(!isset($_SESSION['userid']))
	{
       echo "var valfunct=0;";
	   echo "var userAuth=false;";
	}else
	{
		echo "var valfunct=0;";
		echo "var userAuth=true;";
		
	}?>
	var osmMapType = new google.maps.ImageMapType({
					getTileUrl: function (coord, zoom) {
						return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
					},
					tileSize: new google.maps.Size(256, 256),
					isPng: true,alt: "OpenStreetMap",name: "OSM",maxZoom: 19});
    var markers=[];
	var markersV=[];
	var markersNV=[];
	var markersS=[];
	var markSr=[];
	var next = 1;
	var lkconnect=false;
	//var marker=null;
	var index=0;
    var mapProp = {
        center:myCenter,
        zoom:7,
        mapTypeId:google.maps.MapTypeId.ROADMAP,
		mapTypeControl: true,
		  mapTypeControlOptions: {
			mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID,google.maps.MapTypeId.TERRAIN],
			// mapTypeIds: ['OSM', google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID,google.maps.MapTypeId.TERRAIN],
			// la ligne du dessus a été transformée pour annuler l'affichage du type de carte OSM (OpenStreetMap)
	      	//style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, // pour que ça affiche sans dérouler, les types de carte
			// position:google.maps.ControlPosition.TOP_RIGHT // masqué afin de laisser le zoom comme initialement prévu par google
	       },
		 zoomControl: true,
    zoomControlOptions: {
       // position: google.maps.ControlPosition.TOP_LEFT, // masqué afin de laisser le zoom comme initialement prévu par google
       }
     };

    var map=new google.maps.Map(document.getElementById("gmaps-basic"),mapProp);
	map.mapTypes.set('OSM', osmMapType);
	map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(document.getElementById('legend'));
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(document.getElementById('mkchange'));
	
	//map click
 google.maps.event.addListener(map, 'click', function(event) {	
		if(valfunct==1)
		   {
			 placePoi(event,map);
			 valfunct=0;  
		   }
		    $('.contextmenu').remove();
		  
   
});
//utilisateur identifié
 if( userAuth)
$("#obtitle").html("Ajout d'une observation : Observateur identifi&eacute;");
//marker rigth click
function setRightClick(marker,map)
		{
		google.maps.event.addListener(marker, 'rightclick', function(event) {			
		showContextMenu(event.latLng);
		ctmenuclick=1;
        });
		}
//contextual menu

//select layer
$("#mkchange").change(function(e){
	e.preventDefault();
	if($("#mkchange").val()==0)
	{
		setAllMap(markersS,null);
		setAllMap(markersV,null);
		setAllMap(markers,map);
		setAllMap(markersNV,null);
	}else if($("#mkchange").val()==1)
	{
		setAllMap(markersS,null);
		setAllMap(markersV,null);
		setAllMap(markers,null);
		setAllMap(markersNV,map);
	}else if($("#mkchange").val()==2)
	{
		setAllMap(markersS,null);
		setAllMap(markersV,map);
		setAllMap(markers,null);
		setAllMap(markersNV,null);
	}else if($("#mkchange").val()==3)
	{
		setAllMap(markersS,map);
		setAllMap(markersV,null);
		setAllMap(markers,null);
		setAllMap(markersNV,null);
	}
});
//search result
$('#lksearch').click(function(){
	$('#searchdiv').modal();
	});
$("#searchbt").click(function(e){
		 e.preventDefault();					
			var postUrl='poi.php?action=search';
			$.post(postUrl,$('#frmsearch').serialize(),function(data){
			var indexsr=0;	
			
			setAllMap(markersS,null);
		    setAllMap(markersV,null);
		    setAllMap(markers,null);
		    setAllMap(markersNV,null);			
			setAllMap(markSr,null);
			markSr=[];
		$.each( data, function( key, val ) {	
		var marker= new google.maps.Marker({position:new google.maps.LatLng(val.lat,val.lng),map: map,icon:val.img});
		
	    markSr.push(marker);
		//click droit
		/*if(userAuth)
		  {
	google.maps.event.addListener(marker, 'rightclick', function(event) {showContextMenu(event.latLng,val.ID);});	
		  }*/
		  var infowindow = new google.maps.InfoWindow({ content: InfoW(val)  });
	     google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker);
		                                              $('.contextmenu').remove();});

	 });//end each
	setAllMap(markSr,map);
	$('#searchdiv').modal('hide');
			},"json")
			.fail(function(xhr,err){
				var responseTitle= $(xhr.responseText).filter('title').get(0);
				//replace this code with modal window
				alert($(responseTitle).text() + "\n" + formatErrorMessage(xhr, err) ); 
			});
	
});
  //load map
loadPoi(map);
$("#oui").click(function(){
	  $('#ouinon').modal('hide');
	  $('#login').modal();
	});
	$("#non").click(function(){
		valfunct=1;
		$("#gmaps-basic").css("cursor", "progress");
		$('#before').modal();
	});
	$("#nonb").click(function(){ // on gère le changement de la forme de la souris pour ajouter une observation
		//map.setOptions({draggableCursor:'crosshair'});
	});
//click nouvelle observation
$("#poi").click(function(){
	//if connected
	if(userAuth!=true)
	{
	  if(valfunct!=1)
	  {	$('#ouinon').modal();
	  }
	  else
	   valfunct=0;
	}else
	{
		valfunct=1;
		$('#before').modal();
	}
	
	});
	//logout
$("#logout").click(function(){
	$('#deconnexion').modal();
	});
//click lien deconnexion
$("#lkdec").click(function(){
	$('#deconnexion').modal();
	});
$("#logyes").click(function(e){
	 e.preventDefault();					
			var geturl='manageuser.php?action=jsonout';
			$.getJSON(geturl, function( data ) {
				
					 location.reload();
			})
	});
//reinitialisation du mot de passe 
$('#lkreset').click(function(){
	$('#login').modal('hide');
	$('#reset').modal();
});
$('#savereset').click(function(e){
	e.preventDefault();					
			var postUrl='manageuser.php?action=reset';
			$.post(postUrl,$('#resetfrm').serialize(),function(data){
				
				if(data)
				 {
					$('#resetmsg').html("<p style='color:#3D9C64'>Un mail vous a &eacute;t&eacute; envoy&eacute; avec votre nouveau mot de passe</p>");		
	               $('#reset').modal('hide');
				   
	                $('#reseterror').modal();
					
				 }else
				 {
					 
					 $('#resetmsg').html("<p style='color:#F00'>Cette adresse e-mail est  incorrecte ou n'existe pas dans la base de donn&eacute;es</p>");
					 $('#reseterror').modal();				 
					 
				 }
				
			},"json")
});
//gestion
$('#lkconect').click(function(){
	        $('#login').modal();
             });
			$('#connect').click(function(e){
	 e.preventDefault();					
			var postUrl='manageuser.php?action=login';
			$.post(postUrl,$('#frmlogin').serialize(),function(data){
				
				if(!data)
				 {
					$('#result').html("<p style='color:#F00'>Email ou mot de passe incorrect</p>"); 				
				 }else
				 {
					 $('#login').modal('hide');
					   location.reload();		 					 
				 }
				
			},"json")
			.fail(function(xhr,err){
				var responseTitle= $(xhr.responseText).filter('title').get(0);
				//replace this code with modal window
				alert($(responseTitle).text() + "\n" + formatErrorMessage(xhr, err) ); 
				//$('#missing').children('#sp1').text('Set Missing');
			});
});
function placePoi(location,map) {
	
	$('#lat').val(location.latLng.lat());
	$('#lng').val(location.latLng.lng());
	$('#observation').modal();
	map.setOptions({draggableCursor:'default'});
}
//
//set all markers
function setAllMap(marki,map) {
  for (var i = 0; i < marki.length; i++) {
    marki[i].setMap(map);
  }
}
//infowindow function
function InfoW(data)
{
	var contentStr="";
	var video=true;
	var file=true;
	var sanct="";
	if(data.status==2)
		sanct='<p><a href="">cliquez ici pour plus d\'informations</a></p>';
   contentStr='<div id="views" style="width:400px">'+  
    '<div style="200px"><p><label>Titre :</label>' + data.titre+'</p>'+
        '<p><label>Description:</label>' + data.description+'</p>'+
		'<p><label>Departement:</label> <span id="splat">'+data.dep+'</span></p>'+
		'<p><label>Arrondissement:</label> <span id="splat">'+data.ard+'</span></p>'+
		'<p><label>Ville ou Village:</label> <span id="splat">'+data.lieu+'</span></p>'+
        '<p><label>Latitude:</label> <span id="splat">'+data.lat+'</span></p>'+
       ' <p><label>Longitude:</label> <span id="splng">'+data.lng+'</span></p></div><div id="photo" style=" width:400px">'+
	    sanct+'<p><strong>images:</strong></p><p>';
		
		//add files
         $.each( data.files, function( key, value ) {
			 if(value.type=="image")
				{
	         contentStr=contentStr+'<a href="'+value.url+'" data-lightbox="roadtrip" style="margin:2px"><img src="'+
				  value.thumb+'" width="50" height="50"/></a>';
				}
				else if(value.type=="file")
				{
					if(file)
					{contentStr=contentStr+'</p><p><strong>Fichiers:</strong>';
					 file=false;
					 video=true;
					}
					contentStr=contentStr+'</p><p><a href="'+value.url+'" >'+value.name+'</a>';
				}else if(value.type=="video")
				{
					
					if(video)
					{contentStr=contentStr+'</p><p><strong>Videos:</strong>';
					 video=false;
					 file=true;
					}
					contentStr=contentStr+'</p><p><a href="'+value.url+'" >'+value.name+'</a>';
				}
				
	      });
	
     contentStr=contentStr+'</p></div></div>';
	
  return contentStr;
}
//load markers
function loadPoi(map) {
	
	$.getJSON( "managepoi.php?action=view", function( data ) {
			//
			var indexnv=0;
			var indexv=0;
			var indexs=0;			
	$.each( data, function( key, val ) {	
	
		var marker= new google.maps.Marker({position:new google.maps.LatLng(val.lat,val.lng),map: map,icon:val.img});
	    markers.push(marker);
		//click droit
		
		/* if(userAuth)
		  {
	google.maps.event.addListener(markers[index], 'rightclick', function(event) {showContextMenu(event.latLng,val.ID);
        });		
		  }*/
		  //info window
     var infowindow = new google.maps.InfoWindow({ content: InfoW(val)  });
	 google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker);});
	 //event for zooming
	 google.maps.event.addListener(map, 'zoom_changed', function() {

    var pixelSizeAtZoom0 = 8; //the size of the icon at zoom level 0
    var maxPixelSize = 660//350; //restricts the maximum size of the icon, otherwise the browser will choke at higher zoom levels trying to scale an image to millions of pixels
    var zoom = map.getZoom();
    var relativePixelSize = Math.round(pixelSizeAtZoom0*Math.pow(2,zoom)); // use 2 to the power of current zoom to calculate relative pixel size.  Base of exponent is 2 because relative size should double every time you zoom in

    if(relativePixelSize > maxPixelSize) //restrict the maximum size of the icon
        relativePixelSize = maxPixelSize;
    //change the size of the icon
    marker.setIcon(new google.maps.MarkerImage(
            marker.getIcon().url,null,null,null,new google.maps.Size(relativePixelSize, relativePixelSize)));        
});
   
		index++;
		
	 });//end each
	 //not verified
	 $.each( data, function( key, val ) {	
	 if(val.status==0)
	 {
		var marker= new google.maps.Marker({position:new google.maps.LatLng(val.lat,val.lng),map: map,icon:val.img});
	    markersNV.push(marker);
		/*click droit
		 if(userAuth)
		  {
	google.maps.event.addListener(markersNV[indexnv], 'rightclick', function(event) {showContextMenu(event.latLng,val.ID);
        });	
		  }*/
		  //info window
     var infowindow = new google.maps.InfoWindow({ content: InfoW(val)  });
	 google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker);});
 
		indexnv++;
	 }		
	 });//end each
	//verified
	 $.each( data, function( key, val ) {	
	 if(val.status==1)
	 {
		var marker= new google.maps.Marker({position:new google.maps.LatLng(val.lat,val.lng),map: map,icon:val.img});
	    markersV.push(marker);
		/*click droit
		 if(userAuth)
		  {
	google.maps.event.addListener(markersV[indexv], 'rightclick', function(event) {showContextMenu(event.latLng,val.ID);
        });	
		  }*/
		  //info window
     var infowindow = new google.maps.InfoWindow({ content: InfoW(val)  });
	 google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker);});

		indexv++;
	 }		
	 });//end each
	 //censured
	  $.each( data, function( key, val ) {	
	 if(val.status==2)
	 {
		var marker= new google.maps.Marker({position:new google.maps.LatLng(val.lat,val.lng),map: map,icon:val.img});
	    markersS.push(marker);
		/* if(userAuth)
		  {
	google.maps.event.addListener(markersS[indexs], 'rightclick', function(event) {showContextMenu(event.latLng,val.ID);
        });	
		  }*/
		//info window
     var infowindow = new google.maps.InfoWindow({ content: InfoW(val)  });
	 google.maps.event.addListener(marker, 'click', function() { infowindow.open(map,marker);});
		     	
		indexs++;
	 }		
	 });//end each
	});//end json
}
//context menu
function getCanvasXY(caurrentLatLng){
      var scale = Math.pow(2, map.getZoom());
     var nw = new google.maps.LatLng(
         map.getBounds().getNorthEast().lat(),
         map.getBounds().getSouthWest().lng()
     );
     var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
     var worldCoordinate = map.getProjection().fromLatLngToPoint(caurrentLatLng);
     var caurrentLatLngOffset = new google.maps.Point(
         Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
         Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
     );
     return caurrentLatLngOffset;
  }
  function setMenuXY(caurrentLatLng){
    var mapWidth = $('#gmaps-basic').width();
    var mapHeight = $('#gmaps-basic').height();
    var menuWidth = $('.contextmenu').width();
    var menuHeight = $('.contextmenu').height();
    var clickedPosition = getCanvasXY(caurrentLatLng);
    var x = clickedPosition.x ;
    var y = clickedPosition.y ;

     if((mapWidth - x ) < menuWidth)
         x = x - menuWidth;
    if((mapHeight - y ) < menuHeight)
        y = y - menuHeight;

    $('.contextmenu').css('left',x  );
    $('.contextmenu').css('top',y );
    };
  function showContextMenu(caurrentLatLng,id  ) {
        var projection;
        var contextmenuDir;
        projection = map.getProjection() ;
        $('.contextmenu').remove();
            contextmenuDir = document.createElement("div");
          contextmenuDir.className  = 'contextmenu';
		  if(userAuth)
		  {
          contextmenuDir.innerHTML = "<a  class='lkview' id='edit"+id+"' href=\"javascript:edit("+id+")\">Modifier l&rsquo;observation </a>";
		  }
		 
        $(map.getDiv()).append(contextmenuDir);
 
        setMenuXY(caurrentLatLng);

        contextmenuDir.style.visibility = "visible";
       }
/*end context menu;*/
//insert poi
$('#dateob').on('changeDate',function(e) {
			e.preventDefault();
            $('#poifrm').data('bootstrapValidator').revalidateField('dateob');
        });
    $('#poifrm')
        .bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                titre: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
                lat: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
						numeric: {
                            message: 'Ce champ doit &ecirc;tre num&eacute;que',
                            // The default separators
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }
                    }
                },
               long: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
						numeric: {
                            message: 'Ce champ doit &ecirc;tre num&eacute;que',
                            // The default separators
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }
                    }
                },
                dep: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
				ard: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
				lieu: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
				dateob: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
						date: {
                        format: 'YYYY-MM-DD',
                        message: 'Date non valide'
                    }
                    }
                },
				desc: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
						stringLength: {                        
                        max: 2500,
                        message: 'Vous avez dépassé le nombre de mots autorisé.'
                      }
                    }
                }/*,
				images:{
				validators: {
                    file: {
                        maxSize: 4*1024 * 1024,
                        message: 'aucun fichier ne doit dépasser 4M'
                          }
                    }
				 },
				 files:{
				validators: {
                    file: {
                        maxSize: 4*1024 * 1024,
                        message: 'aucun fichier ne doit dépasser 4M'
                          }
                    }
				 },
				 videos:{
				validators: {
                    file: {
                        maxSize: 4*1024 * 1024,
                        message: 'aucun fichier ne doit dépasser 4M'
                          }
                    }
				 }*/
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent submit form
            e.preventDefault();
          var postUrl='poi.php?action=insert';
		$('#observation').modal('hide');
		$('#prog').modal();
		 
			$.post(postUrl,$('#poifrm').serialize(),function(data){
				//
				// position of marker change
             $( "#progressbar" ).progressbar({value: 25});
            var marker = new google.maps.Marker({position: new google.maps.LatLng($('#lat').val(),$('#lng').val()),map: map,icon:"img/orange.png"}); 
			  // google.maps.event.addListener(marker, 'rightclick', function(event) {showContextMenu(event.latLng);});
			 
				
				//add files
				var formData = new FormData();
				for (var i = 0; i < $('#images').get(0).files.length; i++) {				
				formData.append('image'+i,$('#images').get(0).files[i]);
				
			     }
				 formData.append('imgcount',$('#images').get(0).files.length);
				 
				//files
				for (var j = 0; j < $('#files').get(0).files.length; j++) {				
				formData.append('file'+j,$('#files').get(0).files[j]);
				
			     }
				 formData.append('othercount',$('#files').get(0).files.length);
				
				 //videos
				for (var k = 0; k < $('#videos').get(0).files.length; k++) {				
				formData.append('video'+j,$('#videos').get(0).files[k]);
				
			     }
				 formData.append('videocount',$('#videos').get(0).files.length);
				 //end add file
				 $( "#progressbar" ).progressbar({value: 50});
				 $.ajax({
					 url: 'poi.php?action=file&idpoi='+data,
					 success: function (e) {
					   $( "#progressbar" ).progressbar({value: 100});
					   $('#lat').val('');
	                   $('#lng').val('');
		               $('#titre').val('');
					   $('#dateob').val('');
					   $('#desc').val('');
					   $('#dep').val('');
					   $('#ard').val('');
				       $('#lieu').val('');
					   $('#prog').modal('hide');
					   $( "#progressbar" ).progressbar({value: 0});
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
    
			},"json");
        });
		$( "#progressbar" ).progressbar({value: 0});
//edit poi
$("#save").click(function(e){
	 e.preventDefault();					
			var postUrl='poi.php?action=edit';
			$.post(postUrl,$('#editpoi').serialize(),function(data){
				$('#edit').modal('hide');
				// position of marker change

				$('#lated').val('');
	            $('#lnged').val('');
		        $('#titreed').val('');
				
				
				 //add files
				var formData = new FormData();
				for (var i = 0; i < $('#imagesd').get(0).files.length; i++) {				
				formData.append('image'+i,$('#imagesd').get(0).files[i]);
				
			     }
				 formData.append('imgcount',$('#imagesd').get(0).files.length);
				//files
				for (var j = 0; j < $('#filesd').get(0).files.length; j++) {				
				formData.append('file'+j,$('#filesd').get(0).files[j]);
				
			     }
				 formData.append('othercount',$('#files').get(0).files.length);
				 //videos
				for (var k = 0; k < $('#videosd').get(0).files.length; k++) {				
				formData.append('video'+j,$('#videosd').get(0).files[k]);
				
			     }
				 formData.append('videocount',$('#videosd').get(0).files.length);
				 //end add file
				 
				 $.ajax({
					 url: 'poi.php?action=file&idpoi='+data,
					 success: function (e) {
					   alert('Upload completed');
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
    
			},"json");
});
 }
 //inscription

    $('#frmsub')
        .bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                namein: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
                emailin: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Adresse email invalide'
                        }
                    }
                },
               passin: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
                cpassin: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
				villein: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
				profin: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                }/*,
				dateob: {
                    validators: {
                        notEmpty: {
                            message: 'Ce champ ne doit pas &ecirc;tre vide'
                        },
						date: {
                        format: 'YYYY-MM-DD',
                        message: 'The value is not a valid date'
                            }
                    }
                }*/
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent submit form
            e.preventDefault();
        	var postUrl='manageuser.php?action=add';
			$.post(postUrl,$('#frmsub').serialize(),function(data){
				
				if(data=="false")
				 {
					$('#result').show(); 
					
				 }else
				 {
					
					 $('#sub').modal('hide');	
					 $('#login').modal();				 
				 }
				
			},"json");
			
        });
	   initialize();
 
});
	   </script>

                
         
  
   <!-- end minimize and maximize menu panel-->
    <script src="./js/main.min.js"></script>
    
  
</body></html>