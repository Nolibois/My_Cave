<?php $titlePage = "Gestion de ma Cave";

$pathImg = "public/uploads/";

ob_start();

?>
<section class="infos-bottle">
  <h1>Sélection</h1>

  <div class="card-container">
    <?php
    foreach ($infosBottle as $value) {
    ?>
      <div class="card-bottle">
        <img src='<?= $pathImg; ?><?= $value['picture']; ?>' alt="Bouteille <?= $value['picture']; ?>">
        <h2><?= $value['name']; ?></h2>
        <h3><?= $value['year']; ?></h3>
        <p><?= $value['grapes']; ?></p>
        <p><?= $value['country']; ?></p>
        <p><?= $value['region']; ?></p>
        <p><?= $value['description']; ?></p>
      </div>
    <?php
    }
    ?>
  </div>

  <div>
    <a href="index.php?action=bottles">Retour à la liste des bouteilles</a>
  </div>
</section>

<?php

$content = ob_get_clean();


require 'template.php';
