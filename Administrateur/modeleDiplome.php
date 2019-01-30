<?php 
 session_start();
 include '../DB/base.php';
 include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';
$ran = aleatoire(6, 5);
$envoi = '';

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

    if (isset($_POST['submitDip'])) {
        // code...
        if (isset($_FILES['file']) and $_FILES['file']['error'] == 0) {
            if (!empty($_POST['libelleDipl'])) {
                $name = $mysqli->real_escape_string(trim(verif($_POST['libelleDipl'])));

                $v1 = SaveDiplomeModel($_FILES['file'], $name)[0];
            } else {
                $v1 = '<script> dialoginfo("Champs libellé est vide","modeleDiplome.php"); </script>';
            }
            // code...
        } else {
            $v1 = '<script> dialogerror("Echec, Erreur lors de téléchargement de fichier","modeleDiplome.php"); </script>';
        }
    }

    if (isset($_POST['submitCCA'])) {
        // code...
        if (isset($_FILES['fileCCA']) and $_FILES['fileCCA']['error'] == 0) {
            if (!empty($_POST['libelleCCA'])) {
                $name = $mysqli->real_escape_string(trim(verif($_POST['libelleCCA'])));

                $v1 = SaveCcaModel($_FILES['fileCCA'], $name)[0];
            } else {
                $v1 = '<script> dialoginfo("Le champs libellé est vide","modeleDiplome.php"); </script>';
            }
            // code...
        } else {
            $v1 = '<script> dialogerror("Echec, Erreur lors de téléchargement de fichier","modeleDiplome.php"); </script>';
        }
    }
}

  ?>


<!doctype html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

  
  <?php  include '../Blocs_HTML/script_bootstrap_header.php'; ?>
  <title>accueil admin</title>
  <link rel="stylesheet" href="../CSS/Style.css">
</head>
<body>

 <?php    include '../Blocs_HTML/nav.php'; ?>


<div class="jumbotron accueil">
  <div class="container">
    <h1 class="display-4">Importer les modèles</h1>


    

    <form  class="form-group" method="post"  enctype="multipart/form-data">
</br>
</br>
       
       <div class="div-file">


         <div class="row">
    <div class="col">
      <input type="text" class="form-control" placeholder="Libellé de diplôme" name="libelleDipl">
    </div>

          <label for="file" class="label-classe">
            <i class="fas fa-cloud-upload-alt"></i>
           <span id="label-span">Importer un modèle</span>
         </label>
         <input type="file" name="file" id="file" class="file">

       </div>

       </div>

</br>

   <button type="submit" name="submitDip" class="btn btn-primary btn-dip" >Valider</button>
 

</br></br>
  <div class="div-file">


         <div class="row">
    <div class="col">
      <input type="text" class="form-control" placeholder="Libellé du CCE" name="libelleCCA">
    </div>

          <label for="file1" class="label-classe">
            <i class="fas fa-cloud-upload-alt"></i>
           <span id="label-span1">Importer un modèle </span>
         </label>
         <input type="file" name="fileCCA" id="file1" class="file">

       </div>

       </div>

</br>

   <button type="submit" name="submitCCA" class="btn btn-primary btn-dip" >Valider</button>




</form>
    
  </div>

</div>


<?php   echo $v1; echo $envoi; ?>


<?php    include '../Blocs_HTML/footer.php'; ?>


</body>
</html>