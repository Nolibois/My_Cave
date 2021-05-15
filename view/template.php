<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $titlePage; ?></title>
  <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
  <?php require 'header.php'; ?>

  <?= $content; ?>

  <?php require 'footer.php'; ?>

</body>

</html>