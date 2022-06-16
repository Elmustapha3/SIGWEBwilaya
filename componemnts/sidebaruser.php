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
<style>
.hig{
    height: 100vh;
}

</style>
<body>
    <div class="">
        <div class="list-group ">
            <form action="" method="post"> 
            <p  class="list-group-item list-group-item-action active h3">
                configuration</p>
            
                <a href="projetsnonpartager.php" class="list-group-item list-group-item-action">Liste des projets non partagers</a>
                <a href="mesprojets.php" class="list-group-item list-group-item-action">Mes projets</a>
                <a href="setting.php?cni=<?php echo $_SESSION['cni']; ?>" class="list-group-item list-group-item-action">Nouveau projet</a>
                <a href="setting.php?cni=<?php echo $_SESSION['cni']; ?>" class="list-group-item list-group-item-action">Settings</a>
                <button class="btn text-start w-100 border" name="log">Se déconnecter</button>
            </form>
        </div>
    </div>
</body>
</html>



<?php
if(isset($_POST['log'])){
  
  session_unset();
  session_destroy();
  echo "<script> window.location.href='index.php';</script>";
}


?>