<?php  
       session_start();

if(!isset($_SESSION['login'])){

header("Location:../index.php");

}
  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Accueil Admin</title>
  <!--<link rel="stylesheet" href="../CSS/Style.css">-->
</head>
<body>
  ...
 <h1>  Bonjour mounir cliquer ici pour déconnecté </h1>
 <a href="../deconnection_session.php">Déconnection</a>
  <!-- Le reste du contenu -->
  ...
</body>
</html>