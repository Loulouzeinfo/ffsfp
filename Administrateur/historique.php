<?php  
 session_start();
 include("../DB/base.php");
 include("../Fonction/fonction.php");
$tab=array();
$profile='';
$v1='';
$tabH=array();
$tabD=array();

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



  $historique="SELECT * FROM cotisation";
  $donnhist=$mysqli->query($historique)or die(mysqli_error($mysqli));
  while($resH= $donnhist->fetch_array()){
     $tabH[]=$resH;
  }



  $DiplomeC="SELECT * FROM diplome";
  $donndip=$mysqli->query($DiplomeC)or die(mysqli_error($mysqli));
  while($resD= $donndip->fetch_array()){
     $tabD[]=$resD;
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

    <div class=" HistoriqueCoti">

      <h3>Historique cotisations</h3>

      <div class="table-wrapper-scroll-y">
      <table class="table table-striped " >
  <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé de cotisation</th>
      <th scope="col">Montant</th>
      <th scope="col">date de validité</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php
     foreach ($tabH as $key) {
       echo "<tr>
      <th scope=\"row\">".utf8_encode($key['libelle_cotisation'])."</th>
      <td>".utf8_encode($key['montant'])." € </td>
      <td>".utf8_encode($key['date_validite'])."</td>
      <td>
      <a href=\"historique.php?supp=".utf8_encode($key['id_cotisation'])."\"><i class=\"fas fa-trash-alt\"></i></a>&nbsp;
      <a href=\"editeCotisation.php?edit=".utf8_encode($key['id_cotisation'])."\"><i class=\"fas fa-user-edit\"></i></a>&nbsp;

      </td>
    </tr>";
     }
    

    ?>
    
    
  </tbody>
</table>

</div>

    </div>

    <div class="HistoriqueForm">
      <h3>historique de coût de formations</h3>

      <div class="table-wrapper-scroll-y">
      <table class="table table-striped " >
  <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé de Diplôme</th>
      <th scope="col">Montant</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody id="ul">

    <?php
     foreach ($tabD as $key) {
       echo "<tr>
      <th scope=\"row\">".utf8_encode($key['libelle_diplome'])."</th>
      <td>".utf8_encode($key['montant_diplome'])." € </td>
      <td>
      <a href=\"historique.php?supp=".utf8_encode($key['id_diplome'])."\"><i class=\"fas fa-trash-alt\"></i></a>&nbsp;
      <a href=\"editeDiplome.php?edit=".utf8_encode($key['id_diplome'])."\"><i class=\"fas fa-user-edit\"></i></a>&nbsp;

      </td>
    </tr>";
     }
    

    ?>
    
    
  </tbody>
</table>

</div>

    </div>
    
</div>

<?php   echo $v1; ?>


<?php    include("../Blocs_HTML/footer.php"); ?>


</body>
</html>