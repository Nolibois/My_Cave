<header>
  <?php


  if (isset($_SESSION) && !empty($_SESSION)) {
  ?>
    <div>
      <p>Vous êtes bien connecté <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></p>
    </div>
  <?php
  }
  ?>
  <div id="nav-container">
    <div id="logo-nav">
      <a href="index.php">My Cave</a>
    </div>
    <nav>
      <?php
      if (!empty($_SESSION)) {

        $connected = "<li><a href='index.php'>Accueil</a></li>
      <li><a href='index.php?action=bottles'>Bouteilles</a></li>
      <li><a href='index.php?action=manageCave'>Gérer ma cave</a></li>
      <li><a href='index.php?action=disconnect'>Déconnexion</a></li>";
      } else {
        $connected = "<li><a href='index.php'>Accueil</a></li>
      <li><a href='index.php?action=bottles'>Bouteilles</a></li>
      <li><a href='index.php?action=formConnect'>Connexion</a></li>";
      }
      ?>
      <ul>
        <?= $connected; ?>
      </ul>
    </nav>
  </div>

</header>