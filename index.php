<?php
session_start();
require 'controller/controller.php';

$msgError = [];

var_dump($msgError);

//////////////////// Check connection User //////////////////
if (isset($_POST['btn-connect'])) {
  if (!empty($_POST['email']) && !empty($_POST['pass'])) {

    // Check Email
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

      $result = connectUser($_POST['email']);
      $infosUser = $result->fetch(PDO::FETCH_ASSOC);

      // Check password
      if (password_verify($_POST['pass'], $infosUser['password'])) {

        $_SESSION['id'] = $infosUser['id'];
        $_SESSION['firstname'] = $infosUser['first_name'];
        $_SESSION['lastname'] = $infosUser['last_name'];
        $_SESSION['email'] = $infosUser['email'];
        $_SESSION['admin'] = $infosUser['admin'];

        $result->closeCursor();
      } else {
        array_push($msgError, 'Vos email ou mot de passe ne sont pas valide.');
      }
    } else {
      array_push($msgError, 'Votre email doit correspondre à l\'exemple suivant: chateau@pinot.com');
    }
  } else {
    array_push($msgError, 'Vous devez renseigner votre email et votre mot de passe pour vous connecter.');
  }
}


/////////////////////// ACTIONS ///////////////////////////////////
if (isset($_GET['action'])) {

  // Ask to go page Connection
  if ($_GET['action'] == 'formconnect') {
    formConnect();

    // Ask for Disconnection
  } elseif ($_GET['action'] == 'disconnect') {
    disconnectUser();

    // List bottles
  } elseif ($_GET['action'] == 'bottles') {
    listBottles($_GET['action']);

    // List and manage Bottles
  } elseif (($_GET['action'] == "manageCave") && $_SESSION['admin'] == 1) {

    if (isset($_GET['set'])) {

      // Display list bottles and form for settings
      if (is_numeric($_GET['set'])) {
        listBottles($_GET['action']);
      } else {
        array_push($msgError, 'L\'identifiant de la bouteille à modifier ne correspond pas.');

        msgerrors($msgError);
?>
        <a href="index.php?action=manageCave">Retour à Gestion de ma cave</a>
  <?php

      }

      // Display list bottles and manage links
    } else {
      listBottles($_GET['action']);
    }
  }
} elseif (!empty($msgError)) {

  msgerrors($msgError);

  ?>
  <a href="index.php?action=formconnect">Retour au formulaire de connexion</a>
<?php
} else {
  index();
}
