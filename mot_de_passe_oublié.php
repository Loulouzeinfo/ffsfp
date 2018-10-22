<?php
//index.php

$error = '';
$email = '';
$mailnx='';


function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{

	if(empty($_POST["email"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	}
	else
	{
		$email = clean_text($_POST["email"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}

	include("DB/base.php");
	$donn=$mysqli->query("SELECT * FROM personne WHERE mail='$email'")or die(mysqli_error($mysqli));
	$res= $donn->num_rows;
	if($res==1){
                     
                     if($error == '')
	{
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
		$mail->Body = 'Cliquez sur le lien de réinitialisation figurant dans ce message.<br/> http://localhost/ffsfp/profile.php?rmail='.$email;				//An HTML or plain text message body
		if($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$error = '<label class="text-success">Vérifiez votre boîte de réception. FFSFP envoie immédiatement un message à l\'adresse email associée à votre compte.</label>';
		}
		else
		{
			$error = '<label class="text-danger">There is an Error</label>';
			echo "mail === ". $mail->ErrorInfo;
		}
		
		$email = '';
		
	}

	}else{

        $mailnx='<SCRIPT LANGUAGE="JavaScript"> swal("l\'adresse mail n\'existe pas ");</SCRIPT>';
		
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

		<?php  echo $mailnx;  ?>
	</body>
</html>





