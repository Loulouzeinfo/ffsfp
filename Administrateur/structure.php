<?php 
 session_start();
 include '../DB/base.php';
 include '../Fonction/fonction.php';
$res = array(
    'libelle_diplome' => '',
    'montant_diplome' => '',
  );
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
    $sql22 = "SELECT * FROM personne WHERE mail='$sess'";
    $donpro = $mysqli->query($sql22) or die(mysqli_error($mysqli));
    $respro = $donpro->fetch_array();
    $profile = $respro['prenom'];

    if (isset($_POST['submit'])) {
        if (!empty($_POST['raison']) && !empty($_POST['Adresse']) && !empty($_POST['code']) && !empty($_POST['ville'])
        && !empty($_POST['nomC']) && !empty($_POST['mailC']) && !empty($_POST['telC'])) {
            $raison = $mysqli->real_escape_string(trim(verif($_POST['raison'])));
            $adresse = $mysqli->real_escape_string(trim(verif($_POST['Adresse'])));
            $code = $mysqli->real_escape_string(trim(verif($_POST['code'])));
            $ville = $mysqli->real_escape_string(trim(verif($_POST['ville'])));
            $nomC = $mysqli->real_escape_string(trim(verif($_POST['nomC'])));
            $mailC = $mysqli->real_escape_string(trim(verif($_POST['mailC'])));
            $telC = $mysqli->real_escape_string(trim(verif($_POST['telC'])));

            $sqlD = "INSERT INTO structure(saison_social,adresse_struc,code_struc,ville_struc,nom_struc,mail_struc,tel_struc) 
            VALUES ('$raison','$adresse','$code','$ville','$nomC','$mailC','$telC' )";
            insertDB($sqlD);
            $v1 = '<script> dialogsuccess("Enregistré","structure.php"); </script>';
        } else {
            $v1 = '<script> dialoginfo("Tous les champs sont Obligatoirs !","structure.php"); </script>';
        }
    }

    if (isset($_GET['editD'])) {
        if (!empty($_GET['editD'])) {
            $editD = $mysqli->real_escape_string(trim(verif($_GET['editD'])));

            $historique = "SELECT * FROM diplome WHERE id_diplome='$editD'";
            $donnhist = $mysqli->query($historique) or die(mysqli_error($mysqli));
            $res = $donnhist->fetch_array();
        } else {
            $v1 = "<script> dialoginfo(\"Libellé de Diplôme n'existe pas !\", \"ParamDiplome.php\"); </script>";
        }
    }
}

  ?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  
  <?php  include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Coût de diplôme</title>
  <link rel="stylesheet" href="../CSS/Style.css">





<body>

 <?php    include '../Blocs_HTML/nav.php'; ?>

<div class="jumbotron jumbotron-fluid cotisation accueil">
  <div class="container">
    <h1 class="display-6">Paramétrage de la structure </h1>

        <form method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="raison">Raison sociale : </label>
      <input type="text" class="form-control" id="raison" placeholder="Raison sociale" name="raison"  value="" >
    </div>
  </div>

    <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="Adresse">Adresse : </label>
      <input type="text" class="form-control" id="Adresse" placeholder="Adresse" name="Adresse"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

    </div>
  </div>

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="code">Code postal : </label>
      <input type="number" class="form-control" id="code" placeholder="Code postale" name="code"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

    </div>
  </div>

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="ville">Ville : </label>
      <input type="text" class="form-control" id="ville" placeholder="Ville" name="ville"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

    </div>
  </div>

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="nomC">Nom : </label>
      <input type="text" class="form-control" id="nomC" placeholder="Nom du contact" name="nomC"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

    </div>
  </div>

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="mailC">Mail : </label>
      <input type="text" class="form-control" id="mailC" placeholder="Mail du contact" name="mailC"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

    </div>
  </div>

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="telC">Téléphone : </label>
      <input type="number" class="form-control" id="telC" placeholder="téléphone du contact" name="telC"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

    </div>
  </div>

    <div class="form-row">
   <div class="col-md-4 mb-3">
      <button type="submit" class="btn btn-primary" name="submit">Valider</button>
</div>
    </div>

</form>


</div>
</div>

<?php  echo $v1; ?>
<?php    include '../Blocs_HTML/footer.php'; ?>


</body>
</html>