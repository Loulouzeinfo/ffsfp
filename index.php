<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		
		 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		 <meta name="google-site-verification" content="NluemRFNnltepgPzQqe_HY_tv_z8SgkxxIRqRjIf5VQ" />
     
		<title>Athentification</title>
		<link rel="icon" type="image/png" href="Images/favicon.png" />
		<link rel="stylesheet" href="CSS/Style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

         <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	</head>
	<body class="index">

		<div class="loginBox ">
			<img src="Images/POP.gif" class="user">
			<h2 style="    color: darkgrey; font-family: none;"><center>PLATON</center></h2>
			<h3><center>Connexion</center></h3>
			<form action="Connection/connection.php" method="post">
				<div class="text">
                <i class="fa fa-user"></i>
				<input type="text" name="mail" placeholder="login" autofocus required/>
				</div>

				<div class="text">
			    <i class="fas fa-unlock"></i>
				<input type="password" name="password" placeholder="••••••••••" autofocus required/>
                </div>

			   
			   
				<input type="submit" name="submit" value="Valider">
				<a href="motDePasseOublie.php">mot de passe oublié !</a>
			
			</form>
		</div>
		

<?php    include("Blocs_HTML/politique.php"); ?>


<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


	</body>
</html>