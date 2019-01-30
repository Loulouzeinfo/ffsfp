<?php
session_start();
include '../DB/base.php';
include '../Fonction/fonction.php';
$profile = '';

$v1 = '';
$formation = array();
$tabF = array('libelle_formation' => '');
$out = '';

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
    $sql22 = "SELECT * FROM personne WHERE mail='$sess'";
    $donpro = $mysqli->query($sql22) or die(mysqli_error($mysqli));
    $respro = $donpro->fetch_array();
    $profile = $respro['prenom'];

    $sqForm = 'SELECT * FROM formation ';
    $donproF = $mysqli->query($sqForm) or die(mysqli_error($mysqli));
    while ($resproF = $donproF->fetch_array()) {
        $formation[] = $resproF;
        // code...
    }

    if (isset($_POST['submit'])) {
        if (!empty($_POST['libelleForma'])) {
            $libelleForma = $mysqli->real_escape_string(trim(verif($_POST['libelleForma'])));

            if (RowsOne("SELECT * FROM formation WHERE libelle_formation='$libelleForma'") == false) {
                if (isset($_POST['age'])) {
                    $sqlch = "INSERT INTO formation(libelle_formation,age) VALUES ('$libelleForma',1)";
                    insertDB($sqlch);
                } else {
                    $sqlch = "INSERT INTO formation(libelle_formation,age) VALUES ('$libelleForma',0)";
                    insertDB($sqlch);
                }
            } else {
                if (isset($_POST['age'])) {
                    $sqlch = "UPDATE formation SET libelle_formation='$libelleForma', age= 1 WHERE libelle_formation= '$libelleForma' ";
                    insertDB($sqlch);
                } else {
                    $sqlch = "UPDATE formation SET libelle_formation='$libelleForma' , age= 0 WHERE libelle_formation= '$libelleForma'";
                    insertDB($sqlch);
                }
            }

            foreach ($_POST['l'] as $key) {
                if ($key == 'NULL') {
                    continue;
                } else {
                    $sqPreroquis = "INSERT INTO prerequis(libelle_formation,libellePreroquis) VALUES ('$libelleForma','$key')";
                    insertDB($sqPreroquis);
                }
            }

            foreach ($_POST['prero'] as $key1) {
                if ($key1 == 'NULL') {
                    continue;
                } else {
                    $sqPrerogative = "INSERT INTO prerogative(libelle_formation,libellePrerogative) VALUES ('$libelleForma','$key1')";
                    insertDB($sqPrerogative);
                }
            }

            $v1 = '<script> dialogsuccess("Enregistré","formation.php"); </script>';
        } else {
            $v1 = '<script> dialoginfo("Le champs Libellé est vide","formation.php"); </script>';
        }
    }

    if (isset($_GET['editF'])) {
        $editF = $mysqli->real_escape_string(trim(verif($_GET['editF'])));
        $tabF = selectDB("SELECT * FROM formation WHERE id_formation='$editF'");

        if ($tabF['age'] == 1) {
            $out .= 'checked';
        } else {
            $out .= '';
        }
    }
}

?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">

  <?php include '../Blocs_HTML/script_bootstrap_header.php'; ?>

  <title>Cotisation</title>
  <link rel="stylesheet" href="../CSS/Style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<body>

 <?php include '../Blocs_HTML/nav.php'; ?>

<div class="jumbotron jumbotron-fluid cotisation accueil">


  <div class="container">
    <h1 class="display-6">Paramétrage des formations </h1>

        <form method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Libellé : </label>
      <input type="text" class="form-control" id="libelleForma" placeholder="Libellé de la Formation" name="libelleForma" value="<?php echo $tabF['libelle_formation']; ?>" >
    </div>
  </div>


    <div class="form-group row">
    <div class="col-sm-2 soul">Prérequis : </div>
    <div class="col-sm-4">
      <div class="form-check">

        <input class="form-check-input" type="checkbox" id="gridCheck1" name="age" <?php echo $out; ?> >
        <label class="form-check-label" for="gridCheck1">
          18 Ans.
        </label>
      </div>
    </div>
  </div>
    <div id="sel">
    <div class="form-group row" >
    <div class="col-sm-2" >Prérequis</div>
    <div class="col-sm-3">
      <div class="form-check">
        <select id="inputState" class="form-control" name="l[]">
        <option value="NULL" selected>Choisir une formation</option>

        <?php foreach ($formation as $key) {
    echo '<option value='.utf8_encode($key['libelle_formation']).'>'.utf8_encode($key['libelle_formation']).'</option>';
}?>
      </select>
      </div>
    </div>
  </div>
  </div>

  <div  class="ajFormation">

  </div>



  <input type="button" class="btn btn-primary" id="cli" name="" value="Ajouter un prérequis">

</br></br>

  <div class="form-group row">
    <div class="col-sm-2 soul">Prérogatives :</div>
  </div>
  <div id="sel2">
    <div class="form-group row" >
    <div class="col-sm-2">prérogative</div>
    <div class="col-sm-3">
      <div class="form-check">
        <select id="inputState" class="form-control" name="prero[]">
        <option value="NULL" selected>Choisir une formation</option>
        <?php foreach ($formation as $key) {
    echo '<option value='.utf8_encode($key['libelle_formation']).'>'.utf8_encode($key['libelle_formation']).'</option>';
}?>
      </select>
      </div>
    </div>
  </div>
</div>

   <div  class="ajPrero"></div>



  <input type="button" class="btn btn-primary" id="cliP" name="" value="Ajouter une prérogative">

</br></br>



    <div class="form-row">
   <div class="col-md-4 mb-3">
      <button type="submit"  class="btn btn-primary" name="submit">Valider</button>
</div>
    </div>

</form>


</div>
</div>

<?php echo $v1; ?>
<?php include '../Blocs_HTML/footer.php';?>


</body>
</html>