<?php
include("Fonction/fonction.php");
include("DB/base.php");
$prmail='';
$mailvid='';
$mailnul='';
$nom='Nom';
$Prenom='Prénom';
$immat='Numéro d\'adhérent';
$datenaissance='Date de Naissance';
$lieunaissance='Lieu de naissance';
$depnaissance='Département de Naissance';
$adresse='Adresse';

$dep= $mysqli->query("SELECT DISTINCT departement FROM villefrance ORDER BY departement")or die(mysqli_error($mysqli));
$pays= $mysqli->query("SELECT * FROM t_pays")or die(mysqli_error($mysqli));

if(isset($_GET['rmail'])){
     if(!empty($_GET['rmail'])){
     
         $rmail= trim(verif($_GET['rmail']));
         $rmail=$mysqli->real_escape_string($rmail);
	     $donn=$mysqli->query("SELECT * FROM personne WHERE mail='$rmail'")or die(mysqli_error($mysqli));
	     $row=$donn->num_rows;
	     if($row>0){
	     $res= $donn->fetch_array();
	     $nom=$res['nom'];
	     $Prenom=$res['prenom'];
	     $immat=$res['id_personne'];
	     $datenaissance= $res['date_de_naissance'];
	     $lieunaissance= $res['lieu_de_naissance'];
	     $depnaissance= $res['Departement'];
	     $adresse= $res['addresse'];



       $mysqli->close();



	     }else{

	     	$mailnul='<SCRIPT LANGUAGE="JavaScript"> swal("l\'adresse mail n\'exsite pas ! ");</SCRIPT>';


	     }


     }else{
     	$mailvid='<SCRIPT LANGUAGE="JavaScript"> swal("l\'adresse mail est vide ! ");</SCRIPT>';


     }


}else{

  $prmail='<SCRIPT LANGUAGE="JavaScript"> swal("Il faut renseigner une adresse mail ! ");</SCRIPT>';

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
<body>
<fieldset class="col-md-6">
  <legend><span>Title goes here</span></legend>
  
</fieldset>

<div class="container-fluid">

  <h1 class="display-3"> Modifiez votre profile </h1>

  

  <div class="container-fluid">

  	 <form>
  <div class="form-row profile">
  	<div class="col">
  	  <label for="inputEmail4">Numéro d'adhérent : </label>
      <input type="text" class="form-control" placeholder="<?php echo $immat;  ?> " readonly>
    </div>

    <div class="col">
    <label for="inputnom">Nom : </label>
      <input type="text" class="form-control" placeholder="<?php echo $nom;  ?> " readonly>
    </div>
    <div class="col">
    <label for="inputprenom">Prénom : </label>
      <input type="text" class="form-control" placeholder="<?php echo $Prenom;  ?> " readonly>
    </div>


  </div>

   <div class="form-row profile">

   	 <div class="col">
    <label for="inputnaissance">Date de naissance : </label>
      <input type="text" class="form-control" placeholder="<?php echo $datenaissance;  ?> " readonly>
    </div>

    <div class="col">
    <label for="inputlieu">Lieu de Naissance : </label>
      <input type="text" class="form-control" placeholder="<?php echo $lieunaissance;  ?> " readonly>
    </div>
     <div class="col">
    <label for="inputdep">Département de Naissance : </label>
      <input type="text" class="form-control" placeholder="<?php echo $depnaissance;  ?> " readonly>
    </div>
   	</div>
   	<div class="form-row profile">

   	<div class="col">
   	<label for="inputmail">Adresse mail : </label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="Email" value="<?php  if(!empty($rmail)){ echo $rmail; }


      	  ?>">
    </div>
    	<div class="col">
       <label for="inputpassword">Mot de passe : </label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password" value="">
    </div>

    <div class="col">
     <label for="inputAddress">Adresse :</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="Adresse" value="<?php  echo $adresse;  ?>">
    </div>


</div>

  <div class="form-row profile">

    <div class="col">
      <label for="inpddCity">Ville</label>
      <input type="text" class="form-control" id="inputCity">
      <div style='overflow:scroll; width:auto;height:150px; ' id="do"> <p id="p"></p></div>
    </div>
    <div class="col">
      <label for="inputState">Département</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
      <?php            
           while ($resdep=$dep->fetch_array()) {
             
             echo "<option>".$resdep['departement']."</option>";
           }



        ?>
      </select>
    </div>
    <div class="profile">
      <label for="inputZip">Code postale</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  </div>



</form>


  </div>
</div>

<?php echo $prmail ; echo $mailvid; echo $mailnul;
 ?>






 
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="JS/jquery.js"></script>
        <script type='text/javascript' src='JS/fonction.js'></script>
</body>
</html>
