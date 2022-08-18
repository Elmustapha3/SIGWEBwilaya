<?php
        $a=''; $b=''; $c='';$d=''; $e='activ'; $d="";$f=''; $g="";

        session_start();
        if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
            if($_SESSION['typeuser']=='normaluser'){
                header('location:mesprojets.php');
            }
        }

       
if(isset($_GET['cni'])){
$cniupdated = $_GET['cni'];
}
  include('database/connexion.php');
  $req="select cni , prenom, nom, partager, modifierdesc, supprimer, voirlayernonpartager from users  where  cni = ?;";
  $reqall= $con->prepare($req);
  $reqall->execute([$cniupdated]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="resources/images/logorm.png">
    <link href="sss.css" rel="stylesheet" >

    <title>Document</title>
</head>
<body>

    <?php
    include('componemnts/topbar.php');
    include('componemnts/navbaradmin.php');
    ?>
     <div class="d-sm-flex  ">
            <?php
            include("componemnts/sidebaradmin.php");
            ?>
            <div class="  container px-5 mx-5 w-50">
                <form action="" method="post">
                    <?php   foreach($reqall as $rr){ ?>
                    <h3 class="m-4 mx-5 px-4">Les informations d'utilisateur :</h3>
                    <table class="table">
                        <tr>
                            <td class=" text-center"><lable class=" " for="">CNI :  </label></td>
                            <td><?php echo $rr['cni'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="">Prénom :  </label></td>
                            <td><?php echo $rr['prenom'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="nom">Nom :  </label></td>
                            <td><?php echo $rr['nom'] ;?></td>
                        </tr>
                    </table>
                    <h3 class="m-4 mx-5 px-4 ">les droits d'accés de l'utilisateur : <span class="text-danger">*</span> </h3>
                                    
                                    <?php if($rr['partager']==1){ $checkp='checked';}else{ $checkp='';} if($rr['modifierdesc']==1){ $checkm='checked';}else{ $checkm='';} if($rr['supprimer']==1){ $checks='checked';}else{ $checks='';} if($rr['voirlayernonpartager']==1){ $checkv='checked';}else{ $checkv='';}  ?>
                        <div class="container mx-5 px-5">
                        <div class="form-check form-switch  my-3">
                                <label class="form-check-label" for="flexSwitchCheckDefaulta">Partager les couches</label>
                                <input class="form-check-input mx-3" type="checkbox" <?php echo $checkp; ?> value="partager"  name="partager" id="flexSwitchCheckDefaulta">
                            </div>
                            <div class="form-check form-switch  my-3">
                                <label class="form-check-label" for="flexSwitchCheckDefaultb">Modifier les métadonnées des couches</label>
                                <input class="form-check-input mx-3" type="checkbox" value="modifier"  <?php echo $checkm; ?> name="modifier" id="flexSwitchCheckDefaultb">
                            </div>
                            <div class="form-check form-switch  my-3"> 
                                <label class="form-check-label" for="flexSwitchCheckDefaultc">Supprimer les projets</label>
                                <input class="form-check-input mx-3" type="checkbox"  value="supprimer"  <?php echo $checks; ?> name="supp" id="flexSwitchCheckDefaultc">
                            </div>
                            <div class="form-check form-switch  my-3"> 
                                <label class="form-check-label" for="flexSwitchCheckDefaultd">Voir la liste des couches non partagées</label>
                                <input class="form-check-input mx-3" type="checkbox"  value="voirnonpartager" <?php echo $checkv; ?> name="voirnonpartager" id="flexSwitchCheckDefaultd">
                            </div>
                        </div>
                        <div class="err text-center text-danger h5"></div>
                        <div class="yes text-center h5 text-success"></div>
                        <div class="text-center">
                            <a href="permission.php" class="px-5 my-3 btn bg-secondary text-light">Annuler</a>
                            <input type="submit" class="px-5 my-3 bg-secondary btn text-light" value="Modifier" name="update"/>
                        </div>
                        <?php }?>
                </form>
            </div>
        </div>
    
        <?php
        include("footer.php");
        ?>
</body>
</html>

<?php

           

    if(isset($_POST['update'])){
  
            if(isset($_POST['partager'])){
                $perpar=1;
            }else{
                $perpar=0;
            }
            if(isset($_POST['modifier'])){
                $permod=1;
            }else{
                $permod=0;
            }if(isset($_POST['supp'])){
                $persup=1;
            }else{
                $persup=0;
            }
            if(isset($_POST['voirnonpartager'])){
                $pervoi=1;
            }else{
                $pervoi=0;
            }

           
        

            $sql = "update users set partager = ?,modifierdesc = ?,supprimer = ?, voirlayernonpartager = ? where cni = ?;";
            $stmt= $con->prepare($sql);
            $stmt->execute([$perpar,$permod,$persup,$pervoi,$cniupdated]);
            echo "<script> window.location.href='permission.php';</script>";


    }


?>
