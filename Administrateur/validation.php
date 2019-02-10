<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';
$var = '';

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

    if (isset($_GET['id_personne']) && isset($_GET['id']) && isset($_GET['typePaiment'])) {
        if (!empty($_GET['id_personne']) && !empty($_GET['id']) && !empty($_GET['typePaiment'])) {
            $id_personne = $mysqli->real_escape_string(trim(verif($_GET['id_personne'])));
            $id = $mysqli->real_escape_string(trim(verif($_GET['id'])));
            $typepaiment = $mysqli->real_escape_string(trim(verif($_GET['typePaiment'])));

            if ($typepaiment == 'Virement' || $typepaiment == 'Cheque') {
                if ($typepaiment == 'Virement') {
                    $req = "SELECT * FROM virement WHERE id_virement='$id' AND id_personne='$id_personne' ";
                    $var = selectDB($req);
                } else {
                    $req = "SELECT * FROM cheque WHERE id_cheque='$id' AND id_personne='$id_personne' ";
                    $var = selectDB($req);
                }
            } else {
                header('Location:accueil.php');
            }
        } else {
            header('Location:accueil.php');
        }
    }

    if (isset($_GET['suppVirement'])) {
        $id_virement = $mysqli->real_escape_string(trim(verif($_GET['suppVirement'])));
        $sqldel = "DELETE FROM virement WHERE  id_virement= '$id_virement' ";
        insertDB($sqldel);
        $v1 = '<script> dialogsuccess("Virement supprimé","accueil.php"); </script>';
    }

    if (isset($_GET['suppCheque'])) {
        $id_virement = $mysqli->real_escape_string(trim(verif($_GET['suppCheque'])));
        $sqldel = "DELETE FROM cheque WHERE  id_cheque= '$id_virement' ";
        insertDB($sqldel);
        $v1 = '<script> dialogsuccess("Chèque supprimé","accueil.php"); </script>';
    }

    if (isset($_POST['submit'])) {
    }
}

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Validation</title>
  <link rel="stylesheet" href="../CSS/Style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>
<body>

 <?php include '../Blocs_HTML/nav.php'; ?>






<div class="table-wrapper-scroll-y formation container">


  <div   class="poo">
  <div class="jumbotron pay">
  <div class="container">
    <h3 class="display-4"><?php  echo $test = ($typepaiment == 'Virement') ? 'Virement</h3>' : 'Chèque</h3>'; ?>

  </div>
</div>
<form methode="post">
  <div class="form-group form-row">
    <div class="col">
    <label>Date <?php  echo $test = ($typepaiment == 'Virement') ? 'virement' : 'du chèque'; ?></label>
      <input id="datevir" name="dateVirement" class="form-control"  value="<?php  $dateP = ($typepaiment == 'Virement') ? utf8_encode($var['date_virement']) : utf8_encode($var['date_cheque']); echo $dateP; ?>">
    </div>

    <script type="text/javascript">
      $('#datevir').datepicker({

            altField: "#datepicker",
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            minDate: 0

        });

    </script>
    <div class="col">
    <label>Montant <?php  echo $test = ($typepaiment == 'Virement') ? 'virement' : 'du chèque'; ?></label>
      <input type="text" name="montantVirement" class="form-control" value="<?php  $montantp = ($typepaiment == 'Virement') ? utf8_encode($var['montant_virement']) : utf8_encode($var['montant_cheque']); echo $montantp; ?>">
    </div>

  </div>

  <div class="form-group form-row">
    <div class="col">
    <label>Banque </label>
      <input type="text" name="banqueVirement" class="form-control" value="<?php  $banquep = ($typepaiment == 'Virement') ? utf8_encode($var['banque_virement']) : utf8_encode($var['banque_cheque']); echo $banquep; ?>">
    </div>
    <div class="col">
    <label>Libelle <?php  echo $test = ($typepaiment == 'Virement') ? 'virement' : 'du chèque'; ?></label>
      <input type="text" name="libelleVirement" class="form-control" value="<?php  $lib = ($typepaiment == 'Virement') ? utf8_encode($var['libelle_virement']) : utf8_encode($var['num_cheque']); echo $lib; ?>">
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Valider</button>
  <a href="validation.php?<?php  echo $test = ($typepaiment == 'Virement') ? 'suppVirement='.$var['id_virement'] : 'suppCheque='.$var['id_cheque']; ?>" class="btn btn-primary">Supprimer</a>
</form>


  </div>
</div>
  <!-- Le reste du contenu -->



<?php echo $v1; ?>
<?php include '../Blocs_HTML/footer.php'; ?>

</body>
</html>