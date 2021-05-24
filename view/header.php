<header>
  <a href=""><img src="public/img/logo-large.png" alt="Logo My Cave large"></a>
  <nav>
    <?php
    if (!empty($_SESSION)) {
    ?>
      <p>Vous êtes bien connecté <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></p>
    <?php
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
</header>