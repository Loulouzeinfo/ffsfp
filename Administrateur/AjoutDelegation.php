<?php
session_start();
include '../Fonction/fonction.php';
include '../DB/base.php';
$profile = '';
$dep = array();
$v1 = '';
$del = 'null';

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

    $sqldp = 'SELECT DISTINCT  departement FROM villefrance ORDER BY departement ASC  ';
    $donndep = $mysqli->query($sqldp) or die(mysqli_error($mysqli));
    while ($resdep = $donndep->fetch_array()) {
        $dep[] = $resdep;
    }

    $sql22 = "SELECT * FROM personne WHERE mail='$sess'";
    $donpro = $mysqli->query($sql22) or die(mysqli_error($mysqli));
    $respro = $donpro->fetch_array();
    $profile = $respro['prenom'];

    if (isset($_POST['submit'])) {
        if (!empty($_POST['departement']) && !empty($_POST['deleguer']) && !empty($_POST['formateur1']) &&
            !empty($_POST['formateur2']) && !empty($_POST['medcin'])) {
            $deparetement = $mysqli->real_escape_string(trim(verif($_POST['departement'])));
            $gelegue = $mysqli->real_escape_string(trim(verif($_POST['deleguer'])));
            $formateur1 = $mysqli->real_escape_string(trim(verif($_POST['formateur1'])));
            $formateur2 = $mysqli->real_escape_string(trim(verif($_POST['formateur2'])));
            $medcin = $mysqli->real_escape_string(trim(verif($_POST['medcin'])));
            $hiddendeg = $_POST['hiddendeg'];
            $hiddenr = $_POST['hiddenr'];
            $hiddenrf2 = $_POST['hiddenrf2'];
            $hiddenrm = $_POST['hiddenrm'];

            $reqeteselectedelegue = "SELECT * FROM delegation WHERE id_personne='$hiddendeg'";
            $resdeleg = RowsOne($reqeteselectedelegue);
            console_log($resdeleg);

            $reqeteselectformateur1 = "SELECT * FROM delegation WHERE id_personne='$hiddenr'";
            $resformateur1 = RowsOne($reqeteselectformateur1);
            console_log($resformateur1);

            $reqeteselectformateur2 = "SELECT * FROM delegation WHERE id_personne='$hiddenrf2'";
            $resformateur2 = RowsOne($reqeteselectformateur2);
            console_log($resformateur2);

            $reqeteselectmedcin = "SELECT * FROM delegation WHERE id_personne='$hiddenrm'";
            $resmedcin = RowsOne($reqeteselectedelegue);
            console_log($resmedcin);

            if ($resdeleg == true) {
                $v1 = '<script> dialoginfo("Le délégué existe déja", "AjoutDelegation.php"); </script>';
            } elseif ($resformateur1 == true) {
                $v1 = '<script> dialoginfo("Le formateur existe déja", "AjoutDelegation.php"); </script>';
            } elseif ($resformateur2 == true) {
                $v1 = '<script> dialoginfo("Le formateur existe déja", "AjoutDelegation.php"); </script>';
            } elseif ($resmedcin == true) {
                $v1 = '<script> dialoginfo("Le médecin existe déja", "AjoutDelegation.php"); </script>';
            } else {
                if ($deparetement != 'null' && $formateur1 != $formateur2 && $formateur1 != $medcin && $formateur2 != $medcin) {
                    $requetdeleguer = "INSERT INTO delegation (id_personne,nom_prenom,nomination,deparetement) VALUES
            ('$hiddendeg','$gelegue', 'Deleguer','$deparetement')";
                    insertDB($requetdeleguer);

                    $requetformateur1 = "INSERT INTO delegation (id_personne,nom_prenom,nomination,deparetement) VALUES
            ('$hiddenr','$formateur1', 'Formateur','$deparetement')";
                    insertDB($requetformateur1);

                    $requetformateur2 = "INSERT INTO delegation (id_personne,nom_prenom,nomination,deparetement) VALUES
            ('$hiddenrf2','$formateur2', 'Formateur','$deparetement')";
                    insertDB($requetformateur2);

                    $requetemedcin = "INSERT INTO delegation (id_personne,nom_prenom,nomination,deparetement) VALUES
            ('$hiddenrm','$medcin', 'Medcin','$deparetement')";
                    insertDB($requetemedcin);
                    $v1 = '<script> dialogsuccess("Enregistré","AjoutDelegation.php"); </script>';
                } else {
                    $v1 = '<script> dialoginfo("- Sélectionner un département \n Et/Ou \n - Les noms des délégués sont identiques", "AjoutDelegation.php"); </script>';
                }
            }
        } else {
            $v1 = '<script> dialoginfo("tous les champs sont obligatoires", "AjoutDelegation.php"); </script>';
        }
    }

    if (isset($_GET['editdelegue'])) {
        if (!empty($_GET['editdelegue'])) {
            $del = $mysqli->real_escape_string(trim(verif($_GET['editdelegue'])));
            $reqselectdelegue = "SELECT * FROM delegation WHERE deparetement='$del'";
            $donnrole = $mysqli->query($reqselectdelegue) or die(mysqli_error($mysqli));
            while ($resrole = $donnrole->fetch_array()) {
                $tab[] = $resrole;
            }
        } else {
            $v1 = '<script> dialoginfo("Le département n\'existe pas", "AjoutDelegation.php"); </script>';
        }
    }
} //elselogin

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <?php include '../Blocs_HTML/script_bootstrap_header.php'; ?>

    <title>Ajouter une délégation</title>

    <link rel="stylesheet" href="../CSS/Style.css">


