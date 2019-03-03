<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';
$var = '';
$anne = intval(date('Y'));
$anne = ++$anne;

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
            $ids = $mysqli->real_escape_string(trim(verif($_GET['id'])));
            $typepaiment = $mysqli->real_escape_string(trim(verif($_GET['typePaiment'])));

            if ($typepaiment == 'Virement' || $typepaiment == 'Cheque') {
                if ($typepaiment == 'Virement') {
                    $req = "SELECT * FROM virement WHERE id_virement='$ids' AND id_personne='$id_personne' ";
                    $var = selectDB($req);
                } else {
                    $req = "SELECT * FROM cheque WHERE id_cheque='$ids' AND id_personne='$id_personne' ";
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
        if ($_GET['typePaiment'] == 'Virement') {
            $date_p = $_POST['datename'];
            $tar = utf8_decode($_POST['tarif']);
            $pieces = explode('/', $_POST['datename']);
            $idauto = $_POST['idauto'];
            $idc = $_GET['id_personne'];

            $mnt = $_POST['montant'];
            $banqeP = $_POST['banqueP'];
            $libelleP = $_POST['libelleP'];
            $ajout = "INSERT INTO paiement_histrorique (id_personne,libelle_annee,tarification_historique,montant_historique,moyen_paiment) VALUES ('$idc','$pieces[2]','$tar','$mnt','Virement') ";
            insertDB($ajout);

            $updvir = "UPDATE virement SET statut_virement = 1, montant_virement='$mnt',libelle_virement='$libelleP',banque_virement='$banqeP',date_virement='$date_p'  WHERE id_personne= '$idc' AND id_virement='$idauto'";
            insertDB($updvir);

            if (iconv('UTF-8', 'ISO-8859-1//IGNORE', $tar) == 'adhésion') {
                $sqlup = "UPDATE cotisationniveau SET  cotisationN= 'renouvellement', anneCotisation='$anne'  WHERE id_personne='$idc' ";
                insertDB($sqlup);
            } else {
                $sqlup = "UPDATE cotisationniveau SET  anneCotisation='$anne'  WHERE id_personne='$idc' ";
                insertDB($sqlup);
            }

            $v1 = '<script> dialogsuccess("Le virement est validé","accueil.php"); </script>';
        } elseif ($_GET['typePaiment'] == 'Cheque') {
            $date_p = $_POST['datename'];
            $tar = utf8_decode($_POST['tarif']);
            $pieces = explode('/', $_POST['datename']);
            $idauto = $_POST['idauto'];
            $idc = $_GET['id_personne'];

            $mnt = $_POST['montant'];
            $banqeP = $_POST['banqueP'];
            $libelleP = $_POST['libelleP'];

            $ajout = "INSERT INTO paiement_histrorique (id_personne,libelle_annee,tarification_historique,montant_historique,moyen_paiment) VALUES ('$idc','$pieces[2]','$tar','$mnt','Cheque') ";
            insertDB($ajout);

            $updvir = "UPDATE cheque SET statut_cheque = 1, montant_cheque='$mnt', banque_cheque='$banqeP', num_cheque='$libelleP', date_cheque='$date_p'  WHERE id_personne= '$idc' AND id_cheque='$idauto'";
            insertDB($updvir);

            if (iconv('UTF-8', 'ISO-8859-1//IGNORE', $tar) == 'adhésion') {
                $sqlup = "UPDATE cotisationniveau SET  cotisationN= 'renouvellement', anneCotisation='$anne'  WHERE id_personne='$idc' ";
                insertDB($sqlup);
            } else {
                $sqlup = "UPDATE cotisationniveau SET  anneCotisation='$anne'  WHERE id_personne='$idc' ";
                insertDB($sqlup);
            }

            $v1 = '<script> dialogsuccess("Le virement est validé","accueil.php"); </script>';
        } else {
        }
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
<form method="post">
  <div class="form-group form-row">
    <div class="col">
    <label>Date <?php  echo $test = ($typepaiment == 'Virement') ? 'virement' : 'du chèque'; ?></label>
      <input id="datevir" name="datename" class="form-control"  value="<?php  $dateP = ($typepaiment == 'Virement') ? utf8_encode($var['date_virement']) : utf8_encode($var['date_cheque']); echo $dateP; ?>" >
    </div>

  

<input  type="hidden" name="idauto"  value="<?php  echo $idauto = ($typepaiment == 'Virement') ? utf8_encode($var['id_virement']) : utf8_encode($var['id_cheque']); ?>">
    <input  type="hidden" name="tarif"  value="<?php  echo $tarif = ($typepaiment == 'Virement') ? utf8_encode($var['tarification']) : utf8_encode($var['tarification']); ?>">
    <div class="col">
    <label>Montant <?php  echo $test = ($typepaiment == 'Virement') ? 'virement' : 'du chèque'; ?></label>
      <input type="text" name="montant" class="form-control" value="<?php  $montantp = ($typepaiment == 'Virement') ? utf8_encode($var['montant_virement']) : utf8_encode($var['montant_cheque']); echo $montantp; ?>" >
    </div>

  </div>

  <div class="form-group form-row">
    <div class="col">
    <label>Banque </label>
      <input type="text" name="banqueP" class="form-control" value="<?php  $banquep = ($typepaiment == 'Virement') ? utf8_encode($var['banque_virement']) : utf8_encode($var['banque_cheque']); echo $banquep; ?>" >
    </div>
    <div class="col">
    <label>Libelle <?php  echo $test = ($typepaiment == 'Virement') ? 'virement' : 'du chèque'; ?></label>
      <input type="text" name="libelleP" class="form-control" value="<?php  $lib = ($typepaiment == 'Virement') ? utf8_encode($var['libelle_virement']) : utf8_encode($var['num_cheque']); echo $lib; ?>" >
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