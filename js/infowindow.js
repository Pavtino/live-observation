// JavaScript Document
function InfoW(data)
{
var contentStr='<div id="views" class="modal fade" tabindex="-1" data-width="600" style="display: none; width: 400px;'+ 'margin-left: -379px; margin-top: -266px;" aria-hidden="true">'+
  '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'+
   ' <h4 class="modal-title" id="obtitle">Observation </h4></div>'+   
  '<div class="modal-body" style="width:400px">'+
    '<div class="row"> <div class="col-md-8"><p>Nom : <div id="nom-af">' + data.titre+'</div></p>'+
        '<p><label>Description</label>:<div id="desc-af">' + data.desc+'</div></p>'+
        '<p>Latitude: <span id="splat">'+data.lat+'</span></p>'+
       ' <p>Longitude: <span id="splng">'+data.lng+'</span></p>'+
        /*<p><img src="" id="img1" class="img-responsive img-rounded img-thumbnail" style="width:170px;">  
       <img src="" id="img2" class="img-responsive img-rounded img-thumbnail" style="width:170px;"></p> */ 
      '</div></div></div></div></div>';	
  return contentStr;
}