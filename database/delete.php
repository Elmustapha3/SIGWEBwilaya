<?php

include('connexion.php');

if(isset($_GET['cni'])){
    $cni = $_GET['cni'];
    $sql = "DELETE FROM users WHERE cni=?";
    $stmt= $con->prepare($sql);
    $stmt->execute([$cni]);
    header('location:../administrerUser.php');
}

if(isset($_GET['idpost'])){
    $idpost = $_GET['idpost'];
    $sql = "DELETE FROM post_travail WHERE idpost=?";
    $stmt= $con->prepare($sql);
    $stmt->execute([$idpost]);
    header('location:../postravail.php');
}

?>