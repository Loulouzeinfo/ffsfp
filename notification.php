<?php

include("DB/base.php");


$out='';
            $query_2 = "SELECT personne.nom FROM diplome_personne,personne WHERE personne.id_personne=diplome_personne.id_personne AND status=1 ";
            $result_2 = $mysqli->query($query_2);
            $count2 = $result_2->num_rows;
            
            if($count2>0){

            	while ($t=$result_2->fetch_array()) {
            		# code...
            		$out.="<li class=\"dropdown-item\">".$t['nom']."</li><div class=\"dropdown-divider\"></div>";
            	}
                    

            }else{
                     $out.="<li class=\"dropdown-item\" >  Aucune notification trouvée  </li>";

            }



            $query_1 = "SELECT * FROM diplome_personne WHERE status=1";
            $result_1 = $mysqli->query($query_1);
            $count = $result_1->num_rows;
            $mysqli->close();
            $data = array(
            	     'notification' => $out,
                     'unseen_notification' => $count
                         );
                      echo json_encode($data);





?>