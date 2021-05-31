<?php $titlePage = 'Liste des bouteilles de la Cave';

$pathImg = "public/uploads/";

ob_start();
?>
<section class="listBottles">
  <h1>Toutes les bouteilles de la cave</h1>

  <div class="card-container">
    <?php
    foreach ($listBottles as $key => $value) {
    ?>
      <div class="card-bottle">
        <img src='<?= $pathImg; ?><?= $value['picture']; ?>' alt="Bouteille <?= $value['picture']; ?>">
        <h2><?= $value['name']; ?></h2>
        <p><?= $value['year']; ?></p>
        <p><?= $value['country']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>
</section>

<?php

$content = ob_get_clean();


require 'template.php';
