<?php 
session_start();
include '../Fonction/fonction.php';
include '../DB/base.php';
$profile = '';
$pay = array();
$dep = array();
$v1 = '';
$v2 = '';
$v3 = '';
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
} else {
    if (isset($_SESSION['action']) and (time() - $_SESSION['action']) < 300) {
        $_SESSION['action'] = time();
    } else {
        session_destroy();
        $v1 = '<script>
               swal({
                
                text: "Vous êtes déconnecté !",
                icon: "info"
                }).then(function() {
                window.location = "../index.php";
                 });
               
               </script>';
    }

    $sess = $_SESSION['login'];
    $sql2 = "SELECT libelle FROM personne,role,assoc_per_rol WHERE assoc_per_rol.id_personne=personne.id_personne AND assoc_per_rol.id_role=role.id_role AND mail='$sess' ";
    $donnrole = $mysqli->query($sql2) or die(mysqli_error($mysqli));
    while ($resrole = $donnrole->fetch_array()) {
        $role[] = $resrole;
    }

    $sql22 = "SELECT * FROM personne,cotisationniveau WHERE mail='$sess' AND personne.id_personne=cotisationniveau.id_personne  ";
    $donpro = $mysqli->query($sql22) or die(mysqli_error($mysqli));
    $resprop = $donpro->fetch_array();
    $profile = $resprop['prenom'];

    if (isset($_POST['submit'])) {
        if (!empty($_POST['mail']) && !empty($_POST['PaysRes']) && !empty($_POST['departementRes']) && !empty($_POST['adressePh'])
        && !empty($_POST['ville_p']) && !empty($_POST['codePos'])) {
            $mailP = $mysqli->real_escape_string(trim(verif($_POST['mail'])));
            $PaysRes = $mysqli->real_escape_string(trim(verif($_POST['PaysRes'])));
            $departementRes = $mysqli->real_escape_string(trim(verif($_POST['departementRes'])));
            $adressePh = $mysqli->real_escape_string(trim(verif($_POST['adressePh'])));
            $villePh = $mysqli->real_escape_string(trim(verif($_POST['ville_p'])));
            $codePos = $mysqli->real_escape_string(trim(verif($_POST['codePos'])));
            $sqlup = "UPDATE personne SET mail='$mailP', Departement='$departementRes', pays='$PaysRes', addresse='$adressePh', code_postale='$codePos',ville='$villePh'
                                         WHERE mail='$sess' ";

            insertDB($sqlup);
            $v1 = '<script> dialogsuccess("Mise à jour réussie","mesdonnees.php"); </script>';
        } else {
            $v1 = '<script> dialoginfo("Tous les champs sont Obligatoirs !","mesdonnees.php"); </script>';
        }
    }
} //elselogin?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php  include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Mes données</title>

  <link rel="stylesheet" href="../CSS/Style.css">


</head>
<body>
<?php    include '../Blocs_HTML/nav.php'; ?>

<div class="jumbotron jumbotron-fluid ajoutad">
  <div class="container">
    <h1 class="display-5">Mes données: </h1>

        <form method="post" >
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">* Numéro d'adhérent : </label>
      <input type="text" class="form-control" id="validationDefault01"  value="<?php echo $resprop['id_personne']; ?>" readonly>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">* Nom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Nom" name="nom" value="<?php echo utf8_encode($resprop['nom']); ?>" readonly>
    </div>
     <div class="col-md-4 mb-3">
      <label for="validationDefault02">* Prénom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Prénom" name="prenom" value="<?php echo utf8_encode($resprop['prenom']); ?>" readonly>
    </div>
  </div>
  <div class="form-row">
       <div class="col-md-3 mb-3">
      <label for="validationDefaultUsername">* Adresse mail :</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend2">@</span>
        </div>
        <input type="text" class="form-control" id="validationDefaultUsername"  name="mail" placeholder="Adresse mail" value="<?php echo utf8_encode($resprop['mail']); ?>" aria-describedby="inputGroupPrepend2" >
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault03">* Date de naissance :</label>
       <input class="form-control" id="datepicker"  name="date" value="<?php echo utf8_encode($resprop['date_de_naissance']); ?>" placeholder="date de naissance" readonly />
 
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Lieu de naissance :</label>
      <input type="text" class="form-control" id="validationDefault05" value="<?php echo utf8_encode($resprop['lieu_de_naissance']); ?>" placeholder="Lieu de naissance" name="lieu" readonly>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Pays de naissance : </label>
      <select id="inputState" class="form-control" name="selec" readonly>
        <option value="<?php echo utf8_encode($resprom['pays_naissance']); ?>" selected><?php echo utf8_encode($resprop['pays_naissance']); ?></option>
      </select>
      
    </div>

    
   

     <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Département de naissance : </label>
      <select id="inputStated" class="form-control" name="select2" readonly>
        <option  value="<?php echo utf8_encode($resprom['departement_naissance']); ?>" selected><?php echo utf8_encode($resprop['departement_naissance']); ?></option>
      
      </select>
      
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Pays de résidence :</label>
      <input type="text" class="form-control" id="PaysRes" value="<?php echo utf8_encode($resprop['pays']); ?>" placeholder="Pays de résidence" name="PaysRes">
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Département de résidence :</label>
      <input type="text" class="form-control" id="departementRes" value="<?php echo utf8_encode($resprop['Departement']); ?>" placeholder="Pays de résidence" name="departementRes" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Adresse Physique :</label>
      <input type="text" class="form-control" id="adressePh" value="<?php echo utf8_encode($resprop['addresse']); ?>" placeholder="Adresse physique" name="adressePh" required>
    </div>

      <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Ville :</label>
      <input type="text" class="form-control" id="ville" value="<?php echo utf8_encode($resprop['ville']); ?>" placeholder="Ville" name="ville_p" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Code postale :</label>
      <input type="text" class="form-control" id="codePos" value="<?php echo utf8_encode($resprop['code_postale']); ?>" placeholder="Code Postale" name="codePos" required>
    </div>
      
      <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Profession :</label>
      <input type="text" class="form-control" id="profession" value="<?php echo utf8_encode($resprop['profession']); ?>" placeholder="Profession" name="profession_p" readonly>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Tarification :</label>
      <input type="text" class="form-control" id="tarification" value="<?php echo utf8_encode($resprop['cotisationN']); ?>" placeholder="tarification" name="tarification" readonly>
    </div>
     
    
  </div>
  <div class="form-group">
    <div class="form-check">
    <label for="role">* Role(s) : </label><br/>
      <?php 
      foreach ($role as $key) {
          echo '<label for="role">'.$key['libelle'].'</label><br/>';
      }

        ?>
     
        
      
    </div>
  </div>
  <input class="btn btn-primary" type="submit" name="submit" >
</form>
  </div>
<br/>
  * Champs Obligatoirs.
</div>


<?php  echo $v1;
    echo $v2;
    echo $v3; ?>
<?php    include '../Blocs_HTML/footer.php';
?>

</body>
</html>