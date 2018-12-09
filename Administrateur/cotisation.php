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

    $cotisation=$mysqli->real_escape_string(trim(verif($_POST['cotisation'])));
    $montant=$mysqli->real_escape_string(trim(verif($_POST['montant'])));
    $valide=$mysqli->real_escape_string(trim(verif($_POST['valide'])));

    if(!empty($cotisation) && !empty($montant) && !empty($valide)){


      $sql="INSERT INTO cotisation (libelle_cotisation,montant,date_validite) VALUES ('$cotisation','$montant','$valide')";
      insertDB($sql);

       $v1="<script>
               swal({
                
                text: \"Enregistré !\",
                icon: \"info\"
                });
               
               </script>";
  

    }else{
       $v1="<script>
               swal({
                
                text: \"tous les champs sont obligatoires !\",
                icon: \"info\"
                });
               
               </script>";
    }


  


  }

    
  
  }



  ?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  
  <?php  include("../Blocs_HTML/script_bootstrap_header.php");  ?>

  <title>Cotisation</title>
  <link rel="stylesheet" href="../CSS/Style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<body>

 <?php    include("../Blocs_HTML/nav.php"); ?>

<div class="jumbotron jumbotron-fluid cotisation accueil">
  <div class="container">
    <h1 class="display-6">Paramétrage des cotisations </h1>

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
      <label for="validationDefault01">Validité : </label>
      <input  class="form-control" id="datepicker"  name="valide" placeholder="Date de Validité" >
    </div>

        <script type="text/javascript">
      $('#datepicker').datepicker({

            altField: "#datepicker",
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            minDate: 0

        });

    </script>
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