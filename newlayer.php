<?php
    session_start();
      if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
    }

    include('database/connexion.php');
        $sql = 'select f_table_name from geometry_columns except select layername from layers';
        $result = $con->query($sql);

    //include('addlayertotablelayers.php');
    $a=''; $b='activ'; $c='';$d=''; $e=''; $d="";$f=''; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
 
      <title>Ajout d'une couche</title>
</head>
<body>

    <?php
        include("componemnts/topbar.php");
        if($_SESSION['typeuser']=='admin'){
            include("componemnts/navbaradmin.php");
            }else{
                include("componemnts/navbar.php");
            }
        ?>
        <div class="d-sm-flex">
            <?php
             if($_SESSION['typeuser']=='admin'){
                include("componemnts/sidebaradmin.php");
            }else{
                    include("componemnts/sidebaruser.php");
                }
            ?>
            <div class="container mx-5 mb-5 px-5 ">
                <form action="newlayer.php" method="post">
                    <h3 class="m-5">Nouveau couche</h3>
                    <div class="mx-5 px-5">
                    <?php

                        foreach($result as $res){
                           echo '<div class="form-check">';
                                echo '<input class="form-check-input m-3 " type="radio" name="layer" value="'. $res['f_table_name'].'" id="'. $res['f_table_name'].'">';
                                echo '<label class="form-check-label m-3 " for="'. $res['f_table_name'].'">'. $res['f_table_name'].'</label>';
                            echo '</div>';
                            $couchdb[]=$res['f_table_name'];
                        }

                    ?>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form4Example3">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="form4Example3" name="desc" rows="4"></textarea>
                    </div>
                    <div class="text-warning my-3 border ">Obligatoirement vous devez publier les couches avant d'appuyer sur le button Ajouter</div>
                    <button class="btn bg-primary "><a href="http://localhost/geoserver/web/wicket/bookmarkable/org.geoserver.web.data.layer.NewLayerPage?7" class="text-light nav-link" target="_blank">publier la couches</a></button></br>
                    <div class="form-check form-switch  my-3">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Partger avec le public</label>
                        <input class="form-check-input mx-3" type="checkbox" value="parpub"  name="parpub" id="flexSwitchCheckDefault">
                    </div>
                    <div class="text-center">
                        <div class="err text-danger"></div>
                        <button class="btn bg-primary text-light" name="ajoutl">Ajouter</button>
                    </div>
                    </div>
                </form>
                

            
            </div>
                
        </div>
   
</body>
</html>


<?php

if(isset($_POST['ajoutl'])){


    

       $desc=$_POST['desc'];

   $layernamet;
    for($d=0;$d<count($couchdb);$d++){
        if($_POST['layer']==$couchdb[$d]){
           $layernamet=$couchdb[$d];
        }
    }

      
    if(isset($_POST['parpub'])){
        $parpub=1;
    }else{
        $parpub=0;
    }


    //$sql = 'select f_table_name from geometry_columns';
    //$result = $con->query($sql);
 

    if(empty($desc)){
        echo "<script>document.querySelector('.err').textContent='Ecrire une description pour la couche'</script>";
    }else{
        
        $cn =$_SESSION["cni"];
        $a = "SELECT numuser FROM users WHERE cni ='$cn' ;";

        $b= $con->query($a);
        $bb = $b->fetch();

        $sqltime = 'select CURRENT_TIMESTAMP';
        $noww= $con->query($sqltime);
        $now= $noww->fetch();


        $sqlp = "INSERT INTO layers (layername, datecreer, layerpartager, numuser, description) VALUES (?,?,?,?,?)";
        $proj= $con->prepare($sqlp);
        $proj->execute([$layernamet,$now[0],$parpub,$bb[0], $desc]);

        echo "<script> window.location.href='index.php';</script>";
        
      

    }

}

?>

