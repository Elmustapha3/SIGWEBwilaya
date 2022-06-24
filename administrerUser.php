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
    $sql = 'select a.prenom,a.nom ,a.email,a.cni,b.postravail from users a,post_travail b where a.idpost=b.idpost;';
    $user= $con->query($sql);
    $i=1;
    $a=''; $b=''; $c='';$d='activ'; $e='';$f=''; 
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
        include("componemnts/navbaradmin.php");
    ?>
    <div class="d-sm-flex">
        <?php
        include("componemnts/sidebaradmin.php");
        ?>
        <div class="container">
            <form action="administrerUser.php" method="post">
                <h2 class="p-3">Les utilisateurs :</h2>
                <div class="mx-4">
                <table class="table table-striped text-center">
                        <thead>
                            <tr>
                            <th scope="col">nunero</th>
                            <th scope="col">CNI</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Poste de travail</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($user as $row){
                                
                            echo '<tr>';
                                echo '<th class="p-2 px-3" scope="row">'.$i.'</th>';
                                echo '<td class="p-2 px-3" >'.$row['cni'].'</td>';
                                echo '<td class="p-2 px-3">'.$row['prenom'].'</td>';
                                echo '<td class="p-2 px-3">'.$row['nom'].'</td>';
                                echo '<td class="p-2 px-3">'.$row['email'].'</td>';
                                echo '<td class="p-2 px-3">'.$row['postravail'].'</td>';
                                echo '<td class="p-2 px-3"><button class="btn btn-success" name="modifyuser"><a href="update.php?cni='.$row['cni'].'" class="text-light nav-link">Modifier</a></button></td>';
                                echo '<td class="p-2 px-3"><button class="btn bg-danger " name="deleteuser" ><a class="text-light nav-link" href="database/delete.php?cni='.$row['cni'].'">Supprimer</a></button></td>';
                            
                            echo '</tr>';
                                $i++;
                            }?>
                        </tbody>
                    </table>
                    <button class="btn bg-primary "><a href="adduser.php" class="nav-link text-light">Nouveau utilisateur</a></button>
                    </div>
        </form>
   </div>
  
    </div>
   
</body>
</html>


