<?php

include 'DB/base.php';
$out = '';
$mess = '';
$deleg = '';

if (isset($_GET['data'])) {
    $m = $_GET['data'];

    $req = $mysqli->query("SELECT * FROM personne,assoc_per_rol WHERE (nom  LIKE '%".$m."%' OR prenom  LIKE '%".$m."%') AND personne.id_personne=assoc_per_rol.id_personne AND id_role=2 LIMIT 50");
    $do = $req->num_rows;
    $out .= '<ul class="list-unstyled"  id="nompers">';
    if ($do > 0) {
        while ($ex = $req->fetch_array()) {
            $out .= '<li class="nomli">'.$ex['prenom'].' '.$ex['nom'].'</li>';
            $deleg .= '<input type="hidden" name="hiddendeg"  value="'.$ex['id_personne'].'" >';
        }
    } else {
        $out .= '<li id="lirouge"> Aucun nom trouvé  </li>';
    }

    $out .= '</ul>';
    $out .= $deleg;

    echo $out;
}
