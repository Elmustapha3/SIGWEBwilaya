<?php

try{
    $con = new PDO("pgsql:host=localhost;dbname=SIGMarrakech-safi","postgres","y487sql");
  
}catch(PDOException $e){
    echo $e->getMessage();
}
?>