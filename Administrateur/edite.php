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
$t = array();

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
    $sql2 = 'SELECT * FROM role';
    $donnrole = $mysqli->query($sql2) or die(mysqli_error($mysqli));
    while ($resrole = $donnrole->fetch_array()) {
        $role[] = $resrole;
    }

    $sql1 = 'SELECT * FROM t_pays ';
    $donnpays = $mysqli->query($sql1) or die(mysqli_error($mysqli));
    while ($res = $donnpays->fetch_array()) {
        $pay[] = $res;
    }

    $sqldp = 'SELECT DISTINCT  departement FROM villefrance ORDER BY departement ASC  ';
    $donndep = $mysqli->query($sqldp) or die(mysqli_error($mysqli));
    while ($resdep = $donndep->fetch_array()) {
        $dep[] = $resdep;
    }

    $sql22 = "SELECT * FROM personne WHERE mail='$sess'";
    $donpro = $mysqli->query($sql22) or die(mysqli_error($mysqli));
    $respro = $donpro->fetch_array();
    $profile = $respro['prenom'];

    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
        $m = $_GET['edit'];

        $sqlm = "SELECT * FROM personne WHERE mail='$m'";
        $donprom = $mysqli->query($sqlm) or die(mysqli_error($mysqli));
        $resprom = $donprom->fetch_array();

        $sqlr = "SELECT id_role FROM assoc_per_rol WHERE id_personne='".$resprom['id_personne']."'";
        $donpror = $mysqli->query($sqlr) or die(mysqli_error($mysqli));
        while ($respror = $donpror->fetch_array()) {
            $t[] = $respror['id_role'];
        }
    } else {
        $v1 = '<script>
               swal({
                
                text: "le champs mail dans url est vide !",
                icon: "info"
                }).then(function() {
                window.location = "gestion_adh.php";
                 });
               
               </script>';
    }

    if (isset($_POST['submit'])) {
        if (!empty($_POST['id_ad']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) &&
       !empty($_POST['date']) && !empty($_POST['lieu']) && !empty($_POST['selec']) && !empty($_POST['choix']) && !empty($_POST['PaysRes']) && !empty($_POST['departementRes']) && !empty($_POST['adressePh']) && !empty($_POST['ville_p']) && !empty($_POST['codePos']) && !empty($_POST['profession_p'])) {
            $id_roleP = $mysqli->real_escape_string(trim(verif($_POST['id_ad'])));
            $nomP = $mysqli->real_escape_string(trim(verif($_POST['nom'])));
            $prenomP = $mysqli->real_escape_string(trim(verif($_POST['prenom'])));
            $mailP = $mysqli->real_escape_string(trim(verif($_POST['mail'])));
            $dateP = $mysqli->real_escape_string(trim(verif($_POST['date'])));
            $lieuP = $mysqli->real_escape_string(trim(verif($_POST['lieu'])));
            $selectP = $mysqli->real_escape_string(trim(verif($_POST['selec'])));
            $choixP = $_POST['choix'];

            $PaysRes = $mysqli->real_escape_string(trim(verif($_POST['PaysRes'])));
            $departementRes = $mysqli->real_escape_string(trim(verif($_POST['departementRes'])));
            $adressePh = $mysqli->real_escape_string(trim(verif($_POST['adressePh'])));
            $code_postale = $mysqli->real_escape_string(trim(verif($_POST['codePos'])));

            $ville_p = $mysqli->real_escape_string(trim(verif($_POST['ville_p'])));

            $profession_p = $mysqli->real_escape_string(trim(verif($_POST['profession_p'])));
            $tarification = $mysqli->real_escape_string(trim(verif($_POST['Tarification'])));

            if (!filter_var($mailP, FILTER_VALIDATE_EMAIL)) {
                $v1 = "<script>
               swal({
                text: \"votre adresse mail n'est pas valide\",
                icon: \"error\"
                }).then(function() {
                window.location = \"edite.php\";
                 });
               
               </script>";
            } else {
                if (isset($_POST['select2']) && !empty($_POST['select2'])) {
                    $select22 = $mysqli->real_escape_string(trim(verif($_POST['select2'])));

                    $sqlup = "UPDATE personne SET id_personne='$id_roleP', nom='$nomP', prenom='$prenomP', date_de_naissance='$dateP', lieu_de_naissance='$lieuP',pays_naissance='$selectP', mail='$mailP' , departement_naissance='$select22', Departement='$departementRes', pays='$PaysRes', addresse='$adressePh', code_postale='$code_postale', ville='$ville_p' ,
                              profession='$profession_p' WHERE mail='$m' ";

                    insertDB($sqlup);

                    $updatetarification = "UPDATE cotisationniveau SET cotisationN='$tarification' WHERE id_personne='".$resprom['id_personne']."'";

                    insertDB($updatetarification);

                    $su = "DELETE FROM assoc_per_rol WHERE id_personne='".$resprom['id_personne']."'";
                    insertDB($su);
                    for ($i = 0; $i < sizeof($choixP); ++$i) {
                        $sqlch = "INSERT INTO assoc_per_rol(id_personne,id_role) VALUES ('$id_roleP',".$choixP[$i].' )';
                        insertDB($sqlch);

                        // code...
                    }
                    $v1 = '<script>
               swal({
                text: "Mise à jour réussie",
                icon: "success"
                }).then(function() {
                window.location = "gestion_adh.php";
                 });
               
               </script>';
                } else {
                    $sqlup = "UPDATE personne SET id_personne='$id_roleP', nom='$nomP', prenom='$prenomP', date_de_naissance='$dateP', lieu_de_naissance='$lieuP',pays_naissance='$selectP', mail='$mailP' , departement_naissance='$select22', Departement='$departementRes', pays='$PaysRes', addresse='$adressePh', code_postale='$code_postale', ville='$Ville_p', profession='$Profession_p' WHERE mail='$m' ";
                    insertDB($sqlup);
                    $updatetarification = "UPDATE cotisationniveau SET cotisationN='$tarification' WHERE id_personne='".$resprom['id_personne']."'";
                    insertDB($updatetarification);

                    $su = "DELETE FROM assoc_per_rol WHERE id_personne='".$resprom['id_personne']."'";
                    insertDB($su);
                    for ($i = 0; $i < sizeof($choixP); ++$i) {
                        $sqlch = "INSERT INTO assoc_per_rol(id_personne,id_role) VALUES ('$id_roleP',".$choixP[$i].' )';
                        insertDB($sqlch);

                        // code...
                    }
                    $v1 = '<script>
               swal({
                text: "Mise à jour !",
                icon: "success"
                }).then(function() {
                window.location = "gestion_adh.php";
                 });
               
               </script>';
                }
            }
        } else {
            $v1 = '<script>
               swal({
                
                text: "Tous les champs sont Obligatoirs !",
                icon: "info"
                });
               
               </script>';
        }
    } //elsesubmit
}//elselogin

  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <?php  include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Ajouter d'adhérents</title>

  <link rel="stylesheet" href="../CSS/Style.css">


