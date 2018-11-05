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

  $sess=$_SESSION['login'];
  $sql2="SELECT * FROM role ";
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
       isset($_POST['date']) && isset($_POST['lieu']) && isset($_POST['selec']) && isset($_POST['choix']) ){
            

        $id_roleP= $mysqli->real_escape_string(trim(verif($_POST['id_ad'])));
        $nomP= $mysqli->real_escape_string(trim(verif($_POST['nom'])));
        $prenomP= $mysqli->real_escape_string(trim(verif($_POST['prenom'])));
        $mailP= $mysqli->real_escape_string(trim(verif($_POST['mail'])));
        $dateP= $mysqli->real_escape_string(trim(verif($_POST['date'])));
        $lieuP= $mysqli->real_escape_string(trim(verif($_POST['lieu'])));
        $selectP= $mysqli->real_escape_string(trim(verif($_POST['selec'])));
        $choixP= $_POST['choix']; 

        

        if(!filter_var($mailP, FILTER_VALIDATE_EMAIL)){
               $v1="<script>
               swal({
                title: \"Oups!\",
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

               for ($i=0; $i <sizeof($choixP) ; $i++) { 
       # code...
             $sqlch="INSERT INTO assoc_per_rol(id_personne,id_role) VALUES ('$id_roleP',".$choixP[$i]." )";
               insertDB($sqlch);
                }

           
         if($selectP == "NULL"){
        
                $v1="<script>
               swal({
                title: \"Oups!\",
                text: \"renseigner votre pays de naissance !\",
                icon: \"error\"
                }).then(function() {
                window.location = \"ajoutAdherents.php\";
                 });
               
               </script>";
              }elseif($selectP != "France"){
                    $sqlins="INSERT INTO personne (id_personne,nom,prenom,date_de_naissance,lieu_de_naissance,pays_naissance,departement_naissance,mail,uid_inscription) VALUES ('$id_roleP','$nomP','$prenomP','$dateP','$lieuP','$selectP','Etranger','$mailP', '$ran')";
                    insertDB($sqlins);
                    require '../class/class.phpmailer.php';
    $mail = new PHPMailer;
    $mail -> charSet = "UTF-8";
    $mail->IsSMTP();                //Sets Mailer to send message using SMTP
    $mail->Host = 'smtp.gmail.com';   //Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->Port = 587;                //Sets the default SMTP server port
    $mail->SMTPAuth = true;             //Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'chikhouneloulouze@gmail.com';          //Sets SMTP username
    $mail->Password = 'Chikhounemouloud06';         //Sets SMTP password
    $mail->SMTPSecure = 'tls';              //Sets connection prefix. Options are "", "ssl" or "tls"
    $mail->From = $mailP ;      //Sets the From email address for the essage
    $mail->FromName = 'FFSFP';
    $mail->AddAddress($mailP, 'name');   //Adds a "To" address
      //Adds a "Cc" address
    $mail->WordWrap = 50;             //Sets word wrapping on the body of the message to a given number of characters
    $mail->IsHTML(true);              //Sets message type to HTML       
    $mail->Subject = utf8_decode('Création d\'un compte FFSFP');       //Sets the Subject of the message
    $mail->Body = '<p>Bonjour</p>
                <p>veuillez compléter le formulaire d\'inscription en cliquant sur ce liens.</p> 
                <p>https://localhost/ffsfp/Administrateur/inscription.php?mail='.$mailP.'& uid_inscription='.$ran.'</p>';      

    if($mail->Send())               
    {

       $envoi="<script>
               swal({
                title: \"Oups!\",
                text: \"Vérifiez votre boîte de réception. FFSFP envoie immédiatement un message à l\'adresse email associée à votre compte. !\",
                icon: \"success\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }else{
       
        $envoi="<script>
               swal({
                title: \"Oups!\",
                text: \" Erreur\",
                icon: \"error\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }



              } else{

                $depnaissance=$_POST['select2'];

             $sqlins="INSERT INTO personne (id_personne,nom,prenom,date_de_naissance,lieu_de_naissance,pays_naissance,departement_naissance,mail,uid_inscription) VALUES ('$id_roleP','$nomP','$prenomP','$dateP','$lieuP','$selectP','$depnaissance','$mailP', '$ran')";
             insertDB($sqlins);


             require '../class/class.phpmailer.php';
    $mail = new PHPMailer;
    $mail -> charSet = "UTF-8";
    $mail->IsSMTP();                //Sets Mailer to send message using SMTP
    $mail->Host = 'smtp.gmail.com';   //Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->Port = 587;                //Sets the default SMTP server port
    $mail->SMTPAuth = true;             //Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'chikhouneloulouze@gmail.com';          //Sets SMTP username
    $mail->Password = 'Chikhounemouloud06';         //Sets SMTP password
    $mail->SMTPSecure = 'tls';              //Sets connection prefix. Options are "", "ssl" or "tls"
    $mail->From = $mailP ;      //Sets the From email address for the essage
    $mail->FromName = 'FFSFP';
    $mail->AddAddress($mailP, 'name');   //Adds a "To" address
      //Adds a "Cc" address
    $mail->WordWrap = 50;             //Sets word wrapping on the body of the message to a given number of characters
    $mail->IsHTML(true);              //Sets message type to HTML       
    $mail->Subject = utf8_decode('Création d\'un compte FFSFP');       //Sets the Subject of the message
    $mail->Body = '<p>Bonjour</p>
                <p>veuillez compléter le formulaire d\'inscription en cliquant sur ce liens.</p> 
                <p>https://localhost/ffsfp/inscription.php?mail='.$mailP.'& uid_inscription='.$ran.'</p>';      

    if($mail->Send())               
    {

       $envoi="<script>
               swal({
                title: \"Oups!\",
                text: \"Vérifiez votre boîte de réception. FFSFP envoie immédiatement un message à l\'adresse email associée à votre compte. !\",
                icon: \"success\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";
    }else{
       
        $envoi="<script>
               swal({
                title: \"Oups!\",
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
                title: \"Oups!\",
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
                title: \"Oups!\",
                text: \"tous les champs sont oblégatoires\",
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

     
    
  </div>
  <div class="form-group">
    <div class="form-check">
    <label for="role">* Role : </label><br/>
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
  * LES CHAMPS SONT OBLEGATOIRES.
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