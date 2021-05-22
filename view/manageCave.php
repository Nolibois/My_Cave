<?php $titlePage = "Gestion de ma Cave";

$pathImg = "public/img/";

if (!isset($order)) {
  $order = "no";
}

ob_start();
?>

<h1>Bienvenue dans votre cave <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></h1>

<ul>
  <p>Dans cet espace vous pouvez: </p>

  <li>Filtrer les bouteilles</li>
  <li>Créer une nouvelle bouteille</li>
  <li>Modifier une existante</li>
  <li>Effacer</li>
</ul>

<h2>Sélectionnez par filtre</h2>

<form action="index.php?action=filters" method="post">
  <div>
    <label for="name ">Nom du cru</label>
    <input type="text" name="name" id="name">
  </div>
  <div>
    <label for="year ">Millésime</label>
    <select name="year" id="year">
      <option value=<?= $year ?>><?= $year ?></option>
    </select>
  </div>
  <div>
    <label for="id_label_multiple">
      <select class="js-example-basic-multiple js-example-data-array js-states form-control" id="id_label_multiple" name="id_label_multiple[]" multiple="multiple">
      </select>
    </label>
  </div>
  <div>
    <label for="country ">Pays</label>
    <input type="text" name="country" id="country">
  </div>
  <div>
    <label for="region ">Région</label>
    <input type="text" name="region" id="region">
  </div>
  <div>
    <input type="submit" name="btn-filters" value="Filtrer">
  </div>
</form>

<h2>Liste des bouteilles à MODIFIER</h2>

<table>
  <thead id="orderName">
    <tr>
      <th></th>
      <th>Nom du cru
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=name"><i class="fas fa-sort"></i></a>
        <!-- <a href="#" class="select-field"><i class="fas fa-sort"></i></a> -->
      </th>
      <th>Millésime
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=year"><i class="fas fa-sort"></i></a>
      </th>
      <th>Cépages
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=grapes"><i class="fas fa-sort"></i></a>
      </th>
      <th>Pays d'Origine
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=country"><i class="fas fa-sort"></i></a>
      </th>
      <th>Région
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=region"><i class="fas fa-sort"></i></a>
      </th>
      <th>Description</th>
      <th>Date de création
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=date_creation"><i class="fas fa-sort"></i></a>
      </th>
      <th>Dernière modification
        <a href="index.php?action=manageCave&order=<?= $order ?>&column=date_last_setting"><i class="fas fa-sort"></i></a>
      </th>
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

        <h3>Annulez la modification <a href="index.php?action=manageCave"><i class="far fa-times-circle"></i></a></h3>
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
