<?php $titlePage = "Gestion de ma Cave";

$pathImg = "public/uploads/";

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
    <label for="pictureCreate">Photo de la bouteille</label>
    <input type="file" name="picture" id="pictureCreate">
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
    <textarea name="description" id="descriptionCreate"></textarea>
  </div>
  <div>
    <input type="submit" name="btn-create" value="Ajouter">
  </div>
</form>


<!-- <h2>Filtrer</h2>

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
 -->

<h2>Liste des bouteilles à MODIFIER</h2>
<p id="messages"></p>

<div#orderBy>
  <div>Nom du cru
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=name"><i class="fas fa-sort"></i></a>
  </div>
  <div>Millésime
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=year"><i class="fas fa-sort"></i></a>
  </div>
  <div>Cépages
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=grapes"><i class="fas fa-sort"></i></a>
  </div>
  <div>Pays d'Origine
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=country"><i class="fas fa-sort"></i></a>
  </div>
  <div>Région
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=region"><i class="fas fa-sort"></i></a>
  </div>
  <div>Description</div>
  <div>Date de création
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=date_creation"><i class="fas fa-sort"></i></a>
  </div>
  <div>Dernière modification
    <a href="index.php?action=manageCave&order=<?= $order ?>&column=date_last_setting"><i class="fas fa-sort"></i></a>
  </div>
  </div>

  <div class="card-container">

    <?php
    foreach ($listBottles as $key => $value) {
    ?>
      <div class="card-bottle">
        <div><img src='<?= $pathImg; ?><?= $value['picture']; ?>' alt="Bouteille <?= $value['picture']; ?>"></div>
        <div><?= $value['name']; ?></div>
        <div><?= $value['year']; ?></div>
        <div><?= $value['grapes']; ?></div>
        <div><?= $value['country']; ?></div>
        <div><?= $value['region']; ?></div>
        <div><?= $value['description']; ?></div>
        <div><?= $value['date_creation']; ?></div>
        <div><?= $value['date_last_setting']; ?></div>
        <div><a href="index.php?action=manageCave&set=<?= $value['id']; ?>">Sélectionner</a></div>
      </div>

      <?php

      // "Modification" to append between lines of bottles
      if (isset($_GET['set']) && ($_GET['set'] == $value['id'])) {
      ?>
        <div>
          <h2>Modification</h2>
          <h3>ou Annuler la modification<a href="index.php?action=manageCave"><i class="far fa-times-circle"></i></a></h3>
        </div>
        <div id="form-update">
          <form id="formUpdate" action="index.php?action=manageCave&set=<?= $value['id']; ?>&picture=<?= $value['picture']; ?>" method="post" enctype="multipart/form-data">
            <div>
              <input type="file" name="picture" id="pictureUpdate">
            </div>
            <div>
              <input type="text" name="name" id="name" value='<?= $value['name']; ?>'>
            </div>
            <div>
              <select class="js-year-basic js-year-data-array js-states form-control" id="yearUpdate" name="yearUpdate[]">
              </select>
            </div>
            <div>
              <select class="js-grapes-basic-multiple js-grapes-data-array js-states form-control" id="id_grapesUpdate_multiple" name="id_grapesUpdate_multiple[]" multiple="multiple">
              </select>
            </div>
            <div>
              <input type="text" name="country" id="country" value="<?= $value['country']; ?>">
            </div>
            <div>
              <input type="text" name="region" id="region" value=<?= $value['region']; ?>>
            </div>
            <div>
              <textarea name="description" id="descriptionUpadte"><?= $value['description']; ?></textarea>
            </div>
            <div>
              <input type="submit" name="btn-update-bottle" value="MODIFIER">
            </div>
            <div>
              <button id="btn-del">SUPPRIMER</button>
            </div>
            <div id="myModal" class="modal">
              <div class="modal-content">
                <p>Êtes-vous bien certains de vouloir SUPPRIMER cette bouteill?</p>
                <div class="btn-modal-delete">
                  <input type="submit" id="delete" name="btn-delete-bottle" value="SUPPRIMER">
                  <input type="submit" id="close" name="btn-close-bottle" value="NON">
                </div>
              </div>
            </div>
          </form>
        </div>
    <?php
      }
    }
    ?>

  </div>


  <?php $content = ob_get_clean();

  require 'view/template.php';
