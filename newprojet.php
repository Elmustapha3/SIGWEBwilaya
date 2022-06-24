<?php
    session_start();
      if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
             

      
    }
   // include('addlayertotablelayers.php');

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
 
      <title>Document</title>
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
                <form action="newprojet.php" method="post">
                    <h3 class="m-5">Nouveau projet</h3>
                    <div class="mx-5 px-5">
                        <label for="namep" class="m-3">Nom du projet <span class="text-danger">*</span></label>
                    <input type="text" name="namep" class="m-3 px-4" id="namep">
                    <?php

                        foreach($result as $res){
                           echo '<div class="form-check">';
                                echo '<input class="form-check-input m-3 " type="checkbox" name="'. $res['f_table_name'].'" value="'. $res['f_table_name'].'" id="'. $res['f_table_name'].'">';
                                echo '<label class="form-check-label m-3 " for="'. $res['f_table_name'].'">'. $res['f_table_name'].'</label>';
                            echo '</div>';
                            $couchdb[]=$res['f_table_name'];
                        }

                    ?>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form4Example3">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="form4Example3" name="desc" rows="4"></textarea>
                    </div>
                    <div class="text-warning my-3 border ">Obligatoirement vous devez publier les couches avant d'appuyer sur le button creer</div>
                    <button class="btn bg-primary "><a href="http://localhost/geoserver/web/wicket/bookmarkable/org.geoserver.web.data.layer.NewLayerPage?7" class="text-light nav-link" target="_blank">publier les couches</a></button></br>
                    <div class="form-check form-switch  my-3">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Partger avec le public</label>
                        <input class="form-check-input mx-3" type="checkbox" value="parpub"  name="parpub" id="flexSwitchCheckDefault">
                    </div>
                    <div class="text-center">
                        <div class="err text-danger"></div>
                        <div class="noerr text-success"></div>
                        <button class="btn bg-primary text-light" name="creerp">creer</button>
                    </div>
                    </div>
                </form>
                

            
            </div>
                
        </div>
   
</body>
</html>


<?php

if(isset($_POST['creerp'])){

    

    $namep=$_POST['namep'];
    $desc=$_POST['desc'];
    

   $layernamet=[];
    for($d=0;$d<count($couchdb);$d++){
        if(isset($_POST[$couchdb[$d]])){
            $layernamet[]=$couchdb[$d];
        }
    }

      
    


    if(isset($_POST['parpub'])){
        $parpub=1;
    }else{
        $parpub=0;
    }

    $sql = 'select f_table_name from geometry_columns';
    $result = $con->query($sql);
 

    if(empty($namep) || empty($desc)){
        echo "<script>document.querySelector('.err').textContent='remplir le nom du projet'</script>";
    }else{
        $sqlcouch='select * from layers';
        $couch = $con->query($sqlcouch);
       
        
        
        foreach($result as $res){
            $find=false;
            foreach($couch as $rescouch){
              if($res['f_table_name']==$rescouch['layername']){
                $find=true;
                break;
              }
            }
            if($find==false){
                $s = "INSERT INTO layers (layername) VALUES (?)";
                $stmt= $con->prepare($s);
                $stmt->execute([$res['f_table_name']]);
            }
        
        }



        
        $cn =$_SESSION["cni"];
        $a = "SELECT numuser FROM users WHERE cni ='$cn' ;";

        $b= $con->query($a);
        $bb = $b->fetch();

        $sqltime = 'select CURRENT_TIMESTAMP';
        $noww= $con->query($sqltime);
        $now= $noww->fetch();


        $sqlp = "INSERT INTO projects (projectname, datecreer, partager, numuser, description) VALUES (?,?,?,?,?)";
        $proj= $con->prepare($sqlp);
        $proj->execute([$namep,$now[0],$parpub,$bb[0], $desc]);

        $getprojectid = "SELECT idproject FROM projects WHERE idproject=(SELECT max(idproject) FROM projects);";
        $idprojecc= $con->query($getprojectid);
        $idprojec= $idprojecc->fetch();
    

        //get idlayers for this new project

        for($j=0;$j<count($layernamet);$j++){

            $getlayerid = "SELECT idlayer FROM layers WHERE layername='$layernamet[$j]';";
            $idlayy= $con->query($getlayerid);
            $idlay = $idlayy->fetch();
           

            $sqlpl = "INSERT INTO layerproject (idlayer, idproject) VALUES (?,?)";
            $projpl= $con->prepare($sqlpl);
            $projpl->execute([$idlay[0],$idprojec[0]]);
            
        }
        if($parpub==1){
            echo "<script> window.location.href='projetspartager.php';</script>";
        }else{
            echo "<script> window.location.href='projetsnonpartager.php';</script>";

        }
        
      

    }
}


?>

