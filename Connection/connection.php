<?php
session_start();
include("../Fonction/fonction.php");

$v1='';
$v2='';
$tab=array();

if(isset($_POST['submit'])){

	$mail= trim(strtolower(verif($_POST['mail'])));
	$password= verif($_POST['password']);

	   if(!empty($mail) && !empty($password)){
            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){

                
               $v1="<script>
               swal({
                title: \"Oops!\",
                text: \"votre adresse mail n'est valide!\",
                 icon: \"error\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";
                 

               
               
             }else{

                  include("../DB/base.php");
                  $password= $mysqli->real_escape_string ($password);
                  $password= hash('sha256', $password);

                  $sql="SELECT assoc_per_rol.id_role FROM personne,role,assoc_per_rol WHERE personne.id_personne=assoc_per_rol.id_personne AND role.id_role=assoc_per_rol.id_role AND
                    mail='$mail' AND password='$password'";
                  $donn=$mysqli->query($sql)or die(mysqli_error($mysqli));
                   while ($res= $donn->fetch_array()) {
                    $tab[]=$res['id_role'];
                  }

                  if(in_array(1,$tab)){
                  	$_SESSION['login']=$mail;
		                header("Location:../Administrateur/accueil.php");
                    $mysqli->close();
		                 exit;

                  }else {
                  	$v2="<script>
                 swal({
                title: \"Oops!\",
                text: \"Mot de passe incorrect!\",
                icon: \"error\"
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