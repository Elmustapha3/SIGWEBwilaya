<?php
session_start();

if(!isset($_SESSION['username'])){
    $username='<a href="login.php" class="nav-link">Connexion</a>';
}else{
    $username=$_SESSION['username'];
}

if(isset($_GET['idlayer'])){
    $idlayer = $_GET['idlayer'];
    }elseif(isset($_SESSION['idlaytableattupdated'])){
        $idlayer=$_SESSION['idlaytableattupdated'];
    }else{
        header('location:alllayers.php');
    }

include('database/connexion.php');

    $sql = "select * FROM layers WHERE idlayer = ? ";
    $stmt= $con->prepare($sql);
    $stmt->execute([$idlayer]);
    foreach($stmt as $lay){
        $layname=$lay['layername'];
    }


    $sql = 'SELECT * FROM public."'.$layname.'" ORDER BY fid ASC';
    $table= $con->query($sql);
    //$table= $con->prepare($sql);
    //$table->execute([$layname]);

    $sqlcolumn = "SELECT column_name  FROM information_schema.columns WHERE table_schema = 'public' AND table_name = '$layname' AND column_name <> 'geom' AND column_name <> 'the_geom' ";
    $col= $con->query($sqlcolumn);
    $result = $col->fetchAll(PDO::FETCH_BOTH);

    

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="sss.css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="resources/images/logorm.png">

      <title><?php echo $layname; ?></title>
</head>
<style>
.over{
    overflow:auto;
}
</style>
<body>
    <?php
    
        include("componemnts/topbar.php");
        if(isset($_SESSION['typeuser'])){
            if($_SESSION['typeuser']=='admin'){
                include("componemnts/navbaradmin.php");
                }else{
                    include("componemnts/navbar.php");
                }
        }else{
            include("componemnts/navbar.php");
        }
        
    ?>
        <h3 class="p-4">La table attributaire de la couche <span class="text-info mx-2"><?php echo $layname;  ?></span> </h3>
        <div class="text-end m-3">
            <?php
                if(isset($_SESSION['numuser'])){
                    if($_SESSION['modifiertable']==true){
                    echo '<a href="updatetableatt.php?idlayer='.$idlayer.'" class="btn btn-primary">Modifier la table</a>';
                    } 
                }
            ?>
            <a href="layer.php?idlayer=<?php echo $idlayer; ?>" class="btn btn-primary">retour</a></br>
        </div>
                   <div class="over">
                        <table class="table table-striped text-center">
                                
                                <?php 
                                echo '<tr>';
                                for($i=0;$i<count($result);$i++){                            
                                        echo '<th class="p-2 px-3" scope="row">'.$result[$i][0].'</th>';
                                    }
                                echo '</tr>';
                                foreach($table as $row){   
                                echo '<tr>';
                                for($i=0;$i<count($result);$i++){                            
                                    echo '<th class="p-2 px-3" scope="row">'.$row[$result[$i][0]].'</th>';
                                }
                                                            
                                echo '</tr>';
                                }

                            
                                    
                                    
                                

                                ?>
                            
                        </table>
                   </div>
    
                   <?php  include('footer.php');?>

            
</body>
</html>