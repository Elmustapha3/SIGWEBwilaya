
<?php

session_start();
include('database/connexion.php');

if(isset($_GET['idlayer'])){
    $idlayer = $_GET['idlayer'];
    $sqlu = "update layers set layerpartager = true where idlayer = ?";
    $stmtu= $con->prepare($sqlu);
    $stmtu->execute([$idlayer]);
    $_SESSION['idshared']=$idlayer;
    header('location:layer.php');

}


?>