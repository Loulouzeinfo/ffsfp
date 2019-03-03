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
        session_destroy();
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

    $reqselectdelegue = 'SELECT DISTINCT deparetement FROM delegation';
    $donnrole = $mysqli->query($reqselectdelegue) or die(mysqli_error($mysqli));
    while ($resrole = $donnrole->fetch_array()) {
        $tab[] = $resrole;
    }

    if (isset($_GET['supp'])) {
        if (!empty($_GET['supp'])) {
            $dep = $_GET['supp'];
            $sqld = "DELETE FROM delegation WHERE  deparetement= '$dep' ";
            insertDB($sqld);
            console_log('supprimé');
            $v1 = '<script> dialogsuccess("Supprimé","historiqueDelegue.php"); </script>';
        } else {
            $v1 = '<script> dialoginfo("Le département n\'existe pas ", "historiqueDelegue.php"); </script>';
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
     
      <th scope="col">Départements</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php
foreach ($tab as $key) {
    $var = '<tr>
      <th scope="row">'.utf8_encode($key['deparetement']).'</th><td>';

    if (in_array('ADMINISTRATEUR', $tableau)) {
        $var .= '

      <a href="historiqueDelegue.php?supp='.utf8_encode($key['deparetement']).'"><i class="fas fa-trash-alt"></i></a>&nbsp
      <a href="AjoutDelegation.php?editdelegue='.utf8_encode($key['deparetement']).'"><i class="fas fa-user-edit"></i></a>&nbsp;';
    }

    $label = utf8_encode($key['deparetement']);
    $text = str_replace(' ', '', utf8_encode($key['deparetement']));

    $var .= '<a  href=" " data-toggle="modal" data-target="#'.$text.'"><i class="fas fa-search-plus"></i></a>


  <div class="modal fade" id='.$text.' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'.utf8_encode($key['deparetement']).'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">';

    $preqi = "SELECT * FROM delegation WHERE deparetement='$label' ORDER BY nomination";
    $tab1 = selectDB($preqi);
    $varr = 1;
    foreach ($tab1 as $key1) {
        if ($key1['nomination'] == 'Deleguer') {
            $var .= '<label> Délégué: </label>';

            $var .= '<input type="text" class="form-control"  value="'.$key1['nom_prenom'].'" readonly>';
        } elseif ($key1['nomination'] == 'Formateur') {
            $var .= '<label> Formateur '.$varr++.' : </label>';
            $var .= '<input type="text" class="form-control"  value="'.$key1['nom_prenom'].'" readonly>';
        } else {
            $var .= '<label> Médecin: </label>';
            $var .= '<input type="text" class="form-control"  value="'.$key1['nom_prenom'].'" readonly>';
        }
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
<?php include '../Blocs_HTML/footer.php'; ?>



</body>
</html>