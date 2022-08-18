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
    <link href="sss.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<style>
  @import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
.login-block{
    background: #DE6262;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #FFB88C, #DE6262);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #FFB88C, #DE6262); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
float:left;
width:100%;
padding : 120px 0;
}

.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
.carousel-inner{border-radius:0 10px 10px 0;}
.carousel-caption{text-align:left; left:5%;}
.login-sec{padding: 50px 30px; position:relative;}
.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
.login-sec .copy-text i{color:#FEB58A;}
.login-sec .copy-text a{color:#E36262;}
.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #DE6262;}
.login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
.btn-login{background: #DE6262; color:#fff; font-weight:600;}
.banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
.banner-text h2{color:#fff; font-weight:600;}
.banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
.banner-text p{color:#fff;}
</style>
<body>
<!--
<section class="vh-100 " >
  <div class="container py-5 h-100 ">
    <div class="row d-flex justify-content-center align-items-center h-100 ">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center text-light rounded shadow bg-dark">

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
                <!--
                <div class="form-check d-flex justify-content-start mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="form1Example3"  />
                  <label class="form-check-label" for="form1Example3"> Remember password </label>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>
                <a href="index.php"><button class="btn btn-primary btn-lg btn-block" name="annuler" >Annuler</button></a>
            </form>

   ---->    
   <section class="login-block">
    <div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Connexion</h2>
		    <form action="login.php" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1" class="text-lowercase">Nom d'utilisateur</label>
    <input type="text" class="form-control" placeholder="" name="usern"/>
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="text-lowercase">Mot de passe</label>
    <input type="password" class="form-control" placeholder="" name="passwords"/>
  </div>
  
  
    <div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input">
      <small>Remember Me</small>
    </label>
    <div>
    <button type="submit" class="btn btn-login float-right" name="login">connexion</button>
    <a href="index.php"><button class="btn btn-login float-right" name="annuler" >Annuler</button></a>
</div>
  </div>
  
</form>

		</div>
		<div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                 <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                     
                  </ol>
            <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img class="d-block img-fluid" src="map1.JPG" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>Marrakech-Safi</h2>
            <p>découvrir la région de Marrakech-Safi,synthétiser des données visualiser géographiquement ,des événements en temps réel ou de modélisation,faire une analyse statistique et une historisation des données géographiques sur la région de Marrakech-Safi</p>
        </div>	
  </div>
    </div>
  <div class="carousel-item">
      <img class="d-block img-fluid" src="menara.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
    </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="capture.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
    </div>
  </div>
   </div>	   
		    
		</div>
	</div>
</div>
</section> 
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