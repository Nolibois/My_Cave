<?php $titlePage = "My Cave"; ?>

<?php
// For TESTING
$imgBottle = 'public/img/block_nine.jpg';
$name = 'BLOCK NINE';
$country = 'USA';
$year = '2009';

?>


<?php ob_start(); ?>

<section id="presentation">
  <h1>My Cave</h1>
  <p>Ce site permet de visualiser une liste de bouteilles mais également de gérer la modification, l'ajout et l'effacement d'articles de la cave une fois connecté en tant qu'administrateur.</p>
</section>
<section id="hightlight">
  <div>
    <h2>Bouteille du moment</h2>
    <div class="card-container-bottle">
      <img src="<?= $imgBottle; ?>" alt="">
      <h2><?= $name; ?></h2>
      <p><?= $country; ?> - <?= $year; ?></p>
    </div>
  </div>

</section>

<?php $content = ob_get_clean(); ?>

<?php require 'template.php'; ?>