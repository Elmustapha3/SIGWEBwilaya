<?php
session_start();
include('connexion.php');

if(isset($_GET['update'])){
    $_SESSION['idupdated']=$_GET['update'];
    header('location:../updatemetadonnes.php');
}

?>