 <?php


 require_once '../class/class.phpmailer.php';
    $mail = new PHPMailer;
    $mail -> charSet = "UTF-8";
    $mail->Username = 'admin@ffsfplaton.ovh';          
    $mail->Password = 'Chikhounemouloud06';                
    $mail->From = 'admin@ffsfplaton.ovh' ;  
    $mail->FromName = 'FFSFP';
    $mail->AddAddress($e[3]);  
    $mail->WordWrap = 50;           
    $mail->IsHTML(true);


    ?>