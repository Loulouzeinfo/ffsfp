<?php

$role=array();

include("DB/base.php");

                 /* $password= hash('sha256', 'mouloud');

                  $sql="SELECT assoc_per_rol.id_role, assoc_per_rol.id_personne, role.libelle FROM personne,role,assoc_per_rol WHERE personne.id_personne=assoc_per_rol.id_personne AND role.id_role=assoc_per_rol.id_role AND
                    mail='chikhouneloulouze@gmail.com' AND password='$password'";
                  $donn=$mysqli->query($sql)or die(mysqli_error($mysqli));
                   while ($res= $donn->fetch_array()) {
                    $tab[]=$res;
                  }
          var_dump($tab);
                  /*foreach ($tab as $key) {
                    # code...
                    echo $key[];
                  }*/
   




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
  <form method="POST">
 <div class="form-group">
    <div class="form-check">

      <input type="file" name="file" value="file">
      
     <input type="submit" name="submit">
      
      
    </div>
  </div>
</form>
</script>

  
</body>

</html>