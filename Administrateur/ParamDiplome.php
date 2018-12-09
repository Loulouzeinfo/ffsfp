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
   $sql22="SELECT * FROM personne WHERE mail='$sess'";
  $donpro= $mysqli->query($sql22)or die(mysqli_error($mysqli));
  $respro= $donpro->fetch_array();
  $profile=$respro['prenom'];


  if(isset($_POST['submit'])){

       if(!empty($_POST['cotisation']) && !empty($_POST['montant'])){

                 $cotisation= $mysqli->real_escape_string(trim(verif($_POST['cotisation'])));
                 $montant= $mysqli->real_escape_string(trim(verif($_POST['montant'])));

                $sqlD="INSERT INTO diplome(libelle_diplome,montant_diplome) VALUES ('$cotisation','$montant' )";
                insertDB($sqlD);

                $v1="<script> dialogsuccess(\"Enregistré\"); </script>";


 




       }else{

            $v1="<script> dialoginfo(\"Tous les champs sont Obligatoirs !\"); </script>";
       }
  }

    
  
  }



  ?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  
  <?php  include("../Blocs_HTML/script_bootstrap_header.php");  ?>

  <title>Coût de diplôme</title>
  <link rel="stylesheet" href="../CSS/Style.css">





<body>

 <?php    include("../Blocs_HTML/nav.php"); ?>

<div class="jumbotron jumbotron-fluid cotisation accueil">
  <div class="container">
    <h1 class="display-6">Paramétrage du coût du diplôme </h1>

        <form method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Libellé : </label>
      <input type="text" class="form-control" id="libellecotisation" placeholder="Cotisation" name="cotisation" >
    </div>
  </div>

    <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Montant : </label>
      <input type="number" class="form-control" id="montantcotisation" placeholder="Montant EURO" name="montant" >

    </div>
  </div>


    <div class="form-row">
   <div class="col-md-4 mb-3">
      <button type="submit" class="btn btn-primary" name="submit">Validé</button>
</div>
    </div>

</form>


</div>
</div>

<?php  echo $v1;   ?>
<?php    include("../Blocs_HTML/footer.php"); ?>


</body>
</html>