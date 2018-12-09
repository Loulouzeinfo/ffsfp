<?php


 include("DB/base.php");
$out='';
$mess='';

if(isset($_GET['data']))
{

    if($_GET['data'] !='')
    {




        $m=$_GET['data'];

    $req=$mysqli->query("SELECT * FROM personne WHERE nom LIKE '%".$m."%' " );
    $do=$req->num_rows;
    if($do > 0){

                 while($ex=$req->fetch_array())
                         {
                              
                           $out.="<tr>
      <th scope=\"row\">".utf8_encode($ex['id_personne'])."</th>
      <td>".utf8_encode($ex['nom'])."</td>
      <td>".utf8_encode($ex['prenom'])."</td>
      <td>".utf8_encode($ex['mail'])."</td>
      <td>".utf8_encode($ex['addresse'])."</td>
      <td>".utf8_encode($ex['code_postale'])."</td>
      <td>".utf8_encode($ex['ville'])."</td>
      <td>".utf8_encode($ex['Departement'])."</td>
      <td>
      <a href=\"gestion_adh.php?supp=".utf8_encode($ex['mail'])."\"><i class=\"fas fa-trash-alt\"></i></a>&nbsp;
      <a href=\" \"><i class=\"fas fa-user-edit\"></i></a>&nbsp;
      <a  href=\" \" data-toggle=\"modal\" data-target=\"#".utf8_encode($ex['nom'])."\"><i class=\"fas fa-search-plus\"></i></a>


  <div class=\"modal fade\" id=".utf8_encode($ex['nom'])." tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">".utf8_encode($ex['nom'])." ".utf8_encode($ex['prenom'])."</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
      <label> Date de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['date_de_naissance'])." readonly>
     <label> Lieu de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['lieu_de_naissance'])." readonly>
       <label> Pays de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['pays_naissance'])." readonly>
        <label> Departement de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['departement_naissance'])." readonly>
       <label> Profession : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['profession'])." readonly>



      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>









      </td>
    </tr>";









                          
                         }

                         

    }else{
 

          $mess.="<p>Le nom n'existe pas";

    }

 $data = array(
                     'notification' => $out,
                     'mess'=> $mess
                         );
                      echo json_encode($data);
                         


                         }

}else{


    $req=$mysqli->query("SELECT * FROM personne " );

   while($ex=$req->fetch_array())
                         {
                              
                           $out.="<tr>
      <th scope=\"row\">".utf8_encode($ex['id_personne'])."</th>
      <td>".utf8_encode($ex['nom'])."</td>
      <td>".utf8_encode($ex['prenom'])."</td>
      <td>".utf8_encode($ex['mail'])."</td>
      <td>".utf8_encode($ex['addresse'])."</td>
      <td>".utf8_encode($ex['code_postale'])."</td>
      <td>".utf8_encode($ex['ville'])."</td>
      <td>".utf8_encode($ex['Departement'])."</td>
      <td>
      <a href=\"gestion_adh.php?supp=".utf8_encode($ex['mail'])."\"><i class=\"fas fa-trash-alt\"></i></a>&nbsp;
      <a href=\" \"><i class=\"fas fa-user-edit\"></i></a>&nbsp;
      <a  href=\" \" data-toggle=\"modal\" data-target=\"#".utf8_encode($ex['nom'])."\"><i class=\"fas fa-search-plus\"></i></a>


  <div class=\"modal fade\" id=".utf8_encode($ex['nom'])." tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">".utf8_encode($ex['nom'])." ".utf8_encode($ex['prenom'])."</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
      <label> Date de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['date_de_naissance'])." readonly>
     <label> Lieu de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['lieu_de_naissance'])." readonly>
       <label> Pays de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['pays_naissance'])." readonly>
        <label> Departement de naissance : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['departement_naissance'])." readonly>
       <label> Profession : </label>
       <input type=\"text\" class=\"form-control\" placeholder=".utf8_encode($ex['profession'])." readonly>

)

      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>









      </td>
    </tr>";

                          
                         }

                          $data = array(
                     'notification' => $out
                         );
                      echo json_encode($data);








}





?>