<?php
 session_start();
include("Fonction/fonction.php");
include("DB/base.php");
$RRmail='';
$Rmail='';
$prmail='';
$mailvid='';
$mailnul='';
$uidnv='';
$nom='Nom';
$Prenom='Prénom';
$immat='Immatriculation';
$maill='';

if(isset($_GET['rmail']) && isset($_GET['uid'])){

     if(!empty($_GET['rmail']) && !empty($_GET['uid'])){
     
         $rmail= trim(verif($_GET['rmail']));
         $uid= trim(verif($_GET['uid']));
         $rmail=$mysqli->real_escape_string($rmail);
         $uid=$mysqli->real_escape_string($uid);

	     $donn=$mysqli->query("SELECT * FROM personne WHERE mail='$rmail'")or die(mysqli_error($mysqli));
	     $row=$donn->num_rows;
	     if($row>0){
	     $res= $donn->fetch_array();
        if($uid==$res['uid']){
       $nom=$res['nom'];
       $Prenom=$res['prenom'];
       $immat=$res['id_personne'];
       $maill=$res['mail'];

       }else {

        $uidnv='<SCRIPT LANGUAGE="JavaScript"> swal(" UID est éxpiré !");</SCRIPT>';

        
       }
	     


       $mysqli->close();



	     }else{

	     	$mailnul='<SCRIPT LANGUAGE="JavaScript"> swal("Votre adresse mail n\'est pas reconnue ! ");</SCRIPT>';


	     }


     }else{
     	$mailvid='<SCRIPT LANGUAGE="JavaScript"> swal("l\'adresse mail ou uid est vide ! ");</SCRIPT>';


     }


}else{


   $prmail="<script>

                swal({
                text: \"Il faut renseigner une adresse mail ou bien un uid!\",
                type: \"info\"
                }).then(function() {
                window.location = \"index.php\";
                 });
               
               </script>";

}

if(isset($_POST['reset']))
{
  if(!empty($_POST['resmail']) && !empty($_POST['respassword']) && !empty($_POST['resRpassword'])){

    if($_POST['respassword']==$_POST['resRpassword']){
      $a=$_POST['resmail'];
      $b=verif($_POST['respassword']);
      $c=verif($_POST['resRpassword']);

     
      $_SESSION['etape_1'] = array('resmail' => $a,
                             'respassword' => $b,
                             'resRpassword' => $c );


      header("Location:verifreset.php");
    }else{
      $RRmail="<script>

                swal(\"Les mots de passes ne sont pas identiques!\");
               
               </script>";

    }
        
}else{

     $Rmail="<script>

                swal(\"Il faut renseigner le champs obligatoires !\");
               
               </script>";
}

}



?>


<!doctype html>
<html lang="fr">
<head>

		<title>Accueil Admin</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="CSS/Style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
         <script src="JS/jquery.js"></script>
        <script type='text/javascript' src='JS/fonction.js'></script>


</head>
<body class="index">

  <div class="boxx">

<div class="container-fluid">

  <h4> Réinitialiser votre mot de passe : </h4>

  <div class="container-fluid">

  	 <form action="" method="post">
  <div class="form-row profile">
  	<div class="col">
  	  <label for="inputEmail4">Numéro d'adhérent : </label>
      <input type="text" class="form-control" placeholder="<?php echo $immat;  ?> " readonly>
    </div>
  </div>

    <div class="form-row profile">
    <div class="col">
    <label for="inputnom">Nom : </label>
      <input type="text" class="form-control" placeholder="<?php echo $nom;  ?> " readonly>
    </div>
  </div>

  <div class="form-row profile">
    <div class="col">
    <label for="inputprenom">Prénom : </label>
      <input type="text" class="form-control" placeholder="<?php echo $Prenom;  ?> " readonly>
    </div>
  </div>


   	<div class="form-row profile">

   	<div class="col">
   	<label for="inputmail">*Adresse mail : </label>
      <input type="email" class="form-control" name="resmail" id="inputEmail4" placeholder="*Email" value="<?php  echo $maill;
    

      	  ?>"   readonly>
      </div>
    </div>
    <div class="form-row profile">
    	<div class="col">
       <label for="inputpassword">*Votre nouveau mot de passe : </label>
      <input type="password" class="form-control" name="respassword" id="inputPassword4" placeholder="*Password" value="">
    </div>
  </div>

  <div class="form-row profile">
      <div class="col">
       <label for="inputpassword">*Répéter votre nouveau mot de passe : </label>
      <input type="password" class="form-control" name="resRpassword" id="inpa" placeholder="*Répéter votre nouveau mot de passe " value="">
    </div>
  </div>

  <div class="form-row profile">
    <div class="col">

    <center><input type="submit" class="btn btn-primary" value="Valider" name="reset"></input></center>
    </div>
  </div>

  



</div>

 
  </div>

</form>


  </div>
</div>

<?php echo $prmail ; echo $mailvid; echo $mailnul; echo $uidnv; echo $Rmail; echo $RRmail;
 ?>






 
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="JS/jquery.js"></script>
        <script type='text/javascript' src='JS/fonction.js'></script>
      </div>
</body>
</html>
