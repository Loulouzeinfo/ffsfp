<?php

include 'DB/base.php';
$out = '';
$mess = '';
$inpfor1 = '';
$inpfor2 = '';
$inpm = '';

if (isset($_GET['data'])) {
    $m = $_GET['data'];

    $req = $mysqli->query("SELECT * FROM personne,assoc_per_rol WHERE (nom  LIKE '%".$m."%' OR prenom  LIKE '%".$m."%')
     AND personne.id_personne=assoc_per_rol.id_personne AND id_role=3 LIMIT 50

       ");
    $do = $req->num_rows;
    $out .= '<ul class="list-unstyled"  id="nompers">';
    if ($do > 0) {
        while ($ex = $req->fetch_array()) {
            $out .= '<li class="nomlif1">'.$ex['prenom'].' '.$ex['nom'].'</li>';
            $inpfor1 .= '<input type="hidden" name="hiddenr"  value="'.$ex['id_personne'].'" >';
        }
    } else {
        $out .= '<li  id="lirouge"> Aucun nom trouvé  </li>';
    }

    $out .= '</ul>';
    $out .= $inpfor1;

    echo $out;
}

if (isset($_GET['dataf'])) {
    $m = $_GET['dataf'];

    $req = $mysqli->query("SELECT * FROM personne,assoc_per_rol WHERE (nom  LIKE '%".$m."%' OR prenom  LIKE '%".$m."%') AND personne.id_personne=assoc_per_rol.id_personne AND id_role=3 LIMIT 50");
    $do = $req->num_rows;
    $out .= '<ul class="list-unstyled"  id="nompers">';
    if ($do > 0) {
        while ($ex = $req->fetch_array()) {
            $out .= '<li class="nomlif2">'.$ex['prenom'].' '.$ex['nom'].'</li>';
            $inpfor2 .= '<input type="hidden" name="hiddenrf2"  value="'.$ex['id_personne'].'" >';
        }
    } else {
        $out .= '<li  id="lirouge"> Aucun nom trouvé  </li>';
    }

    $out .= '</ul>';
    $out .= $inpfor2;
    echo $out;
}

if (isset($_GET['datam'])) {
    $m = $_GET['datam'];

    $req = $mysqli->query("SELECT * FROM personne WHERE (nom  LIKE '%".$m."%' OR prenom  LIKE '%".$m."%')  LIMIT 50");
    $do = $req->num_rows;
    $out .= '<ul class="list-unstyled"  id="nompers">';
    if ($do > 0) {
        while ($ex = $req->fetch_array()) {
            $out .= '<li class="nomlim">'.$ex['prenom'].' '.$ex['nom'].'</li>';
            $inpm .= '<input type="hidden" name="hiddenrm"  value="'.$ex['id_personne'].'" >';
        }
    } else {
        $out .= '<li  id="lirouge"> Aucun nom trouvé  </li>';
    }

    $out .= '</ul>';
    $out .= $inpm;
    echo $out;
}
