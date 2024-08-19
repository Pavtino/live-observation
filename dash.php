<?php include("init.php");

$action = getArrayVal($_GET, "action");
$id = getArrayVal($_GET, "id");
$mode = getArrayVal($_GET, "mode");
$admin=false;

    if (!isset($_SESSION["userid"])) {
        
        header("Location: login.php?loginerror=0");
        die();
    }
if($_SESSION["userrole"]=="admin") 
 $admin=true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Observations</title>
   
    <link rel="stylesheet" href="css/main.min.css">
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/jquery.bootgrid.css" rel="stylesheet" />
    <link href="css/bootstrap-modal-bs3patch.css" rel="stylesheet">
    <link href="css/bootstrap-modal.css" rel="stylesheet">    
    <link rel="stylesheet" href="css/bootstrap_datepicker.css">
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
    <script src="js/bootstrap-modalmanager.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script>
	var val=0;
	var delid=0;
    function view(id){
		$.getJSON( "managepoi.php?action=dash&id="+id, function( data ) {
			//
			$('#nom-af').text(data.titre);
			$('#desc-af').text(data.description);
			$('#splat').text(data.lat);
			$('#splng').text(data.lng);	
			$('#img1').attr('src',data.photo1);
			$('#img2').attr('src',data.photo2);	
			
	});
	$('#views').modal();
	}
	//modification
	 function edit(id){
		$.getJSON( "managepoi.php?action=dash&id="+id, function( data ) {
			//
            var decoded = $("<div/>").html(data.titre).text();
			$('#titreed').val(decoded);
			$('#desc').html(data.description).val();
			$('#lated').val(data.lat);
			$('#lnged').val(data.lng);
			$('#dateed').val(data.dateob);
			decoded = $("<div/>").html(data.ard).text();
			$('#arded').val(decoded);
			decoded = $("<div/>").html(data.dep).text();
			$('#deped').val(decoded);
			$('#lieued').val(data.lieu);
			$('#visible').val(data.visible);	
			$('#status').val(data.status);
			$('#idata').val(data.ID);	
			
	});
	$('#edit').modal();
	}
	 function delpoi(id){
		 $('#before').modal();
		 delid=id;     
		
	}
	function fileup(id)
	{
		 $('#views').modal();
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
          <span class="small-18 title" style="font-weight:bold;color:#09F">Panel d'administration des Observations</span>   
          </div>
          
        <table id="grid" class="table table-condensed table-hover table-striped"  cellspacing="0" width="100%">
        <thead>
            <tr>
                <th data-column-id="ID" data-type="numeric">ID</th>
                <th data-column-id="titre">Titre</th>
                <th data-column-id="status">Status</th>
                <!--<th data-column-id="code">Discipline</th>
                <th data-column-id="ordre">N°Ordre</th>-->
                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions</th>
            </tr>
        </thead>
    </table>
    
   
<!--modification observation-->
<div id="edit" class="modal fade" tabindex="-1" data-width="400" style="display: none; width: 600px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="obtitle">Observateur anonyme</h4>
  </div>
  <form name="poifrm" id="poifrm"  enctype="multipart/form-data" method="post" action="poi.php">
  <div class="modal-body">
  <div class="row">
        <div class="form-group">      
        <label class="col-lg-4 control-label">Titre:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="titreed" name="titreed">
         <input  type="hidden" id="idata" name="idata">
            </div>
        </div>
        
        <div class="form-group">      
        <label class="col-lg-4 control-label">Description:</label> 
           <div class="col-lg-6">
         <textarea rows="4" cols="25" name="desc" id="desc" class="form-control"></textarea>
            </div>
        </div>
        
         <div class="form-group">      
        <label class="col-lg-4 control-label">Latitude:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="lated" name="lated">
            </div>
        </div>
        
         <div class="form-group">      
        <label class="col-lg-4 control-label">Longitude:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="lnged" name="longed">
            </div>
        </div>
        <div class="form-group">      
        <label class="col-lg-4 control-label">P&eacute;riode:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="dateed" name="dateed" data-date-format="yyyy-mm-dd">
            </div>
        </div>
        <div class="form-group">      
        <label class="col-lg-4 control-label">Departement:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="deped" name="deped">
            </div>
        </div>
        
         <div class="form-group">      
        <label class="col-lg-4 control-label">Arrondissement:</label> 
           <div class="col-lg-6">
         <input class="form-control" type="text" id="arded" name="arded">
            </div>
        </div>
        <div class="form-group">      
        <label class="col-lg-4 control-label">ville ou village:</label> 
           <div class="col-lg-6">
        <input class="form-control" type="text" id="lieued" name="lieued">
            </div>
        </div>
         <?php if($_SESSION["role"]=="admin")
			  {?>
         <div class="form-group">      
        <label class="col-lg-4 control-label" for="status">Visible:</label> 
           <div class="col-lg-6">
             <select name="visible" id="visible" class="form-control">
             <option value="1">Oui</option>
             <option value="0">Non</option>
             </select>
           </div>
        </div>
       <div class="form-group">      
        <label class="col-lg-4 control-label" for="status">Status:</label> 
           <div class="col-lg-6">
             <select name="status" id="status" class="form-control">
             <option value="0">Non verifi&eacute;</option>
             <option value="1">verifi&eacute;</option>
             <option value="2">Sanctionn&eacute;</option>
             </select>
           </div>
        </div>
       <?php }?>
                
    </div>  
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default" id="close">Fermer</button>
    <button type="button" class="btn btn-primary" id="save">Valider</button>
  </div>
  </form>
</div>
<!--end modification-->

<div id="views" class="modal fade" tabindex="-1" data-width="600" style="display: none; width: 600px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="obtitle">Observation</h4>
  </div>
   <form >
  <div class="modal-body" style="width:600px">
    <div class="row">
      <div class="col-md-8" id='ins'>     
        
      </div> 
      </div>
      </div>
   <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="close">Fermer</button>
  </div> 
  </form>   
    </div>

<!--suppression-->
<div id="before" class="modal fade" tabindex="-1" data-width="460" style="display: none; width: 460px; margin-left: -379px; margin-top: -266px;" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Suppression POI</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-8">
        <h4>Voulez vous continuer la suppression?</h4>
          
      </div>     
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="oui" onClick="javascript:delpoifinal()">OUI</button>
    <button type="button" data-dismiss="modal" class="btn btn-default" id="non">NON</button>
  </div>
</div>
    </div>
   </section>  
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/lightbox.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.bootgrid.js"></script>
    <script src="lib/datepicker/js/bootstrap-datepicker.js"></script>
    <script>
            $(function()
            {
				$('#dateed').datepicker();
                function init()
                {
					var admin=<?=$admin?>;
					var result="";
					
                    $("#grid").bootgrid({
						 ajax: true,
						 /* post: function ()
						  {
						  return {
						  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
						  };
						  },*/
						  url: "managepoi.php?action=poi",
                        formatters: {
						"commands": function(column, row)
						{
							result="<a href=\"files.php?id="+row.ID +"\"   class=\"btn btn-xs btn-default \">Fichiers</a> " +
						"<a href=\"javascript:edit("+row.ID +")\"  data-toggle=\"modal\" row-id=\""+row.ID +"\"  data-target=\"#views\" class=\"btn btn-xs btn-default command-edit \">modifier</a>";
						    if(admin)
							result=result+"<a href=\"javascript:delpoi("+row.ID +")\" class=\"btn btn-xs btn-default command-delete\" >Supprimer</a>";
						return result;
						
						}
						}
                    })
                }  
                init();
$('#save').click(function (event) {
    event.preventDefault()
	var id=0;
	$.post("poi.php?action=edit",$('#poifrm').serialize(),function(data){
				$('#edit').modal('hide');
				$('#lated').val('');
	            $('#lnged').val('');
		        $('#titreed').val('');
				$('#desc').val('');
				$('#arded').val('');
				$('#deped').val('');
				$('#lieued').val('');
				
    
				
			},"json");
			
  window.location.reload();
});   
$('#oui').click(function(){
 
		 $.getJSON( "poi.php?action=del&id="+delid, function( data ) {
		window.location.reload();
	});
	
});
            }); 
</script>
<script src="lib/datepicker/js/bootstrap-datepicker.js"></script>
 <script type="text/javascript">
        $(function() {
			$('#dateed').datepicker();
        });
    </script>
<!--<script src="js/fileinput.js" type="text/javascript"></script>-->

<!--succes-->
</div>
</body>

</html>