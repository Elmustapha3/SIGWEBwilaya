<?php
        session_start();
        $a=''; $b=''; $c='';$d=''; $e=''; $d="";$f='activ';$g=""; 

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
    <link rel="shortcut icon" href="resources/images/logorm.png">
    <link href="sss.css" rel="stylesheet" >

 
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
                        <td class="p-3 h6"><label for="addpost">Saisir un nouveau poste de travail : </label></td>
                        <td class="p-3" ><input type="text" class="form-control " name="newpost" id="" placeholder='nouveau poste'></td>
                    </tr>
                </table>
                <div class="p-3 text-center">
                    <a href="postravail.php" class="btn bg-secondary text-light">Annuler</a>
                    <button class=" btn bg-secondary text-light" name="ajouter">Ajouter</button>
                </div>

            </form>
            </div>
            
            
    </div>
    
    <?php
    include('footer.php');
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
