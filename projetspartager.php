<?php
session_start();

if(isset($_SESSION['username'])){
  $username=$_SESSION['username'];
}else{
  $username='<a href="login.php" class="nav-link">Connexion</a>';
}


include('database/connexion.php');
 $sql = "select * from projects where partager=true ;";
 $projpar= $con->query($sql);

 

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="css.css" rel="stylesheet" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
 
      <title>Projets partages</title>
</head>
<body>
    <?php
    
    include("componemnts/topbar.php");
    if(isset($_SESSION['username'])){
      if($_SESSION['typeuser']=='admin'){
        include("componemnts/navbaradmin.php");
        }else{
          include("componemnts/navbar.php");
        }
    }else{
            include("componemnts/navbar.php");
        }
    ?>
    <div class="d-sm-flex">
        <?php
        if(isset($_SESSION['username'])){
         if($_SESSION['typeuser']=='admin'){
            include("componemnts/sidebaradmin.php");
        }elseif($_SESSION['typeuser']=='normaluser'){
                include("componemnts/sidebaruser.php");
            }
              
            }
        ?>
        <div class="container">
          <h2 class="p-3"> Les projets   :</h2>
            <div class="row my-3">
                <?php  foreach($projpar as $proj) { 
                   $sqluser = "select * from users where numuser = ?";
                   $owner= $con->prepare($sqluser);
                   $owner->execute([$proj['numuser']]);
                   foreach($owner as $own){
                  ?>
                <div class="col-sm my-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $proj['projectname']; ?></h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="proj.php?idproject=<?php echo $proj['idproject']; ?>" class="btn btn-primary">Visuliser le projet</a>
                            <p class="">projet creer en :<?php echo $proj['datecreer'];  ?></p>
                            <p class="">par :<?php echo $own['prenom'].' '.$own['nom'].'  CNI :'.$own['cni'] ;  ?></p>
                        </div>
                    </div>
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