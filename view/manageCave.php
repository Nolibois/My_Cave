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
        <td><a href="index.php?action=manageCave&set=<?= $value['id']; ?>">Sélectionner</a></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>


////// Display form if bottle selected
<form action="" method="post">
  <div>
    <input type="text" name="name" id="name" value='<?= $value['name']; ?>'>
  </div>
  <div>
    <select name="year" id="year">
      <option value=""><?= $value['year']; ?></option>
      <option value="1977">1977</option>
    </select>
  </div>
  <div>
    <label for="id_label_multiple">
      <select class="js-example-basic-multiple js-example-data-array js-states form-control" id="id_label_multiple" multiple="multiple"></select>
    </label>
  </div>
  <div>
    <input type="text" name="country" id="country" value=<?= $value['country']; ?>>
  </div>
  <div>
    <input type="submit" value="Envoyer">
  </div>
</form>



<?php $content = ob_get_clean();

require 'view/template.php';
