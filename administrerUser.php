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
    $a=''; $b=''; $c='';$d='activ'; $e='';$f=''; $g="";
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
                <div class="form-outline mx-3 my-1">
                    <input type="search" id="search" class="form-control"  onkeyup="myFunction()" placeholder="Chercher ici..." />
                </div>
                <div class="mx-4">
                    <div class="text-end">
                        <button class="btn bg-secondary "><a href="adduser.php" class="nav-link text-light">Nouveau utilisateur</a></button>
                    </div>

                <table id="layerstable" class="table table-striped text-center" >
                            <tr>
                                <th scope="col">Numéro</th>
                                <th scope="col">CNI</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Poste de travail</th>
                            </tr>
                    

                            <?php foreach($user as $row){ ?>
                                
                           <tr>
                                <th class="p-2 px-3" scope="row"><?php echo $i;?></th>
                                <td class="p-2 px-3" ><?php echo $row['cni'];?></td>
                                <td class="p-2 px-3"><?php echo $row['prenom'];?></th>
                                <td class="p-2 px-3"><?php echo $row['nom'];?></th>
                                <td class="p-2 px-3"><?php echo $row['email'];?></td>
                                <td class="p-2 px-3"><?php echo $row['postravail'];?></td>
                                <td class="p-2 px-3"><button class="btn btn-success" name="modifyuser"><a href="update.php?cni=<?php echo $row['cni'];?>" class="text-light nav-link">Modifier</a></button></td>
                                <td class="p-2 px-3"><button class="btn bg-danger " name="deleteuser" ><a class="text-light nav-link" href="database/delete.php?cni=<?php echo $row['cni'];?>">Supprimer</a></button></td>
                            
                            </tr>
                                <?php $i++; }?>
                    </table>
                    <button class="btn bg-secondary "><a href="adduser.php" class="nav-link text-light">Nouveau utilisateur</a></button>
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


