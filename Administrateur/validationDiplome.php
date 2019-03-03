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

    if (isset($_GET['id_dip'])) {
        if (!empty($_GET['id_dip'])) {
            $supp = $mysqli->real_escape_string(trim(verif($_GET['id_dip'])));

            $sqlp = "SELECT * FROM diplome_personne WHERE idDiplome='$supp'";
            $donnp = $mysqli->query($sqlp) or die(mysqli_error($mysqli));
            $resp = $donnp->fetch_array();
        } else {
            header('Location:historiquemodpersonne.php');
        }
    }

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $sqlup = "UPDATE diplome_personne SET  status= 0  WHERE idDiplome='$id' ";
        insertDB($sqlup);
        $v1 = '<script> dialogsuccess("Validé","accueil.php"); </script>';
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





<form method="post">
<input type="hidden" name="id" value="<?php  echo $resp['idDiplome']; ?>">
<div class="table-wrapper-scroll-y formation container">
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">Actions</th>
      <th scope="col">Validation</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php

         $pieces = explode('/', $resp['urlDiplome']);
         $var = '<tr>
      <th scope="row">'.utf8_encode($resp['libelleDiplome']).'</th>';

         $var .= '<td>

      <a href="historiquemodpersonne.php?supp='.utf8_encode($resp['libelleDiplome']).'"><i class="fas fa-trash-alt"></i></a>&nbsp;';
         $text = str_replace(' ', '', utf8_encode($resp['libelleDiplome']));

         $var .= '<a  href=" " data-toggle="modal" data-target="#'.$text.'"><i class="fas fa-search-plus"></i></a>


  <div class="modal fade" id='.$text.' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'.utf8_encode($resp['libelleDiplome']).'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <a href="'.utf8_encode($resp['urlDiplome']).'" >'.$pieces[5].'</a>




      ';

         $var .= '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

      </td>
      <td>';
         if ($resp['status'] == 0) {
             $var .= 'Validé</td></tr>';
         } else {
             $var .= '<button type="submit" class="btn btn-primary" name="submit">Valider</button> </td></tr>';
         }

         echo $var;

    ?>
    
    
  </tbody>
</table>
</div>
</form>
  <!-- Le reste du contenu -->


<?php  echo $v1; ?>
<?php    include '../Blocs_HTML/footer.php'; ?>

      

</body>
</html>