
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
 h6{
  font-size: 1.2em !important; /* 30px/16=1.875em */
 }
 a:hover{
  background-color:grey !important;
  border-radius:10px;
 }
 nav li img {
  margin-left:20px !important;
 }
  </style>
<body>
<nav class="navbar navbar-expand-lg bgdark navbar-dark ">
              <div class="container-fluid">
              <a href="index.php" class="nav-brand"><img src="images/ms.png" class="ml-3 mb-2" alt="" width="35" height="20"></a>
                <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto  ">
                    <li>
                      <a class="nav-link active text-light  " aria-current="page" href="index.php"><h6>Accueil</h6></a>
                    </li>
                    <li class="nav-item">
                        <img src="images/word.png" class="mt-2 ml-3" alt="" width="20" height="20">
                     </li>
                    <li class="nav-item" >
                      <a class="nav-link active  " aria-current="page" href="#map"><h6>Carte</h6></a>
                    </li>
                    <?php 
                     if(isset($_SESSION['username'])){ ?>
                     <li class="nav-item">
                        <img src="images/espace.png" class="mt-2 ml-3" alt="" width="20" height="20">
                     </li>
                    <li class="nav-item">
                      <a class="nav-link  px-2 active" href="alllayers.php"><h6>Espace d'administration</h6></a>
                    </li>
                    <?php }?>
                    <li class="nav-item">
                        <img src="images/pc.png" class="mt-2 ml-3" alt="" width="20" height="20">
                     </li>
                    <li class="nav-item">
                        <a class="nav-link active text-light px-2 "  aria-current="page" href="apropos.php"><h6>A propos</h6></a>
                    </li>
                  </ul>
                  <?php
            echo '<div class="d-flex"><h6 class="text-white m-2">'.$username.'</h6>';
            if(isset($_SESSION['username'])){
            ?> 
                  <div class="btn-group">
                      <form action="navbar.php" method="post">
                          <img src="images/user.png" class=" dropdown-toggle  " width="40" height="40" data-bs-toggle="dropdown" aria-expanded="false"></img>
                          <ul class="dropdown-menu dropdown-menu-lg-end  ">
                            <li><a href="setting.php?cni=<?php echo $_SESSION['cni']; ?>" class="dropdown-item" type="button">Profil</a></li>
                            <li><a  href="componemnts/log.php" class="dropdown-item" >Se déconnecter</a></li>
                          </ul>
                      </form>
                  </div>
              <?php } ?>                    
                  </div>
                </div>
              
              </div>
            </nav>
  
            
        
</body>
</html>

