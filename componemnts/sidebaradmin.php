<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
   
    <title>Document</title>
</head>
<style>
.hig{
    height: 100vh;
}
.activ{
  background-color:#cccccc !important;
    color: #000 !important;
  }


</style>
<body>
    <div class="hig w-25 bgdark">
    <form action="" method="post">
        <div class="list-group ">
             
            <h4 class="list-group-item list-group-item-action bg-secondary text-light  ">Configuration</h4>
            
                <!--<a href="administration.php" class="list-group-item list-group-item-action">Liste des projets partagers</a>
                <a href="projetsnonpartager.php" class="list-group-item list-group-item-action">Liste des projets non partagers</a>-->
                <a href="alllayers.php" class="btn list-group-item list-group-item-action  bgdark text-light <?php echo $g; ?>">Toutes les couches</a>
                <a href="mylayers.php" class="btn list-group-item list-group-item-action  bgdark text-light <?php echo $a; ?>">Mes couches</a>
                <a href="newlayer.php" class="btn list-group-item list-group-item-action bgdark text-light <?php echo $b; ?>">Nouvelle couche</a>
                <a href="administrerUser.php" class="btn list-group-item list-group-item-action bgdark text-light <?php echo $d; ?>">Les utilisateurs</a>
                <a href="permission.php" class="btn list-group-item list-group-item-action bgdark text-light <?php echo $e; ?>">Les droits d'accès</a>
                <a href="postravail.php" class="btn list-group-item list-group-item-action bgdark text-light <?php echo $f; ?>">Les postes de travails</a>
                <a href="setting.php?cni=<?php echo $_SESSION['cni']; ?>" class=" btn list-group-item list-group-item-action bgdark text-light <?php echo $c; ?>">Profil</a>
                <button class="btn text-start w-100   bgdark text-light" name="log">Se déconnecter</button>
            
        </div>
    </form>
    </div>
</body>
</html>



<?php
if(isset($_POST['log'])){
  
  session_unset();
  session_destroy();
  echo "<script> window.location.href='index.php';</script>";
}


?>