<?php
session_start();
include("../Fonction/fonction.php");

$v1='';
$v2='';

if(isset($_POST['submit'])){



	$mail= trim(verif($_POST['mail']));
	$password= verif($_POST['password']);

	   if(!empty($mail) && !empty($password)){
            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){

                
               $v1="<script>
               swal({
                title: \"Oups!\",
                text: \"votre adresse mail n'est valide!\",
                type: \"success\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";
                 

               
               
             }else{

                  include("../DB/base.php");
                  $password= $mysqli->real_escape_string ($password);
                  $password= hash('sha256', $_POST['password']);
                  $donn=$mysqli->query("SELECT * FROM personne WHERE mail='$mail' AND password='$password'")or die(mysqli_error($mysqli));
                  $res= $donn->fetch_array();
                  if($res['id_role']==1){
                  	$_SESSION['login']=$mail;
		            header("Location:../Administrateur/Accueil.php");

		            exit;

                  }else {
                  	$v2="<script>

                 swal({
                title: \"Oups!\",
                text: \"Mot de passe incorrect!\",
                type: \"success\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";
                  }


               
             }

           



	   }

             
	}else 

	header("Location:../index.php");






?>


<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
	<body>

       <?php  echo $v1;
              


              echo $v2; 
         ?>

	</body>
	</html>