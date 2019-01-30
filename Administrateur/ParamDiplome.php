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
        if (!empty($_POST['cotisation']) && !empty($_POST['montant'])) {
            $cotisation = $mysqli->real_escape_string(trim(verif($_POST['cotisation'])));
            $montant = $mysqli->real_escape_string(trim(verif($_POST['montant'])));

            $sql22 = "SELECT * FROM diplome WHERE libelle_diplome='$cotisation'";
            $donpro = $mysqli->query($sql22) or die(mysqli_error($mysqli));
            $rows = $donpro->num_rows;

            if ($rows == 1) {
                $sqlup = "UPDATE diplome SET libelle_diplome='$cotisation', montant_diplome='$montant' WHERE libelle_diplome='$cotisation' ";
                insertDB($sqlup);
                $v1 = '<script> dialogsuccess("Mise à jour réussit", "historique.php"); </script>';
            } else {
                $sqlD = "INSERT INTO diplome(libelle_diplome,montant_diplome) VALUES ('$cotisation','$montant' )";
                insertDB($sqlD);

                $v1 = '<script> dialogsuccess("Enregistré","ParamDiplome.php"); </script>';
            }
        } else {
            $v1 = '<script> dialoginfo("Tous les champs sont Obligatoirs !","ParamDiplome.php"); </script>';
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
    <h1 class="display-6">Paramétrage du coût du diplôme </h1>

        <form method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Libellé : </label>
      <input type="text" class="form-control" id="libellecotisation" placeholder="Libellé" name="cotisation"  value="<?php  echo utf8_encode($res['libelle_diplome']); ?>" >
    </div>
  </div>

    <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Montant : </label>
      <input type="number" class="form-control" id="montantcotisation" placeholder="Montant EUROS" name="montant"  value="<?php  echo utf8_encode($res['montant_diplome']); ?>">

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