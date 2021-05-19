<?php $titlePage = "Gestion de ma Cave";

$pathImg = "public/img/";

ob_start();
?>

<h1>Bienvenue dans votre cave <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></h1>

<ul>
  <p>Dans cet espace vous pouvez: </p>

  <li>Créer une nouvelle bouteille</li>
  <li>Modifier une existante</li>
  <li>Effacer</li>
</ul>

<h2>Sélectionner la bouteille à MODIFIER</h2>

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
      <th>Date de création</th>
      <th>Dernière modification</th>
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
        <td><?= $value['date_creation']; ?></td>
        <td><?= $value['date_last_setting']; ?></td>
        <td><a href="index.php?action=manageCave&set=<?= $value['id']; ?>">Sélectionner</a></td>
      </tr>
      <?php

      ////// Display form if bottle selected

      if (isset($_GET['set']) && ($_GET['set'] == $value['id'])) {
      ?>
        <form action="index.php?action=manageCave&set=<?= $value['id']; ?>" method="post">
          <div>
            <input type="text" name="name" id="name" value='<?= $value['name']; ?>'>
          </div>
          <div>
            <select name="year" id="year">
              <option value=<?= (int)$value['year']; ?>><?= (int)$value['year']; ?></option>
              <option value="1977">1977</option>
            </select>
          </div>
          <div>
            <label for="id_label_multiple">
              <select class="js-example-basic-multiple js-example-data-array js-states form-control" id="id_label_multiple" name="id_label_multiple[]" multiple="multiple">
              </select>
            </label>
          </div>
          <div>
            <input type="text" name="country" id="country" value="<?= $value['country']; ?>">
          </div>
          <div>
            <input type="text" name="region" id="region" value=<?= $value['region']; ?>>
          </div>
          <div>
            <textarea name="description" id="description"><?= $value['description']; ?></textarea>
          </div>
          <div>
            <input type="submit" name="btn-update-bottle" value="Envoyer">
          </div>
        </form>

    <?php
      }
    }
    ?>

  </tbody>
</table>




<?php $content = ob_get_clean();

require 'view/template.php';
