<?php

include 'DB/base.php';
$res = 0;
$out = '';
            $query_2 = 'SELECT personne.nom FROM diplome_personne,personne WHERE personne.id_personne=diplome_personne.id_personne AND status=1 ';
            $result_2 = $mysqli->query($query_2);
            $count2 = $result_2->num_rows;

            $req = 'SELECT * FROM cheque,personne WHERE personne.id_personne=cheque.id_personne AND  statut_cheque=0';
            $result_1 = $mysqli->query($req);
            $count = $result_1->num_rows;

            $req1 = 'SELECT * FROM virement,personne WHERE personne.id_personne=virement.id_personne AND  statut_virement=0';
            $result_3 = $mysqli->query($req1);
            $count3 = $result_3->num_rows;

            if ($count2 > 0 || $count > 0 || $count3 > 0) {
                while ($t = $result_2->fetch_array()) {
                    // code...
                    $out .= '<a href=""><li class="dropdown-item">Dilplôme : <ul><li>'.$t['nom'].'</li></ul></li></a><div class="dropdown-divider"></div>';
                }

                while ($che = $result_1->fetch_array()) {
                    // code...
                    $out .= '<a href="validation.php?id_personne='.$che['id_personne'].'"><li class="dropdown-item">Chèque : <ul><li>'.$che['prenom'].' '.$che['nom'].'</li></ul></li></a><div class="dropdown-divider"></div>';
                }

                while ($vir = $result_3->fetch_array()) {
                    // code...
                    $out .= '<a href="validation.php?id_personne='.$vir['id_personne'].'"><li class="dropdown-item">Virement : <ul><li>'.$vir['prenom'].' '.$vir['nom'].'</li></ul></li></a><div class="dropdown-divider"></div>';
                }
            } else {
                $out .= '<li class="dropdown-item" >  Aucune notification trouvée  </li>';
            }

            $res = $count + $count2 + $count3;
            $data = array(
                     'notification' => $out,
                     'unseen_notification' => $res,
                         );
                      echo json_encode($data);
