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
    $sql = 'select cni, prenom, nom , partager, modifierdesc, supprimer, voirlayernonpartager from users ;';
    $user= $con->query($sql);
    $i=1;
    $a=''; $b=''; $c='';$d=''; $e='activ'; $d="";$f='';$g=""; 
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

      <title>Les droits d'acces</title>
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
                <h2 class="p-3">Les utilisateurs et les droits d'accés :</h2>
                <div class="form-outline mx-3 my-1">
                    <input type="search" id="search" class="form-control"  onkeyup="myFunction()" placeholder="Chercher ici..." />
                </div>
                <div class="mx-4">
                <table class="table table-striped text-center" id="layerstable">
                        <thead>
                            <tr>
                            <th scope="col">Numéro</th>
                            <th scope="col">CNI</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">droit de partage</th>
                            <th scope="col">droit de modification des métadonnées</th>
                            <th scope="col">droit de suppression</th>
                            <th scope="col">droit de visualisation des couches non partagées</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php foreach($user as $row){
                                if($row['partager']==1){$row['partager']='Oui'; }else{$row['partager']='Non';}
                                if($row['modifierdesc']==1){$row['modifierdesc']='Oui'; }else{$row['modifierdesc']='Non';}
                                if($row['supprimer']==1){$row['supprimer']='Oui'; }else{$row['supprimer']='Non';} 
                                if($row['voirlayernonpartager']==1){$row['voirlayernonpartager']='Oui'; }else{$row['voirlayernonpartager']='Non';} 


                                
                                
                            echo '<tr>';
                                echo '<th class="p-2 px-3" scope="row">'.$i.'</th>';
                                echo '<td class="p-2 px-3 h6" >'.$row['cni'].'</td>';
                                echo '<td class="p-2 px-3 h6">'.$row['prenom'].'</td>';
                                echo '<td class="p-2 px-3 h6">'.$row['nom'].'</td>';
                                echo '<td class="p-2 px-3 h6">'.$row['partager'].'</td>';
                                echo '<td class="p-2 px-3 h6">'.$row['modifierdesc'].'</td>';
                                echo '<td class="p-2 px-3 h6">'.$row['supprimer'].'</td>';
                                echo '<td class="p-2 px-3 h6">'.$row['voirlayernonpartager'].'</td>';
                                echo '<td class="p-2 px-3"><button class="btn btn-success" name="modifyuser"><a href="updatepermission.php?cni='.$row['cni'].'" class="text-light nav-link">Modifier</a></button></td>';
                            
                            echo '</tr>';
                                $i++;
                            }?>
                        </tbody>
                    </table>
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


