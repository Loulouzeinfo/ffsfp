<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$profile = '';
$i = 1;
$v1 = '';
$formation = array();
$tabF = array('libelle_formation' => '');
$out = '';

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

    $sqForm = 'SELECT * FROM formation ';
    $donproF = $mysqli->query($sqForm) or die(mysqli_error($mysqli));
    while ($resproF = $donproF->fetch_array()) {
        $formation[] = $resproF;
        // code...
    }
    if (isset($_POST['submit'])) {
        if (isset($_FILES['file']) and $_FILES['file']['error'] == 0 and $_POST['dip'] != 'NULL') {
            $v1 = SaveDiplomePersonne($_FILES['file'], $respro, $_POST['dip'])[0];
        } else {
            $v1 = '<script> dialoginfo("Champs diplôme est vide ou erreur lors de téléchargement de fichier","diplome.php"); </script>';
        }
    }
}

?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">

  <?php include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Diplôme</title>
  <link rel="stylesheet" href="../CSS/Style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<body>

 <?php include '../Blocs_HTML/nav.php'; ?>

<div class="jumbotron jumbotron-fluid cotisation accueil">


  <div class="container">
    <h1 class="display-6">Dilpômes </h1>

        <form method="post" enctype="multipart/form-data">
 

    <div class="form-group row">
    <div class="col-sm-4">
      <div class="form-check">

      </div>
    </div>
  </div>
    <div id="sel">
    <div class="form-group row" >
    <div class="col-sm-2" >Diplôme</div>
    <div class="col-sm-3">
      <div class="form-check">
        <select id="inputState" class="form-control" name="dip">
        <option value="NULL" selected>Choisir une formation</option>

        <?php foreach ($formation as $key) {
    echo '<option value='.utf8_encode($key['libelle_formation']).'>'.utf8_encode($key['libelle_formation']).'</option>';
}?>
      </select>

      </div>
    </div>

    <div class='col-sm-6'>
      <label for="file" class="label-classe">
            <i class="fas fa-cloud-upload-alt"></i>
           <span id="label-span">Importer un modèle</span>
         </label>
         <input type="file" name="file" id="file" class="file">
</div>
  </div>
  </div>


    <div class="form-row">
   <div class="col-md-4 mb-3">
      <button type="submit"  class="btn btn-primary" name="submit">Valider</button>
</div>
    </div>

</form>


</div>
</div>

<?php echo $v1; ?>
<?php include '../Blocs_HTML/footer.php'; ?>


</body>
</html>