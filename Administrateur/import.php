<?php  
 session_start();
 include("../DB/base.php");
 include("../Fonction/fonction.php");
$tab=array();
$profile='';
$v1='';
$ran=aleatoire(6,5);
$envoi='';

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

  if (isset($_POST['submit'])) {
       # code...
         if (isset($_FILES['file']) AND $_FILES['file']['error']==0 ) {
           # code...
          
          $file_name=$_FILES['file']['name'];
          $tmp_name=$_FILES['file']['tmp_name'];
          $file_extension=strrchr($file_name, '.');
          $extension_autorisées= array('.csv','.CSV');
          
          $chemin='../file/'.$file_name;
          move_uploaded_file($tmp_name, $chemin);
          if(in_array($file_extension, $extension_autorisées)){
            $tab=importeCv($chemin);
            $f=array();
             for ($i=0; $i <sizeof($tab) ; $i++) { 
                      $f[]= $tab[$i][0];

                      }


                 for ($i=0; $i <sizeof($f) ; $i++){ 
                     $e= explode(';',$f[$i]);

                  $sql2I= "SELECT * FROM personne WHERE mail='$e[3]'";
                  $donproI= $mysqli->query($sql2I)or die(mysqli_error($mysqli));
                  if($donproI->num_rows != 0){
                                  continue;

                  }
                 $re="SELECT * FROM role WHERE libelle='$e[8]'" ;
                 $donnrole= $mysqli->query($re)or die(mysqli_error($mysqli));
                 $resrole=$donnrole->fetch_array();
                 $sqlch="INSERT INTO assoc_per_rol(id_personne,id_role) VALUES ('$e[0]',".$resrole['id_role'].")";
                 insertDB($sqlch);

                 $sqlins="INSERT INTO personne(id_personne,nom,prenom,date_de_naissance,lieu_de_naissance,pays_naissance,departement_naissance,mail,uid_inscription) 
                   VALUES ('$e[0]','$e[1]','$e[2]','$e[4]','$e[5]','$e[6]','$e[7]','$e[3]', '$ran')";
                    insertDB($sqlins);

   require_once("enteteMail.php");
           
    $mail->Subject = utf8_decode('Création d\'un compte FFSFP');       //Sets the Subject of the message
    $mail->Body = utf8_decode('<p>Bonjour</p>
                <p>veuillez compléter le formulaire d\'inscription en cliquant sur ce lien.</p> 
                <p>https://www.ffsfplaton.ovh/Administrateur/inscription.php?mail='.$e[3].'&uid_inscription='.$ran.'</p>');      

    if($mail->Send())               
    {
                   

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


             

                      }



                    unlink($chemin);
                        $envoi="<script>
               swal({
                text: \"Données importées avec succès\",
                icon: \"success\"
                }).then(function() {
                window.location = \"gestion_adh.php\";
                 });
               
               </script>";

                  

          }else{

                         $v1="<script>
               swal({
                
                text: \"L'extension de fichier n'est pas autorisée !\",
                icon: \"info\"
                });
               
               </script>";

          }





         }else{
                      $v1="<script>
               swal({
                
                text: \"Erreur dans le téléchargement du fichier !\",
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
  <title>accueil admin</title>
  <link rel="stylesheet" href="../CSS/Style.css">

<body>

 <?php    include("../Blocs_HTML/nav.php"); ?>


<div class="jumbotron accueil">
  <div class="container">
    <h1 class="display-4">Importer un fichier .CSV</h1>


    

    <form  class="form-group" method="post"  enctype="multipart/form-data">
</br>
</br>

 <div class="custom-file">
  <input type="file" class="custom-file-input" id="file" name="file">
  <label class="custom-file-label" for="file"><span id="label-span">Choisir un fichier</span></label>
</div>


</br>
</br>


   <button type="submit" name="submit" class="btn btn-primary" >Importer</button>
 

</form>
    
  </div>

</div>


<?php   echo $v1;  echo $envoi; ?>


<?php    include("../Blocs_HTML/footer.php"); ?>


</body>
</html>