<?php  
 session_start();
 include("../DB/base.php");
 include("../Fonction/fonction.php");
$tab=array();
$profile='';
$v1='';

if(!isset($_SESSION['login'])){ 
header("Location:../index.php");

}else{


  if(isset($_SESSION['action']) AND (time()-$_SESSION['action'])<300 ){

    $_SESSION['action'] = time();


  }else{

         $v1="<script>
               swal({
                
                text: \"Vous êtes déconnecté !\",
                icon: \"info\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";

  }
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


<div class="jumbotron accueil">
  <div class="container">
    
    
  </div>
</div>

<?php   echo $v1; ?>


<?php    include("../Blocs_HTML/footer.php"); ?>


</body>
</html>