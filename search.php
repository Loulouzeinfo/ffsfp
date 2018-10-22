<?php

if(isset($_GET['motcle']))
{

    if($_GET['motcle'] !="")
    {
 include("DB/base.php");



        $m=$_GET['motcle'];

    $req=$mysqli->query("SELECT codePostale,ville FROM villefrance WHERE codePostale LIKE '%".$m."%'");

                         while($ex=$req->fetch_array())
                         {
                               echo "<p>".$ex['ville']."</p>";
                         }

                         }


}



?>