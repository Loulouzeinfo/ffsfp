<?php
 session_start();
include("DB/base.php");
$mailen='';
 
   if(isset($_SESSION['etape_1']['resmail']) &&  isset($_SESSION['etape_1']['respassword']) && isset ($_SESSION['etape_1']['resRpassword'] )){
              $sess=$_SESSION['etape_1']['resmail'];
                      if($_SESSION['etape_1']['respassword'] == $_SESSION['etape_1']['resRpassword']){
                 $password1= $mysqli->real_escape_string ($_SESSION['etape_1']['respassword']);//injection SQL
                   $password1= hash('sha256', $password1);
                   $sql = "UPDATE personne SET password='$password1' , uid= 'NULL' WHERE mail='$sess'";
                   $mysqli->query($sql);

      require 'class/class.phpmailer.php';
      $mail = new PHPMailer;
      $mail -> charSet = "UTF-8";
      $mail->IsSMTP();                       //Sets Mailer to send message using SMTP
      $mail->Host = 'smtp.gmail.com';     //Sets the SMTP hosts of your Email hosting, this for Godaddy
      $mail->Port = 587;                        //Sets the default SMTP server port
      $mail->SMTPAuth = true;                   //Sets SMTP authentication. Utilizes the Username and Password variables
      $mail->Username = 'chikhouneloulouze@gmail.com';               //Sets SMTP username
      $mail->Password = 'Chikhounemouloud06';               //Sets SMTP password
      $mail->SMTPSecure = 'tls';                   //Sets connection prefix. Options are "", "ssl" or "tls"
      $mail->From = $sess;         //Sets the From email address for the essage
      $mail->FromName = 'FFSFP';
      $mail->AddAddress($sess, 'name');     //Adds a "To" address
         //Adds a "Cc" address
      $mail->WordWrap = 50;                     //Sets word wrapping on the body of the message to a given number of characters
      $mail->IsHTML(true);                   //Sets message type to HTML            
      $mail->Subject = utf8_decode('Activation de votre compte');          //Sets the Subject of the message
      $mail->Body = '<p>Bonjour<p>
<p>Votre compte a été validé sur FFSFP. Vous pouvez
désormais vous connecter avec les identifiants suivants et profiter pleinement
des services du FFSFP.<p>
<p>Identifiant: chikhouneloulouze@gmail.com</p>
<p>Bien cordialement, Les FFSFP</p>';         //An HTML or plain text message body
      if($mail->Send())                      //Send an Email. Return true on success or false on error
      {
         $error = '<label class="text-success">Vérifiez votre boîte de réception. FFSFP envoie immédiatement un message à l\'adresse email associée à votre compte.</label>';
      }
      else
      {
         $error = '<label class="text-danger">There is an Error</label>';
         echo "mail === ". $mail->ErrorInfo;
      }
   
              }
        session_destroy();
    $mailen="<script>

                swal({
                title: \"OK!\",
                text: \"Vérifiez votre boîte de réception. FFSFP envoie immédiatement un message à l\'adresse email associée à votre compte.\",
                type: \"success\"
                }).then(function() {
                window.location = \"index.php\";
                 });
               
               </script>";

      
     
   }else{
      session_destroy();
      header("Location:index.php");
   }

          
          



         ?>

<!doctype html>
<html lang="fr">
<head>
	 
		<title>Accueil Admin</title>
		
  

</head>
<body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php   echo $mailen; ?>


</body>
</html>