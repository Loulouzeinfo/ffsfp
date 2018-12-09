<?php

$mysqli = new mysqli("localhost","root","","ffsfp");// localhost nom de ta machine ,  root: le mot de passe, ffsfp: la base que tu devras crée 

if ($mysqli -> connect_errno)
      {
        printf("Info =====> %s \n", $mysqli->connect_error);
        exit();
      }



?>