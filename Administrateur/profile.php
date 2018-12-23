<?php  
session_start();
include("../Fonction/fonction.php");
include("../DB/base.php");
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

  
  $sess= $_SESSION['login'];
  $sql22="SELECT * FROM personne WHERE mail='$sess'";
  $donpro= $mysqli->query($sql22)or die(mysqli_error($mysqli));
  $respro= $donpro->fetch_array();
  $profile=$respro['prenom'];


  if(isset($_POST['submit'])){

    if(empty($_POST['motPasse']) && empty($_POST['nouvPasse'])){

      $v1="<script> dialogsuccess(\"Votre profil a bien été mis à jour\",\"accueil.php\"); </script>";
    }else{

                $motPasse= $mysqli->real_escape_string(trim(verif($_POST['motPasse'])));
                $nouvPasse= $mysqli->real_escape_string(trim(verif($_POST['nouvPasse'])));

                if($motPasse != $nouvPasse){
                  $v1="<script> dialoginfo(\"Le mot de passe n'est pas identique\",\"profile.php\"); </script>";
                }else{

                  $motPasse= hash('sha256', $motPasse);

                  $sqlup= "UPDATE personne SET password='$motPasse'  WHERE mail='$sess' ";
                  insertDB($sqlup);
                  $v1="<script> dialogsuccess(\"Mise à jour réussit\", \"profile.php\"); </script>";



                }

    }



  }


 

}//elselogin



  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php  include("../Blocs_HTML/script_bootstrap_header.php");  ?>

  <title>Ajouter d'adhérents</title>

  <link rel="stylesheet" href="../CSS/Style.css">


</head>
<body>

 <?php    include("../Blocs_HTML/nav.php"); ?>

<div class="jumbotron jumbotron-fluid cotisation accueil">
  <div class="container">
    <h1 class="display-6">Mon profil </h1>

        <form method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Changer mon mot de passe : </label>
      <input type="password" class="form-control" id="motPasse" placeholder="Nouveau mot de passe" name="motPasse" >
    </div>
  </div>

    <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Répéter le nouveau mot de passe : </label>
      <input type="password" class="form-control" id="nouvPasse" placeholder="Confirmez le mot de passe" name="nouvPasse" >

    </div>
  </div>

    <div class="form-row">
   <div class="col-md-4 mb-3">
      <button type="submit" class="btn btn-primary" name="submit">Valider</button>
</div>
    </div>

</form>


</div>
</div>

<?php  echo $v1;   ?>
<?php    include("../Blocs_HTML/footer.php"); ?>

</body>
</html>