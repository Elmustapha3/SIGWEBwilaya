

<?php

include('connexion.php');
if(isset($_GET['idproject'])){
    $idproject = $_GET['idproject'];
    $sql = "update projects set partager = true where idproject=?";
    $propar= $con->prepare($sql);
    $propar->execute([$idproject]);
    header('location:../projetspartager.php');
  }


?>