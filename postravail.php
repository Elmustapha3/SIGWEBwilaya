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
    $sql = 'select * from post_travail;';
    $postra= $con->query($sql);
    $i=1;
    $a=''; $b=''; $c='';$d=''; $e=''; $f='activ'; $g="";
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


      <title>Poste de travail</title>
</head>
<body>

    <?php
        include("componemnts/topbar.php");
        include("componemnts/navbaradmin.php");
    ?>
    <div class="d-sm-flex">
        <?php
        include("componemnts/sidebaradmin.php");
        ?>
        <div class="container">
            <form action="administrerUser.php" method="post">
                <h2 class="p-3">Les postes de tavail :</h2>
                <div class="form-outline mx-3 my-1">
                    <input type="search" id="search" class="form-control"  onkeyup="myFunction()" placeholder="Chercher ici..." />
                </div>
                <div class="mx-4">
                <table class="table table-striped text-center" id="layerstable">
                        <thead>
                            <tr>
                            <th scope="col">Numero</th>
                            <th scope="col">Poste de travail</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($postra as $row){
                                
                            echo '<tr>';
                                echo '<th class="p-2 px-3" scope="row">'.$i.'</th>';
                                echo '<td class="p-2 px-3 h6">'.$row['postravail'].'</td>';
                                //echo '<td class="p-2 px-3"><button class="btn btn-success" name="modifyuser"><a href="update.php?cni='.$row['cni'].'" class="text-light nav-link">Modifier</a></button></td>';
                                echo '<td class="p-2 px-3"><button class="btn bg-danger " name="deleteuser" ><a class="text-light nav-link" href="database/delete.php?idpost='.$row['idpost'].'">Supprimer</a></button></td>';
                            
                            echo '</tr>';
                                $i++;
                            }?>
                        </tbody>
                    </table>
                    <div class="container m-5">
                        <button class="btn bg-secondary"><a href="addpost.php" class="nav-link text-light">Nouveau poste de travail</a></button>
                    </div>
                    </div>
        </form>
   </div>
  
    </div>
        <?php
            include("footer.php");
        ?>
    <script src="JS/search.js"></script>

</body>
</html>