</head>
<body>
<?php    include '../Blocs_HTML/nav.php'; ?>


<div class="jumbotron jumbotron-fluid ajoutad">
  <div class="container">
    <h1 class="display-5">Modifier les coordonnées d'un Adhérent : </h1>

        <form method="post" >
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">* Numéro d'adhérent : </label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="Numéro d'adhérent" name="id_ad" value="<?php echo utf8_encode($resprom['id_personne']); ?>" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">* Nom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Nom" name="nom" value="<?php echo utf8_encode($resprom['nom']); ?>" required>
    </div>
     <div class="col-md-4 mb-3">
      <label for="validationDefault02">* Prénom :</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Prénom" name="prenom" value="<?php echo utf8_encode($resprom['prenom']); ?>" required>
    </div>
  </div>
  <div class="form-row">
       <div class="col-md-3 mb-3">
      <label for="validationDefaultUsername">* Adresse mail :</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend2">@</span>
        </div>
        <input type="text" class="form-control" id="validationDefaultUsername"  name="mail" placeholder="Adresse mail" value="<?php echo utf8_encode($resprom['mail']); ?>" aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault03">* Date de naissance :</label>
       <input class="form-control" id="datepicker"  name="date" value="<?php echo utf8_encode($resprom['date_de_naissance']); ?>" placeholder="date de naissance" required />
    <script>

   $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy'

        });
    </script>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Lieu de naissance :</label>
      <input type="text" class="form-control" id="validationDefault05" value="<?php echo utf8_encode($resprom['lieu_de_naissance']); ?>" placeholder="Lieu de naissance" name="lieu" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Pays de naissance : </label>
      <select id="inputState" class="form-control" name="selec">
        <option value="<?php echo utf8_encode($resprom['pays_naissance']); ?>" selected><?php echo utf8_encode($resprom['pays_naissance']); ?></option>
      <?php 

          foreach ($pay as $key) {
              echo '<option value='.$key['pays'].'>'.$key['pays'].'</option>';
          }

        ?>
      </select>
      
    </div>

    
   

     <div class="col-md-3 mb-3">
      <label for="validationDefault04">* Département de naissance : </label>
      <select id="inputStated" class="form-control" name="select2" >
        <option  value="<?php echo utf8_encode($resprom['departement_naissance']); ?>" selected><?php echo utf8_encode($resprom['departement_naissance']); ?></option>
      <?php 

          foreach ($dep as $keydep) {
              echo '<option value='.$keydep['departement'].'>'.$keydep['departement'].'</option>';
          }

        ?>

        <option value="Etranger">Etranger</option>"
      </select>
      
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Pays de résidence :</label>
      <input type="text" class="form-control" id="PaysRes" value="<?php echo utf8_encode($resprom['pays']); ?>" placeholder="Pays de résidence" name="PaysRes" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Département de résidence :</label>
      <input type="text" class="form-control" id="departementRes" value="<?php echo utf8_encode($resprom['Departement']); ?>" placeholder="Pays de résidence" name="departementRes" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Adresse Physique :</label>
      <input type="text" class="form-control" id="adressePh" value="<?php echo utf8_encode($resprom['addresse']); ?>" placeholder="Adresse physique" name="adressePh" required>
    </div>

      <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Ville :</label>
      <input type="text" class="form-control" id="ville" value="<?php echo utf8_encode($resprom['ville']); ?>" placeholder="Ville" name="ville_p" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Code postale :</label>
      <input type="text" class="form-control" id="codePos" value="<?php echo utf8_encode($resprom['code_postale']); ?>" placeholder="Code Postale" name="codePos" required>
    </div>
      
      <div class="col-md-3 mb-3">
      <label for="validationDefault05">* Profession :</label>
      <input type="text" class="form-control" id="profession" value="<?php echo utf8_encode($resprom['profession']); ?>" placeholder="Profession" name="profession_p" required>
    </div>

    <div class="col-md-3 mb-3">
      <label for="validationDefault04">Tarification : </label>
      <select id="inputStated" class="form-control" name="Tarification" >
        <option  value="adhésion" selected>adhésion</option>
        <option  value="renouvellement">renouvellement</option>
        <option  value="gratuit">gratuit</option>

      </select>

    </div>
     
    
  </div>
  <div class="form-group">
    <div class="form-check">
    <label for="role">* Role(s) : </label><br/>
      <?php 
             foreach ($role as $key1) {
                 $va = '<input class="form-check-input" type="checkbox" name="choix[]" id="invalidCheck2"  value='.$key1['id_role'].' ';
                 if (in_array($key1['id_role'], $t)) {
                     $va .= 'checked >';
                 } else {
                     $va .= '>';
                 }
                 $va .= '<label class="form-check-label"  for="invalidCheck2">'.$key1['libelle'].'</label><br/>';
                 echo $va;
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
        
       
       $( "#inputState" ).change(function() {
      $d=$("#inputState").val();
     if($d  != 'France'){
           
            $("#inputStated").attr('disabled',true);
            
     }else{

                 $("#inputStated").removeAttr('disabled');

     }

  
});

      </script>

<?php  echo $v1; echo $v2; echo $v3; ?>
<?php    include '../Blocs_HTML/footer.php'; ?>

</body>
</html>