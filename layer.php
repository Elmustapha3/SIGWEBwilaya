<?php
session_start();
if(isset($_SESSION['username'])){
  $username=$_SESSION['username'];
}else{
  $username='<a href="login.php" class="nav-link">Connexion</a>';
}

include('database/connexion.php');

if(isset($_GET['idlayer'])){
  $idlayer = $_GET['idlayer'];
}elseif(isset($_SESSION['idshared'])){
  $idlayer = $_SESSION['idshared'];
}elseif(isset($_SESSION['idupdated'])){
  $idlayer= $_SESSION['idupdated'];
}

  $sql = "select * FROM layers WHERE idlayer = ? ";
  $stmt= $con->prepare($sql);
  $stmt->execute([$idlayer]);
  foreach($stmt as $lay){
    $title=$lay['layername'];
    $idp=$lay['numuser'];
}

        $sqluser = "select * from users where numuser = ?";
        $owner= $con->prepare($sqluser);
        $owner->execute([$idp]);
        foreach($owner as $ow){
            $cni=$ow['cni'];
            $propriétaire= $ow['prenom'].' '.$ow['nom'];
        }


        $a=''; $b=''; $c='';$d='';$e='';$f='';
      
?>

<!doctype html>
<html lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="resources/ol/ol.css">
    <link rel="stylesheet" href="resources/layerswitcher/ol-layerswitcher.css"/>
    <link rel="stylesheet" href="sss.css"/>
    <link rel="stylesheet" href="fontawesome/css/all.css"/>
    
  </head>
  <style>
.px-3{
    height: 100vh;
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

    ?>

       
    
        <div class="d-flex">
          <?php
          if(isset($_SESSION['typeuser'])){
              if($_SESSION['typeuser']=='admin'){
              include("componemnts/sidebaradmin.php");
              }else{
                  include("componemnts/sidebaruser.php");
              }
            }
            ?>
            <div id="map" class="map"></div>
            <div class="list-group bg-dark text-light px-3 w-25 ">
                <?php 
                  $sql = "select * FROM layers WHERE idlayer = ? ";
                  $stmt= $con->prepare($sql);
                  $stmt->execute([$idlayer]);
                  foreach($stmt as $lay){ ?>
                      <h5 class="my-2"><?php echo $lay['layername']; ?></h5>
                      <p>description :</p>
                      <p><?php echo $lay['description']; ?></p>
                      <p>Ajouter le <?php echo $lay['datecreer']; ?></p>
                      <p>Propriétaire : <?php echo $propriétaire.' CNI : '.$cni; ?></p>
                      <p>Permission :  </p>
                      <?php if(isset($_SESSION['username'])){
                              if($_SESSION['modifierdesc']==true || $idp==$_SESSION['numuser']){
                                echo "<a href='database/updatemeta.php?update=$idlayer' class='btn btn-primary my-1'>Modifier les donnes</a>";
                              } }?>
                            <div class="btn-group">
                              <button type="button" class="btn btn-primary lext-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Teleccharger</button>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:<?php echo $lay['layername'];?>&outputformat=JSON" class="dropdown-item btn" download >GeoJSON</a>
                                <a href="http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:<?php echo $lay['layername'];?>&outputformat=CSV" class="dropdown-item btn" download>CSV</a>
                              </div>
                            </div>
                            <?php
                            echo "<a href='tableattr.php?idlayer=$idlayer' class='btn btn-primary my-1'> Voir table attributaire</a>";
                            
                           if(isset($_SESSION['username'])){
                            if( $lay['layerpartager']==false ){
                              if($_SESSION['partagercouche']==true || $idp==$_SESSION['numuser']){  
                                    echo '<a href="sharelayer.php?idlayer='.$idlayer.'" class="btn btn-primary my-1"> Partager la couche</a>';
                            }}
                          if($_SESSION['supprimercouche']==true || $idp==$_SESSION['numuser']){
                            echo "<a href='database/delete.php?idlayer=$idlayer' class='btn btn-primary my-1'>Supprimer la couche</a>";
                            }        
                                
                            
                            echo '<a href="mylayers.php" class="btn btn-light text-dark my-1">Tout vos couches</a>';
                            
                          }
                  }?>
                    <a href="index.php" class="btn btn-light text-dark my-1">Tout les couches</a>
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



    <?php 
         
    //include("componemnts/footer.php");
  
       ?>

    <script src="resources/ol/ol.js"></script>
    <script src="resources/layerswitcher/ol-layerswitcher.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
    <script type="text/javascript" >

      <?php 
      //$projet='Communes_Région';  include("projets/map.php");
      //$projet='Routes_Region';  include("projets/map.php");
    //$url="api/comu.json" ;
      //include("projets/map.php");

       $getname = "SELECT layername FROM layers WHERE idlayer=$idlayer;";
        $namelayy= $con->query($getname);
        $visi=true;
        foreach($namelayy as $namelay){
            $projet=$namelay['layername'];  include("projets/map.php");

        }
      
     // }
      
      
     
 
      ?>
    </script>


    
  </body>
</html>


   