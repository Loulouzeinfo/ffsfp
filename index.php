<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		
		 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Athentification</title>
		<link rel="stylesheet" href="CSS/Style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


	</head>
	<body class="index">

		<div class="loginBox ">
			<img src="Images/POP.gif" class="user">
			<h2><center>Identification</center></h2>
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
				<a href="mot_de_passe_oublié.php">mot de passe oublié !</a>
			
			</form>
		</div>


		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>