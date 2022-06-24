<?php
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
}else{
    $username=$_SESSION['username'];
}


include('database/connexion.php');
$sql = "select * from projects where partager=false ;";
$projnpar= $con->query($sql);

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
 
      <title>Projet non partages</title>
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
        <div class="container">
          <h2 class="p-3"> Les projets non partages   :</h2>
            <div class="row my-3">
                <?php  foreach($projnpar as $proj) { 
                   $sqluser = "select * from users where numuser = ?";
                   $owner= $con->prepare($sqluser);
                   $owner->execute([$proj['numuser']]);
                   foreach($owner as $own){
                  ?>
                <div class="col-sm my-3">
                    <form action="projetsnonpartager.php" method="post">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $proj['projectname']; ?></h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="proj.php?idproject=<?php echo $proj['idproject']; ?>" class="btn btn-primary">Visuliser le projet</a>
                                <p class="">projet creer en :<?php echo $proj['datecreer'];  ?></p>
                                <p class="">par :<?php echo $own['prenom'].' '.$own['nom'].'  CNI :'.$own['cni'] ;  ?></p>
                                <div class="text-end">
                                    <a href="database/partager.php?idproject=<?php echo $proj['idproject']; ?>" class="btn btn-primary">Partager</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> 
                <?php }}  ?>
            </div>
        </div>
    </div>
    

    <?php
        //include("componemnts/footer.php");
    ?>
            
</body>
</html>



<?php

?>