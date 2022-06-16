<?php
session_start();
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
    <title>GIS Simplified - Web Mapping Application</title>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">
    
    <link rel="stylesheet" href="resources/ol/ol.css">
    <link rel="stylesheet" href="resources/layerswitcher/ol-layerswitcher.css">
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="resources/fontawsome/css/all.css">
    <link rel="shortcut icon" href="resources\images\map.png">
    
</head>

    <title>acceuil</title>
  </head>
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
    
    ?>
    
    
    <div id="map" class="map">
    <button id="btnCrosshair" title="Live Location">
        <i class="fa fa-crosshairs fa-2x"></i>
</button>
    </div>
    
    
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>

    <div class="attQueryDiv" id="attQueryDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Attribute Query</label>
        </div><br>
        <label for="">Select Layer</label>
        <select name="selectLayer" id="selectLayer">
        </select><br><br>

        <label for="">Select Attribute</label>
        <select name="selectAttribute" id="selectAttribute">
        </select><br><br>

        <label for="">Select Operator</label>
        <select name="selectOperator" id="selectOperator">
        </select><br><br>

        <label for="">Enter Value</label>
        <input type="text" name="enterValue" id="enterValue">
        </select><br><br>

        <button type="button" id="attQryRun" class="attQryRun" onclick="attributeQuery()">Run</button>
    </div>

    <div class="attListDiv" id="attListDiv">
    </div>
 <div class="spQueryDiv" id="spQueryDiv">
<div class="headerDiv" id="headerDiv">
<label for="">Spatial Query</label>
</div>
<label for="">Select featues of </label>
<select name = "buffselectLayer" id="buffselectLayer">
</select>

<label for="">that are </label>
<select name="qryType" id="qryType">
   <option value="withinDistance">Within Distance of</option>
   <option value="intersecting">Intersectings</option>
    <option value="completelywithinT">Completely within</option>
</select>

<div class="bufferdiv" div="bufferdiv">
    <input type="number" name="bufferDistance" id ="bufferDistance" placeholder="1000">
    <select name="distanceUnits" id="distanceUnits">
        <option value="meters" >Meters</option>
        <option value="Kilometres" >Kilometres</option>
        <option value="feet">Feet</option>
        <option value="nautical miles">Mautical Miles</option>
       
    </select>
 <label for="">from</label>   
</div>
<select name="srcCriteria" id="srcCriteria">
<option value="pointMarker">Point Marker</option>
<option value="lineMarker">Line Marker</option>
<option value= "polygonMarker">Polygon Marker</option>
</select>
<button type="button" id="spUserInput" class="spUserInput">
    <img src="main.png" alt="" style="width:17px; height:17px; vertical-align:middle"></img></button>
    <button type="button" id="spQryRun" class="spQryRun">Run</button>
    <button type="button" id="spQryClear" class="spQryClear">Clear</button>
    </div>
    <div class="editingControlsDiv" id="editingControlsDiv"></div>
<!--
    <div class="settingDiv" id="settingDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Settings</label>
        </div>
            <label for="">FeatureInfo Layer</label><br>
            <select name="featureInfoLayer" id="featureInfoLayer">
                <option value="Visible layers">Visible layers</option>
                <option value="All layers">Alll layers</option>
            </select>
            <label for="">Editing Layer</label><br>
            <select name="editingLayer" id="editingLayer"></select>
    </div>
-->
    <div  class="settingDiv" id="settingDiv">
        <div class="headerDiv" id="headerDiv">
            <label for="">Settings</label>
        </div>
            <label for="">FeatureInfo Layer</label><br>
            <select name="featureInfoLayer" id="featureInfoLayer">
                <option value="Visible layers">Visible layers</option>
                <option value="All layers">Alll layers</option>
            </select>
            <label for="">Editing Layer</label><br>
            <select name="editingLayer" id="editingLayer"></select>
    </div>

    <script src="resources/ol/ol.js"></script>
    <script src="resources/layerswitcher/ol-layerswitcher.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>
    <?php
   include("componemnts/footer.php");
    ?>

   <script type="text/javascript" >
      document.getElementById("profil").style.visibility = "hidden"; 
    </script>

</script>
    
  </body>
</html>