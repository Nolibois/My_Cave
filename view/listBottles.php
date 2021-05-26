<?php $titlePage = 'Liste des bouteilles de la Cave';

$pathImg = "public/uploads/";

ob_start();
?>

<h1>Toutes les bouteilles de la cave</h1>

<table>
  <thead>
    <tr>
      <th></th>
      <th>Nom du cru</th>
      <th>Millésime</th>
      <th>Cépages</th>
      <th>Pays d'Origine</th>
      <th>Région</th>
      <th>Description</th>
    </tr>

  </thead>

  <tbody>
    <?php
    foreach ($listBottles as $key => $value) {
    ?>
      <tr>
        <td><img src='<?= $pathImg; ?><?= $value['picture']; ?>' alt="Bouteille <?= $value['picture']; ?>"></td>
        <td><?= $value['name']; ?></td>
        <td><?= $value['year']; ?></td>
        <td><?= $value['grapes']; ?></td>
        <td><?= $value['country']; ?></td>
        <td><?= $value['region']; ?></td>
        <td><?= $value['description']; ?></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<?php

$content = ob_get_clean();


require 'template.php';
