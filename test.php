<?php

include("Fonction/fonction.php");

// Heure actuelle
echo date('h:i:s') . "\n";

// Stoppe pour 10 secondes
sleep(10);

// retour !
echo date('h:i:s') . "\n";




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
  
  <form  method="post"  enctype="multipart/form-data">
 <div class="form-group">
    <div class="form-check">

      <input type="file" name="file" value="file">
      
     <input type="submit" name="submit">
      
      
    </div>
  </div>
</form>



  
</body>

</html>