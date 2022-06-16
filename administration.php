<?php
include('database/connexion.php');
session_start();
if(!isset($_SESSION['username'])){
  header('location:index.php');
}

  $username=$_SESSION['username'];
  if($_SESSION['typeuser']=='normaluser'){
      header('location:mesprojets.php');
  
}
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
    include("componemnts/navbaradmin.php");
    ?>

    <div class="d-flex">
    <?php
    include("componemnts/sidebaradmin.php");
    include("Allprojects.php");
    ?>
  
    </div>
  
    
   <!-- <div class="d-flex align-items-start">
       
          <div class="nav flex-column nav-pills me-3 w-25" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <form action="administration.php" method="post"> <a href="#" class="nav-link " id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home"  role="tab" aria-controls="v-pills-home" aria-selected="true">tous les projets</a>
            <p class="mx-2 text-success ">System</p>
            <a href="#" class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"  role="tab" aria-controls="v-pills-profile" aria-selected="false">les utilisateurs</a>
            <a href="#" class="nav-link" id="v-pills-creer-tab" data-bs-toggle="pill" data-bs-target="#v-pills-creer"  role="tab" aria-controls="v-pills-creer" aria-selected="false">Nouveau utilisateur</a>
            <a href="#" class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings"  role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            <button class="btn bg-light text-start " name="log">Logout</button>
          </form></div>
        
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0"><?php include("Allprojects.php"); ?></div>
          <div class="tab-pane fade ml-5" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0"><?php include('administration/administrerUser.php'); ?></div>
          <div class="tab-pane fade mx-sm-5 px-sm-5" id="v-pills-creer" role="tabpanel" aria-labelledby="v-pills-creer-tab" tabindex="0"><?php include('adduser.php'); ?></div>
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
        </div>
      </div>-->

</body>
</html>


