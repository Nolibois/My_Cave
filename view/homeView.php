<?php $titlePage = "My Cave"; ?>

<?php
$pathImg = "public/uploads/";

if (!isset($bottle1) || !isset($bottle2) || !isset($bottle3)) {
  array_push($msgError, 'Un problème pour récupérer les données du caroussel est survenu.');
}

?>


<?php ob_start(); ?>

<section id="presentation">
  <h1>My Cave</h1>
  <p>Ce site permet de visualiser une liste de bouteilles mais également de gérer la modification, l'ajout et l'effacement d'articles de la cave une fois connecté en tant qu'administrateur.</p>
</section>
<section id="highlight">
  <div class="carousel">
    <h2>Bouteille du moment</h2>

    <div class="single-item">
      <div>
        <img src="<?= $pathImg; ?><?= $bottle1["picture"]; ?>" alt="Bouteille <?= $bottle1["picture"]; ?>">
        <div>
          <h3><?= $bottle1["name"]; ?></h3>
          <p><?= $bottle1["year"]; ?></p>
        </div>
      </div>
      <div>
        <img src="<?= $pathImg; ?><?= $bottle2["picture"]; ?>" alt="Bouteille <?= $bottle2["picture"]; ?>">
        <div>
          <h3><?= $bottle2["name"]; ?></h3>
          <p><?= $bottle2["year"]; ?></p>
        </div>
      </div>
      <div>
        <img src="<?= $pathImg; ?><?= $bottle3["picture"]; ?>" alt="Bouteille <?= $bottle3["picture"]; ?>">
        <div>
          <h3><?= $bottle3["name"]; ?></h3>
          <p><?= $bottle3["year"]; ?></p>
        </div>
      </div>
    </div>
  </div>

</section>

<?php $content = ob_get_clean(); ?>

<?php require 'template.php'; ?>