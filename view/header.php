<header>
  <a href=""><img src="public/img/logo-large.png" alt="Logo My Cave large"></a>
  <nav>
    <?php
    if (!empty($_SESSION)) {
      var_dump($_SESSION);
    ?>

      <p>Vous êtes bien connecté <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></p>
    <?php
      $connected = "<a href='index.php?action=disconnect'>Déconnexion</a>";
    } else {
      $connected = "<a href='index.php?action=formconnect'>Connexion</a>";
    }
    ?>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="">Bouteilles</a></li>
      <li><?= $connected; ?></li>
    </ul>
  </nav>
</header>