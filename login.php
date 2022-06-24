    <?php
        session_start();
        if(isset($_SESSION['username'])){
        header('location:index.php');
        }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <form action="login.php" method="post">
               <h3 class="mb-5">Sign in</h3>

                <div class="form-outline mb-4">
                  <input type="text" id="typeEmailX-2" placeholder="username" class="form-control form-control-lg" name="usern"/>
                  
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="typePasswordX-2" placeholder="password" class="form-control form-control-lg" name="passwords"/>
                </div>
                <p class="err text-danger"></p><br>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-start mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="form1Example3"  />
                  <label class="form-check-label" for="form1Example3"> Remember password </label>
                  <a href="#" class="link mx-5">forget password</a>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>
                <a href="index.php"><button class="btn btn-primary btn-lg btn-block" name="annuler" >Annuler</button></a>
            </form>

           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>


<?php
 include('database/connexion.php');
    
 if(isset($_POST["login"])){

    $sql = "select a.numuser, a.username,a.password,a.partager, a.modifier, a.modifierdesc, a.supprimer, a.voirlayernonpartager, b.type,a.cni from users a, typeuser b where a.idtype=b.idtype;";
    $user= $con->query($sql);

    foreach($user as $row){
    
  if(empty($_POST["usern"]) || empty($_POST["passwords"])){
     echo '<script>document.querySelector(".err").textContent="remplir tout les champs"</script>';
  }elseif($_POST["usern"]==$row['username'] && $_POST["passwords"]==$row['password']  && $row['type']=='admin'){
    session_start();
    $_SESSION['numuser']=$row['numuser'];
    $_SESSION['username']=$_POST["usern"];
    $_SESSION['typeuser']='admin';
    $_SESSION['cni']=$row['cni'];
    $_SESSION['modifierdesc']=$row['modifierdesc'];
    $_SESSION['modifiertable']=$row['modifier'];
    $_SESSION['supprimercouche']=$row['supprimer'];
    $_SESSION['partagercouche']=$row['partager'];
    $_SESSION['voirlayernonpartager']=$row['voirlayernonpartager'];
    header("location:index.php");
  }elseif($_POST["usern"]==$row['username'] && $_POST["passwords"]==$row['password']  && $row['type']=='normalUser'){
    session_start();
    $_SESSION['numuser']=$row['numuser'];
    $_SESSION['username']=$_POST["usern"];
    $_SESSION['typeuser']='normaluser';
    $_SESSION['cni']=$row['cni'];
    $_SESSION['modifierdesc']=$row['modifierdesc'];
    $_SESSION['modifiertable']=$row['modifier'];
    $_SESSION['supprimercouche']=$row['supprimer'];
    $_SESSION['partagercouche']=$row['partager'];
    $_SESSION['voirlayernonpartager']=$row['voirlayernonpartager'];
    echo '<script> window.location.href="index.php";</script>';
  }else{
    echo '<script>document.querySelector(".err").textContent="email ou le mot de passe est incorrect"</script>';
  }
}
  
    }
    if(isset($_POST["annuler"])){
    header("location:index.php");
  }

?>