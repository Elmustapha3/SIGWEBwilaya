<?php
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    $username='<a href="login.php" class="nav-link">Connexion</a>';
  
}else{
    $username=$_SESSION['username'];
    if($_SESSION['typeuser']=='admin'){
        header('location:administration.php');
    }
}


include('database/connexion.php');
// $sql = "select * projets d'un user specifier;";
 //$user= $con->query($sql);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
 
      <title>Document</title>
</head>
<body>
    <?php
    
        include("componemnts/topbar.php");
        include("componemnts/navbar.php");
    ?>
    <div class="d-sm-flex">
        <?php include("componemnts/sidebaruser.php"); ?>
        <div class="container">
    <div class="container">
        <h2 class="p-3"> Mes projets  :</h2>
        <div class="container">
            <div class="row my-3">
                <?php  //foreach($user as $proj) { ?>
                <div class="col-sm my-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div> 
                <div class="col-sm my-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div> 
                <div class="col-sm my-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
A                        </div>
                    </div>
                </div>
                <?php //}?>                  
            </div>
        </div>
    </div>
    </div>
    </div>
    

    <?php
        include("componemnts/footer.php");
    ?>
            
</body>
</html>