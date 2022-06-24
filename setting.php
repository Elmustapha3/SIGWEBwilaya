<?php
    session_start();
      if(!isset($_SESSION['username'])){
        header('location:index.php');
        }else{
            $username=$_SESSION['username'];
             if(isset($_GET['cni'])){
                $codeid=$_GET['cni'];
             }elseif(isset($_SESSION['codeid'])){
                $codeid=$_SESSION['codeid'];
             }

      
    }
    include('database/connexion.php');
    $sql = 'select a.prenom,a.nom ,a.email,a.cni,a.username, a.password,b.postravail from users a,post_travail b where a.idpost=b.idpost ;';
    $result = $con->query($sql);

$a=''; $b=''; $c='activ';$d=''; $e=''; $d="";$f=''; 

foreach($result as $res){
    if($res['cni']==$codeid){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="css.css" rel="stylesheet" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
 
      <title>Setting</title>
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
            <form action="setting.php" method="post">
                <h2 class="p-3">Vos informations :</h2>
                <div class="mx-4">
                <table class=" table-striped  table ">
                    <tbody>
                    <tr>
                            <td class=" text-center"><lable class=" " for="">CNI :  </label></td>
                            <td><?php echo $res['cni'];?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="">Prenom :  </label></td>
                            <td><?php echo $res['prenom'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="nom">Nom :  </label></td>
                            <td><?php echo $res['nom'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class="" for="email">Email :</label></td>
                            <td><?php echo $res['email'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="">Post de travail :  </label></td>
                            <td><?php echo $res['postravail'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="password">Nom d'utilisateur </label></td>
                            <td><?php echo $res['username'] ;?></td>
                        </tr>
                        <tr>
                            <td  class=" text-center"><lable class=" " for="password">Mot de passe  </label></td>
                            <td><?php echo $res['password'] ;?></td>
                        </tr>
                    </table>
                             
                            
                    </tbody>
                </table>
                <div class="text-center">
                    <button class="btn bg-primary "><a href="modifyprofil.php?cni=<?php echo $codeid; ?>" class="nav-link text-light">Modifier</a></button>
                </div>
            </div>
        </form>
   </div>
  
    </div>
   
</body>
</html>

<?php }}?>