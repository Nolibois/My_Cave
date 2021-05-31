<?php $titlePage = "My Cave"; ?>

<?php
// For TESTING
$imgBottle = 'public/img/block_nine.png';
$name = 'BLOCK NINE';
$country = 'USA';
$year = '2009';

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
      <div><img src="<?= $imgBottle; ?>" alt="..."></div>
      <div><img src="<?= $imgBottle; ?>" alt="..."></div>
      <div><img src="<?= $imgBottle; ?>" alt="..."></div>
    </div>
  </div>

</section>

<?php $content = ob_get_clean(); ?>

<?php require 'template.php'; ?>