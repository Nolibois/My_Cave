<?php $titlePage = "Gestion de ma Cave";

$pathImg = "public/uploads/";

if (!isset($order)) {
  $order = "no";
}

if (isset($_GET['id'])) {
}

ob_start();
?>

<main>

  <h1>Bienvenue dans votre cave <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></h1>

  <div id="background">

    <ul>
      <p>Dans cet espace vous pouvez: </p>

      <li>Ajouter une nouvelle bouteille</li>
      <li>Filtrer les bouteilles</li>
      <li>Sélectionner et modifier</li>
      <li>Effacer</li>
    </ul>


    <section id="create">

      <h2>Ajouter une bouteille</h2>
      <p class="infos-data">* Les photos doivent faire h:300px X L:250px au risque d'avoir des images diformes.</p>
      <form action="index.php?action=create" method="post" enctype="multipart/form-data">
        <label for="pictureCreate" class="picture-row">Photo *</label>
        <input type="file" name="picture" id="pictureCreate" class="picture-row">

        <label for="nameCreate" class="name-row">Nom du cru</label>
        <input type="text" name="name" id="nameCreate" class="name-row">

        <label for="yearCreate" class="year-row">Millésime</label>
        <select class="js-year-basic js-year-data-array js-states form-control year-row" id="yearCreate" name="year[]"></select>

        <label for="id_grapesCreate_multiple" class="grapes-row">Cépages</label>
        <select class="js-grapes-basic-multiple js-grapes-data-array js-states form-control grapes-row" id="id_grapesCreate_multiple" name="id_grapes_multiple[]" multiple="multiple">
        </select>

        <label for="countryCreate" class="country-row">Pays</label>
        <input type="text" name="country" id="countryCreate" class="country-row">

        <label for="regionCreate" class="region-row">Région</label>
        <input type="text" name="region" id="regionCreate" class="region-row">

        <label for="descriptionCreate" class="description-row">Description</label>
        <textarea class="description-row" name="description" id="descriptionCreate" cols="40" rows="10"></textarea>

        <input type="submit" name="btn-create" value="Ajouter">

      </form>

    </section>
  </div>

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
  <section id="update-bottles">
    <h2>Liste des bouteilles à MODIFIER</h2>
    <p id="messages"></p>

    <div id="orderBy">
      <fieldset>
        <legend>TRIE croissant / décroissant</legend>
        <div>
          <a href="index.php?action=manageCave&order=<?= $order ?>&column=name"><span>Nom du cru</span>
            <i class="fas fa-sort"></i></a>
        </div>
        <div>
          <a href="index.php?action=manageCave&order=<?= $order ?>&column=year"><span>Millésime</span>
            <i class="fas fa-sort"></i></a>
        </div>
        <div>
          <a href="index.php?action=manageCave&order=<?= $order ?>&column=grapes"><span>Cépages</span>
            <i class="fas fa-sort"></i></a>
        </div>
        <div>
          <a href="index.php?action=manageCave&order=<?= $order ?>&column=country"><span>d'Origine</span>
            <i class="fas fa-sort"></i></a>
        </div>
        <div>
          <a href="index.php?action=manageCave&order=<?= $order ?>&column=region"><span>Région</span>
            <i class="fas fa-sort"></i></a>
        </div>
        <div>
          <a href="index.php?action=manageCave&order=<?= $order ?>&column=date_creation"><span>Date de création</span>
            <i class="fas fa-sort"></i></a>
        </div>

      </fieldset>

    </div>

    <div class="card-container">


      <?php
      foreach ($listBottles as $key => $value) {
      ?>
        <div class="card-bottle">
          <div>
            <div id="#<?= $value['id'] ?>">
              <img src='<?= $pathImg; ?><?= $value['picture']; ?>' alt="Bouteille <?= $value['picture']; ?>">
            </div>
            <div class="name">
              <?= $value['name']; ?>
            </div>
            <div class="year">
              <?= $value['year']; ?>
            </div>
            <div>
              <?= $value['grapes']; ?>
            </div>
            <div>
              <?= $value['country']; ?>
            </div>
            <div>
              <?= $value['region']; ?>
            </div>
            <div class="description">"<?= $value['description']; ?>"</div>
            <div class="date">
              <span>Créée le: </span><?= $value['date_creation']; ?>
            </div>
            <div class="btn-select">
              <a href="index.php?action=manageCave&set=<?= $value['id']; ?>">Sélectionner</a>
            </div>

          </div>
        </div>

        <?php

        // "Modification" to append between lines of bottles
        if (isset($_GET['set']) && ($_GET['set'] == $value['id'])) {
        ?>

          <div id="form-update-container">
            <div>
              <h2>Modification <a href="index.php?action=manageCave"><i class="far fa-times-circle"></i></a></h2>

            </div>
            <form id="formUpdate" action="index.php?action=manageCave&set=<?= $value['id']; ?>&picture=<?= $value['picture']; ?>" method="post" enctype="multipart/form-data">
              <div>
                <label for="pictureUpdate">Photo</label>
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
                  <p>Êtes-vous bien certains de vouloir SUPPRIMER cette bouteille?</p>
                  <input type="submit" id="delete" name="btn-delete-bottle" value="SUPPRIMER">
                  <input type="submit" id="close" name="btn-close-bottle" value="NON">
                </div>
              </div>
            </form>
          </div>
      <?php
        }
      }
      ?>

    </div>
  </section>
</main>

<?php $content = ob_get_clean();

require 'view/template.php';
