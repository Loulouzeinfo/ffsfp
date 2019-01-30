<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$tab = array();
$profile = '';
$v1 = '';

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

    $o = utf8_encode($resco['tarification']);

    $_SESSION['ses'] = array(
      'tarification' => $o,
      'mntant' => $resco['montant'],
      'libelle' => $resco['libelle_cotisation'],
      'personne' => $resco['id_personne'],
    );
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
        echo '<tr>
        <th scope="row">'.$resco['libelle_cotisation'].'</th>
        <td>'.utf8_encode($resco['tarification']).'</td>
        <td>'.$resco['montant'].' € </td>
        <td>'.$resco['date_validite'].'</td>
        <td>'; ?>

<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    // Customize button (optional)
    locale: 'fr_FR',
    style: {
      size: 'responsive',
      color: 'blue',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
     return paypal.request.post('paiement.php').then(function (data) {
       return data.id; 
     }); 
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
    
        // Show a confirmation message to the buyer
        return paypal.request.post('pay.php',{
        paymentID: data.paymentID,
        payerID: data.payerID
        }).then(function(data){
            console.log(data);
       dialogsuccess("Paiement effectué avec succès", "cotisationAdherent.php");
            
            
        }).catch(function(err){
          console.log(err);
        });
       
     
    }
  }, '#paypal-button');

</script>
        
       <?php    echo '</td></tr>';
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