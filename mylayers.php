<?php
session_start();
include('database/connexion.php');

if(!isset($_SESSION['username'])){
    header('location:index.php');
}else{
    $username=$_SESSION['username'];
}
$a='activ'; $b=''; $c='';$d=''; $e='';$f=''; 
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">
    <title>Mes couches</title>
    <link rel="stylesheet" href="resources/ol/ol.css">
    <link rel="stylesheet" href="resources/layerswitcher/ol-layerswitcher.css">
    <link rel="stylesheet" href="sss.css">
    <link rel="stylesheet" href="resources/fontawsome/css/all.css">
    <link rel="shortcut icon" href="resources\images\map.png">
    
</head>

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

    $sql = 'select * from layers where numuser = ?';
    $result= $con->prepare($sql);
    $result->execute([$_SESSION['numuser']]); 
    ?>
    
    
    <div class="d-flex">
        <?php
             if($_SESSION['typeuser']=='admin'){
            include("componemnts/sidebaradmin.php");
            }else{
                include("componemnts/sidebaruser.php");
            }
          ?>
        <div id="map" class="map"></div>
        <div class="list-group bg-dark w-25">
            <div class="form-outline mx-3 my-1">
              <input type="search" id="search" class="form-control"  onkeyup="myFunction()" placeholder="Chercher ici..." />
            </div>
            <h5 class=" m-2 text-secondary">Mes couches :</h5>
            <table id="layerstable">

                <?php  foreach($result as $row){ ?>
                <tr>
                  <td><a href="layer.php?idlayer=<?php echo $row['idlayer']; ?>" class="list-group-item list-group-item-action bg-dark text-light border"><?php echo $row['layername']; ?></a></td>
                </tr>
                <?php } ?>  
            </table> 
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



    <script src="resources/ol/ol.js"></script>
    <script src="resources/layerswitcher/ol-layerswitcher.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
    <script>
      <?php

        $getname = "SELECT layername FROM layers ;";
        $namelayy= $con->query($getname);
        $visi=false;
        foreach($namelayy as $namelay){
            $projet=$namelay['layername'];  include("projets/map.php");

        }
        ?>
    </script>
 


    
  </body>
</html>