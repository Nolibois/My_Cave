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

  <li>Ajouter une nouvelle bouteille</li>
  <li>Filtrer les bouteilles</li>
  <li>Sélectionner et modifier</li>
  <li>Effacer</li>
</ul>

<h2>Ajouter</h2>

<form action="index.php?action=create" method="post" enctype="multipart/form-data">
  <div>
    <label for="picture">Photo de la bouteille</label>
    <input type="file" name="picture" id="picture">
  </div>
  <div>
    <label for="nameCreate ">Nom du cru</label>
    <input type="text" name="name" id="nameCreate">
  </div>
  <div>
    <label for="yearCreate">Millésime</label>
    <select class="js-year-basic js-year-data-array js-states form-control" id="yearCreate" name="year[]"></select>
  </div>
  <div>
    <label for="id_grapesCreate_multiple">Cépages</label>
    <select class="js-grapes-basic-multiple js-grapes-data-array js-states form-control" id="id_grapesCreate_multiple" name="id_grapes_multiple[]" multiple="multiple">
    </select>
  </div>
  <div>
    <label for="countryCreate">Pays</label>
    <input type="text" name="country" id="countryCreate">
  </div>
  <div>
    <label for="regionCreate">Région</label>
    <input type="text" name="region" id="regionCreate">
  </div>
  <div>
    <textarea name="description" id="description"></textarea>
  </div>
  <div>
    <input type="submit" name="btn-create" value="Ajouter">
  </div>
</form>


<h2>Filtrer</h2>

<form action="index.php?action=filters" method="post">
  <div>
    <label for="nameFilter ">Nom du cru</label>
    <input type="text" name="nameFilter" id="nameFilter">
  </div>
  <div>
    <label for="yearFilter">Millésime</label>
    <select class="js-year-basic js-year-data-array js-states form-control" id="yearFilter" name="yearFilter[]"></select>
  </div>
  <div>
    <label for="id_grapes_multiple">Cépages</label>
    <select class="js-grapes-basic-multiple js-grapes-data-array js-states form-control" id="id_grapes_multiple" name="id_grapes_multiple[]" multiple="multiple">
    </select>
  </div>
  <div>
    <label for="countryFilter">Pays</label>
    <input type="text" name="countryFilter" id="countryFilter">
  </div>
  <div>
    <label for="regionFilter">Région</label>
    <input type="text" name="regionFilter" id="regionFilter">
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

      // "Modification" to append between lines of bottles
      if (isset($_GET['set']) && ($_GET['set'] == $value['id'])) {
      ?>
        <tr>
          <td colspan="5">
            <h2>Modification</h2>
          </td>
          <td colspan="5">
            <h3>ou Annuler <a href="index.php?action=manageCave"><i class="far fa-times-circle"></i></a></h3>
          </td>

        </tr>
        <form action="index.php?action=manageCave&set=<?= $value['id']; ?>" method="post">
          <tr>
            <td>
              <img src="" alt="Image à changer">
            </td>
            <td>
              <div>
                <input type="text" name="name" id="name" value='<?= $value['name']; ?>'>
              </div>
            </td>
            <td>
              <div>
                <select class="js-year-basic js-year-data-array js-states form-control" id="yearUpdate" name="yearUpdate[]">
                </select>
              </div>
            </td>
            <td>
              <div>
                <select class="js-grapes-basic-multiple js-grapes-data-array js-states form-control" id="id_grapesUpdate_multiple" name="id_grapesUpdate_multiple[]" multiple="multiple">
                </select>
              </div>
            </td>
            <td>
              <div>
                <input type="text" name="country" id="country" value="<?= $value['country']; ?>">
              </div>
            </td>
            <td>
              <div>
                <input type="text" name="region" id="region" value=<?= $value['region']; ?>>
              </div>
            </td>
            <td>
              <div>
                <textarea name="description" id="description"><?= $value['description']; ?></textarea>
              </div>
            </td>
            <td colspan="3">
              <div>
                <input type="submit" name="btn-update-bottle" value="Envoyer">
              </div>
            </td>
        </form>
        </tr>
    <?php
      }
    }
    ?>

  </tbody>
</table>


<?php $content = ob_get_clean();

require 'view/template.php';
