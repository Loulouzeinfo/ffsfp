<?php  
 session_start();
 include("../DB/base.php");
$tab=array();
$profile='';

if(!isset($_SESSION['login'])){ 
header("Location:../index.php");

}else{
  $sess=$_SESSION['login'];
  $sql2= "SELECT * FROM personne WHERE mail='$sess'";
  $donpro= $mysqli->query($sql2)or die(mysqli_error($mysqli));
  $respro= $donpro->fetch_array();
  $profile=$respro['prenom'];

  $sql="SELECT * FROM personne";
  $donn=$mysqli->query($sql)or die(mysqli_error($mysqli));
  while($res= $donn->fetch_array()){
     $tab[]=$res;
  }

}


  ?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  
  <?php  include("../Blocs_HTML/script_bootstrap_header.php");  ?>
  <title>accueil admin</title>
  <link rel="stylesheet" href="../CSS/Style.css">

<body>

 <?php    include("../Blocs_HTML/nav.php"); ?>


<div class="jumbotron">
  <div class="container">
    <h1 class="display-4">Fluid jumbotron</h1>
    <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
  </div>
</div>



<?php    include("../Blocs_HTML/footer.php"); ?>


</body>
</html>