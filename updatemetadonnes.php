<?php
$a=''; $b=''; $c='';$d=''; $e='';$f='';$g=""; 

    session_start();
      if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
    }

    if(isset($_SESSION['idupdated'])){
        $idlayer = $_SESSION['idupdated'];
      }else{
        header('location:index.php');
      }
      
   

    include('database/connexion.php');
        $sql = 'select * from layers where idlayer = ?';
        $result = $con->prepare($sql);
        $result->execute([$idlayer]);

    //include('addlayertotablelayers.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="sss.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<link rel="shortcut icon" href="resources/images/logorm.png">

      <title>Modifier la couche</title>
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
                <form action="updatemetadonnes.php" method="post">
                    <h3 class="m-5">Modifier la  couche</h3>
                    <div class="mx-5 px-5">
                        <?php foreach($result as $res){ $descold=$res['description']; ?>
                        <div class="">
                            <h4 class="m-5"><?php echo $res['layername'] ?></h4>
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form4Example3">Déscription <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="form4Example3" name="desc" rows="4"><?php echo $descold; ?></textarea>
                        </div>
                        <?php 
                        $parold = $res['layerpartager']; 
                        if($res['layerpartager']==1){ $checkp='checked';}else{ $checkp='';}  ?>
                        <div class="form-check form-switch  my-3">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Partger avec le public</label>
                            <input class="form-check-input mx-3" type="checkbox" value="parpub" <?php echo $checkp; ?> name="parpub" id="flexSwitchCheckDefault">
                        </div>
                        <div class="text-center">
                            <div class="err text-danger"></div>
                            <a href="layer.php?idlayer=<?php echo $idlayer; ?>" class="btn bg-secondary text-light">Anuuler</a>
                            <button class="btn bg-secondary text-light" name="modl">Modifier</button>
                        </div>
                        <?php } ?>
                    </div>
                </form>
                

            
            </div>
                
        </div>
        <?php
        include("footer.php");
        ?>
</body>
</html>


<?php

if(isset($_POST['modl'])){
    

    $desc=$_POST['desc'];

    if(isset($_POST['parpub'])){
        $parpub=1;
    }else{
        $parpub=0;
    }

    if(empty($desc)){
        echo "<script>document.querySelector('.err').textContent='Ecrire une description pour la couche'</script>";
    }else{
            $modificationdesc="";
            $modificationpar="";
            $modification="";

            if($desc!=$descold){
                $modificationdesc="Modifier la description de la couche,";
            }
            if($parold!=$parpub){
                if($parpub==1){
                    $modificationpar="partager la couche"  ; 
                }else{
                    $modificationpar=" Annuler la partage de la couche";
                }
            }

            $modification=$modificationdesc.' '.$modificationpar;



            $sqltime = 'select CURRENT_TIMESTAMP';
            $noww= $con->query($sqltime);
            $now= $noww->fetch();

            $sqlmod = "insert into updating (numuser,idlayer,date,modification) values (?,?,?,?)";
            $stmtmod= $con->prepare($sqlmod);
            $stmtmod->execute([$_SESSION['numuser'],$idlayer,$now[0],$modification]);
        
            $sqlu = "update layers set description=?, layerpartager = ? where idlayer = ?";
            $stmtu= $con->prepare($sqlu);
            $stmtu->execute([$desc,$parpub,$idlayer]);
            $_SESSION['idupdated']=$idlayer;
            echo "<script> window.location.href='layer.php';</script>";
        
    }
}

      
    



 

    


?>

