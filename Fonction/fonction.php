<?php


   function verif($login){

             $login=htmlentities($login);
             return $login;

   }

   function aleatoire($carac,$nb){
    $code = [];
    $res = '';
 
    $caracteres = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    $nombres = range(0,9);
    $ran= rand(0,100);
 
    shuffle($caracteres);
    shuffle($nombres);
 
    for($i=0;$i<$carac;$i++){
        $code[] = $caracteres[$i];
    }
 
    for($i=0;$i<$nb;$i++){
        $code[] = $nombres[$i];
    }
 
    shuffle($code);
 
    for($i=0;$i<($nb+$carac);$i++){
        $res .= $code[$i];
        
    }
    $res .= $ran;
 
    return $res;
}

function insertDB($sql){
    include("../DB/base.php");
    $mysqli->query($sql)or die(mysqli_error($mysqli));
    $mysqli->close();
   
}


function importeCv($file){
$row = 1;
$tab=array();
    if (($handle = fopen($file, "r")) !== FALSE) {
          $data = fgetcsv($handle, 1000, "\n");    
          while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
            $tab[]= $data;
                # code...

            }
            

        }

        fclose($handle);

        return $tab;
}


 





?>