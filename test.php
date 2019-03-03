<?php

include 'DB/base.php';
include 'Fonction/fonction.php';

mkdir('file/Diplome/d', 0777);

/*$requeteTarifica = "INSERT INTO cotisationniveau (id_personne,cotisationN,etat,anneCotisation) VALUES ('125d','$ad',0,'2098')";
$mysqli->query($requeteTarifica) or die(mysqli_error($mysqli));*/
?>

<!doctype html>
<html lang="fr">

<head>

    <title>Accueil Admin</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




</head>

<body>

    <form method="post">
        <div class="form-group">
            <div class="form-check">

                <input type="checkbox" name="champs" >

                <input type="submit" name="submit">


            </div>
        </div>
    </form>




</body>

</html>