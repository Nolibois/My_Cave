<?php $titlePage = "Connexion utilisateur"; ?>

<?php ob_start(); ?>

<section>
  <h1>Connexion</h1>

  <form action="" method="post">
    <div>
      <label for="email">Email</label>
      <input type="email" name="email" id="email">
    </div>
    <div>
      <label for="pass">Mot de passe</label>
      <input type="password" name="pass" id="pass">
    </div>
    <div><input type="submit" value="">Connexion</div>
  </form>
</section>


<?php $content = ob_get_clean(); ?>

<?php require 'template.php'; ?>