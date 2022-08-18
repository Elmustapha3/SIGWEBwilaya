<?php
session_start();
include('database/connexion.php');

if(isset($_SESSION['username'])){
  $username=$_SESSION['username'];
}else{
  $username='<a href="login.php" class="nav-link">Connexion</a>';
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">  
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Portail de partage</title>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <link rel="stylesheet" href="resources/ol/ol.css">
    <link rel="stylesheet" href="resources/layerswitcher/ol-layerswitcher.css">
    <link rel="stylesheet" href="sss.css">
    
    <link rel="stylesheet" href="resources/fontawsome/css/all.css">
    <link rel="shortcut icon" href="resources/images/logorm.png">
    
</head>

    <title>Acceuil</title>
  </head>
  <style>
.over{
  overflow: auto;
}
  </style>
  <body>

  <?php
  
    include("componemnts/topbar.php");

    if(isset($_SESSION['typeuser'])){
      if($_SESSION['typeuser']=='admin'){
        include("componemnts/navbaradmin.php");  
      }else{
        include("componemnts/navbar.php");  
      }
    }else{

      include("componemnts/navbar.php");
    }

    $sql = 'select * from layers';
    $result = $con->query($sql);

    ?>
    <div class="d-flex">
      <div class="">
        
      </div>
        <div id="map" class="map"></div>
        <div class="list-group rounded-0 bgdark w-25">
            <div class="form-outline mx-3 my-1">
              <input type="search" id="search" class="form-control"  onkeyup="myFunction()" placeholder="Chercher ici..." />
            </div>
            <h5 class=" m-2 text-secondary">Liste des couches :</h5>
            
            <div class="over">
            <table id="layerstable" class="w-100">
                <?php  foreach($result as $row){
                  if($row['layerpartager']==true){ ?>
                    <tr>
                      <td scope="col"><a href="layer.php?idlayer=<?php echo $row['idlayer']; ?>" class="list-group-item list-group-item-action bg-dark text-light  rounded my-1 h6"><?php echo $row['layername']; ?></a></td>
                    </tr>
                <?php }}?>
                <?php if(isset($_SESSION['username'])){
                  ?>
                  <tr>
                      <td scope="col"><h5 class=" m-2 text-secondary">Couches non partages :</h5></td>
                  </tr>
                <?php
                  $sql = 'select * from layers';
                  $result = $con->query($sql);
                  foreach($result as $row){
                if($_SESSION['voirlayernonpartager']==true || $_SESSION['numuser']==$row['numuser'] ){
                  
                    if($row['layerpartager']==false){?>
                    <tr>
                      <td scope="col"><a href="layer.php?idlayer=<?php echo $row['idlayer']; ?>" class="list-group-item list-group-item-action bg-dark text-light border-0 rounded my-1"><?php echo $row['layername']; ?></a></td>
                    </tr>
                <?php
                    }}
                  else{ ?>
                       <tr>
                          <td  scope="col"><div class="text-warning mx-2 ">Vous n'avez pas le droit de voir les couches non partagées de les autres utilisateurs.</div></td>
                      </tr>
                 <?php }}}
                 ?>
                
           </table>
            </div>
            
             
          </div>
    </div>
    
    
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>
    <div id="layersDiv" class="layersDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Layers</label>
        </div>
        <div id="layerSwitcherContent" class="layer-switcher"></div>
    </div>
    <!-- <div class="toggleAttQueryDiv" id="toggleAttQueryDiv"></div> -->
    <div class="attQueryDiv" id="attQueryDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Attribute Query</label>
        </div>
        <!-- <br> -->
        <label for="">Select Layer</label>
        <select name="selectLayer" id="selectLayer">
        </select>
        <!-- <br><br> -->

        <label for="">Select Attribute</label>
        <select name="selectAttribute" id="selectAttribute">
        </select>
        <!-- <br><br> -->

        <label for="">Select Operator</label>
        <select name="selectOperator" id="selectOperator">
        </select>
        <!-- <br><br> -->

        <label for="">Enter Value</label>
        <input type="text" name="enterValue" id="enterValue">
        </select>
        <!-- <br><br> -->

        <button type="button" id="attQryRun" class="attQryRun">Run</button>
        <button type="button" id="attQryClear" class="attQryClear">Clear</button>

    </div>
    <!-- <div class="toggleAttributeListDiv" id="toggleAttributeListDiv"></div> -->
    <div class="attListDiv" id="attListDiv">
    </div>

    <div class="spQueryDiv" id="spQueryDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Spatial Query</label>
        </div>
        <label for="">Select featues of </label>
        <select name="buffSelectLayer" id="buffSelectLayer">
        </select>
        <!-- <br><br> -->

        <label for="">that are </label>
        <select name="qryType" id="qryType">
            <option value="withinDistance">Within Distance of</option>
            <option value="intersecting">Intersecting</option>
            <option value="completelyWithin">Completely Within</option>
        </select>
        <!-- <br><br> -->

        <div class="bufferDiv" id="bufferDiv">
            <!-- <label for="">Distnace in meter</label> -->
            <input type="number" name="bufferDistance" id="bufferDistance" placeholder="1000">
            <select name="distanceUnits" id="distanceUnits">
                <option value="meters">Meters</option>
                <option value="kilometers">Kilometers</option>
                <option value="feet">Feet</option>
                <option value="nautical miles">Nautical Miles</option>
            </select>
            <!-- <br><br> -->

            <label for="">from</label>
        </div>


        <select name="srcCriteria" id="srcCriteria">
            <option value="pointMarker">Point Marker</option>
            <option value="lineMarker">Line Marker</option>
            <option value="polygonMarker">Polygon Marker</option>
        </select>
        <!-- <br><br> -->

        <button type="button" id="spUserInput" class="spUserInput"><img src="resources/images/selection.png" alt=""
                style="width:17px;height:17px;vertical-align:middle"></img></button>

        <button type="button" id="spQryRun" class="spQryRun">Run</button>

        <button type="button" id="spQryClear" class="spQryClear">Clear</button>
    </div>

    <div class="editingControlsDiv" id="editingControlsDiv">

    </div>

    <div class="settingsDiv" id="settingsDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Configurations</label>
        </div>
        <label for="">FeatureInfo Layer</label><br>
        <select name="featureInfoLayer" id="featureInfoLayer">
            <option value="All layers">All layers</option>
            <option value="Visible layers">Visible layers</option>
        </select>
        <label for="">Editing Layer</label><br>
        <select name="editingLayer" id="editingLayer">
        </select>
    </div>

    <?php  include('footer.php');?>

          <script src="resources/ol/ol.js"></script>
          <script src="resources/layerswitcher/ol-layerswitcher.js"></script>
          <script src="main.js"></script>
          <script src="JS/search.js"></script>
          <script>
      <?php

          $getname = "SELECT layername FROM layers where layerpartager=true ;";
          $namelayy= $con->query($getname);
          $visi=true;
          foreach($namelayy as $namelay){
              $projet=$namelay['layername'];  include("projets/map.php");
          }
          if(isset($_SESSION['username'])){
            $getname = "SELECT * FROM layers where layerpartager=false ;";
            $namelayy= $con->query($getname);
            $visi=true;
            foreach($namelayy as $namelay){
              if($_SESSION['voirlayernonpartager']==true || $_SESSION['numuser']==$namelay['numuser'] ){
                    if($namelay['layerpartager']==false){
                      $projet=$namelay['layername'];  include("projets/map.php");
                    }
              }
            }
          }
          ?>
         map.on('click', function(evt) {

      // Hide existing popup and reset it's offset
      popup.hide();
      popup.setOffset([0, 0]);

      // Attempt to find a marker from the planningAppsLayer
      var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
          return feature;
      });

      if (feature) {

          var coord = feature.getGeometry().getCoordinates();
          var props = feature.getProperties();
          var info = "<h2><a href='" + props.caseurl + "'>" + props.casereference + "</a></h2>";
              info += "<p>" + props.locationtext + "</p>";
              info += "<p>Status: " + props.status + " " + props.statusdesc + "</p>";
          // Offset the popup so it points at the middle of the marker not the tip
          popup.setOffset([0, -22]);
          popup.show(coord, info);

      } else {

          var url = Communes_Region
                      .getSource()
                      .getGetFeatureInfoUrl(
                          evt.coordinate,
                          map.getView().getResolution(),
                          map.getView().getProjection(),
                          {
                              'INFO_FORMAT': 'application/json',
                              'propertyName': 'NAME,AREA_CODE,DESCRIPTIO'
                          }
                      );

          reqwest({
              url: url,
              type: 'json',
          }).then(function (data) {
              var feature = data.features[0];
              var props = feature.properties;
              var info = "<h2>" + props.NAME + "</h2><p>" + props.DESCRIPTIO + "</p>";
              popup.show(evt.coordinate, info);
          });

      }});
    </script>
 


    
  </body>
</html>