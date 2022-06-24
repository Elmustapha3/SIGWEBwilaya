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
     <div class="d-sm-flex  ">
            <?php
            include("componemnts/sidebaradmin.php");
            ?>
            <div class="  container px-5 mx-5 w-50">
                <form action="" method="post">
                    <h3 class="m-4 mx-5 px-4">Les informations d'utilisateur :</h3>
                    <table class="table">
                        <tr>
                            <td class=" text-center"><lable class=" " for="">CNI : <span class="text-danger">*</span> </label></td>
                            <td><input type="text" class="p-1 px-3 my-2" id="" name="cni" placeholder="Saisie le CNI"/></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="">Prenom : <span class="text-danger">*</span> </label></td>
                            <td><input type="text" class="p-1 px-3 my-2" id="" name="prenom" placeholder="Saisie le prenom"/></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="nom">Nom : <span class="text-danger">*</span> </label></td>
                            <td><input type="text" class="p-1 px-3 my-2" id="nom" name="nom" placeholder="Saisie le nom"/></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class="" for="email">Email :</label></td>
                            <td><input type="email" class="p-1 px-3 my-2" id="email" name="email" placeholder="Saisie l'email"/></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="">Post de travail : <span class="text-danger">*</span> </label></td>
                            <td>
                                <SELECT class="p-1 px-4 my-2" name="workpost" size="1">
                                    <option value="" >choisir un poste</option>
                                    <?php 
                                    $postsql = 'select * from post_travail';
                                    $postdb= $con->query($postsql);
                                    foreach($postdb as $rowp){
                                    echo '<option value="'.$rowp['postravail'].'" >'.$rowp['postravail'].'</option>' ;
                                    }
                                    ?>
                                </SELECT>
                            </td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="usertype">Type d'utilisateur : <span class="text-danger">*</span> </label></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="usertype" id="flexRadioDefault1" value="admin">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Admin
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="usertype" id="flexRadioDefault2" value="user" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Utilisateur
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="password">Mot de passe <span class="text-danger">*</span> </label></td>
                            <td><input type="password" class="p-1 px-3 my-2" id="password" name="password" placeholder="Saisie un mot de passe"/></td>
                        </tr>
                    </table>
                    <h3 class="m-4 mx-5 px-4 ">les droits d'acces pour l'utilisateur : <span class="text-danger">*</span> </h3>
                        <div class="container mx-5 px-5">
                            <div class="form-check form-switch  my-3">
                                <label class="form-check-label" for="flexSwitchCheckDefaulta">Partager les couches</label>
                                <input class="form-check-input mx-3" type="checkbox" value="partager"  name="partager" id="flexSwitchCheckDefaulta">
                            </div>
                            <div class="form-check form-switch  my-3">
                                <label class="form-check-label" for="flexSwitchCheckDefaultb">Modifier les métadonnée des couches</label>
                                <input class="form-check-input mx-3" type="checkbox" value="modifier"  name="modifier" id="flexSwitchCheckDefaultb">
                            </div>
                            <div class="form-check form-switch  my-3"> 
                                <label class="form-check-label" for="flexSwitchCheckDefaultc">Supprimer les couches</label>
                                <input class="form-check-input mx-3" type="checkbox"  value="supprimer" name="supp" id="flexSwitchCheckDefaultc">
                            </div>
                            <!--<div class="form-check form-switch  my-3"> 
                                <label class="form-check-label" for="flexSwitchCheckDefault">modifier les métadonnée des couches</label>
                                <input class="form-check-input mx-3" type="checkbox"  value="supprimer" name="supp" id="flexSwitchCheckDefault">
                            </div>-->
                            <div class="form-check form-switch  my-3"> 
                                <label class="form-check-label" for="flexSwitchCheckDefaultd">Voir la liste des couches non partages</label>
                                <input class="form-check-input mx-3" type="checkbox"  value="voirnonpartager" name="voirnonpartager" id="flexSwitchCheckDefaultd">
                            </div>
                        </div>
                        <div class="err text-center text-danger h5"></div>
                        <div class="yes text-center h5 text-success"></div>
                        <div class="text-center">
                            <a href="administrerUser.php" class="btn bg-primary text-light px-4 my-3">Annuler</a>
                            <input type="submit" class="px-5 my-3 bg-primary btn text-light" value="Creer" name="creer"/>
                        </div>
                        
                </form>
            </div>
        </div>
    
    <?php
    include('componemnts/footer.php');
    ?>
</body>
</html>

<?php

           

    if(isset($_POST['creer'])){

        $cni = $_POST['cni'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];  
        $post = $_POST['workpost'];
        $password = $_POST['password'];
           

               

            
   if(empty($cni) || empty($prenom) || empty($nom) || empty($post) || empty($_POST['usertype']) || empty($password)){
        echo '<script>document.querySelector(".err").textContent=" vous devez remplir tout les champs !!"</script>';
    }else{
            
        $postsql2 = 'select * from post_travail';
        $postdb2= $con->query($postsql2);
            foreach($postdb2 as $rowps){
                if($post==$rowps['postravail']){
                    $idposts= $rowps['idpost'];
            }
            }


            if($_POST['usertype']=='admin'){
                    $idtypes=1;
           }else{
                $idtypes=2;
            }
            if(isset($_POST['partager'])){
                $perpar=1;
            }else{
                $perpar=0;
            }
            if(isset($_POST['modifier'])){
                $permod=1;
            }else{
                $permod=0;
            }if(isset($_POST['supprimer'])){
                $persup=1;
            }else{
                $persup=0;
            }
            if(isset($_POST['voirnonpartager'])){
                $pervoi=1;
            }else{
                $pervoi=0;
            }

           
        

            $sql = "INSERT INTO users (cni, prenom, nom,email,username,password,idtype,idpost,partager,modifierdesc,supprimer,voirlayernonpartager) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt= $con->prepare($sql);
            $stmt->execute([$cni, $prenom, $nom ,$email, $nom, $password,$idtypes, $idposts,$perpar,$permod,$persup,$pervoi]);
            echo "<script> window.location.href='administrerUser.php';</script>";


    }
}

?>
