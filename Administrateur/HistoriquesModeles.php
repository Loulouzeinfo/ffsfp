<?php 
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$tabc = array();
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

    $sqlp = 'SELECT * FROM modele_diplome';
    $donnp = $mysqli->query($sqlp) or die(mysqli_error($mysqli));
    while ($resp = $donnp->fetch_array()) {
        $tab[] = $resp;
    }

    $sqlpc = 'SELECT * FROM modele_caa';
    $donnc = $mysqli->query($sqlpc) or die(mysqli_error($mysqli));
    while ($resc = $donnc->fetch_array()) {
        $tabc[] = $resc;
    }

    if (isset($_GET['supp'])) {
        if (!empty($_GET['supp'])) {
            $supp = $mysqli->real_escape_string(trim(verif($_GET['supp'])));

            $sqldel = "DELETE FROM modele_diplome WHERE  modeleUrl= '$supp' ";
            insertDB($sqldel);
            console_log('../file/Modele/ModeleDip/'.$supp);
            rrmdir('../file/Modele/ModeleDip/'.$supp);

            console_log('modèle supprimé');

            $v1 = '<script> dialogsuccess("Supprimé","HistoriquesModeles.php"); </script>';
        } else {
            $v1 = '<script>
               swal({
                text: "le Paramètre est valide!",
                icon: "error"
                }).then(function() {
                window.location = "HistoriquesModeles.php";
                 });
               
               </script>';
        }
    }

    if (isset($_GET['suppCaa'])) {
        if (!empty($_GET['suppCaa'])) {
            $supp = $mysqli->real_escape_string(trim(verif($_GET['suppCaa'])));

            $sqldel = "DELETE FROM modele_caa WHERE  caaUrl= '$supp' ";
            insertDB($sqldel);
            console_log('../file/Modele/ModeleCCA/'.$supp);
            rrmdir('../file/Modele/ModeleCCA/'.$supp);

            console_log('modèle supprimé');

            $v1 = '<script> dialogsuccess("Supprimé","HistoriquesModeles.php"); </script>';
        } else {
            $v1 = '<script>
               swal({
                text: "le Paramètre est valide!",
                icon: "error"
                }).then(function() {
                window.location = "HistoriquesModeles.php";
                 });
               
               </script>';
        }
    }
}

  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php  include '../Blocs_HTML/script_bootstrap_header.php'; ?>
  
  <title>Historiques</title>
  <link rel="stylesheet" href="../CSS/Style.css">
   

</head>
<body>
 
 <?php    include '../Blocs_HTML/nav.php'; ?>






<div class="table-wrapper-scroll-y formation container">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php
     foreach ($tab as $key) {
         $var = '<tr>
      <th scope="row">'.utf8_encode($key['modeleUrl']).'</th>';

         $var .= '<td>

      <a href="HistoriquesModeles.php?supp='.utf8_encode($key['modeleUrl']).'"><i class="fas fa-trash-alt"></i></a>&nbsp;';
         $text = str_replace(' ', '', utf8_encode($key['modeleUrl']));

         $var .= '<a  href=" " data-toggle="modal" data-target="#'.$text.'"><i class="fas fa-search-plus"></i></a>


  <div class="modal fade" id='.$text.' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'.utf8_encode($key['modeleUrl']).'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <a href="../file/Modele/ModeleDip/'.utf8_encode($key['modeleUrl']).'/'.$key['nameModele'].'" >'.$key['nameModele'].'</a>




      ';

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


<div class="table-wrapper-scroll-y formation container">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php
     foreach ($tabc as $keyc) {
         $var = '<tr>
      <th scope="row">'.utf8_encode($keyc['caaUrl']).'</th>';

         $var .= '<td>

      <a href="HistoriquesModeles.php?suppCaa='.utf8_encode($keyc['caaUrl']).'"><i class="fas fa-trash-alt"></i></a>&nbsp;';
         $text = str_replace(' ', '', utf8_encode($keyc['caaUrl']));

         $var .= '<a  href=" " data-toggle="modal" data-target="#'.$text.'"><i class="fas fa-search-plus"></i></a>


  <div class="modal fade" id='.$text.' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'.utf8_encode($keyc['caaUrl']).'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <a href="../file/Modele/ModeleCCA/'.utf8_encode($keyc['caaUrl']).'/'.$keyc['nameCaa'].'" >'.$keyc['nameCaa'].'</a>




      ';

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


<?php  echo $v1; ?>
<?php    include '../Blocs_HTML/footer.php'; ?>

      

</body>
</html>