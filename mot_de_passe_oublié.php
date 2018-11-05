<?php
include("Fonction/fonction.php");

$error = '';
$email = '';
$mailnx='';
$ran=aleatoire(6,5);



function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{
	$email = strtolower(clean_text($_POST["email"]));

	if(empty($_POST["email"]))
	{
		$error = "<script>
                swal({
                title: \"Oops!\",
                text: \"Entrer votre adresse mail s'il vous plaît ! \",
                icon: \"warning\"
                }).then(function() {
                window.location = \"mot_de_passe_oublié.php\";
                 });
               
               </script>";
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		    
			   $error = "<script>
                swal({
                title: \"Oops!\",
                text: \"Le format de votre adresse mail est incorrect ! \",
                icon: \"warning\"
                }).then(function() {
                window.location = \"mot_de_passe_oublié.php\";
                 });
               
               </script>";
		}else{


		include("DB/base.php");

	$donn=$mysqli->query("SELECT * FROM personne WHERE mail='$email' AND uid_inscription ='NULL' ")or die(mysqli_error($mysqli));
	$res= $donn->num_rows;

	if($res==1)                    
	{
        $sql = "UPDATE personne SET uid='$ran' WHERE mail='$email'";
        $mysqli->query($sql);
		require 'class/class.phpmailer.php';
		$mail = new PHPMailer;
		$mail -> charSet = "UTF-8";
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = 587;								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'chikhouneloulouze@gmail.com';					//Sets SMTP username
		$mail->Password = 'Chikhounemouloud06';					//Sets SMTP password
		$mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = $_POST["email"];			//Sets the From email address for the essage
		$mail->FromName = 'FFSFP';
		$mail->AddAddress($_POST["email"], 'name');		//Adds a "To" address
			//Adds a "Cc" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML				
		$mail->Subject = utf8_decode('réinitialisation de mot de passe');				//Sets the Subject of the message
		$mail->Body = '<p>Bonjour</p>
		  <p>Merci de cliquer sur le lien ci-dessous afin de (ré)initialiser votre mot de passe:<p><br/>
          http://localhost/ffsfp/reset.php?rmail='.$email.'&uid='.$ran.'<br/>
          <p>Si le clic du lien ne fonctionne pas, merci de le copier/coller dans la barre d\'adresse de votre navigateur.</p><br/>
          Bien cordialement<br/>
          L\'équipe de FFSFP';			                //An HTML or plain text message body
		if($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$error = "<script>
                swal({
                title: \"Oops!\",
                text: \"Vérifiez votre boîte de réception. FFSFP envoie immédiatement un message à l\'adresse email associée à votre compte. \",
                icon: \"success\"
                }).then(function() {
                window.location = \"index.php\";
                 });
               
               </script>";
               
		}
		else
		{
			
			echo "mail === ". $mail->ErrorInfo;
		}
		
	}else{

        $error="<script>
                swal({
                title: \"Oops!\",
                text: \"l'adresse mail n'existe pas \",
                icon: \"error\"
                }).then(function() {
                window.location = \"mot_de_passe_oublié.php\";
                 });

                 </script>";
               
		
            }

        }

	
}
	



	

?>


<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h3 align="center">Réinitialiser votre mot de passe</h3>
					<br />
					<?php echo $error; ?>
					<form method="post">
						
						<div class="form-group">
							<label>Entrez votre Email</label>
							<input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
						</div>
						
						
						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Envoyer" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php    echo $error ;?>
	</body>
</html>





