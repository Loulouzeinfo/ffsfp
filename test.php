<?php

$role=array();

include("DB/base.php");




 $sql2="SELECT * FROM role ";
  $donnrole= $mysqli->query($sql2)or die(mysqli_error($mysqli));
  while ($resrole=$donnrole->fetch_array()) {
    
    $role[]=$resrole;
  }
              
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
    if (isset($_POST['submit'])) {
     
                 $choix=$_POST["choix"];
                for ($i=0; $i < sizeof($choix) ; $i++) { 
                  # code...

                  echo $choix[$i]."<br/>";
                }
                 var_dump($choix);

             }         





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
      <?php 
             foreach ($role as $key1) {
            echo "<input class=\"form-check-input\" type=\"checkbox\" name=\"choix[]\" value=".$key1['id_role']."> 
            <label class=\"form-check-label\"  for=\"invalidCheck2\">".$key1['libelle']."</label><br/>";
                 }
             
         ?>
     <input type="submit" name="submit">
      
      
    </div>
  </div>
</form>
</script>

  
</body>

</html>