</head>

<body>
    <?php include '../Blocs_HTML/nav.php'; ?>


    <div class="jumbotron jumbotron-fluid ajoutad">
        <div class="container">
            <h1 class="display-5">Ajouter une délégation : </h1>

            <form method="post">
                <div  class="form-group row">
                <label for="validationDefault04" class="col-sm-2 col-form-label">* Département : </label>
                <div class="col-sm-10">

                    <select id="validationDefault04" class="form-control" name="departement">
                        <option  value="750 Siège" >750 (Siège)</option>
                        <option value="<?php $del; ?>" selected><?php if ($del == 'null') {
    echo 'Sélectionner un département';
} else {
    echo $del;
}

                        ?></option>
                        <?php

foreach ($dep as $keydep) {
    echo '<option value='.$keydep['departement'].' >'.$keydep['departement'].'</option>';
}

?>
                    </select>

                </div>
                </div>

                <div class="form-group row">
                <label for="deleguer" class="col-sm-2 col-form-label">* Délégué : </label>
                <div class="col-sm-10">

                <input type="text" class="form-control" id="deleguer" placeholder="Délégué" name="deleguer">
                <div id="autocomNom"  style="position: absolute; z-index: 2; width:96.5%;" ></div>

                </div>
                </div>
                <div class="form-group row">
                            <div class="col-sm-2 soul">Equipe : </div>
                 </div>

                 <div class="form-group row">
                <label for="formateur1" class="col-sm-2 col-form-label">* Formateur 1 : </label>
                <div class="col-sm-10">

                <input type="text" class="form-control" id="formateur1" placeholder="Saisir le nom du formateur " name="formateur1">
                <div id="autoformat1"  style="position: absolute; z-index: 2; width:96.5%;" ></div>

                </div>
                </div>

                <div class="form-group row">
                <label for="formateur2" class="col-sm-2 col-form-label">* Formateur 2 : </label>
                <div class="col-sm-10">

                <input type="text" class="form-control" id="formateur2" placeholder="Saisir le nom du formateur" name="formateur2">
                <div id="autoformat2"  style="position: absolute; z-index: 2; width:96.5%;" ></div>

                </div>
                </div>

                <div class="form-group row">
                <label for="medcin" class="col-sm-2 col-form-label">* Médecin : </label>
                <div class="col-sm-10">

                <input type="text" class="form-control" id="medcin" placeholder="Saisir le nom du médecin " name="medcin">
                <div id="autocomm"  style="position: absolute; z-index: 2; width:96.5%;" ></div>

                </div>
                </div>

                <div class="form-row">
   <div class="col-md-4 mb-3">
      <button type="submit"  class="btn btn-primary" name="submit">Valider</button>
</div>
    </div>


            </form>
        </div>






        <br />
        * Champs Obligatoirs.
    </div>


    <?php echo $v1; ?>
    <?php include '../Blocs_HTML/footer.php'; ?>

</body>

</html>