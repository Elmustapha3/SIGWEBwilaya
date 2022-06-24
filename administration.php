<?php
include('database/connexion.php');
session_start();
if(!isset($_SESSION['username'])){
  header('location:index.php');
}

  $username=$_SESSION['username'];
  if($_SESSION['typeuser']=='normaluser'){
      header('location:mylayers.php');
  
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
    ?>
  
    </div>
  
  

</body>
</html>


