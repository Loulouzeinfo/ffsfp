<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';
$out = '';

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
    $anne = date('Y');

    $req = "SELECT * FROM cotisationniveau,cotisation WHERE
     cotisation.tarification=cotisationniveau.cotisationN AND cotisation.libelle_cotisation=cotisationniveau.anneCotisation AND id_personne='$id' ";
    $rqco = $mysqli->query($req) or die(mysqli_error($mysqli));
    $resco = $rqco->fetch_array();
    $o = $resco['tarification'];
    $o = utf8_encode($resco['tarification']);

    $_SESSION['ses'] = array(
        'tarification' => $o,
        'mntant' => $resco['montant'],
        'libelle' => $resco['libelle_cotisation'],
        'personne' => $resco['id_personne'],
    );

    $req = "SELECT * FROM cheque WHERE statut_cheque=0 AND id_personne='$id'";
    $reqVirement = "SELECT * FROM virement WHERE statut_virement=0 AND id_personne='$id'";

    if (isset($_POST['submitCheque'])) {
        if ($_POST['dateCheque'] && $_POST['montantCheque'] && $_POST['banqueCheque'] && $_POST['numerCheque']) {
            $dateCheque = $mysqli->real_escape_string(trim(verif($_POST['dateCheque'])));
            $montantCheque = $mysqli->real_escape_string(trim(verif($_POST['montantCheque'])));
            $banqueCheque = $_POST['banqueCheque'];
            $numerCheque = $mysqli->real_escape_string(trim(verif($_POST['numerCheque'])));

            $ajout = "INSERT INTO cheque (id_personne,date_cheque,montant_cheque,banque_cheque,num_cheque,statut_cheque,tarification) VALUES ('$id','$dateCheque','$montantCheque','$banqueCheque','$numerCheque',0,'$o') ";
            insertDB($ajout);
            console_log('ajouter cheque');
            $v1 = '<script> dialogsuccess("Dés reception de votre chéque, votre cotisation sera validée","cotisationAdherent.php"); </script>';
        } else {
            $v1 = '<script> dialoginfo("Tous les champs sont Obligatoirs !","cotisationAdherent.php"); </script>';
        }
    }

    if (isset($_POST['submitVirement'])) {
        if ($_POST['dateVirement'] && $_POST['montantVirement'] && $_POST['banqueVirement'] && $_POST['libelleVirement']) {
            $dateVirement = $mysqli->real_escape_string(trim(verif($_POST['dateVirement'])));
            $montantVirement = $mysqli->real_escape_string(trim(verif($_POST['montantVirement'])));
            $banqueVirement = $mysqli->real_escape_string(trim(verif($_POST['banqueVirement'])));
            $libelleVirement = iconv('UTF-8', 'ISO-8859-1//IGNORE', $_POST['libelleVirement']);

            $ajout = "INSERT INTO virement (id_personne,montant_virement,libelle_virement,banque_virement,date_virement,statut_virement,tarification) VALUES ('$id','$montantVirement','$libelleVirement','$banqueVirement','$dateVirement',0,'$o') ";
            insertDB($ajout);
            console_log('ajouter Virement');
            $v1 = '<script> dialogsuccess("Dés reception de votre virement, votre cotisation sera validée","cotisationAdherent.php"); </script>';
        } else {
            $v1 = '<script> dialoginfo("Tous les champs sont Obligatoirs !","cotisationAdherent.php"); </script>';
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>
<body>

 <?php include '../Blocs_HTML/nav.php'; ?>






<div class="table-wrapper-scroll-y formation container">
<table class="table table-striped">
  <thead class="thead-dark">

    <tr>
      <th scope="col">Libelle</th>
      <th scope="col">Tarification</th>
      <th scope="col">Montant</th>
      <th scope="col">Date de validité</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="ul">
    <?php
if (!$resco == null) {
    $out .= '<tr>
        <th scope="row">'.$resco['libelle_cotisation'].'</th>
        <td>'.utf8_encode($resco['tarification']).'</td>
        <td>'.$resco['montant'].' € </td>
        <td>'.$resco['date_validite'].'</td>';
    if ((RowsOne($req) != true) and (RowsOne($reqVirement) != true)) {
        $out .= '<td> <ul><li class="ciquePay" id="cliqe">Chèque</li><li class="ciquePay" id="cliqev">Virement</li><li>

<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: \'sandbox\',
    // Customize button (optional)
    locale: \'fr_FR\',
    style: {
      size: \'responsive\',
      color: \'blue\',
      shape: \'pill\',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
     return paypal.request.post(\'paiement.php\').then(function (data) {
       return data.id;
     });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {

        // Show a confirmation message to the buyer
        return paypal.request.post(\'pay.php\',{
        paymentID: data.paymentID,
        payerID: data.payerID
        }).then(function(data){
            console.log(data);
       dialogsuccess("Paiement effectué avec succès", "cotisationAdherent.php");


        }).catch(function(err){
          console.log(err);
        });


    }
  }, \'#paypal-button\');

</script>

       </li></ul></td></tr>';
    } else {
        $out .= '<td>En attente de validation</td></tr>';
    }
    echo $out;
}

?>



  </tbody>
</table>



<div   class="po" style="display:none;">

<div class="jumbotron pay">
  <div class="container">
    <h3 class="display-4">Chèque</h3>

  </div>
</div>
<form method="post" >

  <div class="form-group form-row">
    <div class="col">
      <input id="datepicker" class="form-control" name="dateCheque" placeholder="Date du chèque">
    </div>

    <script type="text/javascript">
      $('#datepicker').datepicker({

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
      <input type="text" class="form-control" name="montantCheque" placeholder="Monatnt">
    </div>

  </div>

  <div class="form-group form-row">
    <div class="col">
      <input type="text" class="form-control" name="banqueCheque" placeholder="Banque">
    </div>
    <div class="col">
      <input type="text" class="form-control" name="numerCheque" placeholder="Numéro du chèque">
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name="submitCheque">Valider</button>
</form>

  </div>

  <div   class="poo" style="display:none;">
  <div class="jumbotron pay">
  <div class="container">
    <h3 class="display-4">Virement</h3>

  </div>
</div>
<form method="post">
  <div class="form-group form-row">
    <div class="col">
      <input id="datevir" name="dateVirement" class="form-control" placeholder="Date virement">
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
      <input type="text" name="montantVirement" class="form-control" placeholder="Monatnt">
    </div>

  </div>

  <div class="form-group form-row">
    <div class="col">
      <input type="text" name="banqueVirement" class="form-control" placeholder="Banque">
    </div>
    <div class="col">
      <input type="text" name="libelleVirement" class="form-control" placeholder="Libellé virement">
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name="submitVirement">Valider</button>
  
</form>


  </div>
</div>
  <!-- Le reste du contenu -->



<?php echo $v1; ?>
<?php include '../Blocs_HTML/footer.php'; ?>

</body>
</html>