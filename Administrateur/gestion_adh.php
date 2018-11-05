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
  $sess=$_SESSION['login'];
  $sql2="SELECT * FROM personne WHERE mail='$sess'";
  $donpro= $mysqli->query($sql2)or die(mysqli_error($mysqli));
  $respro= $donpro->fetch_array();
  $profile=$respro['prenom'];
  
  $sql="SELECT * FROM personne";
  $donn=$mysqli->query($sql)or die(mysqli_error($mysqli));
  while($res= $donn->fetch_array()){
     $tab[]=$res;
  }
  
if(isset($_GET['supp'])){


      
   if(!empty($_GET['supp'])){
          
     $supp= $mysqli->real_escape_string(trim(verif($_GET['supp'])));

     $sqlre="SELECT id_personne FROM personne WHERE mail='$supp'";
     $donnre=$mysqli->query($sqlre)or die(mysqli_error($mysqli));
     $resre=$donnre->fetch_array();
     $idp=$resre['id_personne'];

     $sqldel="DELETE FROM assoc_per_rol WHERE  id_personne= '$idp'; ";
     $sqldel.="DELETE FROM personne WHERE mail='$supp' ; ";
     $mysqli->multi_query($sqldel)or die(mysqli_error($mysqli));

             $v1="<script>
               swal({
                title: \"Oups!\",
                text: \"supprimé!\",
                icon: \"success\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
     



   }else{
           
               $v1="<script>
               swal({
                title: \"Oups!\",
                text: \"le Paramètre est valide!\",
                icon: \"error\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";

   }


}
             /* */






}

  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php  include("../Blocs_HTML/script_bootstrap_header.php");  ?>

  <title>gestion d'adhérents</title>
  <link rel="stylesheet" href="../CSS/Style.css">

</head>
<body>
 
 <?php    include("../Blocs_HTML/nav.php"); ?>

<div class="tab">
<table class="table table-striped" style="overflow-y:scroll">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Numéro d'adérents</th>
      <th scope="col">Nom</th>
      <th scope="col">Prénom</th>
      <th scope="col">Adresse Mail</th>
      <th scope="col">Adresse</th>
      <th scope="col">Code postale</th>
      <th scope="col">Ville</th>
      <th scope="col">Département</th>
      <th scope="col">Modifier</th>

    </tr>
  </thead>
  <tbody>

    <?php
     foreach ($tab as $key) {
       echo "<tr>
      <th scope=\"row\">".$key['id_personne']."</th>
      <td>".$key['nom']."</td>
      <td>".$key['prenom']."</td>
      <td>".$key['mail']."</td>
      <td>".$key['addresse']."</td>
      <td>".$key['code_postale']."</td>
      <td>".$key['ville']."</td>
      <td>".utf8_encode($key['Departement'])."</td>
      <td>
      <a href=\"gestion_adh.php?supp=".$key['mail']."\"><i class=\"fas fa-trash-alt\"></i></a>&nbsp;
      <a href=\" \"><i class=\"fas fa-user-edit\"></i></a>&nbsp;
      <a  href=\" \" data-toggle=\"modal\" data-target=\"#".$key['nom']."\"><i class=\"fas fa-search-plus\"></i></a>


  <div class=\"modal fade\" id=".$key['nom']." tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">".$key['nom']." ".$key['prenom']."</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
      <label> Date de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".$key['date_de_naissance']." readonly>
     <label> Lieu de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".$key['lieu_de_naissance']." readonly>
       <label> Pays de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".$key['pays_naissance']." readonly>
        <label> Departement de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".$key['departement_naissance']." readonly>
       <label> Profession : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".$key['profession']." readonly>



      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>









      </td>
    </tr>";
     }
    

    ?>
    
    
  </tbody>
</table>
</div>
  <!-- Le reste du contenu -->


<?php  echo $v1;   ?>
<?php    include("../Blocs_HTML/footer.php"); ?>

      

</body>
</html>