<?php

require '../class/class.phpmailer.php';
    $mail = new PHPMailer;
    $mail -> charSet = "UTF-8";
    $mail->IsSMTP();                //Sets Mailer to send message using SMTP
    $mail->Host = 'smtp.gmail.com';   //Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->Port = 587;                //Sets the default SMTP server port
    $mail->SMTPAuth = true;             //Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'chikhouneloulouze@gmail.com';          //Sets SMTP username
    $mail->Password = 'Chikhounemouloud06';         //Sets SMTP password
    $mail->SMTPSecure = 'tls';              //Sets connection prefix. Options are "", "ssl" or "tls"
    $mail->From = $mailP;      //Sets the From email address for the essage
    $mail->FromName = 'FFSFP';
    $mail->AddAddress($mailP, 'name');   //Adds a "To" address
      //Adds a "Cc" address
    $mail->WordWrap = 50;             //Sets word wrapping on the body of the message to a given number of characters
    $mail->IsHTML(true);
       //Adds a "To" address
      //Adds a "Cc" address
                 //Sets message type to HTML       

    ?>