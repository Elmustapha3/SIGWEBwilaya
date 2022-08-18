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
h1, h2, h3, h4, h5, h6 { 
	font-family: "Open sans", Helvetica, Arial;
	font-weight: 300;
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
    }?>
    <div class="bg-dark bg-gradient">
    <div class="container text-center p-3 py-3 text-light">
            <div class=" text-center">
                    <h1 class="">Portail de Partage</h1>
                    <h3 class="">Système d'information géographique</h3>
                    <h3 class="">Marrakech-Safi</h3>
                    <p class="lead">
                        
                    </p>
                    
                    <p>découvrir la région de Marrakech-Safi<br>
                    synthétiser des données visualiser géographiquement ,des événements en temps réel ou de modélisation,faire une analyse statistique et une historisation des données géographiques sur la région de Marrakech-Safi</p>
                        <br>
			</div>
        </div>
    </div>
    <div class="bg-light bg-gradient ">
    <div class="container text-center py-5 ">
        
        <div class="container text-center pb-5">
            <div class="my-4">
				<h1 class="text-center">De quoi s'agit-il</h1>
				<p class="lead text-center">
			    SIGWEB système d’information géographique conçu d’acquérir, d’organiser, de gérer de traiter et de restituer des données géographiques de la region Marrakech-Safi sous forme de plans et cartes cartographie intuitive et évolutive.
				</p> 
			</div>
            <div class="d-md-flex">
                <div class="w-50  col col-md-6 mx-auto">
                    <img class="img-fluid m-5 w-75 rounded-circle" src="map1.jpg" alt="Sample image">
                </div>
                <div class="w-50  col col-md-6 mx-auto my-5">
                    <h2 class="mt-5">presentation de la région de Marrakech-Safi </h2>
                    <p xlass="mb-5">La région de Marrakech Safi est l’une des douze régions du Maroc, elle se  situe dans le centre de pays  s'étend sur une superficie de 41 404 km2 , soit 6% du territoire national, avec une population de 4 520 569 habitants repartis dans sept provinces et 215 communes .</p>
                </div>
            </div>
            <div class="d-md-flex">
                <div class="w-50 py-3 col col-md-6 mx-auto">
                    <h2 class="space-before">Presentation de ce Portail </h2>
                    <p> Le portail de partage fournit aux utilisateurs finaux une application SIG Web qui leur permette de travailler sans pour autant disposer de connaissances approfondies dans le domaine des SIG, ainsi que les différents outils utilisés pour visualiser des informations géographiques, interagir avec ces dernières et les exploiter</p>
                    <p>résoudre des problèmes d’amé¬na¬ge¬ment et de gestion, ou encore de synthétiser des données pour aider à la décision. D’une part, le SIG offre la possibilité d’exploiter des bases de données complexes (requêtes, statis¬tiques, analyse des interactions spatiales) et d’autre part, il permet de les visualiser géographiquement.</p>
                </div>
                <div class="w-50 py-3 col col-md-6 mx-auto">
                    <img class="img-fluid m-5 w-75 rounded-circle" src="m3.png" alt="Sample image">
                </div>
            </div>
            <div class="d-md-flex">
                <div class="w-50 py-3 col col-md-6 mx-auto">
                    <img class="img-fluid m-5 w-75 rounded-circle" src="c1.png" alt="Sample image">
                </div>
                <div class="w-50 my-5 col col-md-6 mx-auto">
                    <h2 class="mt-5 pt-4">Fonctionnalités de ce portail</span></h2>
                    <p>L’analyse statis¬tique et l’historisation des données géographiques sur la commune. Rapports, analyses statistiques et spatiales ou encore stockage des dernières modifications que se soit attributaire ou sur terrain du patrimoine de la commune.
                    la  gestion et le suivi des équipements communaux. Construction et modélisation progressive du patrimoine de la commune
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
        include("footer.php");
        ?>
    </body>
    <html>
