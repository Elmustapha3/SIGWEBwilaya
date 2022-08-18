<?php

try{
    $con = new PDO("pgsql:host=localhost;dbname=SIGMarrakech-safi","postgres","wilaya");
  
}catch(PDOException $e){
    echo $e->getMessage();
}
?>