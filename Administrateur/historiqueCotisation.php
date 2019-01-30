<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';
$tabH = array();

$v2 = '';
$bar = '';

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
    $id = $respro['id_personne'];

    $req = "SELECT * FROM paiement_histrorique WHERE id_personne='$id' ORDER BY libelle_annee DESC ";
    $rqco = $mysqli->query($req) or die(mysqli_error($mysqli));
    while ($resH = $rqco->fetch_array()) {
        $tabH[] = $resH;
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
      <th scope="col">Tarification</th>
      <th scope="col">Année de cotisation</th>
      <th scope="col">Montant</th>

    </tr>
  </thead>
  <tbody id="ul">
    <?php
   foreach ($tabH as $key) {
       echo '<tr>
        <th scope="row">'.utf8_encode($key['tarification_historique']).'</th>
        <td>'.utf8_encode($key['libelle_annee']).'</td>
        <td>'.utf8_encode($key['montant_historique']).' € </td>';
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