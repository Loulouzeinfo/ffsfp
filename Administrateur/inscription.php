<?php 
include("../Fonction/fonction.php");
include("../DB/base.php");

$v1='';
$pay=array();
$dep=array();
$donreq=array(
 
      'id_personne' => '', 
      'nom' => '', 
      'prenom' => '', 
      'mail' => '',
      'date_de_naissance' => '',
      'lieu_de_naissance' => '',
      'pays_naissance' => '',
      'departement_naissance' => '',
  );

  $sql1="SELECT * FROM t_pays ";
  $donnpays= $mysqli->query($sql1)or die(mysqli_error($mysqli));
  while ($res=$donnpays->fetch_array()) {
    
    $pay[]=$res;
  }

   $sqldp="SELECT DISTINCT  departement FROM villefrance ORDER BY departement ASC  ";
  $donndep= $mysqli->query($sqldp)or die(mysqli_error($mysqli));
  while ($resdep=$donndep->fetch_array()) {
    
    $dep[]=$resdep;
  }


if ( isset ( $_GET['mail']) &&  isset($_GET['uid_inscription'])) {
 

  if(empty($_GET['mail']) || empty($_GET['uid_inscription'])) {

    
               
               $v1="<script>
               swal({
                text: \"Les paramètres de URL sont pas valide!\",
                icon: \"info\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";


  }else{

     $mail= $mysqli->real_escape_string(trim(verif($_GET['mail'])));
     $ins= $mysqli->real_escape_string(trim(verif($_GET['uid_inscription'])));
     $sq="SELECT * FROM personne WHERE mail='$mail' AND uid_inscription='$ins' ";
     $resrq= $mysqli->query($sq)or die(mysqli_error($mysqli));
     $donreq=$resrq->fetch_array();

     if (($mail != $donreq['mail']) || ($ins != $donreq['uid_inscription']) ) {
       # code...

      $v1="<script>
               swal({
                text: \"le mail ou bien UID n'existe pas !\",
                icon: \"info\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               
               </script>";
     }

  }



  # code...
}else{

  header("Location:../index.php");
}


if(isset($_POST['submit'])){

  if(isset($_POST['prefession']) && isset($_POST['adresse']) && isset($_POST['code_postale']) && isset($_POST['pays']) && isset($_POST['villle']) && isset($_POST['motP']) && isset($_POST['motPr']) ){

                  $prefession=$mysqli->real_escape_string(trim(verif($_POST['prefession'])));
                  $adresse=$mysqli->real_escape_string(trim(verif($_POST['adresse'])));
                  $code_postale=$mysqli->real_escape_string(trim(verif($_POST['code_postale'])));
                  $payss=$mysqli->real_escape_string(trim(verif($_POST['pays'])));
                  $vils=$mysqli->real_escape_string(trim(verif($_POST['villle'])));
                  $motP=$mysqli->real_escape_string(trim(verif($_POST['motP'])));
                  $motPr=$mysqli->real_escape_string(trim(verif($_POST['motPr'])));
                  $residence=$mysqli->real_escape_string(trim(verif($_POST['departement_residence'])));

      if(empty($_POST['prefession']) && empty($_POST['adresse']) && empty($_POST['code_postale']) && empty($_POST['villle']) && empty($_POST['motP']) && empty($_POST['motPr']) ){
        

                  $v1="<script>
               swal({
                text: \"Tous les champs sont oblégatoires\",
                icon: \"info\"
                }).then(function() {
                window.location = \"inscription.php?mail=".$_GET['mail']."&uid_inscription=".$_GET['uid_inscription']." \";
                 });
               </script>";

}else{

           if (($_POST['pays']=="NULL") || $_POST['departement_residence']=="NULL") {
             # code...
                $v1="<script>
               swal({
                text: \"Choissisez votre Pays/Département de résidence\",
                icon: \"info\"
                }).then(function() {
                window.location = \"inscription.php?mail=".$_GET['mail']."&uid_inscription=".$_GET['uid_inscription']." \";
                 });
               </script>";

           }else{

            

                if ($motP!= $motPr) {
                  # code...

                   $v1="<script>
                 swal({
                text: \"le mot de passe n'est pas identique\",
                icon: \"info\"
                }).then(function() {
                window.location = \"inscription.php?mail=".$_GET['mail']."&uid_inscription=".$_GET['uid_inscription']." \";
                 });
               </script>";
                }else{


                   $mail= $mysqli->real_escape_string(trim(verif($_GET['mail'])));
                  $password= hash('sha256', $motP);
                  $sqlup= "UPDATE personne SET addresse='$adresse', code_postale='$code_postale',Ville='$vils',pays='$payss',profession='$prefession', departement='$residence',password='$password', uid_inscription= 'NULL' WHERE mail='$mail' ";
                  insertDB($sqlup);

                   $v1="<script>
                 swal({
                title: \"Enregistré!\",
                icon: \"success\"
                }).then(function() {
                window.location = \"../index.php\";
                 });
               </script>";




               

                   


                }
            









           }
            


}







  }





}


  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php  include("../Blocs_HTML/script_bootstrap_header.php");  ?>

  <title>Inscription</title>

  <link rel="stylesheet" href="../CSS/Style.css">


</head>
<body>


<div class="jumbotron jumbotron-fluid inscription">
  <div class="container">
    <h1 class="display-5">Inscription </h1>

        <form method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Numéro d'adhérent : </label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="Numéro d'adhérent" name="id_ad" value="<?php echo $donreq['id_personne'];    ?>" readonly>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Nom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Nom" name="nom" value="<?php echo $donreq['nom'];    ?>" readonly>
    </div>
     <div class="col-md-4 mb-3">
      <label for="validationDefault02">Prénom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Prénom" name="prenom" value="<?php echo $donreq['prenom'];    ?>" readonly>
    </div>
  </div>
  <div class="form-row">
       <div class="col-md-3 mb-3">
      <label for="validationDefaultUsername">Adresse mail :</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend2">@</span>
        </div>
        <input type="text" class="form-control" id="validationDefaultUsername"  name="mail" value="<?php echo $donreq['mail'];    ?>" placeholder="Adresse mail" aria-describedby="inputGroupPrepend2" readonly>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault03">Date de naissance :</label>
       <input class="form-control" type="text" name="date" value="<?php echo $donreq['date_de_naissance'];?>" placeholder="date de naissance" readonly/>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">Lieu de naissance :</label>
      <input type="text" class="form-control" id="validationDefault05" placeholder="Lieu de naissance" name="lieu" value="<?php echo $donreq['lieu_de_naissance'];    ?>"  readonly>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault04">Pays de naissance : </label>
      <input type="text"  id="inputState" class="form-control" placeholder="Pays de naissance" name="select" value="<?php echo $donreq['pays_naissance'];    ?>" readonly>  
      
    </div>  
  </div>

  <div class="form-row">
    <div class="col-md-3 mb-3">
       <label for="validationDefault04">Département de naissance : </label>
      <input type="text"  id="inputState" class="form-control" placeholder="Département de naissance" value="<?php echo $donreq['departement_naissance'];    ?>" readonly>
    </div>

     <div class="col-md-3 mb-3">
       <label for="validationDefault04">Profession : </label>
      <input type="text"  id="inputState" class="form-control" name="prefession" placeholder="Profession" >
    </div>

       <div class="col-md-3 mb-3">
       <label for="validationDefault04">* Adresse : </label>
      <input type="text"  id="inputState" class="form-control" name="adresse" placeholder="Adresse" >
    </div>

       <div class="col-md-3 mb-3">
       <label for="validationDefault04">* Code postale : </label>
      <input type="number"  id="inputState" class="form-control" name="code_postale" placeholder="Code postale" >
    </div>


  </div>

  <div class="form-row">
    <div class="col-md-3 mb-3">

         <label for="validationDefault04">* Pays : </label>
      <select id="inputStated" class="form-control" name="pays" >
        <option  value="NULL" selected>Choose...</option>
      <?php  

          foreach ($pay as $keydep) {

                    echo "<option value=".$keydep['pays'].">".$keydep['pays']."</option>";
                   
                    }          
          


        ?> 
      </select>
      </div>

       <div class="col-md-3 mb-3">

         <label for="validationDefault04">* Département : </label>
      <select id="inputStated" class="form-control" name="departement_residence" >
        <option  value="NULL" selected>Choose...</option>
     <?php  

          foreach ($dep as $keyd) {

                    echo "<option value=".$keyd['departement'].">".$keyd['departement']."</option>";
                   
                    }          
          


        ?>
      </select>
      </div>

      <div class="col-md-3 mb-3">
       <label for="validationDefault04">* Ville : </label>
      <input type="text"  id="inputState" class="form-control" name="villle" placeholder="Ville">
    </div>
      </div>  


      <div class="form-row">
    <div class="col-md-3 mb-3">

       <label for="validationDefault04">* Mot de passe : </label>
      <input type="password"  id="inputState" class="form-control" name="motP" placeholder="Mot de passe" >

    </div>

     <div class="col-md-3 mb-3">

       <label for="validationDefault04">* Répéter votre Mot de passe : </label>
      <input type="password"  id="inputState" class="form-control" name="motPr" placeholder="Répéter votre mot de passe" >

    </div>
  </div>

     <input class="btn btn-primary" type="submit" name="submit" value="Valider" ></input>
      </form>
    </div>
  </div>



<?php  echo $v1; ?>
<?php    include("../Blocs_HTML/footer.php"); ?>

</body>
</html>