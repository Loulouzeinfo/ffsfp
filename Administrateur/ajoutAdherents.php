<?php  
session_start();
include("../Fonction/fonction.php");
include("../DB/base.php");
$profile='';
$pay=array();
$role=array();
$dep=array();
$v1='';
$v2='';
$v3='';
$envoi='';
$ran=aleatoire(6,5);


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
  $sql2="SELECT * FROM role";
  $donnrole= $mysqli->query($sql2)or die(mysqli_error($mysqli));
  while ($resrole=$donnrole->fetch_array()) {
    
    $role[]=$resrole;
  }

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

  $sql22="SELECT * FROM personne WHERE mail='$sess'";
  $donpro= $mysqli->query($sql22)or die(mysqli_error($mysqli));
  $respro= $donpro->fetch_array();
  $profile=$respro['prenom'];


 if(isset($_POST['submit'])){

       if(isset($_POST['id_ad']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) &&
       isset($_POST['date']) && isset($_POST['lieu']) && isset($_POST['selec']) && isset($_POST['choix']) && isset($_POST['Tarification']) ){
            

        $id_roleP= $mysqli->real_escape_string(trim(verif($_POST['id_ad'])));
        $nomP= $mysqli->real_escape_string(trim(verif($_POST['nom'])));
        $prenomP= $mysqli->real_escape_string(trim(verif($_POST['prenom'])));
        $mailP= $mysqli->real_escape_string(trim(verif($_POST['mail'])));
        $dateP= $mysqli->real_escape_string(trim(verif($_POST['date'])));
        $lieuP= $mysqli->real_escape_string(trim(verif($_POST['lieu'])));
        $selectP= $mysqli->real_escape_string(trim(verif($_POST['selec'])));
        $choixP= $_POST['choix']; 
        $Tarification=$_POST['Tarification'];

        

        if(!filter_var($mailP, FILTER_VALIDATE_EMAIL)){
               $v1="<script>
               swal({
                text: \"votre adresse mail n'est pas valide !\",
                icon: \"error\"
                }).then(function() {
                window.location = \"ajoutAdherents.php\";
                 });
               
               </script>";
                   
             }else{

                      
                $donn=$mysqli->query("SELECT * FROM personne WHERE mail='$mailP'")or die(mysqli_error($mysqli));
                $res= $donn->num_rows;                                  
 
         if ($res==0){
           
         if($selectP == "NULL"){
        
                $v1="<script>
               swal({
                text: \"renseigner votre pays de naissance !\",
                icon: \"error\"
                }).then(function() {
                window.location = \"ajoutAdherents.php\";
                 });
               
               </script>";
              }elseif($selectP != "France"){

                for ($i=0; $i <sizeof($choixP) ; $i++) { 
       # code...
             $sqlch="INSERT INTO assoc_per_rol(id_personne,id_role) VALUES ('$id_roleP',".$choixP[$i]." )";
               insertDB($sqlch);
                }
               $sqlCots="INSERT INTO cotisationniveau(id_personne,niveauCotisation,payeBool) VALUES ('$id_roleP','$Tarification',0)";
               insertDB($sqlCots);


                    $sqlins="INSERT INTO personne (id_personne,nom,prenom,date_de_naissance,lieu_de_naissance,pays_naissance,departement_naissance,mail,uid_inscription) VALUES ('$id_roleP','$nomP','$prenomP','$dateP','$lieuP','$selectP','Etranger','$mailP', '$ran')";
                    insertDB($sqlins);

     require_once("enteteMail.php");
    $mail->Subject = utf8_decode('Création d\'un compte FFSFP');       //Sets the Subject of the message
    $mail->Body = utf8_decode('<p>Bonjour</p>
                <p>veuillez compléter le formulaire d\'inscription en cliquant sur ce lien.</p> 
                <p>https://localhost/ffsfp/Administrateur/inscription.php?mail='.$mailP.'&uid_inscription='.$ran.'</p>');      

    if($mail->Send())               
    {

       $envoi="<script>
               swal({
                text: \"Vérifiez votre boîte de reception afin de valider votre inscription !\",
                icon: \"success\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }else{
       
        $envoi="<script>
               swal({
                text: \" Erreur de l'envoi\",
                icon: \"error\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }



              } else{
                 $sqlCots="INSERT INTO cotisationniveau(id_personne,niveauCotisation,payeBool) VALUES ('$id_roleP','$Tarification',0)";
               insertDB($sqlCots);
                $depnaissance=$_POST['select2'];

             $sqlins="INSERT INTO personne (id_personne,nom,prenom,date_de_naissance,lieu_de_naissance,pays_naissance,departement_naissance,mail,uid_inscription) VALUES ('$id_roleP','$nomP','$prenomP','$dateP','$lieuP','$selectP','$depnaissance','$mailP', '$ran')";
             insertDB($sqlins);
             for ($i=0; $i <sizeof($choixP) ; $i++) { 
       # code...
             $sqlch="INSERT INTO assoc_per_rol(id_personne,id_role) VALUES ('$id_roleP',".$choixP[$i]." )";
               insertDB($sqlch);
                } 


            require_once("enteteMail.php"); 
    $mail->Subject = utf8_decode('Création d\'un compte FFSFP');       //Sets the Subject of the message
    $mail->Body = utf8_decode('<p>Bonjour</p>
                <p>veuillez compléter le formulaire d\'inscription en cliquant sur ce lien.</p> 
                <p>localhost/ffsfp/Administrateur/inscription.php?mail='.$mailP.'&uid_inscription='.$ran.'</p>');          

    if($mail->Send())               
    {

       $envoi="<script>
               swal({
                text: \"Vérifiez votre boîte de reception afin de valider votre inscription !\",
                icon: \"success\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }else{
       
        $envoi="<script>
               swal({
                text: \" Erreur\",
                icon: \"error\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }




              }

    
         }else{

                   $v3="<script>
               swal({
                text: \"l'adresse mail existe déja !\",
                icon: \"error\"
                }).then(function() {
                window.location = \"ajoutAdherents.php\";
                 });
               
               </script>";


         }













             }//adresse mail nest pas valide

        
    
       

}else{
                   $v3="<script>
               swal({
                text: \"Champs Obligatoirs\",
                icon: \"error\"
                }).then(function() {
                window.location = \"ajoutAdherents.php\";
                 });
               
               </script>";

}

}//elsesubmit

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


<div class="jumbotron jumbotron-fluid ajoutad">
  <div class="container">
    <h1 class="display-5">Ajouter un Adhérent : </h1>

        <form method="post" >
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">* Numéro d'adhérent : </label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="Numéro d'adhérent" name="id_ad" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">* Nom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Nom" name="nom" required>
    </div>
     <div class="col-md-4 mb-3">
      <label for="validationDefault02">* Prénom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Prénom" name="prenom" required>
    </div>
  </div>
  <div class="form-row">
       <div class="col-md-3 mb-3">
      <label for="validationDefaultUsername">* Adresse mail :</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend2">@</span>
        </div>
        <input type="text" class="form-control" id="validationDefaultUsername"  name="mail" placeholder="Adresse mail" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault03">* Date de naissance :</label>
       <input class="form-control" id="datepicker"  name="date" placeholder="date de naissance" required />
    <script>

   $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy'

        });
    </script>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Lieu de naissance :</label>
      <input type="text" class="form-control" id="validationDefault05" placeholder="Lieu de naissance" name="lieu" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Pays de naissance : </label>
      <select id="inputState" class="form-control" name="selec">
        <option value="NULL" selected>Choose...</option>
      <?php  

          foreach ($pay as $key) {

                    echo "<option value=".$key['pays'].">".$key['pays']."</option>";
                   
                    }          
          


        ?>
      </select>
      
    </div>

    
   

     <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Département de naissance : </label>
      <select id="inputStated" class="form-control" name="select2" >
        <option  value="Etranger" selected>Choose...</option>
      <?php  

          foreach ($dep as $keydep) {

                    echo "<option value=".$keydep['departement'].">".$keydep['departement']."</option>";
                   
                    }          
          


        ?>
      </select>
      
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Tarification : </label>
      <select id="inputStated" class="form-control" name="Tarification" >
        <option  value="Tatif1" selected>Tarif 1</option>
        <option  value="Tatif2" >Tarif 2</option>
        <option  value="gratuit" >gratuit</option>
     
      </select>
      
    </div>

     
    
  </div>
  <div class="form-group">
    <div class="form-check">
    <label for="role">* Role(s) : </label><br/>
      <?php 
             foreach ($role as $key1) {
            echo "<input class=\"form-check-input\" type=\"checkbox\" name=\"choix[]\" id=\"invalidCheck2\"  value=".$key1['id_role']."> 
            <label class=\"form-check-label\"  for=\"invalidCheck2\">".$key1['libelle']."</label><br/>";
                 }
             
         ?>
     
        
      
    </div>
  </div>
  <input class="btn btn-primary" type="submit" name="submit" ></input>
</form>
  </div>
<br/>
  * Champs Obligatoirs.
</div>

 <script>
        
        $("#inputStated").attr('disabled',true);
       $( "#inputState" ).change(function() {
      $d=$("#inputState").val();
     if($d  != 'France'){
           
            $("#inputStated").attr('disabled',true);
            
     }else{

                 $("#inputStated").removeAttr('disabled');

     }

  
});

      </script>

<?php  echo $v1;  echo $v2;  echo $v3; echo $envoi;?>
<?php    include("../Blocs_HTML/footer.php"); ?>

</body>
</html>