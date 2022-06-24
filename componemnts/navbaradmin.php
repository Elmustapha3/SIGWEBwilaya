
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
<body>
  
            <nav class="navbar navbar-expand-lg bg-dark text-dark navbar-dark">
              <div class="container-fluid">
              <a class="nav-link active text-light mx-5" aria-current="page" href="index.php">Accueil</a>
                <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#map">Map</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="mylayers.php">Espace administration</a>
                    </li>
                  </ul>
                  <?php
                
                  echo '<div class="d-flex"><h5 class="text-white m-2">'.$username.'</h5>';
                      if(isset($_SESSION['username'])){ ?>
                         <div class="btn-group">
                          
                          <img src="images/ic.png" class="btn btn-secondary dropdown-toggle rounded-5 bg-dark" width="50" height="40" data-bs-toggle="dropdown" aria-expanded="false">                </img>
                          <ul class="dropdown-menu dropdown-menu-lg-end  ">
                            <li><a href="setting.php?cni=<?php echo $_SESSION['cni']; ?>" class="dropdown-item" type="button">setting</a></li>
                            <li><a href="componemnts/log.php" class="btn dropdown-item" >logout</a></li>
                          </ul>
                        </div>
                    <?php }?>
                  </div>
                </div>
                
              </div>
            </nav>
        
</body>
</html>

