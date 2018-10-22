<?php
//include("DB/base.php");




/*if (($handle = fopen("x.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	$mysqli->query('INSERT INTO t_pays SET pays="'.mb_convert_encoding($data[4], "UTF-8").'"');
        echo "ok"; 
    }
    fclose($handle);
}*/



?>

<!doctype html>
<html lang="fr">
<head>
     
        <title>Accueil Admin</title>
        <fieldset>
  <legend><span>Title goes here</span></legend>
  
</fieldset>
       
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script type='text/javascript' src='JS/fonction.js'></script>
        
  

</head>
<body>

     <label for="inpddCity">Ville</label>
      <input type="text" class="form-control" id="inputCity">
      <p id="p"></p>

</html>