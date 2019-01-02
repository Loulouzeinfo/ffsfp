<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
} else {
    if (isset($_SESSION['action']) and (time() - $_SESSION['action']) < 300) {
        $_SESSION['action'] = time();
    } else {
        $v1 = '<script>
               swal({

                text: "Vous êtes déconnecté !",
                icon: "info"
                }).then(function() {
                window.location = "../index.php";
                 });

               </script>';
    }

    $sess = $_SESSION['login'];
    $sql2 = "SELECT * FROM personne WHERE mail='$sess'";
    $donpro = $mysqli->query($sql2) or die(mysqli_error($mysqli));
    $respro = $donpro->fetch_array();
    $profile = $respro['prenom'];

    $sql = 'SELECT * FROM formation';
    $donn = $mysqli->query($sql) or die(mysqli_error($mysqli));
    while ($res = $donn->fetch_array()) {
        $tab[] = $res;
    }

    if (isset($_GET['supp'])) {
        if (!empty($_GET['supp'])) {
            $supp = $mysqli->real_escape_string(trim(verif($_GET['supp'])));

            $sqldel = "DELETE FROM formation WHERE  libelle_formation= '$supp' ";
            insertDB($sqldel);
            console_log('formation supprimé');

            $sqldel1 = "DELETE FROM prerequis WHERE libelle_formation= '$supp' ";
            insertDB($sqldel1);
            console_log('prérequis supprimé');

            $sqldel2 = "DELETE FROM prerogative WHERE libelle_formation= '$supp' ";
            insertDB($sqldel2);
            console_log('prerogative supprimé');

            $v1 = '<script> dialogsuccess("Supprimé","historiqueParamFormation.php"); </script>';
        } else {
            $v1 = "<script>
               swal({
                text: \"Le Paramètre n'est pas valide valide!\",
                icon: \"error\"
                }).then(function() {
                window.location = \"historiqueParamFormation.php\";
                 });

               </script>";
        }
    }
}

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Historiques</title>
  <link rel="stylesheet" href="../CSS/Style.css">


</head>
<body>

 <?php include '../Blocs_HTML/nav.php'; ?>






<div class="table-wrapper-scroll-y formation container">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">18 ans</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php
foreach ($tab as $key) {
    $var = '<tr>
      <th scope="row">'.utf8_encode($key['libelle_formation']).'</th>';
    if ($key['age'] == 1) {
        $var .= '<td scope="row"> <input class="form-check-input" type="checkbox" id="gridCheck1" onclick="return false;" checked></td>';
    } else {
        $var .= '<td scope="row"><input class="form-check-input" type="checkbox" id="gridCheck1" onclick="return false;"> </td>';
    }

    $var .= '<td>

      <a href="historiqueParamFormation.php?supp='.utf8_encode($key['libelle_formation']).'"><i class="fas fa-trash-alt"></i></a>&nbsp;
      <a href="formation.php?editF='.utf8_encode($key['id_formation']).'"><i class="fas fa-user-edit"></i></a>&nbsp;';
    $label = utf8_encode($key['libelle_formation']);
    $text = str_replace(' ', '', utf8_encode($key['libelle_formation']));

    $var .= '<a  href=" " data-toggle="modal" data-target="#'.$text.'"><i class="fas fa-search-plus"></i></a>


  <div class="modal fade" id='.$text.' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'.utf8_encode($key['libelle_formation']).'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <label> Prérequis: </label>';
    $preqi = "SELECT * FROM prerequis WHERE libelle_formation='$label'";
    $donnpreqi = $mysqli->query($preqi) or die(mysqli_error($mysqli));
    while ($respreqi = $donnpreqi->fetch_array()) {
        $var .= '<input type="text" class="form-control"  placeholder='.$respreqi['libellePreroquis'].' readonly><a  href="historiqueParamFormation.php?supp=s'.$respreqi['id_prerequis'].'">supp</a> </br>';
    }

    $var .= '</br><label> Prérogatives: </label>';
    $pregative = "SELECT * FROM prerogative WHERE libelle_formation='$label'";
    $donnpregative = $mysqli->query($pregative) or die(mysqli_error($mysqli));
    while ($respregative = $donnpregative->fetch_array()) {
        $var .= '<input type="text" class="form-control"  placeholder='.$respregative['libellePrerogative'].' readonly></br>';
    }

    $var .= '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

      </td>
    </tr>';

    echo $var;
}

?>


  </tbody>
</table>
</div>
  <!-- Le reste du contenu -->


<?php echo $v1; ?>
<?php include '../Blocs_HTML/footer.php';?>



</body>
</html>