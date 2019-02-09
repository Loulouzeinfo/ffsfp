<?php
session_start();
include '../Fonction/fonction.php';

$v1 = '';
$v2 = '';
$tab = array();

if (isset($_POST['submit'])) {
    $mail = trim(strtolower(verif($_POST['mail'])));
    $password = verif($_POST['password']);

    if (!empty($mail) && !empty($password)) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $v1 = "<script>
               swal({
                text: \"votre adresse mail n'est pas valide!\",
                 icon: \"error\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";
        } else {
            include '../DB/base.php';
            $password = $mysqli->real_escape_string($password);

            $password = hash('sha256', $password);

            $sql = "SELECT * FROM personne WHERE  mail='$mail' AND password='$password'";

            if (RowsOne($sql) == true) {
                $_SESSION['login'] = $mail;
                $_SESSION['action'] = time();
                header('Location:../Administrateur/accueil.php');
                $mysqli->close();
                exit;
            } else {
                $v2 = "<script>
                 swal({
                title: \"Erreur !\",
                text: \"L'identifiant et/ou le mot de passe sont incorrects\",
                icon: \"error\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";
            }
        }
    }
} else {
    header('Location:../index.php');
}

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