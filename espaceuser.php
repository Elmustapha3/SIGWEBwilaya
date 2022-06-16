<?php
session_start();
if(!isset($_SESSION['username'])){
  header('location:index.php');
}else{
    $username=$_SESSION['username'];
    if($_SESSION['typeuser']=='admin'){
      header('location:administration.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">
    
    <title>Document</title>
</head>
<body>
<?php
    include('database/connexion.php');
    include("componemnts/topbar.php");
    
    include("componemnts/navbar.php");
    ?>
    
    

    <?php
    include("componemnts/footer.php");
   
    if(isset($_POST['log'])){

  
        session_unset();
        session_destroy();
        echo "<script> window.location.href='index.php';</script>";
      }



?>
 
</body>
</html>