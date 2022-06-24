<?php

        include('database/connexion.php');
        $sql = 'select f_table_name from geometry_columns';
        $result = $con->query($sql);
        
        $sqlcouch='select * from layers';
        $couch = $con->query($sqlcouch);
       
        
        
        foreach($result as $res){
            $find=false;
            foreach($couch as $rescouch){
              if($res['f_table_name']==$rescouch['layername']){
                $find=true;
                break;
              }
            }
            if($find==false){
                $s = "INSERT INTO layers (layername) VALUES (?)";
                $stmt= $con->prepare($s);
                $stmt->execute([$res['f_table_name']]);
            }
        
        }



?>