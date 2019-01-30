<?php

session_start();
$ids = require 'paypal.php';
require '../vendor/autoload.php';

if (isset($_SESSION['ses'])) {
    $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        $ids['id'],
        $ids['secret']
    )
);

    $liste = new \PayPal\Api\ItemList();
    $item = new \PayPal\Api\Item();
    $item->setName($_SESSION['ses']['tarification']);
    $item->setPrice($_SESSION['ses']['mntant']);
    $item->setCurrency('EUR');
    $item->setQuantity(1);

    $liste->addItem($item);

    $details = (new \PayPal\Api\Details())
              ->setSubtotal($_SESSION['ses']['mntant']);

    $amount = (new \PayPal\Api\Amount())
              ->setTotal($_SESSION['ses']['mntant'])
              ->setCurrency('EUR')
              ->setDetails($details);
    $transaction = (new \PayPal\Api\Transaction())
                ->setItemList($liste)
                ->setDescription('Cotisation')
                ->setAmount($amount)
                ->setCustom('demo-1');

    $payement = new \PayPal\Api\Payment();
    $payement->setTransactions([$transaction]);
    $payement->setIntent('sale');
    $redirectUrls = (new \PayPal\Api\RedirectUrls())
                ->setReturnUrl('https://www.ffsfplaton.ovh/Administrateur/pay.php')/*https:www.ffsfplaton.ovh/Administrateur/pay.php*/
                ->setCancelUrl('https://www.ffsfplaton.ovh/Administrateur/cotisationAdherent.php'); /*https:www.ffsfplaton.ovh/Administrateur/cotisationAdherent.php */

    $payement->setRedirectUrls($redirectUrls);
    $payement->setPayer((new \PayPal\Api\Payer())->setPaymentMethod('paypal'));

    try {
        //code...
        $payement->create($apiContext);
        echo json_encode([
            'id' => $payement->getId(),
        ]);
    } catch (\PayPal\Exception\payPalConnectionException $e) {
        var_dump(json_decode($e->getData()));
    }
}
