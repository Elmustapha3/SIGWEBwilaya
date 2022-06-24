<?php
        session_start();
        if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
            if($_SESSION['typeuser']=='normaluser'){
                header('location:mesprojets.php');
            }
        }
  include('database/connexion.php');
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
    include('componemnts/topbar.php');
    include('componemnts/navbaradmin.php');
    ?>
    <div class="d-sm-flex   ">
            <?php
            include("componemnts/sidebaradmin.php");
            ?>
            <div class="container m-5">
            <form action="addpost.php" method="post">
                <table>
                    <tr class="mx-5">
                        <td class="p-3"><label for="addpost">Saisie le nouveau post de travail : </label></td>
                        <td class="p-3" ><input type="text" class="" name="newpost" id="" placeholder='nouveau post'></td>
                        <td class="p-3"><button class=" btn bg-primary text-light" name="ajouter">Ajouter</button></td>
                    </tr>
                </table>
                
            </form>
            </div>
            
            
    </div>
    
    <?php
    //include('componemnts/footer.php');
    ?>
</body>
</html>

<?php

           

    if(isset($_POST['ajouter'])){

       $newpost = $_POST['newpost'];
           

               

            
   if(empty($newpost)){
        echo '<script>document.querySelector(".err").textContent=" vous devez remplir tout les champs !!"</script>';
    }else{
            
            $sql = "INSERT INTO post_travail (postravail) VALUES (?)";
            $stmt= $con->prepare($sql);
            $stmt->execute([$newpost]);
            echo "<script> window.location.href='postravail.php';</script>";


    }
}

?>
