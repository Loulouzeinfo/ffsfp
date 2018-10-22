<?php

$mysqli = new mysqli("localhost","root","","ffsfp");

if ($mysqli -> connect_errno)
      {
        printf("Info =====> %s\n", $mysqli->connect_error);
        exit();
      }
      




?>