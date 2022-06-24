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

if(isset($_GET['idlayer'])){
    $idlayer = $_GET['idlayer'];

    $sqlnl = "select layername from layers where idlayer = ?";
    $stmtnl= $con->prepare($sqlnl);
    $stmtnl->execute([$idlayer]);

    foreach($stmtnl as $nl){
        $namel=$nl['layername'];
    }
    

    $sql = "DELETE FROM layers WHERE idlayer=?";
    $stmt= $con->prepare($sql);
    $stmt->execute([$idlayer]);

    

    $sqlt = 'DROP TABLE "'.$namel.'"';
    $stmt=$con->query($sqlt);

    //delete from groserver
    //curl -v -u admin:geoserver -XDELETE "http://testdevt.fractanet.com.mx:181/geoserver/rest/workspaces/MyWorkspace/datastores/MyDatastore/featuretypes/Layername.xml";


    header('location:../index.php');
}



?>