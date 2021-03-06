<?php

function verif($login)
{
    $login = htmlentities($login);

    return $login;
}

function aleatoire($carac, $nb)
{
    $code = [];
    $res = '';

    $caracteres = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    $nombres = range(0, 9);
    $ran = rand(0, 100);

    shuffle($caracteres);
    shuffle($nombres);

    for ($i = 0; $i < $carac; ++$i) {
        $code[] = $caracteres[$i];
    }

    for ($i = 0; $i < $nb; ++$i) {
        $code[] = $nombres[$i];
    }

    shuffle($code);

    for ($i = 0; $i < ($nb + $carac); ++$i) {
        $res .= $code[$i];
    }
    $res .= $ran;

    return $res;
}

function insertDB($sql)
{
    include '../DB/base.php';
    $mysqli->query($sql) or die(mysqli_error($mysqli));
    $mysqli->close();
}

function selectDB($sqlc)
{
    include '../DB/base.php';
    $donnrole = $mysqli->query($sqlc) or die(mysqli_error($mysqli));
    $role = array();
    if (RowsOne($sqlc) == true) {
        $role = $donnrole->fetch_array();
    } else {
        while ($resrole = $donnrole->fetch_array()) {
            $role[] = $resrole;
        }
    }

    $mysqli->close();

    return $role;
}

function Rows($sqlc)
{
    include '../DB/base.php';
    $donnrole = $mysqli->query($sqlc) or die(mysqli_error($mysqli));
    $res = $donnrole->num_rows;
    if ($res == 0) {
        $resrows = false;
    } else {
        $resrows = true;
    }
    $mysqli->close();

    return $resrows;
}

function RowsOne($sqlc)
{
    include '../DB/base.php';
    $donnrole = $mysqli->query($sqlc) or die(mysqli_error($mysqli));
    $res = $donnrole->num_rows;
    if ($res == 1) {
        $resrows = true;
    } else {
        $resrows = false;
    }
    $mysqli->close();

    return $resrows;
}

function importeCv($file)
{
    $tab = array();
    if (($handle = fopen($file, 'r')) !== false) {
        $data = fgetcsv($handle, 1000, "\n");
        while (($data = fgetcsv($handle, 1000, "\n")) !== false) {
            $tab[] = $data;
            // code...
        }
    }

    fclose($handle);

    return $tab;
}

function console_log($data)
{
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
}

function SaveDiplomeModel($file, $name)
{
    $path = '../file/Modele/ModeleDip/'.$name;

    $file_name = $file['name'];
    $tmp_name = $file['tmp_name'];

    $file_extension = strrchr($file_name, '.');
    $extension_autorisées = array('.PDF', '.pdf', '.doc', '.DOC', '.docx', '.DOCX');
    $chemin = $path.'/'.$file_name;

    if (in_array($file_extension, $extension_autorisées)) {
        if (!file_exists('../file/Modele/ModeleDip/'.$name)) {
            mkdir($path, 0777);
        }
        move_uploaded_file($tmp_name, $chemin);

        $sqlD = "INSERT INTO modele_diplome(modeleUrl,nameModele) VALUES ('$name','$file_name' )";
        insertDB($sqlD);
        console_log('requete sql');

        return array('<script> dialogsuccess("Le modèle a bien été enregistré ","modeleDiplome.php"); </script>', $chemin);
    } else {
        return array('<script> dialoginfo("Extension non autorisée ","modeleDiplome.php"); </script>');
    }
}

function SaveCcaModel($file, $name)
{
    $path = '../file/Modele/ModeleCCA/'.$name;
    $file_name = $file['name'];
    $tmp_name = $file['tmp_name'];

    $file_extension = strrchr($file_name, '.');
    $extension_autorisées = array('.PDF', '.pdf', '.doc', '.DOC', '.docx', '.DOCX');
    $chemin = $path.'/'.$file_name;

    if (in_array($file_extension, $extension_autorisées)) {
        if (!file_exists('../file/Modele/ModeleCCA/'.$name)) {
            mkdir($path, 0777);
        }
        move_uploaded_file($tmp_name, $chemin);

        $sqlD = "INSERT INTO modele_caa(caaUrl,nameCaa) VALUES ('$name','$file_name' )";
        insertDB($sqlD);
        console_log('requete sql');

        return array('<script> dialogsuccess("Le modèle a bien été enregistré ","modeleDiplome.php"); </script>', $chemin);
    } else {
        return array('<script> dialoginfo("Extension non autorisée ","modeleDiplome.php"); </script>');
    }
}

function SaveDiplomePersonne($file, $name, $libelle)
{
    if (!file_exists('../file/Diplome/'.$name['nom'])) {
        mkdir('../file/Diplome/'.$name['nom'], 0777);
    }
    $path = '../file/Diplome/'.$name['nom'].'/'.$libelle;

    $idPersonne = $name['id_personne'];

    $file_name = $file['name'];
    $tmp_name = $file['tmp_name'];

    $file_extension = strrchr($file_name, '.');
    $extension_autorisées = array('.PDF', '.pdf', '.doc', '.DOC', '.docx', '.DOCX');
    $chemin = $path.'/'.$file_name;

    if (in_array($file_extension, $extension_autorisées)) {
        if (!file_exists('../file/Diplome/'.$name['nom'].'/'.$libelle)) {
            mkdir($path, 0777);
        }
        move_uploaded_file($tmp_name, $chemin);

        $sqlD = "INSERT INTO diplome_personne(libelleDiplome,urlDiplome,id_personne,status) VALUES ('$libelle','$chemin','$idPersonne',1)";
        insertDB($sqlD);
        console_log('requete sql');

        return array('<script> dialogsuccess("Le diplôme a bien été enregistré ","diplome.php"); </script>', $chemin);
    } else {
        return array('<script> dialoginfo("Extension non autorisée ","diplome.php"); </script>');
    }
}

function docx($chemin, $name)
{
    include_once 'docxtemplate.class.php';
    $doc = new DOCXTemplate($chemin);
    $doc->set('nom', $name);
    $doc->downloadAs('test.docx');
}

function rrmdir($dir)
{
    if (is_dir($dir)) { // si le paramètre est un dossier
        $objects = scandir($dir); // on scan le dossier pour récupérer ses objets
        foreach ($objects as $object) { // pour chaque objet
            if ($object != '.' && $object != '..') { // si l'objet n'est pas . ou ..
                if (filetype($dir.'/'.$object) == 'dir') {
                    rmdir($dir.'/'.$object);
                } else {
                    unlink($dir.'/'.$object);
                }
                // on supprime l'objet
            }
        }
        reset($objects); // on remet à 0 les objets
        rmdir($dir); // on supprime le dossier
    }
}
