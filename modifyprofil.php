<?php
    session_start();
      if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
        

        if(isset($_GET['cni'])){
            $_SESSION['codeid'] = $_GET['cni'];
        }
    }

    include('database/connexion.php');
    $sql = 'select a.prenom,a.nom ,a.email,a.cni,a.username, a.password,b.postravail from users a,post_travail b where a.idpost=b.idpost ;';
    $result = $con->query($sql);
   
foreach($result as $res){
    if($res['cni']== $_SESSION['codeid']){
  

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
        if($_SESSION['typeuser']=='admin'){
            include("componemnts/navbaradmin.php");
            }else{
                include("componemnts/navbar.php");
            }
        ?>
        <div class="d-sm-flex">
            <?php
             if($_SESSION['typeuser']=='admin'){
                include("componemnts/sidebaradmin.php");
            }else{
                    include("componemnts/sidebaruser.php");
                }
        ?>
        <div class="container mx-5 px-5">
            <form action="modifyprofil.php" method="post">
                <h2 class="p-3">Vos informations :</h2>
                <div class="mx-4">
                <table class=" table-striped  table ">
                    <tbody>
                    
                        <tr>
                            <td  class=" text-center"><lable class=" " for="">Prenom :  </label></td>
                            <td><input type="text" class="p-1 px-3 my-2" id="" name="prenom" value="<?php echo $res['prenom'] ;?>"</td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="nom">Nom :  </label></td>
                            <td><input type="text" class="p-1 px-3 my-2" id="" name="nom" value="<?php echo $res['nom'] ;?>"</td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class="" for="email">Email :</label></td>
                            <td><input type="email" class="p-1 px-3 my-2" id="" name="email"  value="<?php echo $res['email'] ;?>"</td>
                        </tr>
                        
                        <tr>
                            <td  class=" text-center"><lable class=" " for="password">Nom d'utilisateur </label></td>
                            <td><input type="text" class="p-1 px-3 my-2" id="" name="username"  value="<?php echo $res['username'] ;?>"</td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="password">Mot de passe  </label></td>
                            <td><input type="password" class="p-1 px-3 my-2" id="" name="password"  value="<?php echo $res['password'] ;?>"</td>
                        </tr>
                    </tbody>
                </table>
                <div class="err text-danger text-center my-3"></div>
                <div class="text-center my-4">
                    <a href="setting.php" class="btn bg-primary text-light" >Annuler</a>
                    <button class="btn bg-primary text-light" name="updatesetting" >Modifier</button>

                </div>
                
                </div>
        </form>
   </div>
  
    </div>
   
</body>
</html>

<?php
    }}
           

    if(isset($_POST['updatesetting'])){

        
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];  
        $password = $_POST['password'];
        $username= $_POST['username'];
           

               

            
   if( empty($prenom) || empty($nom)  || empty($password) || empty($username)){
        echo '<script>document.querySelector(".err").textContent=" vous devez remplir tout les champs !!"</script>';
    }else{
            
            $sql = "update users set  prenom = ?, nom = ?,email = ?,username = ?,password = ? where cni = ?;";
            $stmt= $con->prepare($sql);
            $stmt->execute([ $prenom, $nom ,$email, $username, $password,$_SESSION['codeid']]);
            echo "<script> window.location.href='setting.php';</script>";


    }
}

?>

