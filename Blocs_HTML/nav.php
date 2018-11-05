<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light navbar-dark bg-dark ">
  <a class="navbar-brand" href="accueil.php"><img id="imgadmm" src="../Images/POP.gif"></a><span id="poli">BIENVENUE  SUR LE SITE OFFICIEL DE LA FEDERATION FRANCAISE DES SECOURISTES ET FORMATEURS POLICIERS</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav  ml-auto top">

      <li class="navbar"><a href="accueil.php"><i class="fas fa-home"></i></a></li>
      <li class="nav-item dropdown">

      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Adhérents
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="gestion_adh.php">Gestion Adhérents </a>
        <a class="dropdown-item" href="ajoutAdherents.php">Ajouter adhérents</a>
        
      </div>
    </li>


       <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Paramétrages
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href=""> Financier </a>
        <a class="dropdown-item" href=""> Formation </a>
        
      </div>
    </li>
       <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Délégations
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="">Gestion de délégations </a>
        <a class="dropdown-item" href="">Ajouter une délégation</a>
        
      </div>
     
    </li>

    <li class="nav-item dropdown p">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Bonjour <?php  echo $profile;  ?> 
      </a>

      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Link 1</a>
        <a class="dropdown-item" href="../deconnection_session.php">Déconnxion</a>
      </div>

    </li>
    </ul>
  </div>
</nav>