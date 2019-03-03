<?php
$s = '';

$reqsql = "SELECT * FROM personne,role,assoc_per_rol WHERE mail='$sess' AND personne.id_personne=assoc_per_rol.id_personne
                 AND assoc_per_rol.id_role=role.id_role";
$donpro = $mysqli->query($reqsql) or die(mysqli_error($mysqli));
while ($respro = $donpro->fetch_array()) {
    // code...
    $tableau[] = $respro['libelle'];
}

?>
<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light navbar-dark bg-dark ">
  <a class="navbar-brand" href="accueil.php"><img id="imgadmm" src="../Images/POP.gif"></a><span id="poli">BIENVENUE  SUR PLATON, LA PLATFORME D'OUVERTURE DE COURS ET DE NOUVELLE ADHESION.</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-right: 65px;">
    <ul class="navbar-nav  ml-auto top">

      <li class="navbar"><a href="accueil.php"><i class="fas fa-home"></i></a></li>

     <?php
            if (in_array('ADMINISTRATEUR', $tableau)) {
                ?>
    <li class="nav-item dropdown">
      <a class="nav-link " href="#" id="navbardrop" data-toggle="dropdown"><i class="fas fa-bell" id="iconnot"> </i><span id="count" class="badge badge-danger count" style="border-radius:10px;"></span>
      </a>
    <ul class="dropdown-menu not"></ul>
    </li>

      <li class="nav-item dropdown">

      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Adhérents
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="gestion_adh.php">Gestion adhérents </a>
        <a class="dropdown-item" href="ajoutAdherents.php">Ajouter adhérent</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item " href="import.php">Import des données .csv</a>


      </div>
    </li>



     <li class="nav-item dropdown  ">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Paramétrages
      </a>

      <div class="dropdown-menu scrollable_menu">
        <a class="dropdown-item" style="pointer-events: none; cursor: default;" href="">Financier </a>
         <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="cotisation.php"> Paramétrage des cotisations </a></li></ul>
         <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="ParamDiplome.php"> Paramétrage du coût du diplôme </a></li></ul>
         <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="historique.php">Historiques</a></li></ul>
         <div class="dropdown-divider"></div>
        <a class="dropdown-item"style="pointer-events: none; cursor: default;" href="">Formation </a>
         <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="formation.php"> Paramétrage formation </a></li></ul>
         <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="historiqueParamFormation.php"> Historique  </a></li></ul>
        <a class="dropdown-item"style="pointer-events: none; cursor: default;" href="">Modèle </a>
        <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="modeleDiplome.php"> Modèles de documents </a></li></ul>
         <ul><li class="dropdown-submenu dropdown-item"> <a class=" dropdown-item" href="HistoriquesModeles.php"> Historiques  </a></li></ul>
         <a class="dropdown-item " href="structure.php">Structure</a>
      </div>
      
    </li>
       <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Délégations
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="historiqueDelegue.php">Gestion de délégations </a>
        <a class="dropdown-item" href="AjoutDelegation.php">Ajouter une délégation</a>

      </div>

    </li>


<?php
            }
       ?>


<?php
            if (in_array('DELEGUE', $tableau)) {
                ?>
</li>
       <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Délégations
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="historiqueDelegue.php">Gestion de délégations </a>
        <a class="dropdown-item" href="">Ajouter un formateur</a>
        <a class="dropdown-item" href="">Liste d'aptitude</a>
        <a class="dropdown-item" href="">Certificat d'affiliation</a>
        <a class="dropdown-item" href="">Gestion des formations</a>

      </div>

    </li>
    <?php
            }
       ?>


<?php
            if (in_array('FORMATEUR', $tableau)) {
                ?>
   <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Formation
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="historiqueDelegue.php">Gestion de délégations </a>
        <a class="dropdown-item" href="AjoutDelegation.php">Ajouter une délégation</a>

      </div>

    </li>

    <?php
            }
       ?>


    <li class="nav-item dropdown p">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Bonjour <?php echo $profile; ?>
      </a>
      
      <div class="dropdown-menu">


        <a class="dropdown-item" href="profile.php">Mot de passe</a>
        <a class="dropdown-item" href="diplome.php">Diplômes</a>
        <a class="dropdown-item" href="historiquemodpersonne.php">Historique diplôme</a>
        <a class="dropdown-item" href="mesdonnees.php">Mes données</a>
        <a class="dropdown-item" href="../Administrateur/cotisationAdherent.php">Payer ma cotisation</a>
        <a class="dropdown-item" href="../Administrateur/historiqueCotisation.php">Historique des paiments</a>


        <div class="dropdown-divider"></div>
       <a class="dropdown-item" href="../deconnectionSession.php">Déconnexion</a>
      </div>

    </li>
    </ul>
  </div>
</nav>