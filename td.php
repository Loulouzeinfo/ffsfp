<?php 
include("Fonction/fonction.php");

$tab=importeCv('format.csv');
$f=array();

for ($i=0; $i <sizeof($tab) ; $i++) { 
	# code...

	$f[]= $tab[$i][0];

}



for ($i=0; $i <sizeof($f) ; $i++) { 
	# code...
  $e= explode(';',$f[$i]);
  echo "Numéro".$e[0]." nom: ".$e[1]."</br>";
}

/*for ($i=0; $i < $p ; $i++) { 
	# code...
        $e= explode(';',$tab[$i][0]);
        
         for ($r=0; $r < sizeof($e) ; $r++) {

              echo $e[0];
                //sql requete  
         	# code...
         }

    }*/


	# code...







?>