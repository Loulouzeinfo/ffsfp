<?php

session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$ids = require 'paypal.php';
require '../vendor/autoload.php';

$anne = intval(date('Y'));
$date = date('d').'/'.date('m').'/'.$anne;
$anne = ++$anne;
if (isset($_SESSION['ses'])) {
    $personne = $_SESSION['ses']['personne'];
    $libelle = $_SESSION['ses']['libelle'];
    $montant = $_SESSION['ses']['mntant'];
    $tarif = iconv('UTF-8', 'ISO-8859-1//IGNORE', $_SESSION['ses']['tarification']);

    $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        $ids['id'],
        $ids['secret']
    )
);

    $payement = \PayPal\Api\Payment::get($_POST['paymentID'], $apiContext);

    $excution = (new \PayPal\Api\PaymentExecution())
       ->setPayerId($_POST['payerID'])
       ->setTransactions($payement->getTransactions);

    try {
        //code...
        $payement->execute($excution, $apiContext);
        $stat = $payement->getState();

        $Tarification = iconv('UTF-8', 'ISO-8859-1//IGNORE', 'adhésion');

        if ($stat == 'approved') {
            if ($_SESSION['ses']['tarification'] == $Tarification) {
                $sqlup = "UPDATE cotisationniveau SET  cotisationN= 'renouvellement', anneCotisation='$anne'  WHERE id_personne='$personne' ";
                insertDB($sqlup);
            } else {
                $sqlup = "UPDATE cotisationniveau SET cotisationN= 'renouvellement', anneCotisation='$anne'  WHERE id_personne='$personne' ";
                insertDB($sqlup);
            }

            $ajout = "INSERT INTO paiement_histrorique (id_personne,libelle_annee,tarification_historique,montant_historique,moyen_paiment,date_paiment) VALUES ('$personne','$libelle','$tarif','$montant','Paypal','$date') ";
            insertDB($ajout);
        }

        echo json_encode([
      'id' => $payement->getId(),
      'stat' => $payement->getState(),
      'date' => $payement->getCreateTime(),
    ]);
    } catch (\PayPal\Exception\payPalConnectionException $e) {
        var_dump(json_decode($e->getData()));
    }
}
